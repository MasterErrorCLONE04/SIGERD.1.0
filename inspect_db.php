<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "DB Name: " . DB::connection()->getDatabaseName() . "\n";
echo "DB Config: " . config('database.connections.mysql.database') . "\n";

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$tables = DB::select('SHOW TABLES');
foreach ($tables as $table) {
    $tableName = array_values((array)$table)[0];
    echo "Table: $tableName\n";
    $columns = Schema::getColumnListing($tableName);
    foreach ($columns as $column) {
        if (strpos($column, 'document') !== false) {
            echo "  !!! FOUND: $column\n";
        } else {
            // echo "  - $column\n";
        }
    }
}
