<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Bienvenidos Exploradores! - Oaxaca Mágico</title>
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Fredoka+One&family=Quicksand:wght@700&display=swap" rel="stylesheet">
    
    <style>
        /* 🎨 TU FORMATO DE COLORES ORIGINAL Y FONDO MÍSTICO */
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #1A0F08, #361A0C, #5C3A21, #1A0F08);
            background-size: 400% 400%;
            animation: neblinaOaxaca 10s ease-in-out infinite alternate;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            color: #FECE79;
            overflow-x: hidden;
            position: relative;
        }

        @keyframes neblinaOaxaca {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        /* 👑 BARRA DE NAVEGACIÓN Y BOTONES REDONDEADOS ORIGINALES */
        .navbar {
            display: flex;
            justify-content: center;
            gap: 15px;
            background: rgba(26, 15, 8, 0.95);
            padding: 12px;
            border-radius: 25px;
            border: 4px solid #E6A341;
            max-width: 600px;
            margin: 0 auto 30px auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            z-index: 10;
        }

        .tab-btn {
            font-family: 'Fredoka One', cursive;
            background: transparent;
            border: none;
            color: #FFFBF2;
            padding: 10px 22px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 18px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tab-btn:hover {
            background: rgba(230, 163, 65, 0.15);
            color: #FECE79;
        }

        /* Tu botón con el relieve tridimensional activo */
        .tab-btn.activa {
            background: #8C0902;
            color: #FFFBF2;
            border-bottom: 4px solid #4A0502;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        /* 📦 CONTENEDORES INVISIBLES DE CONTROL DE PESTAÑAS */
        .view {
            display: none; /* Todo oculto por defecto para que no se encime */
        }

        /* Clase encargada de renderizar solo la sección que el niño cliquea */
        .view.activa {
            display: block;
        }

        /* DISEÑO DE TU PERGAMINO / MARCOS CÁLIDOS DE ANTES */
        .contenedor-principal {
            background: rgba(26, 15, 8, 0.95);
            border: 5px solid #E6A341;
            border-radius: 35px;
            max-width: 850px;
            margin: 0 auto;
            padding: 30px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.7);
        }

        h2 {
            font-family: 'Fredoka One', cursive;
            color: #FECE79;
            text-shadow: 2px 2px 0px #8C0902;
        }

        /* Elementos flotantes de fondo (Luciérnagas/Burbujas mágicas) */
        .luciernaga {
            position: absolute;
            bottom: -50px;
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
            animation: subirSutil linear infinite;
            background: rgba(254, 206, 121, 0.2);
            border: 1px solid rgba(254, 206, 121, 0.4);
            box-shadow: 0 0 15px #E6A341;
        }

        @keyframes subirSutil {
            0% { transform: translateY(0) scale(0.6); opacity: 0; }
            20% { opacity: 0.8; }
            100% { transform: translateY(-120vh) scale(1.1); opacity: 0; }
        }
    </style>
</head>
<body>

    <!-- ELEMENTOS GRÁFICOS MÁGICOS DE FONDO -->
    <div class="luciernaga" style="left: 10%; width: 20px; height: 20px; animation-duration: 6s;"></div>
    <div class="luciernaga" style="left: 40%; width: 15px; height: 15px; animation-duration: 5s; animation-delay: 1s;"></div>
    <div class="luciernaga" style="left: 80%; width: 22px; height: 22px; animation-duration: 7s; animation-delay: 2s;"></div>

    <!-- 🎵 REPRODUCTOR GENERAL DE AUDIO -->
    <audio id="bg-music" loop autoplay></audio>

    <!-- 👑 TU MENÚ SUPERIOR CON LAS LLAMADAS CORREGIDAS -->
    <div class="navbar">
        <button class="tab-btn activa" onclick="tab('aprender', 'sonido/coldplay.mp3')">📖 Aprender</button>
        <button class="tab-btn" onclick="tab('mapa', 'sonido/dios.mp3')">🧭 Mapa</button>
        <button class="tab-btn" onclick="tab('juegos', 'sonido/rojo.mp3')">🎮 Juegos</button>
    </div>

    <!-- ========================================== -->
    <!-- 📖 PESTAÑA 1: APRENDER                      -->
    <!-- ========================================== -->
    <div id="aprender" class="view activa">
        <div class="contenedor-principal">
            <h2>📖 Narración Mística</h2>
            <p style="color: #FFFBF2; font-size: 16px; line-height: 1.6;">
                Aquí va el texto completo y detallado del mito de la Princesa Donají para leer de forma entretenida.
            </p>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 🧭 PESTAÑA 2: MAPA                          -->
    <!-- ========================================== -->
    <div id="mapa" class="view">
        <div class="contenedor-principal">
            <h2>🧭 Mapa de Aventuras Regionales</h2>
            <p style="color: #FFFBF2;">Aquí se renderiza tu mapa de las regiones de Oaxaca sin que se encime con la lectura.</p>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 🎮 PESTAÑA 3: SECCIÓN DE JUEGOS             -->
    <!-- ========================================== -->
    <div id="juegos" class="view">
  <div class="contenedor-principal" style="padding: 25px; border-color: #E6A341; display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
    
    <!-- TARJETA 1: ROMPECABEZAS -->
    <div style="background: #FFFBF2; border: 4px solid #E6A341; border-radius: 20px; padding: 20px; text-align: center; width: 220px; box-shadow: 0 8px 16px rgba(0,0,0,0.2);">
        <div style="font-size: 45px; margin-bottom: 10px;">🧩</div>
        <h3 style="color: #8C0902; margin: 10px 0;">El Rompecabezas</h3>
        <p style="color: #361A0C; font-size: 14px; min-height: 60px;">Responde los acertijos de Donají para armar la imagen mística.</p>
        <button onclick="window.location.href='juegos/rompecabezas.php'" style="background: #8C0902; color: #FFFBF2; border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer; font-weight: bold;">Jugar 🎮</button>
    </div>

    <!-- TARJETA 2: MEMORAMA -->
    <div style="background: #FFFBF2; border: 4px solid #E6A341; border-radius: 20px; padding: 20px; text-align: center; width: 220px; box-shadow: 0 8px 16px rgba(0,0,0,0.2);">
        <div style="font-size: 45px; margin-bottom: 10px;">🃏</div>
        <h3 style="color: #8C0902; margin: 10px 0;">El Memorama</h3>
        <p style="color: #361A0C; font-size: 14px; min-height: 60px;">¡Encuentra los pares ocultos de La Llorona del Istmo!</p>
        <button onclick="window.location.href='juegos/memorama.php'" style="background: #8C0902; color: #FFFBF2; border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer; font-weight: bold;">Jugar 🎮</button>
    </div>

    <!-- TARJETA 3: EL FLECHADOR -->
    <div class="tarjeta-juego" style="background: #FFFBF2; border: 4px solid #E6A341; border-radius: 20px; padding: 20px; text-align: center; width: 220px; box-shadow: 0 8px 16px rgba(0,0,0,0.2);">
        <div style="font-size: 45px; margin-bottom: 10px;">🏹</div>
        <h3 style="color: #8C0902; margin: 10px 0;">El Flechador</h3>
        <p style="color: #361A0C; font-size: 14px; min-height: 60px;">¡Atrapa las flechas sagradas del Sol y esquiva los rayos del cielo!</p>
        <button onclick="window.location.href='juegos/flechador.php'" style="background: #8C0902; color: #FFFBF2; border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer; font-weight: bold;">Jugar 🎮</button>
    </div>

</div>

    <!-- ========================================== -->
    <!-- 🛠️ JAVASCRIPT DE FLUJO SÍNCRONO            -->
    <!-- ========================================== -->
    <script>
        const audio = document.getElementById('bg-music');

        function tab(pantalla, cancion) {
            // 1. Apaga y esconde de golpe todos los bloques contenedores (.view)
            document.querySelectorAll('.view').forEach(v => v.classList.remove('activa'));
            
            // 2. Apaga el relieve rojo de todos los botones de la barra
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('activa'));

            // 3. Enciende únicamente la sección correspondiente
            const seccionDestino = document.getElementById(pantalla);
            if (seccionDestino) {
                seccionDestino.classList.add('activa');
            }

            // 4. Agrega el estilo tridimensional activo al botón presionado
            if (window.event && window.event.currentTarget) {
                window.event.currentTarget.classList.add('activa');
            }

            // 5. Intercambia la canción de fondo de manera segura
            audio.src = cancion;
            audio.play().catch(() => {});
        }

    // Carga inicial y redirección interactiva a la pestaña correcta
window.addEventListener('DOMContentLoaded', () => {
    // 1. Revisamos si la URL trae el recado de abrir juegos (?tab=juegos)
    const parametros = new URLSearchParams(window.location.search);
    const pestañaActiva = parametros.get('tab');

    if (pestañaActiva === 'juegos') {
        // Ejecutamos tu función nativa para encender la sección de las tarjetas y su música roja
        tab('juegos', 'sonido/rojo.mp3');

        // Buscamos el botón de la barra de navegación para ponerlo en modo activo
        const botones = document.querySelectorAll('.tab-btn');
        botones.forEach(b => {
            // Si el texto del botón contiene la palabra "Juegos", lo activamos
            if (b.innerText.includes('Juegos')) {
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('activa'));
                b.classList.add('activa');
            }
        });
    } else {
        // Si no trae recado, arranca normal en la pestaña Aprender con Coldplay
        tab('aprender', 'sonido/coldplay.mp3'); // Ajusta 'aprender' por el ID exacto de tu contenedor de lectura si es diferente
    }
});

    </script>
</body>
</html>
