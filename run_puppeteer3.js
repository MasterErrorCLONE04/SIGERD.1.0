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

        // Login first
        await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
        await delay(500);
        await page.type('input[name="email"]', 'instructor1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1000);

        // CP-INS-009: Reportar incidencia con todos los datos
        console.log('Running CP-INS-009...');
        await page.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.type('input[name="title"]', 'Aire acondicionado averiado');
        await page.type('textarea[name="description"]', 'El equipo no enfría en la sala 5.');
        await page.type('input[name="location"]', 'Sala 5');

        let fileInput = await page.$('#initial_evidence_images');
        await fileInput.uploadFile(path.resolve('pupperteer_test/files/valid.png'));

        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-009.png' });

        // CP-INS-010: Reporte sin evidencias fotográficas
        console.log('Running CP-INS-010...');
        await page.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.evaluate(() => {
            document.querySelector('#initial_evidence_images').removeAttribute('required');
        });
        await page.type('input[name="title"]', 'Servidor caído');
        await page.type('textarea[name="description"]', 'El servidor principal no responde.');
        await page.type('input[name="location"]', 'Site');

        await page.click('button[type="submit"]');
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-010.png' });

        // CP-INS-011: Reporte omitiendo campos obligatorios
        console.log('Running CP-INS-011...');
        await page.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.evaluate(() => {
            document.querySelector('input[name="title"]').removeAttribute('required');
        });
        await page.type('textarea[name="description"]', 'Descripción sin título.');
        fileInput = await page.$('#initial_evidence_images');
        await fileInput.uploadFile(path.resolve('pupperteer_test/files/valid.png'));
        await page.click('button[type="submit"]');
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-011.png' });

        // CP-INS-012: Subida excediendo límite de peso (>2MB)
        console.log('Running CP-INS-012...');
        await page.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.type('input[name="title"]', 'Imagen muy grande');
        await page.type('textarea[name="description"]', 'Probando límite de subida.');
        await page.type('input[name="location"]', 'Oficina A');
        fileInput = await page.$('#initial_evidence_images');
        await fileInput.uploadFile(path.resolve('pupperteer_test/files/large.png'));

        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-012.png' });

        // CP-INS-013: Múltiples fotos subidas simultáneamente
        console.log('Running CP-INS-013...');
        await page.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.type('input[name="title"]', 'Falla múltiple');
        await page.type('textarea[name="description"]', 'Adjuntando 10 imágenes.');
        await page.type('input[name="location"]', 'Pasillo');
        fileInput = await page.$('#initial_evidence_images');
        const filePaths = [];
        for (let i = 1; i <= 10; i++) filePaths.push(path.resolve(`pupperteer_test/files/valid${i}.png`));
        await fileInput.uploadFile(...filePaths);

        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-013.png' });

        // CP-INS-014: Intento de subir archivos maliciosos
        console.log('Running CP-INS-014...');
        await page.goto(BASE_URL + '/incidents/create', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.type('input[name="title"]', 'Archivo PHP');
        await page.type('textarea[name="description"]', 'Probando subida restringida.');
        await page.type('input[name="location"]', 'Oficina B');
        await page.evaluate(() => {
            document.querySelector('#initial_evidence_images').removeAttribute('accept');
        });
        fileInput = await page.$('#initial_evidence_images');
        await fileInput.uploadFile(path.resolve('pupperteer_test/files/malicious.php'));

        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-014.png' });

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error in tests:', e);
    } finally {
        await browser.close();
    }
})();
