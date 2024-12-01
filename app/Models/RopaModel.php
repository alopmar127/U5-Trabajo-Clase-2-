<?php
declare(strict_types=1);

namespace App\Models;

class RopaModel extends Model
{
    protected $table = 'ropa'; // Tabla secundaria
    protected $table2 = 'productos'; // Tabla principal

    public function obtenerDatosConProducto(): array
    {
        return $this->joinTablas(['id', 'talla'], ['id', 'nombre', 'precio']);
    }
}
