<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$task = App\Models\Task::find(20);
$task->update(['status' => 'en progreso', 'initial_evidence_images' => ['test.jpg']]);
echo "Task status is now: " . $task->fresh()->status . "\n";
