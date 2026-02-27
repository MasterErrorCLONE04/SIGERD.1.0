<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$instructor = App\Models\User::where('email', 'instructor1@sigerd.com')->first();
$admin = App\Models\User::where('email', 'admin@sigerd.com')->first();

$incAd = App\Models\Incident::create([
    'title' => 'Incidencia Admin (Oculta)',
    'description' => 'Solo de admin',
    'location' => 'Admin area',
    'report_date' => now(),
    'status' => 'pending',
    'user_id' => $admin->id
]);

$incIns = App\Models\Incident::create([
    'title' => 'Incidencia Instructor Investigada',
    'description' => 'Ya fue asignada a una tarea',
    'location' => 'Patio',
    'report_date' => now(),
    'status' => 'in_progress',
    'user_id' => $instructor->id
]);

file_put_contents('test_ids.txt', $incAd->id . ',' . $incIns->id);
echo "Creadas con exito\n";
