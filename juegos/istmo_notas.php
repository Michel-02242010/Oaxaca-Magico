<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Atrapa las Notas - El Istmo</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { background: #040d12; color: #00e5ff; font-family: 'Press Start 2P', sans-serif; font-size: 11px; text-align: center; margin: 0; padding: 20px; background-image: radial-gradient(circle, #09212c 10%, #010508 90%); overflow: hidden; }
        h2 { color: #ffe600; text-shadow: 0 0 10px #ffe600; font-size: 14px; margin-bottom: 10px; }
        .contenedor-juego { position: relative; width: 700px; height: 380px; margin: 15px auto; }
        canvas { background: linear-gradient(to bottom, #071921, #02080d); border: 4px solid #00e5ff; border-radius: 12px; position: absolute; top: 0; left: 0; z-index: 1; box-shadow: 0 0 25px rgba(0, 229, 255, 0.2); }
        .overlay { position: absolute; top: 0; left: 0; width: 700px; height: 380px; background: rgba(2, 10, 15, 0.96); border: 4px solid #ffe600; border-radius: 12px; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 25px; box-sizing: border-box; }
        .box-titulo { color: #ffe600; font-size: 11px; margin-bottom: 15px; text-shadow: 0 0 8px #ffe600; }
        .box-texto { color: #FFF; font-size: 9px; line-height: 1.8; margin-bottom: 20px; text-align: center; }
        .btn-game { padding: 10px 20px; font-family: 'Press Start 2P', sans-serif; font-size: 9px; font-weight: bold; background: #000; color: #00e5ff; border: 2px solid #00e5ff; border-radius: 5px; cursor: pointer; transition: all 0.2s; }
        .btn-game:hover { background: #00e5ff; color: #000; box-shadow: 0 0 15px #00e5ff; }
    </style>
</head>
<body>
    <h2>🎶 JUEGO: Atrapa las Notas Tradicionales</h2>
    
    <div class="contenedor-juego">
        <!-- Pantalla Inicial -->
        <div id="pantalla-inicio" class="overlay">
            <div class="box-titulo">📜 VENTARRÓN MUSICAL</div>
            <div class="box-texto">
                ¡Hola, <?= htmlspecialchars($nombre) ?>!<br><br>
                Mueve la canasta de Tehuana horizontalmente usando tu MOUSE.<br><br>
                Las ráfagas de viento arrastrarán notas musicales por el lienzo. Lee la pregunta superior y atrapa únicamente la burbuja dorada que contenga la respuesta histórica correcta.
            </div>
            <button class="btn-game" onclick="iniciarViento()">ATRAPAR RITMO</button>
        </div>

        <!-- Pantalla Diálogo Feedback -->
        <div id="pantalla-resultado" class="overlay" style="display: none;">
            <div class="box-titulo" id="res-titulo">EVALUACIÓN DE NOTA</div>
            <div class="box-texto" id="res-texto">Mensaje informativo</div>
            <button class="btn-game" onclick="proximaRonda()">VOLVER AL VIENTO</button>
        </div>

        <canvas id="canvasNotas" width="700" height="380"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasNotas"), ctx = cvs.getContext("2d");
let canastaX = 350, juegoCorriendo = false, colisionEvaluada = false;

// Banco dinámico con 4 preguntas sobre las tradiciones e identidad del Istmo
const bancoNotas = [
    { q: "¿De qué está decorado el huipil tradicional de Tehuana?", ok: "Flores bordadas multicolores 🌸", no: "Monedas de plata pesadas 🪙" },
    { q: "¿Cuál es el son istmeño más famoso a nivel internacional?", ok: "La Sandunga 🎼", no: "La Llorona del Centro ❌" },
    { q: "¿Qué importante celebración tradicional del Istmo dura varios días?", ok: "Las Velas Istmeñas ✨", no: "Las Calendas del Valle ❌" },
    { q: "¿Qué árbol místico da flores sagradas que las tehuanas usan en su cabello?", ok: "La flor de Guiechachi o Frangipani 🌼", no: "El Laurel de la india ❌" }
];
let retoActual = {}, notas = [];

function cargarNuevoReto() {
    retoActual = bancoNotas[Math.floor(Math.random() * bancoNotas.length)];
    colisionEvaluada = false;
    notas = [
        { x: 0, y: 120, vX: 3.2, vY: 1.0, txt: retoActual.ok, correcto: true },
        { x: 0, y: 240, vX: 2.7, vY: -0.7, txt: retoActual.no, correcto: false }
    ];
}

cvs.onmousemove = (e) => {
    if (!juegoCorriendo) return;
    let rect = cvs.getBoundingClientRect();
    canastaX = e.clientX - rect.left;
};

function iniciarViento() {
    document.getElementById("pantalla-inicio").style.display = "none";
    juegoCorriendo = true;
    cargarNuevoReto();
    loopJuego();
}

function procesarColisionNota(esCorrecto) {
    juegoCorriendo = false;
    colisionEvaluada = true;
    const resTitulo = document.getElementById("res-titulo");
    const resTexto = document.getElementById("res-texto");

    if (esCorrecto) {
        resTitulo.innerText = "🏆 ¡SINFONÍA IMPEDIDA!";
        resTitulo.style.color = "#00ffcc";
        resTexto.innerHTML = "¡Excelente oído histórico! Has atrapado la respuesta correcta. Los bordados y sones le dan su gran identidad cultural a la Tehuana.";
    } else {
        resTitulo.innerText = "🎒 RITMO DISCORDANTE";
        resTitulo.style.color = "#ffe600";
        resTexto.innerHTML = "¡Oh no! Atrapaste una opción falsa que desentona con los relatos tradicionales del Istmo de Tehuantepec.";
    }
    document.getElementById("pantalla-resultado").style.display = "flex";
}

function proximaRonda() {
    document.getElementById("pantalla-resultado").style.display = "none";
    cargarNuevoReto();
    juegoCorriendo = true;
}

function loopJuego() {
    if (!juegoCorriendo) return;

    ctx.clearRect(0, 0, cvs.width, cvs.height);

    // Desplegar enunciado en la parte superior
    ctx.fillStyle = "#ffe600"; ctx.font = "bold 9px 'Press Start 2P', sans-serif"; ctx.textAlign = "center";
    ctx.fillText("RETAR: " + retoActual.q, 350, 60);

    notas.forEach(n => {
        n.x += n.vX;
        n.y += n.vY + Math.sin(n.x * 0.04) * 1.5; // Efecto físico elástico del viento del Istmo

        if (n.x > cvs.width) { n.x = 0; n.y = Math.random() * 200 + 90; }

        // Renderizado vectorial de la burbuja musical de neón
        ctx.save();
        ctx.shadowBlur = 12; ctx.shadowColor = n.correcto ? "#ffe600" : "#ff0055";
        ctx.fillStyle = n.correcto ? "#ffe600" : "#ff5555";
        ctx.beginPath(); ctx.arc(n.x, n.y, 18, 0, Math.PI * 2); ctx.fill();
        
        // Dibujo interno geométrico de la nota musical (Evita usar texto crudo)
        ctx.fillStyle = "#000";
        ctx.fillRect(n.x + 2, n.y - 10, 3, 15); // Plica
        ctx.beginPath(); ctx.ellipse(n.x - 2, n.y + 4, 5, 4, Math.PI/6, 0, Math.PI*2); ctx.fill(); // Cabeza
        ctx.restore();

        ctx.fillStyle = "#FFF"; ctx.font = "8px 'Press Start 2P', sans-serif"; ctx.textAlign = "center";
        ctx.fillText(n.txt, n.x, n.y - 25);

        // Detectar si ingresa al perímetro de la canasta
        if (!colisionEvaluada && n.y >= 320 && n.y <= 350 && Math.abs(n.x - canastaX) < 45) {
            procesarColisionNota(n.correcto);
        }
    });

    // Dibujar Canasta Tradicional mediante vectores puros de alta definición
    ctx.save();
    ctx.shadowBlur = 15; ctx.shadowColor = "#ff0055";
    ctx.fillStyle = "#ff0055"; ctx.fillRect(canastaX - 40, 340, 80, 20); // Base canasta
    ctx.fillStyle = "#ffe600"; ctx.fillRect(canastaX - 45, 335, 90, 5);  // Borde superior dorado
    ctx.restore();

    requestAnimationFrame(loopJuego);
}
</script>
</body>
</html>
