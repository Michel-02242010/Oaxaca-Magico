<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Red de Pescador Ancestral</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { 
            background: #020710; 
            color: #00ffcc; 
            font-family: 'Press Start 2P', sans-serif; 
            font-size: 11px;
            text-align: center; 
            margin: 0; padding: 20px;
            overflow: hidden;
        }
        h2 { 
            color: #ff0055; 
            text-shadow: 0 0 10px #ff0055, 0 0 20px #ff0055; 
            font-size: 14px;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        .contenedor-juego {
            position: relative;
            width: 700px;
            height: 360px;
            margin: 20px auto;
        }
        canvas { 
            background: linear-gradient(to bottom, #061524, #010408); 
            border: 4px solid #00ffcc; 
            border-radius: 12px; 
            box-shadow: 0 0 25px rgba(0, 255, 204, 0.3);
            position: absolute;
            top: 0; left: 0;
            z-index: 1;
        }
        .pantalla-overlay {
            position: absolute;
            top: 0; left: 0;
            width: 700px;
            height: 360px;
            background: rgba(1, 4, 8, 0.96);
            border: 4px solid #00ffcc;
            border-radius: 12px;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            padding: 25px;
        }
        .box-titulo {
            color: #ff0055;
            font-size: 12px;
            margin-bottom: 20px;
            text-shadow: 0 0 10px #ff0055;
        }
        .box-texto {
            color: #FFF;
            font-size: 10px;
            line-height: 1.8;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-game {
            padding: 12px 20px;
            font-family: 'Press Start 2P', sans-serif;
            font-size: 9px;
            font-weight: bold;
            background: #000;
            color: #00ffcc;
            border: 2px solid #00ffcc;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0, 255, 204, 0.3);
            transition: all 0.2s;
            margin: 6px;
            width: 90%;
        }
        .btn-game:hover {
            background: #00ffcc;
            color: #000;
            box-shadow: 0 0 20px #00ffcc;
        }
    </style>
</head>
<body>
    <h2>🧜‍♀️ JUEGO 2: Red de Pescador (La Sirena de Zicatela)</h2>
    
    <div class="contenedor-juego">
        <!-- Pantalla Inicial -->
        <div id="pantalla-inicio" class="pantalla-overlay">
            <div class="box-titulo">🎣 RED DE PESCA ANCESTRAL</div>
            <div class="box-texto">
                Desplaza la lancha moviendo el mouse de izquierda a derecha.<br><br>
                La red inferior atrapará las respuestas flotantes. Debes capturar el pez luminoso que responda correctamente la pregunta del océano.
            </div>
            <button class="btn-game" style="width:auto;" onclick="iniciarPesca()">ZARPAR LANCHA</button>
        </div>

        <!-- Pantalla de Resultados Integrada -->
        <div id="pantalla-resultado" class="pantalla-overlay" style="display: none;">
            <div class="box-titulo" id="res-titulo">RED EVALUADA</div>
            <div class="box-texto" id="res-texto">Mensaje</div>
            <button class="btn-game" style="width:auto;" onclick="regresarAlMar()">VOLVER A LANZAR LA RED</button>
        </div>

        <canvas id="canvasPescador" width="700" height="360"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasPescador"), ctx = cvs.getContext("2d");
let lanchaX = 350, juegoCorriendo = false, colisionEvaluada = false;

// Banco expansivo con 5 preguntas distintas sobre el mito y cultura marina
const bancoPreguntasRed = [
    { q: "¿A quiénes encanta la sirena en la orilla del mar de noche?", ops: ["A pescadores trasnochadores u hombres codiciosos 👍", "A los niños que juegan de tarde ❌"], correcta: 0 },
    { q: "¿Qué instrumento musical tradicional acompaña los sones de la costa?", ops: ["La Iguana o la Caja de madera de tapeo 👍", "El Acordeón eléctrico moderno ❌"], correcta: 0 },
    { q: "¿Cuál es el puerto histórico más importante de la Costa oaxaqueña?", ops: ["Puerto Ángel y Puerto Escondido 👍", "Acapulco de Juárez ❌"], correcta: 0 },
    { q: "¿Qué elemento de la naturaleza castiga a los pescadores según el mito?", ops: ["La marea violenta provocada por espíritus 👍", "La lluvia del frente frío ordinario ❌"], correcta: 0 },
    { q: "¿Cuál es la lengua indígena originaria predominante en Pinotepa Nacional?", ops: ["El Mixteco de la Costa 👍", "El Maya peninsular ❌"], correcta: 0 }
];
let preguntaActiva = {};
let peces = [];

function generarPreguntaPeces() {
    preguntaActiva = bancoPreguntasRed[Math.floor(Math.random() * bancoPreguntasRed.length)];
    
    // Configurar los peces autónomos con las opciones dinámicas
    peces = [
        { x: 0, y: 160, v: 2.2, txt: preguntaActiva.ops[0], correcto: true, color: "#00ffcc" },
        { x: 700, y: 250, v: -1.8, txt: preguntaActiva.ops[1], correcto: false, color: "#ff0055" }
    ];
}

cvs.onmousemove = (e) => {
    if (!juegoCorriendo) return;
    let rect = cvs.getBoundingClientRect();
    lanchaX = e.clientX - rect.left;
};

function iniciarPesca() {
    document.getElementById("pantalla-inicio").style.display = "none";
    juegoCorriendo = true;
    generarPreguntaPeces();
    juego();
}

function abrirResultadoRed(esCorrecto) {
    juegoCorriendo = false;
    colisionEvaluada = true;
    const resTitulo = document.getElementById("res-titulo");
    const resTexto = document.getElementById("res-texto");

    if (esCorrecto) {
        resTitulo.innerText = "🏆 CAPTURA CORRECTA";
        resTitulo.style.color = "#00ffcc";
        resTexto.innerHTML = "¡Excelente conocimiento marino!<br><br>Has pescado la respuesta correcta de la leyenda de Zicatela y sumado puntos ancestrales.";
    } else {
        resTitulo.innerText = "🚨 RED DAÑADA / INCORRECTO";
        resTitulo.style.color = "#ff0055";
        resTexto.innerHTML = "¡Oh no! Atrapaste una creencia falsa. El canto de la sirena desorientó tus redes de pesca.";
    }
    document.getElementById("pantalla-resultado").style.display = "flex";
}

function regresarAlMar() {
    document.getElementById("pantalla-resultado").style.display = "none";
    colisionEvaluada = false;
    juegoCorriendo = true;
    generarPreguntaPeces();
}

function juego() {
    if (!juegoCorriendo) return;

    ctx.clearRect(0, 0, cvs.width, cvs.height);

    // Dibujar Enunciado/Pregunta actual flotando estéticamente arriba del mar en color neón
    ctx.fillStyle = "#ff0055"; ctx.font = "bold 9px 'Press Start 2P', sans-serif"; ctx.textAlign = "center";
    ctx.fillText("PREGUNTA: " + preguntaActiva.q, 350, 85);

    // Lancha de pesca vectorial
    ctx.save();
    ctx.shadowBlur = 10; ctx.shadowColor = "#ff0055";
    ctx.fillStyle = "#ff0055"; ctx.fillRect(lanchaX - 35, 110, 70, 15);
    ctx.restore();

    // Cable guía de la red
    ctx.strokeStyle = "rgba(0, 255, 204, 0.4)"; ctx.lineWidth = 2;
    ctx.beginPath(); ctx.moveTo(lanchaX, 125); ctx.lineTo(lanchaX, 300); ctx.stroke();

    // Red de malla circular vectorizada
    ctx.save();
    ctx.shadowBlur = 10; ctx.shadowColor = "#00ffcc";
    ctx.fillStyle = "#00ffcc"; ctx.beginPath(); ctx.arc(lanchaX, 300, 20, 0, Math.PI, false); ctx.fill();
    ctx.restore();

    // Procesar peces autónomos
    peces.forEach(p => {
        p.x += p.v;
        if (p.v > 0 && p.x > cvs.width) p.x = -150;
        if (p.v < 0 && p.x < -150) p.x = 700;

        // Renderizado del pez mediante vectores dinámicos
        ctx.save();
        ctx.shadowBlur = 10; ctx.shadowColor = p.color;
        ctx.fillStyle = p.color; 
        ctx.beginPath(); ctx.arc(p.x, p.y, 14, 0, Math.PI * 2); ctx.fill();
        // Cola del pez vectorial
        ctx.beginPath();
        ctx.moveTo(p.x + (p.v > 0 ? -14 : 14), p.y);
        ctx.lineTo(p.x + (p.v > 0 ? -24 : 24), p.y - 8);
        ctx.lineTo(p.x + (p.v > 0 ? -24 : 24), p.y + 8);
        ctx.fill();
        ctx.restore();

        ctx.fillStyle = "#FFF"; ctx.font = "9px 'Press Start 2P', sans-serif"; ctx.textAlign = "center";
        ctx.fillText(p.txt, p.x, p.y - 25);

        // Detectar colisión exacta con la red
        if (!colisionEvaluada && p.y >= 280 && p.y <= 315 && Math.abs(p.x - lanchaX) < 25) {
            abrirResultadoRed(p.correcto);
        }
    });

    if (juegoCorriendo) {
        requestAnimationFrame(juego);
    }
}
</script>
</body>
</html>
