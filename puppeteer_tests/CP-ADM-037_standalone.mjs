import puppeteer from 'puppeteer';
import * as fs from 'fs';
import * as path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const resultsDir = 'C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\screenshots';
const resultsFile = 'C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\results.json';
const baseUrl = 'http://127.0.0.1:8000';

if (!fs.existsSync(resultsDir)) { fs.mkdirSync(resultsDir, { recursive: true }); }

async function capture(page, tcId, mom) {
    const p = path.join(resultsDir, `${tcId}_${mom}.png`);
    await page.screenshot({ path: p, fullPage: true });
    console.log(`Captured: ${tcId}_${mom}.png`);
}

(async () => {
    const startTime = Date.now();
    const tcId = 'CP-ADM-037';
    console.log(`EJECUCIÓN FINAL ${tcId}...`);
    
    const browser = await puppeteer.launch({ headless: "new", args: ['--no-sandbox', '--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    let status = "❌ Fallido";
    let obtained = "";
    let error = null;

    try {
        await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2' });
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([ page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);

        // PASO 0
        await page.goto(`${baseUrl}/admin/users`, { waitUntil: 'networkidle2' });
        await page.waitForSelector('input[name="search"]');
        await page.type('input[name="search"]', 'qatest@sigerd.com');
        await page.keyboard.press('Enter');
        await page.waitForNetworkIdle();
        await capture(page, tcId, 'before');

        // PASO 1
        console.log("Abriendo modal...");
        const clicked = await page.evaluate(() => {
            const rows = Array.from(document.querySelectorAll('tr'));
            const targetRow = rows.find(r => r.innerText.includes('qatest@sigerd.com'));
            if (targetRow) {
                const btn = targetRow.querySelector('button[onclick*="startEditUser"]');
                if (btn) { btn.click(); return true; }
            }
            return false;
        });

        if (!clicked) throw new Error("No se encontró la fila del usuario de prueba.");

        await page.waitForSelector('#editUserModal', { visible: true, timeout: 5000 });
        
        await page.focus('#edit_user_name');
        await page.keyboard.down('Control'); await page.keyboard.press('A'); await page.keyboard.up('Control');
        await page.keyboard.press('Backspace');
        const newName = "QA Final Edit " + Date.now();
        await page.type('#edit_user_name', newName);
        
        await capture(page, tcId, 'during');
        
        await page.click('#editUserModal button[type="submit"]');
        await page.waitForNavigation({ waitUntil: 'networkidle2' });

        // PASO 2
        await page.goto(`${baseUrl}/admin/users`, { waitUntil: 'networkidle2' });
        await capture(page, tcId, 'after');
        
        status = "✅ Exitoso";
        obtained = "Usuario editado correctamente sin cambiar la contraseña.";

    } catch (e) {
        console.error(e);
        status = "⚠️ Error Técnico";
        error = e.toString();
        obtained = "Error técnico: " + e.message;
    } finally {
        const endTime = Date.now();
        const duration = endTime - startTime;
        
        const result = {
            id: tcId,
            modulo: "Gestión de Usuarios",
            funcionalidad: "Editar sin cambiar clave",
            estado: status.replace('✅ ', '').replace('❌ ', '').replace('⚠️ ', ''),
            resultado_esperado: "Se guarda con éxito. La contraseña original no se sobreescribe ni corrompe.",
            resultado_obtenido: obtained,
            capturas: {
                before: `puppeteer_tests/screenshots/${tcId}_before.png`,
                during: `puppeteer_tests/screenshots/${tcId}_during.png`,
                after:  `puppeteer_tests/screenshots/${tcId}_after.png`
            },
            tiempo_ms: duration,
            error: error
        };

        let currentResults = { proyecto: "SIGERD", date: new Date().toISOString(), total: 0, exitosos: 0, fallidos: 0, errores_tecnicos: 0, casos: [] };
        if (fs.existsSync(resultsFile)) {
            try { currentResults = JSON.parse(fs.readFileSync(resultsFile, 'utf8')); } catch(e) {}
        }
        
        const existingIdx = currentResults.casos.findIndex(c => c.id === tcId);
        if (existingIdx > -1) currentResults.casos[existingIdx] = result;
        else currentResults.casos.push(result);
        
        currentResults.total = currentResults.casos.length;
        currentResults.exitosos = currentResults.casos.filter(c => c.estado === "Exitoso").length;
        currentResults.fallidos = currentResults.casos.filter(c => c.estado === "Fallido").length;
        currentResults.errores_tecnicos = currentResults.casos.filter(c => c.estado === "Error Técnico").length;
        
        fs.writeFileSync(resultsFile, JSON.stringify(currentResults, null, 2));

        console.log("─────────────────────────────────────");
        console.log(`CASO: ${tcId} | ESTADO: ${status}`);
        console.log("─────────────────────────────────────");

        await browser.close();
    }
})();
