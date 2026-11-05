@php
    $estudiante = $certificado->estudiante;
    $curso = $certificado->curso;
    $fecha = $certificado->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY');
    $urlVerificar = route('certificado.verificar', ['codigo' => $certificado->codigo]);
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado – {{ $curso->nombre }} – {{ $estudiante->nombre }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,400;8..144,600;8..144,800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        /* Hoja A4 horizontal: lo que se ve es exactamente lo que se guarda en PDF */
        @page { size: A4 landscape; margin: 0; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: "Roboto Flex", system-ui, sans-serif; background: #ece7f3; color: #1f1a24;
               -webkit-print-color-adjust: exact; print-color-adjust: exact; }

        .barra { display: flex; justify-content: center; gap: 12px; padding: 18px; }
        .barra a, .barra button { font: 600 15px "Roboto Flex", sans-serif; padding: 10px 20px; border-radius: 999px;
                                  border: 0; cursor: pointer; text-decoration: none; }
        .descargar { background: #db2777; color: #fff; }
        .volver { background: #fff; color: #5b2f8c; border: 1px solid #d8c8ee !important; }

        .hoja { width: 297mm; height: 210mm; margin: 0 auto 32px; background: #fff; position: relative; overflow: hidden;
                box-shadow: 0 10px 40px rgba(60, 20, 90, .18); }
        .marco { position: absolute; inset: 10mm; border: 3px solid transparent; border-radius: 6mm;
                 background: linear-gradient(#fff, #fff) padding-box, linear-gradient(135deg, #db2777, #7c3aed) border-box; }
        .marco::after { content: ""; position: absolute; inset: 3mm; border: 1px solid #e9d5ff; border-radius: 4mm; }
        /* fondo suave con los colores de la marca */
        .hoja { background: radial-gradient(circle at 0 0, rgba(219, 39, 119, .10), transparent 35%),
                            radial-gradient(circle at 100% 100%, rgba(124, 58, 237, .10), transparent 35%), #fff; }

        .contenido { position: absolute; inset: 10mm 10mm 30mm; display: flex; flex-direction: column; align-items: center;
                     justify-content: center; text-align: center; padding: 0 30mm; }
        .marca { display: flex; align-items: center; gap: 8px; font-weight: 800; font-size: 15px; color: #5b2f8c;
                 letter-spacing: .02em; margin-bottom: 9mm; }
        .marca span { display: inline-grid; place-items: center; width: 30px; height: 30px; border-radius: 9px;
                      background: linear-gradient(135deg, #db2777, #7c3aed); color: #fff; font-size: 16px; }
        .titulo { font: 700 40px "Playfair Display", Georgia, serif; color: #3b0764; letter-spacing: .01em; }
        .subtitulo { font-size: 13px; letter-spacing: .32em; text-transform: uppercase; color: #a21caf; margin: 3mm 0 9mm; font-weight: 600; }
        .texto { font-size: 16px; color: #4a4152; }
        .nombre { font: 700 46px "Playfair Display", Georgia, serif; color: #1f1a24; margin: 4mm 0 3mm;
                  padding: 0 10mm 3mm; border-bottom: 2px solid #f0abfc; }
        .curso { font-size: 26px; font-weight: 800; color: #6d28d9; margin: 3mm 0 2mm; }
        .detalle { font-size: 14px; color: #6b6275; }

        .pie { position: absolute; left: 30mm; right: 30mm; bottom: 22mm; display: grid; grid-template-columns: 1fr auto 1fr;
               align-items: end; gap: 10mm; font-size: 13px; color: #4a4152; bottom: 27mm; }
        .firma { text-align: center; }
        .firma .linea { border-top: 1.5px solid #3b0764; padding-top: 2mm; font-weight: 600; color: #1f1a24; }
        .firma small { display: block; color: #6b6275; font-weight: 400; }
        .sello { width: 26mm; height: 26mm; border-radius: 50%; display: grid; place-items: center; color: #fff;
                 background: radial-gradient(circle at 30% 30%, #f472b6, #db2777 45%, #7c3aed); font-size: 30px;
                 box-shadow: 0 0 0 3px #fff, 0 0 0 5px #f0abfc; }
        .codigo { position: absolute; bottom: 17mm; left: 0; right: 0; text-align: center; font-size: 11px; color: #8a8193; }
        .codigo strong { font-family: ui-monospace, Menlo, monospace; color: #5b2f8c; letter-spacing: .08em; }

        @media print {
            body { background: #fff; }
            .barra { display: none; }
            .hoja { margin: 0; box-shadow: none; }
        }
        /* En pantallas pequeñas se ve la hoja escalada */
        @media screen and (max-width: 1150px) { .hoja { zoom: .6; } }
    </style>
</head>
<body>
    <div class="barra">
        <button class="descargar" onclick="window.print()">⬇ Descargar PDF</button>
        <a class="volver" href="{{ url('/estudiante') }}">Volver a mis cursos</a>
    </div>

    <main class="hoja">
        <div class="marco"></div>

        <div class="contenido">
            <div class="marca"><span>★</span> Plataforma de Habilidades</div>

            <h1 class="titulo">Certificado de finalización</h1>
            <p class="subtitulo">Se otorga el presente certificado a</p>

            <p class="nombre">{{ $estudiante->nombre }}</p>

            <p class="texto">por haber completado satisfactoriamente el curso</p>
            <p class="curso">{{ $curso->nombre }}</p>
            <p class="detalle">
                {{ $curso->tematica?->nombre }} · {{ $curso->duracion }} · {{ $curso->lecciones()->count() }} lecciones completadas
            </p>
        </div>

        <div class="pie">
            <div class="firma">
                <div class="linea">{{ $curso->profesor?->nombre ?? 'Profesor del curso' }}<small>Profesor del curso</small></div>
            </div>
            <div class="sello">★</div>
            <div class="firma">
                <div class="linea">{{ ucfirst($fecha) }}<small>Fecha de emisión</small></div>
            </div>
        </div>

        <p class="codigo">Código de verificación: <strong>{{ $certificado->codigo }}</strong> · Verifícalo en {{ $urlVerificar }}</p>
    </main>
</body>
</html>
