<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>El Rapto del Tonal - Sierra Sur</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { background: #050f0a; color: #81c784; font-family: 'VT323', monospace; font-size: 24px; text-align: center; margin: 0; padding: 20px; overflow: hidden; }
        h2 { color: #2e7d32; font-size: 32px; text-shadow: 0 0 10px rgba(46,125,50,0.3); margin: 5px 0; }
        .contenedor-juego { position: relative; width: 700px; height: 350px; margin: 15px auto; }
        canvas { background: #0b2216; border: 4px solid #2e7d32; border-radius: 12px; position: absolute; top: 0; left: 0; z-index: 1; box-shadow: 0 0 30px rgba(46,125,50,0.3); }
        .overlay { position: absolute; top: 0; left: 0; width: 700px; height: 350px; background: rgba(5, 15, 10, 0.97); border: 4px solid #2e7d32; border-radius: 12px; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 25px; box-sizing: border-box; }
        .box-titulo { color: #fece79; font-size: 30px; margin-bottom: 12px; text-shadow: 0 0 10px #fece79; }
        .box-texto { color: #FFF; font-size: 19px; line-height: 1.6; margin-bottom: 15px; text-align: center; }
        .btn-game { padding: 8px 16px; font-family: 'VT323', monospace; font-size: 20px; font-weight: bold; background: #1b120c; color: #fece79; border: 2px solid #e6a341; border-radius: 6px; cursor: pointer; margin: 5px; transition: all 0.2s; width: 85%; }
        .btn-game:hover { background: #e6a341; color: #1b120c; box-shadow: 0 0 15px #e6a341; }
    </style>
</head>
<body>
    <h2>🍃 INVOCACIÓN: El Rapto del Tonal</h2>
    
    <div class="contenedor-juego">
        <!-- Pantalla Inicial -->
        <div id="pantalla-inicio" class="overlay">
            <div class="box-titulo">📜 RITUAL DE CURACIÓN</div>
            <div class="box-texto">
                ¡El Chaneque ha robado el tonal! El cuerpo físico sigue al alma con retraso en el plano espiritual.<br><br>
                Mueve el mouse para guiar el alma brillante. Responde las preguntas tradicionales seleccionando las ofrendas reales para estabilizar la sincronía y curar el espanto de inmediato.
            </div>
            <button class="btn-game" style="width:auto;" onclick="iniciarRitual()">INICIAR RITUAL</button>
        </div>

        <!-- Pantalla de Pregunta Dinámica -->
        <div id="pantalla-trivia" class="overlay" style="display: none;">
            <div class="box-titulo">✨ OFRENDA MEDICINAL</div>
            <div class="box-texto" id="trivia-pregunta">Pregunta</div>
            <button class="btn-game" id="opc-0" onclick="evaluarOfrenda(true)">Opción A</button>
            <button class="btn-game" id="opc-1" onclick="evaluarOfrenda(false)">Opción B</button>
        </div>

        <!-- Pantalla Feedback -->
        <div id="pantalla-resultado" class="overlay" style="display: none;">
            <div class="box-titulo" id="res-titulo">PROGRESO</div>
            <div class="box-texto" id="res-texto">Mensaje</div>
            <button class="btn-game" style="width:auto;" onclick="siguienteFase()">SIGUIENTE OFRENDA</button>
        </div>

        <canvas id="canvasTonal" width="700" height="350"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasTonal"), ctx = cvs.getContext("2d");
let almaX = 350, almaY = 100, historialMovimientos = [], retrasoFotogramas = 120;
let aciertos = 0, juegoCorriendo = false;

// Banco de preguntas expandido con múltiples retos de herbolaria tradicional
const bancoOfrendas = [
    { q: "¿Cuál de estos elementos calma a los chaneques y limpia el espíritu herido?", ok: "✨ Copal Sagrado Ancestral", no: "📱 Dispositivo de Red Celular", esOk: true },
    { q: "¿Qué planta fuerte se utiliza en las limpias de espanto de la Sierra Sur?", ok: "🍂 Tabaco Fuerte Medicinal", no: "🍬 Refrescos y Golosinas Sintéticas", esOk: true },
    { q: "¿Qué elemento tradicional se coloca en altares para endulzar el alma del niño?", ok: "🍬 Dulces de Azúcar Artesanal", no: "🪙 Monedas de plástico modernas", esOk: true }
];
let retoActual = {};

function cargarRetoOfrenda() {
    if (bancoOfrendas.length === 0 || aciertos >= 3) {
        finalizarJuegoExitoso();
        return;
    }
    const idx = Math.floor(Math.random() * bancoOfrendas.length);
    retoActual = bancoOfrendas.splice(idx, 1)[0];
    
    document.getElementById("trivia-pregunta").innerText = retoActual.q;
    document.getElementById("opc-0").innerText = retoActual.ok;
    document.getElementById("opc-1").innerText = retoActual.no;
    document.getElementById("pantalla-trivia").style.display = "flex";
    juegoCorriendo = false;
}

cvs.onmousemove = (e) => {
    if (!juegoCorriendo) return;
    let rect = cvs.getBoundingClientRect();
    almaX = e.clientX - rect.left; almaY = e.clientY - rect.top;
};

function iniciarRitual() {
    document.getElementById("pantalla-inicio").style.display = "none";
    juegoCorriendo = true;
    setTimeout(cargarRetoOfrenda, 1500);
    loop();
}

function evaluarOfrenda(isOpc0) {
    document.getElementById("pantalla-trivia").style.display = "none";
    const resTitulo = document.getElementById("res-titulo");
    const resTexto = document.getElementById("res-texto");

    if (isOpc0) {
        aciertos++;
        retrasoFotogramas = Math.max(0, retrasoFotogramas - 40);
        resTitulo.innerText = "👍 COMPONENTE CORRECTO";
        resTitulo.style.color = "#81c784";
        resTexto.innerHTML = "¡Excelente elección! Añadiste un recurso medicinal real. El cuerpo físico recobra energía y se acerca rápidamente a su alma.";
    } else {
        retrasoFotogramas += 40;
        resTitulo.innerText = "🎒 RITUAL ALTERADO";
        resTitulo.style.color = "#ff4d4d";
        resTexto.innerHTML = "¡Elemento incorrecto! Los chaneques se burlan de los objetos modernos y el cuerpo pierde consistencia desorientándose más.";
    }
    document.getElementById("pantalla-resultado").style.display = "flex";
}

function siguienteFase() {
    document.getElementById("pantalla-resultado").style.display = "none";
    juegoCorriendo = true;
    setTimeout(cargarRetoOfrenda, 2000);
}

function finalizarJuegoExitoso() {
    juegoCorriendo = false;
    retrasoFotogramas = 0;
    const resTitulo = document.getElementById("res-titulo");
    resTitulo.innerText = "🏆 RITUAL COMPLETADO";
    resTitulo.style.color = "#fece79";
    document.getElementById("res-texto").innerHTML = "¡Sincronización Completa! Lograste reintegrar el Tonal de vuelta al cuerpo físico. El niño está curado del espanto.";
    document.getElementById("pantalla-resultado").style.display = "flex";
    document.querySelector("#pantalla-resultado .btn-game").onclick = () => location.reload();
}

function loop() {
    ctx.clearRect(0, 0, cvs.width, cvs.height);

    if (juegoCorriendo) {
        historialMovimientos.push({x: almaX, y: almaY});
        if (historialMovimientos.length > 200) historialMovimientos.shift();
    }

    let indiceRetraso = Math.max(0, historialMovimientos.length - 1 - retrasoFotogramas);
    let cuerpoPos = historialMovimientos[indiceRetraso] || {x: 350, y: 250};

    // Zona del plano espiritual superior
    ctx.fillStyle = "rgba(230, 163, 65, 0.05)"; ctx.fillRect(0, 0, cvs.width, 180);
    
    // Alma en vector de neón oro
    ctx.save();
    ctx.shadowBlur = 15; ctx.shadowColor = "#fece79";
    ctx.fillStyle = "#fece79"; ctx.beginPath(); ctx.arc(almaX, almaY, 15, 0, Math.PI*2); ctx.fill();
    ctx.restore();
    ctx.fillStyle = "#FFF"; ctx.font = "16px 'VT323'"; ctx.fillText("ALMA (Tonal)", almaX - 35, almaY - 22);

    // Cuerpo en vector carmesí
    ctx.save();
    ctx.shadowBlur = 15; ctx.shadowColor = "#ff4d4d";
    ctx.fillStyle = "#ff4d4d"; ctx.fillRect(cuerpoPos.x - 15, 260, 30, 45);
    ctx.restore();
    ctx.fillStyle = "#FFF"; ctx.fillText("CUERPO", cuerpoPos.x - 20, 245);

    requestAnimationFrame(loop);
}
</script>
</body>
</html>
