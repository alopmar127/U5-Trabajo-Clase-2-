<?php

namespace App\Personas;

use App\Models\UsuarioModel;


// Se instancia el modelo


class Empleados {

    // En esta carpeta se podrían crear más clases para otros tipos de personas
    // Se pueden crear más carpetas en app/ para organizar las clases
    public function __construct(private string $nombre, private string $apellido) {
        $usuarioModel = new UsuarioModel();
        //Al llamar al constructor lo insertamos en la BBDD
        $usuarioModel->create(['nombre' => $nombre, 'apellidos' => $apellido]);
    }
    
    }