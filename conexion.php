<?php
$conexion = mysqli_connect("localhost", "jhon", "123", "taller");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>