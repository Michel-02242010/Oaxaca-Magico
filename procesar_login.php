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
            
            // Redirección inmediata a la pantalla intermedia tras un ingreso exitoso
           if (isset($_POST['ir_al_mapa'])) {
    header("Location: index.html");
} else {
    header("Location: inter.php");
}

            exit();
        }
    }
}
?>