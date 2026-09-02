<form action="/skills" method="POST">

    @csrf

    <div>
        <label for="name">Nombre de la habilidad:</label>
        <input type="text" id="name" name="name">
    </div>

    <br>

    <div>
        <label for="description">Descripción:</label>
        <textarea id="description" name="description"></textarea>
    </div>

    <br>

    <div>
        <label for="category">Categoría:</label>
        <input type="text" id="category" name="category">
    </div>

    <br>

    <button type="submit">Guardar habilidad</button>

</form>