<?php
session_start();
// Si el alumno no ha entrado con su nombre, lo regresa al inicio
if (!isset($_SESSION['alumno_nombre'])) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Aventuras</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        /* Estilos base comprimidos y fondo de neblina oaxaqueña */
        body { font-family: 'Quicksand', sans-serif; background: #1A0F08; margin: 0; padding-top: 100px; color: #fff; overflow-x: hidden; }
        .nav-top { position: fixed; top: 0; left: 0; width: 100%; background: #1A0F08; border-bottom: 4px solid #E6A341; display: flex; justify-content: center; gap: 10px; padding: 12px 0; z-index: 10; }
        .tab-btn { font-family: 'Quicksand', sans-serif; background: #2B160A; color: #FECE79; border: 2px solid #5C3A21; padding: 10px 20px; font-size: 16px; border-radius: 10px; cursor: pointer; transition: 0.2s; }
        .tab-btn.activa { background: linear-gradient(135deg, #E6A341, #8C0902); color: #fff; border-color: #FECE79; }
        .view { display: none; width: 100%; height: calc(100vh - 100px); border: none; }
        .view.activa { display: block; }
        
        /* Contenedores de las tarjetas estilo cartas de juego */
        .box { max-width: 800px; margin: 15px auto; background: #2B160A; border: 3px solid #E6A341; border-radius: 20px; padding: 20px; text-align: center; }
        .grid { display: flex; gap: 15px; justify-content: center; margin: 15px 0; flex-wrap: wrap; }
        .card { flex: 1; min-width: 280px; border-radius: 15px; padding: 15px; text-align: left; box-shadow: 0 5px 15px rgba(0,0,0,0.5); }
        .card.mito { background: #1e3a8a; border: 3px solid #3b82f6; }
        .card.leyenda { background: #7c2d12; border: 3px solid #ea580c; }
        h3 { margin: 0 0 10px 0; font-size: 20px; color: #FECE79; }
        p { font-size: 14px; line-height: 1.4; margin: 5px 0; }
        .ejemplo { background: rgba(0,0,0,0.3); padding: 8px; border-radius: 8px; font-size: 13px; border-left: 4px solid #FECE79; margin-top: 10px; }
    </style>
</head>
<body>

    <!-- REPRODUCTOR ÚNICO DE AUDIO DINÁMICO -->
    <audio id="bg-music" loop autoplay
    ></audio>

    <!-- Barra de pestañas fijas superiores apuntando a tus canciones reales -->
    <nav class="nav-top">
        <button class="tab-btn activa" onclick="tab('aprender', 'guela.mp3')">📖 Aprender</button>
        <button class="tab-btn" onclick="tab('mapa', 'viva_mex.mp3')">🧭 Mapa</button>
        <button class="tab-btn" onclick="tab('juegos', 'todo_de_ti.mp3')">🎮 Juegos</button>
    </nav>

    <!-- INTERFAZ 1: APRENDER -->
    <div id="aprender" class="view activa">
        <div class="box">
            <h2 style="color: #FECE79; margin: 0;">¡Hola, <?php echo htmlspecialchars($_SESSION['alumno_nombre']); ?>! ✨</h2>
            <p style="margin: 5px 0 15px 0; color: #A08068;">¡Descubre el poder de las historias antiguas!</p>
            
            <div class="grid">
                <!-- Carta del Mito -->
                <div class="card mito">
                    <h3>⚡ MITO</h3>
                    <p>Historias de la creación creadas por pueblos antiguos.</p>
                    <p><strong>¿Quiénes están?</strong> ¡Dioses, superhéroes y monstruos mágicos!</p>
                    <div class="ejemplo"><strong>🌟 Oaxaca:</strong> El mito de cómo el Sol y la Luna subieron al cielo para alumbrarnos.</div>
                </div>
                
                <!-- Carta de la Leyenda -->
                <div class="card leyenda">
                    <h3>🗣️ LEYENDA</h3>
                    <p>Hechos reales de un pueblo mezclados con magia y misterio.</p>
                    <p><strong>¿Quiénes están?</strong> Personas comunes, fantasmas o animales del bosque.</p>
                    <div class="ejemplo"><strong>🌲 Oaxaca:</strong> La Princesa Donají, una guerrera real grabada en nuestro escudo.</div>
                </div>
            </div>
            <p>🚀 <strong>¿Estás listo?</strong> ¡Dale clic a la pestaña de <strong>Mapa</strong> para iniciar tu viaje!</p>
        </div>
    </div>

    <!-- INTERFAZ 2: MAPA -->
    <iframe id="mapa" class="view" src="mapa.php"></iframe>

    <!-- INTERFAZ 3: JUEGOS -->
    <iframe id="juegos" class="view" src="menu_juegos.php"></iframe>

    <script>
        const audio = document.getElementById('bg-music');

        // Función gamer interactiva para alternar vistas e intercambiar canciones al mismo tiempo
        function tab(id, cancion) {
            // Oculta todas las interfaces y apaga los botones dorados anteriores
            document.querySelectorAll('.view').forEach(v => v.classList.remove('activa'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('activa'));
            
            // Enciende la interfaz y el botón seleccionado
            document.getElementById(id).classList.add('activa');
            event.currentTarget.classList.add('activa');

            // INTERCAMBIO DE AUDIO: Actualiza el archivo fuente y arranca el sonido
            audio.src = cancion;
            audio.play().catch(() => {});
        }

        // Al iniciar por primera vez, reproduce automáticamente la canción de la pestaña Aprender
        window.addEventListener('DOMContentLoaded', () => {
            audio.src = "guela.mp3";
            audio.play().catch(() => {});
        });
    </script>
</body>
</html>
