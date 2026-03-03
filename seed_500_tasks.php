<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

$user = User::where('email', 'trabajador1@sigerd.com')->first();
$admin = User::first();

if (!$user)
    die("User not found\n");

$count = Task::where('assigned_to', $user->id)->count();

if ($count < 500) {
    echo "Current count: $count. Seeding with Eloquent...\n";
    for ($i = 0; $i < (510 - $count); $i++) {
        Task::create([
            'title' => 'Bulk Task ' . $i,
            'description' => 'Pagination test',
            'status' => 'asignado',
            'priority' => 'media',
            'location' => 'Zona Test',
            'assigned_to' => $user->id,
            'created_by' => $admin->id,
            'deadline_at' => now()->addDays(rand(1, 10)),
        ]);
    }
    echo "Seeding completed.\n";
} else {
    echo "Sufficient tasks exist.\n";
}
