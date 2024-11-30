<?php

namespace App\Traits;

trait Descuento
{
    private float $descuento = 0.0; // Porcentaje de descuento (0 a 100)

    public function setDescuento(float $porcentaje): void
    {
        if ($porcentaje < 0 || $porcentaje > 100) {
            throw new \InvalidArgumentException('El porcentaje de descuento debe estar entre 0 y 100.');
        }
        $this->descuento = $porcentaje;
    }

    public function getDescuento(): float
    {
        return $this->descuento;
    }

    public function aplicarDescuento(float $precio): float
    {
        $descuento = ($precio * $this->descuento) / 100;
        return $precio - $descuento;
    }
}
