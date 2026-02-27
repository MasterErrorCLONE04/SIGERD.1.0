import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';

const BASE_URL = 'http://localhost:8000';

(async () => {
    console.log("Starting browser...");
    const browser = await puppeteer.launch({ headless: 'new' });
    const pageIns = await browser.newPage();
    await pageIns.setViewport({ width: 1280, height: 800 });
    const delay = ms => new Promise(res => setTimeout(res, ms));

    try {
        let client = await pageIns.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');

        console.log("Logging in Instructor...");
        await pageIns.goto(BASE_URL + '/login', { waitUntil: 'domcontentloaded' });
        await delay(500);
        await pageIns.type('input[name="email"]', 'instructor1@sigerd.com');
        await pageIns.type('input[name="password"]', 'password');
        await pageIns.click('button[type="submit"]');
        await delay(2000);

        // CP-INS-032: Concurrencia - Simular Instructor abriendo formulario en dos pestañas enviándolos juntos
        console.log('Running CP-INS-032 (Concurrencia Tabs)...');
        await pageIns.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'domcontentloaded' });
        await delay(1000);
        await pageIns.type('input[name="title"]', 'Tab 1 Incident');
        await pageIns.type('textarea[name="description"]', 'Desc 1');
        await pageIns.type('input[name="location"]', 'Lab 1');

        // Form submitted via script to simulate tab 2
        await pageIns.evaluate(async () => {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const data = new FormData();
            data.append('_token', token);
            data.append('title', 'Tab 2 Incident');
            data.append('description', 'Desc 2');
            data.append('location', 'Lab 2');
            // Fake empty file
            const blob = new Blob(['phony image'], { type: 'image/png' });
            data.append('initial_evidence_images[]', blob, 'fake.png');

            fetch('/instructor/incidents', { method: 'POST', body: data }).catch(e => console.log(e));
        });
        await delay(500); // Small interval between fetches

        const fi1 = await pageIns.$('#initial_evidence_images');
        await fi1.uploadFile(path.resolve('pupperteer_test/files/valid.png'));
        await pageIns.click('button[type="submit"]');
        await delay(2000);

        await pageIns.goto(BASE_URL + '/instructor/incidents', { waitUntil: 'domcontentloaded' });
        await Math.random() // break Vite hang
        await delay(1000);
        await pageIns.screenshot({ path: 'pupperteer_test/CP-INS-032.png' });

        // CP-INS-033: Edición simultánea por doble sesión
        console.log('Running CP-INS-033 (Simultaneous Edit)...');
        await pageIns.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'domcontentloaded' });
        await delay(1000);
        await pageIns.type('input[name="title"]', 'Simultaneous Edit Base');
        await pageIns.type('textarea[name="description"]', 'Base desc');
        await pageIns.type('input[name="location"]', 'Base loc');
        const fi3 = await pageIns.$('#initial_evidence_images');
        await fi3.uploadFile(path.resolve('pupperteer_test/files/valid.png'));

        await pageIns.click('button[type="submit"]');
        await delay(2000);

        const simEditUrl = await pageIns.evaluate(() => {
            const row = Array.from(document.querySelectorAll('a')).find(a => a.href.includes('/edit') && a.href.includes('/instructor/incidents'));
            return row ? row.href : '';
        });

        if (simEditUrl) {
            await pageIns.goto(simEditUrl, { waitUntil: 'domcontentloaded' });
            await delay(1000);

            // Simulate User 2 submitting first via POST fetch ignoring UI
            await pageIns.evaluate(async (url) => {
                const formUrl = url.replace('/edit', ''); // POST/PUT url
                const token = document.querySelector('meta[name="csrf-token"]').content;
                const data = new FormData();
                data.append('_method', 'PUT');
                data.append('_token', token);
                data.append('title', 'Simultaneous Edit - User 2');
                data.append('description', 'User 2 desc');
                data.append('location', 'User 2 loc');
                // Laravel handles PUT with forms, so fetch should be ok
                fetch(formUrl, { method: 'POST', body: data });
            }, simEditUrl);
            await delay(1000);

            // Now regular UI User 1 submits
            await pageIns.evaluate(() => { let input = document.querySelector('input[name="title"]'); if (input) { input.value = ''; } });
            await pageIns.type('input[name="title"]', 'Simultaneous Edit - User 1');
            await pageIns.click('button[type="submit"]');
            await delay(2000);

            await pageIns.goto(BASE_URL + '/instructor/incidents', { waitUntil: 'domcontentloaded' });
            await delay(1000);
            await pageIns.screenshot({ path: 'pupperteer_test/CP-INS-033.png' });
        }

        // CP-INS-034/030: Integridad y Borrado
        console.log('Running CP-INS-034 and CP-INS-030...');
        await pageIns.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'domcontentloaded' });
        await delay(1000);
        await pageIns.type('input[name="title"]', 'Incident Escalated Under Me');
        await pageIns.type('textarea[name="description"]', 'Desc');
        await pageIns.type('input[name="location"]', 'Loc');
        const fi4 = await pageIns.$('#initial_evidence_images');
        await fi4.uploadFile(path.resolve('pupperteer_test/files/valid.png'));

        await pageIns.click('button[type="submit"]');
        await delay(2000);

        const escEditUrl = await pageIns.evaluate(() => {
            const row = Array.from(document.querySelectorAll('a')).find(a => a.href.includes('/edit') && a.href.includes('/instructor/incidents'));
            return row ? row.href : '';
        });
        const escId = escEditUrl ? escEditUrl.split('/').slice(-2, -1)[0] : null;

        if (escId) {
            // First open edit page for Instructor
            await pageIns.goto(escEditUrl, { waitUntil: 'domcontentloaded' });
            await delay(1000);

            // To simulate admin escalation without blocking php artisan serve:
            // Let's create an incognito browser, login admin, escalate, close it.
            console.log('Admin escalating...');
            const browser2 = await puppeteer.launch({ headless: 'new' });
            const pageAdmin = await browser2.newPage();

            await pageAdmin.goto(BASE_URL + '/login', { waitUntil: 'domcontentloaded' });
            await delay(1000);
            await pageAdmin.type('input[name="email"]', 'admin@sigerd.com');
            await pageAdmin.type('input[name="password"]', 'password');
            await pageAdmin.click('button[type="submit"]');
            await delay(2000);

            await pageAdmin.goto(BASE_URL + '/admin/incidents', { waitUntil: 'domcontentloaded' });
            await delay(1500);
            await pageAdmin.evaluate((id) => {
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
            await delay(2000);
            await browser2.close();
            console.log('Admin browser closed.');

            console.log('Submitting outdated pageIns...');
            await pageIns.click('button[type="submit"]');
            await delay(2000);
            await pageIns.screenshot({ path: 'pupperteer_test/CP-INS-034.png' });

            await pageIns.goto(BASE_URL + '/instructor/incidents', { waitUntil: 'domcontentloaded' });
            await delay(1000);

            await pageIns.evaluate(async (id) => {
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
            await pageIns.screenshot({ path: 'pupperteer_test/CP-INS-030.png' });
        }

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error in tests:', e);
    } finally {
        await browser.close();
    }
})();
