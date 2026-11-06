<?php
// Ejemplo de control de sesión por si manejas usuarios en tu proyecto de secundaria
session_start();
$nombre_usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Estudiante';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Mito o Leyenda - Plataforma Oaxaca</title>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style2.css">
</head>
<body>
    

    <!-- CONTENEDOR PRINCIPAL DE LA INTERFAZ -->
    <div class="interfaz-principal efecto-flotante">
        
        <!-- ENCABEZADO -->
        <div class="encabezado-juego">
            <h1 class="titulo-rojo efecto-flotante">¿Mito o Leyenda?</h1>
        </div>

        <!-- SECCIÓN DE CONCEPTOS  -->
        <div class="contenedor-bloques">
            
            <!-- BLOQUE: MITO -->
            <div class="bloque-concepto">
                <h2 class="titulo-concepto">-Mito-</h2>
                <div class="contenido-concepto">
                    <div class="ilustracion-espacio">
                        <div class="contenedor-imagen-mito">
    <img src="img_parte2/img1.png"
         alt="Ilustración de una criatura mítica"
         class="imagen-mito">
</div>
                    </div>
                    <div class="lista-caracteristicas">
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">🏛️</span>
                            <span>Son relatos que narran las zañas de seres sobre naturales, por lo general intentan explicar el origen del mundo o del hombre.</span>
                        </div>
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">🌀</span>
                            <span>Sus personajes suelen ser dioses, semidioses, heroes o moustros que se consideran extraordinarias</span>
                        </div>
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">⏳</span>
                            <span>Tras curren fuera del tiempo historco real o en un tiempo indeterminado (epoca sagrada).</span>
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
                            <span>Es una narración breve cuyo proposito es eplicar los hechos tradicionales y costumbres de un pueblo de forma sobrenatural.</span>
                        </div>
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">🧔</span>
                            <span>Se basan de testimonios de personas, elementos verdaderos, hechos históricos o personajes concretos.</span>
                        </div>
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">👥</span>
                            <span>Mezcla la ficcion y la realidad.
                                Tienen tiempo y lugar preciso.
                                Tiene una finalidad moral.
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- FILA INFERIOR: SIMILITUDES Y ACCIÓN -->
        <div class="fila-inferior">
            
            <div class="bloque-similitudes">
                <div class="titulo-similitudes efecto-flotante">¿En qué se parecen?</div>
                <div class="grid-similitudes">
                    <div class="columna-similitud">
                        <span style="font-size: 24px;">🗣️</span>
                        <span>
                            Pasan de generación en generación, por medio de la transmisión oral o escrita.
                        
                        </span>
                    </div>
                    <div class="columna-similitud">
                        <span style="font-size: 24px;">🌺</span>
                        <span>
                            Buscan explicar un evento o fenómeno que resulta anigmático o misterios.
                        
                        </span>
                    </div>
                    <div class="columna-similitud">
                        <span style="font-size: 24px;">🗺️</span>
                        <span>
                            Forman parte de la cultura y costumbres de nuestras comunidades.
                        
                        </span>
                    </div>
                </div>
            </div>

           
            <div class="bloque-boton">

               <button class="mi-boton" onclick="cambiarPestaña()"> INICIO</button>

            </div>
            <script>
                function cambiarPestaña(){
                    window.location.href= "plataforma.php"
                }
                </script>

        </div>

    </div>
    

</body>
</html>
