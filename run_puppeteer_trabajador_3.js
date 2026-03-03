import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';

const BASE_URL = 'http://localhost:8000';
const TASK_ID = 20;
const OTHER_TASK_ID = 21;

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

        console.log('Logging in...');
        await page.goto(BASE_URL + '/login', { waitUntil: 'domcontentloaded' });
        await delay(500);
        await page.type('input[name="email"]', 'trabajador1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
        ]);
        await delay(1000);

        // CP-TRB-012
        console.log('Running CP-TRB-012...');
        await page.goto(BASE_URL + '/worker/tasks/' + TASK_ID, { waitUntil: 'domcontentloaded' });
        await delay(500);
        const inputUpload1 = await page.$('input#initial_evidence_images');
        await inputUpload1.uploadFile(path.resolve('test_image.jpg'));
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
            page.evaluate(() => document.querySelector('form[action*="tasks"]').submit()),
        ]);
        await delay(1000);
        await page.goto(BASE_URL + '/worker/tasks/' + TASK_ID, { waitUntil: 'domcontentloaded' });
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-012.png' });

        // CP-TRB-014
        console.log('Running CP-TRB-014...');
        await page.waitForSelector('textarea[name="final_description"]', { visible: true });
        await page.type('textarea[name="final_description"]', 'Some text');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
            page.evaluate(() => document.querySelector('form[action*="tasks"]').submit()),
        ]);
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-014.png' });

        // CP-TRB-015
        console.log('Running CP-TRB-015...');
        await page.evaluate(() => document.querySelector('textarea[name="final_description"]').value = '');

        const inputUploadErr = await page.$('input#final_evidence_images');
        await inputUploadErr.uploadFile(path.resolve('test_doc.pdf'));
        await page.type('textarea[name="final_description"]', 'Some text');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
            page.evaluate(() => document.querySelector('form[action*="tasks"]').submit()),
        ]);
        await delay(1000);
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-015.png' });

        await page.goto(BASE_URL + '/worker/tasks/' + TASK_ID, { waitUntil: 'domcontentloaded' });
        await delay(500);

        // CP-TRB-013 & CP-TRB-016
        console.log('Running CP-TRB-013 and CP-TRB-016...');
        const inputUploadFinal = await page.$('input#final_evidence_images');
        await inputUploadFinal.uploadFile(path.resolve('test_image.jpg'));
        // clear textarea first
        await page.evaluate(() => document.querySelector('textarea[name="final_description"]').value = '');
        await page.type('textarea[name="final_description"]', 'Trabajo finalizado con éxito');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
            page.evaluate(() => document.querySelector('form[action*="tasks"]').submit()),
        ]);
        await delay(1000);
        await page.goto(BASE_URL + '/worker/tasks/' + TASK_ID, { waitUntil: 'domcontentloaded' });
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-013.png' });
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-016.png' });

        // CP-TRB-017
        console.log('Running CP-TRB-017...');
        await page.goto(BASE_URL + '/worker/tasks/' + OTHER_TASK_ID, { waitUntil: 'domcontentloaded' });
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-017.png' });

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error in tests:', e);
    } finally {
        await browser.close();
    }
})();
