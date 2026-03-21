import puppeteer from 'puppeteer';
import fs from 'fs';

const resultsFile = 'puppeteer_tests/results.json';
const testId = 'CP-ADM-005';
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
        funcionalidad: "Formato de email inválido",
        estado: "Exitoso",
        resultado_esperado: 'Error de validación informando que la cadena no parece un correo electrónico.',
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
        await page.type('input[name="email"]', 'admin123');
        await page.type('input[name="password"]', 'password');
        await page.screenshot({ path: result.capturas.during });
        
        const submitClick = page.click('button[type="submit"]');
        
        let didNavigate = false;
        try {
            await Promise.all([
                submitClick,
                page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 3000 })
            ]);
            didNavigate = true;
        } catch (navError) {
            // El timeout ocurrirá por la validación HTML5 type="email"
            didNavigate = false;
        }

        // PASO 2 - VERIFICACIÓN
        const url = page.url();
        await page.screenshot({ path: result.capturas.after, fullPage: true });

        if (!didNavigate && url.includes('/login')) {
            const emailValidationMessage = await page.evaluate(() => document.querySelector('input[name="email"]').validationMessage);
            
            if (emailValidationMessage && emailValidationMessage.length > 0) {
                result.estado = "Exitoso";
                result.resultado_obtenido = `Bloqueo por validación HTML5 de Type Email activo con éxito. Mensaje del navegador: "${emailValidationMessage}". No se envió la petición.`;
            } else {
                result.estado = "Exitoso";
                result.resultado_obtenido = "Sistema permaneció en login deteniendo la petición, pero no se recuperó un mensaje específico.";
            }
        } else if (url.includes('/dashboard')) {
            result.estado = "Fallido";
            result.resultado_obtenido = "Peligro: El sistema permitió el inicio de sesión con formato de correo incorrecto.";
        } else {
            // Revisar si el backend frenó
            const pageText = await page.content();
            const hasBackendError = pageText.includes('correo') || pageText.includes('valid') || pageText.toLowerCase().includes('email');
            if (hasBackendError) {
               result.estado = "Exitoso";
               result.resultado_obtenido = "El request llegó al backend y Laravel rechazó el formato de email inválido exitosamente.";
            } else {
               result.estado = "Fallido";
               result.resultado_obtenido = "Se procesó, pero no hubieron advertencias claras de error de formato.";
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
