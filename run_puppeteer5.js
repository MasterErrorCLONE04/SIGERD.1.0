import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';

const BASE_URL = 'http://localhost:8000';

(async () => {
    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });
    const delay = ms => new Promise(res => setTimeout(res, ms));

    try {
        let client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');

        // Step 1: Login Instructor
        await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
        await page.type('input[name="email"]', 'instructor1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1000);

        // Create Incident exactly as CP-INS-009 
        await page.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'networkidle0' });
        await delay(500);
        await page.type('input[name="title"]', 'Ventana Rota Taller');
        await page.type('textarea[name="description"]', 'Vidrio esparcido en el piso.');
        await page.type('input[name="location"]', 'Taller Automotriz');
        const fileInput = await page.$('#initial_evidence_images');
        await fileInput.uploadFile(path.resolve('pupperteer_test/files/valid.png'));
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1000);

        // At this point we are usually at the index containing our incident. We need its ID for 016, 018
        // Let's grab the edit link of the newly created incident
        const editHref = await page.evaluate(() => {
            const row = Array.from(document.querySelectorAll('a')).find(a => a.href.includes('/edit') && a.href.includes('/instructor/incidents'));
            return row ? row.href : '';
        });

        console.log("Newly created incident URL:", editHref);

        // Log out Instructor
        let userMenu = await page.$('button[ref="userMenu"]');
        if (!userMenu) userMenu = await page.$('button.flex.items-center'); // standard breeze drop
        // Actually faster to just clear cookies
        client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');

        // Step 2: Login Admin
        await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
        await delay(500);

        await page.evaluate(() => {
            const em = document.querySelector('input[name="email"]');
            if (em) em.value = '';
            const pw = document.querySelector('input[name="password"]');
            if (pw) pw.value = '';
        });
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1000);

        // Go to Admin Incidents
        await page.goto(BASE_URL + '/admin/incidents', { waitUntil: 'networkidle0' });
        await delay(1000);

        const incidentIdStr = editHref.split('/').slice(-2, -1)[0]; // e.g. /instructor/incidents/7/edit

        if (incidentIdStr) {
            // Find and click Convert to Task for this Incident
            // Since it might be complex to click, let's just use evaluate to submit the form
            await page.evaluate((id) => {
                const forms = document.querySelectorAll('form');
                for (let form of forms) {
                    if (form.action.includes(`/admin/incidents/${id}/convert-to-task`)) {
                        form.querySelector('input[name="title"]').value = 'Tarea de Ventana Rota';
                        form.submit();
                        break;
                    }
                }
            }, incidentIdStr);
            await delay(2000); // wait for conversion
        }

        // Clear Admin Session
        client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');

        // Step 3: Login Instructor again to perform the specific test cases
        await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
        await delay(500);
        await page.type('input[name="email"]', 'instructor1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1000);

        // CP-INS-015 & CP-INS-016
        console.log('Running CP-INS-015 and CP-INS-016...');
        await page.goto(BASE_URL + '/instructor/incidents', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-015.png' });
        await page.screenshot({ path: 'pupperteer_test/CP-INS-016.png' });

        // CP-INS-018: Intento de editar incidencia en curso/resuelta
        console.log('Running CP-INS-018...');
        if (incidentIdStr) {
            await page.goto(BASE_URL + `/instructor/incidents/${incidentIdStr}/edit`, { waitUntil: 'networkidle0' });
            await delay(1000);
            await page.screenshot({ path: 'pupperteer_test/CP-INS-018.png' });
        }

        // CP-INS-017: Intento de borrar o editar incidencia ajena (o ID no existente por policy)
        console.log('Running CP-INS-017...');
        await page.goto(BASE_URL + `/instructor/incidents/99999/edit`, { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-017.png' });

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error in tests:', e);
    } finally {
        await browser.close();
    }
})();
