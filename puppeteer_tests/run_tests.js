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

    const clearSession = async () => {
        const client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');
    };

    const capture = async (name) => {
        await page.screenshot({ path: path.join(SHOTS_DIR, name + '.png') });
    }

    try {
        console.log("CP-ADM-001");
        await clearSession();
        await page.goto(`${BASE_URL}/login`);
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('button[type="submit"]')
        ]);
        await capture('CP-ADM-001');

        console.log("CP-ADM-002");
        await clearSession();
        await page.goto(`${BASE_URL}/login`);
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'wrongpassword');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('button[type="submit"]')
        ]);
        await capture('CP-ADM-002');

        console.log("CP-ADM-003");
        await clearSession();
        await page.goto(`${BASE_URL}/login`);
        await page.type('input[name="email"]', 'nonexistent@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('button[type="submit"]')
        ]);
        await capture('CP-ADM-003');

        console.log("CP-ADM-004");
        await clearSession();
        await page.goto(`${BASE_URL}/login`);
        await page.evaluate(() => {
            document.querySelector('input[name="email"]').removeAttribute('required');
            document.querySelector('input[name="password"]').removeAttribute('required');
        });
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => null),
            page.click('button[type="submit"]')
        ]);
        await new Promise(r => setTimeout(r, 500));
        await capture('CP-ADM-004');

        console.log("CP-ADM-005");
        await clearSession();
        await page.goto(`${BASE_URL}/login`);
        await page.evaluate(() => {
            document.querySelector('input[name="email"]').removeAttribute('required');
            document.querySelector('input[name="email"]').setAttribute('type', 'text');
        });
        await page.type('input[name="email"]', 'admin123');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => null),
            page.click('button[type="submit"]')
        ]);
        await new Promise(r => setTimeout(r, 500));
        await capture('CP-ADM-005');

        console.log("CP-ADM-006");
        await clearSession();
        await page.goto(`${BASE_URL}/login`);
        await page.evaluate(() => {
            document.querySelector('input[name="email"]').setAttribute('type', 'text');
        });
        await page.type('input[name="email"]', "' OR 1=1 --");
        await page.type('input[name="password"]', 'anypassword');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('button[type="submit"]')
        ]);
        await capture('CP-ADM-006');

        console.log("CP-ADM-007");
        await clearSession();
        await page.goto(`${BASE_URL}/admin/dashboard`);
        await capture('CP-ADM-007');

        console.log("CP-ADM-008");
        await clearSession();
        await page.goto(`${BASE_URL}/login`);
        await page.type('input[name="email"]', 'instructor1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('button[type="submit"]')
        ]);
        await page.goto(`${BASE_URL}/admin/users`);
        await new Promise(r => setTimeout(r, 1000));
        await capture('CP-ADM-008');

        console.log("Completado");
    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
    }
})();
