<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar certificado – Plataforma de Habilidades</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 16px;
               font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; background: #150f18; color: #f3eaf6; }
        .tarjeta { width: 100%; max-width: 460px; background: #231b26; border: 1px solid #382f3c; border-radius: 20px; padding: 28px; }
        h1 { font-size: 22px; margin: 0 0 6px; }
        p { margin: 0 0 16px; color: #cbbfd1; line-height: 1.5; }
        form { display: flex; gap: 8px; margin-bottom: 20px; }
        input { flex: 1; min-width: 0; padding: 12px 14px; border-radius: 12px; border: 1px solid #4a3f50; background: #1d1620;
                color: #fff; font: 600 16px ui-monospace, Menlo, monospace; text-transform: uppercase; letter-spacing: .06em; }
        button { padding: 12px 18px; border: 0; border-radius: 12px; background: #db2777; color: #fff; font-weight: 700; font-size: 15px; cursor: pointer; }
        .resultado { border-radius: 14px; padding: 16px; }
        .valido { background: rgba(22, 163, 74, .15); border: 1px solid rgba(34, 197, 94, .5); }
        .invalido { background: rgba(220, 38, 38, .15); border: 1px solid rgba(248, 113, 113, .5); }
        .resultado strong { display: block; font-size: 17px; margin-bottom: 8px; }
        dl { margin: 0; display: grid; grid-template-columns: auto 1fr; gap: 4px 12px; font-size: 14px; }
        dt { color: #cbbfd1; } dd { margin: 0; font-weight: 600; }
        a { color: #ffb0cd; }
    </style>
</head>
<body>
    <main class="tarjeta">
        <h1>Verificar certificado</h1>
        <p>Escribe el código que aparece en la parte de abajo del certificado.</p>

        <form method="GET" action="{{ route('certificado.verificar') }}">
            <label for="codigo" style="position:absolute; left:-9999px;">Código de verificación</label>
            <input id="codigo" name="codigo" value="{{ $codigo }}" placeholder="XXXX-XXXX-XX" autocomplete="off" required>
            <button type="submit">Verificar</button>
        </form>

        @if ($codigo !== '')
            @if ($certificado)
                <div class="resultado valido" role="status">
                    <strong>✅ Certificado válido</strong>
                    <dl>
                        <dt>Estudiante</dt><dd>{{ $certificado->estudiante->nombre }}</dd>
                        <dt>Curso</dt><dd>{{ $certificado->curso->nombre }}</dd>
                        <dt>Emitido</dt><dd>{{ $certificado->created_at->format('d/m/Y') }}</dd>
                        <dt>Código</dt><dd>{{ $certificado->codigo }}</dd>
                    </dl>
                </div>
            @else
                <div class="resultado invalido" role="status">
                    <strong>❌ No encontramos ese código</strong>
                    Revisa que esté bien escrito. Si el problema sigue, el certificado no es válido.
                </div>
            @endif
        @endif

        <p style="margin: 20px 0 0; font-size: 13px;"><a href="{{ url('/') }}">← Plataforma de Habilidades</a></p>
    </main>
</body>
</html>
