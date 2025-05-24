<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\UserController; 
Route::get('/', function () {
    return view('welcome');
});

Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');

Route::post('/store', [UserController::class, 'store'])->name('usuarios.store');

Route::get('/login', [UserController::class, 'login'])->name('usuarios.login');

Route::post('/loginProces', [LoginController::class, 'loginProcess'])->name('login.process');



Route::middleware(['auth','account'])->group(function(){


    
        Route::delete('/eliminar/user/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

        Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('usuarios.edit');

        Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');


        Route::post('/logout', function () {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect('/login')->with('success', 'Sesión cerrada correctamente');
        })->name('logout');
});

Route::get('/users/activate/account/{token}', [LoginController::class, 'validateAccount'])->name('activate.account');
Route::get('/usuarios/espera-confirmacion', function () {
    return view('usuarios.espera_confirmacion');
})->name('usuarios.espera_confirmacion');




