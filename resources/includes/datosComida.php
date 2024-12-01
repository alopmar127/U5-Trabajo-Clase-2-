<?php
declare(strict_types=1);

use App\Models\ComidaModel;

// Instanciar modelo
$comidaModel = new ComidaModel();

// Obtener producto
$comida = $comidaModel->obtenerDatosConProducto();

// Mostrar productos de comida
echo "<div class='category'>";
echo "<h3>Comida</h3>";
echo "<div class='product-list'>";
foreach ($comida as $item) {
    echo "<div class='product-card'>
            <h4>{$item['productos_nombre']}</h4>
            <p>Caducidad: {$item['comida_caducidad']}</p>
            <p class='price'>Precio: {$item['productos_precio']}€</p>
            <form method='POST' action='carrito'>
                <input type='hidden' name='id' value='{$item['productos_id']}'>
                <input type='hidden' name='nombre' value='{$item['productos_nombre']}'>
                <input type='hidden' name='precio' value='{$item['productos_precio']}'>
                <input type='hidden' name='caducidad' value='{$item['comida_caducidad']}'>
                <button class='add-to-cart-btn'>Añadir al carrito</button>
            </form>
          </div>";
}
echo "</div>";
echo "</div>";
?>
