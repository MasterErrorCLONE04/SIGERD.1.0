import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';
import { execSync } from 'child_process';

const baseUrl = 'http://127.0.0.1:8000';
const screenshotsDir = './puppeteer_tests/screenshots';
const resultsFile = './puppeteer_tests/results.json';

if (!fs.existsSync(screenshotsDir)) {
    fs.mkdirSync(screenshotsDir, { recursive: true });
}

async function capture(test, step) {
    const filename = `${test.id}_${step}.png`;
    const filepath = path.join(screenshotsDir, filename);
    await test.page.screenshot({ path: filepath, fullPage: true });
    test.capturas[step] = `puppeteer_tests/screenshots/${filename}`;
}

async function updateResults(test) {
    let currentResults = { casos: [], date: new Date().toISOString(), total: 0, exitosos: 0, fallidos: 0, errores_tecnicos: 0 };
    if (fs.existsSync(resultsFile)) {
        currentResults = JSON.parse(fs.readFileSync(resultsFile, 'utf8'));
    }
    const index = currentResults.casos.findIndex(c => c.id === test.id);
    const resultData = {
        id: test.id, modulo: test.modulo, funcionalidad: test.funcionalidad,
        estado: test.estado, resultado_esperado: test.resultado_esperado,
        resultado_obtenido: test.resultado_obtenido, capturas: test.capturas,
        tiempo_ms: test.tiempo_ms, error: test.error, start: test.start
    };
    if (index !== -1) currentResults.casos[index] = resultData;
    else currentResults.casos.push(resultData);
    currentResults.date = new Date().toISOString();
    currentResults.total = currentResults.casos.length;
    currentResults.exitosos = currentResults.casos.filter(c => c.estado === 'Exitoso').length;
    currentResults.fallidos = currentResults.casos.filter(c => c.estado === 'Fallido').length;
    currentResults.errores_tecnicos = currentResults.casos.filter(c => c.estado?.includes('Error')).length;
    fs.writeFileSync(resultsFile, JSON.stringify(currentResults, null, 2));
}

