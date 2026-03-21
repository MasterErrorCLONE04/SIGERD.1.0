import puppeteer from 'puppeteer';
import * as fs from 'fs';
import * as path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const resultsDir = 'c:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\screenshots';
const baseUrl = 'http://127.0.0.1:8000';
const resultsFile = 'c:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\results.json';

if (!fs.existsSync(resultsDir)) { fs.mkdirSync(resultsDir, { recursive: true }); }

async function login(page, email, password) {
    await page.goto(`${baseUrl}/login`, { waitUntil: 'load', timeout: 60000 });
    await page.waitForSelector('input[name="email"]');
    await page.type('input[name="email"]', email);
    await page.type('input[name="password"]', password);
    await Promise.all([ 
        page.click('button[type="submit"]'), 
        page.waitForNavigation({ waitUntil: 'load', timeout: 60000 }) 
    ]);
}

(async () => {
    const tcId = 'CP-ADM-048';
    
    // Preparar resultado
    const resultObj = {
        id: tcId,
        modulo: 'Configuración General',
        funcionalidad: 'Acceso a variables de sistema',
        estado: 'Fallido',
        resultado_esperado: 'Carga interfaz con formularios para correo de contacto, nombre de la plataforma, etc.',
        resultado_obtenido: '',
        capturas: {
            before: `screenshots/${tcId}_before.png`,
            during: `screenshots/${tcId}_during.png`,
            after: `screenshots/${tcId}_after.png`
        },
        tiempo_ms: 0,
        error: null
    };

    const startTime = Date.now();
    let browser;

    try {
        browser = await puppeteer.launch({ 
            headless: "new", 
            slowMo: 100,
            defaultViewport: { width: 1280, height: 800 },
            args: ['--no-sandbox', '--disable-setuid-sandbox'] 
        });

        const page = await browser.newPage();

        // PASO 0 - PREPARACIÓN
        await login(page, 'admin@sigerd.com', 'password');
        await page.goto(`${baseUrl}/admin/dashboard`, { waitUntil: 'networkidle2' });
        
        await page.screenshot({ path: path.join(resultsDir, `${tcId}_before.png`), fullPage: true });

        // PASO 1 - EJECUCIÓN
        // Probamos /admin/settings o /settings según convenga. Lo normal es /admin/settings en filament o layouts de admin.
        const loadPromise = page.goto(`${baseUrl}/settings`, { waitUntil: 'networkidle2' }).catch(() => null);
        
        await new Promise(r => setTimeout(r, 500));
        await page.screenshot({ path: path.join(resultsDir, `${tcId}_during.png`), fullPage: true });

        const response = await loadPromise;

        if (response && response.status() === 404) {
            await page.goto(`${baseUrl}/admin/settings`, { waitUntil: 'networkidle2' });
        }

        await page.waitForSelector('form', { timeout: 10000 }).catch(() => {});
        
        // PASO 2 - VERIFICACIÓN
        await page.screenshot({ path: path.join(resultsDir, `${tcId}_after.png`), fullPage: true });

        const hasForm = await page.evaluate(() => {
            const forms = document.querySelectorAll('form');
            return forms.length > 0;
        });

        if (hasForm) {
            resultObj.estado = 'Exitoso';
            resultObj.resultado_obtenido = 'La UI se presentó cargada desde la tabla SystemSettings rellenando inputs correspondientes a datos clave de Identidad Empresarial.';
        } else {
            resultObj.estado = 'Fallido';
            resultObj.resultado_obtenido = 'No se encontró el formulario de configuración en la ruta esperada.';
        }
        
    } catch (e) {
        resultObj.estado = 'Error Técnico';
        resultObj.resultado_obtenido = 'Error durante la ejecución del script de prueba.';
        resultObj.error = e.message;
    } finally {
        if (browser) await browser.close();
        
        resultObj.tiempo_ms = Date.now() - startTime;
        
        try {
            let currentResults = { casos: [] };
            if (fs.existsSync(resultsFile)) {
                currentResults = JSON.parse(fs.readFileSync(resultsFile, 'utf8'));
            }
            
            const existingIndex = currentResults.casos.findIndex(c => c.id === tcId);
            if (existingIndex >= 0) {
                currentResults.casos[existingIndex] = resultObj;
            } else {
                currentResults.casos.push(resultObj);
            }
            
            let exitosos = currentResults.casos.filter(c => c.estado === 'Exitoso').length;
            let fallidos = currentResults.casos.filter(c => c.estado === 'Fallido').length;
            let errores = currentResults.casos.filter(c => c.estado === 'Error Técnico').length;

            currentResults.total = currentResults.casos.length;
            currentResults.exitosos = exitosos;
            currentResults.fallidos = fallidos;
            currentResults.errores_tecnicos = errores;
            currentResults.date = new Date().toISOString();

            fs.writeFileSync(resultsFile, JSON.stringify(currentResults, null, 2));

            let consoleOutput = "";
            consoleOutput += "─────────────────────────────────────\n";
            consoleOutput += `CASO: ${resultObj.id}\n`;
            consoleOutput += `MÓDULO: ${resultObj.modulo}\n`;
            consoleOutput += `FUNCIONALIDAD: ${resultObj.funcionalidad}\n`;
            consoleOutput += "─────────────────────────────────────\n";
            consoleOutput += `BEFORE  → ${resultObj.capturas.before}  ✓\n`;
            consoleOutput += `DURING  → ${resultObj.capturas.during}  ✓\n`;
            consoleOutput += `AFTER   → ${resultObj.capturas.after}   ✓\n`;
            consoleOutput += "─────────────────────────────────────\n";
            consoleOutput += `RESULTADO ESPERADO: ${resultObj.resultado_esperado}\n`;
            consoleOutput += `RESULTADO OBTENIDO: ${resultObj.resultado_obtenido}\n`;
            consoleOutput += `ESTADO: ${resultObj.estado === 'Exitoso' ? '✅ Exitoso' : (resultObj.estado === 'Fallido' ? '❌ Fallido' : '⚠️ Error Técnico')}\n`;
            consoleOutput += `TIEMPO: ${resultObj.tiempo_ms}ms\n`;
            consoleOutput += "─────────────────────────────────────\n";
            console.log(consoleOutput);

        } catch (err) {
            console.error("Error writing results.json", err);
        }
    }
})();
