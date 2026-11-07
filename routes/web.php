<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Certificados
Route::get('/certificados/{curso}', [\App\Http\Controllers\CertificadoController::class, 'mostrar'])->name('certificado');
Route::get('/verificar-certificado', [\App\Http\Controllers\CertificadoController::class, 'verificar'])->name('certificado.verificar');

// Evidencias del plan de mejoramiento: sirve los archivos de docs/ (solo administrador)
Route::get('/evidencias/{archivo?}', function (string $archivo = 'evidencias.html') {
    $docs = realpath(base_path('docs'));
    $ruta = realpath($docs.'/'.$archivo);
    abort_unless(auth()->user()?->role?->nombre === 'admin', 403);
    abort_unless($ruta && str_starts_with($ruta, $docs.DIRECTORY_SEPARATOR) && is_file($ruta), 404);

    return response()->file($ruta);
})->where('archivo', '.*')->name('evidencias');
