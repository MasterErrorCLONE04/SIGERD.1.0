import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';

const resultsFile = 'puppeteer_tests/results.json';
const testId = 'CP-ADM-001';
const screenshotPath = 'puppeteer_tests/screenshots';

async function runTest() {
    const browser = await puppeteer.launch({ 
        headless: "new",
        args: ['--no-sandbox', '--disable-setuid-sandbox'] 
    });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });
    
    let result = {
        id: testId,
        modulo: "Autenticación y Acceso (Login)",
        funcionalidad: "Inicio de sesión exitoso",
        estado: "Exitoso",
        resultado_esperado: "Redirección a /admin/dashboard mostrando indicadores del sistema.",
        resultado_obtenido: "",
        capturas: {
            before: `${screenshotPath}/${testId}_before.png`,
            during: `${screenshotPath}/${testId}_during.png`,
            after: `${screenshotPath}/${testId}_after.png`
        },
        tiempo_ms: 0,
        error: null
    };

    const startTime = Date.now();
    try {
        // PASO 0 - PREPARACIÓN
        await page.goto('http://127.0.0.1:8000/login', { waitUntil: 'networkidle2' });
        await page.screenshot({ path: result.capturas.before });

        // PASO 1 - EJECUCIÓN
        await page.waitForSelector('input[name="email"]');
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await page.screenshot({ path: result.capturas.during });
        
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle2' })
        ]);

        // PASO 2 - VERIFICACIÓN
        const url = page.url();
        await page.screenshot({ path: result.capturas.after, fullPage: true });

        if (url.includes('/admin/dashboard')) {
            result.estado = "Exitoso";
            result.resultado_obtenido = `Redirección correcta a ${url}`;
        } else {
            result.estado = "Fallido";
            result.resultado_obtenido = `Redirigido a ${url} en lugar de /admin/dashboard`;
        }
    } catch (e) {
        result.estado = "⚠️ Error Técnico";
        result.error = e.toString();
        result.resultado_obtenido = "Excepción durante la ejecución";
    } finally {
        result.tiempo_ms = Date.now() - startTime;
        await browser.close();
    }

    // REPORTE A RESULTS.JSON
    let resultsData = { proyecto: "SIGERD", fecha: new Date().toISOString(), total: 206, exitosos: 0, fallidos: 0, errores_tecnicos: 0, casos: [] };
    if (fs.existsSync(resultsFile)) {
        resultsData = JSON.parse(fs.readFileSync(resultsFile, 'utf8'));
    }
    
    // update state in JSON
    const existingIndex = resultsData.casos.findIndex(c => c.id === testId);
    if (existingIndex >= 0) {
        resultsData.casos[existingIndex] = result;
    } else {
        resultsData.casos.push(result);
    }

    // Recalculate totals
    resultsData.exitosos = resultsData.casos.filter(c => c.estado === "Exitoso").length;
    resultsData.fallidos = resultsData.casos.filter(c => c.estado === "Fallido").length;
    resultsData.errores_tecnicos = resultsData.casos.filter(c => c.estado === "⚠️ Error Técnico").length;
    
    fs.writeFileSync(resultsFile, JSON.stringify(resultsData, null, 2));

    // Console output for the assistant to format
    const outputState = result.estado.includes("Exitoso") ? "✅ Exitoso" : (result.estado.includes("Fallido") ? "❌ Fallido" : "⚠️ Error Técnico");
    console.log(`─────────────────────────────────────
CASO: ${result.id}
MÓDULO: ${result.modulo}
FUNCIONALIDAD: ${result.funcionalidad}
─────────────────────────────────────
BEFORE  → ${result.capturas.before}  ✓
DURING  → ${result.capturas.during}  ✓
AFTER   → ${result.capturas.after}   ✓
─────────────────────────────────────
RESULTADO ESPERADO: ${result.resultado_esperado}
RESULTADO OBTENIDO: ${result.resultado_obtenido}
ESTADO: ${outputState}
TIEMPO: ${result.tiempo_ms}ms
─────────────────────────────────────`);
}

runTest();
