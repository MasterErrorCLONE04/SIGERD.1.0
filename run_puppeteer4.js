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

        // CP-INS-014: Intento de subir archivos maliciosos
        console.log('Running CP-INS-014...');
        await page.goto(BASE_URL + '/instructor/incidents/create', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.type('input[name="title"]', 'Archivo PHP');
        await page.type('textarea[name="description"]', 'Probando subida restringida.');
        await page.type('input[name="location"]', 'Oficina B');
        await page.evaluate(() => {
            const el = document.querySelector('#initial_evidence_images');
            if (el) el.removeAttribute('accept');
        });
        const fileInput14 = await page.$('#initial_evidence_images');
        await fileInput14.uploadFile(path.resolve('pupperteer_test/files/malicious.php'));

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
