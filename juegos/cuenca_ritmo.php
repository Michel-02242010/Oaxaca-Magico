<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Compás de la Cuenca</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { background: #090514; color: #bc99ff; font-family: 'Press Start 2P', sans-serif; font-size: 11px; text-align: center; margin: 0; padding: 20px; background-image: radial-gradient(circle, #180d30 10%, #030108 90%); overflow: hidden; }
        h2 { color: #00ffff; text-shadow: 0 0 10px #00ffff; font-size: 14px; margin-bottom: 10px; }
        .contenedor-juego { position: relative; width: 600px; height: 280px; margin: 15px auto; }
        canvas { background: #0c0817; border: 4px solid #ff007f; border-radius: 12px; position: absolute; top: 0; left: 0; z-index: 1; box-shadow: 0 0 25px rgba(255, 0, 127, 0.2); }
        .overlay { position: absolute; top: 0; left: 0; width: 600px; height: 280px; background: rgba(12, 8, 23, 0.96); border: 4px solid #00ffff; border-radius: 12px; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; }
        .box-titulo { color: #00ffff; font-size: 11px; margin-bottom: 12px; text-shadow: 0 0 8px #00ffff; }
        .box-texto { color: #FFF; font-size: 9px; line-height: 1.8; margin-bottom: 15px; text-align: center; }
        .btn-game { padding: 10px 18px; font-family: 'Press Start 2P', sans-serif; font-size: 9px; font-weight: bold; background: #000; color: #e6a341; border: 2px solid #e6a341; border-radius: 5px; cursor: pointer; margin: 4px; transition: all 0.2s; }
        .btn-game:hover { background: #e6a341; color: #000; box-shadow: 0 0 15px #e6a341; }
        .btn-ans { border-color: #00ffff; color: #00ffff; width: 85%; }
        .btn-ans:hover { background: #00ffff; color: #000; }
    </style>
</head>
<body>
    <h2>🪘 JUEGO 2: Compás de la Cuenca (Ritmo Tradicional)</h2>
    
    <div class="contenedor-juego">
        <!-- Pantalla Inicial -->
        <div id="pantalla-inicio" class="overlay">
            <div class="box-titulo">📜 RITMO DEL PAPALOAPAN</div>
            <div class="box-texto">
                ¡Hola, <?= htmlspecialchars($nombre) ?>!<br><br>
                Una onda de sonido se desplaza horizontalmente. Mira la barra cian brillante del centro.<br><br>
                Debes responder las preguntas teóricas presionando los botones interactivos JUSTO cuando la onda cruce por el centro para lograr un zapateado perfecto.
            </div>
            <button class="btn-game" onclick="iniciarRitmo()">CAMPING RITMO</button>
        </div>

        <!-- Pantalla de Trivia Dinámica -->
        <div id="pantalla-trivia" class="overlay" style="display: none;">
            <div class="box-titulo">❔ CUESTIONARIO RÍTMICO</div>
            <div class="box-texto" id="trivia-pregunta">Pregunta</div>
            <button class="btn-game btn-ans" onclick="evaluarRitmo(true)">VERDADERO</button>
            <button class="btn-game btn-ans" onclick="evaluarRitmo(false)">FALSO</button>
        </div>

        <!-- Pantalla Feedback -->
        <div id="pantalla-resultado" class="overlay" style="display: none;">
            <div class="box-titulo" id="res-titulo">ZAPATEADO</div>
            <div class="box-texto" id="res-texto">Mensaje</div>
            <button class="btn-game" onclick="proximaPregunta()">SIGUIENTE COMPÁS</button>
        </div>

        <canvas id="canvasRitmo" width="600" height="280"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasRitmo"), ctx = cvs.getContext("2d");
let pulsoX = 0, velocidadRitmo = 4, aciertosRitmo = 0, juegoCorriendo = false;

// Banco expansivo con 4 preguntas interactivas de Verdadero o Falso
const bancoRitmo = [
    { q: "¿El baile Flor de Piña combina las raíces indígenas de la Cuenca con música tradicional?", ans: true },
    { q: "¿Este baile tradicional fue creado originalmente en la época prehispánica?", ans: false }, // Fue creado en 1958
    { q: "¿La región de la Cuenca del Papaloapan colinda geográficamente con Veracruz?", ans: true },
    { q: "¿Las bailarinas usan zapatos de tapón alto de metal durante la coreografía?", ans: false } // Bailan descalzas
];
let retoActual = {};

function cargarRetoRitmo() {
    retoActual = bancoRitmo[Math.floor(Math.random() * bancoRitmo.length)];
    document.getElementById("trivia-pregunta").innerText = retoActual.q;
    document.getElementById("pantalla-trivia").style.display = "flex";
}

function iniciarRitmo() {
    document.getElementById("pantalla-inicio").style.display = "none";
    juegoCorriendo = true;
    loopRitmo();
    cargarRetoRitmo();
}

function evaluarRitmo(respuestaUsuario) {
    document.getElementById("pantalla-trivia").style.display = "none";
    const resTitulo = document.getElementById("res-titulo");
    const resTexto = document.getElementById("res-texto");

    if (respuestaUsuario === retoActual.ans) {
        // Validación matemática de la barra de ritmo (Eje X central: 300)
        if (Math.abs(pulsoX - 300) < 40) {
            aciertosRitmo += 25;
            resTitulo.innerText = "🔥 ZAPATEADO PERFECTO";
            resTitulo.style.color = "#00ffcc";
            resTexto.innerHTML = "¡Excelente! Acertaste la trivia e impactaste justo en el centro del compás del tambor. Sumas +25 PTS Ancestrales.";
        } else {
            resTitulo.innerText = "✨ RITMO CORRIDO";
            resTitulo.style.color = "#ffe600";
            resTexto.innerHTML = "Tu respuesta histórica es correcta, pero tu coordinación física falló. Oprimiste el botón cuando la onda estaba fuera de la barra central.";
        }
    } else {
        resTitulo.innerText = "❌ RITMO PERDIDO";
        resTitulo.style.color = "#ff0055";
        resTexto.innerHTML = "¡Incorrecto! La afirmación teórica no corresponde a los relatos históricos de la Cuenca del Papaloapan.";
    }
    
    document.getElementById("pantalla-resultado").style.display = "flex";
}

function proximaPregunta() {
    document.getElementById("pantalla-resultado").style.display = "none";
    if (aciertosRitmo >= 100) {
        document.getElementById("res-titulo").innerText = "🥇 MAESTRO DEL TAMBOR";
        document.getElementById("res-titulo").style.color = "#00ffcc";
        document.getElementById("res-texto").innerText = "¡Felicidades! Lograste completar los 100 puntos de ritmo y teoría del Papaloapan.";
        document.getElementById("pantalla-resultado").style.display = "flex";
        document.querySelector("#pantalla-resultado .btn-game").onclick = () => location.reload();
    } else {
        cargarRetoRitmo();
    }
}

function loopRitmo() {
    if (!juegoCorriendo) return;

    ctx.clearRect(0, 0, cvs.width, cvs.height);

    // Barra central de sincronización vectorial de neón cian
    ctx.fillStyle = "rgba(0, 255, 255, 0.15)"; ctx.fillRect(280, 0, 40, cvs.height);
    ctx.strokeStyle = "#00ffff"; ctx.lineWidth = 2;
    ctx.beginPath(); ctx.moveTo(300, 0); ctx.lineTo(300, cvs.height); ctx.stroke();

    pulsoX += velocidadRitmo;
    if (pulsoX > cvs.width) pulsoX = 0;

    // Renderizar la onda senoidal rítmica mediante esferas vectoriales en cadena (Evita emojis)
    ctx.save();
    ctx.shadowBlur = 12; ctx.shadowColor = "#ff007f";
    ctx.fillStyle = "#ff007f";
    for (let x = pulsoX - 50; x < pulsoX + 50; x += 5) {
        let dephY = 140 + Math.sin(x * 0.08) * 35;
        ctx.beginPath(); ctx.arc(x, dephY, 4, 0, Math.PI * 2); ctx.fill();
    }
    ctx.restore();

    // HUD de puntaje
    ctx.fillStyle = "#00ffff"; ctx.font = "bold 9px 'Press Start 2P'"; ctx.textAlign = "left";
    ctx.fillText("SCORE: " + aciertosRitmo + "/100 PTS", 20, 35);

    requestAnimationFrame(loopRitmo);
}
</script>
</body>
</html>
