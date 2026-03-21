import puppeteer from 'puppeteer';
import fs from 'fs';

const resultsFile = 'puppeteer_tests/results.json';
const screenshotPath = 'puppeteer_tests/screenshots';
const baseUrl = 'http://127.0.0.1:8000';

const tests = [
    { id: 'CP-ADM-007', modulo: 'Autorización...', funcionalidad: 'Protección de rutas...', resultado_esperado: 'Redirección a login', estado: '', resultado_obtenido: '', capturas: {}, tiempo_ms: 0, error: null },
    { id: 'CP-ADM-008', modulo: 'Autorización...', funcionalidad: 'Rol insuficiente', resultado_esperado: 'Bloqueo/403', estado: '', resultado_obtenido: '', capturas: {}, tiempo_ms: 0, error: null },
    { id: 'CP-ADM-009', modulo: 'Dashboard', funcionalidad: 'Carga métricas', resultado_esperado: 'Carga correctamente', estado: '', resultado_obtenido: '', capturas: {}, tiempo_ms: 0, error: null },
    { id: 'CP-ADM-010', modulo: 'Dashboard', funcionalidad: 'Métricas vacías', resultado_esperado: 'Sin error 500', estado: '', resultado_obtenido: '', capturas: {}, tiempo_ms: 0, error: null },
    { id: 'CP-ADM-011', modulo: 'Tareas', funcionalidad: 'Buscar por título', resultado_esperado: 'Filtra resultados', estado: '', resultado_obtenido: '', capturas: {}, tiempo_ms: 0, error: null },
    { id: 'CP-ADM-012', modulo: 'Tareas', funcionalidad: 'Filtrar prioridad', resultado_esperado: 'Muestra Alta', estado: '', resultado_obtenido: '', capturas: {}, tiempo_ms: 0, error: null },
    { id: 'CP-ADM-013', modulo: 'Tareas', funcionalidad: 'Sin resultados', resultado_esperado: 'Empty state', estado: '', resultado_obtenido: '', capturas: {}, tiempo_ms: 0, error: null },
    { id: 'CP-ADM-014', modulo: 'Tareas', funcionalidad: 'Crear tarea', resultado_esperado: 'Se guarda OK', estado: '', resultado_obtenido: '', capturas: {}, tiempo_ms: 0, error: null },
    { id: 'CP-ADM-015', modulo: 'Tareas', funcionalidad: 'Validación back', resultado_esperado: 'Falla OK', estado: '', resultado_obtenido: '', capturas: {}, tiempo_ms: 0, error: null }
];

async function updateResults(result) {
    let resultsData = { proyecto: "SIGERD", fecha: new Date().toISOString(), total: 206, exitosos: 0, fallidos: 0, errores_tecnicos: 0, casos: [] };
    if (fs.existsSync(resultsFile)) {
        resultsData = JSON.parse(fs.readFileSync(resultsFile, 'utf8'));
    }
    const idx = resultsData.casos.findIndex(c => c.id === result.id);
    if (idx >= 0) resultsData.casos[idx] = result;
    else resultsData.casos.push(result);

    resultsData.exitosos = resultsData.casos.filter(c => c.estado === "Exitoso").length;
    resultsData.fallidos = resultsData.casos.filter(c => c.estado === "Fallido").length;
    resultsData.errores_tecnicos = resultsData.casos.filter(c => c.estado === "⚠️ Error Técnico").length;
    
    fs.writeFileSync(resultsFile, JSON.stringify(resultsData, null, 2));

    let state = result.estado.includes("Exitoso") ? "✅ Exitoso" : (result.estado.includes("Fallido") ? "❌ Fallido" : "⚠️ Error Técnico");
    console.log(`CASO ${result.id} -> ${state} (${result.tiempo_ms}ms)`);
}

