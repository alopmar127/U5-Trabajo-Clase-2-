<?php
declare(strict_types=1);

namespace App\Productos;



//Clase abstracta debido a que implementa un metodo abstracto y además se definira mejor en sus clases hijas
//Implementa la interface VendibleInterface para obligar a todas las clases hijas a tener un IVA definido y usar el metodo calcularPrecioConIVA
abstract class Productos implements VendibleInterface
{

    // En esta carpeta se podrían crear más clases para otros tipos de productos
    // Se pueden crear más carpetas en app/ para organizar las clases

    //Constante con el IVA
    public const IVA = 21;

    //Sintaxis Constructor Property Promotion
    public function __construct(private string $id, private string $nombre, private float $precio) {
      
    }
    //Metodo abstracto que definiremos en las clases hijas
    abstract public function mostrarDescripcion(): void;

    //Funcion que calcula el precio con IVA
    public function calcularPrecioConIva(): float
    {
        return $this->precio * (1 + self::IVA / 100);
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }
}
