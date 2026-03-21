import puppeteer from 'puppeteer';
import * as fs from 'fs';

(async () => {
    const browser = await puppeteer.launch({headless: "new"});
    const page = await browser.newPage();
    await page.goto('http://127.0.0.1:8000/login');
    await page.type('input[name="email"]', 'admin@sigerd.com');
    await page.type('input[name="password"]', 'password');
    await Promise.all([page.click('button[type="submit"]'), page.waitForNavigation()]);
    await page.goto('http://127.0.0.1:8000/admin/tasks/create');
    const html = await page.content();
    fs.writeFileSync('task_create_dump.html', html);
    await browser.close();
})();
