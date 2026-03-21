import puppeteer from 'puppeteer';
import * as fs from 'fs';

const baseUrl = 'http://127.0.0.1:8000';

async function login(page, email, password) {
    await page.goto(`${baseUrl}/login`, { waitUntil: 'load', timeout: 60000 });
    await page.waitForSelector('input[name="email"]');
    await page.type('input[name="email"]', email);
    await page.type('input[name="password"]', password);
    await Promise.all([ 
        page.click('button[type="submit"]'), 
        page.waitForNavigation({ waitUntil: 'load', timeout: 60000 }) 
    ]);
}

(async () => {
    const browser = await puppeteer.launch({ 
        headless: "new", 
        args: ['--no-sandbox', '--disable-setuid-sandbox'] 
    });

    try {
        const page = await browser.newPage();
        await login(page, 'admin@sigerd.com', 'password');
        await page.goto(`${baseUrl}/settings`, { waitUntil: 'networkidle2' });
        
        const html = await page.content();
        fs.writeFileSync('c:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\settings_dump.html', html);
        console.log("Dumped HTML settings route.");
        
        await page.screenshot({ path: 'c:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\screenshots\\dump_test_settings.png', fullPage: true });

    } finally {
        await browser.close();
    }
})();
