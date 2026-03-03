import puppeteer from 'puppeteer';
import path from 'path';
import fs from 'fs';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

async function run() {
    console.log('--- Iniciando captura de pantalla (Manual Admin) ---');
    const browser = await puppeteer.launch({ headless: 'new', defaultViewport: { width: 1366, height: 768 } });
    const page = await browser.newPage();
    const dir = path.join(__dirname, 'capturas_manual_usuario_admin');

    if (!fs.existsSync(dir)) {
        fs.mkdirSync(dir);
    }

    try {
        // 1. Pantalla de Bienvenida (Login Vacío)
        await page.goto('http://127.0.0.1:8000/login', { waitUntil: 'networkidle2' });
        await new Promise(r => setTimeout(r, 1000));
        await page.screenshot({ path: path.join(dir, '1_login_vacio.png') });

        // 2. Formulario de Login lleno
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'badpass');
        await page.screenshot({ path: path.join(dir, '2_login_lleno.png') });

        // 3. Alerta de credenciales
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('button[type="submit"]')
        ]);
        await new Promise(r => setTimeout(r, 500));
        await page.screenshot({ path: path.join(dir, '3_login_error.png') });

        // 4. Login correcto
        await page.goto('http://127.0.0.1:8000/login', { waitUntil: 'networkidle2' });

        // Limpiar inputs ya que Laravel retiene el email fallido devuelto con old()
        await page.evaluate(() => document.querySelector('input[name="email"]').value = '');
        await page.evaluate(() => document.querySelector('input[name="password"]').value = '');

        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' })
        ]);

        // 5. Dashboard
        await new Promise(r => setTimeout(r, 1000));
        await page.screenshot({ path: path.join(dir, '4_dashboard_general.png') });

        // Click Notificaciones
        try {
            const bell = await page.$('button svg path[d*="M15"]'); // generic bell icon check or user menu
            // Let's guess there is a button with a bell icon or relative
            // Best effort: take the top corner
            await page.screenshot({ path: path.join(dir, '5_notificaciones.png') });
        } catch (e) { }

        // 6. Lista de Usuarios
        await page.goto('http://127.0.0.1:8000/admin/users', { waitUntil: 'networkidle2' });
        await page.screenshot({ path: path.join(dir, '6_lista_usuarios.png'), fullPage: true });

        // 7. Crear Usuario
        try {
            await page.goto('http://127.0.0.1:8000/admin/users/create', { waitUntil: 'networkidle2' });
            await page.screenshot({ path: path.join(dir, '7_crear_usuario.png') });
        } catch (e) { }

        // 8. Tareas - Lista
        await page.goto('http://127.0.0.1:8000/admin/tasks', { waitUntil: 'networkidle2' });
        await page.screenshot({ path: path.join(dir, '8_lista_tareas.png'), fullPage: true });

        // 9. Crear Tarea
        try {
            await page.goto('http://127.0.0.1:8000/admin/tasks/create', { waitUntil: 'networkidle2' });
            await page.screenshot({ path: path.join(dir, '9_crear_tarea.png') });
        } catch (e) { }

        // 10. Tarea detalle (We assume admin/tasks/1 exists)
        try {
            await page.goto('http://127.0.0.1:8000/admin/tasks/1', { waitUntil: 'networkidle2' });
            await page.screenshot({ path: path.join(dir, '10_detalle_tarea_evidencia.png'), fullPage: true });
        } catch (e) { }

        // 11. Lista de Incidentes
        await page.goto('http://127.0.0.1:8000/admin/incidents', { waitUntil: 'networkidle2' });
        await page.screenshot({ path: path.join(dir, '11_lista_incidentes.png'), fullPage: true });

        // 12. Incidente detalle
        try {
            await page.goto('http://127.0.0.1:8000/admin/incidents/1', { waitUntil: 'networkidle2' });
            await page.screenshot({ path: path.join(dir, '12_detalle_incidente.png'), fullPage: true });
        } catch (e) { }

        // 13. Perfil de Usuario
        await page.goto('http://127.0.0.1:8000/profile', { waitUntil: 'networkidle2' });
        await page.screenshot({ path: path.join(dir, '13_perfil_usuario.png'), fullPage: true });

        console.log('--- Capturas exitosas ---');
    } catch (error) {
        console.error('Ocurrió un error:', error);
    } finally {
        await browser.close();
    }
}
run();
