<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'welcome']);
Route::get('/login', [UsersController::class, 'LoginForm']);
Route::get('/register', [UsersController::class, 'RegisterForm']);

Route::post('/logout', [UsersController::class, 'Logout'])->name('logout');
Route::post('/auth/login', [UsersController::class, 'Login'])->name('auth-login');
Route::post('/register', [UsersController::class, 'Register'])->name('auth.register');

Route::get('/home', [HomeController::class, 'Home'])->name('home.page')->middleware('auth');
Route::get('/accounts', [HomeController::class, 'accountsListPage'])->name('accounts')->middleware('auth');
Route::post('/get/account', [UsersController::class, 'getAccountById'])->name('get.account')->middleware('auth');
Route::put('/update/account', [UsersController::class, 'updateAccountById'])->name('update.account')->middleware('auth');