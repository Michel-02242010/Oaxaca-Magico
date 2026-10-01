<?php
// 1. Iniciamos la sesión para verificar al explorador conectado
session_start();
if (!isset($_SESSION['alumno_id'])) {
    header("Location: index.php");
    exit();
}

// 2. Traemos nuestra conexión a la base de datos "oaxaca"
include("conexion.php");

// 3. Atrapamos el ID de la leyenda actual (Ej: menu_juegos.php?leyenda_id=1)
$leyenda_id = isset($_GET['leyenda_id']) ? intval($_GET['leyenda_id']) : 1;

// 4. Consultamos el título de la leyenda para personalizar el título de la página
$consulta = "SELECT titulo FROM leyendas WHERE id = $leyenda_id";
$resultado = mysqli_query($conexion, $consulta);
$leyenda = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oaxaca Mágico - Elige tu Desafío</title>
    <!-- Jalamos tus estilos definitivos con las bolitas de energía flotando -->
    <link rel="stylesheet" href="estilos.css">
    
    <style>
        .panel-juegos {
            max-width: 750px;
            margin: 60px auto;
            padding: 40px;
            background: rgba(255, 255, 255, 0.5) !important;
            backdrop-filter: blur(20px);
            border-radius: 32px;
            border: 3px solid #823919; /* Borde chocolate de tu paleta */
            box-shadow: 0 25px 50px rgba(82, 25, 8, 0.2);
            text-align: center;
        }

        /* Cuadrícula interactiva para los minijuegos */
        .grid-opciones-juego {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        /* Tarjeta interactiva de cada juego */
        .tarjeta-juego {
            background: rgba(255, 255, 255, 0.8);
            border: 3px solid #823919;
            border-radius: 20px;
            padding: 25px;
            cursor: pointer;
            box-shadow: 0 6px 0 #521908;
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .tarjeta-juego:hover {
            background-color: #FFDBAF; /* Almendra claro */
            border-color: #CA7B42; /* Terracota */
            box-shadow: 0 8px 0 #CA7B42;
            transform: translateY(-4px);
        }

        .tarjeta-juego h3 {
            color: #521908;
            margin: 10px 0 5px 0;
            font-size: 18px;
        }

        .tarjeta-juego p {
            color: #823919;
            font-size: 13px;
            margin: 0;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <div class="panel-juegos">
        <h1 style="font-size: 30px;">🎮 ¡Elige tu Desafío Mágico! 🎮</h1>
        <p class="subtitulo">Mito actual: <?php echo htmlspecialchars($leyenda['titulo']); ?></p>
        
        <div class="grid-opciones-juego">
            
            <!-- JUEGO 1: TRIVIA (La que ya programamos) -->
            <div class="tarjeta-juego" onclick="redirigirJuego('juego.php', <?php echo $leyenda_id; ?>)">
                <div style="font-size: 45px;">🧠</div>
                <h3>Trivia Relámpago</h3>
                <p>Responde preguntas y demuestra tu sabiduría ancestral.</p>
            </div>

            <!-- JUEGO 2: AHORCADO (Próximo a programar) -->
            <div class="tarjeta-juego" onclick="redirigirJuego('ahorcado.php', <?php echo $leyenda_id; ?>)">
                <div style="font-size: 45px;">🕵️</div>
                <h3>Palabras Ocultas</h3>
                <p>Adivina el concepto secreto antes de que se agoten tus vidas.</p>
            </div>

            <!-- JUEGO 3: MEMORAMA (Próximo a programar) -->
            <div class="tarjeta-juego" onclick="redirigirJuego('memorama.php', <?php echo $leyenda_id; ?>)">
                <div style="font-size: 45px;">🎴</div>
                <h3>Memoria Mítica</h3>
                <p>Encuentra las parejas de las criaturas de Oaxaca.</p>
            </div>

        </div>

        <br><br>
        <a href="mapa.php" class="btn-principal" style="background-color: #823919; text-decoration: none; display: inline-block; width: auto; padding: 12px 30px; box-shadow: 0 5px 0 #521908;">
            🗺️ Volver al Mapa
        </a>
    </div>

    <!-- EL DIÁLOGO DEL GUÍA -->
    <div id="bocadillo" class="bocadillo-texto">
        ¡Vaya, veo que buscas grandes aventuras! Escoge el minijuego que más te llame la atención. ¡Todos te darán estrellas! ⭐
    </div>

    <div class="personaje-guia">👾</div>

    <script>
        // Función simple para mandar al niño al juego seleccionado pasándole el ID de la historia
        function redirigirJuego(nombreArchivo, leyendaId) {
            window.location.href = `${nombreArchivo}?leyenda_id=${leyendaId}`;
        }
    </script>
</body>
</html>
