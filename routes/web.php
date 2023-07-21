<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Catalog\CatalogController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Route\ErrorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(
    [
        'prefix' => 'auth',
    ],
    function () {
        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
    }
);

Route::middleware('auth.jwt')->group(function () {
    Route::post('/auth/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/catalog/{id}', [CatalogController::class, 'show'])->name('catalog.show');
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/order/{id}', [TransactionController::class, 'show'])->name('order.show');
    Route::post('/order/{id}/purchase', [TransactionController::class, 'purchase'])->name('order.purchase');
    Route::get('/history', [TransactionController::class, 'history'])->name('order.history');
    Route::get('/self', [LoginController::class, 'self'])->name('order.self');
});

Route::fallback([ErrorController::class, 'show404']);
