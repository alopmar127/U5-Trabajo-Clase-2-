<?php

namespace App\Productos;


class Ropa extends Productos
{
    //Atributo modelo
    private String $talla;

    //Constructor
    public function __construct(String $nombre, float $precio, String $talla)
    {
        //Llamamos al constructor de la clase padre y le pasamos el nombre y el precio
        parent::__construct($nombre, $precio);
    }


    //Funcion para mostrar la descripcion del producto electronico
    public function mostrarDescripcion(): void
    {
        echo "El nombre del producto es: " . $this->getNombre() . " y su precio es: " . $this->getPrecio() . " y la talla es: " . $this->talla;
    }
}
