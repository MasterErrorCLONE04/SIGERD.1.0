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

(async () => {
    const tcId = 'CP-ADM-045';
    console.log(`EJECUCIÓN STANDALONE ${tcId}...`);
    
    const browser = await puppeteer.launch({ headless: "new", args: ['--no-sandbox', '--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    try {
        await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2' });
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([ page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);

        await page.goto(`${baseUrl}/admin/incidents`, { waitUntil: 'networkidle2' });

        // BEFORE
        await capture(page, tcId, 'before');

        // OPEN MODAL
        await page.evaluate(() => {
            const btn = Array.from(document.querySelectorAll('button')).find(b => b.innerText.includes('Reportar Falla'));
            if (btn) btn.click();
        });
        await page.waitForSelector('#createIncidentModal', { visible: true });

        // FILL FORM
        await page.type('#createIncidentModal input[name="title"]', 'Test Fecha Futura');
        await page.type('#createIncidentModal textarea[name="description"]', 'Prueba de validación de fecha futura.');
        await page.type('#createIncidentModal input[name="location"]', 'Almacén');

        // BYPASS READONLY DATE
        await page.evaluate(() => {
            const input = document.getElementById('incident_report_date');
            input.readOnly = false;
            input.max = "";
            input.value = '2099-12-31';
        });

        // PHOTO
        const photoPath = path.join(fixtureDir, 'valid.jpg');
        const [fileChooser] = await Promise.all([
            page.waitForFileChooser(),
            page.click('#createIncidentModal input[name="initial_evidence_images[]"]')
        ]);
        await fileChooser.accept([photoPath]);

        // DURING
        await capture(page, tcId, 'during');

        // SUBMIT
        await Promise.all([ 
            page.click('#createIncidentModal button[type="submit"]'), 
            page.waitForNavigation({ waitUntil: 'networkidle2' }) 
        ]);

        // AFTER
        await capture(page, tcId, 'after');

        const success = await page.evaluate(() => document.body.innerText.includes('fecha del reporte') && document.body.innerText.includes('hoy'));
        console.log(`CASO: ${tcId} | ESTADO: ${success ? '✅ Exitoso' : '❌ Fallido'}`);

    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
    }
})();
