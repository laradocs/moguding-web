<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

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

Route::redirect('/', 'login');
Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login');

Route::delete('logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('register', [UserController::class, 'create'])->name('register');
Route::post('register', [UserController::class, 'store'])->name('register');
Route::match(['put', 'patch'], 'users/{user}', [UserController::class, 'update']);
Route::delete('users/{user}', [UserController::class, 'destroy']);

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('accounts', AccountController::class)->except('show');

Route::post('socialize/{account}', [SocialController::class, 'store'])->name('socialize');

Route::resource('addresses', AddressController::class)->except('show');

Route::resource('tasks', TaskController::class)->except('show');
