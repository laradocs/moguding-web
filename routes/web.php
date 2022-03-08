<?php

namespace App\Http\Controllers\Web;

use Illuminate\Auth\Events\Login;
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

Route::redirect ( '/', 'login' );
Route::middleware ( 'guest:web' )->group ( function () {
    Route::get ( 'login', [ LoginController::class, 'create' ] )->name ( 'login' );
    Route::post ( 'login', [ LoginController::class, 'store' ] )->name ( 'login' );
    Route::get ( 'register', [ RegisterController::class, 'create' ] )->name ( 'register' );
    Route::post ( 'register', [ RegisterController::class, 'store' ] )->name ( 'register' );
} );

Route::middleware ( 'auth:web' )->group ( function () {
    Route::delete ( 'logout', [ LoginController::class, 'destroy' ] )->name ( 'logout' );
    Route::get ( 'dashboard', [ DashboardController::class, 'index' ] )->name ( 'dashboard' );
    Route::resource ( 'accounts', AccountController::class )->except ( 'show' );
    Route::resource ( 'addresses', AddressController::class )->except ( 'show' );
    Route::resource ( 'tasks', TaskController::class )->except ( 'show' );
} );
