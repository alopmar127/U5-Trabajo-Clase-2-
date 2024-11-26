<?php

namespace App\Ropa;

use App\Productos\Productos;

class Ropa extends Productos {
     public function __construct(
        string $id,
        string $nombre,
        float $precio,
        string $talla
     )
     {
      parent::__construct($id, $nombre, $precio);
     }

     public function mostrarDescripcion(): void
     {
        echo "Talla: {$this->talla}";   
     }
}
