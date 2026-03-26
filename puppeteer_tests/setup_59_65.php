<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Task;
use App\Models\Incident;
use Illuminate\Support\Facades\DB;

$admin = User::where('role', 'administrador')->first();
$worker = User::where('role', 'trabajador')->first();

if(!$admin || !$worker) {
    die("Usuarios no encontrados\n");
}

// 060: Task in realizada with no final evidence
$task60 = Task::create([
    'title' => 'Task 060 Without Evidence Test',
    'description' => 'Test',
    'location' => 'Test',
    'status' => 'realizada',
    'priority' => 'media',
    'created_by' => $admin->id,
    'assigned_to' => $worker->id,
    'deadline_at' => now()->addDays(1)
]);
file_put_contents(__DIR__.'/task60_id.txt', $task60->id);

// 061: Incident converted to task
$incident61 = Incident::create([
    'title' => 'Incident 061 For Deletion',
    'description' => 'Test',
    'location' => 'Test',
    'status' => 'asignado',
    'reported_by' => $admin->id
]);
$task61 = Task::create([
    'title' => 'Task 61 linked to Incident',
    'description' => 'Test',
    'location' => 'Test',
    'status' => 'asignado',
    'priority' => 'media',
    'created_by' => $admin->id,
    'assigned_to' => $worker->id,
    'deadline_at' => now()->addDays(1),
    'incident_id' => $incident61->id
]);
file_put_contents(__DIR__.'/task61_id.txt', $task61->id);
file_put_contents(__DIR__.'/incident61_id.txt', $incident61->id);

// 062: Incident pendiente de revision
$incident62 = Incident::create([
    'title' => 'Incident 062 Pending',
    'description' => 'Test',
    'location' => 'Test',
    'status' => 'pendiente de revisión',
    'reported_by' => $admin->id
]);
file_put_contents(__DIR__.'/incident62_id.txt', $incident62->id);

// 065: Pagination (if less than 5000, insert to reach ~5000)
$count = Task::count();
if ($count < 5000) {
    echo "Inserting tasks for pagination test...\n";
    $tasksToInsert = [];
    $needed = 5000 - $count;
    // Cap to 5000 to avoid huge wait times
    for($i=0; $i<$needed; $i++){
        $tasksToInsert[] = [
            'title' => 'Dummy Task ' . $i,
            'description' => 'Dummy',
            'location' => 'Dummy',
            'status' => 'pendiente',
            'priority' => 'baja',
            'created_by' => $admin->id,
            'assigned_to' => $worker->id,
            'deadline_at' => now()->addYear(),
            'created_at' => now(),
            'updated_at' => now()
        ];
        if(count($tasksToInsert) == 1000) {
            DB::table('tasks')->insert($tasksToInsert);
            $tasksToInsert = [];
        }
    }
    if(count($tasksToInsert) > 0) {
        DB::table('tasks')->insert($tasksToInsert);
    }
}

echo "Setup OK\n";
