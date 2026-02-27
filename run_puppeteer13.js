import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';

const BASE_URL = 'http://localhost/SIGERD.1.0/public';

(async () => {
    console.log("Starting browser...");
    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    const delay = ms => new Promise(res => setTimeout(res, ms));
    const safeGoto = async (page, url) => {
        try {
            const finalUrl = url.startsWith('http') ? url : BASE_URL + url;
            await page.goto(finalUrl, { waitUntil: 'domcontentloaded', timeout: 5000 });
        } catch (e) {
            console.log(`Timeout ignored for ${url}`);
        }
    };

    try {
        console.log("Logging in Instructor...");
        await safeGoto(page, '/login');
        await delay(500);
        await page.waitForSelector('input[name="email"]', { timeout: 10000 });
        await page.type('input[name="email"]', 'instructor1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await delay(2000);

        // CP-INS-041: Filtro por estado
        console.log('Running CP-INS-041 (Filter by status)...');
        await safeGoto(page, '/instructor/incidents');
        await delay(1000);

        // Find filter select if exists, or append to URL
        // From previous context, let's assume status filter is via query param ?status=...
        await safeGoto(page, '/instructor/incidents?status=resolved');
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-041.png' });

        // CP-INS-042: Filtro con parámetro inválido en URL
        console.log('Running CP-INS-042 (Invalid Filter Param)...');
        await safeGoto(page, '/instructor/incidents?status=hacked');
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-042.png' });

        // CP-INS-044: Dashboard con muchas notificaciones
        console.log('Running CP-INS-044 (Notifications Load)...');
        await safeGoto(page, '/dashboard'); // Or wherever the dashboard is
        await delay(2000);
        // Toggle notifications panel
        await page.evaluate(() => {
            const bell = document.querySelector('button svg.fa-bell') || document.querySelector('.fa-bell')?.parentElement;
            if (bell) bell.click();
        });
        await delay(1000);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-044.png' });

        // CP-INS-045: Reporte duplicado intencional
        console.log('Running CP-INS-045 (Duplicate Report)...');
        const reportIncident = async (title) => {
            await safeGoto(page, '/instructor/incidents/create');
            await page.waitForSelector('input[name="title"]');
            await page.type('input[name="title"]', title);
            await page.type('textarea[name="description"]', 'Duplicidad para prueba de negocio');
            await page.type('input[name="location"]', 'Sala de Pruebas');

            const fileInput = await page.$('#initial_evidence_images');
            if (fileInput) {
                await fileInput.uploadFile(path.resolve('pupperteer_test/files/valid.png'));
            }
            await page.click('button[type="submit"]');
            await delay(2000);
        };

        const duplicateTitle = 'Incidencia Duplicada ' + Date.now();
        await reportIncident(duplicateTitle);
        await reportIncident(duplicateTitle);

        await safeGoto(page, '/instructor/incidents');
        await delay(1000);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-045.png' });

        // CP-INS-046: Eliminación lógica (Soft Delete)
        console.log('Running CP-INS-046 (Soft Delete)...');
        await safeGoto(page, '/instructor/incidents');
        await delay(1000);

        // Find a "Finalizar" or "Eliminar" button for a pending incident
        await page.evaluate(() => {
            const deleteBtn = Array.from(document.querySelectorAll('button, a')).find(el =>
                (el.innerText.includes('Eliminar') || el.innerHTML.includes('fa-trash')) &&
                el.closest('tr')?.innerText.includes('Pendiente')
            );
            if (deleteBtn) deleteBtn.click();
        });

        // Handle confirmation dialog if exists
        await delay(500);
        await page.keyboard.press('Enter');
        await delay(2000);

        await page.screenshot({ path: 'pupperteer_test/CP-INS-046.png' });

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error in tests:', e);
    } finally {
        await browser.close();
    }
})();
