<?php
declare(strict_types=1);

namespace App\Productos;

use App\Traits\Descuento;


use DateTime;

class Comida extends Productos
{
    //Utilizamos el trait Descuento para poder aplicar descuento
    use Descuento;
    //Atributo caducidad de la comida
    protected DateTime $caducidad;

    //Constructor
    public function __construct(string $id, string $nombre, float $precio, DateTime $caducidad)
    {
        parent::__construct($id, $nombre, $precio);
        $this->caducidad = $caducidad;
    }

    //Funcion extra para comprobar si un producto esta caducado
    public function comprobarCaducidad(): bool
    {
        //Devolvemos un bool si la fecha de caducidad es menor a la fecha actual
        return $this->caducidad < new DateTime();
    }

    //Funcion para mostrar la descripcion de la comida
    public function mostrarDescripcion(): void
    {
        echo "El nombre del producto es: " . $this->getNombre() . " y su precio es: " . $this->getPrecio() . " y la fecha de caducidad es: " . $this->caducidad->format('Y-m-d');
    }

    public function getCaducidad(): DateTime
    {
        return $this->caducidad;
    }

    // Sobrescribimos calcularPrecioConIVA para aplicar el descuento
    public function calcularPrecioConIVA(): float
    {
        $precioBase = parent::calcularPrecioConIVA();
        return $this->aplicarDescuento($precioBase);
    }
}
