<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MarketingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentsController;

Route::middleware('guest')->get('/', [HomeController::class, 'index']);
Route::middleware('auth')->get('/home', [HomeController::class, 'home'])->name('home');
Route::middleware('auth')->get('/admin_panel', [AdminController::class, 'admin_panel']);
Route::middleware('auth')->get('/users_management', [AdminController::class, 'users']);
Route::middleware('auth')->get('/admin_settings', [AdminController::class, 'settings']);
Route::middleware('auth')->get('/payments_management', [AdminController::class, 'payments']);
Route::middleware('auth')->get('/payout', [PaymentsController::class, 'payout']);
Route::get('/payout_non_user', [PaymentsController::class, 'payout_non_user']);
Route::get('/signin', [AuthController::class, 'loginPage'])->name('auth.loginPage');
Route::get('/404_error', [AuthController::class, 'notFoundPage'])->name('route.404error');
Route::get('/get_ubuntu_vm', [AuthController::class, 'ubuntu'])->name('auth.ubuntu.vm');
Route::get('/privacy_policy', [HomeController::class, 'privacy_policy'])->name('home.privacy_policy');
Route::get('/terms', [HomeController::class, 'terms'])->name('home.terms');
Route::get('/dont_sell_info', [HomeController::class, 'dont_sell_info'])->name('home.dont_sell_info');
Route::get('/signup', [AuthController::class, 'signupPage'])->name('auth.signupPage');
Route::get('/verifyEmailPage/{verifCode}', [AuthController::class, 'verifyEmailPage'])->name('auth.verifyEmail');
Route::get('/confirmPaymentPage/{order_no}', [PaymentsController::class, 'confirmPaymentPage'])->name('payments.confirmPaymentPage');
Route::get('/signout', [AuthController::class, 'signout'])->name('api.auth.signout');
Route::get('/download', [MarketingsController::class, 'download'])->name('marketings.download');
Route::post('/payment_hook', [PaymentsController::class, 'payment_hook'])->name('payments.payment_hook');
Route::middleware('auth')->get('/paySuccess', [PaymentsController::class, 'paySuccess'])->name('payments.paySuccess');
Route::middleware('auth')->get('/admin_download', [MarketingsController::class, 'admin_download'])->name('marketings.admin_download');
Route::middleware('auth')->get('/users/download', [AdminController::class, 'users_download'])->name('admin.users.download');


