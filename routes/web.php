<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\UpdatePasswordController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserSettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(static function () {
    Route::get('/theme', ThemeController::class)->name('theme');
});

Route::middleware(['auth', 'verified', 'filled'])->group(static function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('clients', ClientController::class)->except(['create']);
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::resource('invoices', InvoiceController::class)->except(['create']);

    Route::prefix('invoices')->name('invoices.')->group(static function () {
        Route::post('/create', [InvoiceController::class, 'createForm'])->name('createform');

        Route::get('/create/{client}', [InvoiceController::class, 'create'])
            ->whereNumber('client')
            ->name('create');

        Route::get('/download/{invoice}', [InvoiceController::class, 'download'])
            ->whereNumber('invoice')
            ->name('download');
    });

    Route::get('/reports', [ReportController::class, 'form'])->name('reports.form');
    Route::post('/reports', [ReportController::class, 'create'])->name('reports.create');
});

Route::middleware(['auth', 'verified'])->group(static function () {
    Route::prefix('user')->name('user.')->group(static function () {
        Route::get('/password', [UpdatePasswordController::class, 'edit'])->name('password.edit');
        Route::put('/password', [UpdatePasswordController::class, 'update'])->name('password.update');

        Route::middleware(['password.confirm'])->group(static function () {
            Route::get('/settings', [UserSettingsController::class, 'edit'])->name('settings.edit');
            Route::put('/settings', [UserSettingsController::class, 'update'])->name('settings.update');
        });
    });
});

require __DIR__ . '/auth.php';
