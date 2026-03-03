import puppeteer from 'puppeteer';
import path from 'path';
import fs from 'fs';

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

        console.log('Navigating to task 20...');
        await page.goto(BASE_URL + '/worker/tasks/' + TASK_ID, { waitUntil: 'networkidle0' });

        console.log('Uploading file...');
        const inputUpload1 = await page.$('input#initial_evidence_images');
        await inputUpload1.uploadFile(path.resolve('test_image.jpg'));

        console.log('Submitting form...');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch((e) => { console.log("Timeout waiting for nav:", e.message) }),
            page.evaluate(() => document.querySelector('form[action*="tasks"]').submit())
        ]);

        console.log('Navigation completed. Current URL:', page.url());

        console.log('Navigating to task 20 again to check state...');
        await page.goto(BASE_URL + '/worker/tasks/' + TASK_ID, { waitUntil: 'networkidle0' });

        const hasTextarea = await page.evaluate(() => document.querySelector('textarea[name="final_description"]') !== null);
        console.log('Has final_description textarea?', hasTextarea);

    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
    }
})();
