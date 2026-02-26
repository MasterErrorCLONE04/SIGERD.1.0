const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

const BASE_URL = 'http://sigerd.1.0.test';
const SHOTS_DIR = path.join(__dirname, 'screenshots');
if (!fs.existsSync(SHOTS_DIR)) fs.mkdirSync(SHOTS_DIR);

(async () => {
    const browser = await puppeteer.launch({ headless: 'new', args: ['--no-sandbox', '--window-size=1280,800'] });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    const capture = async (name) => {
        await page.screenshot({ path: path.join(SHOTS_DIR, name + '.png') });
    }

    const openModal = async () => {
        await page.goto(`${BASE_URL}/admin/tasks`, { waitUntil: 'networkidle0' });
        await page.click('button[onclick="openModal(\'createTaskModal\')"]');
        await new Promise(r => setTimeout(r, 500));
    };

    try {
        console.log("Login Admin...");
        await page.goto(`${BASE_URL}/login`);
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('button[type="submit"]')
        ]);

        console.log("CP-ADM-014");
        await openModal();
        await page.type('#task_title', 'Mantenimiento Preventivo A/C');
        await page.type('#task_description', 'Revisar filtros y gas del aire acondicionado central.');
        // Set future date
        const futureDate = new Date();
        futureDate.setDate(futureDate.getDate() + 5);
        await page.type('#task_deadline', futureDate.toISOString().split('T')[0]);
        await page.type('#task_location', 'Edificio Principal - Piso 3');
        await page.select('#task_priority', 'media');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('#createTaskModal button[type="submit"]')
        ]);
        await capture('CP-ADM-014');

        console.log("CP-ADM-015");
        await openModal();
        // remove HTML5 validation to trigger backend validation
        await page.evaluate(() => {
            document.querySelector('#task_title').removeAttribute('required');
            document.querySelector('#task_deadline').removeAttribute('required');
            document.querySelector('#task_location').removeAttribute('required');
        });
        await page.type('#task_location', 'Sede Norte'); // Sólo llenamos esto para forzar submit
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => null),
            page.click('#createTaskModal button[type="submit"]')
        ]);
        await new Promise(r => setTimeout(r, 500));
        await capture('CP-ADM-015');

        console.log("CP-ADM-016");
        await openModal();
        await page.type('#task_title', 'Tarea Atrasada Intencional');
        const pastDate = new Date();
        pastDate.setDate(pastDate.getDate() - 1);
        await page.type('#task_deadline', pastDate.toISOString().split('T')[0]);
        await page.type('#task_location', 'Sistema');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('#createTaskModal button[type="submit"]')
        ]);
        await capture('CP-ADM-016');

        console.log("CP-ADM-017");
        await openModal();
        await page.type('#task_title', 'Hack Prioridad');
        await page.type('#task_deadline', futureDate.toISOString().split('T')[0]);
        await page.type('#task_location', 'Sistema');
        await page.evaluate(() => {
            const select = document.querySelector('#task_priority');
            const option = document.createElement('option');
            option.value = 'urgente';
            option.text = 'Urgente (Hack)';
            select.add(option);
            select.value = 'urgente';
        });
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => null),
            page.click('#createTaskModal button[type="submit"]')
        ]);
        await new Promise(r => setTimeout(r, 500));
        await capture('CP-ADM-017');

        console.log("CP-ADM-018");
        await openModal();
        await page.type('#task_title', 'Tarea con Evidencia Válida');
        await page.type('#task_deadline', futureDate.toISOString().split('T')[0]);
        await page.type('#task_location', 'Sede Central');
        const fileInput18 = await page.$('#task_reference_images');
        await fileInput18.uploadFile(path.join(__dirname, 'test_files', 'valid.jpg'));
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('#createTaskModal button[type="submit"]')
        ]);
        await capture('CP-ADM-018');

        console.log("CP-ADM-019");
        await openModal();
        await page.type('#task_title', 'Intento Subir PDF');
        await page.type('#task_deadline', futureDate.toISOString().split('T')[0]);
        await page.type('#task_location', 'Sede Central');
        const fileInput19 = await page.$('#task_reference_images');
        await fileInput19.uploadFile(path.join(__dirname, 'test_files', 'test.pdf'));
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => null),
            page.click('#createTaskModal button[type="submit"]')
        ]);
        await new Promise(r => setTimeout(r, 500));
        await capture('CP-ADM-019');

        console.log("CP-ADM-020");
        await openModal();
        await page.type('#task_title', 'Intento Foto Pesada');
        await page.type('#task_deadline', futureDate.toISOString().split('T')[0]);
        await page.type('#task_location', 'Sede Central');
        const fileInput20 = await page.$('#task_reference_images');
        await fileInput20.uploadFile(path.join(__dirname, 'test_files', 'heavy.jpg'));
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => null),
            page.click('#createTaskModal button[type="submit"]')
        ]);
        await new Promise(r => setTimeout(r, 500));
        await capture('CP-ADM-020');

        console.log("Completado");
    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
    }
})();
