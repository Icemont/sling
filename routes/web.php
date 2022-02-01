<?php

use App\Http\Controllers\Auth\UpdatePasswordController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserSettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'filled'])->group(function () {
    Route::get('/user/password', [UpdatePasswordController::class, 'edit'])
        ->name('user.password.edit');
    Route::put('/user/password', [UpdatePasswordController::class, 'update'])
        ->name('user.password.update');

    Route::middleware(['password.confirm'])->group(function () {
        Route::get('/user/settings', [UserSettingsController::class, 'edit'])
            ->name('user.settings.edit');
        Route::put('/user/settings', [UserSettingsController::class, 'update'])
            ->name('user.settings.update');
    });

    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('clients', ClientController::class)->except(['create']);

    Route::resource('payment-methods', PaymentMethodController::class);

    Route::resource('invoices', InvoiceController::class)->except(['create']);
    Route::post('/invoices/create', [InvoiceController::class, 'createForm'])->name('invoices.createform');
    Route::get('/invoices/create/{client}', [InvoiceController::class, 'create'])
        ->where('client', '[0-9]+')
        ->name('invoices.create');
    Route::get('/invoices/download/{invoice}', [InvoiceController::class, 'download'])
        ->where('invoice', '[0-9]+')
        ->name('invoices.download');

    Route::get('/reports', [ReportController::class, 'form'])->name('reports.form');
    Route::post('/reports', [ReportController::class, 'create'])->name('reports.create');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/password', [UpdatePasswordController::class, 'edit'])
        ->name('user.password.edit');
    Route::put('/user/password', [UpdatePasswordController::class, 'update'])
        ->name('user.password.update');

    Route::middleware(['password.confirm'])->group(function () {
        Route::get('/user/settings', [UserSettingsController::class, 'edit'])
            ->name('user.settings.edit');
        Route::put('/user/settings', [UserSettingsController::class, 'update'])
            ->name('user.settings.update');
    });
});

require __DIR__ . '/auth.php';
