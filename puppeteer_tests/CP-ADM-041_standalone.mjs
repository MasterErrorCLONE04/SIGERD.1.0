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
    const tcId = 'CP-ADM-041';
    console.log(`EJECUCIÓN STANDALONE ${tcId}...`);
    
    const browser = await puppeteer.launch({ headless: "new", args: ['--no-sandbox', '--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    try {
        // LOGIN
        await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2' });
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([ page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);

        // IR A INCIDENTES
        await page.goto(`${baseUrl}/admin/incidents`, { waitUntil: 'networkidle2' });
        await page.waitForSelector('input[name="search"]');
        
        // PASO 0: BEFORE (Lista inicial)
        await capture(page, tcId, 'before');

        // BUSCAR
        console.log("Buscando 'Falla'...");
        await page.type('input[name="search"]', 'Falla');
        
        // PASO 1: DURING (Después de escribir, justo al presionar Enter)
        await page.keyboard.press('Enter');
        await capture(page, tcId, 'during');

        // ESPERAR RESULTADOS
        await page.waitForNetworkIdle();
        
        // PASO 2: AFTER (Resultados filtrados)
        await capture(page, tcId, 'after');

        const hasResults = await page.evaluate(() => {
            return !document.body.innerText.includes('No se encontraron incidentes');
        });

        console.log("─────────────────────────────────────");
        console.log(`CASO: ${tcId} | ESTADO: ${hasResults ? '✅ Exitoso' : '⚠️ Sin Resultados'}`);
        console.log("─────────────────────────────────────");

    } catch (e) {
        console.error(e);
        await page.screenshot({ path: path.join(resultsDir, `ERROR_${tcId}.png`) });
        console.log(`CASO: ${tcId} | ESTADO: ⚠️ Error Técnico`);
    } finally {
        await browser.close();
    }
})();
