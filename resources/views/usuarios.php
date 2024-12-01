<?php

include_once __DIR__ . '/../../resources/includes/filtrar.php';

use App\Personas\Empleados;
use App\Models\UsuarioModel; // Recuerda el uso del autoload.php

//Usar el where de model para filtrar por nombre 


// Obtener usuarios con nombre "Juan"
// $usuarios = $model->obtenerPorCampo('nombre', '=', 'test1');

// // Mostrar los usuarios
// foreach ($usuarios as $usuario) {
//     echo "ID: {$usuario['id']}, Nombre: {$usuario['nombre']}, Apellidos: {$usuario['apellidos']}<br>";
// }


$usuarioTransa = new UsuarioModel();

//Procedimientos
$mensajeTransa = "";
//Ejemplo de procedimiento con IN OUT
if (isset($_POST['buscartrans'], $_POST['id'])) {
    try {
        $id = (int)filtrar($_POST['id']);
        $usuarioTransa->iniciarTransaccion();
        $parametros = [
            'idUsuario' => ['tipo' => 'IN', 'valor' => $id],
            'nombreUsuario' => ['tipo' => 'OUT']
        ];
        $resultados = $usuarioTransa->ejecutarProcedimiento('obtenerNombreUsuario', $parametros);

        $usuarioTransa->confirmarTransaccion();

        $mensajeTransa =  "El nombre del usuario es: " . $resultados['nombreUsuario'];
    } catch (\Exception $e) {
        $usuarioTransa->deshacerTransaccion();
        $mensajeTransa =  "Error al buscar el usuario: " . $e->getMessage();
    }
}


//Ejemplo insertar usuario con IN 
$mensajeInsertarProce = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['apellidos'], $_POST['insertarProce'])) {
    try {
        // Iniciar transacción
        $usuarioTransa->iniciarTransaccion();
        //filtramos datos post
        $nombre =  strval(filtrar($_POST['nombre']));
        $apellidos = strval(filtrar($_POST['apellidos']));
        // Crear empleado para usar objetos
        $empleado = new Empleados($nombre, $apellidos);
        //Seguimos usando objetos para obtener los datos del empleado creado
        $nombre =  strval($empleado->getNombre());
        $apellidos = strval($empleado->getApellido());
        // Crear usuario
        $parametros = [
            'nombreUsuario' => ['tipo' => 'IN', 'valor' => $nombre],
            'apellidosUsuario' => ['tipo' => 'IN', 'valor' => $apellidos]
        ];
        $usuarioTransa->ejecutarProcedimiento('agregarUsuario', $parametros);
        // Confirmar transacción
        $usuarioTransa->confirmarTransaccion();
        // Mostrar mensaje de inserción
        $mensajeInsertarProce = "Usuario creado correctamente";
    } catch (\Exception $e) {
        // Deshacer transacción en caso de error
        $usuarioTransa->deshacerTransaccion();
        // Mostrar mensaje de error
        $mensajeInsertarProce = "Error al crear el usuario: " . $e->getMessage();
    }
}


$usuarioModel = new UsuarioModel();
$mensajeBuscar = "";
$datosbuscados = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscarPorNombre'], $_POST['nombre'])) {
    try {
        // Iniciar transacción
        $usuarioModel->iniciarTransaccion();
        //Obtener usuarios con nombre 

        $nombre = filtrar($_POST['nombre']);
        $usuarios = $usuarioModel
            ->where('nombre', 'LIKE', '%' . $nombre . '%')
            ->get();
        // Confirmar transacción
        $usuarioModel->confirmarTransaccion();
        $mensajeBuscar = "Usuarios encontrados: " . count($usuarios);
        $datosbuscados = $usuarios;
    } catch (\Exception $e) {
        // Deshacer transacción en caso de error
        $usuarioModel->deshacerTransaccion();
        $mensajeBuscar =  "Error al buscar el usuario: " . $e->getMessage();
    }
}
// $usuarios = $model
//     ->where('nombre', 'LIKE', '%Test%')
//     ->get();

// foreach ($usuarios as $usuario) {
//     echo "ID: {$usuario['id']}, Nombre: {$usuario['nombre']}, Apellidos: {$usuario['apellidos']}<br>";
// }


