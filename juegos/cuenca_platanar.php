<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recolección en el Platanar - La Cuenca</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { 
            background: #051408; color: #4ef278; font-family: 'Press Start 2P', sans-serif; font-size: 11px;
            text-align: center; margin: 0; padding: 20px;
            background-image: radial-gradient(circle, #0e2a14 10%, #020804 90%); overflow: hidden;
        }
        h2 { color: #ffe600; text-shadow: 0 0 10px #ffe600; font-size: 14px; margin-bottom: 10px; }
        .contenedor-juego { position: relative; width: 650px; height: 350px; margin: 15px auto; }
        canvas { 
            background: linear-gradient(to bottom, #091a0e, #030a05); border: 4px solid #ffe600; border-radius: 12px; 
            position: absolute; top: 0; left: 0; z-index: 1; box-shadow: 0 0 25px rgba(255, 230, 0, 0.2);
        }
        .overlay {
            position: absolute; top: 0; left: 0; width: 650px; height: 350px; background: rgba(5, 15, 8, 0.96);
            border: 4px solid #ffe600; border-radius: 12px; z-index: 10;
            display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 25px; box-sizing: border-box;
        }
        .box-titulo { color: #ffe600; font-size: 12px; margin-bottom: 15px; text-shadow: 0 0 8px #ffe600; }
        .box-texto { color: #FFF; font-size: 10px; line-height: 1.8; margin-bottom: 20px; text-align: center; }
        .btn-game {
            padding: 10px 20px; font-family: 'Press Start 2P', sans-serif; font-size: 9px; font-weight: bold;
            background: #000; color: #4ef278; border: 2px solid #4ef278; border-radius: 5px; cursor: pointer;
            box-shadow: 0 0 8px rgba(78, 242, 120, 0.3); transition: all 0.2s;
        }
        .btn-game:hover { background: #4ef278; color: #000; box-shadow: 0 0 15px #4ef278; }
    </style>
</head>
<body>
    <h2>🍍 NIVEL 1: Recolección en el Platanar (Flor de Piña)</h2>
    
    <div class="contenedor-juego">
        <!-- Pantalla Inicial -->
        <div id="pantalla-inicio" class="overlay">
            <div class="box-titulo">📜 RECOLECCIÓN TRADICIONAL</div>
            <div class="box-texto">
                ¡Hola, <?= htmlspecialchars($nombre) ?>!<br><br>
                Mueve el mouse a los lados para desplazar a la bailarina folclórica.<br><br>
                Debes atrapar la piña dorada que responda correctamente a la pregunta de la Guelaguetza que aparecerá flotando en la pantalla. ¡Evita las frutas incorrectas!
            </div>
            <button class="btn-game" onclick="iniciarNivel()">ZARPAR</button>
        </div>

        <!-- Pantalla Feedback de Resultados -->
        <div id="pantalla-resultado" class="overlay" style="display: none;">
            <div class="box-titulo" id="res-titulo">EVALUACIÓN</div>
            <div class="box-texto" id="res-texto">Mensaje</div>
            <button class="btn-game" onclick="siguienteRonda()">CONTINUAR EXPEDICIÓN</button>
        </div>

        <canvas id="canvasPlatanar" width="650" height="350"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasPlatanar"), ctx = cvs.getContext("2d");
let targetX = 325, personajeX = 325, juegoCorriendo = false, evaluado = false;

// Banco dinámico de múltiples preguntas de la Cuenca
const bancoPreguntas = [
    { q: "¿Qué adorna el hombro de las bailarinas en la Cuenca?", ok: "Una Piña madura 🍍", no: "Plátanos machos 🍌" },
    { q: "¿Qué peinado tradicional usan en el baile Flor de Piña?", ok: "Trenzas con listones multicolores 🎀", no: "Cabello suelto con coronas de oro 👑" },
    { q: "¿A qué fiesta máxima de Oaxaca pertenece este baile?", ok: "A la Guelaguetza de los Lunes del Cerro ⛰️", no: "A la feria del café de la sierra ☕" }
];
let preguntaActual = {}, frutas = [];

function cargarReto() {
    preguntaActual = bancoPreguntas[Math.floor(Math.random() * bancoPreguntas.length)];
    evaluado = false;
    frutas = [
        { x: Math.random() * 200 + 50, y: -40, v: 2.3, txt: preguntaActual.ok, correcto: true },
        { x: Math.random() * 200 + 400, y: -120, v: 2.0, txt: preguntaActual.no, correcto: false }
    ];
}

cvs.onmousemove = (e) => {
    if (!juegoCorriendo) return;
    let rect = cvs.getBoundingClientRect();
    targetX = e.clientX - rect.left;
};

function iniciarNivel() {
    document.getElementById("pantalla-inicio").style.display = "none";
    juegoCorriendo = true;
    cargarReto();
    loop();
}

function procesarRespuesta(esCorrecto) {
    juegoCorriendo = false;
    evaluado = true;
    const resTitulo = document.getElementById("res-titulo");
    const resTexto = document.getElementById("res-texto");

    if (esCorrecto) {
        resTitulo.innerText = "🏆 ¡ZAPATEADO EXCELENTE!";
        resTitulo.style.color = "#4ef278";
        resTexto.innerHTML = "¡Respuesta correcta! Las bailarinas del Papaloapan portan con orgullo el fruto de la tierra sobre sus hombros con elegancia y ritmo.";
    } else {
        resTitulo.innerText = "🎒 REPASO NECESARIO";
        resTitulo.style.color = "#ffe600";
        resTexto.innerHTML = "¡Casi! Recuerda que todo el vestuario, música y coreografía de este alegre baile regional rinden tributo exclusivo a la Piña.";
    }
    document.getElementById("pantalla-resultado").style.display = "flex";
}

function siguienteRonda() {
    document.getElementById("pantalla-resultado").style.display = "none";
    cargarReto();
    juegoCorriendo = true;
}

function loop() {
    if (!juegoCorriendo) return;

    ctx.clearRect(0, 0, cvs.width, cvs.height);

    // Texto de la pregunta activa arriba
    ctx.fillStyle = "#FFF"; ctx.font = "9px 'Press Start 2P', sans-serif"; ctx.textAlign = "center";
    ctx.fillText(preguntaActual.q, 325, 50);

    personajeX += (targetX - personajeX) * 0.15;
    personajeX = Math.max(50, Math.min(600, personajeX));

    frutas.forEach(f => {
        f.y += f.v;
        if (f.y > cvs.height) { f.y = -60; f.x = Math.random() * 500 + 70; }

        ctx.save();
        ctx.shadowBlur = 10; ctx.shadowColor = f.correcto ? "#ffe600" : "#ff3333";
        ctx.fillStyle = f.correcto ? "#ffe600" : "#ff5555";
        ctx.beginPath(); ctx.arc(f.x, f.y, 15, 0, Math.PI * 2); ctx.fill();
        ctx.restore();

        ctx.fillStyle = "#FFF"; ctx.font = "8px 'Press Start 2P', sans-serif"; ctx.textAlign = "center";
        ctx.fillText(f.txt, f.x, f.y - 22);

        // Evaluar colisión con la bailarina (Base)
        if (!evaluado && f.y >= 295 && f.y <= 320 && Math.abs(f.x - personajeX) < 35) {
            procesarRespuesta(f.correcto);
        }
    });

    // Dibujar Bailarina Estilizada en Vector
    ctx.save();
    ctx.shadowBlur = 12; ctx.shadowColor = "#ff0055";
    ctx.fillStyle = "#ff0055"; ctx.fillRect(personajeX - 20, 310, 40, 30); // Falda
    ctx.fillStyle = "#ffcc99"; ctx.beginPath(); ctx.arc(personajeX, 298, 8, 0, Math.PI*2); ctx.fill(); // Cabeza
    ctx.restore();

    if (juegoCorriendo) {
        requestAnimationFrame(loop);
    }
}
</script>
</body>
</html>
