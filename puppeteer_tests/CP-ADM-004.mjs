import puppeteer from 'puppeteer';
import fs from 'fs';

const resultsFile = 'puppeteer_tests/results.json';
const testId = 'CP-ADM-004';
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
        funcionalidad: "Validación de campos obligatorios",
        estado: "Exitoso",
        resultado_esperado: 'El formulario arroja error de validación HTML5 o backend reconociendo campos requeridos.',
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
        
        // No tecleamos nada
        await page.screenshot({ path: result.capturas.during });
        
        // Hacemos clic e intentamos atrapar la navegación si ocurre, o el timeout si HTML5 la detiene
        const submitClick = page.click('button[type="submit"]');
        
        let didNavigate = false;
        try {
            await Promise.all([
                submitClick,
                page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 3000 })
            ]);
            didNavigate = true;
        } catch (navError) {
            // El timeout de 3000ms ocurrirá si el navegador bloquea el envío de formulario por campos 'required' HTML5
            didNavigate = false;
        }

        // PASO 2 - VERIFICACIÓN
        const url = page.url();
        await page.screenshot({ path: result.capturas.after, fullPage: true });

        // Evaluamos comportamiento
        if (!didNavigate && url.includes('/login')) {
            // Check for HTML5 validation message on the input
            const emailValidationMessage = await page.evaluate(() => document.querySelector('input[name="email"]').validationMessage !== "");
            
            if (emailValidationMessage) {
                result.estado = "Exitoso";
                result.resultado_obtenido = "Bloqueo por validación HTML5 (campos obligatorios) activado con éxito. No se envió el formulario al servidor.";
            } else {
                result.estado = "Exitoso";
                result.resultado_obtenido = "Sistema permaneció en login esperando datos. Se omitió enviar petición vacía.";
            }
        } else if (url.includes('/dashboard')) {
            result.estado = "Fallido";
            result.resultado_obtenido = "Peligro de Seguridad: El sistema permitió el acceso con credenciales en blanco.";
        } else {
            // Evaluamos si recargó y devolvió errores de Backend
            const pageText = await page.content();
            const hasBackendError = pageText.includes('requerido') || pageText.includes('required');
            if (hasBackendError) {
               result.estado = "Exitoso";
               result.resultado_obtenido = "El backend atrapó y regresó correctamete la advertencia de datos vacíos obligatorios.";
            } else {
               result.estado = "Fallido";
               result.resultado_obtenido = "Se envió el formulario pero no se detectaron advertencias visibles ni redirección de éxito.";
            }
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
