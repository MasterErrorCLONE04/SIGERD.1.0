import puppeteer from 'puppeteer';
import fs from 'fs';

const resultsFile = 'puppeteer_tests/results.json';
const testId = 'CP-ADM-006';
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
        funcionalidad: "Intento de SQL Injection en Login",
        estado: "Exitoso",
        resultado_esperado: 'Rechazo contundente por parte del backend asumiendo credencial incorrecta sin volcado de MySQL.',
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
        
        // Removemos la validación HTML5 para poder enviar el payload SQLi al backend
        await page.evaluate(() => {
            const emailInput = document.querySelector('input[name="email"]');
            emailInput.setAttribute('type', 'text');
            emailInput.removeAttribute('required');
        });

        const sqliPayload = "' OR 1=1 --";
        await page.type('input[name="email"]', sqliPayload);
        await page.type('input[name="password"]', 'anypassword123');
        
        // Tomamos captura DURING para evidenciar el payload
        await page.screenshot({ path: result.capturas.during });
        
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle2' })
        ]);

        // PASO 2 - VERIFICACIÓN
        const url = page.url();
        await page.screenshot({ path: result.capturas.after, fullPage: true });

        const pageText = await page.content();
        
        // Evaluar condiciones de fallo y error
        const hasSqlError = pageText.includes('SQL syntax') || pageText.includes('QueryException');
        const hasAuthError = pageText.includes('Estas credenciales no coinciden') || pageText.includes('These credentials do not match') || pageText.includes('email');

        if (url.includes('/dashboard')) {
            result.estado = "Fallido";
            result.resultado_obtenido = "Peligro Crítico: El sistema permitió el inicio de sesión exitoso mediante SQL Injection (Bypass de autenticación).";
        } else if (hasSqlError) {
            result.estado = "Fallido";
            result.resultado_obtenido = "Peligro: El sistema expuso un error de SQL o volcado de base de datos (QueryException). La aplicación es vulnerable.";
        } else if (hasAuthError || url.includes('/login')) {
            result.estado = "Exitoso";
            result.resultado_obtenido = "Sanitización PDO exitosa. El sistema procesó el payload malicioso como simple texto y devolvió error estándar de credencial.";
        } else {
            result.estado = "Fallido";
            result.resultado_obtenido = "Comportamiento inesperado tras la inyección SQL. URL actual: " + url;
        }

    } catch (e) {
        result.estado = "⚠️ Error Técnico";
        result.error = e.toString();
        result.resultado_obtenido = "Excepción durante la ejecución: " + e.message;
    } finally {
        result.tiempo_ms = Date.now() - startTime;
        await browser.close();
    }

    // REPORTE A RESULTS.JSON
    let resultsData = { proyecto: "SIGERD", fecha: new Date().toISOString(), total: 206, exitosos: 0, fallidos: 0, errores_tecnicos: 0, casos: [] };
    if (fs.existsSync(resultsFile)) {
        resultsData = JSON.parse(fs.readFileSync(resultsFile, 'utf8'));
    }
    
    const existingIndex = resultsData.casos.findIndex(c => c.id === testId);
    if (existingIndex >= 0) {
        resultsData.casos[existingIndex] = result;
    } else {
        resultsData.casos.push(result);
    }

    resultsData.exitosos = resultsData.casos.filter(c => c.estado === "Exitoso").length;
    resultsData.fallidos = resultsData.casos.filter(c => c.estado === "Fallido").length;
    resultsData.errores_tecnicos = resultsData.casos.filter(c => c.estado === "⚠️ Error Técnico").length;
    
    fs.writeFileSync(resultsFile, JSON.stringify(resultsData, null, 2));

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
