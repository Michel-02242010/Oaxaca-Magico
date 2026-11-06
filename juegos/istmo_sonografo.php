<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Sonógrafo del Viento - El Istmo</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { background: #050508; color: #8da296; font-family: 'VT323', monospace; font-size: 24px; text-align: center; margin: 0; padding: 20px; overflow: hidden; }
        h2 { font-family: 'Cinzel', serif; color: #39e68d; text-shadow: 0 0 15px rgba(57,230,141,0.4); font-size: 26px; margin-bottom: 5px; }
        .contenedor-juego { position: relative; width: 650px; height: 350px; margin: 15px auto; }
        canvas { background: #000; border: 4px solid #1a3326; border-radius: 12px; position: absolute; top: 0; left: 0; z-index: 1; box-shadow: 0 0 35px rgba(26,51,38,0.5); }
        .overlay { position: absolute; top: 0; left: 0; width: 650px; height: 350px; background: rgba(5, 5, 8, 0.97); border: 4px solid #39e68d; border-radius: 12px; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; }
        .box-titulo { color: #39e68d; font-size: 28px; margin-bottom: 12px; text-shadow: 0 0 10px #39e68d; font-family: 'Cinzel', serif; }
        .box-texto { color: #FFF; font-size: 20px; line-height: 1.6; margin-bottom: 15px; text-align: center; }
        .btn-game { padding: 8px 16px; font-family: 'VT323', monospace; font-size: 20px; font-weight: bold; background: #111; color: #39e68d; border: 2px solid #39e68d; border-radius: 6px; cursor: pointer; margin: 5px; transition: all 0.2s; width: 85%; }
        .btn-game:hover { background: #39e68d; color: #050508; box-shadow: 0 0 15px #39e68d; }
    </style>
</head>
<body>
    <h2>💧 JUEGO: Sonógrafo del Viento</h2>
    
    <div class="contenedor-juego">
        <!-- Pantalla Inicial -->
        <div id="pantalla-inicio" class="overlay">
            <div class="box-titulo">📜 ECO ESPECTRAL</div>
            <div class="box-texto">
                ¡Hola, <?= htmlspecialchars($nombre) ?>!<br><br>
                El paraje nocturno del Istmo se encuentra en oscuridad absoluta. Lee la pregunta del cuestionario y selecciona la opción correcta para emitir una onda sónica mística que revelará los secretos del mapa.
            </div>
            <button class="btn-game" style="width:auto;" onclick="iniciarSonógrafo()">DESPERTAR ECO</button>
        </div>

        <!-- Pantalla de Trivia Dinámica -->
        <div id="pantalla-trivia" class="overlay" style="display: none;">
            <div class="box-titulo">❓ ENIGMA ZAPOTECA</div>
            <div class="box-texto" id="trivia-pregunta">Pregunta</div>
            <button class="btn-game" id="opc-0" onclick="evaluarSonógrafo(0)">Opción A</button>
            <button class="btn-game" id="opc-1" onclick="evaluarSonógrafo(1)">Opción B</button>
        </div>

        <!-- Pantalla Feedback -->
        <div id="pantalla-resultado" class="overlay" style="display: none;">
            <div class="box-titulo" id="res-titulo">REVELACIÓN</div>
            <div class="box-texto" id="res-texto">Mensaje informativo.</div>
            <button class="btn-game" style="width:auto;" onclick="proximoLamento()">SIGUIENTE ENIGMA</button>
        </div>

        <canvas id="canvasSonografo" width="650" height="350"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasSonografo"), ctx = cvs.getContext("2d");
let pulsoActivo = false, pulsoRadio = 0, juegoCorriendo = false;
let palmeras = [{x: 120, y: 150, r: 30}, {x: 520, y: 220, r: 40}, {x: 320, y: 100, r: 25}];

// Banco expansivo con 4 preguntas sobre la Llorona y tradiciones del Istmo
const bancoSonografo = [
    { q: "¿Por qué deambula y llora la Llorona del Istmo según la tradición zapoteca?", ops: ["Por el amor perdido de su guerrero que no regresó de la batalla 👍", "Por culpa tras ahogar a sus hijos en el río ❌"], correcta: 0 },
    { q: "¿En qué idioma se cantan originalmente los sones tradicionales del Istmo?", ops: ["En lengua Zapoteca (Diidxazá) 👍", "En Náhuatl clásico del centro ❌"], correcta: 0 },
    { q: "¿Qué significado cultural tienen las velas en las festividades del Istmo?", ops: ["Alianzas familiares y mayordomías religiosas del pueblo 👍", "Simples adornos de iluminación para los bailes de noche ❌"], correcta: 0 },
    { q: "¿Cómo es el carácter de la mujer tehuana descrito en las narraciones locales?", ops: ["Líder, comerciante activa y pilar de la economía comunitaria 👍", "Sumisa y apartada de las decisiones importantes del pueblo ❌"], correcta: 0 }
];
let retoActual = {};

function cargarPreguntaSonografo() {
    retoActual = bancoSonografo[Math.floor(Math.random() * bancoSonografo.length)];
    document.getElementById("trivia-pregunta").innerText = retoActual.q;
    document.getElementById("opc-0").innerText = "A) " + retoActual.ops[0];
    document.getElementById("opc-1").innerText = "B) " + retoActual.ops[1];
    document.getElementById("pantalla-trivia").style.display = "flex";
}

function iniciarSonógrafo() {
    document.getElementById("pantalla-inicio").style.display = "none";
    juegoCorriendo = true;
    render();
    cargarPreguntaSonografo();
}

function evaluarSonógrafo(opcionSeleccionada) {
    document.getElementById("pantalla-trivia").style.display = "none";
    const resTitulo = document.getElementById("res-titulo");
    const resTexto = document.getElementById("res-texto");

    if (opcionSeleccionada === retoActual.correcta) {
        pulsoActivo = true; pulsoRadio = 0;
        resTitulo.innerText = "🏆 ECO ULTRASONÓNICO ACTIVADO";
        resTitulo.style.color = "#39e68d";
        resTexto.innerHTML = "¡Respuesta correcta! El lamento romántico y poético zapoteca se funde con el viento, liberando una onda de energía que revela el mapa secreto.";
    } else {
        resTitulo.innerText = "❌ DISCORDIAL / PENUMBRA TOTAL";
        resTitulo.style.color = "#ff3333";
        resTexto.innerHTML = "¡Incorrecto! Esa versión pertenece al centro del país. El relato istmeño es una elegía de amor y herencia prehispánica.";
    }
    document.getElementById("pantalla-resultado").style.display = "flex";
}

function proximoLamento() {
    document.getElementById("pantalla-resultado").style.display = "none";
    cargarPreguntaSonografo();
}

function render() {
    ctx.fillStyle = "#000"; ctx.fillRect(0, 0, cvs.width, cvs.height);
    
    if (pulsoActivo) {
        ctx.save();
        ctx.beginPath(); ctx.arc(325, 175, pulsoRadio, 0, Math.PI * 2); ctx.clip(); // Máscara circular
        
        ctx.fillStyle = "#0a1a11"; ctx.fillRect(0, 0, cvs.width, cvs.height);
        
        // Dibujado de vegetación vectorial iluminada
        ctx.save();
        ctx.shadowBlur = 15; ctx.shadowColor = "#39e68d";
        ctx.fillStyle = "#39e68d";
        palmeras.forEach(p => {
            ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2); ctx.fill();
        });
        ctx.restore();
        ctx.restore();
        
        if (pulsoRadio < 450) {
            pulsoRadio += 8;
            requestAnimationFrame(render);
        } else {
            pulsoActivo = false;
            setTimeout(render, 1000);
        }
    } else {
        // Renderizado vectorial de los ojos encendidos del espíritu en la oscuridad (Evita emojis)
        ctx.save();
        ctx.shadowBlur = 10; ctx.shadowColor = "#ff3333";
        ctx.fillStyle = "#ff3333"; 
        ctx.fillRect(310, 170, 8, 4); 
        ctx.fillRect(332, 170, 8, 4);
        ctx.restore();
    }
}
</script>
</body>
</html>
