<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasTable('notifications')) {
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('type');
        $table->string('title');
        $table->text('message');
        $table->string('link')->nullable();
        $table->boolean('read')->default(false);
        $table->timestamps();
    });
    echo "Table 'notifications' created successfully.\n";
} else {
    echo "Table 'notifications' already exists.\n";
}
