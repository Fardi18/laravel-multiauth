<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// AUTH
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'doLogin']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/userregister', [AuthController::class, "userRegister"])->name('userregister');
Route::get('/pkaregister', [AuthController::class, "pkaRegister"])->name('pkaregister');
Route::post('/userregister', [AuthController::class, "doUserRegister"])->name('do.userregister');
Route::post('/pkaregister', [AuthController::class, "doPkaRegister"])->name('do.pkaregister');


Route::get('/', [PageController::class, 'user']);
// user
Route::middleware(['auth:web'])->group(
    function () {
        // isi disini routing yang cuma bisa diakses oleh user
        // contoh penulisan
        // Route::get('/', [PageController::class, 'user']);
    }
);

// admin
Route::prefix('/admin')->middleware('auth:admin')->group(
    function () {
        Route::get('/', [PageController::class, 'admin']);
    }
);

// pka
Route::prefix('/pka')->middleware('auth:pka')->group(
    function () {
        Route::get('/', [PageController::class, 'pka']);
    }
);
