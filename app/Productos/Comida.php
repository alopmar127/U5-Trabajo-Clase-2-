<?php

namespace App\Productos;

use DateTime;

class Comida extends Productos
{
    //Atributo caducidad de la comida
    protected DateTime $caducidad;

    //Constructor
    public function __construct(String $nombre, float $precio, DateTime $caducidad)
    {
        //Llamamos al constructor de la clase padre y le pasamos el nombre y el precio
        parent::__construct($nombre, $precio);
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
}
