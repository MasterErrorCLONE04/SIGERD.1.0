import puppeteer from 'puppeteer'; 
import * as fs from 'fs';
import * as path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const resultsDir = 'C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\screenshots';
const baseUrl = 'http://127.0.0.1:8000';

async function capture(page, tcId, mom) {
    const p = path.join(resultsDir, `${tcId}_${mom}.png`);
    await page.screenshot({ path: p, fullPage: true });
    console.log(`[CAPTURED] ${tcId}_${mom}`);
}

(async () => {
    const browser = await puppeteer.launch({ headless: "new", args: ['--no-sandbox', '--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    try {
        await page.goto(`${baseUrl}/login`, { waitUntil: 'load' });
        await page.type('input[name="email"]', 'admin@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([ page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'load' }) ]);

        // 039
        console.log("039 surgical...");
        await page.goto(`${baseUrl}/admin/users`, { waitUntil: 'load' });
        await page.type('input[name="search"]', 'qatest@sigerd.com');
        await page.keyboard.press('Enter');
        await page.waitForFunction(() => document.body.innerText.includes('qatest@sigerd.com'), { timeout: 10000 });
        await page.evaluate(() => {
            const btns = Array.from(document.querySelectorAll('button'));
            const del = btns.find(b => b.innerHTML.includes('trash') || b.classList.contains('text-red-600'));
            del.click();
        });
        await new Promise(r => setTimeout(r, 2000));
        await capture(page, 'CP-ADM-039', 'during');
        await page.evaluate(() => {
            const b = Array.from(document.querySelectorAll('button')).find(x => x.innerText.trim() === 'Sí, eliminar');
            b.click();
        });
        await new Promise(r => setTimeout(r, 4000));
        await capture(page, 'CP-ADM-039', 'after');

        // 046
        console.log("046 surgical...");
        await page.goto(`${baseUrl}/admin/incidents`, { waitUntil: 'load' });
        await page.click('tr a[href*="/admin/incidents/"]');
        await page.waitForNavigation({ waitUntil: 'load' });
        await page.select('#assigned_to', '2');
        await page.evaluate(() => {
            const b = Array.from(document.querySelectorAll('button')).find(x => x.innerText.includes('CONVERTIR A TAREA') || x.innerText.includes('Convertir'));
            b.click();
        });
        await new Promise(r => setTimeout(r, 2000));
        await page.evaluate(() => {
            const b = Array.from(document.querySelectorAll('button')).find(x => x.innerText.trim() === 'Sí, convertir' || x.innerText.trim() === 'Convertir');
            b.click();
        });
        await new Promise(r => setTimeout(r, 6000));
        await capture(page, 'CP-ADM-046', 'after');

    } catch(e) { console.error(e); }
    finally { await browser.close(); console.log("V15 DONE"); }
})();
