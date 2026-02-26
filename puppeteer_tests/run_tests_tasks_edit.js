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

        console.log("CP-ADM-021");
        const { execSync } = require('child_process');
        execSync(`php artisan tinker --execute="\\App\\Models\\Task::query()->update(['status' => 'pendiente', 'initial_evidence_images' => null, 'final_evidence_images' => null]);"`, { cwd: 'c:\\\\laragon\\\\www\\\\SIGERD.1.0' });
        await page.goto(`${BASE_URL}/admin/tasks`, { waitUntil: 'networkidle0' });
        // Click edit on the first possible task. Evaluate to find a valid edit button.
        const taskId = await page.evaluate(() => {
            const btn = document.querySelector('button[onclick^="startEditTask"]');
            if (btn) {
                const match = btn.getAttribute('onclick').match(/\d+/);
                if (match) {
                    btn.click();
                    return match[0];
                }
            }
            return null;
        });

        if (taskId) {
            await new Promise(r => setTimeout(r, 1000)); // wait for modal

            // clear and type
            await page.evaluate(() => document.getElementById('edit_task_title').value = '');
            await page.type('#edit_task_title', 'Título Editado por QA');
            await page.select('#edit_task_priority', 'alta');

            await Promise.all([
                page.waitForNavigation({ waitUntil: 'networkidle0' }),
                page.click('#editTaskSubmitBtn')
            ]);
            await capture('CP-ADM-021');
        } else {
            console.log("No task found to edit for CP-ADM-021");
            await capture('CP-ADM-021_FAIL');
        }


        console.log("CP-ADM-022");
        await page.goto(`${BASE_URL}/admin/tasks`, { waitUntil: 'networkidle0' });
        const taskId22 = await page.evaluate(() => {
            const btn = document.querySelector('button[onclick^="startEditTask"]');
            if (btn) {
                btn.click();
                return true;
            }
            return false;
        });

        if (taskId22) {
            await new Promise(r => setTimeout(r, 1000));
            const pastDate = new Date();
            pastDate.setDate(pastDate.getDate() - 5);
            await page.evaluate(() => document.getElementById('edit_task_deadline').value = '');
            await page.type('#edit_task_deadline', pastDate.toISOString().split('T')[0]);

            await Promise.all([
                page.waitForNavigation({ waitUntil: 'networkidle0' }),
                page.click('#editTaskSubmitBtn')
            ]);

            await page.goto(`${BASE_URL}/admin/tasks`, { waitUntil: 'networkidle0' });
            await capture('CP-ADM-022');
        }

        // Para Evidencias y Aprobaciones vamos al Show del primer elemento disponible
        const getFirstTaskUrl = async () => {
            await page.goto(`${BASE_URL}/admin/tasks`, { waitUntil: 'networkidle0' });
            return await page.evaluate(() => {
                // Buscamos específicamente el botón con SVG de "Ojo" (Ver detalle)
                const anchors = Array.from(document.querySelectorAll('a[href*="/admin/tasks/"]'));
                const showAnchor = anchors.find(a => a.getAttribute('title') === 'Ver detalle' || a.querySelector('svg'));
                return showAnchor ? showAnchor.href : null;
            });
        };

        const firstTaskShowUrl = await getFirstTaskUrl();

        if (firstTaskShowUrl) {
            console.log("CP-ADM-023");
            await page.goto(firstTaskShowUrl, { waitUntil: 'networkidle0' });

            // Forzar estado "realizada" mediante tinker para que aparezca el form de revisión
            const taskIdMatch = firstTaskShowUrl.match(/\d+$/);
            if (taskIdMatch) {
                const id = taskIdMatch[0];
                const { execSync } = require('child_process');
                // Hacemos que la tarea esté "realizada" y le ponemos una evidencia falsa para que renderice los botones de review
                execSync(`php artisan tinker --execute="\\App\\Models\\Task::where('id', ${id})->update(['status' => 'realizada', 'final_evidence_images' => '[]']);"`, { cwd: 'c:\\\\laragon\\\\www\\\\SIGERD.1.0' });
                await page.goto(firstTaskShowUrl, { waitUntil: 'networkidle0' }); // Recargar
            }

            // Subir Evidencia Final si el form existe
            const finalEvidenceInput = await page.$('input[name="final_evidence_images[]"]');
            if (finalEvidenceInput) {
                await finalEvidenceInput.uploadFile(path.join(__dirname, 'test_files', 'valid.jpg'));

                await Promise.all([
                    page.waitForNavigation({ waitUntil: 'networkidle0' }),
                    page.click('form[action$="/upload-final-evidence"] button[type="submit"]')
                ]);
            }
            await capture('CP-ADM-023');


            console.log("CP-ADM-026 (Delay)");
            await page.goto(firstTaskShowUrl, { waitUntil: 'networkidle0' });
            const hasReviewCard = await page.$('form[action$="/review"]');
            if (hasReviewCard) {
                await page.evaluate(() => {
                    const select = document.querySelector('select[name="status"]');
                    if (select) select.value = 'retraso en proceso';

                    const textarea = document.querySelector('textarea[name="review_notes"]');
                    if (textarea) textarea.value = 'Se requiere más tiempo para QA';
                });

                await Promise.all([
                    page.waitForNavigation({ waitUntil: 'networkidle0' }),
                    page.click('form[action$="/review"] button[type="submit"]')
                ]);
                await capture('CP-ADM-026');
            }

            console.log("CP-ADM-025 (Reject)");
            if (taskIdMatch) {
                const { execSync } = require('child_process');
                execSync(`php artisan tinker --execute="\\App\\Models\\Task::where('id', ${taskIdMatch[0]})->update(['status' => 'realizada']);"`, { cwd: 'c:\\\\laragon\\\\www\\\\SIGERD.1.0' });
            }
            await page.goto(firstTaskShowUrl, { waitUntil: 'networkidle0' });
            const formReview2 = await page.$('form[action$="/review"]');
            if (formReview2) {
                await page.evaluate(() => {
                    const select = document.querySelector('select[name="status"]');
                    if (select) select.value = 'en progreso';

                    const textarea = document.querySelector('textarea[name="review_notes"]');
                    if (textarea) textarea.value = 'Faltan detalles en la evidencia, devuelta al campo.';
                });

                await Promise.all([
                    page.waitForNavigation({ waitUntil: 'networkidle0' }),
                    page.click('form[action$="/review"] button[type="submit"]')
                ]);
                await capture('CP-ADM-025');
            }

            console.log("CP-ADM-024 (Approve)");
            // Para el caso final, marcamos la misma tarea de vuelta a realizada
            if (taskIdMatch) {
                const { execSync } = require('child_process');
                execSync(`php artisan tinker --execute="\\App\\Models\\Task::where('id', ${taskIdMatch[0]})->update(['status' => 'realizada']);"`, { cwd: 'c:\\\\laragon\\\\www\\\\SIGERD.1.0' });
            }
            await page.goto(firstTaskShowUrl, { waitUntil: 'networkidle0' });
            const formReview3 = await page.$('form[action$="/review"]');
            if (formReview3) {
                await page.evaluate(() => {
                    const select = document.querySelector('select[name="status"]');
                    if (select) select.value = 'finalizada';

                    const textarea = document.querySelector('textarea[name="review_notes"]');
                    if (textarea) textarea.value = 'Todo correcto, tarea aprobada satisfactoriamente.';
                });

                await Promise.all([
                    page.waitForNavigation({ waitUntil: 'networkidle0' }),
                    page.click('form[action$="/review"] button[type="submit"]')
                ]);
                await capture('CP-ADM-024');
            }
        } else {
            console.log("No task found to show for CP-ADM-24-26");
        }

        console.log("Completado");
    } catch (e) {
        console.error(e);
    } finally {
        await browser.close();
    }
})();
