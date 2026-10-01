<?php
$host = "localhost";
$usuario_db = "root";
$password_db = "";
$nombre_base_datos = "oaxaca";
$conexion = mysqli_connect($host, $usuario_db, $password_db, $nombre_base_datos);
if (!$conexion) {
    die("¡Oh no! No se pudo conectar a la base de datos: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, "utf8mb4");
?>
