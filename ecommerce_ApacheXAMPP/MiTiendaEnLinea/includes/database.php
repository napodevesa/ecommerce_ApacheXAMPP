<?php
$host = "localhost";
$usuario = "Napoleón Devesa Dalio";
$contrasena = "123";
$base_de_datos = "TiendaFrutosSecosUOC";

$conexion = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

if (!$conexion) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}
