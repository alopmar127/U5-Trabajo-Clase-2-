<?php

use App\Models\RopaModel;

// Instanciar modelo
$ropaModel = new RopaModel();

// Obtener producto
$ropa = $ropaModel->obtenerDatosConProducto();

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
