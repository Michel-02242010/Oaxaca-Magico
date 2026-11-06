<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>El Resplandor del Charro Negro - Pro Edition</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        @keyframes neoflicker {
            0%, 18%, 22%, 25%, 53%, 57%, 100% { text-shadow: 0 0 10px #ff007f, 0 0 20px #ff0055, 0 0 40px #ff00ff; }
            20%, 24%, 55% { text-shadow: none; }
        }
        body { 
            background: #010103; 
            color: #00ffff; 
            font-family: 'Press Start 2P', sans-serif; 
            font-size: 11px; 
            text-align: center; 
            margin: 0; padding: 10px; 
            background-image: radial-gradient(circle at center, #070412 0%, #000000 100%); 
            display: flex; flex-direction: column; align-items: center; justify-content: center; 
            height: 100vh; overflow: hidden; 
        }
        h2 { 
            color: #ff007f; 
            animation: neoflicker 3s infinite alternate;
            font-size: 22px; 
            margin: 0 0 15px 0; 
            letter-spacing: 3px;
        }
        .contenedor-juego { 
            position: relative; 
            width: 1000px; 
            height: 550px; 
        }
        canvas { 
            background: #030308; 
            border: 4px solid #ff007f; 
            border-radius: 16px; 
            cursor: none; 
            box-shadow: 0 0 35px rgba(255, 0, 127, 0.4); 
            position: absolute; top: 0; left: 0; z-index: 1; 
        }
        .overlay { 
            position: absolute; top: 0; left: 0; 
            width: 1000px; height: 550px; 
            background: rgba(3, 2, 10, 0.96); 
            border: 4px solid #00ffff; 
            border-radius: 16px; 
            z-index: 10; 
            display: flex; flex-direction: column; align-items: center; justify-content: center; 
            padding: 40px; box-sizing: border-box;
            box-shadow: 0 0 35px rgba(0, 255, 255, 0.3), inset 0 0 35px rgba(0,0,0,0.9);
        }

.tit-xl { 
    color: #ffe600; 
    font-family: 'Press Start 2P', sans-serif; /* <-- Añade esta línea */
    font-size: 18px; 
    margin-bottom: 25px; 
    text-shadow: 0 0 12px #ffe600; 
}
.txt-lg { 
    color: #FFF; 
    font-family: 'Press Start 2P', sans-serif;
    font-size: 11px; 
    line-height: 2; 
    max-width: 850px; 
    margin-bottom: 30px; 
}

.btn-ans { 
    width: 85%; 
    border-color: #00ffff; 
    color: #00ffff; 
    font-size: 9px;
    line-height: 1.6;
    box-shadow: 0 5px 0 #0088cc;
    text-align: left;
    padding: 18px 24px;
}
.btn-game { 
            padding: 16px 28px; 
            font-family: 'Press Start 2P', sans-serif; 
            font-size: 11px; 
            font-weight: bold; 
            background: #000; color: #00ff66; 
            border: 3px solid #00ff66; border-radius: 8px; 
            cursor: pointer; margin: 10px; 
            box-shadow: 0 5px 0 #00aa44;
            transition: all 0.1s ease; 
        }
        .btn-game:hover { 
            background: #00ff66; color: #000; 
            box-shadow: 0 0 25px #00ff66; 
            transform: translateY(-2px); 
        }
        .btn-ans:hover { 
            background: #00ffff; color: #000; 
            box-shadow: 0 0 25px #00ffff; 
        }
    </style>
</head>
<body>
    <h2>⛰️ EL RESPLANDOR DEL CHARRO NEGRO</h2>
    <div class="contenedor-juego">
        
        <!-- PANTALLA INICIAL -->
        <div id="p-inicio" class="overlay">
            <p class="tit-xl" style="color:#ff3c00; text-shadow:0 0 10px #ff3c00;">📜 INSTRUCCIONES DE MISIÓN</p>
            <p class="txt-lg">¡Hola, <?= htmlspecialchars($nombre) ?>!<br><br>Mueve tu cursor místico para alumbrar la penumbra del cerro Tokosho 🔦.<br><br><strong>⚠️ ¡ALERTA!</strong> Evita que tu luz toque a los <strong>Monstruos del Cerro (Fuegos Fatuos y Calaveras)</strong> o causarán interferencia de terror.<br><br>Encuentra los Hongos Sagrados ocultos para activar las preguntas rituales.</p>
            <button class="btn-game" onclick="iniciar(1)">INICIAR RECOLECCIÓN 🕹️</button>
        </div>

        <!-- TRIVIA -->
        <div id="p-trivia" class="overlay" style="display: none; border-color: #ffaa00; box-shadow: 0 0 35px rgba(255, 170, 0, 0.4);">
            <p class="tit-xl" style="color: #ffaa00; text-shadow: 0 0 15px #ffaa00;">PREGUNTA DEL CHIKÓN</p>
            <p class="txt-lg" id="q-txt" style="color: #FFF; font-weight: bold;"></p>
            <button class="btn-game btn-ans" onclick="evaluar(0)" id="opc-0"></button>
            <button class="btn-game btn-ans" onclick="evaluar(1)" id="opc-1"></button>
        </div>

        <!-- FEEDBACK RESULTADO -->
        <div id="p-res" class="overlay" style="display: none;">
            <p class="tit-xl" id="res-t" style="font-size: 22px;"></p>
            <p class="txt-lg" id="res-x"></p>
            <button class="btn-game" onclick="iniciar(2)">CONTINUAR EXPEDICIÓN 🔄</button>
        </div>

        <canvas id="canvasChikon" width="1000" height="550"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasChikon"), ctx = cvs.getContext("2d");
let mx=500, my=275, hx, hy, encontrado=false, corriendo=false, pts=0, qAct={};
let asustadoEfecto = 0;

// Configuración de Monstruos del Cerro
const monstruos = [
    { x: 200, y: 150, vx: 3, vy: 2, icon: "💀", size: 30 },
    { x: 700, y: 400, vx: -2, vy: 3, icon: "👻", size: 30 },
    { x: 500, y: 100, vx: 4, vy: -2, icon: "🔥", size: 25 }
];

const banco = [
    { q: "¿Qué debes hacer antes de recolectar plantas sagradas o sembrar café?", ops: ["Pedir permiso y dejar ofrendas al Chikón ", "Entrar corriendo sin avisar "], c: 0 },
    { q: "¿Qué ofrendas tradicionales prefiere el Chikón?", ops: ["Monedas modernas y aparatos de plástico ", "Cacao, aguardiente y velas de cera "], c: 1 },
    { q: "¿Qué le ocurre a la sombra de los que le faltan al respeto al cerro?", ops: ["El Chikón la atrapa causando enfermedad de espanto ", "Su sombra se duplica haciéndolos fuertes "], c: 0 },
    { q: "¿Cuál es el nombre del cerro sagrado donde habita el guardián?", ops: ["Cerro de la Calenda ", "Cerro Tokosho "], c: 1 },
    { q: "¿Bajo qué forma elegante se manifiesta el Chikón en la noche?", ops: ["Como un Charro Negro montado a caballo ", "Como un águila gigante dorada "], c: 0 },
    { q: "¿Qué beneficio otorgan los hongos recolectados con respeto?", ops: ["Sanar enfermedades a las personas de la comunidad ", "Dar superpoderes físicos de velocidad "], c: 0 },
    { q: "¿Qué elemento usan los chamanes de la Sierra para limpiar el espanto?", ops: ["Aparatos de sonido modernos ", "Ramas de plantas fuertes y copal sagrado "], c: 1 },
    { q: "¿Por qué el Charro Negro cuida celosamente los recursos del cerro?", ops: ["Para proteger la naturaleza y la vida del paraje ", "Porque quiere ocultar un tesoro pirata "], c: 0 },
    { q: "¿A qué región de Oaxaca pertenece el místico cerro Tokosho?", ops: ["A la región de la Sierra Sur ", "A los Valles Centrales "], c: 0 },
    { q: "¿Qué valor nos enseña esta antigua leyenda oaxaqueña?", ops: ["El valor del respeto a la tierra y a los abuelos ", "Que debemos destruir los bosques"], c: 0 }
];


cvs.onmousemove = (e) => { 
    let r=cvs.getBoundingClientRect(); 
    mx=e.clientX-r.left; 
    my=e.clientY-r.top; 
};

function iniciar(modo) {
    document.getElementById(modo===1 ? "p-inicio" : "p-res").style.display = "none";
    hx = Math.random()*800+100; 
    hy = Math.random()*350+100; 
    encontrado = false; corriendo = true;
    if(modo===1) requestAnimationFrame(loop);
}

function evaluar(opc) {
    document.getElementById("p-trivia").style.display = "none";
    const t=document.getElementById("res-t"), x=document.getElementById("res-x");
    if (opc === qAct.c) { 
        pts+=20; 
        t.innerText="🏆 TRIBUTO ACEPTADO"; t.style.color="#00ff66"; t.style.textShadow="0 0 10px #00ff66";
        x.innerText="¡Excelente! Respetas las costumbres del cerro Tokosho. +20 PTS."; 
    } else { 
        pts = Math.max(0, pts - 10);
        t.innerText="🚨 ADVERTENCIA"; t.style.color="#ff3c00"; t.style.textShadow="0 0 10px #ff3c00";
        x.innerText="¡Incorrecto! Olvidar los rituales ofende a los guardianes del cerro. Perdiste -10 PTS."; 
    }
    document.getElementById("p-res").style.display = "flex";
}

function loop() {
    // Si ha tocado un monstruo, el fondo parpadea en rojo sangre
    if (asustadoEfecto > 0) {
        ctx.fillStyle = `rgba(255, 0, 50, ${asustadoEfecto * 0.15})`;
        ctx.fillRect(0, 0, cvs.width, cvs.height);
        asustadoEfecto--;
    } else {
        ctx.clearRect(0, 0, cvs.width, cvs.height);
    }

    if (corriendo) {
        // Actualizar y rebotar monstruos por los bordes
        monstruos.forEach(m => {
            m.x += m.vx; m.y += m.vy;
            if (m.x < 50 || m.x > cvs.width - 50) m.vx *= -1;
            if (m.y < 50 || m.y > cvs.height - 50) m.vy *= -1;
        });

        ctx.save();
        // Definición de la Linterna del Jugador
        let g = ctx.createRadialGradient(mx, my, 10, mx, my, 120);
        g.addColorStop(0, "rgba(0,255,255,1)"); 
        g.addColorStop(0.5, "rgba(0,100,255,0.4)"); 
        g.addColorStop(1, "rgba(0,0,0,0)");
        ctx.fillStyle = g; ctx.beginPath(); ctx.arc(mx, my, 120, 0, Math.PI*2); ctx.fill(); ctx.clip();
        
        // --- DIBUJAR ENTORNO OCULTO (Dentro de la Luz) ---
        
        // 🍄 Dibujar Hongo Místico Estilizado
        ctx.save();
ctx.globalAlpha = 0.15; // <-- PEGA ESTA LÍNEA AQUÍ
ctx.shadowBlur = 15; ctx.shadowColor = "#ff0055";
ctx.fillStyle = "#ff0055"; ctx.font = "32px sans-serif";
        ctx.fillText("🍄", hx - 16, hy + 12);
        ctx.restore();

        // 👹 Dibujar Monstruos si entran en el rango de visión de la luz
        monstruos.forEach(m => {
            ctx.font = `${m.size}px sans-serif`;
            ctx.fillText(m.icon, m.x - 15, m.y + 10);

            // DETECCIÓN: Si la luz toca al monstruo, causa interferencia/susto
            let distMonstruo = Math.hypot(mx - m.x, my - m.y);
            if (distMonstruo < 110 && asustadoEfecto === 0) {
                asustadoEfecto = 8; // Activa parpadeo rojo
            }
        });

        ctx.restore();
        
        // COMPROBACIÓN: Si encuentras el hongo curativo
        if (!encontrado && Math.hypot(mx - hx, my - hy) < 35) {
            encontrado = true; corriendo = false;
            qAct = banco[Math.floor(Math.random()*banco.length)];
            document.getElementById("q-txt").innerText = qAct.q;
            document.getElementById("opc-0").innerText = "A) " + qAct.ops[0];
            document.getElementById("opc-1").innerText = "B) " + qAct.ops[1];
    document.getElementById("p-trivia").style.display = "flex";
}
}
// Dibujar Cursór Óptico Neón del Jugador
ctx.save();
ctx.shadowBlur = 25; ctx.shadowColor = "#00ffff";
ctx.fillStyle = "#00ffff"; ctx.beginPath(); ctx.arc(mx, my, 6, 0, Math.PI*2); ctx.fill();
ctx.restore();
// Marcador HUD Superior
ctx.fillStyle = "#00ffff";
ctx.font = "12px 'Press Start 2P'";
ctx.fillText("SCORE: " + pts + " PTS", 35, 45);
requestAnimationFrame(loop);
}
</script>
</body>
</html>
