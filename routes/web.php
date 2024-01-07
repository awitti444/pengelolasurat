<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KlasiController;
use App\Http\Controllers\SuratController;


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

Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    Route::get('logout', 'logout')->middleware('auth')->name('logout');

    Route::get('/error-permission', function () {
        return view('errors.permission');
    })->name('error.permission');
});

    Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
    return view('dashboard');
    })->name('dashboard');

        // Route::controller(UserController::class)->prefix('staffs')->group(function () {
        //     Route::get('', 'index')->name('staffs');
        //     Route::get('create', 'create')->name('staffs.create');
        //     Route::post('store', 'store')->name('staffs.store');
            // Route::prefix('staffs')->group(function () {
            //     Route::get('', [UserController::class, 'index'])->name('staffs');
            //     Route::get('create', [UserController::class, 'create'])->name('staffs.create');
            //     Route::post('store', [UserController::class, 'store'])->name('staffs.store');
            //     Route::get('show/{id}', [UserController::class, 'show'])->name('staffs.show');
            //     Route::get('edit/{id}', [UserController::class, 'edit'])->name('staffs.edit');

                // Route::get('show/{id}', 'show')->name('staffs.show');
            // Route::get('edit/{id}', 'edit')->name('staffs.edit');
        //     Route::put('edit/{id}', 'update')->name('staffs.update');
        //     Route::delete('destroy/{id}', 'destroy')->name('staffs.destroy');
        // });

        Route::prefix('/staffs')->name('staffs.')->group(function() {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'edit'])->name('edit'); // Change {id} to {user}
            Route::put('/{user}', [UserController::class, 'update'])->name('update'); // Change {id} to {user}
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy'); // Change {id} to {user}
        });   

        Route::prefix('/guru')->name('guru.')->group(function() {
            Route::get('/', [GuruController::class, 'index'])->name('index');
            Route::get('/create', [GuruController::class, 'create'])->name('create');
            Route::post('/store', [Gurucontroller::class, 'store'])->name('store');
            Route::get('/{guru}', [GuruController::class, 'edit'])->name('edit'); // Change {id} to {user}
            Route::put('/{guru}', [GuruController::class, 'update'])->name('update'); // Change {id} to {user}
            Route::delete('/{guru}', [GuruController::class, 'destroy'])->name('destroy'); // Change {id} to {user}
        });  
        
        Route::prefix('/dataklasi')->name('dataklasi.')->group(function() {
        Route::get('/', [KlasiController::class, 'index'])->name('index');
        Route::get('/create', [KlasiController::class, 'create'])->name('create');
        Route::post('/store', [KlasiController::class, 'store'])->name('store'); 
        Route::get('/{letterTypes}', [KlasiController::class, 'edit'])->name('edit'); // Change {id} to {user}
        Route::put('/{letterTypes}', [KlasiController::class, 'update'])->name('update'); // Change {id} to {user}
        Route::delete('/{letterTypes}', [KlasiController::class, 'destroy'])->name('destroy'); // Change {id} to {user}  
        Route::get('/export/pdf', [KlasiController::class, 'export'])->name('export');
        Route::get('/show/{id}', [KlasiController::class, 'show'])->name('show');

        Route::get('/download/{id}', [KlasiController::class, 'downloadPDF'])->name('download');
        Route::get('/print/{id}', [KlasiController::class, 'show'])->name('print');


        });

        Route::prefix('/surat')->name('surat.')->group(function() {
        Route::get('/', [SuratController::class, 'index'])->name('index');
        Route::get('/create', [SuratController::class, 'create'])->name('create');
        Route::post('/store', [SuratController::class, 'store'])->name('store');
        Route::get('/print/{id}', [SuratController::class, 'show'])->name('print');
        Route::get('/{id}', [SuratController::class, 'edit'])->name('edit'); // Change {id} to {user}
        Route::put('/{letter}', [SuratController::class, 'update'])->name('update'); // Change {id} to {user}
        Route::delete('/{letter}', [SuratController::class, 'destroy'])->name('destroy'); // Change {id} to {user}
        Route::get('/export/pdf', [SuratController::class, 'export'])->name('export');
        Route::get('/detail/{id}', [SuratController::class, 'detail'])->name('detail');
        Route::get('/download/{id}', [SuratController::class, 'downloadPDF'])->name('download');


    });

});