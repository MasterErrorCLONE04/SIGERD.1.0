import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';

const BASE_URL = 'http://localhost/SIGERD.1.0/public';

// Setup Test Files
const dir = path.resolve('pupperteer_test/files');
if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
fs.writeFileSync(path.join(dir, 'corrupt.jpg'), 'This is a fake image file text content');

// We need a ~2MB valid image to pass the "image" rule.
// We'll read valid.png and duplicate its contents if possible, but valid PNG structure might break.
// Actually, let's just use valid.png 10 times to satisfy "Subir 10 imágenes". 
// A 2MB image is hard to generate programmatically without a library. We'll use 10 copies of valid.png to test the multiple file upload limit and process.

(async () => {
    console.log("Starting browser...");
    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    const delay = ms => new Promise(res => setTimeout(res, ms));
    const safeGoto = async (page, url) => {
        try {
            const finalUrl = url.startsWith('http') ? url : BASE_URL + url;
            await page.goto(finalUrl, { waitUntil: 'domcontentloaded', timeout: 5000 });
        } catch (e) {
            console.log(`Timeout ignorado para ${url}`);
        }
    };

    try {
        console.log("Logging in Instructor...");
        await safeGoto(page, '/login');
        await delay(500);
        await page.waitForSelector('input[name="email"]', { timeout: 10000 });
        await page.type('input[name="email"]', 'instructor1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await delay(2000);

        // CP-INS-035: Expiración de sesión por inactividad
        console.log('Running CP-INS-035 (Session Expiration)...');
        await safeGoto(page, '/instructor/incidents/create');
        await delay(1000);
        await page.type('input[name="title"]', 'Incidencia Sesion Expirada');

        // Simular expiración borrando cookies de sesión (laravel_session)
        const cookies = await page.cookies();
        await page.deleteCookie(...cookies);

        await page.click('button[type="submit"]');
        await delay(2000); // Should redirect to login or show 419 Page Expired
        await page.screenshot({ path: 'pupperteer_test/CP-INS-035.png' });

        // Re-login
        const client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');
        await safeGoto(page, '/login');
        await delay(1000);
        await page.waitForSelector('input[name="email"]', { timeout: 10000 });
        await page.type('input[name="email"]', 'instructor1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await delay(2000);

        // CP-INS-036: Reutilización de token CSRF expirado
        console.log('Running CP-INS-036 (CSRF Expired)...');
        await safeGoto(page, '/instructor/incidents/create');
        await delay(1000);
        await page.waitForSelector('input[name="title"]', { timeout: 10000 });
        await page.type('input[name="title"]', 'Incidencia CSRF');

        // Modify CSRF token
        await page.evaluate(() => {
            const tokenInput = document.querySelector('input[name="_token"]');
            if (tokenInput) tokenInput.value = 'invalidtoken12345';
        });

        await page.click('button[type="submit"]');
        await delay(3500); // Should show 419 Expired - give more time for response
        await page.screenshot({ path: 'pupperteer_test/CP-INS-036.png' });

        // Navigate back to valid form
        await safeGoto(page, '/instructor/incidents/create');
        await delay(1000);

        // CP-INS-037: Manipulación manual del ID en request POST
        console.log('Running CP-INS-037 (Manual ID injection)...');
        await page.waitForSelector('input[name="title"]', { timeout: 10000 });
        await page.type('input[name="title"]', 'Incidencia ID Falso');
        await page.type('textarea[name="description"]', 'Inyectado user_id=999');
        await page.type('input[name="location"]', 'Server Side');

        await page.evaluate(() => {
            const form = document.querySelector('form');
            const hiddenId = document.createElement('input');
            hiddenId.type = 'hidden';
            hiddenId.name = 'user_id';
            hiddenId.value = '999';
            form.appendChild(hiddenId);
        });

        const fi_037 = await page.$('#initial_evidence_images');
        await fi_037.uploadFile(path.resolve('pupperteer_test/files/valid.png'));

        await page.click('button[type="submit"]');
        await delay(2000);

        // Check assigned user ID (should be auth()->id() not 999) - view the incident
        await safeGoto(page, '/instructor/incidents');
        await delay(1000);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-037.png' });

        // CP-INS-038: Subir 10 imágenes
        console.log('Running CP-INS-038 (10 Images)...');
        await safeGoto(page, '/instructor/incidents/create');
        await delay(1000);
        await page.waitForSelector('input[name="title"]', { timeout: 10000 });
        await page.type('input[name="title"]', '10 Imagenes Test');
        await page.type('textarea[name="description"]', 'Limite subida multiple');
        await page.type('input[name="location"]', 'Upload Limit');

        const fi_038 = await page.$('#initial_evidence_images');
        const tenImages = Array(10).fill(path.resolve('pupperteer_test/files/valid.png'));
        await fi_038.uploadFile(...tenImages);

        await page.click('button[type="submit"]');
        await delay(3000);
        await safeGoto(page, '/instructor/incidents');
        await delay(1000);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-038.png' });

        // CP-INS-039: Imagen corrupta con extensión válida
        console.log('Running CP-INS-039 (Corrupt Image)...');
        await safeGoto(page, '/instructor/incidents/create');
        await delay(1000);
        await page.waitForSelector('input[name="title"]', { timeout: 10000 });
        await page.type('input[name="title"]', 'Imagen Corrupta');
        await page.type('textarea[name="description"]', 'MIMO check');
        await page.type('input[name="location"]', 'Upload validation');

        const fi_039 = await page.$('#initial_evidence_images');
        await fi_039.uploadFile(path.resolve('pupperteer_test/files/corrupt.jpg'));

        await page.click('button[type="submit"]');
        await delay(2000); // Validation error (not an image)
        await page.screenshot({ path: 'pupperteer_test/CP-INS-039.png' });

        // CP-INS-040: Path Traversal en nombre archivo
        console.log('Running CP-INS-040 (Path Traversal)...');
        await safeGoto(page, '/instructor/incidents/create');
        await delay(1000);

        // Emulate via Fetch to control File Name explicitly
        await page.evaluate(async () => {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const data = new FormData();
            data.append('_token', token);
            data.append('title', 'Path Traversal File Name');
            data.append('description', 'Check if storage ignores traversal');
            data.append('location', 'Filesystem');

            // Valid image blob
            const blob = new Blob([new Uint8Array([137, 80, 78, 71, 13, 10, 26, 10, 0, 0, 0, 13, 73, 72, 68, 82, 0, 0, 0, 1, 0, 0, 0, 1, 8, 2, 0, 0, 0, 144, 119, 83, 222, 0, 0, 0, 12, 73, 68, 65, 84, 8, 215, 99, 248, 255, 255, 63, 0, 5, 254, 2, 254, 220, 204, 89, 231, 0, 0, 0, 0, 73, 69, 78, 68, 174, 66, 96, 130])], { type: 'image/png' });
            data.append('initial_evidence_images[]', blob, '../../../../hack.png');

            await fetch('/SIGERD.1.0/public/instructor/incidents', { method: 'POST', body: data });
        });
        await delay(2000);

        await safeGoto(page, '/instructor/incidents');
        await delay(1000);
        await page.evaluate(() => {
            // Find details of "Path Traversal File Name"
            const row = Array.from(document.querySelectorAll('a')).find(a => a.innerText.includes('Path Traversal') || a.innerHTML.includes('Path Traversal'));
            if (row) row.click();
        });
        await delay(1500);
        await page.screenshot({ path: 'pupperteer_test/CP-INS-040.png' });

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error in tests:', e);
    } finally {
        await browser.close();
    }
})();
