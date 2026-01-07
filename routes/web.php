<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Include Admin Routes
require __DIR__.'/admin.php';
