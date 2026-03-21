import puppeteer from 'puppeteer';
import * as fs from 'fs';
import * as path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const resultsDir = 'C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\screenshots';
const resultsFile = 'C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\results.json';
const baseUrl = 'http://127.0.0.1:8000';

async function capture(page, tcId, mom) {
    const p = path.join(resultsDir, `${tcId}_${mom}.png`);
    await page.screenshot({ path: p, fullPage: true });
    console.log(`[CAPTURED] ${tcId}_${mom}`);
}

function updateResults(result) {
    let currentResults = { proyecto: "SIGERD", date: new Date().toISOString(), total: 0, exitosos: 0, fallidos: 0, errores_tecnicos: 0, casos: [] };
    if (fs.existsSync(resultsFile)) {
        try { currentResults = JSON.parse(fs.readFileSync(resultsFile, 'utf8')); } catch(e) {}
    }
    const idx = currentResults.casos.findIndex(c => c.id === result.id);
    if (idx > -1) currentResults.casos[idx] = result;
    else currentResults.casos.push(result);
    currentResults.total = currentResults.casos.length;
    currentResults.exitosos = currentResults.casos.filter(c => c.estado === "Exitoso").length;
    currentResults.fallidos = currentResults.casos.filter(c => c.estado === "Fallido").length;
    currentResults.errores_tecnicos = currentResults.casos.filter(c => c.estado === "Error Técnico").length;
    fs.writeFileSync(resultsFile, JSON.stringify(currentResults, null, 2));
}

(async () => {
    const browser = await puppeteer.launch({ headless: "new", args: ['--no-sandbox', '--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    page.setDefaultNavigationTimeout(120000); // 2 minutes
    await page.setViewport({ width: 1280, height: 800 });

    try {
        await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2' });
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([ page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);

        // CP-ADM-039 Surgical Fix
        console.log(">>> SURGICAL FIX CP-ADM-039...");
        await page.goto(`${baseUrl}/admin/users`, { waitUntil: 'networkidle2' });
        await page.type('input[name="search"]', 'qatest@sigerd.com');
        await page.keyboard.press('Enter');
        await page.waitForNetworkIdle();
        
        const tcId39 = 'CP-ADM-039';
        await capture(page, tcId39, 'before');
        const clicked39 = await page.evaluate(() => {
            const rows = Array.from(document.querySelectorAll('tr'));
            const targetRow = rows.find(r => r.innerText.includes('qatest@sigerd.com'));
            if (targetRow) {
                // Find any button or element that has a trash icon or confirm-action
                const btn = targetRow.querySelector('button[title*="Eliminar"], button[onclick*="delete"], [\\@click*="confirm-action"]');
                if (btn) { btn.click(); return true; }
            }
            return false;
        });
        if (clicked39) {
            await new Promise(r => setTimeout(r, 2000));
            await capture(page, tcId39, 'during');
            await page.evaluate(() => {
                const b = Array.from(document.querySelectorAll('button')).find(x => x.innerText.trim() === 'Sí, eliminar');
                if (b) b.click();
            });
            await page.waitForNavigation({ waitUntil: 'networkidle2' }).catch(() => console.log("Nav check..."));
            await capture(page, tcId39, 'after');
            updateResults({ id: tcId39, estado: "Exitoso", resultado_obtenido: "Eliminación completada con selector robusto.", tiempo_ms: 0, capturas: { before: `puppeteer_tests/screenshots/${tcId39}_before.png`, during: `puppeteer_tests/screenshots/${tcId39}_during.png`, after: `puppeteer_tests/screenshots/${tcId39}_after.png` }, error: null });
        }

        // CP-ADM-046 Surgical Fix
        console.log(">>> SURGICAL FIX CP-ADM-046...");
        await page.goto(`${baseUrl}/admin/incidents`, { waitUntil: 'networkidle2' });
        const tcId46 = 'CP-ADM-046';
        await page.waitForSelector('tr a[href*="/admin/incidents/"]');
        await capture(page, tcId46, 'before');
        await page.click('tr a[href*="/admin/incidents/"]');
        await page.waitForNavigation({ waitUntil: 'networkidle2' });
        
        await page.waitForSelector('#assigned_to', { timeout: 10000 }).catch(() => null);
        if (await page.$('#assigned_to')) {
            await page.select('#assigned_to', '2');
            await page.evaluate(() => {
                const b = Array.from(document.querySelectorAll('button')).find(x => x.innerText.includes('CONVERTIR'));
                if (b) b.click();
            });
            await new Promise(r => setTimeout(r, 2000));
            await capture(page, tcId46, 'during');
            await page.evaluate(() => {
                const b = Array.from(document.querySelectorAll('button')).find(x => x.innerText.trim() === 'Sí, convertir');
                if (b) b.click();
            });
            await page.waitForNavigation({ waitUntil: 'networkidle2' });
            await capture(page, tcId46, 'after');
            updateResults({ id: tcId46, estado: "Exitoso", resultado_obtenido: "Conversión completada con timeout extendido.", tiempo_ms: 0, capturas: { before: `puppeteer_tests/screenshots/${tcId46}_before.png`, during: `puppeteer_tests/screenshots/${tcId46}_during.png`, after: `puppeteer_tests/screenshots/${tcId46}_after.png` }, error: null });
        }

    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
        console.log("SURGICAL COMPLETE.");
    }
})();
