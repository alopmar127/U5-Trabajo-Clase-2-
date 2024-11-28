<?php
use App\Personas\Empleados;
use App\Models\UsuarioModel; // Recuerda el uso del autoload.php

$usuarioModel = new UsuarioModel();

//Actualizar usuario en la BBDD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['nombre'], $_POST['apellidos'])) {
    $id = (int)$_POST['id']; // Asegúrate de convertirlo a entero
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];

    // Depurar datos antes de ejecutar la actualización
    echo "ID recibido: {$id}, Nombre: {$nombre}, Apellidos: {$apellidos} <br>";

    $resultado = $usuarioModel->update($id, ['nombre' => $nombre, 'apellidos' => $apellidos]);

    if ($resultado) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar el usuario.";
    }

    // Redirige después de la operación para evitar reenvío del formulario
    header('Location: usuarios');
    exit;
}


//Insertar usuario en la BBDD
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['apellidos'])){
    $empleado = new Empleados($_POST['nombre'], $_POST['apellidos']);
    $nombre =  strval($empleado->getNombre());
    $apellidos = strval($empleado->getApellido());
    $usuarioModel->create(['nombre' => $nombre, 'apellidos' => $apellidos]);
}

//Eliminar usuario de la BBDD
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && $_POST['id'] !== '' && is_numeric($_POST['id'])){
    $usuarioModel->delete($_POST['id']);
}

//Recuperar usuarios de la BBDD
$usuarios = $usuarioModel->all();

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

    <table>
        <thead>
            <tr>
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
                        <form method="POST" action="usuarios">
                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                            <input type="submit" name="Eliminar" value="Eliminar">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <br>
    <h2>Crear Usuario</h2>
    <!-- Creamos un formulario para insertar un nuevo usuario -->
     <form method="POST" action="usuarios">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" required>
        <br>
        <input type="submit" value="Crear Usuario">
    </form>

    <br>
    <h2>Modificar Usuario</h2>
    <!-- Modificar usuario -->
     <form method="POST" action="usuarios">
        <label for="id">Id:</label>
        <input type="text" name="id" id="id" required>
        <br>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" required>
        <br>
        <input type="submit" value="Modificar Usuario">
    </form>

    <footer>
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    </footer>
</body>

</html>