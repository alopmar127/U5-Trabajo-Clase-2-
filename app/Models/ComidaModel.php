<?php
declare(strict_types=1);

namespace App\Models;

class ComidaModel extends Model
{
    protected $table = 'comida'; // Tabla secundaria
    protected $table2 = 'productos'; // Tabla principal

    public function obtenerDatosConProducto(): array
    {
        return $this->joinTablas(['id', 'caducidad'], ['id', 'nombre', 'precio']);
    }
}
