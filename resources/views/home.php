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
    //Array ( [0] => Array ( [ropa_id] => 1 [ropa_talla] => M [productos_id] => P001 [productos_nombre] => Camiseta [productos_precio] => 15.99 ) [1] => Array ( [ropa_id] => 2 [ropa_talla] => L [productos_id] => P002 [productos_nombre] => Pantalón [productos_precio] => 30.5 ) [2] => Array ( [ropa_id] => 3 [ropa_talla] => S [productos_id] => P003 [productos_nombre] => Sudadera [productos_precio] => 25 ) [3] => Array ( [ropa_id] => 4 [ropa_talla] => XL [productos_id] => P004 [productos_nombre] => Chaqueta [productos_precio] => 50 ) [4] => Array ( [ropa_id] => 5 [ropa_talla] => M [productos_id] => P005 [productos_nombre] => Zapatos [productos_precio] => 65 ) )
    foreach ($ropa as $ropa) {
        echo "Id producto: {$ropa['ropa_id']},  Nombre: {$ropa['productos_nombre']}, Talla: {$ropa['ropa_talla']}, Precio: {$ropa['productos_precio']}<br>";
    }

    ?>
</body>

</html>