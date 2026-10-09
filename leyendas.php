<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oaxaca Mágico - Una Historia Ancestral</title>
    <link href="https://googleapis.com" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #1A0F08, #361A0C, #1A0F08);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #FECE79;
            overflow-x: hidden;
        }

        h1.titulo-leyenda {
            font-family: 'Fredoka One', cursive;
            font-size: 32px;
            color: #FECE79;
            text-shadow: 3px 3px 0px #8C0902;
            margin-bottom: 25px;
            text-align: center;
        }

        /* SECCIÓN DE VIDEO (LO PRIMERO QUE VE EL NIÑO) */
        .zona-video {
            width: 90%;
            max-width: 750px;
            margin-bottom: 35px;
            text-align: center;
        }

        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%; /* Relación 16:9 */
            height: 0;
            overflow: hidden;
            border: 5px solid #fece79;
            border-radius: 25px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.7);
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
        }

        /* EL PERGAMINO (OCULTO AL PRINCIPIO) */
        .pergamino-contenedor {
            display: none; /* Se activa mediante JavaScript */
            background-color: #f4e4c1;
            background-image: radial-gradient(circle, #fbf4df 60%, #e2ca97 100%);
            border: 8px solid #5c3a21;
            border-radius: 4px;
            box-shadow: 0 0 0 4px #fece79, 0 15px 35px rgba(0,0,0,0.6), inset 0 0 40px rgba(92, 58, 33, 0.3);
            max-width: 750px;
            width: 90%;
            padding: 40px 35px;
            position: relative;
            margin-bottom: 30px;
            box-sizing: border-box;
        }

        .pergamino-contenedor::before, .pergamino-contenedor::after {
            content: "";
            position: absolute;
            height: 25px;
            width: 103%;
            background: #422612;
            border: 3px solid #fece79;
            border-radius: 10px;
            left: -1.5%;
        }
        .pergamino-contenedor::before { top: -15px; }
        .pergamino-contenedor::after { bottom: -15px; }

        .texto-narrado {
            font-family: 'Special Elite', cursive;
            font-size: 21px;
            line-height: 1.7;
            color: #2b1408;
            min-height: 150px;
            white-space: pre-line;
        }

        /* BOTONES */
        .contenedor-botones {
            display: flex;
            gap: 20px;
            justify-content: center;
            width: 100%;
            max-width: 750px;
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .btn-accion {
            font-family: 'Fredoka One', cursive;
            font-size: 18px;
            padding: 15px 25px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            text-shadow: 2px 2px 0px rgba(0,0,0,0.4);
            box-shadow: 0 6px 0px rgba(0,0,0,0.3), 0 8px 15px rgba(0,0,0,0.4);
            transition: all 0.1s ease;
            text-align: center;
        }

        .btn-siguiente { background-color: #ff9f1c; border-bottom: 5px solid #cc7a00; }
        .btn-siguiente:hover { background-color: #ffb142; }

        .btn-juegos { background-color: #2daf48; border-bottom: 5px solid #196127; display: none; }
        .btn-juegos:hover { background-color: #39c755; }

        .btn-mapa { background-color: #8c0902; border-bottom: 5px solid #4a0502; }
        .btn-mapa:hover { background-color: #b14a36; }

        .btn-accion:active {
            transform: translateY(4px);
            box-shadow: 0 2px 0px rgba(0,0,0,0.3), 0 4px 6px rgba(0,0,0,0.4);
        }
    </style>
</head>
<body>

    <audio id="musica-region" src="musica_region.mp3" loop autoplay></audio>

    <h1 class="titulo-leyenda" id="titulo">Bienvenidos a la Sierra Juárez</h1>

    <!-- 1. El Video de la Región -->
    <div class="zona-video" id="seccion-video">
        <div class="video-wrapper">
            <!-- Pon aquí tu video interactivo de la región correspondiente -->
            <iframe src="https://youtube.com" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>

    <!-- 2. El Pergamino Mágico (Empieza oculto) -->
    <div class="pergamino-contenedor" id="seccion-pergamino">
        <div id="pantalla-texto" class="texto-narrado"></div>
    </div>

    <!-- Botones de Navegación -->
    <div class="contenedor-botones">
        <a href="plataforma.php" class="btn-accion btn-mapa">🗺️ Mapa</a>
        <button class="btn-accion btn-siguiente" id="btn-entrar" onclick="comenzarLeyenda()">¡Ver el Mito Ancestral! 📜</button>
        <a href="menu_juegos.php" class="btn-accion btn-juegos" id="btn-juego-final">🎮 ¡Ir a los Juegos!</a>
    </div>

    <script>
        const leyendaTexto = "Hace muchos años, en los frondosos y mágicas bosques de la Sierra Juárez, la neblina guardaba grandes secretos...\n\nLos guardianes del bosque cuentan que los árboles hablan por las noches, narrando historias antiguas para proteger las tradiciones de Oaxaca.\n\nPresta mucha atención, explorador, porque la magia está por comenzar...";

        let indice = 0;
        // Ajustamos la velocidad aquí: 85ms es ideal para niños de primaria (va letra por letra con calma)
        const velocidadEscritura = 85; 

        function comenzarLeyenda() {
            // Ocultamos el video y mostramos el pergamino
            document.getElementById("seccion-video").style.display = "none";
            document.getElementById("btn-entrar").style.display = "none";
            document.getElementById("seccion-pergamino").style.display = "block";
            document.getElementById("titulo").innerText = "📍 El Mito de la Sierra";
            
            // Iniciamos la escritura pausada
            aparecerTexto();
        }

        function aparecerTexto() {
            if (indice < leyendaTexto.length) {
                document.getElementById("pantalla-texto").innerHTML += leyendaTexto.charAt(indice);
                indice++;
                setTimeout(aparecerTexto, velocidadEscritura);
            } else {
                // Al terminar todo el texto, aparece el botón verde de juegos
                document.getElementById("btn-juego-final").style.display = "inline-block";
            }
        }
    </script>

</body>
</html>