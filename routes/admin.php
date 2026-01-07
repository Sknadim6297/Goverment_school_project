<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\ComputerAdmissionController;
use App\Http\Controllers\Admin\SaraswatiPujaController;
use App\Http\Controllers\Admin\AuthController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin Authentication Routes (Public - No Auth Required)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Admin Protected Routes (Requires Authentication)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admission Management
    Route::prefix('admission')->name('admission.')->group(function () {
        Route::get('/', [AdmissionController::class, 'index'])->name('index');
        Route::get('/create', [AdmissionController::class, 'create'])->name('create');
        Route::post('/store', [AdmissionController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AdmissionController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [AdmissionController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AdmissionController::class, 'destroy'])->name('delete');
        Route::get('/make-payment/{id}', [AdmissionController::class, 'makePayment'])->name('make_payment');
        Route::post('/payment/{id}', [AdmissionController::class, 'processPayment'])->name('process_payment');
        Route::get('/receipt/{id}', [AdmissionController::class, 'receipt'])->name('receipt');
        Route::get('/edit-receipt/{id}', [AdmissionController::class, 'editReceipt'])->name('edit_receipt');
        Route::put('/update-receipt/{id}', [AdmissionController::class, 'updateReceipt'])->name('update_receipt');
        Route::get('/export', [AdmissionController::class, 'export'])->name('export');
    });
    
    // Computer Admission Management
    Route::prefix('computer-admission')->name('computer_admission.')->group(function () {
        Route::get('/', [ComputerAdmissionController::class, 'index'])->name('index');
        Route::get('/add/{admission_id}', [ComputerAdmissionController::class, 'create'])->name('create');
        Route::post('/store', [ComputerAdmissionController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ComputerAdmissionController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ComputerAdmissionController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ComputerAdmissionController::class, 'destroy'])->name('delete');
        Route::get('/make-payment/{id}', [ComputerAdmissionController::class, 'makePayment'])->name('make_payment');
        Route::post('/process-payment/{id}', [ComputerAdmissionController::class, 'processPayment'])->name('process_payment');
        Route::get('/reports', [ComputerAdmissionController::class, 'reports'])->name('reports');
        Route::get('/receipt/{id}', [ComputerAdmissionController::class, 'receipt'])->name('receipt');
    });
    
    // Saraswati Puja Committee Management
    Route::prefix('saraswati-puja')->name('saraswati_puja.')->group(function () {
        Route::get('/', [SaraswatiPujaController::class, 'index'])->name('index');
        Route::get('/add/{admission_id}', [SaraswatiPujaController::class, 'create'])->name('create');
        Route::post('/store', [SaraswatiPujaController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SaraswatiPujaController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [SaraswatiPujaController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [SaraswatiPujaController::class, 'destroy'])->name('delete');
        Route::get('/reports', [SaraswatiPujaController::class, 'reports'])->name('reports');
        Route::get('/receipt/{id}', [SaraswatiPujaController::class, 'receipt'])->name('receipt');
    });
});
