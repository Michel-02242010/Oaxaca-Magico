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
    
    <!-- CONEXIÓN CON EL ESTILO INDEPENDIENTE -->
    <link rel="stylesheet" href="style_exp copy.css">
</head>
<body>

    <!-- CONTENEDOR PRINCIPAL DE LA INTERFAZ -->
    <div class="interfaz-principa">
        
        
       
    </div>
<!-- From Uiverse.io by shakil_6466 --> 
<div class="card">
  <div class="gradient-overlay"></div>
  <p>
     <!-- ENCABEZADO -->
        <div class="encabezado-juego">
            <h1 class="titulo-rojo">¿Mito o Leyenda?</h1>
            <p class="subtitulo-dorado">¡Hola, <?php echo htmlspecialchars($nombre_usuario); ?>! Vamos a descubrir sus secretos e identidad cultural.</p>
        </div>

        <!-- SECCIÓN DE CONCEPTOS -->
        <div class="contenedor-bloques">
            
            <!-- BLOQUE: MITO -->
            <div class="bloque-concepto">
                <h2 class="titulo-concepto">Mito</h2>
                <div class="contenido-concepto">
                    <div class="ilustracion-espacio">
                        <span>[ Imagen de Criatura Mítica / Cosmovisión ]</span>
                    </div>
                    <div class="lista-caracteristicas">
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">🪄</span>
                            <span>Explica el origen mediante elementos sagrados y divinos.</span>
                        </div>
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">🌀</span>
                            <span>Resuelve misterios del cosmos, naturaleza y deidades.</span>
                        </div>
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">⏳</span>
                            <span>Se sitúa fuera del tiempo histórico real (época sagrada).</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BLOQUE: LEYENDA -->
            <div class="bloque-concepto">
                <h2 class="titulo-concepto">Leyenda</h2>
                <div class="contenido-concepto">
                    <div class="ilustracion-espacio">
                        <span>[ Imagen de Personaje Local / Templo de Oaxaca ]</span>
                    </div>
                    <div class="lista-caracteristicas">
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">🏛️</span>
                            <span>Tiene un núcleo arraigado en un hecho o lugar histórico real.</span>
                        </div>
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">💡</span>
                            <span>Modifica los sucesos reales agregando ficción popular.</span>
                        </div>
                        <div class="item-caracteristica">
                            <span class="icono-vinyeta">👥</span>
                            <span>Se hereda en las comunidades de generación en generación.</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- FILA INFERIOR: SIMILITUDES Y ACCIÓN -->
        <div class="fila-inferior">
            
            <div class="bloque-similitudes">
                <div class="titulo-similitudes">¿En qué se parecen?</div>
                <div class="grid-similitudes">
                    <div class="columna-similitud">
                        <span style="font-size: 24px;">🗣️</span>
                        <span>Se transmiten originalmente a través de la <strong>tradición oral</strong>.</span>
                    </div>
                    <div class="columna-similitud">
                        <span style="font-size: 24px;">🌺</span>
                        <span>Forman parte viva del tejido y las costumbres de nuestras comunidades.</span>
                    </div>
                    <div class="columna-similitud">
                        <span style="font-size: 24px;">🗺️</span>
                        <span>¡Son herramientas clave para comprender la riqueza multicultural de Oaxaca!</span>
                    </div>
                </div>
            </div>

            <div class="bloque-boton">
                <!-- Conexión mediante JavaScript nativo -->
                <!-- From Uiverse.io by Yaseen549 --> 
<button> Regresar
</button>

            </div>

        </div>

  </p>
</div>

</body>
</html>
