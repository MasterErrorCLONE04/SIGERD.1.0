import puppeteer from 'puppeteer';
import path from 'path';

const BASE_URL = 'http://localhost:8000';
const TASK_ID = 20;

(async () => {
    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    try {
        await page.goto(BASE_URL + '/login', { waitUntil: 'domcontentloaded' });
        await page.type('input[name="email"]', 'trabajador1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
        ]);

        await page.goto(BASE_URL + '/worker/tasks/' + TASK_ID, { waitUntil: 'domcontentloaded' });
        console.log("Before upload, status is: ");
        const statusEl = await page.evaluate(() => document.body.innerText);
        if (statusEl.includes('Asignado')) console.log("Task is ASIGNADO");

        const inputUpload1 = await page.$('input#initial_evidence_images');
        await inputUpload1.uploadFile(path.resolve('test_image.jpg'));
        await Promise.all([
            page.click('form[action*="tasks"] button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
        ]);

        const errors = await page.evaluate(() => {
            const errEls = document.querySelectorAll('.text-red-600, .text-red-500');
            return Array.from(errEls).map(e => e.innerText);
        });
        console.log("Validation Errors:", errors);

        await page.screenshot({ path: 'puppeter_test_trabajador/DEBUG.png' });
    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
    }
})();
