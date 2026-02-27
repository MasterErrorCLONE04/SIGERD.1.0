import puppeteer from 'puppeteer';
import fs from 'fs';

const BASE_URL = 'http://localhost:8000';

(async () => {
    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });
    const delay = ms => new Promise(res => setTimeout(res, ms));

    try {
        let client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');

        // CP-INS-007: Carga correcta de métricas del dashboard
        console.log('Running CP-INS-007...');
        await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
        await delay(500);
        await page.type('input[name="email"]', 'instructor1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-007.png' });

        // Clear session / log out
        client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');

        // CP-INS-008: Dashboard con métricas en cero
        console.log('Running CP-INS-008...');
        await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
        await delay(500);
        await page.evaluate(() => {
            document.querySelector('input[name="email"]').value = '';
            document.querySelector('input[name="password"]').value = '';
        });
        await page.type('input[name="email"]', 'instructor_empty@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-008.png' });

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error in tests:', e);
    } finally {
        await browser.close();
    }
})();
