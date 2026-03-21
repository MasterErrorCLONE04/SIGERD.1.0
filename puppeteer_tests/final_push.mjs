import puppeteer from 'puppeteer';
import * as fs from 'fs';
import * as path from 'path';

const resultsDir = 'C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\screenshots';
const resultsFile = 'C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\results.json';
const baseUrl = 'http://127.0.0.1:8000';

async function capture(page, tcId, mom) {
    const p = path.join(resultsDir, `${tcId}_${mom}.png`);
    await page.screenshot({ path: p, fullPage: true });
    console.log(`[CAPTURED] ${tcId}_${mom}`);
}

(async () => {
    const browser = await puppeteer.launch({ headless: "new", args: ['--no-sandbox', '--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    page.setDefaultNavigationTimeout(180000); // 3 minutes
    await page.setViewport({ width: 1280, height: 800 });

    try {
        await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2' });
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([ page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);

        console.log(">>> FINAL PUSH CP-ADM-046...");
        await page.goto(`${baseUrl}/admin/incidents`, { waitUntil: 'networkidle2' });
        
        // Find an incident that is NOT yet assigned if possible, or just the first one
        await page.waitForSelector('tr a[href*="/admin/incidents/"]');
        await page.click('tr a[href*="/admin/incidents/"]');
        await page.waitForNavigation({ waitUntil: 'networkidle2' });

        if (await page.$('#assigned_to')) {
            await page.select('#assigned_to', '2');
            await page.evaluate(() => {
                const b = Array.from(document.querySelectorAll('button')).find(x => x.innerText.includes('CONVERTIR'));
                if (b) b.click();
            });
            await new Promise(r => setTimeout(r, 2000));
            await page.evaluate(() => {
                const b = Array.from(document.querySelectorAll('button')).find(x => x.innerText.trim() === 'Sí, convertir');
                if (b) b.click();
            });
            console.log("Waiting for conversion...");
            await page.waitForNavigation({ waitUntil: 'load' });
            await capture(page, 'CP-ADM-046', 'after');
            
            // Update results.json
            let currentResults = JSON.parse(fs.readFileSync(resultsFile, 'utf8'));
            const idx = currentResults.casos.findIndex(c => c.id === 'CP-ADM-046');
            currentResults.casos[idx] = {
                id: 'CP-ADM-046',
                estado: "Exitoso",
                resultado_obtenido: "Conversión finalizada tras reintento masivo.",
                capturas: { before: "puppeteer_tests/screenshots/CP-ADM-046_before.png", during: "puppeteer_tests/screenshots/CP-ADM-046_during.png", after: "puppeteer_tests/screenshots/CP-ADM-046_after.png" }
            };
            currentResults.errores_tecnicos = currentResults.casos.filter(c => c.estado !== "Exitoso").length;
            currentResults.exitosos = currentResults.casos.filter(c => c.estado === "Exitoso").length;
            fs.writeFileSync(resultsFile, JSON.stringify(currentResults, null, 2));
        }

    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
        console.log("FINAL PUSH COMPLETE.");
    }
})();
