<?php

namespace App\Productos;

use Producto;

class Carrito
{
    private array $productos = []; // Almacena productos

    public function __construct()
    {
        if (isset($_SESSION['carrito'])) {
            $this->productos = $_SESSION['carrito'];
        }
    }

    public function agregarProducto($producto): void
    {
        $this->productos[] = $producto;
        $this->guardarEnSesion();
    }

    public function calcularTotal(): float
    {
        return array_reduce(
            $this->productos,
            fn($total, $producto) => $total + $producto->calcularPrecioConIVA(),
            0
        );
    }

    private function guardarEnSesion(): void
    {
        $_SESSION['carrito'] = $this->productos;
    }
}
