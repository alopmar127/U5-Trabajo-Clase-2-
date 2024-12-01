<?php
declare(strict_types=1);

namespace App\Productos;

use Producto;

class Carrito
{
    private array $productos = []; // Almacena productos con sus cantidades

    //Constructor carrito
    public function __construct()
    {
        //Iniciamos la sesion aqui para facilitar el acceso a la sesion
        session_start();
        //Si la sesion existe, cargamos los productos
        if (isset($_SESSION['carrito'])) {
            $this->productos = $_SESSION['carrito'];
        }
    }

    //Agregar producto al carrito, nos llega un objeto de tipo clase hija de Producto
    public function agregarProducto($producto): void
    {
        //Obtenemos el id del producto, que sera el de la tabla Productos que es comun en todos
        $id = $producto->getId();
        //Comprobamos si el id esta en el carrito de ese producto
        if (isset($this->productos[$id])) {
            //Si esta añadimos a la cantidad +1
            $this->productos[$id]['cantidad']++;
        } else {
            // Si no está, la cantidad sera = 1
            $this->productos[$id] = [
                'producto' => $producto,
                'cantidad' => 1
            ];
        }
        //Guardamos los productos en la sesion
        $this->guardarEnSesion();
    }

    //Eliminar producto del carrito
    public function eliminarProducto($id): void
    {
        //Si el producto existe, lo eliminamos
        if (isset($this->productos[$id])) {
            //Eliminamos el producto
            unset($this->productos[$id]);
            //Guardamos los productos en la sesion
            $this->guardarEnSesion();
        }
    }

    //Disminuir cantidad de un producto
    public function disminuirCantidad($id): void
    {
        //Si el producto existe, lo disminuimos
        if (isset($this->productos[$id])) {
            //Disminuimos la cantidad con --
            $this->productos[$id]['cantidad']--;
            //Si la cantidad es menor o igual a cero, eliminamos el producto
            if ($this->productos[$id]['cantidad'] <= 0) {
                unset($this->productos[$id]);
            }
            $this->guardarEnSesion();
        }
    }

    //Calcular el total del carrito
    public function calcularTotal(): float
    {
        //Inicializamos el total a 0
        $total = 0;
        //Recorremos todos los productos
        foreach ($this->productos as $item) {
            //Obtenemos el producto y la cantidad
            $producto = $item['producto'];
            $cantidad = $item['cantidad'];
            //Sumamos el precio con IVA multiplicado por la cantidad
            $total += $producto->calcularPrecioConIVA() * $cantidad;
        }
        return $total;
    }

    //Guardar los productos en la sesion
    private function guardarEnSesion(): void
    {
        //Guardamos en una variable session carrito los productos
        $_SESSION['carrito'] = $this->productos;
    }

    //Obtener los productos del carrito
    public function getProductos(): array
    {
        //Return los productos del carrito
        return $this->productos;
    }
}