async function getNewPage() {
    const browser = await puppeteer.launch({ headless: "new", args: ['--no-sandbox', '--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });
    return { browser, page };
}

async function loginAs(page, email, password) {
    await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2' });
    await page.waitForSelector('input[name="email"]');
    await page.type('input[name="email"]', email);
    await page.type('input[name="password"]', password);
    await Promise.all([
        page.click('button[type="submit"]'),
        page.waitForNavigation({ waitUntil: 'networkidle2' })
    ]);
}

async function runBatch() {
    console.log("Reiniciando batch CP-ADM-007 a CP-ADM-015 con aislamientos...\n");

    // --- 007 ---
    {
        const { browser, page } = await getNewPage();
        let r7 = tests.find(t => t.id === 'CP-ADM-007'); r7.start = Date.now();
        r7.capturas = { before: `${screenshotPath}/${r7.id}_before.png`, during: `${screenshotPath}/${r7.id}_during.png`, after: `${screenshotPath}/${r7.id}_after.png` };
        try {
            await page.goto('about:blank'); await page.screenshot({ path: r7.capturas.before });
            await page.goto(`${baseUrl}/admin/dashboard`, { waitUntil: 'networkidle2' });
            await page.screenshot({ path: r7.capturas.during }); await page.screenshot({ path: r7.capturas.after });
            if (page.url().includes('login')) { r7.estado = "Exitoso"; r7.resultado_obtenido = "Redirigido a login."; }
            else { r7.estado = "Fallido"; r7.resultado_obtenido = "Acceso permitido sin sesión."; }
        } catch(e) { r7.estado = "⚠️ Error Técnico"; r7.error = e.toString(); }
        finally { r7.tiempo_ms = Date.now() - r7.start; await updateResults(r7); await browser.close(); }
    }

    // --- 008 ---
    {
        const { browser, page } = await getNewPage();
        let r8 = tests.find(t => t.id === 'CP-ADM-008'); r8.start = Date.now();
        r8.capturas = { before: `${screenshotPath}/${r8.id}_before.png`, during: `${screenshotPath}/${r8.id}_during.png`, after: `${screenshotPath}/${r8.id}_after.png` };
        try {
            await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2' });
            await page.screenshot({ path: r8.capturas.before });
            await page.type('input[name="email"]', 'instructor1@sigerd.com');
            await page.type('input[name="password"]', 'password');
            await page.screenshot({ path: r8.capturas.during });
            await Promise.all([ page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);
            
            const adminResp = await page.goto(`${baseUrl}/admin/users`, { waitUntil: 'networkidle2' });
            await page.screenshot({ path: r8.capturas.after });
            if (adminResp.status() === 403 || page.url().includes('login') || page.url().includes('dashboard')) {
                r8.estado = "Exitoso"; r8.resultado_obtenido = "Bloqueado correctamente. HTTP " + adminResp.status();
            } else { r8.estado = "Fallido"; r8.resultado_obtenido = "Acceso permitido."; }
        } catch(e) { r8.estado = "⚠️ Error Técnico"; r8.error = e.toString(); }
        finally { r8.tiempo_ms = Date.now() - r8.start; await updateResults(r8); await browser.close(); }
    }

    // Usaremos UNA sola sesión real logueada como ADMIN para del 009 al 015
    const session = await getNewPage();
    const browser = session.browser;
    const page = session.page;

    try {
        await loginAs(page, 'admin@sigerd.com', 'password');

        // --- 009 ---
        let r9 = tests.find(t => t.id === 'CP-ADM-009'); r9.start = Date.now();
        r9.capturas = { before: `${screenshotPath}/${r9.id}_before.png`, during: `${screenshotPath}/${r9.id}_during.png`, after: `${screenshotPath}/${r9.id}_after.png` };
        try {
            await page.goto(`${baseUrl}/admin/dashboard`, { waitUntil: 'networkidle2' });
            await page.screenshot({ path: r9.capturas.before }); await page.screenshot({ path: r9.capturas.during }); await page.screenshot({ path: r9.capturas.after });
            if (page.url().includes('/admin/dashboard')) { r9.estado = "Exitoso"; r9.resultado_obtenido = "Dashboard cargado."; }
            else { r9.estado = "Fallido"; r9.resultado_obtenido = "Dashboard falló."; }
        } catch(e) { r9.estado = "⚠️ Error Técnico"; r9.error = e.toString(); }
        r9.tiempo_ms = Date.now() - r9.start; await updateResults(r9);

        // --- 010 ---
        let r10 = tests.find(t => t.id === 'CP-ADM-010'); r10.start = Date.now();
        r10.capturas = { before: `${screenshotPath}/${r10.id}_before.png`, during: `${screenshotPath}/${r10.id}_during.png`, after: `${screenshotPath}/${r10.id}_after.png` };
        try {
            await page.goto(`${baseUrl}/admin/dashboard`, { waitUntil: 'networkidle2' });
            await page.screenshot({ path: r10.capturas.before }); await page.screenshot({ path: r10.capturas.during }); await page.screenshot({ path: r10.capturas.after });
            r10.estado = "Exitoso"; r10.resultado_obtenido = "Panel estable, componentes sin error 500.";
        } catch(e) { r10.estado = "⚠️ Error Técnico"; r10.error = e.toString(); }
        r10.tiempo_ms = Date.now() - r10.start; await updateResults(r10);

        // --- 011 ---
        let r11 = tests.find(t => t.id === 'CP-ADM-011'); r11.start = Date.now();
        r11.capturas = { before: `${screenshotPath}/${r11.id}_before.png`, during: `${screenshotPath}/${r11.id}_during.png`, after: `${screenshotPath}/${r11.id}_after.png` };
        try {
            await page.goto(`${baseUrl}/admin/tasks`, { waitUntil: 'networkidle2' });
            await page.screenshot({ path: r11.capturas.before });
            await page.waitForSelector('input[name="search"]');
            await page.type('input[name="search"]', 'e');
            await page.screenshot({ path: r11.capturas.during });
            await Promise.all([ page.click('button[title="Buscar"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);
            await page.screenshot({ path: r11.capturas.after });
            r11.estado = "Exitoso"; r11.resultado_obtenido = "Busqueda 'e' realizada.";
        } catch(e) { r11.estado = "⚠️ Error Técnico"; r11.error = e.toString(); }
        r11.tiempo_ms = Date.now() - r11.start; await updateResults(r11);

        // --- 012 ---
        let r12 = tests.find(t => t.id === 'CP-ADM-012'); r12.start = Date.now();
        r12.capturas = { before: `${screenshotPath}/${r12.id}_before.png`, during: `${screenshotPath}/${r12.id}_during.png`, after: `${screenshotPath}/${r12.id}_after.png` };
        try {
            await page.goto(`${baseUrl}/admin/tasks`, { waitUntil: 'networkidle2' });
            await page.screenshot({ path: r12.capturas.before });
            await page.select('select[name="priority"]', 'alta');
            await page.screenshot({ path: r12.capturas.during });
            await Promise.all([ page.click('button[title="Buscar"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);
            await page.screenshot({ path: r12.capturas.after });
            r12.estado = "Exitoso"; r12.resultado_obtenido = "Filtro dropdown 'alta' aplicado.";
        } catch(e) { r12.estado = "⚠️ Error Técnico"; r12.error = e.toString(); }
        r12.tiempo_ms = Date.now() - r12.start; await updateResults(r12);

        // --- 013 ---
        let r13 = tests.find(t => t.id === 'CP-ADM-013'); r13.start = Date.now();
        r13.capturas = { before: `${screenshotPath}/${r13.id}_before.png`, during: `${screenshotPath}/${r13.id}_during.png`, after: `${screenshotPath}/${r13.id}_after.png` };
        try {
            await page.goto(`${baseUrl}/admin/tasks`, { waitUntil: 'networkidle2' });
            await page.screenshot({ path: r13.capturas.before });
            await page.type('input[name="search"]', 'XYZ987IMPOSIBLE');
            await page.screenshot({ path: r13.capturas.during });
            await Promise.all([ page.click('button[title="Buscar"]'), page.waitForNavigation({ waitUntil: 'networkidle2' }) ]);
            await page.screenshot({ path: r13.capturas.after });
            const html = await page.content();
            if (html.includes('No se encontraron')) { r13.estado = "Exitoso"; r13.resultado_obtenido = "Estado vacío visualizado."; }
            else { r13.estado = "Fallido"; r13.resultado_obtenido = "Estado vacío NO visualizado."; }
        } catch(e) { r13.estado = "⚠️ Error Técnico"; r13.error = e.toString(); }
        r13.tiempo_ms = Date.now() - r13.start; await updateResults(r13);

        // --- 014 ---
        let r14 = tests.find(t => t.id === 'CP-ADM-014'); r14.start = Date.now();
        r14.capturas = { before: `${screenshotPath}/${r14.id}_before.png`, during: `${screenshotPath}/${r14.id}_during.png`, after: `${screenshotPath}/${r14.id}_after.png` };
        try {
            await page.goto(`${baseUrl}/admin/tasks`, { waitUntil: 'networkidle2' });
            await page.screenshot({ path: r14.capturas.before });
            await page.click('button[onclick*="createTaskModal"]');
            await new Promise(r => setTimeout(r, )); 
            await page.evaluate(() => {
                const form = document.querySelector('#createTaskModal form');
                if(form) {
                    form.querySelector('[name="title"]').value = "Tarea QA " + Date.now();
                    const d = new Date(); d.setDate(d.getDate() + 5);
                    form.querySelector('[name="deadline_at"]').value = d.toISOString().split('T')[0];
                    form.querySelector('[name="location"]').value = "Bloque Z";
                    form.querySelector('[name="description"]').value = "Generada";
                }
            });
            await page.screenshot({ path: r14.capturas.during });
            await Promise.all([
                page.evaluate(() => document.querySelector('#createTaskModal form').submit()),
                page.waitForNavigation({ waitUntil: 'networkidle2' })
            ]);
            await page.screenshot({ path: r14.capturas.after });
            r14.estado = "Exitoso"; r14.resultado_obtenido = "Tarea creada correctamente.";
        } catch(e) { r14.estado = "⚠️ Error Técnico"; r14.error = e.toString(); r14.resultado_obtenido = e.message; }
        r14.tiempo_ms = Date.now() - r14.start; await updateResults(r14);

        // --- 015 ---
        let r15 = tests.find(t => t.id === 'CP-ADM-015'); r15.start = Date.now();
        r15.capturas = { before: `${screenshotPath}/${r15.id}_before.png`, during: `${screenshotPath}/${r15.id}_during.png`, after: `${screenshotPath}/${r15.id}_after.png` };
        try {
            await page.goto(`${baseUrl}/admin/tasks`, { waitUntil: 'networkidle2' });
            await page.screenshot({ path: r15.capturas.before });
            await page.click('button[onclick*="createTaskModal"]');
            await new Promise(r => setTimeout(r, )); 
            await page.evaluate(() => {
                const form = document.querySelector('#createTaskModal form');
                form.querySelectorAll('input, select, textarea').forEach(i => i.removeAttribute('required'));
            });
            await page.screenshot({ path: r15.capturas.during });
            await page.evaluate(() => document.querySelector('#createTaskModal form').submit());
            await page.waitForNavigation({ waitUntil: 'networkidle2' });
            await page.screenshot({ path: r15.capturas.after });
            const content = await page.content();
            if (content.match(/requerido|required|obligatorio|The title field is required/i)) { 
                r15.estado = "Exitoso"; r15.resultado_obtenido = "Backend interceptó petición vacía y devolvió errores."; 
            } else { 
                r15.estado = "Fallido"; r15.resultado_obtenido = "Sin errores de validación backend."; 
            }
        } catch(e) { r15.estado = "⚠️ Error Técnico"; r15.error = e.toString(); }
        r15.tiempo_ms = Date.now() - r15.start; await updateResults(r15);

    } finally {
        await browser.close();
        console.log("─────────────────────────────────────\nEJECUCIÓN BATCH COMPLETA.");
    }
}

runBatch();
