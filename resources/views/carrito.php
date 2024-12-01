<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../resources/includes/filtrar.php';

use App\Productos\Carrito;
use App\Productos\Ropa;
use App\Productos\Comida;
use App\Productos\Electronico;


$carrito = new Carrito();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Agregar producto al carrito
    if (isset($_POST['id'], $_POST['nombre'], $_POST['precio'])) {
        //Filtramos los datos
        $id = strval(filtrar($_POST['id']));
        $nombre = strval(filtrar($_POST['nombre']));
        $precio = floatval(filtrar($_POST['precio']));

        //Filtramos por tipo de producto para crearlo segun su campo diferencial 
        if (isset($_POST['talla'])) {
            //Filtramos los datos
            $talla = filtrar($_POST['talla']);
            //Creamos el producto
            $producto = new Ropa($id, $nombre, $precio, $talla);
            //Aplicamos el descuento un 10% solo en ropa
            $producto->setDescuento(10);
        } elseif (isset($_POST['caducidad'])) {
            $caducidad = new DateTime(filtrar($_POST['caducidad']));
            $producto = new Comida($id, $nombre, $precio, $caducidad);
        } elseif (isset($_POST['modelo'])) {
            $modelo = filtrar($_POST['modelo']);
            $producto = new Electronico($id, $nombre, $precio, $modelo);
        }
        //Comprobamos que el producto exista
        if (isset($producto)) {
            //Agregamos el producto al carrito

            $carrito->agregarProducto($producto);

        }
        //Redirigimos al carrito
        header("Location: /carrito");
        exit;
    }

    // Disminuir cantidad de un producto
    if (isset($_POST['id_disminuir'])) {
        //Filtramos los datos
        $idDisminuir = filtrar($_POST['id_disminuir']);
        //Disminuimos la cantidad
        $carrito->disminuirCantidad($idDisminuir);
        //Redirigimos al carrito
        header("Location: /carrito");
        exit;
    }

    // Aumentar cantidad de un producto
    if (isset($_POST['id_aumentar'])) {
        //Filtramos los datos
        $idAumentar = filtrar($_POST['id_aumentar']);
        //Obtenemos los productos del carrito
        $productosEnCarrito = $carrito->getProductos();
        //Comprobamos que el producto exista en el carrito con su id
        if (isset($productosEnCarrito[$idAumentar])) {
            //Obtenemos el producto
            $producto = $productosEnCarrito[$idAumentar]['producto'];
            //Agregamos el producto al carrito
            $carrito->agregarProducto($producto);
        }

        header("Location: /carrito");
        exit;
    }

    // Eliminar producto del carrito
    if (isset($_POST['id_eliminar'])) {
        //Filtramos los datos
        $idEliminar = filtrar($_POST['id_eliminar']);
        //Eliminamos el producto
        $carrito->eliminarProducto($idEliminar);

        header("Location: /carrito");
        exit;
    }

    // Vaciar carrito
    if (isset($_POST['vaciar'])) {
        //Eliminamos la session y al hacerlo se borra el carrito ya que se almacena en ella.
        unset($_SESSION['carrito']);

        header("Location: /carrito");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    $tituloPagina = 'Carrito';
    require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php';
    ?>
</head>

<body>
    <header>
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php'; ?>
    </header>

    <nav>
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'nav.php'; ?>
    </nav>

    <main>
        <h1>Carrito de Compras</h1>

        <div class="cart-container">
            <?php $productos = $carrito->getProductos(); ?>
            <?php if (!empty($productos)): ?>
                <ul>
                    <?php foreach ($productos as $item): ?>
                        <?php $producto = $item['producto']; ?>
                        <li class="cart-item">
                            <div class="cart-item-info">
                                <span class="product-name"><?= $producto->getNombre(); ?></span>
                                <span><?= $producto->mostrarDescripcion(); ?></span>
                                <span>Cantidad: <?= $item['cantidad']; ?></span>
                            </div>
                            <div class="cart-item-actions">
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="id_disminuir" value="<?= $producto->getId(); ?>">
                                    <button type="submit">-</button>
                                </form>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="id_aumentar" value="<?= $producto->getId(); ?>">
                                    <button style="background-color: #1fa13b;" type="submit">+</button>
                                </form>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="id_eliminar" value="<?= $producto->getId(); ?>">
                                    <button type="submit">Eliminar</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p class="cart-total">Total con IVA: <?= round($carrito->calcularTotal(), 2); ?>€</p>
                <div class="cart-actions">
                    <form method="POST" action="">
                        <input type="hidden" name="vaciar" value="1">
                        <button type="submit">Vaciar carrito</button>
                    </form>
                </div>
            <?php else: ?>
                <p>El carrito está vacío.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    </footer>
</body>

</html>
