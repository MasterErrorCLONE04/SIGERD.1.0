<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Task;
use App\Models\Incident;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

echo "Running Setup for CP-ADM-072 to 078...\n";

$admin = User::where('email', 'admin@sigerd.com')->first();
$worker = User::where('email', 'trabajador1@sigerd.com')->first();
$adminId = $admin ? $admin->id : 1;
$workerId = $worker ? $worker->id : 2;

// --- CP-ADM-072: Delete task with multiple evidences ---
$t72_initial = ['tasks/072_init_1.jpg', 'tasks/072_init_2.jpg'];
$t72_final = ['tasks/072_final_1.jpg', 'tasks/072_final_2.jpg'];

// Ensure storage directory exists
$publicStorage = storage_path('app/public/tasks');
if (!File::exists($publicStorage)) File::makeDirectory($publicStorage, 0755, true);

// Create dummy files
$fixture = __DIR__.'/fixtures/heavy.jpg';
foreach(array_merge($t72_initial, $t72_final) as $relPath) {
    File::copy($fixture, storage_path('app/public/'.$relPath));
}

$task72 = Task::create([
    'title' => 'Task 072 Multi Evidence',
    'description' => 'Verify physical deletion of 4 files.',
    'status' => 'realizada',
    'priority' => 'media',
    'location' => 'File System Zone',
    'assigned_to' => $workerId,
    'created_by' => $adminId,
    'reference_images' => $t72_initial, // Ensure model handles array or json casting
    'final_evidence_images' => $t72_final,
    'deadline_at' => now()->addDays(5)
]);

// --- CP-ADM-073: 200 notifications ---
echo "Inserting 200 notifications for admin...\n";
$notifications = [];
for($i=0; $i<200; $i++) {
    $notifications[] = [
        'user_id' => $adminId,
        'type' => 'tarea_asignada',
        'title' => 'Carga Masiva ' . $i,
        'message' => 'Notificación de prueba para rendimiento ' . $i,
        'link' => '/admin/tasks',
        'read' => false,
        'created_at' => now()->format('Y-m-d H:i:s'),
        'updated_at' => now()->format('Y-m-d H:i:s')
    ];
    if(count($notifications) >= 50) {
        DB::table('notifications')->insert($notifications);
        $notifications = [];
    }
}
if(count($notifications) > 0) DB::table('notifications')->insert($notifications);

// --- CP-ADM-074: Other user notification ---
$notif74Id = DB::table('notifications')->insertGetId([
    'user_id' => $workerId,
    'type' => 'test_seguridad',
    'title' => 'No me toques',
    'message' => 'Esta notificación es de trabajador1',
    'link' => '#',
    'read' => false,
    'created_at' => now()->format('Y-m-d H:i:s'),
    'updated_at' => now()->format('Y-m-d H:i:s')
]);

// --- CP-ADM-075: Orphan notification ---
$task75 = Task::create([
    'title' => 'Task for deletion test 075',
    'description' => 'Will be deleted',
    'location' => 'Nowhere',
    'status' => 'pendiente',
    'priority' => 'baja',
    'assigned_to' => $workerId,
    'created_by' => $adminId,
    'deadline_at' => now()->addDays(1)
]);

$notif75Id = DB::table('notifications')->insertGetId([
    'user_id' => $adminId,
    'type' => 'tarea_eliminada_obs',
    'title' => 'Referencia Huérfana',
    'message' => 'Esta tarea será borrada',
    'link' => '/admin/tasks/' . $task75->id,
    'read' => false,
    'created_at' => now()->format('Y-m-d H:i:s'),
    'updated_at' => now()->format('Y-m-d H:i:s')
]);

$task75->delete();

// Write IDs
file_put_contents(__DIR__ . '/test_ids_72_78.json', json_encode([
    'task72' => $task72->id,
    'notif74' => $notif74Id,
    'notif75' => $notif75Id,
    'task72_files' => array_merge($t72_initial, $t72_final)
]));

echo "Setup 72-78 completed.\n";
