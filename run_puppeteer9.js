import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';

const BASE_URL = 'http://localhost:8000';

(async () => {
    console.log("Starting browser...");
    const browser = await puppeteer.launch({ headless: 'new' });
    const pageIns1 = await browser.newPage();
    const pageIns2 = await browser.newPage();
    await pageIns1.setViewport({ width: 1280, height: 800 });
    await pageIns2.setViewport({ width: 1280, height: 800 });

    const delay = ms => new Promise(res => setTimeout(res, ms));

    try {
        console.log("Logging in pageIns1 (Instructor)...");
        await pageIns1.goto(BASE_URL + '/login', { waitUntil: 'domcontentloaded' });
        await delay(500);
        await pageIns1.type('input[name="email"]', 'instructor1@sigerd.com');
        await pageIns1.type('input[name="password"]', 'password');
        await pageIns1.click('button[type="submit"]');
        await delay(2000);

        console.log("Verifying login on pageIns2...");
        await pageIns2.goto(BASE_URL + '/instructor/dashboard', { waitUntil: 'domcontentloaded' });
        await delay(1000);
        if ((await pageIns2.url()).includes('login')) {
            console.log("pageIns2 is NOT logged in. Logging in explicitly...");
            await pageIns2.type('input[name="email"]', 'instructor1@sigerd.com');
            await pageIns2.type('input[name="password"]', 'password');
            await pageIns2.click('button[type="submit"]');
            await delay(2000);
        }

        // CP-INS-032: Concurrencia - Instructor abre formulario en dos pestañas
        console.log('Running CP-INS-032 (Concurrencia Tabs)...');
        await pageIns1.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'domcontentloaded' });
        await pageIns2.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'domcontentloaded' });
        await delay(2000);

        try {
            await pageIns1.waitForSelector('input[name="title"]', { timeout: 3000 });
        } catch (e) {
            console.error('pageIns1 failed to load form. Taking error screenshot...');
            await pageIns1.screenshot({ path: 'pupperteer_test/error_032_page1.png' });
            throw e;
        }

        await pageIns1.type('input[name="title"]', 'Tab 1 Incident');
        await pageIns1.type('textarea[name="description"]', 'Desc 1');
        await pageIns1.type('input[name="location"]', 'Lab 1');
        const fi1 = await pageIns1.$('#initial_evidence_images');
        await fi1.uploadFile(path.resolve('pupperteer_test/files/valid.png'));

        await pageIns2.type('input[name="title"]', 'Tab 2 Incident');
        await pageIns2.type('textarea[name="description"]', 'Desc 2');
        await pageIns2.type('input[name="location"]', 'Lab 2');
        const fi2 = await pageIns2.$('#initial_evidence_images');
        await fi2.uploadFile(path.resolve('pupperteer_test/files/valid.png'));

        await pageIns1.click('button[type="submit"]');
        await delay(200);
        await pageIns2.click('button[type="submit"]');
        await delay(3000);

        await pageIns1.goto(BASE_URL + '/instructor/incidents', { waitUntil: 'domcontentloaded' });
        await delay(1000);
        await pageIns1.screenshot({ path: 'pupperteer_test/CP-INS-032.png' });

        // CP-INS-033: Edición simultánea por doble sesión
        console.log('Running CP-INS-033 (Simultaneous Edit)...');
        await pageIns1.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'domcontentloaded' });
        await delay(1000);
        await pageIns1.type('input[name="title"]', 'Simultaneous Edit Base');
        await pageIns1.type('textarea[name="description"]', 'Base desc');
        await pageIns1.type('input[name="location"]', 'Base loc');
        const fi3 = await pageIns1.$('#initial_evidence_images');
        await fi3.uploadFile(path.resolve('pupperteer_test/files/valid.png'));

        await pageIns1.click('button[type="submit"]');
        await delay(2000);

        const simEditUrl = await pageIns1.evaluate(() => {
            const row = Array.from(document.querySelectorAll('a')).find(a => a.href.includes('/edit') && a.href.includes('/instructor/incidents'));
            return row ? row.href : '';
        });

        if (simEditUrl) {
            await pageIns1.goto(simEditUrl, { waitUntil: 'domcontentloaded' });
            await pageIns2.goto(simEditUrl, { waitUntil: 'domcontentloaded' });
            await delay(1500);

            await pageIns1.evaluate(() => { let input = document.querySelector('input[name="title"]'); if (input) { input.value = ''; } });
            await pageIns1.type('input[name="title"]', 'Simultaneous Edit - User 1');

            await pageIns2.evaluate(() => { let input = document.querySelector('input[name="title"]'); if (input) { input.value = ''; } });
            await pageIns2.type('input[name="title"]', 'Simultaneous Edit - User 2');

            // submit both
            await pageIns1.click('button[type="submit"]');
            await delay(500);
            await pageIns2.click('button[type="submit"]');
            await delay(2000);

            await pageIns1.goto(BASE_URL + '/instructor/incidents', { waitUntil: 'domcontentloaded' });
            await delay(1000);
            await pageIns1.screenshot({ path: 'pupperteer_test/CP-INS-033.png' });
        }

        // CP-INS-034/030: Integridad y Borrado
        console.log('Running CP-INS-034 and CP-INS-030...');
        await pageIns1.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'domcontentloaded' });
        await delay(1000);
        await pageIns1.type('input[name="title"]', 'Incident Escalated Under Me');
        await pageIns1.type('textarea[name="description"]', 'Desc');
        await pageIns1.type('input[name="location"]', 'Loc');
        const fi4 = await pageIns1.$('#initial_evidence_images');
        await fi4.uploadFile(path.resolve('pupperteer_test/files/valid.png'));

        await pageIns1.click('button[type="submit"]');
        await delay(2000);

        const escEditUrl = await pageIns1.evaluate(() => {
            const row = Array.from(document.querySelectorAll('a')).find(a => a.href.includes('/edit') && a.href.includes('/instructor/incidents'));
            return row ? row.href : '';
        });
        const escId = escEditUrl ? escEditUrl.split('/').slice(-2, -1)[0] : null;

        if (escId) {
            await pageIns1.goto(escEditUrl, { waitUntil: 'domcontentloaded' });
            await delay(1000);
            console.log('Admin escalating...');

            const client = await pageIns2.target().createCDPSession();
            await client.send('Network.clearBrowserCookies');

            await pageIns2.goto(BASE_URL + '/login', { waitUntil: 'domcontentloaded' });
            await delay(1000);
            await pageIns2.type('input[name="email"]', 'admin@sigerd.com');
            await pageIns2.type('input[name="password"]', 'password');
            await pageIns2.click('button[type="submit"]');
            await delay(2000);

            await pageIns2.goto(BASE_URL + '/admin/incidents', { waitUntil: 'domcontentloaded' });
            await delay(2000);

            // Fill and submit the specific convert-to-task form
            await pageIns2.evaluate((id) => {
                const forms = document.querySelectorAll('form');
                for (let form of forms) {
                    if (form.action.includes(`/admin/incidents/${id}/convert-to-task`)) {
                        let i1 = form.querySelector('input[name="task_title"]'); if (i1) i1.value = 'Task Escalated';
                        let i2 = form.querySelector('textarea[name="task_description"]'); if (i2) i2.value = 'D';
                        let s1 = form.querySelector('select[name="assigned_to"]'); if (s1) s1.selectedIndex = 1;
                        let s2 = form.querySelector('select[name="priority"]'); if (s2) s2.selectedIndex = 1;
                        let dt = form.querySelector('input[name="deadline_at"]');
                        if (dt) {
                            let d = new Date(); d.setDate(d.getDate() + 2);
                            dt.value = d.toISOString().split('T')[0];
                        }
                        let loc = form.querySelector('input[name="location"]'); if (loc) loc.value = 'L';
                        form.submit();
                        break;
                    }
                }
            }, escId);
            await delay(2500);

            console.log('Submitting outdated pageIns1...');
            await pageIns1.click('button[type="submit"]');
            await delay(2000);
            await pageIns1.screenshot({ path: 'pupperteer_test/CP-INS-034.png' });

            await pageIns1.goto(BASE_URL + '/instructor/incidents', { waitUntil: 'domcontentloaded' });
            await delay(1000);

            await pageIns1.evaluate(async (id) => {
                const forms = document.querySelectorAll('form');
                for (let f of forms) {
                    if (f.action.includes(`/instructor/incidents/${id}`) && f.querySelector('input[value="DELETE"]')) {
                        f.style.display = 'block';
                        f.submit();
                        break;
                    }
                }
            }, escId);
            await delay(2000);
            await pageIns1.screenshot({ path: 'pupperteer_test/CP-INS-030.png' });
        }

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error in tests:', e);
    } finally {
        await browser.close();
    }
})();
