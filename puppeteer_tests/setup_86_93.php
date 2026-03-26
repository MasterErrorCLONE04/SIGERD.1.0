<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "Setting up Phase 5 (086-093)...\n";

try {
    // 1. Cleanup
    DB::table('tasks')->where('title', 'like', 'QA-86-%')->orWhere('title', 'like', 'QA-88-%')->orWhere('title', 'like', 'QA-90-%')->delete();
    DB::table('incidents')->where('title', 'like', 'QA-91-%')->delete();
    DB::table('users')->where('email', 'instructor_qa_91@sigerd.com')->delete();
    DB::table('users')->where('email', 'admin_qa_92@sigerd.com')->delete();

    // 2. Lookup ids
    $admin = DB::table('users')->where('email', 'admin@sigerd.com')->first();
    if (!$admin) $admin = DB::table('users')->where('role', 'administrador')->first();
    
    $worker = DB::table('users')->where('role', 'trabajador')->first();
    if (!$worker) $worker = DB::table('users')->where('role', 'worker')->first();

    if (!$admin || !$worker) {
        die("Error: No se encontró admin o worker base.\n");
    }

    // 3. Setup for 086: Pagination (55 tasks)
    echo "Creating 55 tasks for 086...\n";
    for ($i = 1; $i <= 55; $i++) {
        DB::table('tasks')->insert([
            'title' => "QA-86-Task-$i",
            'description' => "Pagination test task $i",
            'deadline_at' => now()->addDays(10),
            'location' => 'QA Lab',
            'priority' => 'baja',
            'status' => 'asignado',
            'assigned_to' => $worker->id,
            'created_by' => $admin->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    // 4. Setup for 088 & 090: Finished task
    echo "Creating task for 090...\n";
    DB::table('tasks')->insert([
        'title' => "QA-90-Finished",
        'description' => "Task to be deleted physicaly",
        'deadline_at' => now()->addDays(1),
        'location' => 'Archive',
        'priority' => 'media',
        'status' => 'finalizada',
        'assigned_to' => $worker->id,
        'created_by' => $admin->id,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // 5. Setup for 091: Instructor
    echo "Inserting instructor for 091...\n";
    $instructorId = DB::table('users')->insertGetId([
        'name' => 'Instructor QA 91',
        'email' => 'instructor_qa_91@sigerd.com',
        'password' => Hash::make('password'),
        'role' => 'instructor',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    echo "Inserting incident for 091...\n";
    DB::table('incidents')->insert([
        'title' => 'QA-91-Incident',
        'description' => 'Incident by instructor 91',
        'location' => 'Lab 91',
        'status' => 'pendiente',
        'reported_by' => $instructorId,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // 6. Setup for 092: Self admin
    echo "Inserting admin for 092...\n";
    DB::table('users')->insert([
        'name' => 'Admin QA 92',
        'email' => 'admin_qa_92@sigerd.com',
        'password' => Hash::make('password'),
        'role' => 'administrador',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    echo "Phase 5 Setup Complete.\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
