<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habilidades</title>
</head>
<body>

    <h1>Habilidades disponibles</h1>

    @if($skills->isEmpty())

        <p>Aún no hay habilidades registradas.</p>

    @else

        @foreach($skills as $skill)

            <h2>{{ $skill->name }}</h2>

            <p>{{ $skill->description }}</p>

            <p>Categoría: {{ $skill->category }}</p>

            <a href="{{ route('skills.edit', $skill->id) }}">
                Editar
            </a>

            <br><br>

            <form action="{{ route('skills.destroy', $skill->id) }}" method="POST">

                @csrf
                @method('DELETE')

                <button type="submit">
                    Eliminar
                </button>

            </form>

            <hr>

        @endforeach

    @endif

    <br>

    <a href="{{ route('skills.create') }}">
        Crear nueva habilidad
    </a>

</body>
</html>