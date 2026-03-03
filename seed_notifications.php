<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Task;
use App\Models\Notification;

$type = $argv[1] ?? 'task_assigned';
$user = User::where('email', 'trabajador1@sigerd.com')->first();
if (!$user)
    die("User not found\n");

$task = Task::find(20);
if (!$task)
    die("Task not found\n");

// Clear existing notifications
Notification::where('user_id', $user->id)->delete();

if ($type === 'task_assigned') {
    $task->update(['status' => 'asignado', 'assigned_to' => $user->id]);
    Notification::create([
        'user_id' => $user->id,
        'type' => 'task_assigned',
        'title' => 'Nueva Tarea Asignada',
        'message' => 'Te han asignado una nueva tarea: ' . $task->title,
        'link' => '/worker/tasks/' . $task->id,
    ]);
    echo "Seed: assigned\n";
} elseif ($type === 'task_rejected') {
    $task->update(['status' => 'en progreso']);
    Notification::create([
        'user_id' => $user->id,
        'type' => 'task_rejected',
        'title' => 'Tarea Rechazada',
        'message' => 'Tu trabajo en la tarea "' . $task->title . '" requiere correcciones.',
        'link' => '/worker/tasks/' . $task->id,
    ]);
    echo "Seed: rejected\n";
} elseif ($type === 'task_approved') {
    $task->update(['status' => 'finalizada']);
    Notification::create([
        'user_id' => $user->id,
        'type' => 'task_approved',
        'title' => 'Tarea Aprobada',
        'message' => '¡Felicidades! Tu trabajo en la tarea "' . $task->title . '" ha sido aprobado.',
        'link' => '/worker/tasks/' . $task->id,
    ]);
    echo "Seed: approved\n";
}
