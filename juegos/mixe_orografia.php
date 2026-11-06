<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Moldeador de Orografía - Rey Condoy</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { background: #0d0907; color: #FECE79; font-family: 'VT323', monospace; font-size: 24px; text-align: center; margin: 0; padding: 20px; overflow: hidden; }
        h2 { font-family: 'Cinzel', serif; color: #E6A341; text-shadow: 0 0 15px rgba(230,163,65,0.6); font-size: 26px; margin: 10px 0; }
        .contenedor-juego { position: relative; width: 700px; height: 350px; margin: 15px auto; }
        canvas { background: linear-gradient(180deg, #1f140e 0%, #0d0704 100%); border: 4px solid #8C0902; border-radius: 10px; position: absolute; top: 0; left: 0; z-index: 1; box-shadow: 0 0 30px #8C0902; }
        .overlay { position: absolute; top: 0; left: 0; width: 700px; height: 350px; background: rgba(13, 9, 7, 0.97); border: 4px solid #E6A341; border-radius: 10px; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 25px; box-sizing: border-box; }
        .box-titulo { color: #E6A341; font-size: 32px; margin-bottom: 12px; text-shadow: 0 0 10px #E6A341; font-family: 'Cinzel', serif; }
        .box-texto { color: #FFF; font-size: 20px; line-height: 1.6; margin-bottom: 15px; text-align: center; }
        .btn-game { padding: 8px 16px; font-family: 'VT323', monospace; font-size: 20px; font-weight: bold; background: #8C0902; color: #FFF; border: 2px solid #E6A341; border-radius: 6px; cursor: pointer; margin: 5px; transition: all 0.2s; width: 85%; }
        .btn-game:hover { background: #E6A341; color: #0d0907; box-shadow: 0 0 15px #E6A341; }
    </style>
</head>
<body>
    <h2>⚔️ FASE : Moldeador de Orografía</h2>
    
    <div class="contenedor-juego">
        <!-- Pantalla Inicial -->
        <div id="pantalla-inicio" class="overlay">
            <div class="box-titulo">🛡️ LA FUERZA DE CONDOY</div>
            <div class="box-texto">
                ¡Los invasores avanzan hacia las fronteras del territorio Mixe!<br><br>
                Responde correctamente los enigmas históricos para activar el poder cósmico del Rey Condoy. Luego, mantén presionado el mouse y arrástralo sobre el terreno inferior para levantar montañas empinadas y bloquear por completo su avance.
            </div>
            <button class="btn-game" style="width:auto;" onclick="iniciarOrografia()">ACTIVAR PODER</button>
        </div>

        <!-- Pantalla de Trivia Dinámica -->
        <div id="pantalla-trivia" class="overlay" style="display: none;">
            <div class="box-titulo">❔ RETO HISTÓRICO</div>
            <div class="box-texto" id="trivia-pregunta">Pregunta</div>
            <button class="btn-game" id="opc-0" onclick="evaluarOrografia(0)">Opción A</button>
            <button class="btn-game" id="opc-1" onclick="evaluarOrografia(1)">Opción B</button>
        </div>

        <!-- Pantalla Feedback -->
        <div id="pantalla-resultado" class="overlay" style="display: none;">
            <div class="box-titulo" id="res-titulo">ESTADO DE DEFENSA</div>
            <div class="box-texto" id="res-texto">Mensaje instructivo</div>
            <button class="btn-game" id="btn-accion" style="width:auto;" onclick="cerrarResultadoOrografia()">MANIPULAR TERRENO</button>
        </div>

        <canvas id="canvasOrografia" width="700" height="350"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasOrografia"), ctx = cvs.getContext("2d");
let poderActivado = false, juegoCorriendo = false, invasoresX = 700, presionando = false;
let puntosTerreno = Array(71).fill(280); 

// Banco expansivo con 4 preguntas sobre la mítica historia del pueblo Mixe
const bancoMixe = [
    { q: "¿Por qué es famoso el pueblo Mixe en la historia y los relatos antiguos de Oaxaca?", ops: ["Porque jamás fueron conquistados militarmente por imperios exteriores 👍", "Porque construyeron de forma única la ciudad de Monte Albán ❌"], correcta: 0 },
    { q: "¿Quién es el máximo rey mitológico protector de la herencia del pueblo Mixe?", ops: ["El Rey Condoy, un gigante guerrero de fuerza cósmica 👍", "El Rey Cosijoeza de los Valles Centrales ❌"], correcta: 0 },
    { q: "¿En qué majestuoso cerro de Oaxaca se dice que duerme y descansa el Rey Condoy?", ops: ["En la cumbre mística del cerro Zempoaltépetl 👍", "En el cerro del Fortín de la ciudad ❌"], correcta: 0 },
    { q: "¿Qué instrumento musical de viento identifica la gran tradición actual Mixe?", ops: ["Las bandas filarmónicas de música y metales de viento 👍", "Las marimbas de madera tropical ❌"], correcta: 0 }
];
let retoActual = {};

function cargarRetoMixe() {
    retoActual = bancoMixe[Math.floor(Math.random() * bancoMixe.length)];
    document.getElementById("trivia-pregunta").innerText = retoActual.q;
    document.getElementById("opc-0").innerText = retoActual.ops[0];
    document.getElementById("opc-1").innerText = retoActual.ops[1];
    document.getElementById("pantalla-trivia").style.display = "flex";
    juegoCorriendo = false;
}

cvs.onmousedown = () => { if(poderActivado && juegoCorriendo) presionando = true; };
cvs.onmouseup = () => { presionando = false; };
cvs.onmousemove = (e) => {
    if (!presionando || !juegoCorriendo) return;
    let rect = cvs.getBoundingClientRect(), mx = e.clientX - rect.left, my = e.clientY - rect.top;
    let indice = Math.floor(mx / 10);
    for (let i = indice - 3; i <= indice + 3; i++) {
        if (i >= 0 && i <= 70) {
            puntosTerreno[i] = Math.max(120, Math.min(280, my));
        }
    }
};

function iniciarOrografia() {
    document.getElementById("pantalla-inicio").style.display = "none";
    juegoCorriendo = true;
    loop();
    cargarRetoMixe();
}

function evaluarOrografia(opcion) {
    document.getElementById("pantalla-trivia").style.display = "none";
    const resTitulo = document.getElementById("res-titulo");
    const resTexto = document.getElementById("res-texto");

    if (opcion === retoActual.correcta) {
        poderActivado = true;
        resTitulo.innerText = "🏆 ¡FUERZA CÓSMICA ACTIVADA!";
        resTitulo.style.color = "#FECE79";
        resTexto.innerHTML = "¡Excelente respuesta! Has despertado la fuerza de Condoy. Al cerrar esta ventana, arrastra rápidamente el cursor por el suelo para levantar la Sierra Mixe y frenar el batallón.";
    } else {
        poderActivado = false;
        resTitulo.innerText = "🚨 ENERGÍA INSUFICIENTE";
        resTitulo.style.color = "#ff3333";
        resTexto.innerHTML = "¡Incorrecto! La falta de precisión teórica debilita tus muros. Los invasores avanzarán sin impedimentos geográficos.";
    }
    document.getElementById("pantalla-resultado").style.display = "flex";
}

function cerrarResultadoOrografia() {
    document.getElementById("pantalla-resultado").style.display = "none";
    juegoCorriendo = true;
}

function loop() {
    if (!juegoCorriendo) return;

    ctx.clearRect(0, 0, cvs.width, cvs.height);

    // 1. Dibujar el terreno deformado poligonalmente
    ctx.fillStyle = "#29160a";
    ctx.beginPath();
    ctx.moveTo(0, cvs.height);
    for (let i = 0; i <= 70; i++) { ctx.lineTo(i * 10, puntosTerreno[i]); }
    ctx.lineTo(cvs.width, cvs.height);
    ctx.fill();

    // Línea superior del suelo de color oro
    ctx.strokeStyle = "#E6A341"; ctx.lineWidth = 4;
    ctx.beginPath();
    ctx.moveTo(0, puntosTerreno[0]);
    for (let i = 1; i <= 70; i++) { ctx.lineTo(i * 10, puntosTerreno[i]); }
    ctx.stroke();

    // 2. Mover ejército invasor
    if (juegoCorriendo) invasoresX -= poderActivado ? 1.4 : 2.5; 
    let indiceInvasor = Math.floor(invasoresX / 10);
    let alturaInvasor = puntosTerreno[Math.max(0, Math.min(70, indiceInvasor))] || 280;

    // Dibujar el campamento enemigo de forma vectorial (Evita emojis)
    ctx.save();
    ctx.shadowBlur = 10; ctx.shadowColor = "#ff2211";
    ctx.fillStyle = "#ff2211";
    ctx.fillRect(invasoresX - 15, alturaInvasor - 25, 30, 25);
    // Bandera del batallón
    ctx.fillStyle = "#FFF"; ctx.fillRect(invasoresX + 5, alturaInvasor - 40, 2, 15);
    ctx.fillStyle = "#ff2211"; ctx.beginPath(); ctx.moveTo(invasoresX + 7, alturaInvasor - 40); ctx.lineTo(invasoresX + 18, alturaInvasor - 35); ctx.lineTo(invasoresX + 7, alturaInvasor - 30); ctx.fill();
    ctx.restore();
    
    ctx.fillStyle = "#FFF"; ctx.font = "bold 13px sans-serif"; ctx.fillText("EJÉRCITO", invasoresX - 25, alturaInvasor - 48);

    // Evaluar Derrota
    if (invasoresX <= 0) {
        juegoCorriendo = false;
        document.getElementById("res-titulo").innerText = "🎒 INVASIÓN EN FRONTERA";
        document.getElementById("res-titulo").style.color = "#ff3333";
        document.getElementById("res-texto").innerText = "¡Oh no! El ejército cruzó las cordilleras. Reinicia e intenta modelar elevaciones más drásticas para detenerlos.";
        document.getElementById("btn-accion").innerText = "REINICIAR BATALLA 🔄";
        document.getElementById("btn-accion").onclick = () => location.reload();
        document.getElementById("pantalla-resultado").style.display = "flex";
        return;
    }

    // Evaluar Victoria
    if (indiceInvasor > 1 && puntosTerreno[indiceInvasor - 1] < alturaInvasor - 15) {
        juegoCorriendo = false;
        document.getElementById("res-titulo").innerText = "🏆 ¡VICTORIA DE CONDOY!";
        document.getElementById("res-titulo").style.color = "#FECE79";
        document.getElementById("res-texto").innerHTML = "¡Excelente estrategia! Levantaste las montañas de la Sierra Mixe y bloqueaste por completo el camino de los invasores, defendiendo la libertad de las tierras.";
        document.getElementById("btn-accion").innerText = "VOLVER A MAPEAR 🔄";
document.getElementById("btn-accion").onclick = () => location.reload();
document.getElementById("pantalla-resultado").style.display = "flex";
return;
}
requestAnimationFrame(loop);
}

</script>
</body>
</html>
