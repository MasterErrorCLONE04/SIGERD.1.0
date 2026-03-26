<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Task;
use App\Models\Incident;
use Illuminate\Support\Facades\DB;

echo "Running Setup for CP-ADM-066 to 071...\n";

// CP-ADM-066: 1,000 tareas marcadas como finalizadas en el mes actual.
$monthStart = now()->startOfMonth()->format('Y-m-d H:i:s');
$countTasks = Task::where('status', 'finalizada')->where('created_at', '>=', $monthStart)->count();

$admin = User::where('email', 'admin@sigerd.com')->first();
$worker = User::where('email', 'trabajador1@sigerd.com')->first();
$adminId = $admin ? $admin->id : 1;
$workerId = $worker ? $worker->id : 2;

if ($countTasks < 1000) {
    echo "Inserting " . (1000 - $countTasks) . " fixed tasks for PDF export test...\n";
    $chunks = [];
    for ($i = 0; $i < (1000 - $countTasks); $i++) {
        $chunks[] = [
            'title' => 'Report Task ' . $i,
            'description' => 'Load testing data for PDF export DOMPDF.',
            'status' => 'finalizada',
            'priority' => 'media',
            'location' => 'Zone ' . ($i % 5),
            'incident_id' => null,
            'assigned_to' => $workerId,
            'created_by' => $adminId,
            'deadline_at' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ];
        if (count($chunks) >= 500) {
            DB::table('tasks')->insert($chunks);
            $chunks = [];
        }
    }
    if (count($chunks) > 0) {
        DB::table('tasks')->insert($chunks);
    }
}

// CP-ADM-068: Gran volumen de incidencias. 
$countIncidents = Incident::count();
if ($countIncidents < 15000) {
    echo "Inserting " . (15000 - $countIncidents) . " incidents for search load test...\n";
    $chunks = [];
    for ($i = 0; $i < (15000 - $countIncidents); $i++) {
        $chunks[] = [
            'title' => 'Incidencia Falla Eléctrica ' . $i,
            'description' => 'Testing search query for falla eléctrica randomly generated text.',
            'location' => 'Unknown Sector',
            'status' => 'pendiente de revisión',
            'reported_by' => $workerId,
            'created_at' => now()->subDays(random_int(1, 30))->format('Y-m-d H:i:s'),
            'updated_at' => now()->subDays(random_int(1, 30))->format('Y-m-d H:i:s'),
        ];
        if (count($chunks) >= 1000) {
            DB::table('incidents')->insert($chunks);
            $chunks = [];
        }
    }
    if (count($chunks) > 0) {
        DB::table('incidents')->insert($chunks);
    }
}

// CP-ADM-069: Task whose evidence has been deleted from disk physically
$id69 = Task::insertGetId([
    'title' => 'Task with missing physical evidence',
    'description' => 'Will be deleted in UI to test file_exists wrapper.',
    'status' => 'pendiente',
    'location' => 'Missing File Zone',
    'assigned_to' => $workerId,
    'created_by' => $adminId,
    'reference_images' => json_encode(['tasks/not_exist_in_disk_123.jpg']),
    'deadline_at' => now()->addDays(2)->format('Y-m-d H:i:s'),
    'created_at' => now()->format('Y-m-d H:i:s'),
    'updated_at' => now()->format('Y-m-d H:i:s')
]);

// Write IDs
file_put_contents(__DIR__ . '/test_ids_66_71.json', json_encode([
    'task69' => $id69
]));

echo "Setup 66-71 completed.\n";
