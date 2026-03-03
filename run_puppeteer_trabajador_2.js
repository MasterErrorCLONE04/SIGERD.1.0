import puppeteer from 'puppeteer';
import fs from 'fs';

const BASE_URL = 'http://localhost:8000';

(async () => {
    if (!fs.existsSync('puppeter_test_trabajador')) {
        fs.mkdirSync('puppeter_test_trabajador', { recursive: true });
    }

    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    const delay = ms => new Promise(res => setTimeout(res, ms));

    try {
        let client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');

        // Login as a worker with tasks (trabajador1)
        console.log('Logging in as trabajador1...');
        await page.goto(BASE_URL + '/login', { waitUntil: 'domcontentloaded' });
        await delay(500);
        await page.type('input[name="email"]', 'trabajador1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
        ]);
        await delay(1000);

        // CP-TRB-007: Carga correcta de métricas del dashboard
        console.log('Running CP-TRB-007...');
        await page.goto(BASE_URL + '/dashboard', { waitUntil: 'domcontentloaded' });
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-007.png' });

        // CP-TRB-009: Visualización exclusiva de tareas asignadas
        console.log('Running CP-TRB-009...');
        await page.goto(BASE_URL + '/worker/tasks', { waitUntil: 'domcontentloaded' });
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-009.png' });

        // CP-TRB-010: Búsqueda de tarea por palabra clave
        console.log('Running CP-TRB-010...');
        await page.waitForSelector('input[name="search"]', { visible: true });
        await page.type('input[name="search"]', 'a'); // Type 'a'
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
        ]);
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-010.png' });

        // CP-TRB-011: Filtrado de tareas por estado
        console.log('Running CP-TRB-011...');
        // Clear search first
        await page.goto(BASE_URL + '/worker/tasks', { waitUntil: 'domcontentloaded' });
        await delay(500);
        await page.select('select[name="status"]', 'en progreso'); // Select status
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
        ]);
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-011.png' });

        // Logout
        await client.send('Network.clearBrowserCookies');

        // CP-TRB-008: Dashboard con métricas en cero
        console.log('Running CP-TRB-008...');
        await page.goto(BASE_URL + '/login', { waitUntil: 'domcontentloaded' });
        await delay(500);
        await page.type('input[name="email"]', 'trabajador_zero@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
        ]);
        await delay(1000);
        await page.goto(BASE_URL + '/dashboard', { waitUntil: 'domcontentloaded' });
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-008.png' });

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error in tests:', e);
    } finally {
        await browser.close();
    }
})();
