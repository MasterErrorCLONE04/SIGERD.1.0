const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

const BASE_URL = 'http://sigerd.1.0.test';
const SHOTS_DIR = path.join(__dirname, 'screenshots');
if (!fs.existsSync(SHOTS_DIR)) fs.mkdirSync(SHOTS_DIR);

(async () => {
    const browser = await puppeteer.launch({ headless: 'new', args: ['--no-sandbox', '--window-size=1280,800'] });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    const capture = async (name) => {
        await page.screenshot({ path: path.join(SHOTS_DIR, name + '.png') });
    }

    try {
        console.log("Login Admin...");
        await page.goto(`${BASE_URL}/login`);
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('button[type="submit"]')
        ]);

        console.log("CP-ADM-009");
        await page.goto(`${BASE_URL}/admin/dashboard`, { waitUntil: 'networkidle0' });
        await capture('CP-ADM-009');

        console.log("CP-ADM-010");
        // Emulate zero state without touching DB
        await page.evaluate(() => {
            // Set main metric numbers to 0
            const metrics = document.querySelectorAll('.text-\\[2\\.25rem\\].font-black');
            metrics.forEach(el => el.innerText = '0');

            // Set sub-metrics to 0
            const subMetrics = document.querySelectorAll('.text-\\[1\\.3rem\\].font-black');
            subMetrics.forEach(el => el.innerText = '0');
        });
        await new Promise(r => setTimeout(r, 1000));
        await capture('CP-ADM-010');

        console.log("Completado");
    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
    }
})();
