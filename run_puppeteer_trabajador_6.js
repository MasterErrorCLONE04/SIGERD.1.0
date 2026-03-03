import puppeteer from 'puppeteer';
import { execSync } from 'child_process';
import path from 'path';
import fs from 'fs';

const BASE_URL = 'http://localhost:8000';

const delay = ms => new Promise(res => setTimeout(res, ms));

async function login(page) {
    await page.goto(BASE_URL + '/login', { waitUntil: 'domcontentloaded' });
    const currentUrl = page.url();
    if (currentUrl.includes('/worker/dashboard') || currentUrl.includes('/worker/tasks')) {
        return; // Already logged in
    }
    await page.type('input[name="email"]', 'trabajador1@sigerd.com');
    await page.type('input[name="password"]', 'password');
    await Promise.all([
        page.click('button[type="submit"]'),
        page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
    ]);
}

(async () => {
    if (!fs.existsSync('puppeter_test_trabajador')) {
        fs.mkdirSync('puppeter_test_trabajador', { recursive: true });
    }

    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    try {
        console.log('--- FILE VALIDATION AND SECURITY ---');

        await login(page);
        await page.goto(BASE_URL + '/worker/tasks', { waitUntil: 'domcontentloaded' });
        await delay(500);

        // We will grab 3 tasks from the UI to serve for our 3 test cases
        const taskLinks = await page.$$eval('td a[href*="/worker/tasks/"]', links => links.map(a => a.href));
        if (taskLinks.length < 3) {
            throw new Error("Not enough tasks on the first page to run 3 distinct tests.");
        }
        const url33 = taskLinks[0];
        const url34 = taskLinks[1];
        const url35 = taskLinks[2];

        const id33 = url33.split('/').pop();
        const id34 = url34.split('/').pop();
        const id35 = url35.split('/').pop();
        execSync(`php artisan tinker --execute="\\App\\Models\\Task::whereIn('id', [${id33}, ${id34}, ${id35}])->update(['status' => 'en progreso']);"`);

        // ==========================================
        // CP-TRB-033: Exact 2MB valid file upload
        // ==========================================
        console.log('Running CP-TRB-033 (Exact 2MB Image)...');
        await page.goto(url33, { waitUntil: 'domcontentloaded' });
        await delay(500);
        let fileInput = await page.$('input[type="file"]');
        if (fileInput) {
            await fileInput.uploadFile(path.resolve('exact_2mb.jpg'));
            await page.type('textarea[name="final_description"]', 'Test upload 2MB image explicitly.');
            await Promise.all([
                page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
                page.evaluate(() => document.querySelector('form button[type="submit"]').click())
            ]);
            await delay(500);
        } else {
            console.log("Could not find file input for CP-TRB-033!");
        }
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-033.png' });


        // ==========================================
        // CP-TRB-034: Spoofed/Corrupted Image Upload (Mime Check)
        // ==========================================
        console.log('Running CP-TRB-034 (Spoofed Image MIME Test)...');
        // Ensure we are still logged in (in case previous test caused a logout via 419)
        await login(page);

        await page.goto(url34, { waitUntil: 'domcontentloaded' });
        await delay(500);

        const fileInput2 = await page.$('input[type="file"]');
        if (!fileInput2) {
            fs.writeFileSync('debug.html', await page.evaluate(() => document.documentElement.outerHTML));
            throw new Error("Missing file input on task34Url. Saved HTML to debug.html");
        }
        await fileInput2.uploadFile(path.resolve('spoofed.jpg'));
        await page.type('textarea[name="final_description"]', 'Test spoofed image.');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
            page.evaluate(() => document.querySelector('form button[type="submit"]').click())
        ]);
        await delay(500);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-034.png' });


        // ==========================================
        // CP-TRB-035: Path Traversal
        // ==========================================
        console.log('Running CP-TRB-035 (Path Traversal Filename)...');
        await login(page);

        await page.goto(url35, { waitUntil: 'domcontentloaded' });
        await delay(500);

        const csrfToken = await page.$eval('meta[name="csrf-token"]', el => el.content);
        const responseCode = await page.evaluate(async (url, csrf) => {
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('final_description', 'Testing Path Traversal in filename');

            const fakeBlob = new Blob(["Valid tiny picture spoofed content but named maliciously"], { type: 'image/jpeg' });
            formData.append('final_evidence_images[]', fakeBlob, '../../shell.php.jpg');

            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json, text/plain, */*'
                },
                body: formData
            });
            return res.status;
        }, url35, csrfToken);

        console.log('CP-TRB-035 traversal request status:', responseCode);
        await page.reload({ waitUntil: 'domcontentloaded' });
        await delay(500);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-035.png' });

        console.log('Done testing.');

    } catch (e) {
        console.error('Error:', e);
    } finally {
        await browser.close();
    }
})();
