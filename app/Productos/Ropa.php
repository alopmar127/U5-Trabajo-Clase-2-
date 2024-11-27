<?php

namespace App\Productos;


class Ropa extends Productos
{
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
}
