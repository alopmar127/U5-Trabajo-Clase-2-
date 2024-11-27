<?php

use App\Models\ComidaModel;

// Instanciar modelo
$comidaModel = new ComidaModel();

// Obtener producto
$comida = $comidaModel->obtenerDatosConProducto();

// Mostrar productos de Ropa
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
?>