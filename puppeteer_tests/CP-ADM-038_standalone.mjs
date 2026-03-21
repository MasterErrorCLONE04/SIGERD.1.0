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
    console.log("--- ENSURE TEST USER ---");
    await page.goto(`${baseUrl}/admin/users?search=qatest@sigerd.com`, { waitUntil: 'networkidle2' });
    
    const exists = await page.evaluate(() => {
        return document.body.innerText.includes('qatest@sigerd.com');
    });

    if (exists) {
        console.log("Usuario ya existe.");
        return;
    }

    console.log("Creando usuario...");
    await page.goto(`${baseUrl}/admin/users`, { waitUntil: 'networkidle2' });
    await page.click('button[onclick*="createUserModal"]');
    await page.waitForSelector('#createUserModal', { visible: true });
    
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

    await Promise.all([ 
        page.click('#createUserModal button[type="submit"]'), 
        page.waitForNavigation({ waitUntil: 'networkidle2' }) 
    ]);
    console.log("Paso de creación completado.");
}

(async () => {
    const tcId = 'CP-ADM-038';
    console.log(`EXE FINAL ${tcId}...`);
    
    const browser = await puppeteer.launch({ headless: "new", args: ['--no-sandbox', '--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    try {
        await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2' });
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([ page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);

        await ensureTestUser(page);

        // PASO 0: BEFORE
        await page.goto(`${baseUrl}/admin/users?search=qatest@sigerd.com`, { waitUntil: 'networkidle2' });
        await capture(page, tcId, 'before');

        // PASO 1: DURING
        console.log("Clic en Ver detalle...");
        const clicked = await page.evaluate(() => {
            const rows = Array.from(document.querySelectorAll('tr'));
            const targetRow = rows.find(r => r.innerText.includes('qatest@sigerd.com'));
            const link = targetRow?.querySelector('a[title*="Ver detalle"]');
            if (link) { link.click(); return true; }
            return false;
        });

        if (!clicked) throw new Error("No se pudo encontrar el enlace 'Ver detalle'");

        await page.waitForNavigation({ waitUntil: 'networkidle2' });
        await capture(page, tcId, 'during');

        // PASO 2: AFTER
        await page.waitForNetworkIdle();
        await capture(page, tcId, 'after');

        console.log("─────────────────────────────────────");
        console.log(`CASO: ${tcId} | ESTADO: ✅ Exitoso`);
        console.log("─────────────────────────────────────");

    } catch (e) {
        console.error("FAIL:", e.message);
        await page.screenshot({ path: path.join(resultsDir, `FAIL_FINAL_${tcId}.png`) });
    } finally {
        await browser.close();
    }
})();
