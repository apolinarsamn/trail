<?php

use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/membership/apply', [MembershipApplicationController::class, 'create'])
        ->name('membership.create');

    Route::post('/membership/apply', [MembershipApplicationController::class, 'store'])
        ->name('membership.store');
});

Route::get('/weather', [WeatherController::class, 'show'])
    ->name('weather.show');

Route::get('/locations/search', [WeatherController::class, 'search'])
    ->name('locations.search');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');

    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::resource('members', MemberController::class);

    Route::get('/members/{member}/history', [MemberController::class, 'history'])
        ->name('members.history');

    Route::resource('admin/categories', CategoryController::class)
        ->except(['show'])
        ->names([
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]);

    Route::resource('admin/levels', LevelController::class)
        ->except(['show'])
        ->names([
            'index' => 'admin.levels.index',
            'create' => 'admin.levels.create',
            'store' => 'admin.levels.store',
            'edit' => 'admin.levels.edit',
            'update' => 'admin.levels.update',
            'destroy' => 'admin.levels.destroy',
        ]);

    Route::get('/admin/applications', [AdminApplicationController::class, 'index'])
        ->name('admin.applications.index');

    Route::get('/admin/applications/{application}', [AdminApplicationController::class, 'show'])
        ->name('admin.applications.show');

    Route::get('/admin/transactions', [TransactionController::class, 'index'])
        ->name('admin.transactions.index');

    Route::get('/admin/transactions/create', [TransactionController::class, 'create'])
        ->name('admin.transactions.create');

    Route::post('/admin/transactions', [TransactionController::class, 'store'])
        ->name('admin.transactions.store');

    Route::patch('/admin/transactions/{transaction}/approve', [TransactionController::class, 'approve'])
        ->name('admin.transactions.approve');

    Route::patch('/admin/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])
        ->name('admin.transactions.cancel');

    Route::patch('/admin/transactions/{transaction}/expire', [TransactionController::class, 'expire'])
        ->name('admin.transactions.expire');

    Route::get('/admin/payments', [PaymentController::class, 'index'])
        ->name('admin.payments.index');

    Route::get('/admin/payments/create', [PaymentController::class, 'create'])
        ->name('admin.payments.create');

    Route::post('/admin/payments', [PaymentController::class, 'store'])
        ->name('admin.payments.store');

    Route::get('/admin/payments/{payment}/receipt', [PaymentController::class, 'receipt'])
        ->name('admin.payments.receipt');
});