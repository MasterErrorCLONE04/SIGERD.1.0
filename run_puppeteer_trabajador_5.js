import puppeteer from 'puppeteer';
import { execSync } from 'child_process';
import path from 'path';
import fs from 'fs';

const BASE_URL = 'http://localhost:8000';

const delay = ms => new Promise(res => setTimeout(res, ms));

(async () => {
    if (!fs.existsSync('puppeter_test_trabajador')) {
        fs.mkdirSync('puppeter_test_trabajador', { recursive: true });
    }

    // Seed test image
    if (!fs.existsSync('test_image.jpg')) {
        execSync('fsutil file createnew test_image.jpg 10240'); // Creates a 10KB dummy file in Windows
    }

    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    try {
        console.log('Logging in...');
        await page.goto(BASE_URL + '/login', { waitUntil: 'domcontentloaded' });
        await page.type('input[name="email"]', 'trabajador1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
        ]);

        console.log('--- UI & PERFORMANCE ---');

        // CP-TRB-028: Pagination
        console.log('Running CP-TRB-028 (Pagination)...');
        await page.goto(BASE_URL + '/worker/tasks', { waitUntil: 'domcontentloaded' });
        await delay(1000); // Give time for UI and transitions
        // Scroll to bottom to show pagination
        await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
        await delay(500);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-028.png' });

        // CP-TRB-027: UI Lightbox
        console.log('Running CP-TRB-027 (Lightbox UI)...');
        // Task 20 is already completed and has images.
        await page.goto(BASE_URL + '/worker/tasks/20', { waitUntil: 'domcontentloaded' });
        await delay(500);

        const hasImages = await page.evaluate(() => {
            const img = document.querySelector('.group\\/item');
            if (img) {
                img.click();
                return true;
            }
            return false;
        });

        if (hasImages) {
            await delay(1000); // Give time for the modal transition
            await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-027.png' });
            await page.keyboard.press('Escape');
            await delay(500);
        } else {
            console.log('Warning: No images found on task 20 to test lightbox.');
        }


        // CP-TRB-029: Double Submit Prevention
        console.log('Running CP-TRB-029 (Double Submit)...');
        // Let's go to one of the seeded tasks which is 'asignado'
        await page.goto(BASE_URL + '/worker/tasks', { waitUntil: 'domcontentloaded' });
        await delay(500);
        // Find the first task link
        const firstTaskLink = await page.$eval('td a[href*="/worker/tasks/"]', el => el.href);
        await page.goto(firstTaskLink, { waitUntil: 'domcontentloaded' });
        await delay(500);

        const taskId = firstTaskLink.split('/').pop();

        // Let's select a file but intercept requests so we can capture the UI state
        await page.setRequestInterception(true);
        // Delay the POST request by 3 seconds artificially
        page.on('request', async req => {
            if (req.method() === 'POST' && req.url().includes(taskId)) {
                setTimeout(() => req.continue(), 3000);
            } else {
                req.continue();
            }
        });

        // Try to submit initial evidence
        const fileInput = await page.$('input[type="file"]');
        if (fileInput) {
            await fileInput.uploadFile(path.resolve('test_image.jpg'));
            const btn = await page.$('form button[type="submit"]');
            await btn.click();
            await delay(500); // Let UI update the alpine state
            await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-029.png' });

            // Wait for it to finish and go 'en progreso'
            await page.setRequestInterception(false);
            try {
                await page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 5000 });
            } catch (e) { }
        }


        console.log('--- INTEGRITY & TRANSITIONS ---');

        // Capture cookies for Fetch payload
        const cookies = await page.cookies();
        const cookieStr = cookies.map(c => `${c.name}=${c.value}`).join(';');
        const csrfToken = await page.$eval('meta[name="csrf-token"]', el => el.content);

        // CP-TRB-030: Restart already active task
        console.log('Running CP-TRB-030 (Idempotent start)...');
        // The task is now "en progreso". Send another "start" request.
        let response = await page.evaluate(async (url, csrf) => {
            const formData = new FormData();
            formData.append('_method', 'PUT');
            // Sending an empty image load to simulate hitting submit again

            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json, text/plain, */*'
                },
                body: formData
            });
            return res.status;
        }, BASE_URL + '/worker/tasks/' + taskId, csrfToken);
        console.log('CP-TRB-030 server response:', response); // Should be a valid response, no crash (idempotent)
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-030.png' });


        // CP-TRB-031: Negative force invalid transition
        console.log('Running CP-TRB-031 (Force finalizada)...');
        // The task is en progreso. Let's try to set status=finalizada
        response = await page.evaluate(async (url, csrf) => {
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('status', 'finalizada');

            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json, text/plain, */*'
                },
                body: formData
            });
            return res.status;
        }, BASE_URL + '/worker/tasks/' + taskId, csrfToken);
        console.log('CP-TRB-031 injected PUT request status:', response);
        // Refresh and check status in DOM
        await page.reload({ waitUntil: 'domcontentloaded' });
        await delay(500);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-031.png' });


        // CP-TRB-032: Security Modifying worker_id
        console.log('Running CP-TRB-032 (Modify worker_id)...');
        response = await page.evaluate(async (url, csrf) => {
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('assigned_to', '999'); // Attempt to reassign to non-existent or other user
            formData.append('worker_id', '999');

            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json, text/plain, */*'
                },
                body: formData
            });
            return res.status;
        }, BASE_URL + '/worker/tasks/' + taskId, csrfToken);
        console.log('CP-TRB-032 injected assign request status:', response);
        // Refresh
        await page.reload({ waitUntil: 'domcontentloaded' });
        await delay(500);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-032.png' });


        console.log('Done testing.');

    } catch (e) {
        console.error('Error:', e);
    } finally {
        await browser.close();
    }
})();
