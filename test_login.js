import puppeteer from 'puppeteer';

async function test() {
    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    try {
        await page.goto('http://127.0.0.1:8000/login', { waitUntil: 'networkidle2' });

        await page.evaluate(() => document.querySelector('input[name="email"]').value = '');
        await page.evaluate(() => document.querySelector('input[name="password"]').value = '');

        await page.type('input[name="email"]', 'admin@example.com');
        await page.type('input[name="password"]', 'password');

        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' })
        ]);

        console.log("Current URL:", page.url());

        const content = await page.content();
        if (content.includes('Inicio de sesión seguro') || content.includes('Estas credenciales no coinciden')) {
            console.log("FAILED to log in. Form error detected.");
            // Print out the specific error if possible
            const error = await page.evaluate(() => {
                const err = document.querySelector('.text-red-500, .text-sm.text-red-600');
                return err ? err.innerText : 'No explicit error element found.';
            });
            console.log("Error text:", error);
        } else {
            console.log("Logged in successfully! Reached:", page.url());
        }
    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
    }
}
test();
