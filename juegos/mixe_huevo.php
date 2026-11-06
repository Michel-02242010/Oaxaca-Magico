<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>El Huevo de Ópalo - Rey Condoy</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { background: #090214; color: #00ffcc; font-family: 'Press Start 2P', sans-serif; font-size: 11px; text-align: center; margin: 0; padding: 20px; overflow: hidden; }
        h2 { color: #ff007f; text-shadow: 0 0 10px #ff007f; font-size: 14px; margin-bottom: 10px; }
        .contenedor-juego { position: relative; width: 600px; height: 320px; margin: 15px auto; }
        canvas { background: #110924; border: 4px solid #ff007f; border-radius: 12px; position: absolute; top: 0; left: 0; z-index: 1; box-shadow: 0 0 25px #ff007f; }
        .overlay { position: absolute; top: 0; left: 0; width: 600px; height: 320px; background: rgba(17, 9, 36, 0.97); border: 4px solid #00ffcc; border-radius: 12px; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; }
        .box-titulo { color: #ff007f; font-size: 11px; margin-bottom: 15px; text-shadow: 0 0 8px #ff007f; }
        .box-texto { color: #FFF; font-size: 9px; line-height: 1.8; margin-bottom: 20px; text-align: center; }
        .btn-game { padding: 10px 18px; font-family: 'Press Start 2P', sans-serif; font-size: 9px; font-weight: bold; background: #000; color: #00ffcc; border: 2px solid #00ffcc; border-radius: 5px; cursor: pointer; transition: all 0.2s; }
        .btn-game:hover { background: #00ffcc; color: #000; box-shadow: 0 0 15px #00ffcc; }
        .btn-ans { border-color: #ff007f; color: #ff007f; width: 85%; margin: 4px; }
        .btn-ans:hover { background: #ff007f; color: #000; box-shadow: 0 0 15px #ff007f; }
    </style>
</head>
<body>
    <h2>✨ NIVEL: El Huevo de Ópalo Místico</h2>
    
    <div class="contenedor-juego">
        <!-- Pantalla Inicial -->
        <div id="pantalla-inicio" class="overlay">
            <div class="box-titulo">🔮 EL EQUILIBRIO SAGRADO</div>
            <div class="box-texto">
                Mueve tu MOUSE horizontalmente para inclinar la plataforma del nido.<br><br>
                El Huevo de Ópalo pierde energía constantemente. Responde las trivias míticas para recargar su destello core y mantén el huevo balanceado en el centro. ¡Si se desliza a los lados, caerá!
            </div>
            <button class="btn-game" onclick="iniciarHuevo()">INICIAR BALANTEO</button>
        </div>

        <!-- Pantalla de Trivia Dinámica -->
        <div id="pantalla-trivia" class="overlay" style="display: none;">
            <div class="box-titulo">❔ PREGUNTA DE RECARGA</div>
            <div class="box-texto" id="trivia-pregunta">Pregunta</div>
            <button class="btn-game btn-ans" id="opc-0" onclick="evaluarHuevo(0)">Opción A</button>
            <button class="btn-game btn-ans" id="opc-1" onclick="evaluarHuevo(1)">Opción B</button>
        </div>

        <!-- Pantalla Feedback -->
        <div id="pantalla-resultado" class="overlay" style="display: none;">
            <div class="box-titulo" id="res-titulo">CORE STATUS</div>
            <div class="box-texto" id="res-texto">Mensaje</div>
            <button class="btn-game" onclick="cerrarResultadoHuevo()">REGRESAR AL CANVAS</button>
        </div>

        <canvas id="canvasHuevo" width="600" height="320"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasHuevo"), ctx = cvs.getContext("2d");
let hx = 300, hvx = 0, nidoAngulo = 0, energiaOpal = 100, juegoCorriendo = false, triviaAbierta = false;

// Banco expansivo de 4 preguntas de la mitología Mixe
const bancoHuevo = [
    { q: "¿La leyenda dice que el Rey Condoy no murió, sino que duerme en el cerro Zempoaltépetl?", ops: ["VERDADERO. Despertará si su pueblo está en peligro 👍", "FALSO. Los relatos dicen que desapareció en el mar ❌"], correcta: 0 },
    { q: "¿Qué criatura mística resguarda los accesos a las cuevas sagradas de Condoy?", ops: ["La Serpiente de dos cabezas o Serpiente de Nube 👍", "Un Jaguar de fuego gigante ❌"], correcta: 0 },
    { q: "¿Qué ofrenda tradicional recarga espiritualmente el Huevo de Ópalo?", ops: ["Granos de cacao puro, ollas de pulque y tamales 👍", "Monedas de oro importadas de otros continentes ❌"], correcta: 0 },
    { q: "¿De qué material precioso reluciente estaba hecho el huevo de la cueva?", ops: ["De Ópalo místico protector de destellos divinos 👍", "De obsidiana negra pulida del volcán ❌"], correcta: 0 }
];
let retoActual = {};

cvs.onmousemove = (e) => {
    if (!juegoCorriendo || triviaAbierta) return;
    let rect = cvs.getBoundingClientRect(), mx = e.clientX - rect.left;
    nidoAngulo = (mx - 300) / 1500; 
};

function cargarTriviaHuevo() {
    juegoCorriendo = false;
    triviaAbierta = true;
    retoActual = bancoHuevo[Math.floor(Math.random() * bancoHuevo.length)];
    document.getElementById("trivia-pregunta").innerText = retoActual.q;
    document.getElementById("opc-0").innerText = retoActual.ops;
    document.getElementById("opc-1").innerText = retoActual.ops;
    document.getElementById("pantalla-trivia").style.display = "flex";
}

function iniciarHuevo() {
    document.getElementById("pantalla-inicio").style.display = "none";
    juegoCorriendo = true;
    loopJuego();
}

function evaluarHuevo(opcion) {
    document.getElementById("pantalla-trivia").style.display = "none";
    const resTitulo = document.getElementById("res-titulo");
    const resTexto = document.getElementById("res-texto");

    if (opcion === retoActual.correcta) {
        energiaOpal = Math.min(100, energiaOpal + 45);
        resTitulo.innerText = "⚡ ENERGY CORE RECHARGED";
        resTitulo.style.color = "#00ffcc";
        resTexto.innerHTML = "¡Excelente respuesta tradicional! Has inyectado sabiduría al nido místico, restaurando +45% de energía calórica al Huevo de Ópalo.";
    } else {
        resTitulo.innerText = "🚨 RECHARGE FAILED";
        resTitulo.style.color = "#ff007f";
        resTexto.innerHTML = "¡Incorrecto! La respuesta errónea debilita el escudo. No se generó recarga de ópalo y el núcleo sigue enfriándose.";
    }
    document.getElementById("pantalla-resultado").style.display = "flex";
}

function cerrarResultadoHuevo() {
    document.getElementById("pantalla-resultado").style.display = "none";
    triviaAbierta = false;
    juegoCorriendo = true;
}

function loopJuego() {
    if (!juegoCorriendo && triviaAbierta) return;

    ctx.clearRect(0, 0, cvs.width, cvs.height);
    
    if (juegoCorriendo) {
        energiaOpal = Math.max(0, energiaOpal - 0.09);
        hvx += Math.sin(nidoAngulo) * 0.4;
        hx += hvx;
        hvx *= 0.98; // Fricción básica
    }

    // Límites de caída del nido místico
    if (hx < 50 || hx > 550) {
        hx = 300; hvx = 0; nidoAngulo = 0;
        juegoCorriendo = false;
        document.getElementById("res-titulo").innerText = "🎒 HUEVO DESLIZADO";
        document.getElementById("res-titulo").style.color = "#ff007f";
        document.getElementById("res-texto").innerText = "¡El huevo se resbaló fuera de la plataforma protectora! Mantén el mouse centrado para estabilizar la inclinación.";
        document.getElementById("pantalla-resultado").style.display = "flex";
        return;
    }

    // 1. Plataforma inclinada vectorial de neón rosa
    ctx.save();
    ctx.translate(300, 260);
    ctx.rotate(nidoAngulo);
    ctx.fillStyle = "#ff007f"; 
    ctx.shadowBlur = 15; ctx.shadowColor = "#ff007f";
    ctx.fillRect(-250, -5, 500, 10);
    ctx.restore();

    // 2. Altura Y acoplada a la rotación
    let dx = hx - 300;
    let hy = 260 + dx * Math.sin(nidoAngulo) - 25;

    // 3. Dibujar Huevo de Ópalo vectorial en alta definición con destellos (Evita emojis)
    let alpha = energiaOpal / 100;
    ctx.save();
    ctx.shadowBlur = 25; ctx.shadowColor = "#00ffcc";
    ctx.fillStyle = "rgba(0, 255, 204, " + alpha + ")";
    ctx.beginPath(); ctx.arc(hx, hy, 22, 0, Math.PI * 2); ctx.fill();
    ctx.strokeStyle = "#FFF"; ctx.lineWidth = 3; ctx.stroke();
    ctx.restore();

    // HUD
    ctx.fillStyle = "#00ffcc"; ctx.font = "bold 9px 'Press Start 2P'"; ctx.textAlign = "left";
    ctx.fillText("CORE ENERGY: " + Math.floor(energiaOpal) + "%", 20, 35);

    // Si la energía llega a cero, forzar la apertura de la trivia para recargar
    if (energiaOpal <= 0 && !triviaAbierta) {
        cargarTriviaHuevo();
    }

    requestAnimationFrame(loopJuego);
}
</script>
</body>
</html>
