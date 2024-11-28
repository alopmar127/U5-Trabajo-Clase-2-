<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Productos\Carrito;
use App\Productos\Ropa;
use App\Productos\Comida;
use App\Productos\Electronico;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['nombre'], $_POST['precio'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = (float)$_POST['precio'];

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_POST['talla'])) {
        $ropa = new Ropa($id, $nombre, $precio, $_POST['talla']);
        $_SESSION['carrito'][] = $ropa;
    } elseif (isset($_POST['caducidad'])) {
        $caducidad = new DateTime($_POST['caducidad']);
        $comida = new Comida($id, $nombre, $precio, $caducidad);
        $_SESSION['carrito'][] = $comida;
    } elseif (isset($_POST['modelo'])) {
        $electronico = new Electronico($id, $nombre, $precio, $_POST['modelo']);
        $_SESSION['carrito'][] = $electronico;
    }
}

$carrito = new Carrito();
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_eliminar'])) {
    $idEliminar = $_POST['id_eliminar'];
    $_SESSION['carrito'] = array_filter($_SESSION['carrito'], function ($producto) use ($idEliminar) {
        return $producto->getId() !== $idEliminar;
    });

    header("Location: /carrito");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vaciar'])) {
    unset($_SESSION['carrito']);

    header("Location: /carrito");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    $tituloPagina = 'Inicio';
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
            <?php if (!empty($_SESSION['carrito'])): ?>
                <ul>
                    <?php foreach ($_SESSION['carrito'] as $producto): ?>
                        <li class="cart-item">
                            <div class="cart-item-info">
                                <span class="product-name"><?= $producto->getNombre(); ?></span>
                                <span><?= $producto->mostrarDescripcion(); ?></span>
                            </div>
                            <div class="cart-item-actions">
                                <form method="POST" action="">
                                    <input type="hidden" name="id_eliminar" value="<?= $producto->getId(); ?>">
                                    <button type="submit">Eliminar</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p class="cart-total">Total con IVA: <?= $carrito->calcularTotal(); ?>€</p>
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