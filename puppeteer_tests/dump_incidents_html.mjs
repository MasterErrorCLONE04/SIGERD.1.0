import puppeteer from 'puppeteer';
import fs from 'fs';

(async () => {
    const browser = await puppeteer.launch({ headless: 'new', args: ['--no-sandbox'] });
    const page = await browser.newPage();
    try {
        await page.goto('http://127.0.0.1:8000/login');
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([page.click('button[type="submit"]'), page.waitForNavigation()]);
        await page.goto('http://127.0.0.1:8000/admin/incidents');
        const html = await page.content();
        fs.writeFileSync('puppeteer_tests/incidents_debug.html', html);
        console.log('HTML guardado en puppeteer_tests/incidents_debug.html');
    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
    }
})();
