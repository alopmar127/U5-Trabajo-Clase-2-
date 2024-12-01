<?php
declare(strict_types=1);

use App\Models\ElectronicoModel;

// Instanciar modelo
$electronicoModel = new ElectronicoModel();

// Obtener productos de electrónicos
$electronico = $electronicoModel->obtenerDatosConProducto();

// Mostrar productos de electrónicos
echo "<div class='category'>";
echo "<h3>Electrónicos</h3>";
echo "<div class='product-list'>";
foreach ($electronico as $item) {
    echo "<div class='product-card'>
            <h4>{$item['productos_nombre']}</h4>
            <p>Modelo: {$item['electronico_modelo']}</p>
            <p class='price'>Precio: {$item['productos_precio']}€</p>
            <form method='POST' action='carrito'>
                <input type='hidden' name='id' value='{$item['productos_id']}'>
                <input type='hidden' name='nombre' value='{$item['productos_nombre']}'>
                <input type='hidden' name='precio' value='{$item['productos_precio']}'>
                <input type='hidden' name='modelo' value='{$item['electronico_modelo']}'>
                <button class='add-to-cart-btn'>Añadir al carrito</button>
            </form>
          </div>";
}
echo "</div>";
echo "</div>";
?>
