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

    <?php

    use App\Models\RopaModel;
    // Se instancia el modelo
    $productosModel = new ProductosModel();


    //Consultar ropa
    $ropaModel = new RopaModel();
    // $ropa = $ropaModel->all();

    // foreach ($ropa as $ropa) {
    //     $idp = $ropa['id_p'];
    //     // $productosModel->find($idp);
    //     $datos = $productosModel->select('nombre', 'precio')
    //         ->where('id', '=', $idp)
    //         ->get();
    //     var_dump($datos);

    //     echo "Id producto: {$ropa['id_p']}, Nombre: {$datos["nombre"]}, Precio: {$datos['precio']}<br>";
    //     echo "Id producto: {$ropa['id_p']}, Talla: {$ropa['talla']}<br>";
    // }
    $ropa = $ropaModel->obtenerDatosConProducto();
    echo "<h3>Ropa</h3>";
    print_r($ropa);

    foreach ($ropa as $ropa) {
        echo "Id producto: {$ropa['ropa_id']},  Nombre: {$ropa['productos_nombre']}, Talla: {$ropa['ropa_talla']}, Precio: {$ropa['productos_precio']}<br>";
    }

    echo "<br>";

    use App\Models\ComidaModel;

    $comidaModel = new ComidaModel();
    $comida = $comidaModel->obtenerDatosConProducto();
    echo "<h3>Comida</h3>";
    print_r($comida);


    foreach ($comida as $comida) {
        echo "Id producto: {$comida['comida_id']},  Nombre: {$comida['productos_nombre']}, Caducidad: {$comida['comida_caducidad']}, Precio: {$comida['productos_precio']}<br>";
    }

    use App\Models\ElectronicoModel;

    $electronicoModel = new ElectronicoModel();
    $electronico = $electronicoModel->obtenerDatosConProducto();
    echo "<h3>Electronico</h3>";
    print_r($electronico);


    foreach ($electronico as $electronico) {
        echo "Id producto: {$electronico['electronico_id']},  Nombre: {$electronico['productos_nombre']}, Modelo: {$electronico['electronico_modelo']}, Precio: {$electronico['productos_precio']}<br>";
    }
    ?>
</body>

</html>