<?php

namespace App\Models;

class ComidaModel extends Model
{
    protected $table = 'electronico'; // Tabla secundaria
    protected $table2 = 'productos'; // Tabla principal

    public function obtenerDatosConProducto(): array
    {
        return $this->joinTablas(['id', 'modelo'], ['id', 'nombre', 'precio']);
    }
}
