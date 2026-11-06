<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Sangre del Ocaso - Mixteca</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { background: #06040a; color: #d1c4e9; font-family: 'Cinzel', serif; text-align: center; margin: 0; padding: 20px; overflow: hidden; }
        h2 { color: #ff5722; text-shadow: 0 0 15px rgba(255,87,34,0.5); font-size: 24px; letter-spacing: 2px; margin: 10px 0; }
        .contenedor-juego { position: relative; width: 650px; height: 350px; margin: 15px auto; }
        canvas { background: linear-gradient(to bottom, #1a052e, #05020c); border: 3px solid #ff5722; border-radius: 20px; position: absolute; top: 0; left: 0; z-index: 1; box-shadow: 0 0 35px rgba(255,87,34,0.3); }
        .overlay { position: absolute; top: 0; left: 0; width: 650px; height: 350px; background: rgba(6, 4, 10, 0.97); border: 3px solid #ff5722; border-radius: 20px; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 25px; box-sizing: border-box; }
        .box-titulo { color: #ff5722; font-size: 26px; margin-bottom: 12px; text-shadow: 0 0 10px #ff5722; }
        .box-texto { color: #FFF; font-size: 16px; line-height: 1.6; margin-bottom: 15px; text-align: center; font-family: sans-serif; }
        .btn-game { padding: 10px 24px; font-family: 'Cinzel', serif; font-weight: bold; font-size: 14px; background: #ff5722; color: #FFF; border: none; border-radius: 25px; cursor: pointer; margin: 5px; transition: all 0.2s; width: 85%; box-shadow: 0 0 10px rgba(255,87,34,0.4); }
        .btn-game:hover { background: #FFF; color: #1a052e; box-shadow: 0 0 20px #ff5722; }
    </style>
</head>
<body>
    <h2>☀️ CAPÍTULO: Sangre del Ocaso</h2>
    
    <div class="contenedor-juego">
        <!-- Pantalla Inicial -->
        <div id="pantalla-inicio" class="overlay">
            <div class="box-titulo">🔥 EL PRIMER ATARDECER</div>
            <div class="box-texto">
                ¡Hola, <?= htmlspecialchars($nombre) ?>!<br><br>
                Mueve el cursor para desplazar el Amuleto Magnético de Dzahuindanda en la base.<br><br>
                Responde correctamente los enigmas teóricos sobre el relato fundacional para activar el magnetismo ancestral y absorber las partículas vitales del Ocaso que descienden del cielo.
            </div>
            <button class="btn-game" style="width:auto;" onclick="iniciarOcaso()">INICIAR ABSORCIÓN</button>
        </div>

        <!-- Pantalla de Trivia Dinámica -->
        <div id="pantalla-trivia" class="overlay" style="display: none;">
            <div class="box-titulo">❓ COSMOGONÍA MIXTECA</div>
            <div class="box-texto" id="trivia-pregunta">Pregunta</div>
            <button class="btn-game" id="opc-0" onclick="evaluarOcaso(0)">Opción A</button>
            <button class="btn-game" id="opc-1" onclick="evaluarOcaso(1)">Opción B</button>
        </div>

        <!-- Pantalla Feedback -->
        <div id="pantalla-resultado" class="overlay" style="display: none;">
            <div class="box-titulo" id="res-titulo">AMULETO MAGNETIZADO</div>
            <div class="box-texto" id="res-texto">Mensaje instructivo</div>
            <button class="btn-game" style="width:auto;" onclick="proximaOndaOcaso()">SIGUIENTE ENIGMA</button>
        </div>

        <canvas id="canvasOcaso" width="650" height="350"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasOcaso"), ctx = cvs.getContext("2d");
let imanX = 325, imanActivado = false, juegoCorriendo = false, puntuacion = 0;

// Banco expansivo con 4 preguntas sobre la sumisión del Sol y cosmogonía
const bancoOcaso = [
    { q: "¿Al día siguiente de la fiera batalla, el Sol regresó sumiso con el brillo necesario para dar vida?", ops: ["VERDADERO. Cumplió con el balance cósmico exigido 👍", "FALSO. Se apagó por completo sumiendo la Mixteca en hielo ❌"], correcta: 0 },
    { q: "¿Qué tonalidad mística tomaron las nubes tras el flechazo según el relato?", ops: ["Tonos rojizos y púrpuras como la sangre sagrada del astro 👍", "Gris metálico opaco por la ceniza volcánica ❌"], correcta: 0 },
    { q: "¿Quién fue el gran líder militar mixteco que comandó esta gran hazaña?", ops: ["El Flechador del Sol místico 👍", "El Sumo Sacerdote Tibut de Mitla ❌"], correcta: 0 },
    { q: "¿Qué elemento vital floreció en los valles gracias al balance del atardecer?", ops: ["La agricultura, los árboles sagrados y los ríos de agua 👍", "Las minas de oro y metales preciosos ❌"], correcta: 0 }
];
let retoActual = {};

let particulas = [
    { x: 100, y: 20, v: 2, color: "#ff3d00" },
    { x: 300, y: 50, v: 2.5, color: "#ff9100" },
    { x: 500, y: 10, v: 1.8, color: "#e040fb" }
];

cvs.onmousemove = (e) => {
    if (!juegoCorriendo) return;
    let rect = cvs.getBoundingClientRect();
    imanX = e.clientX - rect.left;
};

function cargarRetOOcaso() {
    retoActual = bancoOcaso[Math.floor(Math.random() * bancoOcaso.length)];
    document.getElementById("trivia-pregunta").innerText = retoActual.q;
    document.getElementById("opc-0").innerText = retoActual.ops;
    document.getElementById("opc-1").innerText = retoActual.ops;
    document.getElementById("pantalla-trivia").style.display = "flex";
    juegoCorriendo = false;
}

function iniciarOcaso() {
    document.getElementById("pantalla-inicio").style.display = "none";
    juegoCorriendo = true;
    cargarRetOOcaso();
    animar();
}

function evaluarOcaso(opcion) {
    document.getElementById("pantalla-trivia").style.display = "none";
    const resTitulo = document.getElementById("res-titulo");
    const resTexto = document.getElementById("res-texto");

    if (opcion === retoActual.correcta) {
        imanActivado = true;
        resTitulo.innerText = "🏆 ATRACCIÓN CRISTALIZADA";
        resTitulo.style.color = "#00e676";
        resTexto.innerHTML = "¡Excelente respuesta cosmogónica! Tu dominio teórico magnetiza el amuleto. Las partículas vitales del ocaso serán atraídas elásticamente hacia tu base.";
    } else {
        imanActivado = false;
        resTitulo.innerText = "🚨 MAGNETISMO DISIPADO";
        resTitulo.style.color = "#ff1744";
        resTexto.innerHTML = "¡Incorrecto! El error confunde el balance natural. El amuleto se apaga y las partículas caerán al vacío sin otorgar puntos.";
    }
    document.getElementById("pantalla-resultado").style.display = "flex";
}

function proximaOndaOcaso() {
    document.getElementById("pantalla-resultado").style.display = "none";
    juegoCorriendo = true;
    cargarRetOOcaso();
}

function animar() {
    if (!juegoCorriendo && !imanActivado) return;

    ctx.clearRect(0, 0, cvs.width, cvs.height);

    particulas.forEach((p, i) => {
        if (juegoCorriendo) p.y += p.v;
        if (p.y > cvs.height) { p.y = 0; p.x = Math.random() * cvs.width; }

        // Efecto elástico de atracción por proximidad física
        if (imanActivated && p.y > 240 && Math.abs(p.x - imanX) < 70) {
            p.x += (imanX - p.x) * 0.22;
        }

        ctx.save();
        ctx.shadowBlur = 12; ctx.shadowColor = p.color;
        ctx.fillStyle = p.color;
        ctx.beginPath(); ctx.arc(p.x, p.y, 9, 0, Math.PI * 2); ctx.fill();
        ctx.restore();

        // Evaluar colisión exacta con el receptor de la base (Y: 320)
        if (p.y >= 310 && Math.abs(p.x - imanX) < 40) {
            p.y = 0; p.x = Math.random() * cvs.width;
            if (imanActivado) puntuacion += 10;
        }
    });

    // Amuleto Magnético en vector HD puro con halo incandescente
    ctx.save();
    ctx.shadowBlur = 15;
    ctx.shadowColor = imanActivado ? "#00e676" : "#ff1744";
    ctx.fillStyle = imanActivado ? "#00e676" : "#ff1744";
    ctx.fillRect(imanX - 35, 320, 70, 12);
    ctx.restore();
    
    // HUD de puntuación integrado
    ctx.fillStyle = "#FFF"; ctx.font = "bold 14px 'Cinzel', serif"; ctx.textAlign = "left";
    ctx.fillText("SCORE: " + puntuacion + " PTS", 20, 35);

    requestAnimationFrame(animar);
}
</script>
</body>
</html>