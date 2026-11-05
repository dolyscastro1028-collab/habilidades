<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Curso;
use Illuminate\Http\Request;

class CertificadoController extends Controller
{
    // Certificado del estudiante que inició sesión. Solo si completó el 100 % del curso.
    public function mostrar(Curso $curso)
    {
        $estudiante = auth()->user()?->estudiante;

        if (! $estudiante) {
            return redirect('/estudiante/login');
        }

        abort_unless($curso->tieneInscrito($estudiante), 403, 'No estás inscrito en este curso.');
        abort_unless($estudiante->terminoCurso($curso), 403, 'Completa todas las lecciones para obtener el certificado.');

        // Se crea la primera vez que lo abre; después siempre es el mismo (mismo código y fecha)
        $certificado = Certificado::firstOrCreate([
            'estudiante_id' => $estudiante->id,
            'curso_id' => $curso->id,
        ]);

        return view('certificados.certificado', [
            'certificado' => $certificado->load('estudiante.user', 'curso.profesor.user', 'curso.tematica'),
        ]);
    }

    // Página pública: cualquiera puede comprobar si un código es válido
    public function verificar(Request $request)
    {
        $codigo = strtoupper(trim((string) $request->query('codigo', '')));

        $certificado = $codigo === ''
            ? null
            : Certificado::with('estudiante.user', 'curso')->where('codigo', $codigo)->first();

        return view('certificados.verificar', compact('codigo', 'certificado'));
    }
}
