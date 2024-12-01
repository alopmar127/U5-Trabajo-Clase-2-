<?php
declare(strict_types=1);

namespace App\Productos;
use App\Traits\Descuento;


class Electronico extends Productos
{
    //Utilizamos el trait Descuento para poder aplicar descuento
    use Descuento;
    //Atributo modelo
    private String $modelo;

    //Constructor
    public function __construct(String $id, String $nombre, float $precio, String $modelo)
    {
        //Llamamos al constructor de la clase padre y le pasamos el nombre y el precio
        parent::__construct($id, $nombre, $precio);
        $this->modelo = $modelo;
    }


    public function getModelo(): string
    {
        return $this->modelo;
    }

    //Funcion para mostrar la descripcion del producto electronico
    public function mostrarDescripcion(): void
    {
        echo "El nombre del producto es: " . $this->getNombre() . " y su precio es: " . $this->getPrecio() . " y el modelo es: " . $this->modelo;
    }

            // Sobrescribimos calcularPrecioConIVA para aplicar el descuento
            public function calcularPrecioConIVA(): float
            {
                $precioBase = parent::calcularPrecioConIVA();
                return $this->aplicarDescuento($precioBase);
            }
}
