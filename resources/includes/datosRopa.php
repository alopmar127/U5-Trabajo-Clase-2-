<?php
declare(strict_types=1);


use App\Models\RopaModel;

// Instanciar modelo
$ropaModel = new RopaModel();

// Obtener productos de ropa
$ropa = $ropaModel->obtenerDatosConProducto();

// Mostrar productos de ropa
echo "<div class='category'>";
echo "<h3>Ropa</h3>";
echo "<h5>Descuento del 10%</h5>";
echo "<div class='product-list'>";
foreach ($ropa as $item) {
    echo "<div class='product-card'>
            <h4>{$item['productos_nombre']}</h4>
            <p>Talla: {$item['ropa_talla']}</p>
            <p class='price'>Precio: {$item['productos_precio']}€</p>
            <form method='POST' action='carrito'>
                <input type='hidden' name='id' value='{$item['productos_id']}'>
                <input type='hidden' name='nombre' value='{$item['productos_nombre']}'>
                <input type='hidden' name='precio' value='{$item['productos_precio']}'>
                <input type='hidden' name='talla' value='{$item['ropa_talla']}'>
                <button class='add-to-cart-btn'>Añadir al carrito</button>
            </form>
          </div>";
}
echo "</div>";
echo "</div>";
?>
