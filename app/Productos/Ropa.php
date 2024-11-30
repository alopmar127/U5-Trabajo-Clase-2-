<?php

namespace App\Productos;
use App\Traits\Descuento;


class Ropa extends Productos
{
    //Utilizamos el trait Descuento para poder aplicar descuento
    use Descuento;

    //Atributo modelo
    private String $talla;

    //Constructor
    public function __construct(String $id, String $nombre, float $precio, String $talla)
    {
        //Llamamos al constructor de la clase padre y le pasamos el nombre y el precio
        parent::__construct($id, $nombre, $precio);
        $this->talla = $talla;

    }


    //Funcion para mostrar la descripcion del producto electronico
    public function mostrarDescripcion(): void
    {
        echo "El nombre del producto es: " . $this->getNombre() . " y su precio es: " . $this->getPrecio() . " y la talla es: " . $this->talla;
    }

        // Sobrescribimos calcularPrecioConIVA para aplicar el descuento
        public function calcularPrecioConIVA(): float
        {
            $precioBase = parent::calcularPrecioConIVA();
            return $this->aplicarDescuento($precioBase);
        }
}