//Actualizar usuario en la BBDD
$mensajeActualizar = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['nombre'], $_POST['apellidos'], $_POST['actualizarUsuario'])) {
    try {
        // Iniciar transacción
        $usuarioModel->iniciarTransaccion();
        //Filtralos los datos del post
        $id = (int)filtrar($_POST['id']);
        $nombre = filtrar($_POST['nombre']);
        $apellidos = filtrar($_POST['apellidos']);

        //Actualizamos el usuario con el metodo update del model
        $resultado = $usuarioModel->update($id, ['nombre' => $nombre, 'apellidos' => $apellidos]);

        // Confirmar transacción
        $usuarioModel->confirmarTransaccion();

        // Mostrar mensaje de actualización
        $mensajeActualizar = "Usuario actualizado correctamente";
        // Redirige después de la operación para evitar reenvío del formulario
        // header('Location: usuarios');
        // exit;
    } catch (\Exception $e) {
        // Deshacer transacción en caso de error
        $usuarioModel->deshacerTransaccion();
        // Mostrar mensaje de error
        $mensajeActualizar = "Error al actualizar el usuario: " . $e->getMessage();
        // Redirige después de la operación para evitar reenvío del formulario
        // header('Location: usuarios');
        // exit;
    }
}


//Insertar usuario en la BBDD
$mensajeInsertar = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['apellidos'], $_POST['insertarUsuario'])) {
    try {
        // Iniciar transacción
        $usuarioModel->iniciarTransaccion();
        //filtramos datos post
        $nombre =  strval(filtrar($_POST['nombre']));
        $apellidos = strval(filtrar($_POST['apellidos']));
        // Crear empleado para usar objetos
        $empleado = new Empleados($nombre, $apellidos);
        //Seguimos usando objetos para obtener los datos del empleado creado
        $nombre =  strval($empleado->getNombre());
        $apellidos = strval($empleado->getApellido());
        // Crear usuario
        $usuarioModel->create(['nombre' => $nombre, 'apellidos' => $apellidos]);
        // Confirmar transacción
        $usuarioModel->confirmarTransaccion();
        // Mostrar mensaje de inserción
        $mensajeInsertar = "Usuario creado correctamente";
    } catch (\Exception $e) {
        // Deshacer transacción en caso de error
        $usuarioModel->deshacerTransaccion();
        // Mostrar mensaje de error
        $mensajeInsertar = "Error al crear el usuario: " . $e->getMessage();
    }
}

//Eliminar usuario de la BBDD
$mensajeEliminar = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminarUsuario']) && isset($_POST['id']) && $_POST['id'] !== '' && is_numeric($_POST['id'])) {

    try {
        // Iniciar transacción
        $usuarioModel->iniciarTransaccion();

        $id = (int)filtrar($_POST['id']);
        $usuarioModel->delete($id);
        // Confirmar transacción
        $usuarioModel->confirmarTransaccion();

        $mensajeEliminar = "Usuario eliminado correctamente.";
    } catch (\Exception $e) {
        // Deshacer transacción en caso de error
        $usuarioModel->deshacerTransaccion();
        $mensajeEliminar = "Error al eliminado el usuario: " . $e->getMessage();
    }
}

//Recuperar usuarios de la BBDD
$usuarios = $usuarioModel->all();





//formulario para buscar usuarios
$find = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['buscarid'])) {
    try {
        // Iniciar transacción
        $usuarioModel->iniciarTransaccion();
        //usar el find
        $id = (int)filtrar($_POST['id']);
        $find = $usuarioModel->find($id);
        // Confirmar transacción
        $usuarioModel->confirmarTransaccion();
    } catch (\Exception $e) {
        // Deshacer transacción en caso de error
        $usuarioModel->deshacerTransaccion();
        echo "Error al buscar el usuario: " . $e->getMessage();
    }
}


?>
<!DOCTYPE html>
<html lang="es">

<head>

    <head>
        <?php $tituloPagina = 'Usuarios';
        require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php'; ?>
    </head>
</head>

