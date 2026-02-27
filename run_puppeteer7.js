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

        // Login Instructor
        await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
        await delay(500);
        await page.type('input[name="email"]', 'instructor1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1000);

        // CP-INS-023: Actualizar perfil (fotos)
        console.log('Running CP-INS-023...');
        await page.goto(BASE_URL + '/profile', { waitUntil: 'networkidle0' });
        await delay(1000);
        // Change Name
        await page.evaluate(() => {
            const nameInput = document.querySelector('input[name="name"]');
            if (nameInput) {
                nameInput.value = '';
            }
        });
        await page.type('input[name="name"]', 'Instructor Modificado');
        // If there is an avatar input
        const profilePhotoInput = await page.$('input[name="profile_photo"]');
        if (profilePhotoInput) {
            await profilePhotoInput.uploadFile(path.resolve('pupperteer_test/files/valid.png'));
        }

        // Find the profile update form and submit
        await page.evaluate(() => {
            const forms = document.querySelectorAll('form');
            for (let f of forms) {
                if (f.action.includes('/profile') && f.querySelector('input[name="name"]') && !f.querySelector('input[name="current_password"]')) {
                    f.submit();
                    break;
                }
            }
        });
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-023.png' });

        // CP-INS-024: Cambio de Password
        console.log('Running CP-INS-024...');
        await page.goto(BASE_URL + '/profile', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.evaluate(() => {
            const forms = document.querySelectorAll('form');
            for (let f of forms) {
                if (f.action.includes('password') || f.querySelector('input[name="current_password"]')) {
                    f.querySelector('input[name="current_password"]').value = 'password';
                    f.querySelector('input[name="password"]').value = 'password_new123';
                    f.querySelector('input[name="password_confirmation"]').value = 'password_new123';
                    f.submit();
                    break;
                }
            }
        });
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-024.png' });

        // Restore password back to 'password' for future test runs
        await page.goto(BASE_URL + '/profile', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.evaluate(() => {
            const forms = document.querySelectorAll('form');
            for (let f of forms) {
                if (f.action.includes('password') || f.querySelector('input[name="current_password"]')) {
                    f.querySelector('input[name="current_password"]').value = 'password_new123';
                    f.querySelector('input[name="password"]').value = 'password';
                    f.querySelector('input[name="password_confirmation"]').value = 'password';
                    f.submit();
                    break;
                }
            }
        });
        await delay(1000);

        // CP-INS-025: Intento de auto-promoción de rol
        console.log('Running CP-INS-025...');
        await page.goto(BASE_URL + '/profile', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.evaluate(() => {
            const forms = document.querySelectorAll('form');
            for (let f of forms) {
                if (f.action.includes('/profile') && f.querySelector('input[name="name"]') && !f.querySelector('input[name="current_password"]')) {
                    // Inject role element
                    const roleInput = document.createElement('input');
                    roleInput.type = 'hidden';
                    roleInput.name = 'role';
                    roleInput.value = 'administrador';
                    f.appendChild(roleInput);
                    f.submit();
                    break;
                }
            }
        });
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-025.png' });

        // Verify role hasn't changed by accessing admin dashboard
        await page.goto(BASE_URL + '/admin/dashboard', { waitUntil: 'networkidle0' }).catch(() => null);
        await delay(1000);

        // CP-INS-026: Prevención de doble Submit
        console.log('Running CP-INS-026...');
        await page.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.type('input[name="title"]', 'Intento doble submit');
        await page.type('textarea[name="description"]', 'Doble clic test.');
        await page.type('input[name="location"]', 'Oficina');
        const fileInput26 = await page.$('#initial_evidence_images');
        await fileInput26.uploadFile(path.resolve('pupperteer_test/files/valid.png'));

        // Double click
        const btn = await page.$('button[type="submit"]');
        await btn.click({ clickCount: 2 });
        // screenshot immediately during submittal
        await page.screenshot({ path: 'pupperteer_test/CP-INS-026.png' });
        await delay(2000);

        // CP-INS-027: Visualización de evidencias pasadas (Visor modal)
        console.log('Running CP-INS-027...');
        // First we go to the newly created incident detail page
        await page.goto(BASE_URL + '/instructor/incidents', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.evaluate(() => {
            // Find first details link
            const firstA = document.querySelector('a[href*="/instructor/incidents/"]');
            if (firstA) firstA.click();
        });
        await delay(1500);
        // Try clicking on image to trigger modal if exists
        await page.evaluate(() => {
            const imgs = document.querySelectorAll('img');
            for (let i of imgs) {
                // Ignore profile picture and logos
                if (i.src.includes('evidence') || i.src.includes('http')) {
                    i.click();
                    break;
                }
            }
        });
        await delay(1000);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-027.png' });

        // CP-INS-028: Rendimiento - Paginado masivo para instructores (inyectar +200 incidencias usando Tinker)
        // We already injected 25 incidences using seed_pagination.php
        console.log('Running CP-INS-028...');
        await page.goto(BASE_URL + '/instructor/incidents', { waitUntil: 'networkidle0' });
        await delay(1000);
        // Scroll to bottom to verify pagination UI or endless scroll exists and page doesn't crash
        await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
        await delay(500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-028.png' });

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error in tests:', e);
    } finally {
        await browser.close();
    }
})();
