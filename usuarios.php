<?php
include("conexion.php");

if (isset($_GET['eliminar'])) {
    $usuario = $_GET['eliminar'];

    $sql = "DELETE FROM usuarios WHERE usuario='$usuario'";
    mysqli_query($conexion, $sql);

    header("Location: usuarios.php");
    exit();
}

if (isset($_POST['guardar'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO usuarios (usuario, password, nombre, apellido, estado)
            VALUES ('$usuario', '$password', '$nombre', '$apellido', '$estado')";

    mysqli_query($conexion, $sql);

    header("Location: usuarios.php");
    exit();
}

if (isset($_POST['actualizar'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $estado = $_POST['estado'];

    $sql = "UPDATE usuarios SET 
                password='$password',
                nombre='$nombre',
                apellido='$apellido',
                estado='$estado'
            WHERE usuario='$usuario'";

    mysqli_query($conexion, $sql);

    header("Location: usuarios.php");
    exit();
}

$editando = false;
$usuario_edit = "";
$password_edit = "";
$nombre_edit = "";
$apellido_edit = "";
$estado_edit = "";

if (isset($_GET['editar'])) {
    $editando = true;
    $usuario = $_GET['editar'];

    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $resultado_editar = mysqli_query($conexion, $sql);
    $fila_editar = mysqli_fetch_assoc($resultado_editar);

    $usuario_edit = $fila_editar['usuario'];
    $password_edit = $fila_editar['password'];
    $nombre_edit = $fila_editar['nombre'];
    $apellido_edit = $fila_editar['apellido'];
    $estado_edit = $fila_editar['estado'];
}

$sql = "SELECT * FROM usuarios";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="mb-4">Tabla de Usuarios</h2>

    <form method="POST" action="usuarios.php">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>Usuario</th>
                    <th>Password</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>
                        <input type="text" name="usuario" class="form-control"
                               value="<?php echo $usuario_edit; ?>"
                               <?php echo $editando ? "readonly" : ""; ?>
                               required>
                    </td>

                    <td>
                        <input type="text" name="password" class="form-control"
                               value="<?php echo $password_edit; ?>"
                               required>
                    </td>

                    <td>
                        <input type="text" name="nombre" class="form-control"
                               value="<?php echo $nombre_edit; ?>"
                               required>
                    </td>

                    <td>
                        <input type="text" name="apellido" class="form-control"
                               value="<?php echo $apellido_edit; ?>"
                               required>
                    </td>

                    <td>
                        <select name="estado" class="form-control" required>
                            <option value="Activo" <?php echo ($estado_edit == "" || $estado_edit == "Activo") ? "selected" : ""; ?>>Activo</option>
                            <option value="Inactivo" <?php echo ($estado_edit == "Inactivo") ? "selected" : ""; ?>>Inactivo</option>
                        </select>
                    </td>

                    <td>
                        <?php if ($editando) { ?>
                            <button type="submit" name="actualizar" class="btn btn-warning btn-sm">Actualizar</button>
                            <a href="usuarios.php" class="btn btn-secondary btn-sm">Cancelar</a>
                        <?php } else { ?>
                            <button type="submit" name="guardar" class="btn btn-success btn-sm">Agregar</button>
                        <?php } ?>
                    </td>
                </tr>

                <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo $fila['usuario']; ?></td>
                        <td><?php echo $fila['password']; ?></td>
                        <td><?php echo $fila['nombre']; ?></td>
                        <td><?php echo $fila['apellido']; ?></td>
                        <td><?php echo $fila['estado']; ?></td>
                        <td>
                            <a href="usuarios.php?editar=<?php echo $fila['usuario']; ?>" class="btn btn-warning btn-sm">Editar</a>

                            <a href="usuarios.php?eliminar=<?php echo $fila['usuario']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
                               Eliminar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>

    <a href="index.html" class="btn btn-secondary">Cerrar sesión</a>

</div>

</body>
</html>