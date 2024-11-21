<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <p class="header-paragraph">Pruebas de consultas (hacer scroll):</p>
    <?php

    use App\Models\UsuarioModel; // Recuerda el uso del autoload.php

    // Se instancia el modelo
    $usuarioModel = new UsuarioModel();

    // Descomentar consultas para ver la creación. Cuando se lanza execute hay código para
    // mostrar la consulta SQL que se está ejecutando.

    // Consulta 
    //  $usuarioModel->all();

    // Consulta
    //$usuarioModel->select('columna1', 'columna2')->get();

    // Consulta
    //  $usuarioModel->select('columna1', 'columna2')
    //              ->where('columna1', '>', '3')
    //              ->orderBy('columna1', 'DESC')
    //              ->get();

    // Consulta
    //  $usuarioModel->select('columna1', 'columna2')
    //              ->where('columna1', '>', '3')
    //              ->where('columna2', 'columna3')
    //              ->where('columna2', 'columna3')
    //              ->where('columna3', '!=', 'columna4', 'OR')
    //              ->orderBy('columna1', 'DESC')
    //              ->get();

    // Consulta
    //  $usuarioModel->create(['id' => 1, 'nombre' => 'nombre1', 'apellidos' => 'apellidos1']);

    // Consulta
    //$usuarioModel->delete(['id' => 1]);

    // Consulta
    //  $usuarioModel->update(['id' => 1], ['nombre' => 'NombreCambiado']);

    echo "Pruebas SQL Query Builder";
    ?>
</body>

</html>