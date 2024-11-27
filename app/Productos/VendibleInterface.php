<?php

namespace App\Productos;

//obliga a todas las clases que lo implementen haciendo que todas las clases hijas de productos tengan que tener un IVA
interface VendibleInterface
{
    public function calcularPrecioConIVA(): float;
}
