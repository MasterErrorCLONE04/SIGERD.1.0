import puppeteer from 'puppeteer';
import * as fs from 'fs';
import * as path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const resultsDir = 'C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\screenshots';
const fixtureDir = 'C:\\laragon\\www\\SIGERD.1.0\\puppeteer_tests\\fixtures';
const baseUrl = 'http://127.0.0.1:8000';

if (!fs.existsSync(resultsDir)) { fs.mkdirSync(resultsDir, { recursive: true }); }

async function login(page, email, password) {
    await page.goto(`${baseUrl}/login`, { waitUntil: 'load', timeout: 60000 });
    await page.waitForSelector('input[name="email"]');
    await page.type('input[name="email"]', email);
    await page.type('input[name="password"]', password);
    await Promise.all([ 
        page.click('button[type="submit"]'), 
        page.waitForNavigation({ waitUntil: 'load', timeout: 60000 }) 
    ]);
}

(async () => {
    const tcId = 'CP-ADM-047';
    console.log(`\nEJECUCIÓN DIRECTA ${tcId}...\n`);
    
    const browser = await puppeteer.launch({ 
        headless: "new", 
        slowMo: 100, 
        args: ['--no-sandbox', '--disable-setuid-sandbox'] 
    });

    const testTitle = `Direct Notif ${Date.now()}`;
    let success = false;

    try {
        // STEP 1: CREATE
        const ctx1 = await browser.createBrowserContext();
        const p1 = await ctx1.newPage();
        await login(p1, 'instructor1@sigerd.com', 'password');
        await p1.goto(`${baseUrl}/instructor/incidents`, { waitUntil: 'load' });
        await p1.evaluate(() => Array.from(document.querySelectorAll('a, button')).find(el => el.innerText.includes('Reportar Nueva Falla')).click());
        await p1.waitForSelector('#createIncidentModal', { visible: true });
        await p1.evaluate((t) => {
            document.getElementById('incident_title').value = t;
            document.getElementById('incident_description').value = 'Test directo.';
            document.getElementById('incident_location').value = 'Lab';
            document.getElementById('incident_title').dispatchEvent(new Event('input', { bubbles: true }));
        }, testTitle);
        await (await p1.$('#incident_evidence_images')).uploadFile(path.join(fixtureDir, 'valid.jpg'));
        await new Promise(r => setTimeout(r, 1000));
        await Promise.all([ p1.evaluate(() => document.querySelector('#createIncidentModal form').submit()), p1.waitForNavigation({ waitUntil: 'load' }) ]);
        console.log(`- Created: ${testTitle}`);
        await ctx1.close();

        // STEP 2: CONVERT (DIRECT SUBMIT)
        const ctx2 = await browser.createBrowserContext();
        const p2 = await ctx2.newPage();
        await p2.setViewport({ width: 1280, height: 1200 });
        await login(p2, 'admin@sigerd.com', 'password');
        await p2.goto(`${baseUrl}/admin/incidents`, { waitUntil: 'load' });
        await p2.evaluate((t) => Array.from(document.querySelectorAll('tr')).find(r => r.innerText.includes(t)).querySelector('a').click(), testTitle);
        await p2.waitForNavigation({ waitUntil: 'load' });

        await p2.waitForSelector('#assigned_to');
        await p2.select('#assigned_to', '2'); 
        await p2.select('#priority', 'alta');
        await p2.evaluate(() => { if (document.getElementById('deadline_at')) document.getElementById('deadline_at').value = '2026-12-31'; });
        
        await p2.screenshot({ path: path.join(resultsDir, `${tcId}_during.png`), fullPage: true });
        console.log("- Submitting form directly...");
        await Promise.all([
            p2.evaluate(() => {
                const form = document.querySelector('form[id^="convert-to-task-"]');
                form.submit();
            }),
            p2.waitForNavigation({ waitUntil: 'load', timeout: 90000 })
        ]);
        console.log("- Converted.");
        await ctx2.close();

        // STEP 3: WORKER
        const ctx3 = await browser.createBrowserContext();
        const p3 = await ctx3.newPage();
        await login(p3, 'trabajador1@sigerd.com', 'password');
        await new Promise(r => setTimeout(r, 15000));
        await p3.evaluate(() => {
            const bellBtn = Array.from(document.querySelectorAll('button')).find(b => b.innerHTML.includes('M15 17h5l-1.405-1.405'));
            if (bellBtn) bellBtn.click();
        });
        await new Promise(r => setTimeout(r, 8000));
        await p3.screenshot({ path: path.join(resultsDir, `${tcId}_after.png`), fullPage: true });
        const wkOk = await p3.evaluate(() => document.body.innerText.includes('Nueva Tarea Asignada'));
        await ctx3.close();

        // STEP 4: INSTRUCTOR
        const ctx4 = await browser.createBrowserContext();
        const p4 = await ctx4.newPage();
        await login(p4, 'instructor1@sigerd.com', 'password');
        await new Promise(r => setTimeout(r, 15000));
        await p4.evaluate(() => {
            const bellBtn = Array.from(document.querySelectorAll('button')).find(b => b.innerHTML.includes('M15 17h5l-1.405-1.405'));
            if (bellBtn) bellBtn.click();
        });
        await new Promise(r => setTimeout(r, 8000));
        const insOk = await p4.evaluate(() => document.body.innerText.includes('Incidente Convertido a Tarea'));
        await ctx4.close();

        success = wkOk && insOk;
        console.log(`\nFinal: Worker=${wkOk} Instructor=${insOk}`);

    } catch (e) {
        console.error("\nERROR:", e.message);
    } finally {
        await browser.close();
        console.log("\nStatus:", success ? "SUCCESS" : "FAILURE");
    }
})();
