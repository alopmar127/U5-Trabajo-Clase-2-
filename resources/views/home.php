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


    use App\Models\ProductosModel; // Recuerda el uso del autoload.php

    // Se instancia el modelo
    $productosModel = new ProductosModel();


    // Descomentar consultas para ver la creación. Cuando se lanza execute hay código para
    // mostrar la consulta SQL que se está ejecutando.

    // Consulta 
    // Obtener todos los usuarios en un array
    $productos = $productosModel->all();


    var_dump($productos);
    echo "<br>";
    // Mostrar los usuarios
    foreach ($productos as $producto) {
        echo "ID: {$producto['id']}, Nombre: {$producto['nombre']}, Precio: {$producto['precio']}<br>";
    }

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

    // Consulta INSERTAR FUNCIONA
    //$usuarioModel->create(['nombre' => 'nombre2', 'apellidos' => 'apellidos2', 'edad' => '20']);

    // Consulta DELETE FUNCIONA
    //$usuarioModel->delete(6);

    // Consulta UPDATE FUNCIONA 
    //$usuarioModel->update(6, ['nombre' => 'NombreCambiado']);

    echo "Pruebas SQL Query Builder";
    ?>
</body>

</html>