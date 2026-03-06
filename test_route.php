<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/xyzauth', 'GET')
);

$request = Illuminate\Http\Request::create('/worker/tasks/1', 'GET');
$request->setUserResolver(function () {
    return \App\Models\User::find(2);
});

// Since the kernel processes actual web middleware, we need to bypass it or simulate it. 
// A simpler way is to just call a tinker command.
