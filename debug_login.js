import puppeteer from 'puppeteer';
import path from 'path';
import fs from 'fs';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

async function testLogin() {
    const browser = await puppeteer.launch({ headless: 'new', defaultViewport: { width: 1366, height: 768 } });
    const page = await browser.newPage();
    const dir = path.join(__dirname, 'capturas_manual_usuario_admin');

    try {
        await page.goto('http://127.0.0.1:8000/login', { waitUntil: 'networkidle0' });

        // Ensure input is empty
        await page.evaluate(() => document.querySelector('input[name="email"]').value = '');
        await page.evaluate(() => document.querySelector('input[name="password"]').value = '');

        await page.type('input[name="email"]', 'admin@example.com');
        await page.type('input[name="password"]', 'password');

        await page.screenshot({ path: path.join(dir, 'DEBUG_BEFORE_CLICK.png') });

        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('button[type="submit"]')
        ]);

        await new Promise(r => setTimeout(r, 1000));
        await page.screenshot({ path: path.join(dir, 'DEBUG_AFTER_CLICK.png') });
        console.log("Current URL after click:", page.url());

    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
    }
}
testLogin();
