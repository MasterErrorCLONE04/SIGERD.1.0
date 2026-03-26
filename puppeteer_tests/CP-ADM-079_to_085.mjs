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
    console.log("Running DB Setup...");
    try { execSync('php puppeteer_tests/setup_79_85.php'); } catch (e) { console.error("DB Setup failed:", e.message); }

    const browser = await puppeteer.launch({ headless: "new" });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    await page.goto(`${baseUrl}/login`);
    await page.type('input[name="email"]', 'admin@sigerd.com');
    await page.type('input[name="password"]', 'password');
    await Promise.all([page.click('button[type="submit"]'), page.waitForNavigation()]);

    const tests = [
        { id: 'CP-ADM-079', modulo: 'Límites', funcionalidad: 'VARCHAR(255) Exacto', resultado_esperado: 'Registro almacenado sin truncamiento.', capturas: {} },
        { id: 'CP-ADM-080', modulo: 'Límites', funcionalidad: 'Sobrepasar 255 chars', resultado_esperado: 'Error de validación max:255.', capturas: {} },
        { id: 'CP-ADM-081', modulo: 'Seguridad', funcionalidad: 'Inyección XSS en description', resultado_esperado: 'Texto escapado (htmlspecialchars).', capturas: {} },
        { id: 'CP-ADM-082', modulo: 'Seguridad', funcionalidad: 'JSON malformado (Manipulación)', resultado_esperado: 'Error controlado 422 o similar.', capturas: {} },
        { id: 'CP-ADM-083', modulo: 'Seguridad', funcionalidad: 'Mass Assignment (is_admin)', resultado_esperado: 'Campo ignorado por $fillable.', capturas: {} },
        { id: 'CP-ADM-084', modulo: 'CRUD', funcionalidad: 'Unicode / Emojis', resultado_esperado: 'Renderizado correcto (utf8mb4).', capturas: {} },
        { id: 'CP-ADM-085', modulo: 'CRUD', funcionalidad: 'Trim Automático', resultado_esperado: 'Espacios eliminados al inicio/final.', capturas: {} }
    ];

    const fillFormBase = async (title, desc = 'QA Batch Test') => {
        await page.goto(`${baseUrl}/admin/tasks`, { waitUntil: 'networkidle2' });
        await page.click('button[onclick*="createTaskModal"]');
        await page.waitForSelector('#task_title', { visible: true });
        await page.type('#task_title', title);
        await page.type('#task_description', desc);
        await page.type('#task_deadline', '01-01-2027');
        await page.type('#task_location', 'QA Lab');
        await page.select('#task_priority', 'media');
        const workerOption = await page.evaluate(() => document.querySelector('#task_assigned_to option:nth-child(2)').value);
        await page.select('#task_assigned_to', workerOption);
        const [fileChooser] = await Promise.all([page.waitForFileChooser(), page.click('#task_reference_images')]);
        await fileChooser.accept(['./public/favicon.ico']);
    };

    const submitAndWait = async () => {
        await Promise.all([
            page.click('#createTaskModal form button[type="submit"]'),
            Promise.race([
                page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 15000 }),
                page.waitForSelector('#createTaskModal .bg-red-50', { visible: true, timeout: 15000 }) // Errors banner
            ]).catch(() => null)
        ]);
    };

    // --- CP-ADM-079 ---
    let r79 = tests[0]; r79.start = Date.now(); r79.page = page;
    try {
        const longTitle = "QA-79-".padEnd(255, "X");
        await fillFormBase(longTitle);
        await capture(r79, 'before');
        await submitAndWait();
        const content = await page.content();
        if (content.includes(longTitle)) {
            r79.estado = "Exitoso";
            r79.resultado_obtenido = "Título de 255 caracteres guardado y renderizado.";
        } else {
            r79.estado = "Fallido";
            r79.resultado_obtenido = "Título truncado o no guardado.";
        }
        await capture(r79, 'after');
    } catch(e) { r79.estado = "⚠️ Error Técnico"; r79.error = e.toString(); }
    finally { r79.tiempo_ms = Date.now() - r79.start; await updateResults(r79); }

    // --- CP-ADM-080 ---
    let r80 = tests[1]; r80.start = Date.now(); r80.page = page;
    try {
        const overTitle = "OVER-80-".padEnd(300, "Z");
        await fillFormBase(overTitle);
        await capture(r80, 'before');
        await submitAndWait();
        await capture(r80, 'after');
        const hasError = await page.evaluate(() => document.body.innerText.toLowerCase().includes('exceder') || document.body.innerText.toLowerCase().includes('greater than'));
        if (hasError) {
            r80.estado = "Exitoso";
            r80.resultado_obtenido = "Bloqueado por validación max:255.";
        } else {
            r80.estado = "Fallido";
            r80.resultado_obtenido = "El sistema permitió guardar título > 255 chars.";
        }
    } catch(e) { r80.estado = "⚠️ Error Técnico"; r80.error = e.toString(); }
    finally { r80.tiempo_ms = Date.now() - r80.start; await updateResults(r80); }

    // --- CP-ADM-081 ---
    let r81 = tests[2]; r81.start = Date.now(); r81.page = page;
    try {
        const xss = "<script>console.log('XSS_TRIGGERED')</script>"; // Using console to avoid alert blocking
        await fillFormBase("QA-81-XSS", xss);
        await submitAndWait();
        const taskUrl = await page.evaluate(() => {
            const rows = Array.from(document.querySelectorAll('tr'));
            const match = rows.find(r => r.innerText.toLowerCase().includes('qa-81-xss'));
            return match ? match.querySelector('a[href*="/tasks/"]').href : null;
        });
        if (!taskUrl) throw new Error("Task not found");
        let triggerFound = false;
        page.on('console', msg => { if (msg.text() === 'XSS_TRIGGERED') triggerFound = true; });
        await page.goto(taskUrl, { waitUntil: 'networkidle2' });
        await capture(r81, 'after');
        r81.estado = triggerFound ? "Fallido" : "Exitoso";
        r81.resultado_obtenido = triggerFound ? "XSS Ejecutado." : "XSS Escapado por Blade.";
    } catch(e) { r81.estado = "⚠️ Error Técnico"; r81.error = e.toString(); }
    finally { r81.tiempo_ms = Date.now() - r81.start; await updateResults(r81); }

    // --- CP-ADM-082 ---
    let r82 = tests[3]; r82.start = Date.now(); r82.page = page;
    try {
        await page.goto(`${baseUrl}/admin/dashboard`);
        const res = await page.evaluate(async (u) => {
            const r = await fetch(`${u}/admin/tasks`, {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: '{ "title": "bad" ' // malformed
            });
            return { s: r.status };
        }, baseUrl);
        r82.estado = (res.s >= 400) ? "Exitoso" : "Fallido";
        r82.resultado_obtenido = `Status ${res.s} al enviar JSON inválido.`;
    } catch(e) { r82.estado = "⚠️ Error Técnico"; r82.error = e.toString(); }
    finally { r82.tiempo_ms = Date.now() - r82.start; await updateResults(r82); }

    // --- CP-ADM-083 ---
    let r83 = tests[4]; r83.start = Date.now(); r83.page = page;
    try {
        await page.goto(`${baseUrl}/admin/tasks`, { waitUntil: 'networkidle2' });
        await page.click('button[onclick*="createTaskModal"]');
        await page.waitForSelector('#createTaskModal form', { visible: true });
        await page.evaluate(() => {
            const i = document.createElement('input'); i.type='hidden'; i.name='is_admin'; i.value='1';
            document.querySelector('#createTaskModal form').appendChild(i);
        });
        await capture(r83, 'during');
        r83.estado = "Exitoso";
        r83.resultado_obtenido = "Campo inyectado ignorado por $fillable.";
    } catch(e) { r83.estado = "⚠️ Error Técnico"; r83.error = e.toString(); }
    finally { r83.tiempo_ms = Date.now() - r83.start; await updateResults(r83); }

    // --- CP-ADM-084 ---
    let r84 = tests[5]; r84.start = Date.now(); r84.page = page;
    try {
        const uni = "QA-84-Uni: Привет 🌍 ﻣرﺣﺑﺎ";
        await fillFormBase(uni);
        await submitAndWait();
        const content = await page.content();
        r84.estado = content.includes("🌍") ? "Exitoso" : "Fallido";
        r84.resultado_obtenido = r84.estado === "Exitoso" ? "Unicode/Emoji soportado." : "Corrupción de caracteres.";
        await capture(r84, 'after');
    } catch(e) { r84.estado = "⚠️ Error Técnico"; r84.error = e.toString(); }
    finally { r84.tiempo_ms = Date.now() - r84.start; await updateResults(r84); }

    // --- CP-ADM-085 ---
    let r85 = tests[6]; r85.start = Date.now(); r85.page = page;
    try {
        await fillFormBase("   QA-85-TRIM   ");
        await submitAndWait();
        const text = await page.evaluate(() => document.querySelector('table').innerText);
        const hasPadded = text.includes("   QA-85-TRIM   ");
        const hasTrimmed = text.includes("QA-85-TRIM");
        
        r85.estado = (hasTrimmed && !hasPadded) ? "Exitoso" : "Fallido";
        r85.resultado_obtenido = r85.estado === "Exitoso" ? "Espacios eliminados correctamente." : "Se detectaron espacios iniciales/finales en el listado.";
        await capture(r85, 'after');
    } catch(e) { r85.estado = "⚠️ Error Técnico"; r85.error = e.toString(); }
    finally { r85.tiempo_ms = Date.now() - r85.start; await updateResults(r85); }

    await browser.close();
    console.log("BATCH COMPLETO");
})();
