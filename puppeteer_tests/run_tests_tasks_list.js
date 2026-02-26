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

    try {
        console.log("Login Admin...");
        await page.goto(`${BASE_URL}/login`);
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('button[type="submit"]')
        ]);

        console.log("CP-ADM-011");
        await page.goto(`${BASE_URL}/admin/tasks`, { waitUntil: 'networkidle0' });
        // Buscar por una letra común para asegurar algún resultado si hay tareas
        await page.type('input[name="search"]', 'e');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.keyboard.press('Enter')
        ]);
        await capture('CP-ADM-011');

        console.log("CP-ADM-012");
        await page.goto(`${BASE_URL}/admin/tasks`, { waitUntil: 'networkidle0' });
        // Seleccionar prioridad Alta
        await page.select('select[name="priority"]', 'alta');
        // El select no hace auto-submit en este caso así que le damos submit al forms
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.click('button[title="Buscar"]')
        ]);
        await capture('CP-ADM-012');

        console.log("CP-ADM-013");
        await page.goto(`${BASE_URL}/admin/tasks`, { waitUntil: 'networkidle0' });
        // Búsqueda basura para que no haya coincidencias
        await page.type('input[name="search"]', 'XYZ987IMPOSIBLE');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
            page.keyboard.press('Enter')
        ]);
        await capture('CP-ADM-013');

        console.log("Completado");
    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
    }
})();
