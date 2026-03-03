import puppeteer from 'puppeteer';
import { execSync } from 'child_process';
import path from 'path';
import fs from 'fs';

const BASE_URL = 'http://localhost:8000';

const delay = ms => new Promise(res => setTimeout(res, ms));

const seedNotification = (type) => {
    console.log(`Seeding notification: ${type}`);
    execSync(`php c:/laragon/www/SIGERD.1.0/seed_notifications.php ${type}`);
};

(async () => {
    if (!fs.existsSync('puppeter_test_trabajador')) {
        fs.mkdirSync('puppeter_test_trabajador', { recursive: true });
    }

    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 800 });

    try {
        console.log('Logging in...');
        await page.goto(BASE_URL + '/login', { waitUntil: 'domcontentloaded' });
        await page.type('input[name="email"]', 'trabajador1@sigerd.com');
        await page.type('input[name="password"]', 'password');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => { }),
        ]);

        console.log('--- NOTIFICATIONS ---');

        // CP-TRB-018: Assigned Task
        seedNotification('task_assigned');
        await page.reload({ waitUntil: 'domcontentloaded' });
        await delay(1000);
        await page.click('div[x-data*="notificationDropdown"] button'); // Open bell
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-018.png' });
        await page.keyboard.press('Escape'); // Close bell
        await delay(500);

        // CP-TRB-019: Rejected Task
        seedNotification('task_rejected');
        await page.reload({ waitUntil: 'domcontentloaded' });
        await delay(1000);
        await page.click('div[x-data*="notificationDropdown"] button');
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-019.png' });
        await page.keyboard.press('Escape');
        await delay(500);

        // CP-TRB-020: Approved Task
        seedNotification('task_approved');
        await page.reload({ waitUntil: 'domcontentloaded' });
        await delay(1000);
        await page.click('div[x-data*="notificationDropdown"] button');
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-020.png' });

        // CP-TRB-021: Mark as read
        // Bell is open, click the notification (which has @click="markAsRead")
        await page.evaluate(() => {
            const items = document.querySelectorAll('.cursor-pointer');
            for (const item of items) {
                if (item.innerHTML.includes('Tarea') || item.innerHTML.includes('markAsRead')) {
                    item.click();
                    break;
                }
            }
        });
        await delay(1500); // UI re-renders, redirects or handles ajax
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-021.png' });


        console.log('--- APPEARANCE ---');
        // CP-TRB-022: Theme change
        await page.goto(BASE_URL + '/worker/dashboard', { waitUntil: 'domcontentloaded' });
        await delay(1000);
        // Find the toggleTheme button in the header and click it
        const themeButton = await page.$('button[x-on\\:click="toggleTheme"]');
        if (themeButton) {
            await themeButton.click();
            await delay(1000);
            await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-022.png' });
            // Click again to return to default or let it be dark
        } else {
            // Some alpine toggle looks like @click="toggleTheme()"
            await page.evaluate(() => {
                const btn = document.querySelector('button[click*="toggleTheme"]');
                if (btn) btn.click();
            });
            await delay(1000);
            await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-022.png' });
        }


        console.log('--- PROFILE CONFIGURATION ---');
        await page.goto(BASE_URL + '/profile', { waitUntil: 'domcontentloaded' });
        await delay(1000);

        // CP-TRB-025: Incorrect Current Password
        console.log('Running CP-TRB-025 (Incorrect Password)...');
        await page.type('input#update_password_current_password', 'wrongpassword');
        await page.type('input#update_password_password', 'newpassword123');
        await page.type('input#update_password_password_confirmation', 'newpassword123');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
            page.evaluate(() => {
                const form = document.querySelector('form[action*="password"]');
                if (form) form.submit();
                else document.querySelectorAll('form')[1].submit(); // the second form usually
            })
        ]);
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-025.png' });

        // Clear password fields for next tests just in case 
        await page.goto(BASE_URL + '/profile', { waitUntil: 'domcontentloaded' });
        await delay(500);

        // CP-TRB-024: Correct Password Change
        console.log('Running CP-TRB-024 (Correct Password)...');
        await page.type('input#update_password_current_password', 'password');
        await page.type('input#update_password_password', 'password'); // Reset to same or 'password123'
        await page.type('input#update_password_password_confirmation', 'password');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
            page.evaluate(() => {
                const form = document.querySelector('form[action*="password"]');
                if (form) form.submit();
                else document.querySelectorAll('form')[1].submit();
            })
        ]);
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-024.png' });


        // CP-TRB-026: Role Auto-Promotion Security
        console.log('Running CP-TRB-026 (Role Security)...');
        await page.goto(BASE_URL + '/profile', { waitUntil: 'domcontentloaded' });
        await delay(500);
        // Inject a hidden input to the profile form
        await page.evaluate(() => {
            const form = document.querySelector('form[action*="profile"]');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'role';
            input.value = 'admin';
            form.appendChild(input);
        });

        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
            page.evaluate(() => {
                const form = document.querySelector('form[action*="profile"]');
                form.submit();
            })
        ]);
        await delay(1000);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-026.png' });

        // CP-TRB-023: Update Personal Info & Photo
        console.log('Running CP-TRB-023 (Profile Update)...');
        await page.goto(BASE_URL + '/profile', { waitUntil: 'domcontentloaded' });
        await delay(500);
        // Change name
        await page.evaluate(() => document.querySelector('input#name').value = '');
        await page.type('input#name', 'Trabajador Editado');

        const fileInput = await page.$('input#profile_photo');
        await fileInput.uploadFile(path.resolve('test_image.jpg'));

        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
            page.evaluate(() => {
                const form = document.querySelector('form[action*="profile"]');
                form.submit();
            })
        ]);
        await delay(1500);
        await page.screenshot({ path: 'puppeter_test_trabajador/CP-TRB-023.png' });


        // Clean up: Reset name back to original so it doesn't break future runs
        await page.goto(BASE_URL + '/profile', { waitUntil: 'domcontentloaded' });
        await delay(500);
        await page.evaluate(() => document.querySelector('input#name').value = '');
        await page.type('input#name', 'Trabajador 1');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'networkidle0' }).catch(() => { }),
            page.evaluate(() => document.querySelector('form[action*="profile"]').submit())
        ]);

        console.log('Tests finished successfully.');
    } catch (e) {
        console.error('Error during tests:', e);
    } finally {
        await browser.close();
    }
})();