<body>

    <header>
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php'; ?>
    </header>

    <nav>
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'nav.php'; ?>
    </nav>

    <h1>Usuarios</h1>

    <table class="table">
        <thead class="table-header">
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Apellidos</th>
            </tr>
        </thead>
        <tbody>
            <h2> Listado de Usuarios</h2>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['apellidos']; ?></td>
                    <td>
                        <form method="POST" action="usuarios" class="delete-form">
                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                            <input type="hidden" name="eliminarUsuario" value="eliminarUsuario">
                            <input type="submit" name="Eliminar" value="Eliminar">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($mensajeEliminar): ?>
        <p><?= $mensajeEliminar ?></p>
    <?php endif; ?>
    <h2>Total de Usuarios con procedimiento OUT</h2>
    <?php

    //Ejemplo procedimiento con OUT para el total de usuarios
    $mensajeTotal = "";
    try {
        $usuarioTransa->iniciarTransaccion();

        $parametrostotal = [
            'totalUsuarios' => ['tipo' => 'OUT']
        ];

        $total = $usuarioTransa->ejecutarProcedimiento('contarUsuarios', $parametrostotal);
        $usuarioTransa->confirmarTransaccion();
        $mensajeTotal = "El número total de usuarios es: " . $total['totalUsuarios'];
    } catch (\Exception $e) {
        $usuarioTransa->deshacerTransaccion();
        $mensajeTotal =  "Error al buscar el usuario: " . $e->getMessage();
    }

    ?>
    <?php if ($mensajeTotal): ?>
        <p class="section"><?= $mensajeTotal ?></p>
    <?php endif; ?>
    <br>
    <br>
    <div class="form-container">

        <h2>Crear Usuario</h2>
        <!-- Creamos un formulario para insertar un nuevo usuario -->
        <form method="POST" action="usuarios" class="delete-form">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <br>
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" required>
            <input type="hidden" name="insertarUsuario" value="insertarUsuario">
            <br>
            <input type="submit" value="Crear Usuario">
        </form>
        <?php if ($mensajeInsertar): ?>
            <p><?= $mensajeInsertar ?></p>
        <?php endif; ?>
    </div>

    <br>
    <br>
    <div class="form-container">

        <h2>Crear Usuario con procedimientos</h2>
        <!-- Creamos un formulario para insertar un nuevo usuario -->
        <form method="POST" action="usuarios" class="delete-form">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <br>
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" required>
            <input type="hidden" name="insertarProce" value="insertarProce">
            <br>
            <input type="submit" value="Crear Usuario">
        </form>
        <?php if ($mensajeInsertarProce): ?>
            <p><?= $mensajeInsertarProce ?></p>
        <?php endif; ?>
    </div>

    <br>
    <div class="form-container">

        <h2>Modificar Usuario</h2>
        <!-- Modificar usuario -->
        <form method="POST" action="usuarios" class="delete-form">
            <label for="id">Id:</label>
            <input type="text" name="id" id="id" required>
            <br>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <br>
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" required>
            <br>
            <input type="hidden" name="actualizarUsuario" value="actualizarUsuario">
            <input type="submit" value="Modificar Usuario">
        </form>
        <?php if ($mensajeActualizar): ?>
            <p><?= $mensajeActualizar ?></p>
        <?php endif; ?>
    </div>

<br>
    <div class="form-container">

        <h2>Buscar Usuario por ID con transacciones</h2>
        <form method="POST" action="usuarios" class="delete-form">
            <label for="id">Id:</label>
            <input type="text" name="id" id="id" required>
            <input type="hidden" name="buscartrans" id="buscartrans" required>
            <br>
            <input type="submit" value="Buscar Usuario">
        </form>
        <br>
        <!-- Si la variable $buscartransa no es null mostramos los datos -->
        <?php if ($mensajeTransa): ?>
            <p><?= $mensajeTransa ?></p>
        <?php endif; ?>
    </div>
    <br>
    <div class="form-container">

        <h2>Buscar Usuario por ID</h2>
        <form method="POST" action="usuarios" class="delete-form">
            <label for="id">Id:</label>
            <input type="text" name="id" id="id" required>
            <input type="hidden" name="buscarid" id="buscarid" required>
            <br>
            <input type="submit" value="Buscar Usuario">
        </form>
        <!-- Si la variable $find no es null mostramos los datos -->
        <?php if ($find): ?>
            <h2>Datos del Usuario</h2>
            <table class="table">
                <thead class="table-header">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $find['id']; ?></td>
                        <td><?php echo $find['nombre']; ?></td>
                        <td><?php echo $find['apellidos']; ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>


    <br>
    <div class="form-container">

        <h2>Buscar por nombre con LIKE</h2>
        <form method="POST" action="usuarios" class="delete-form">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <input type="hidden" name="buscarPorNombre" value="buscarPorNombre">
            <br>
            <input type="submit" value="Buscar Usuario">
        </form>

        <?php if ($mensajeBuscar): ?>
            <p><?= $mensajeBuscar ?></p>
        <?php endif; ?>
        <br>
        <?php if ($datosbuscados): ?>
            <table class="table">
                <thead class="table-header">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datosbuscados as $usuario): ?>
                        <tr>
                            <td><?php echo $usuario['id']; ?></td>
                            <td><?php echo $usuario['nombre']; ?></td>
                            <td><?php echo $usuario['apellidos']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <footer>
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    </footer>
</body>

</html>