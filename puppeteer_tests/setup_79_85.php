<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "Cleaning up tasks for 079-085...\n";
Task::where('title', 'like', 'QA-79%')
    ->orWhere('title', 'like', 'QA-8%')
    ->orWhere('title', 'like', '%🌍%')
    ->delete();

$admin = User::where('email', 'admin@sigerd.com')->first();
$worker = User::where('role', 'trabajador')->first();

if (!$admin || !$worker) {
    die("Error: Admin or Worker not found.\n");
}

// Create a base task for editing tests if needed
$task = Task::create([
    'title' => 'QA-Base-Task-For-Editing',
    'description' => 'Initial description',
    'deadline_at' => now()->addDays(5),
    'location' => 'QA Lab',
    'priority' => 'media',
    'status' => 'asignado',
    'assigned_to' => $worker->id,
    'created_by' => $admin->id,
    'reference_images' => ['tasks-reference/dummy.jpg'] 
]);

echo "Setup 79-85 complete. Base Task ID: {$task->id}\n";
