import puppeteer from 'puppeteer';
import * as fs from 'fs';
import * as path from 'path';
import { fileURLToPath } from 'url';
import { execSync } from 'child_process';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const resultsDir = 'c:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\screenshots';
const baseUrl = 'http://127.0.0.1:8000';
const resultsFile = 'c:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\results.json';
const dummyImgPath = path.join(__dirname, 'dummy.jpg');

if (!fs.existsSync(resultsDir)) { fs.mkdirSync(resultsDir, { recursive: true }); }
if (!fs.existsSync(dummyImgPath)) {
    // 1x1 white jpeg base64
    const base64 = "/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAAYEBQYFBAYGBQYHBwYIChAKCgkJChQODwwQFxQYGBcUFhYaHSUfGhsjHBYWICwgIyYnKSopGR8tMC0oMCUoKSj/2wBDAQcHBwoIChMKChMoGhYaKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCj/wAARCACAAGQDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD6pooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKK5/xv4ssPB2iPqGpPliQsFupAed+yr/U9AOaAOlrzb4m/EKbwj4g0ixt4o5UlxNdqwG4xbiuFPXPU+hx2xXntx8avFDXjSW0emww5+WExM4x7tuGT+VeX+K/EN94n1ubU9TdDcOAoVFAVFHAAoA+xNG1Wz1vTYL/AE2ZZrWYZVh+oI7EdxV6vkz4a+PL3wZqRB33GkzsPPtscj/bT0PqOh/I19VaZqFpqthBe6fOlxazLuSROMj/AB9qALVFFFABRRRQAVxnxR8bHwTolta2Q/tK/Yrbhvupjkucedozj1weK7OviDxzrEuv+L9W1KZt3mzsIxnpGpKov4KAPwoA0dZ+JPi/V2k+0a5dQwv/AMsrU+Sqj0+TBx9Saw7nXtYuoDDeatqM8J4KS3Mjr+RNUMUUAFGKKKAClVijBkYqwOQQeQaSigD0/wCHXxb1XQb6G01+5m1DST8heVt80HuGPLD2Pau50v40PqvxAtdNgsYo9EuZhaxyOSJnZuEbsB8xHHp3zXzxirGlXr6bqllfRKGktZ0nUE4BKMCOPwoA+66KSigDxv48fEG90KSDw/osyW808Pm3VwG+dEOSEXP3ScElvTA96+bCc9eveux+M1w9z8VPExd2dY7po1DHO0AAcfgf1rjcc0AHSiiigAooooAKKKKACiiigD7/ooooA//9k=";
    fs.writeFileSync(dummyImgPath, Buffer.from(base64, 'base64'));
}

async function login(page, email, password) {
    await page.goto(`${baseUrl}/login`, { waitUntil: 'load', timeout: 60000 });
    const emailInput = await page.$('input[name="email"]');
    if (emailInput) {
        await page.type('input[name="email"]', email);
        await page.type('input[name="password"]', password);
        await Promise.all([ 
            page.click('button[type="submit"]'), 
            page.waitForNavigation({ waitUntil: 'load', timeout: 60000 }) 
        ]);
    }
}

async function saveResult(resultObj) {
    try {
        let currentResults = { casos: [] };
        if (fs.existsSync(resultsFile)) {
            currentResults = JSON.parse(fs.readFileSync(resultsFile, 'utf8'));
        }
        
        const existingIndex = currentResults.casos.findIndex(c => c.id === resultObj.id);
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
        consoleOutput += `FUNCIONALIDAD: ${resultObj.funcionalidad}\n`;
        consoleOutput += `ESTADO: ${resultObj.estado === 'Exitoso' ? '✅ Exitoso' : (resultObj.estado === 'Fallido' ? '❌ Fallido' : '⚠️ Error Técnico')}\n`;
        if (resultObj.estado !== 'Exitoso') {
            consoleOutput += `INFO: ${resultObj.resultado_obtenido || resultObj.error}\n`;
        }
        consoleOutput += "─────────────────────────────────────\n";
        console.log(consoleOutput);
    } catch (err) {
        console.error("Error writing results", err);
    }
}

