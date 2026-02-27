<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'instructor1@sigerd.com')->first();
$incidents = [];
for ($i = 1; $i <= 25; $i++) {
    $incidents[] = [
        'title' => 'Incidencia Falsa ' . $i,
        'description' => 'Prueba de paginacion ' . $i,
        'location' => 'Patio',
        'report_date' => now(),
        'status' => 'pendiente de revisión',
        'reported_by' => $user->id,
        'created_at' => now(),
        'updated_at' => now()
    ];
}
\DB::table('incidents')->insert($incidents);
echo 'Data inserted';
