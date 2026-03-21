import puppeteer from 'puppeteer';
import fs from 'fs';

const resultsFile = 'puppeteer_tests/results.json';
const testId = 'CP-ADM-003';
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
        funcionalidad: "Fallo por usuario no registrado",
        estado: "Exitoso", // Default success if behavior matches expectation
        resultado_esperado: 'Mensaje de error indicando que las credenciales no coinciden. No ingresa.',
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
        await page.type('input[name="email"]', 'nonexistent@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await page.screenshot({ path: result.capturas.during });
        
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle2' })
        ]);

        // PASO 2 - VERIFICACIÓN
        const url = page.url();
        await page.screenshot({ path: result.capturas.after, fullPage: true });

        // Evaluamos si apareció el error y no ingresó al dashboard
        const pageText = await page.content();
        const hasErrorElement = pageText.includes('Estas credenciales no coinciden') || pageText.includes('These credentials do not match');

        if (url.includes('/login') && hasErrorElement) {
            result.estado = "Exitoso";
            result.resultado_obtenido = "Sistema permaneció en login y mostró mensaje de error de credenciales válido al no encontrar el usuario.";
        } else if (url.includes('/dashboard')) {
            result.estado = "Fallido";
            result.resultado_obtenido = "Peligro de Seguridad: El sistema permitió el acceso con un usuario no registrado.";
        } else {
            result.estado = "Fallido";
            result.resultado_obtenido = "Permaneció en login pero no se visualizó el mensaje de error esperado.";
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
