<?php
session_start();
$nombre_alumno = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mito o Leyenda - Plataforma Oaxaca</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="interfaz-principal efecto-flotante">
        
        <div class="encabezado-juego">
            <h1 class="titulo-rojo efecto-flotante">¿Mito o Leyenda?, <?= htmlspecialchars($nombre_alumno) ?></h1>
        </div>

        <div class="contenedor-bloques">
            <!-- BLOQUE: MITO -->
            <div class="bloque-concepto">
                <h2 class="titulo-concepto">-Mito-</h2>
                <div class="contenido-concepto">
                    <div class="ilustracion-espacio">
                        <div class="contenedor-imagen-mito">
                            <img src="img_parte2/img1.png" alt="Ilustración de una criatura mítica" class="imagen-mito">
                        </div>
                    </div>
                    <div class="lista-caracteristicas">
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">🏛️</span>
                            <span>Son relatos que narran las hazañas de seres sobrenaturales, por lo general intentan explicar el origen del mundo o del hombre.</span>
                        </div>
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">🌀</span>
                            <span>Sus personajes suelen ser dioses, semidioses, héroes o monstruos que se consideran extraordinarios.</span>
                        </div>
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">⏳</span>
                            <span>Transcurren fuera del tiempo histórico real o en un tiempo indeterminado (época sagrada).</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BLOQUE: LEYENDA -->
            <div class="bloque-concepto">
                <h2 class="titulo-concepto">-Leyenda-</h2>
                <div class="contenido-concepto">
                    <div class="ilustracion-espacio">               
                         <img src="img_parte2/img2.png" alt="Imagen de Leyenda" class="imagen-leyenda">
                    </div>
                    <div class="lista-caracteristicas">
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">⛪</span>
                            <span>Es una narración breve cuyo propósito es explicar los hechos tradicionales y costumbres de un pueblo de forma sobrenatural.</span>
                        </div>
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">🧔</span>
                            <span>Se basan en testimonios de personas, elementos verdaderos, hechos históricos o personajes concretos.</span>
                        </div>
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">👥</span>
                            <span>Mezcla la ficción y la realidad. Tienen tiempo y lugar preciso. Tiene una finalidad moral.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fila-inferior">
            <div class="bloque-similitudes">
                <div class="titulo-similitudes efecto-flotante">¿En qué se parecen?</div>
                <div class="grid-similitudes">
                    <div class="columna-similitud">
                        <span style="font-size: 24px;">🗣️</span>
                        <span>Pasan de generación en generación, por medio de la transmisión oral o escrita.</span>
                    </div>
                    <div class="columna-similitud">
                        <span style="font-size: 24px;">🌺</span>
                        <span>Buscan explicar un evento o fenómeno que resulta enigmático o misterioso.</span>
                    </div>
                    <div class="columna-similitud">
                        <span style="font-size: 24px;">🗺️</span>
                        <span>Forman parte de la cultura y costumbres de nuestras comunidades.</span>
                    </div>
                </div>
            </div>

            <div class="bloque-boton">
               <button class="mi-boton" onclick="cambiarPestana()">INICIO</button>
            </div>
            
            <script>
                function cambiarPestana(){
                    // Avanza directo a la plataforma principal interactiva
                    window.location.href = "index.html";
                }
            </script>
        </div>
    </div>
</body>
</html>


