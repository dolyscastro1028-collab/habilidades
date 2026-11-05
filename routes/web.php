<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Certificados
Route::get('/certificados/{curso}', [\App\Http\Controllers\CertificadoController::class, 'mostrar'])->name('certificado');
Route::get('/verificar-certificado', [\App\Http\Controllers\CertificadoController::class, 'verificar'])->name('certificado.verificar');
