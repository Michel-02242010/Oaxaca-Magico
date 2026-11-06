<?php
session_start();
$nombre_alumno = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intermedio</title>
    <link rel="stylesheet" href="style_inter.css">
</head>
<body>
    <!--------------------Fondo Animado---------------------------->
    <div class="area" >
        <ul class="circles">
            <li></li><li></li><li></li><li></li><li></li>
            <li></li><li></li><li></li><li></li><li></li>
        </ul>
    </div >

    <!---------------------Pergamino Místico----------------------------->
    <div class="parchment">
        <h1 class="titulo">Misión: El Origen de los Relatos</h1>
        
        <p class="texto">¡Bienvenido, Explorador <strong><?= htmlspecialchars($nombre_alumno) ?></strong>! </p>
        <p class="texto" >Las historias antiguas de nuestras comunidades corren el peligro de ser olvidadas. 
            Tu primera tarea consiste en aprender a distinguir la realidad de la fantasía.</p>
        <p class="texto">¿Estás listo?</p>

        <div style="text-align: center;">
            <button class="btn" onclick="window.location.href='parte2.php'">
                <h1>Estoy listo</h1>
            </button>
        </div>
    </div>
</body>
</html>