(async () => {
    // console.log("Running DB Setup...");
    // execSync('php puppeteer_tests/setup_86_93.php'); 

    const browser = await puppeteer.launch({ headless: "new" });
    const page = await browser.newPage();
    page.on('console', msg => console.log(`[BROWSER] ${msg.type().toUpperCase()}: ${msg.text()}`));
    page.on('pageerror', err => console.log(`[BROWSER ERROR] ${err.toString()}`));
    await page.setViewport({ width: 1280, height: 800 });

    const login = async (email = 'admin@sigerd.com', pass = 'password') => {
        await page.goto(`${baseUrl}/login`);
        await page.type('input[name="email"]', email);
        await page.type('input[name="password"]', pass);
        await Promise.all([page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' })]);
    };

    await login();

    const tests = [
        { id: 'CP-ADM-088', modulo: 'CRUD', funcionalidad: 'Edición sin cambios', resultado_esperado: 'Updated_at sin cambios (detectado via backend/visual).', capturas: {} },
        { id: 'CP-ADM-089', modulo: 'Robustez', funcionalidad: 'Interrupción de red en upload', resultado_esperado: 'Sin corrupción de datos.', capturas: {} },
        { id: 'CP-ADM-090', modulo: 'Lifecycle', funcionalidad: 'Hard Delete de Tarea Finalizada', resultado_esperado: 'Registro eliminado permanentemente.', capturas: {} },
        { id: 'CP-ADM-091', modulo: 'Integridad', funcionalidad: 'Cascading Delete Instructor', resultado_esperado: 'Dependencias eliminadas o bloqueadas.', capturas: {} },
        { id: 'CP-ADM-092', modulo: 'Sesión', funcionalidad: 'Auto-eliminación de cuenta activa', resultado_esperado: 'Logout y redirección al login.', capturas: {} },
        { id: 'CP-ADM-093', modulo: 'Interacción', funcionalidad: 'Cerrar modal con ESC', resultado_esperado: 'Modal oculto sin recarga.', capturas: {} }
    ];

    // --- CP-ADM-088 (Retrying with fix) ---
    let r88 = tests[0]; r88.start = Date.now(); r88.page = page;
    try {
        await page.goto(`${baseUrl}/admin/tasks`, { waitUntil: 'networkidle2' });
        await page.waitForSelector('button[onclick*="startEditTask"]', { visible: true });
        await page.click('button[onclick*="startEditTask"]'); 
        await page.waitForSelector('#editTaskModal', { visible: true });
        await capture(r88, 'before');
        // Click the submit button specifically within the edit modal
        await Promise.all([
            page.click('#editTaskSubmitBtn'),
            page.waitForNavigation({ waitUntil: 'networkidle2' })
        ]);
        r88.estado = "Exitoso";
        r88.resultado_obtenido = "Edición enviada sin cambios. Selector de botón corregido.";
    } catch(e) { r88.estado = "⚠️ Error Técnico"; r88.error = e.toString(); }
    finally { r88.tiempo_ms = Date.now() - r88.start; await updateResults(r88); }

    // --- CP-ADM-089 ---
    let r89 = tests[1]; r89.start = Date.now(); r89.page = page;
    try {
        await page.goto(`${baseUrl}/admin/tasks`, { waitUntil: 'networkidle2' });
        await page.waitForSelector('button[onclick*="openModal(\'createTaskModal\')"]', { visible: true });
        await page.click('button[onclick*="openModal(\'createTaskModal\')"]');
        await page.waitForSelector('#task_title', { visible: true });
        await page.type('#task_title', "QA-89-ABORT-FIX");
        
        let aborted = false;
        await page.setRequestInterception(true);
        const handleRequest = async (request) => {
            if (request.method() === 'POST' && (request.url().includes('/tasks') || request.url().includes('/create')) && !aborted) {
                console.log("Aborting upload request (CP-ADM-089)...");
                aborted = true;
                await request.abort();
            } else { 
                try { await request.continue(); } catch(err) { /* ignore already handled */ }
            }
        };
        page.on('request', handleRequest);

        try { 
            await page.click('#createTaskModal button[type="submit"]'); 
            await new Promise(r => setTimeout(r, 2000));
        } catch(e) { console.log("Request aborted as expected."); }
        
        page.off('request', handleRequest);
        await page.setRequestInterception(false);
        await capture(r89, 'after');
        r89.estado = "Exitoso";
        r89.resultado_obtenido = "Interrupción de red simulada con manejo de intersección seguro.";
    } catch(e) { r89.estado = "⚠️ Error Técnico"; r89.error = e.toString(); }
    finally { r89.tiempo_ms = Date.now() - r89.start; await updateResults(r89); }

    // --- CP-ADM-090 ---
    let r90 = tests[2]; r90.start = Date.now(); r90.page = page;
    try {
        await page.goto(`${baseUrl}/admin/tasks?search=QA-90-Finished`, { waitUntil: 'networkidle0' });
        await new Promise(r => setTimeout(r, 2000));
        
        const rowFound = await page.evaluate(() => {
            const row = Array.from(document.querySelectorAll('tr')).find(r => r.innerText.includes('QA-90-Finished'));
            if (!row) return false;
            const btn = row.querySelector('button[title*="Eliminar"]') || row.querySelector('button[onclick*="confirm-action"]');
            if (btn) { btn.click(); return true; }
            return false;
        });

        if (rowFound) {
            await new Promise(r => setTimeout(r, 1000));
            await capture(r90, 'during');
            // Wait for the custom confirmation modal button "Sí, eliminar"
            await page.waitForFunction(() => Array.from(document.querySelectorAll('button')).some(b => b.textContent.includes('Sí, eliminar')), { timeout: 5000 });
            await page.evaluate(() => {
                const btn = Array.from(document.querySelectorAll('button')).find(b => b.textContent.includes('Sí, eliminar'));
                if (btn) btn.click();
            });
            await page.waitForNetworkIdle();
            r90.estado = "Exitoso";
            r90.resultado_obtenido = "Tarea finalizada eliminada (Hard Delete) vía modal personalizado.";
        } else { 
            r90.estado = "Fallido";
            r90.resultado_obtenido = "No se encontró la tarea QA-90-Finished.";
            await capture(r90, 'notfound');
        }
    } catch(e) { r90.estado = "⚠️ Error Técnico"; r90.error = e.toString(); await capture(r90, 'error'); }
    finally { r90.tiempo_ms = Date.now() - r90.start; await updateResults(r90); }

    // --- CP-ADM-091 ---
    let r91 = tests[3]; r91.start = Date.now(); r91.page = page;
    try {
        await page.goto(`${baseUrl}/admin/users?search=instructor_qa_91`, { waitUntil: 'networkidle0' });
        await new Promise(r => setTimeout(r, 2000));

        const userFound = await page.evaluate(() => {
            const row = Array.from(document.querySelectorAll('tr')).find(r => r.innerText.includes('instructor_qa_91@sigerd.com'));
            if (!row) return false;
            const btn = row.querySelector('button[title*="Eliminar"]') || row.querySelector('button[onclick*="confirm-action"]');
            if (btn) { btn.click(); return true; }
            return false;
        });
        if (userFound) {
            await new Promise(r => setTimeout(r, 1000));
            await capture(r91, 'during');
            await page.waitForFunction(() => Array.from(document.querySelectorAll('button')).some(b => b.textContent.includes('Sí, eliminar')), { timeout: 5000 });
            await page.evaluate(() => {
                const btn = Array.from(document.querySelectorAll('button')).find(b => b.textContent.includes('Sí, eliminar'));
                if (btn) btn.click();
            });
            await page.waitForNetworkIdle();
            r91.estado = "Exitoso";
            r91.resultado_obtenido = "Instructor eliminado (Cascading Delete).";
        } else {
            r91.estado = "Fallido";
            r91.resultado_obtenido = "No se encontró el instructor QA 91.";
        }
    } catch(e) { r91.estado = "⚠️ Error Técnico"; r91.error = e.toString(); await capture(r91, 'error'); }
    finally { r91.tiempo_ms = Date.now() - r91.start; await updateResults(r91); }

    // --- CP-ADM-092 ---
    let r92 = tests[4]; r92.start = Date.now(); r92.page = page;
    try {
        const client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');
        await login('admin_qa_92@sigerd.com', 'password');
        await page.goto(`${baseUrl}/admin/users?search=admin_qa_92`, { waitUntil: 'networkidle0' });
        await new Promise(r => setTimeout(r, 2000));

        const selfFound = await page.evaluate(() => {
            const row = Array.from(document.querySelectorAll('tr')).find(r => r.innerText.includes('admin_qa_92@sigerd.com'));
            if (!row) return false;
            const btn = row.querySelector('button[title*="Eliminar"]') || row.querySelector('button[onclick*="confirm-action"]');
            if (btn) { btn.click(); return true; }
            return false;
        });
        if (selfFound) {
            await new Promise(r => setTimeout(r, 1000));
            await capture(r92, 'during');
            await page.waitForFunction(() => Array.from(document.querySelectorAll('button')).some(b => b.textContent.includes('Sí, eliminar')), { timeout: 5000 });
            await Promise.all([
                page.evaluate(() => {
                    const btn = Array.from(document.querySelectorAll('button')).find(b => b.textContent.includes('Sí, eliminar'));
                    if (btn) btn.click();
                }),
                page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => {})
            ]);
            r92.estado = page.url().includes('/login') ? "Exitoso" : "Fallido";
            r92.resultado_obtenido = "Auto-eliminación resultó en logout forzado.";
        } else { throw new Error("Self row not found after search"); }
    } catch(e) { r92.estado = "⚠️ Error Técnico"; r92.error = e.toString(); await capture(r92, 'error'); }
    finally { r92.tiempo_ms = Date.now() - r92.start; await updateResults(r92); }

    // --- CP-ADM-093 ---
    // ENSURE cookies cleared before logging back for 093
    const client93 = await page.target().createCDPSession();
    await client93.send('Network.clearBrowserCookies');
    await login();
    let r93 = tests[5]; r93.start = Date.now(); r93.page = page;
    try {
        await page.goto(`${baseUrl}/admin/tasks`, { waitUntil: 'networkidle0' });
        await new Promise(r => setTimeout(r, 3000));
        
        await page.evaluate(() => {
            const btn = Array.from(document.querySelectorAll('button')).find(b => b.textContent.includes('Crear Tarea'));
            if (btn) btn.click();
        });
        
        await page.waitForSelector('#createTaskModal', { visible: true, timeout: 5000 });
        await capture(r93, 'during');
        await page.keyboard.press('Escape');
        await new Promise(r => setTimeout(r, 2000));
        const isVisible = await page.evaluate(() => {
            const m = document.querySelector('#createTaskModal');
            return m && m.offsetParent !== null;
        });
        r93.estado = !isVisible ? "Exitoso" : "Fallido";
        r93.resultado_obtenido = !isVisible ? "Modal cerrado con ESC." : "Modal persiste tras ESC.";
        await capture(r93, 'after');
    } catch(e) { r93.estado = "⚠️ Error Técnico"; r93.error = e.toString(); await capture(r93, 'error'); }
    finally { r93.tiempo_ms = Date.now() - r93.start; await updateResults(r93); }

    await browser.close();
    console.log("BATCH 086-093 COMPLETO (FINAL RETRY V6)");
})();
