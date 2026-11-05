<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar habilidad</title>
</head>
<body>

    <h1>Editar habilidad</h1>

    <form action="{{ route('skills.update', $skill->id) }}" method="POST">

        @csrf
        @method('PUT')

        <label for="name">Nombre de la habilidad:</label>
        <input type="text" name="name" id="name" value="{{ $skill->name }}">

        <br><br>

        <label for="description">Descripción:</label>
        <input type="text" name="description" id="description" value="{{ $skill->description }}">

        <br><br>

        <label for="category">Categoría:</label>
        <input type="text" name="category" id="category" value="{{ $skill->category }}">

        <br><br>

        <button type="submit">Actualizar</button>

    </form>

    <br>

    <a href="{{ route('skills.index') }}">Volver</a>

</body>
</html>