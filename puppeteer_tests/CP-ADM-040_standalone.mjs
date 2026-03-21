import puppeteer from 'puppeteer';
import * as fs from 'fs';
import * as path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const resultsDir = 'C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\screenshots';
const baseUrl = 'http://127.0.0.1:8000';

if (!fs.existsSync(resultsDir)) { fs.mkdirSync(resultsDir, { recursive: true }); }

async function capture(page, tcId, mom) {
    const p = path.join(resultsDir, `${tcId}_${mom}.png`);
    await page.screenshot({ path: p, fullPage: true });
    console.log(`[CAPTURED] ${tcId}_${mom}`);
}

(async () => {
    const tcId = 'CP-ADM-040';
    console.log(`EJECUCIÓN STANDALONE ${tcId}...`);
    
    const browser = await puppeteer.launch({ headless: "new", args: ['--no-sandbox', '--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    try {
        await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2' });
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([ page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);

        await page.goto(`${baseUrl}/admin/users`, { waitUntil: 'networkidle2' });
        await page.type('input[name="search"]', 'admin@sigerd.com');
        await page.keyboard.press('Enter');
        await page.waitForNetworkIdle();

        // PASO 0: BEFORE
        await capture(page, tcId, 'before');

        // VERIFICAR RESTRICCIÓN
        console.log("Verificando restricción de auto-eliminación...");
        const isRestricted = await page.evaluate(() => {
            const r = Array.from(document.querySelectorAll('tr')).find(x => x.innerText.includes('admin@sigerd.com'));
            if (!r) return "User not found";
            const deleteBtn = r.querySelector('button[onclick*="confirm-action"], button[onclick*="delete"]');
            // If the button is not there, it's restricted (UI level)
            // If the button is disabled, it's restricted
            return !deleteBtn || deleteBtn.disabled || deleteBtn.classList.contains('opacity-50') || deleteBtn.style.display === 'none';
        });

        console.log(`¿Botón restringido? ${isRestricted}`);

        // PASO 1: DURING
        await capture(page, tcId, 'during');

        // PASO 2: AFTER
        await capture(page, tcId, 'after');

        const success = (isRestricted === true);
        console.log(`CASO: ${tcId} | ESTADO: ${success ? '✅ Exitoso' : '❌ Fallido'}`);

    } catch (e) {
        console.error(e);
        await page.screenshot({ path: path.join(resultsDir, `ERROR_${tcId}.png`) });
    } finally {
        await browser.close();
    }
})();
