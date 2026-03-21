import puppeteer from 'puppeteer';
import * as fs from 'fs';
import * as path from 'path';

const baseUrl = 'http://127.0.0.1:8000';

(async () => {
    const browser = await puppeteer.launch({ headless: "new", args: ['--no-sandbox', '--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    try {
        await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2' });
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([ page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);

        await page.goto(`${baseUrl}/admin/users`, { waitUntil: 'networkidle2' });
        const html = await page.evaluate(() => document.body.innerHTML);
        fs.writeFileSync('C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\users_debug.html', html);
        console.log("Dumped HTML to users_debug.html");
    } finally {
        await browser.close();
    }
})();
