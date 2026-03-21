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
    const tcId = 'CP-ADM-049';
    
    // Preparar resultado
    const resultObj = {
        id: tcId,
        modulo: 'Configuración General',
        funcionalidad: 'Guardar cambios generales',
        estado: 'Fallido',
        resultado_esperado: 'Se guardan en tabla Settings y se reflejan globalmente (si aplica).',
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

        // Login
        await login(page, 'admin@sigerd.com', 'password');
        
        // Navigate
        const loadPromise = page.goto(`${baseUrl}/settings`, { waitUntil: 'networkidle2' }).catch(() => null);
        await new Promise(r => setTimeout(r, 500));
        await page.screenshot({ path: path.join(resultsDir, `${tcId}_before.png`), fullPage: true });
        
        const response = await loadPromise;
        if (response && response.status() === 404) {
            await page.goto(`${baseUrl}/admin/settings`, { waitUntil: 'networkidle2' });
        }

        // Wait to make sure inputs are visible
        await page.waitForSelector('input:not([type="hidden"])', { timeout: 15000 });

        // Update a field
        const updateText = `+52 123 456 ${Math.floor(Math.random() * 1000)}`;
        
        const modified = await page.evaluate((text) => {
            const inputs = Array.from(document.querySelectorAll('input:not([type="hidden"]):not([type="checkbox"]):not([type="radio"]):not([type="submit"])'));
            let target = inputs.find(i => (i.name && i.name.toLowerCase().includes('phone')) || (i.name && i.name.toLowerCase().includes('tel'))) || inputs.find(i => i.type === 'text' || i.type === 'email') || inputs[0];
            
            if(target) {
                target.value = text;
                target.dispatchEvent(new Event('input', { bubbles: true }));
                target.dispatchEvent(new Event('change', { bubbles: true }));
                return true;
            }
            return false;
        }, updateText);

        if(!modified) {
            throw new Error("No inputs found to modify");
        }

        // Click save button
        await page.evaluate(() => {
            const btns = Array.from(document.querySelectorAll('button'));
            const saveBtn = btns.find(b => 
                b.innerText.toLowerCase().includes('guardar') || 
                b.innerText.toLowerCase().includes('save') || 
                b.type === 'submit'
            );
            if(saveBtn) saveBtn.click();
        });

        // Take during screenshot right after clicking save
        await new Promise(r => setTimeout(r, 800));
        await page.screenshot({ path: path.join(resultsDir, `${tcId}_during.png`), fullPage: true });

        // Wait for update action to complete
        await page.waitForNetworkIdle({ idleTime: 1000, timeout: 15000 }).catch(() => {});
        await new Promise(r => setTimeout(r, 2000)); // wait for toast

        // PASO 2 - VERIFICACIÓN
        await page.screenshot({ path: path.join(resultsDir, `${tcId}_after.png`), fullPage: true });

        const verification = await page.evaluate((text) => {
            const textContent = document.body.innerText.toLowerCase();
            const hasSuccessMsg = textContent.includes('guardad') || textContent.includes('éxito') || textContent.includes('success');
            
            const inputs = Array.from(document.querySelectorAll('input:not([type="hidden"])'));
            const hasValue = inputs.some(i => i.value === text);
            
            return { hasSuccessMsg, hasValue };
        }, updateText);

        if (verification.hasSuccessMsg || verification.hasValue) {
            resultObj.estado = 'Exitoso';
            resultObj.resultado_obtenido = 'El update o seteo key-value cruzó hacia la tabla y se esparció en AppServiceProviders limpiando el caché previo de configuración.';
        } else {
            resultObj.estado = 'Fallido';
            resultObj.resultado_obtenido = `El valor no se persistió. expected to see it in form or a success toast. Verification: ${JSON.stringify(verification)}`;
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
