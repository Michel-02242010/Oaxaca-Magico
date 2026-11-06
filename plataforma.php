<?php
session_start();
$nombre_alumno = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Oaxaca Mágico</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background: #1A0F08; color: #FECE79; margin: 0; padding: 20px; }
        .navbar { display: flex; justify-content: center; gap: 15px; background: rgba(26,15,8,0.95); padding: 12px; border-radius: 25px; border: 4px solid #E6A341; max-width: 600px; margin: 0 auto 30px; }
        .tab-btn { font-family: 'Fredoka One', cursive; background: transparent; border: none; color: #FFFBF2; padding: 10px 22px; font-size: 16px; cursor: pointer; border-radius: 18px; }
        .tab-btn.activa { background: #8C0902; border-bottom: 4px solid #4A0502; }
        .view { display: none; }
        .view.activa { display: block; }
        .contenedor-principal { background: rgba(26,15,8,0.95); border: 5px solid #E6A341; border-radius: 35px; max-width: 850px; margin: 0 auto; padding: 30px; display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .tarjeta-juego { background: #FFFBF2; border: 4px solid #E6A341; border-radius: 20px; padding: 20px; text-align: center; width: 220px; color: #361A0C; }
        .tarjeta-juego h3 { color: #8C0902; margin: 10px 0; font-family: 'Fredoka One', cursive; }
        .btn-jugar { background: #8C0902; color: #FFFBF2; border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer; font-weight: bold; width: 100%; }
    </style>
</head>
<body>
    <audio id="bg-music" loop autoplay></audio>

    <div class="navbar">
        <button class="tab-btn activa" onclick="tab('aprender', 'sonido/coldplay.mp3')">📖 Aprender</button>
        <button class="tab-btn" onclick="tab('mapa', '')">🧭 Mapa</button>
        <button class="tab-btn" onclick="tab('juegos', 'sonido/rojo.mp3')">🎮 Juegos</button>
    </div>

    <!-- PESTAÑA 1: LEER -->
    <div id="aprender" class="view activa">
        <div class="contenedor-principal">
            <h2>📖 ¡Hola, <?= htmlspecialchars($nombre_alumno) ?>! Aquí inicia tu viaje</h2>
            <p style="color: #FFFBF2; line-height: 1.6;">Aquí va el texto completo y detallado del mito de la Princesa Donají...</p>
        </div>
    </div>
<<<<<<< HEAD


=======
            <!-- PESTAÑA 2: MAPA INTERACTIVO ACOMODADO -->
>>>>>>> aa02e2aeef8880520be2ab6f9337fce563e1a80f
<div id="mapa" class="view">
    <iframe src="OaxacaM%C3%A1gico1/index.html" 
            style="width: 100%; height: 80vh; border: none; border-radius: 20px;">
    </iframe>
</div>
<<<<<<< HEAD
<!-- ========================================== -->
    <!-- 🎮 PESTAÑA 3: SECCIÓN DE JUEGOS             -->
    <!-- ========================================== -->
=======


    <!-- PESTAÑA 3: JUEGOS -->
>>>>>>> aa02e2aeef8880520be2ab6f9337fce563e1a80f
    <div id="juegos" class="view">
        <div class="contenedor-principal">
            <!-- Rompecabezas -->
            <div class="tarjeta-juego">
                <div style="font-size: 45px;">🧩</div>
                <h3>El Rompecabezas</h3>
                <button class="btn-jugar" onclick="window.location.href='juegos/rompecabezas.php'">Jugar 🎮</button>
            </div>
            <!-- Memorama -->
            <div class="tarjeta-juego">
                <div style="font-size: 45px;">🃏</div>
                <h3>El Memorama</h3>
                <button class="btn-jugar" onclick="window.location.href='juegos/memorama.php'">Jugar 🎮</button>
            </div>
            <!-- Flechador -->
            <div class="tarjeta-juego">
                <div style="font-size: 45px;">🏹</div>
                <h3>El Flechador</h3>
                <button class="btn-jugar" onclick="window.location.href='juegos/flechador.php'">Jugar 🎮</button>
            </div>
            <!-- Chaneques -->
            <div class="tarjeta-juego">
                <div style="font-size: 45px;">🌿</div>
                <h3>Los Chaneques</h3>
                <button class="btn-jugar" onclick="window.location.href='juegos/chaneques.php'">Jugar 🎮</button>
            </div>
            <!-- Rey Condoy -->
            <div class="tarjeta-juego">
                <div style="font-size: 45px;">👑</div>
                <h3>El Rey Condoy</h3>
                <button class="btn-jugar" onclick="window.location.href='juegos/condoy.php'">Jugar 🎮</button>
            </div>
        </div>
    </div>

    <script>
        function tab(pantalla, cancion) {
            document.querySelectorAll('.view').forEach(v => v.classList.remove('activa'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('activa'));
            
            const seccionDestino = document.getElementById(pantalla);
            if (seccionDestino) seccionDestino.classList.add('activa');

            document.querySelectorAll('.tab-btn').forEach(b => {
                if (b.getAttribute('onclick') && b.getAttribute('onclick').includes(`'${pantalla}'`)) b.classList.add('activa');
            });

            const audio = document.getElementById('bg-music');
            if (audio) {
                if (cancion) { audio.src = cancion; audio.play().catch(() => {}); } 
                else { audio.pause(); }
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            const parametros = new URLSearchParams(window.location.search);
            if (parametros.get('tab') === 'juegos') { tab('juegos', 'sonido/rojo.mp3'); } 
            else { tab('aprender', 'sonido/coldplay.mp3'); }
        });
    </script>
</body>
</html>
