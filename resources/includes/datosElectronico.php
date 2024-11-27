<?php

use App\Models\ElectronicoModel;

// Instanciar modelo
$electronicoModel = new ElectronicoModel();

// Obtener producto
$electronico = $electronicoModel->obtenerDatosConProducto();

// Mostrar productos de Ropa
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