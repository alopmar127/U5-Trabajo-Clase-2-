<?php

namespace App\Productos;


class Electronico extends Productos
{
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
}