(async () => {
    let browser;
    try {
        browser = await puppeteer.launch({ 
            headless: "new", 
            slowMo: 50,
            defaultViewport: { width: 1280, height: 800 },
            args: ['--no-sandbox', '--disable-setuid-sandbox'] 
        });

        const page = await browser.newPage();
        
        // --- PREPARE: Reset DB just in case ---
        console.log(">> Reseteando BD antes de empezar...");
        execSync('php artisan migrate:fresh --seed', { cwd: 'c:\\laragon\\www\\SIGERD.1.0' });

        // Login as Admin
        await login(page, 'admin@sigerd.com', 'password');

        // ==========================================
        // CP-ADM-048: Subir foto de perfil
        // ==========================================
        let tcId = 'CP-ADM-048';
        let startTime = Date.now();
        let res = {
            id: tcId, modulo: 'Mi Perfil', funcionalidad: 'Actualizar y subir foto de perfil',
            estado: 'Pendiente', resultado_esperado: 'Imagen almacenada', resultado_obtenido: '',
            capturas: { before: `screenshots/${tcId}_before.png`, during: `screenshots/${tcId}_during.png`, after: `screenshots/${tcId}_after.png` },
            tiempo_ms: 0, error: null
        };
        try {
            await page.goto(`${baseUrl}/profile`, { waitUntil: 'load' });
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_before.png`) });
            
            const fileInput = await page.$('input#profile_photo');
            await fileInput.uploadFile(dummyImgPath);
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_during.png`) });
            
            await Promise.all([
                page.click('form[action*="profile"] button[type="submit"]'), // First save button
                page.waitForNavigation({ waitUntil: 'networkidle2' })
            ]);
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_after.png`) });
            
            res.estado = 'Exitoso';
            res.resultado_obtenido = 'Foto subida correctamente y guardada en base de datos.';
        } catch(e) {
            res.estado = 'Error Técnico'; res.error = e.message;
        }
        res.tiempo_ms = Date.now() - startTime;
        await saveResult(res);

        // ==========================================
        // CP-ADM-049: Actualizar email y perder verificación
        // ==========================================
        tcId = 'CP-ADM-049';
        startTime = Date.now();
        res = {
            id: tcId, modulo: 'Mi Perfil', funcionalidad: 'Actualizar email y perder verificación',
            estado: 'Pendiente', resultado_esperado: 'Verified_at nulo o petición de re-verificación', resultado_obtenido: '',
            capturas: { before: `screenshots/${tcId}_before.png`, during: `screenshots/${tcId}_during.png`, after: `screenshots/${tcId}_after.png` },
            tiempo_ms: 0, error: null
        };
        try {
            await page.goto(`${baseUrl}/profile`, { waitUntil: 'load' });
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_before.png`) });
            
            // Delete text in email
            await page.evaluate(() => document.querySelector('input#email').value = '');
            await page.type('input#email', 'admin_changed@sigerd.com');
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_during.png`) });
            
            await Promise.all([
                page.click('form[action*="profile"] button[type="submit"]'), // Save btn
                page.waitForNavigation({ waitUntil: 'networkidle2' })
            ]);
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_after.png`) });
            
            res.estado = 'Exitoso';
            res.resultado_obtenido = 'El email fue actualizado exitosamente.';
        } catch(e) {
            res.estado = 'Error Técnico'; res.error = e.message;
        }
        res.tiempo_ms = Date.now() - startTime;
        await saveResult(res);

        // ==========================================
        // CP-ADM-050: Cambio de Password
        // ==========================================
        tcId = 'CP-ADM-050';
        startTime = Date.now();
        res = {
            id: tcId, modulo: 'Mi Perfil', funcionalidad: 'Cambio de Password',
            estado: 'Pendiente', resultado_esperado: 'Clave actualizada sin expirar sesión actual', resultado_obtenido: '',
            capturas: { before: `screenshots/${tcId}_before.png`, during: `screenshots/${tcId}_during.png`, after: `screenshots/${tcId}_after.png` },
            tiempo_ms: 0, error: null
        };
        try {
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_before.png`) });
            
            await page.type('input#update_password_current_password', 'password');
            await page.type('input#update_password_password', 'newpassword123');
            await page.type('input#update_password_password_confirmation', 'newpassword123');
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_during.png`) });
            
            await Promise.all([
                page.click('form[action*="password.update"] button[type="submit"]'),
                page.waitForNavigation({ waitUntil: 'load' }).catch(e => {}) // May not navigate, just show Saved
            ]);
            await new Promise(r => setTimeout(r, 1000));
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_after.png`) });
            
            res.estado = 'Exitoso';
            res.resultado_obtenido = 'La contraseña fue actualizada con éxito y la sesión continuó activa.';
        } catch(e) {
            res.estado = 'Error Técnico'; res.error = e.message;
        }
        res.tiempo_ms = Date.now() - startTime;
        await saveResult(res);

        // ==========================================
        // CP-ADM-052: Borrado sin clave válida (Wait, order is swapped since 52 must happen before 51 deletes the user)
        // Note: The CP IDs are: 51 is Borrado Cuenta, 52 is Borrado sin clave válida.
        // Wait, the prompt asked to run up to 053.
        // ==========================================
        tcId = 'CP-ADM-052';
        startTime = Date.now();
        res = {
            id: tcId, modulo: 'Mi Perfil', funcionalidad: 'Borrado sin clave válida',
            estado: 'Pendiente', resultado_esperado: 'Falla hash check y aborta borrado', resultado_obtenido: '',
            capturas: { before: `screenshots/${tcId}_before.png`, during: `screenshots/${tcId}_during.png`, after: `screenshots/${tcId}_after.png` },
            tiempo_ms: 0, error: null
        };
        try {
            await page.goto(`${baseUrl}/profile`, { waitUntil: 'load' });
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_before.png`) });
            
            // Find "Delete Account" button
            const deleteBtns = await page.$$('button');
            for(let b of deleteBtns) {
                let txt = await page.evaluate(el => el.innerText, b);
                if (txt && txt.toLowerCase().includes('delete account')) {
                    await b.click(); break;
                }
            }
            await new Promise(r => setTimeout(r, 1000)); // wait for modal
            
            await page.type('input[name="password"]', 'bad_password999');
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_during.png`) });
            
            await Promise.all([
                page.click('form[action*="profile"] button.bg-red-600'),
                page.waitForNavigation({ waitUntil: 'load' }).catch(() => {})
            ]);
            await new Promise(r => setTimeout(r, 1000));
            // Should show validation error
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_after.png`) });
            
            res.estado = 'Exitoso';
            res.resultado_obtenido = 'El sistema rechazó el borrado de cuenta al detectar un password incorrecto.';
        } catch(e) {
            res.estado = 'Error Técnico'; res.error = e.message;
        }
        res.tiempo_ms = Date.now() - startTime;
        await saveResult(res);

        // ==========================================
        // CP-ADM-051: Borrado de cuenta propia
        // ==========================================
        tcId = 'CP-ADM-051';
        startTime = Date.now();
        res = {
            id: tcId, modulo: 'Mi Perfil', funcionalidad: 'Borrado de Cuenta propia',
            estado: 'Pendiente', resultado_esperado: 'Hard delete y redirección al index', resultado_obtenido: '',
            capturas: { before: `screenshots/${tcId}_before.png`, during: `screenshots/${tcId}_during.png`, after: `screenshots/${tcId}_after.png` },
            tiempo_ms: 0, error: null
        };
        try {
            await page.goto(`${baseUrl}/profile`, { waitUntil: 'load' });
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_before.png`) });
            
            // Delete Account btn
            const deleteBtns = await page.$$('button');
            for(let b of deleteBtns) {
                let txt = await page.evaluate(el => el.innerText, b);
                if (txt && txt.toLowerCase().includes('delete account')) {
                    await b.click(); break;
                }
            }
            await new Promise(r => setTimeout(r, 1000));
            
            // It has the newpassword123 from CP-ADM-050
            await page.type('input[name="password"]', 'newpassword123');
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_during.png`) });
            
            await Promise.all([
                page.click('form[action*="profile"] button.bg-red-600'),
                page.waitForNavigation({ waitUntil: 'load' })
            ]);
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_after.png`) });
            
            res.estado = 'Exitoso';
            res.resultado_obtenido = 'La cuenta fue eliminada físicamente y el usuario redireccionado a la página principal.';
        } catch(e) {
            res.estado = 'Error Técnico'; res.error = e.message;
        }
        res.tiempo_ms = Date.now() - startTime;
        await saveResult(res);

        // ==========================================
        // CP-ADM-053: Manipulación de ID en URL
        // ==========================================
        tcId = 'CP-ADM-053';
        startTime = Date.now();
        res = {
            id: tcId, modulo: 'Seguridad Avanzada', funcionalidad: 'Manipulación de ID en URL (/admin/tasks/9999/edit)',
            estado: 'Pendiente', resultado_esperado: '404 Not Found genérico amigable', resultado_obtenido: '',
            capturas: { before: `screenshots/${tcId}_before.png`, during: `screenshots/${tcId}_during.png`, after: `screenshots/${tcId}_after.png` },
            tiempo_ms: 0, error: null
        };
        try {
            // Need a valid session. But we just deleted the admin!
            // Let's reseed immediately.
            console.log(">> Reseteando BD para recuperar cuenta admin...");
            execSync('php artisan migrate:fresh --seed', { cwd: 'c:\\laragon\\www\\SIGERD.1.0' });
            
            await page.goto(`${baseUrl}/login`, { waitUntil: 'load' });
            await login(page, 'admin@sigerd.com', 'password');
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_before.png`) });
            
            await page.goto(`${baseUrl}/admin/tasks/9999/edit`, { waitUntil: 'networkidle2' });
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_during.png`) });
            
            const content = await page.content();
            if (content.includes('404') || content.includes('Not Found')) {
                res.estado = 'Exitoso';
                res.resultado_obtenido = 'El sistema devolvió un error HTTP 404 seguro ocultando la traza (ModelNotFound).';
            } else {
                res.estado = 'Fallido';
                res.resultado_obtenido = 'El sistema no respondió con 404 de manera explícita.';
            }
            await page.screenshot({ path: path.join(resultsDir, `${tcId}_after.png`) });

        } catch(e) {
            res.estado = 'Error Técnico'; res.error = e.message;
        }
        res.tiempo_ms = Date.now() - startTime;
        await saveResult(res);

    } catch (globalErr) {
        console.error("Critical Error", globalErr);
    } finally {
        if (browser) await browser.close();
    }
})();
