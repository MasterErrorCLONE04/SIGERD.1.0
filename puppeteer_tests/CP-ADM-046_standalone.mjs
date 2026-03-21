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
    const tcId = 'CP-ADM-046';
    console.log(`EJECUCIÓN STANDALONE ${tcId}...`);
    
    const browser = await puppeteer.launch({ headless: "new", args: ['--no-sandbox', '--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    try {
        await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2' });
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([ page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);

        // ENSURE AN INCIDENT EXISTS
        await page.goto(`${baseUrl}/admin/incidents`, { waitUntil: 'networkidle2' });
        let incidentExists = await page.evaluate(() => {
            const rows = Array.from(document.querySelectorAll('tr'));
            return rows.some(r => r.innerText.toLowerCase().includes('pendiente de revisión'));
        });

        if (!incidentExists) {
            console.log("Creating an incident for conversion...");
            await page.evaluate(() => {
                const btn = Array.from(document.querySelectorAll('button')).find(b => b.innerText.includes('Reportar Falla'));
                if (btn) btn.click();
            });
            await page.waitForSelector('#createIncidentModal', { visible: true });
            await page.type('#createIncidentModal input[name="title"]', 'Incidente Para Conversion');
            await page.type('#createIncidentModal textarea[name="description"]', 'Este incidente se convertira en tarea.');
            await page.type('#createIncidentModal input[name="location"]', 'Laboratorio');
            const photoPath = path.join(fixtureDir, 'valid.jpg');
            const [fileChooser] = await Promise.all([
                page.waitForFileChooser(),
                page.click('#createIncidentModal input[name="initial_evidence_images[]"]')
            ]);
            await fileChooser.accept([photoPath]);
            await Promise.all([ page.click('#createIncidentModal button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);
        }

        // GO TO INCIDENT DETAIL
        await page.evaluate(() => {
            const rows = Array.from(document.querySelectorAll('tr'));
            const row = rows.find(r => r.innerText.toLowerCase().includes('pendiente de revisión'));
            if (row) {
                const link = row.querySelector('a[href*="/admin/incidents/"]');
                if (link) link.click();
            }
        });
        await page.waitForNavigation({ waitUntil: 'networkidle2' });

        // BEFORE
        await capture(page, tcId, 'before');

        // FILL CONVERSION FORM
        console.log("Diligenciando formulario de conversión...");
        await page.select('#assigned_to', '2'); 
        await page.select('#priority', 'alta');
        
        // Use evaluate to set deadline to avoid date picker issues
        await page.evaluate(() => {
            document.getElementById('deadline_at').value = '2026-12-31';
        });
        
        // DURING (Before confirmation)
        await capture(page, tcId, 'during');

        // CLICK CONVERT (Triggers modal)
        await page.evaluate(() => {
            const btn = Array.from(document.querySelectorAll('button')).find(b => b.innerText.includes('CONVERTIR'));
            if (btn) btn.click();
        });
        await new Promise(r => setTimeout(r, 1000)); // Wait for modal animation

        // CONFIRM
        console.log("Confirmando conversión...");
        await Promise.all([
            page.evaluate(() => {
                const btn = Array.from(document.querySelectorAll('button')).find(b => b.innerText.includes('Sí, convertir'));
                if (btn) btn.click();
            }),
            page.waitForNavigation({ waitUntil: 'networkidle2' })
        ]);

        // AFTER
        await capture(page, tcId, 'after');

        const success = await page.evaluate(() => document.body.innerText.includes('Incidente convertido a tarea exitosamente'));
        console.log(`CASO: ${tcId} | ESTADO: ${success ? '✅ Exitoso' : '❌ Fallido'}`);

    } catch (e) {
        console.error(e);
        await page.screenshot({ path: path.join(resultsDir, `ERROR_${tcId}.png`) });
    } finally {
        await browser.close();
    }
})();
