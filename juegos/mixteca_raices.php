<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Las Raíces de Apoala - Mixteca</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { background: #110d0a; color: #FECE79; font-family: 'VT323', monospace; font-size: 24px; text-align: center; margin: 0; padding: 20px; overflow: hidden; }
        h2 { font-family: 'Cinzel', serif; color: #E6A341; font-size: 26px; margin: 5px 0; }
        .contenedor-juego { position: relative; width: 600px; height: 400px; margin: 15px auto; }
        canvas { background: #261710; border: 4px solid #E6A341; border-radius: 10px; position: absolute; top: 0; left: 0; z-index: 1; box-shadow: 0 0 25px rgba(230,163,65,0.3); }
        .overlay { position: absolute; top: 0; left: 0; width: 600px; height: 400px; background: rgba(17, 13, 10, 0.98); border: 4px solid #E6A341; border-radius: 10px; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 25px; box-sizing: border-box; }
        .box-titulo { color: #E6A341; font-size: 32px; margin-bottom: 12px; text-shadow: 0 0 10px #E6A341; font-family: 'Cinzel', serif; }
        .box-texto { color: #FFF; font-size: 20px; line-height: 1.6; margin-bottom: 15px; text-align: center; }
        .btn-game { padding: 8px 16px; font-family: 'VT323', monospace; font-size: 20px; font-weight: bold; background: #000; color: #FECE79; border: 2px solid #E6A341; border-radius: 6px; cursor: pointer; margin: 5px; transition: all 0.2s; width: 85%; }
        .btn-game:hover { background: #E6A341; color: #110d0a; box-shadow: 0 0 15px #E6A341; }
    </style>
</head>
<body>
    <h2>🌳 MISIÓN: Las Raíces de Apoala</h2>
    
    <div class="contenedor-juego">
        <!-- Pantalla Inicial -->
        <div id="pantalla-inicio" class="overlay">
            <div class="box-titulo">📜 NUTRICIÓN MÍSTICA</div>
            <div class="box-texto">
                ¡Hola, <?= htmlspecialchars($nombre) ?>!<br><br>
                Usa las flechas ⬅️ IZQUIERDA y ➡️ DERECHA de tu teclado para guiar la raíz dorada mientras crece hacia abajo.<br><br>
                Debes dirigir la raíz hacia el letrero inferior que contenga la respuesta histórica correcta para absorber agua y hacer florecer la región Mixteca.
            </div>
            <button class="btn-game" style="width:auto;" onclick="iniciarRaices()">INICIAR DESCENSO</button>
        </div>

        <!-- Pantalla Feedback -->
        <div id="pantalla-resultado" class="overlay" style="display: none;">
            <div class="box-titulo" id="res-titulo">ZONA DE DECISIÓN</div>
            <div class="box-texto" id="res-texto">Mensaje instructivo</div>
            <button class="btn-game" id="btn-accion-raiz" style="width:auto;" onclick="siguienteProfundidad()">SIGUIENTE RETO</button>
        </div>

        <canvas id="canvasRaiz" width="600" height="400"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasRaiz"), ctx = cvs.getContext("2d");
let rx = 300, ry = 0, juegoCorriendo = false, evaluado = false, progresoMision = 0;

// Banco expansivo con 4 preguntas distintas sobre los mitos de origen mixteco
const bancoRaices = [
    { q: "¿De dónde nacieron los primeros hombres jefes mixtecas?", ok: "De los Árboles Sagrados de Apoala 👍", no: "De las Cuevas de Oro de la Sierra ❌", correcto: "izq" },
    { q: "¿Qué paraje místico resguarda las raíces del origen del pueblo mixteco?", ops: "El místico Valle de Apoala 👍", no: "Las dunas desérticas del Istmo ❌", correcto: "izq" },
    { q: "¿Qué divinidad mixteca sopló vida sobre los parajes mísiticos?", ops: "El Dios de la Lluvia Dzahui 👍", no: "El gigante guerrero Condoy ❌", correcto: "izq" },
    { q: "¿Qué importante documento histórico registra estas genealogías sagradas?", ops: "Los Códices Mixtecos de piel de venado 👍", no: "Las tablillas de arcilla tallada ❌", correcto: "izq" }
];
let retoActual = {};

window.onkeydown = (e) => {
    if (!juegoCorriendo) return;
    if (e.key === "ArrowLeft" && rx > 60) rx -= 20;
    if (e.key === "ArrowRight" && rx < 540) rx += 20;
};

function cargarRetoRaices() {
    retoActual = bancoRaices[Math.floor(Math.random() * bancoRaices.length)];
    evaluado = false;
    rx = 300; ry = 0;
    ctx.clearRect(0, 0, cvs.width, cvs.height);
}

function iniciarRaices() {
    document.getElementById("pantalla-inicio").style.display = "none";
    juegoCorriendo = true;
    cargarRetoRaices();
    bucle();
}

function evaluarCaminoRaiz(eleccionUsuario) {
    juegoCorriendo = false;
    evaluado = true;
    const resTitulo = document.getElementById("res-titulo");
    const resTexto = document.getElementById("res-texto");

    if (eleccionUsuario === retoActual.correcto) {
        progresoMision += 34;
        resTitulo.innerText = "🏆 LOGRO DESBLOQUEADO";
        resTitulo.style.color = "#00ffcc";
        resTexto.innerHTML = "¡Excelente respuesta! Tu raíz mística absorbe agua de los mantos sagrados y la región Mixteca florece con fuerza.";
    } else {
        resTitulo.innerText = "🚨 COLISIÓN DE LAVA";
        resTitulo.style.color = "#ff3333";
        resTexto.innerHTML = "¡Oops! Chocaste con una vena de lava subterránea. El error seca los brotes. Los árboles sagrados exigen la verdad histórica para nutrirse.";
    }
    document.getElementById("pantalla-resultado").style.display = "flex";
}

function siguienteProfundidad() {
    document.getElementById("pantalla-resultado").style.display = "none";
    
    if (progresoMision >= 100) {
        document.getElementById("res-titulo").innerText = "🥇 ÁRBOL DEL ORIGEN COMPLETO";
        document.getElementById("res-titulo").style.color = "#00ffcc";
        document.getElementById("res-texto").innerText = "¡Felicidades! Has guiado exitosamente las raíces ancestrales y completado el códice sagrado de Apoala.";
        document.getElementById("btn-accion-raiz").innerText = "REINICIAR ÁRBOL";
        document.getElementById("btn-accion-raiz").onclick = () => location.reload();
        document.getElementById("pantalla-resultado").style.display = "flex";
    } else {
        juegoCorriendo = true;
        cargarRetoRaices();
    }
}

function bucle() {
    if (!juegoCorriendo) return;

    // Dibujar el camino de la raíz (crece hacia abajo progresivamente)
    ry += 1.8;

    // Textos educativos fijos dentro del Canvas con fuentes premium
    if (ry > 100 && ry < 105) {
        ctx.fillStyle = "#FECE79"; ctx.font = "22px 'VT323'"; ctx.textAlign = "center";
        ctx.fillText(retoActual.q, 300, 130);
    }
    
    if (ry > 150) {
        // Letrero Izquierdo vectorial
        ctx.fillStyle = "#5c0601"; ctx.fillRect(40, 220, 220, 45);
        ctx.strokeStyle = "#E6A341"; ctx.strokeRect(40, 220, 220, 45);
        ctx.fillStyle = "#FFF"; ctx.font = "16px 'VT323'"; ctx.fillText((retoActual.correcto === "izq") ? retoActual.ok || "Opción A 👍" : retoActual.no || "Opción A ❌", 150, 248);
        
        // Letrero Derecho vectorial
        ctx.fillStyle = "#5c0601"; ctx.fillRect(340, 220, 220, 45);
        ctx.strokeRect(340, 220, 220, 45);
        ctx.fillStyle = "#FFF"; ctx.fillText((retoActual.correcto === "der") ? retoActual.ok || "Opción B 👍" : retoActual.no || "Opción B ❌", 450, 248);
    }

    // Dibujar la punta de la Raíz principal con halo incandescente (Evita emojis)
    ctx.save();
    ctx.shadowBlur = 12; ctx.shadowColor = "#FECE79";
    ctx.fillStyle = "#FECE79";
    ctx.beginPath(); ctx.arc(rx, ry, 6, 0, Math.PI * 2); ctx.fill();
    ctx.restore();

    // Evaluar zona de decisión matemática (Bifurcación en Y: 220)
    if (!evaluado && ry >= 220 && ry <= 226) {
        let eleccion = (rx < 300) ? "izq" : "der";
        evaluarCaminoRaiz(eleccion);
    }

    if (ry < cvs.height && juegoCorriendo) {
        requestAnimationFrame(bucle);
    }
}
</script>
</body>
</html>
