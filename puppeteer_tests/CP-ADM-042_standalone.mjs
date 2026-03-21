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
    const tcId = 'CP-ADM-042';
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
        
        // PASO 0: BEFORE
        await capture(page, tcId, 'before');

        // ABRIR MODAL
        console.log("Abriendo modal de nueva incidencia...");
        await page.evaluate(() => {
            const btn = Array.from(document.querySelectorAll('button')).find(b => b.innerText.includes('Reportar Falla'));
            if (btn) btn.click();
        });
        await page.waitForSelector('#createIncidentModal', { visible: true });

        // LLENAR FORMULARIO
        const incidentTitle = `Falla Detectada por QA ${Date.now()}`;
        await page.type('#createIncidentModal input[name="title"]', incidentTitle);
        await page.type('#createIncidentModal textarea[name="description"]', 'Descripción generada automáticamente por script de prueba para verificar creación de incidencias.');
        await page.type('#createIncidentModal input[name="location"]', 'Laboratorio de Pruebas Automatizadas');
        
        // ADJUNTAR IMAGEN
        const photoPath = path.join(fixtureDir, 'valid.jpg');
        const [fileChooser] = await Promise.all([
            page.waitForFileChooser(),
            page.click('#createIncidentModal input[name="initial_evidence_images[]"]')
        ]);
        await fileChooser.accept([photoPath]);

        // PASO 1: DURING
        await capture(page, tcId, 'during');

        // GUARDAR
        console.log("Guardando incidencia...");
        await Promise.all([ 
            page.click('#createIncidentModal button[type="submit"]'), 
            page.waitForNavigation({ waitUntil: 'networkidle2' }) 
        ]);

        // VERIFICAR EN LISTA
        await page.type('input[name="search"]', incidentTitle);
        await page.keyboard.press('Enter');
        await page.waitForNetworkIdle();

        // PASO 2: AFTER
        await capture(page, tcId, 'after');

        const success = await page.evaluate((title) => document.body.innerText.includes(title), incidentTitle);

        console.log("─────────────────────────────────────");
        console.log(`CASO: ${tcId} | ESTADO: ${success ? '✅ Exitoso' : '❌ Fallido'}`);
        console.log("─────────────────────────────────────");

    } catch (e) {
        console.error(e);
        await page.screenshot({ path: path.join(resultsDir, `ERROR_${tcId}.png`) });
        console.log(`CASO: ${tcId} | ESTADO: ⚠️ Error Técnico`);
    } finally {
        await browser.close();
    }
})();
