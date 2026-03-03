import puppeteer from 'puppeteer';
import fs from 'fs';

const BASE_URL = 'http://localhost:8000';

(async () => {
    if (!fs.existsSync('puppeter_test_trabajador')) {
        fs.mkdirSync('puppeter_test_trabajador', { recursive: true });
    }

    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    const delay = ms => new Promise(res => setTimeout(res, ms));

    try {
        let client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');

        // CP-TRB-001: Login as trabajador
        console.log('Running CP-TRB-001...');
        await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
        await delay(500);
        await page.type('input[name="email"]', 'trabajador1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-001.png' });

        // CP-TRB-005: Intento de acceso a panel de administrador
        // Evaluamos este directamente ya que estamos logueados
        console.log('Running CP-TRB-005...');
        await page.goto(BASE_URL + '/admin/users', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-005.png' });

        // Clear session / log out for next tests
        client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');

        // CP-TRB-002: Login with incorrect password
        console.log('Running CP-TRB-002...');
        await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
        await delay(500);
        await page.type('input[name="email"]', 'trabajador1@sigerd.com');
        await page.type('input[name="password"]', 'wrongpassword');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-002.png' });

        // Clear session / cookies just in case
        await client.send('Network.clearBrowserCookies');

        // CP-TRB-003: Login with unregistered user
        console.log('Running CP-TRB-003...');
        await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
        await delay(500);
        await page.type('input[name="email"]', 'notexists@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
        ]);
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-003.png' });

        await client.send('Network.clearBrowserCookies');

        // CP-TRB-004: Access protected route without auth
        console.log('Running CP-TRB-004...');
        await page.goto(BASE_URL + '/tasks', { waitUntil: 'networkidle0' });
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-004.png' });

        // CP-TRB-006: Empty login form
        console.log('Running CP-TRB-006...');
        await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
        await delay(500);

        // Clear possible pre-filled values
        await page.evaluate(() => {
            document.querySelector('input[name="email"]').value = '';
            document.querySelector('input[name="password"]').value = '';
        });

        await page.click('button[type="submit"]');
        await delay(1500);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-006.png' });

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error in tests:', e);
    } finally {
        await browser.close();
    }
})();
