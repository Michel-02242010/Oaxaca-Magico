<?php
session_start();
include("conexion.php");

if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

    $consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado && mysqli_num_rows($resultado) == 1) {
        $fila = mysqli_fetch_assoc($resultado);
        
        if ($contrasena == $fila['contrasena']) {
            $_SESSION['alumno_id'] = $fila['id'];
            $_SESSION['alumno_nombre'] = $fila['nombre_alumno'];
            
            // Redirección inmediata a la plataforma principal con pestañas
            header("Location: plataforma.php");
            exit();
        } else {
            echo "<script>alert('contraseña incorrecta'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Alumno no registrado'); window.location='index.php';</script>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>