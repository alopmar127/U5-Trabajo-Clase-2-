<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos por Categoría</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        h1, h3 {
            text-align: center;
            color: #333;
        }

        .category {
            margin: 20px 0;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .category h3 {
            margin-bottom: 10px;
            font-size: 1.5em;
            color: #333;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .product-card {
            width: 250px;
            background-color: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product-card h4 {
            margin: 10px 0;
            font-size: 1.2em;
            color: #333;
        }

        .product-card p {
            margin: 10px 0;
            color: #666;
        }

        .product-card .price {
            font-size: 1.2em;
            font-weight: bold;
            color: #2ecc71;
        }

        .product-card .add-to-cart-btn {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .product-card .add-to-cart-btn:hover {
            background-color: #2980b9;
        }

        .product-card .add-to-cart-btn:disabled {
            background-color: #bdc3c7;
            cursor: not-allowed;
        }

    </style>
</head>

<body>
    <h1>Productos por Categoría</h1>

    <?php
    use App\Models\RopaModel;
    use App\Models\ComidaModel;
    use App\Models\ElectronicoModel;

    // Instanciar los modelos
    $ropaModel = new RopaModel();
    $comidaModel = new ComidaModel();
    $electronicoModel = new ElectronicoModel();

    // Obtener los productos por categoría
    $ropa = $ropaModel->obtenerDatosConProducto();
    $comida = $comidaModel->obtenerDatosConProducto();
    $electronico = $electronicoModel->obtenerDatosConProducto();

    // Mostrar productos de Ropa
    echo "<div class='category'>";
    echo "<h3>Ropa</h3>";
    echo "<div class='product-list'>";
    foreach ($ropa as $item) {
        echo "<div class='product-card'>
                <img src='img/ropa.jpg' alt='Imagen de ropa'>
                <h4>{$item['productos_nombre']}</h4>
                <p>Talla: {$item['ropa_talla']}</p>
                <p class='price'>Precio: {$item['productos_precio']}€</p>
                <button class='add-to-cart-btn'>Añadir al carrito</button>
              </div>";
    }
    echo "</div>";
    echo "</div>";

    // Mostrar productos de Comida
    echo "<div class='category'>";
    echo "<h3>Comida</h3>";
    echo "<div class='product-list'>";
    foreach ($comida as $item) {
        echo "<div class='product-card'>
                <img src='img/comida.jpg' alt='Imagen de comida'>
                <h4>{$item['productos_nombre']}</h4>
                <p>Caducidad: {$item['comida_caducidad']}</p>
                <p class='price'>Precio: {$item['productos_precio']}€</p>
                <button class='add-to-cart-btn'>Añadir al carrito</button>
              </div>";
    }
    echo "</div>";
    echo "</div>";

    // Mostrar productos de Electrónico
    echo "<div class='category'>";
    echo "<h3>Electrónico</h3>";
    echo "<div class='product-list'>";
    foreach ($electronico as $item) {
        echo "<div class='product-card'>
                <img src='img/electronico.jpg' alt='Imagen de electrónico'>
                <h4>{$item['productos_nombre']}</h4>
                <p>Modelo: {$item['electronico_modelo']}</p>
                <p class='price'>Precio: {$item['productos_precio']}€</p>
                <button class='add-to-cart-btn'>Añadir al carrito</button>
              </div>";
    }
    echo "</div>";
    echo "</div>";
    ?>

</body>

</html>
