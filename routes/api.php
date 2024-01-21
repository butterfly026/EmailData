<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MarketingsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/marketings/list', [MarketingsController::class, 'list'])->name('api.marketings.list');
Route::post('/marketings/topRates', [MarketingsController::class, 'topRates'])->name('api.marketings.topRates');
Route::post('/marketings/free_search', [MarketingsController::class, 'free_search'])->name('api.marketings.free_search');
Route::post('/payments/checkout', [PaymentsController::class, 'checkout'])->name('api.payments.checkout');
Route::post('/payments/sendPaymentEmail', [PaymentsController::class, 'sendPaymentEmail'])->name('api.payments.send_payment_email');
Route::post('/auth/signin', [AuthController::class, 'login'])->name('api.auth.login');
Route::post('/auth/signup', [AuthController::class, 'signup'])->name('api.auth.signup');
Route::middleware('auth')->post('/auth/sendVerifyEmail', [AuthController::class, 'sendVerifyEmail'])->name('api.auth.sendVerifyEmail');
Route::middleware('auth')->post('/auth/autologin', [AuthController::class, 'autologin'])->name('api.auth.autologin');
Route::middleware('auth')->post('/auth/changePassword', [AuthController::class, 'changePassword'])->name('api.auth.changePassword');
Route::middleware('auth')->post('/marketings/search', [MarketingsController::class, 'search'])->name('api.marketings.search');
Route::middleware('auth')->post('/marketings/admin_search', [MarketingsController::class, 'admin_search'])->name('api.marketings.admin_search');
Route::middleware('auth')->post('/users/users_search', [UsersController::class, 'users_search'])->name('api.users.users_search');
Route::middleware('auth')->post('/payments/payments_search', [PaymentsController::class, 'payments_search'])->name('api.payments.payments_search');
Route::middleware('auth')->post('/admin/saveSetting', [AdminController::class, 'saveSetting'])->name('api.admin.saveSetting');
Route::middleware('auth')->post('/admin/getSetting', [AdminController::class, 'getSetting'])->name('api.admin.getSetting');
Route::middleware('auth')->post('/admin/users/delete', [UsersController::class, 'delete'])->name('api.admin.users.delete');
Route::middleware('auth')->post('/admin/users/update', [UsersController::class, 'update'])->name('api.admin.users.update');
Route::middleware('auth')->post('/admin/users/create', [UsersController::class, 'create'])->name('api.admin.users.create');