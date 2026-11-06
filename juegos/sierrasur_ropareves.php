<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>La Ropa al Revés - Sierra Sur</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { background: #0a120b; color: #a3e2a4; font-family: 'Press Start 2P', sans-serif; font-size: 11px; text-align: center; margin: 0; padding: 20px; overflow: hidden; }
        h2 { color: #4caf50; text-shadow: 0 0 10px rgba(76,175,80,0.4); margin-bottom: 10px; }
        .contenedor-juego { position: relative; width: 600px; height: 300px; margin: 15px auto; }
        canvas { background: #112214; border: 4px solid #4caf50; border-radius: 12px; position: absolute; top: 0; left: 0; z-index: 1; box-shadow: 0 0 25px rgba(76,175,80,0.2); }
        .overlay { position: absolute; top: 0; left: 0; width: 600px; height: 300px; background: rgba(10, 25, 12, 0.97); border: 4px solid #4caf50; border-radius: 12px; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; }
        .box-titulo { color: #4caf50; font-size: 11px; margin-bottom: 12px; text-shadow: 0 0 8px #4caf50; }
        .box-texto { color: #FFF; font-size: 9px; line-height: 1.8; margin-bottom: 15px; text-align: center; }
        .btn-game { padding: 10px 18px; font-family: 'Press Start 2P', sans-serif; font-size: 9px; font-weight: bold; background: #000; color: #4caf50; border: 2px solid #4caf50; border-radius: 5px; cursor: pointer; margin: 4px; transition: all 0.2s; }
        .btn-game:hover { background: #4caf50; color: #000; box-shadow: 0 0 15px #4caf50; }
        .btn-ans { border-color: #00ffff; color: #00ffff; width: 85%; }
        .btn-ans:hover { background: #00ffff; color: #000; box-shadow: 0 0 15px #00ffff; }
    </style>
</head>
<body>
    <h2>🌿 MAPA : La Ropa al Revés (Rompe el Rumbo)</h2>
    
    <div class="contenedor-juego">
        <!-- Pantalla Inicial -->
        <div id="pantalla-inicio" class="overlay">
            <div class="box-titulo">🚨 TRUCO DE LOS CHANEQUES</div>
            <div class="box-texto">
                ¡Los traviesos chaneques han invertido tus movimientos!<br><br>
                Usa las flechas ⬅️ IZQUIERDA y ➡️ DERECHA de tu teclado. Los controles caminarán al revés a menos que respondas correctamente las preguntas de geografía de la Sierra Sur para activar tu amuleto protector. ¡Llega a la meta segura!
            </div>
            <button class="btn-game" onclick="iniciarBosque()">ENTRAR AL MONTE</button>
        </div>

        <!-- Pantalla de Trivia Dinámica -->
        <div id="pantalla-trivia" class="overlay" style="display: none;">
            <div class="box-titulo">🌲 CUESTIONARIO DE LA SIERRA</div>
            <div class="box-texto" id="trivia-pregunta">Pregunta</div>
            <button class="btn-game btn-ans" id="opc-0" onclick="evaluarBosque(0)">Opción A</button>
            <button class="btn-game btn-ans" id="opc-1" onclick="evaluarBosque(1)">Opción B</button>
        </div>

        <!-- Pantalla Feedback -->
        <div id="pantalla-resultado" class="overlay" style="display: none;">
            <div class="box-titulo" id="res-titulo">AMULETO ACTIVADO</div>
            <div class="box-texto" id="res-texto">Mensaje explicativo</div>
            <button class="btn-game" id="btn-res-accion" onclick="cerrarResultadoBosque()">CONTINUAR CAMINO</button>
        </div>

        <canvas id="canvasRopa" width="600" height="300"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasRopa"), ctx = cvs.getContext("2d");
let personajeX = 80, amuletoActivado = false, juegoCorriendo = false;

// Banco expansivo con 4 preguntas sobre la Sierra Sur de Oaxaca
const bancoSierra = [
    { q: "¿A qué región oaxaqueña pertenece el municipio de Miahuatlán de Porfirio Díaz?", ops: ["A la Sierra Sur 🌲", "A la Costa Chica 🌊"], correcta: 0 },
    { q: "¿Cuál es la principal actividad artesanal y económica de San José del Pacífico?", ops: ["La producción de café y el ecoturismo de bosque 🌲", "La pesca de altamar ❌"], correcta: 0 },
    { q: "¿Qué cordillera montañosa cruza toda esta hermosa región oaxaqueña?", ops: ["La Sierra Madre del Sur 🏔️", "La Sierra de la Huasteca ❌"], correcta: 0 },
    { q: "¿Qué prenda textil artesanal tejida en telar de cintura identifica a la región?", ops: ["Los huipiles bordados de seda fina 🧵", "Los sombreros de palma costeña ❌"], correcta: 0 }
];
let retoActual = {};

function cargarRetoSierra() {
    retoActual = bancoSierra[Math.floor(Math.random() * bancoSierra.length)];
    document.getElementById("trivia-pregunta").innerText = retoActual.q;
    document.getElementById("opc-0").innerText = retoActual.ops[0];
    document.getElementById("opc-1").innerText = retoActual.ops[1];
    document.getElementById("pantalla-trivia").style.display = "flex";
    juegoCorriendo = false;
}

window.onkeydown = (e) => {
    if (!juegoCorriendo) return;
    let multiplicador = amuletoActivado ? 1 : -1;

    if (e.key === "ArrowLeft") personajeX -= (15 * multiplicador);
    if (e.key === "ArrowRight") personajeX += (15 * multiplicador);
    
    personajeX = Math.max(20, Math.min(580, personajeX));
};

function iniciarBosque() {
    document.getElementById("pantalla-inicio").style.display = "none";
    juegoCorriendo = true;
    dibujarMundo();
    setTimeout(cargarRetoSierra, 1000);
}

function evaluarBosque(opcion) {
    document.getElementById("pantalla-trivia").style.display = "none";
    const resTitulo = document.getElementById("res-titulo");
    const resTexto = document.getElementById("res-texto");

    if (opcion === retoActual.correcta) {
        amuletoActivado = true;
        resTitulo.innerText = "✨ AMULETO DESPIERTO";
        resTitulo.style.color = "#00ffcc";
        resTexto.innerHTML = "¡Excelente respuesta! Tu conocimiento rompió el truco de la ropa invertida. Los controles se han normalizado. ¡Camina rápido a la meta!";
    } else {
        amuletoActivado = false;
        resTitulo.innerText = "❌ TRUCO DUPLICADO";
        resTitulo.style.color = "#ff3333";
        resTexto.innerHTML = "¡Incorrecto! Los chaneques se ríen y te confunden más. Los controles siguen completamente invertidos (Izquierda camina a la Derecha).";
    }
    document.getElementById("pantalla-resultado").style.display = "flex";
}

function cerrarResultadoBosque() {
    document.getElementById("pantalla-resultado").style.display = "none";
    juegoCorriendo = true;
}

function dibujarMundo() {
    ctx.clearRect(0, 0, cvs.width, cvs.height);

    // Zona de la Meta (Altar seguro) vectorizado
    ctx.fillStyle = "rgba(76, 175, 80, 0.25)"; ctx.fillRect(500, 0, 100, cvs.height);
    ctx.strokeStyle = "#4caf50"; ctx.lineWidth = 2; ctx.strokeRect(500, 0, 100, cvs.height);
    
    ctx.fillStyle = "#FFF"; ctx.font = "bold 9px 'Press Start 2P'"; ctx.textAlign = "center";
    ctx.fillText("SAFE", 550, 140); ctx.fillText("ZONE", 550, 160);

    // Dibujar al Viajero mediante formas geométricas nítidas (Evita emojis)
    ctx.save();
    ctx.shadowBlur = 12; ctx.shadowColor = amuletoActivado ? "#4caf50" : "#ff4d4d";
    ctx.fillStyle = amuletoActivado ? "#4caf50" : "#ff4d4d";
    ctx.fillRect(personajeX - 12, 130, 24, 40); // Cuerpo
    ctx.fillStyle = "#fff"; ctx.beginPath(); ctx.arc(personajeX, 118, 7, 0, Math.PI * 2); ctx.fill(); // Cabeza
    ctx.restore();

    // Evaluar si el personaje llegó al refugio seguro derecho
    if (personajeX >= 500) {
        juegoCorriendo = false;
        document.getElementById("res-titulo").innerText = "🏆 ¡MISIÓN COMPLETADA!";
        document.getElementById("res-titulo").style.color = "#00ffcc";
        document.getElementById("res-texto").innerHTML = "¡Felicidades! Lograste burlar el truco del monte a salvo y guiaste al viajero fuera de los peligros de los chaneques.";
        document.getElementById("btn-res-accion").innerText = "REINICIAR ESCENARIO";
        document.getElementById("btn-res-accion").onclick = () => location.reload();
        document.getElementById("pantalla-resultado").style.display = "flex";
        return;
    }

    requestAnimationFrame(dibujarMundo);
}
</script>
</body>
</html>
