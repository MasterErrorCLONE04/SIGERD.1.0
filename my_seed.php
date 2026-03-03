<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$admin = App\Models\User::where('role', 'administrador')->first();
$worker1 = App\Models\User::where('email', 'trabajador1@sigerd.com')->first();
$worker2 = App\Models\User::where('email', 'trabajador_zero@sigerd.com')->first();

$t1 = App\Models\Task::create([
    'title' => 'Tarea Asignada Test ' . time(),
    'description' => 'Test CP',
    'location' => 'Oficina 1',
    'status' => 'asignado',
    'priority' => 'media',
    'deadline_at' => now()->addDays(5),
    'assigned_to' => $worker1->id,
    'created_by' => $admin->id
]);
echo "TASK1_ID=" . $t1->id . "\n";

$t2 = App\Models\Task::create([
    'title' => 'Tarea Ajena ' . time(),
    'description' => 'Test CP',
    'location' => 'Oficina 2',
    'status' => 'asignado',
    'priority' => 'media',
    'deadline_at' => now()->addDays(5),
    'assigned_to' => $worker2->id,
    'created_by' => $admin->id
]);
echo "TASK2_ID=" . $t2->id . "\n";
