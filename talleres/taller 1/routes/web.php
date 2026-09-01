<?php

use App\Http\Controllers\CuentaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CuentaController::class, 'inicio'])->name('inicio');
Route::get('/cuentas', [CuentaController::class, 'index'])->name('cuentas.index');
Route::get('/cuentas/crear', [CuentaController::class, 'create'])->name('cuentas.create');
Route::post('/cuentas', [CuentaController::class, 'store'])->name('cuentas.store');
Route::get('/cuentas/{cuenta}', [CuentaController::class, 'show'])->name('cuentas.show');
Route::delete('/cuentas/{cuenta}', [CuentaController::class, 'destroy'])->name('cuentas.destroy');
