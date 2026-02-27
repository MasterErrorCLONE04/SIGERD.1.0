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
        await delay(500);
        await page.type('input[name="email"]', 'instructor1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1000);

        // CP-INS-022: Cambio dinámico de modo Claro/Oscuro
        console.log('Running CP-INS-022...');
        const darkToggle = await page.$('button[x-on\\:click="darkMode = !darkMode"]'); // Switcher ID/selectors could vary
        if (darkToggle) {
            await darkToggle.click();
            await delay(500);
            await page.screenshot({ path: 'pupperteer_test/CP-INS-022.png' });
            // revert back
            await darkToggle.click();
            await delay(500);
        } else {
            // Alternatively evaluate
            await page.evaluate(() => {
                Alpine.store('darkMode', true); // If alpine store is used
                // or just click the first button containing 'svg' for moon/sun
                const btns = document.querySelectorAll('button');
                for (let b of btns) {
                    if (b.innerHTML.includes('moon') || b.className.includes('dark')) { b.click(); break; }
                }
            });
            await delay(500);
            await page.screenshot({ path: 'pupperteer_test/CP-INS-022.png' });
        }

        // Create Incident exactly as CP-INS-009 to generate fresh notifications
        await page.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'networkidle0' });
        await delay(500);
        await page.type('input[name="title"]', 'Proyector con fallas');
        await page.type('textarea[name="description"]', 'El proyector no enciende.');
        await page.type('input[name="location"]', 'Aula 10');
        const fileInput = await page.$('#initial_evidence_images');
        await fileInput.uploadFile(path.resolve('pupperteer_test/files/valid.png'));
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1000);

        const editHref = await page.evaluate(() => {
            const row = Array.from(document.querySelectorAll('a')).find(a => a.href.includes('/edit') && a.href.includes('/instructor/incidents'));
            return row ? row.href : '';
        });
        const incidentIdStr = editHref ? editHref.split('/').slice(-2, -1)[0] : null;

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

        // Convert Incident to Task
        if (incidentIdStr) {
            await page.goto(BASE_URL + '/admin/incidents', { waitUntil: 'networkidle0' });
            await delay(1000);

            await page.evaluate((id) => {
                const forms = document.querySelectorAll('form');
                for (let form of forms) {
                    if (form.action.includes(`/admin/incidents/${id}/convert-to-task`)) {
                        form.querySelector('input[name="task_title"]').value = 'Revisar Proyector';
                        form.querySelector('textarea[name="task_description"]').value = 'Revisar foco';
                        // select worker
                        const select = form.querySelector('select[name="assigned_to"]');
                        if (select && select.options.length > 1) select.selectedIndex = 1;

                        const prio = form.querySelector('select[name="priority"]');
                        if (prio && prio.options.length > 1) prio.selectedIndex = 1;

                        const date = form.querySelector('input[name="deadline_at"]');
                        if (date) {
                            let d = new Date(); d.setDate(d.getDate() + 2);
                            date.value = d.toISOString().split('T')[0];
                        }

                        const loc = form.querySelector('input[name="location"]');
                        if (loc) loc.value = 'Aula 10';

                        form.submit();
                        break;
                    }
                }
            }, incidentIdStr);
            await delay(2000);

            // Fetch the task id
            await page.goto(BASE_URL + '/admin/tasks', { waitUntil: 'networkidle0' });
            await delay(1000);

            // Mark task as approved
            await page.evaluate((incTitle) => {
                // Find review form for task named Revisar Proyector
                const forms = document.querySelectorAll('form');
                for (let form of forms) {
                    if (form.action.includes(`/review`)) {
                        const select = form.querySelector('select[name="action"]');
                        if (select) select.value = 'approve';
                        form.submit();
                        break;
                    }
                }
            }, 'Revisar Proyector');
            await delay(2000);
        }

        // Step 3: Login Instructor again to see notifications
        client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');

        await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
        await delay(500);
        await page.evaluate(() => {
            const em = document.querySelector('input[name="email"]');
            if (em) em.value = '';
            const pw = document.querySelector('input[name="password"]');
            if (pw) pw.value = '';
        });
        await page.type('input[name="email"]', 'instructor1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1000);

        // CP-INS-019 & 020: Notifications present
        console.log('Running CP-INS-019 and 020...');
        // click notification bell (alpine dropdown)
        await page.evaluate(() => {
            const btns = document.querySelectorAll('button');
            for (let b of btns) {
                if (b.innerHTML.includes('bell') || b.querySelector('svg')) {
                    // It's usually a button near user menu
                    if (b.getAttribute('x-on:click') && b.getAttribute('x-on:click').includes('open')) {
                        b.click();
                    }
                }
            }
        });
        await delay(1000);

        // Let's just go to /notifications page directly because dropdown might be closed by some click.
        await page.goto(BASE_URL + '/notifications', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-019-020.png' });

        // CP-INS-021: Marcado automático / clic 
        console.log('Running CP-INS-021...');
        await page.evaluate(() => {
            const notifLinks = document.querySelectorAll('a[href*="/incidents"]');
            if (notifLinks.length > 0) {
                notifLinks[0].click(); // click first notification link
            }
        });
        await delay(2000);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-021.png' });

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error in tests:', e);
    } finally {
        await browser.close();
    }
})();
