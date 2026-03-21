import puppeteer from 'puppeteer';
import * as fs from 'fs';
import * as path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const resultsDir = 'C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\screenshots';
const fixtureDir = 'C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\fixtures';
const baseUrl = 'http://127.0.0.1:8000';

if (!fs.existsSync(resultsDir)) { fs.mkdirSync(resultsDir, { recursive: true }); }

async function capture(page, tcId, mom) {
    const p = path.join(resultsDir, `${tcId}_${mom}.png`);
    await page.screenshot({ path: p, fullPage: true });
    console.log(`[CAPTURED] ${tcId}_${mom}`);
}

async function ensureTestUser(page) {
    await page.goto(`${baseUrl}/admin/users`, { waitUntil: 'networkidle2' });
    await page.type('input[name="search"]', 'qatest@sigerd.com');
    await page.keyboard.press('Enter');
    await page.waitForNetworkIdle();
    const exists = await page.evaluate(() => document.body.innerText.includes('qatest@sigerd.com'));
    if (!exists) {
        console.log("Creating qatest@sigerd.com...");
        await page.goto(`${baseUrl}/admin/users`, { waitUntil: 'networkidle2' });
        await page.evaluate(() => document.querySelector('button[onclick*="createUserModal"]').click());
        await page.waitForSelector('#createUserModal input[name="name"]', { visible: true });
        await page.type('#createUserModal input[name="name"]', 'QA Test User');
        await page.type('#createUserModal input[name="email"]', 'qatest@sigerd.com');
        await page.type('#createUserModal input[name="password"]', 'password');
        await page.type('#createUserModal input[name="password_confirmation"]', 'password');
        await page.select('#createUserModal select[name="role"]', 'trabajador');
        const photoPath = path.join(fixtureDir, 'valid.jpg');
        const [fileChooser] = await Promise.all([
            page.waitForFileChooser(),
            page.click('#createUserModal input[name="profile_photo"]')
        ]);
        await fileChooser.accept([photoPath]);
        await Promise.all([ page.click('#createUserModal button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);
    }
}

(async () => {
    const tcId = 'CP-ADM-039';
    console.log(`EJECUCIÓN STANDALONE ${tcId}...`);
    
    const browser = await puppeteer.launch({ headless: "new", args: ['--no-sandbox', '--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    try {
        await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2' });
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([ page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);

        await ensureTestUser(page);

        await page.goto(`${baseUrl}/admin/users`, { waitUntil: 'networkidle2' });
        await page.type('input[name="search"]', 'qatest@sigerd.com');
        await page.keyboard.press('Enter');
        await page.waitForNetworkIdle();

        // PASO 0: BEFORE
        await capture(page, tcId, 'before');

        // CLICK DELETE
        console.log("Abriendo confirmación de eliminación...");
        await page.evaluate(() => {
            const r = Array.from(document.querySelectorAll('tr')).find(x => x.innerText.includes('qatest@sigerd.com'));
            r.querySelector('button[onclick*="confirm-action"], button[onclick*="delete"]').click();
        });
        await new Promise(r => setTimeout(r, 1000));

        // PASO 1: DURING
        await capture(page, tcId, 'during');

        // CONFIRMAR
        console.log("Confirmando eliminación...");
        await page.evaluate(() => {
            Array.from(document.querySelectorAll('button')).find(b => b.innerText.includes('Sí, eliminar')).click();
        });
        await page.waitForNavigation({ waitUntil: 'networkidle2' });

        // PASO 2: AFTER
        await page.type('input[name="search"]', 'qatest@sigerd.com');
        await page.keyboard.press('Enter');
        await page.waitForNetworkIdle();
        await capture(page, tcId, 'after');

        const success = await page.evaluate(() => !document.body.innerText.includes('qatest@sigerd.com'));
        console.log(`CASO: ${tcId} | ESTADO: ${success ? '✅ Exitoso' : '❌ Fallido'}`);

    } catch (e) {
        console.error(e);
        await page.screenshot({ path: path.join(resultsDir, `ERROR_${tcId}.png`) });
    } finally {
        await browser.close();
    }
})();
