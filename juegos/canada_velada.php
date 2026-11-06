<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ritual: Velada de Alianzas - Edición Retro Craft</title>
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cinzel:wght@700&family=VT323&display=swap" rel="stylesheet">
    
    <style>
        body { 
            background: #5c94fc; /* Azul Cielo Clásico de Super Mario Bros */
            color: #ffffff; 
            font-family: 'VT323', monospace; 
            font-size: 24px;
            text-align: center; 
            margin: 0; padding: 15px;
            overflow: hidden;
            user-select: none;
        }

        /* 🕹️ OVERLAY DE BIENVENIDA ESTILO MENU DE SELECCIÓN */
        .overlay-gamer {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: #000000;
            display: flex; justify-content: center; align-items: center;
            z-index: 9999;
            transition: all 0.4s ease;
        }

        .contenedor-instrucciones {
            background: #4c4c4c; /* Estilo bloque de piedra lisa / menú de inventario */
            border: 6px dashed #ffffff;
            box-shadow: 0 0 0 6px #4c4c4c, 0 15px 0 rgba(0,0,0,0.4);
            padding: 45px; border-radius: 4px; /* Bordes rectos estilo píxel */
            max-width: 850px; width: 95%; text-align: center;
            box-sizing: border-box;
        }

        .titulo-arcade {
            font-family: 'VT323', monospace;
            color: #ffcc00;
            text-shadow: 4px 4px 0px #000;
            font-size: 42px; margin-bottom: 12px;
        }

        .subtitulo-arcade { color: #5c94fc; font-size: 26px; margin-bottom: 35px; text-shadow: 2px 2px 0px #000; }

        .bloque-pasos {
            text-align: left;
            background: rgba(0, 0, 0, 0.4);
            padding: 25px; border-radius: 4px;
            border-left: 6px solid #ffcc00; margin-bottom: 35px;
        }

        .bloque-pasos h3 { color: #fcb444; font-size: 24px; margin-top: 0; margin-bottom: 15px; text-shadow: 2px 2px 0px #000; }
        .bloque-pasos li { margin-bottom: 15px; line-height: 1.6; font-size: 22px; color: #fff; list-style: none;}

        .btn-comenzar {
            background: #ffcc00; color: #000; border: 4px solid #ffffff;
            padding: 12px 40px; font-family: 'VT323', monospace;
            font-size: 26px; font-weight: bold; border-radius: 4px;
            cursor: pointer; box-shadow: 0 6px 0 #cc9900;
        }

        .btn-comenzar:hover { background: #ffffff; color: #ffcc00; border-color: #ffcc00; }
        .ocultar-pantalla { opacity: 0; transform: scale(1.1); pointer-events: none; }

        /* 🎮 INTERFAZ PRINCIPAL MULTICOLOR */
        .container { max-width: 1000px; margin: 0 auto; }
        h2 { 
            font-family: 'VT323', monospace;
            color: #ffffff; 
            text-shadow: 4px 4px 0px #000; 
            font-size: 40px; margin: 10px 0 15px 0;
            letter-spacing: 2px;
        }
        p { color: #fff; font-size: 24px; margin-bottom: 25px; text-shadow: 2px 2px 0px #000; }
        
        /* CANVAS CON FONDO AZUL SUBTERRÁNEO MÁGICO */
        canvas { 
            background: #181030; 
            border: 6px solid #ffffff; 
            border-radius: 4px; /* Aspecto pixel blocks */
            box-shadow: 0 15px 0 rgba(0,0,0,0.3);
            display: block; margin: 0 auto;
        }

        /* 🚨 FLASH DE DAÑO ROJO INTENSO */
        .glitch-flash { animation: flashRed 0.2s ease-out 2; }
        @keyframes flashRed {
            0%, 100% { background: #5c94fc; }
            50% { background: #b81414; }
        }

        /* 🏆 POPUPS MÍSTICOS ESTILO GAME OVER / LEVEL CLEAR */
        .game-notification {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.9); z-index: 10000;
            display: flex; justify-content: center; align-items: center;
            opacity: 0; pointer-events: none; transition: opacity 0.3s ease;
        }
        .game-notification.active { opacity: 1; pointer-events: auto; }
        .noti-box {
            background: #4c4c4c;
            padding: 40px; border-radius: 4px; max-width: 650px; width: 90%;
            text-align: center; border: 4px solid #fff;
        }
        .noti-box.success { border-color: #5c0; box-shadow: 0 0 25px #5c0; color: #5c0; }
        .noti-box.fail { border-color: #f33; box-shadow: 0 0 25px #f33; color: #f33; }
        .noti-box p { color: #fff; font-size: 24px; line-height: 1.6; margin: 25px 0; }
        
        .btn-noti {
            padding: 10px 30px; font-family: 'VT323', monospace; font-size: 24px;
            font-weight: bold; background: #000; color: #fff; border: 3px solid white;
            border-radius: 4px; cursor: pointer;
        }
    </style>
</head>
<body>

<!-- 🕹️ PANTALLA DE INICIO -->
<div id="pantalla-inicio" class="overlay-gamer">
    <div class="contenedor-instrucciones">
        <h1 class="titulo-arcade">🧱 RITUAL: Velada Retro Craft</h1>
        <h2 class="subtitulo-arcade">¡Hola, Aventurero <?php echo htmlspecialchars($nombre); ?>!</h2>
        
        <div class="bloque-pasos">
            <h3>🎮 REGLAS DE LA ARENA:</h3>
            <ul>
                <li><span style="color:#ffcc00">🌟 FASE 1:</span> Une los ítems tradicionales arrastrando el cursor: <span style="color:#5c94fc">VELAS 🕯️</span> ➡️ <span style="color:#ff00ff">CACAO 🫘</span> ➡️ <span style="color:#fcb444">AGUARDIENTE 🍾</span>.</li>
                <li><span style="color:#ffcc00">🔥 FASE 2:</span> ¡Los bloques flotarán! Mueve tu **Orbe de Diamante 💎** con el mouse para recolectar los 3 fragmentos sagrados antes de que se desvanezcan.</li>
                <li><span style="color:#ff3366; font-weight:bold;">💣 PELIGRO TNT:</span> ¡Evita a toda costa los **Bloques de Celular TNT 📱**! Si chocas contra sus ondas expansivas rojas, perderás de inmediato.</li>
            </ul>
        </div>
        <button id="btn-comenzar" class="btn-comenzar">¡SPOWN JUEGO!</button>
    </div>
</div>

<!-- 🏆 POPUPS DE CONTROL -->
<div id="popup-juego" class="game-notification">
    <div id="popup-contenido" class="noti-box">
        <h2 id="popup-titulo" style="font-size: 32px; margin: 0; text-shadow: 2px 2px #000;"></h2>
        <p id="popup-mensaje"></p>
        <button class="btn-noti" onclick="cerrarNotificacion()">CONTINUAR</button>
    </div>
</div>

<div class="container">
    <h2>🧱 RITUAL: Velada de Alianzas (Edición Color Block)</h2>
    <p id="instruccionesFase">Fase 1: Conecta los elementos arrastrando el mouse: <span style="color:#ffcc00">VELAS ➡️ CACAO ➡️ AGUARDIENTE</span></p>
    
    <canvas id="canvasVelada" width="850" height="500"></canvas>
</div>

<script>
const cvs = document.getElementById("canvasVelada"), ctx = cvs.getContext("2d");
let trazando = false, puntosRuta = [], pasoActual = 0;
let faseJuego = 1; 
let fragmentosRecolectados = 0;

// Configuración de Bloques/Altares (Formatos Cuadrados y Bloques Estilo Minecraft/Mario)
const altares = [
    { x: 150, y: 250, r: 55, txt: "Velas 🕯️", id: 0, color: "#fcb444" },
    { x: 425, y: 130, r: 55, txt: "Cacao 🫘", id: 1, color: "#ff77a8" },
    { x: 700, y: 250, r: 55, txt: "Aguardiente 🍾", id: 2, color: "#5c94fc" },
    { x: 425, y: 380, r: 50, txt: "📱 TNT", id: 99, color: "#ff3333" }
];

let orbeJugador = { x: 425, y: 250, r: 16, color: "#00ffff" }; // Orbe de Diamante Celeste
let fragmentosEspirituales = [];
let enemigosCelulares = [];

// Bloques de nubes decorativas estilo plataformas de juego
let particulas = [];
for (let i = 0; i < 20; i++) {
    particulas.push({ x: Math.random() * cvs.width, y: Math.random() * cvs.height, w: Math.random() * 40 + 20, h: 10, speed: Math.random() * 0.3 + 0.1 });
}

document.getElementById('btn-comenzar').addEventListener('click', function() {
    document.getElementById('pantalla-inicio').classList.add('ocultar-pantalla');
});

function lanzarNotificacion(titulo, mensaje, tipo) {
    const popup = document.getElementById('popup-juego');
    const contenido = document.getElementById('popup-contenido');
    document.getElementById('popup-titulo').innerText = titulo;
    document.getElementById('popup-mensaje').innerText = mensaje;
    contenido.className = "noti-box " + (tipo === 'success' ? 'success' : 'fail');
    popup.classList.add('active');
}

function cerrarNotificacion() {
    document.getElementById('popup-juego').classList.remove('active');
    if (faseJuego === 2 && fragmentosRecolectados === 0) {
        puntosRuta = [];
    } else {
        reiniciarJuegoTotal();
    }
}

function reiniciarJuegoTotal() {
    trazando = false; puntosRuta = []; pasoActual = 0; faseJuego = 1;
    fragmentosRecolectados = 0; fragmentosEspirituales = []; enemigosCelulares = [];
    document.getElementById("instruccionesFase").innerHTML = 'Fase 1: Conecta los elementos arrastrando el mouse: <span style="color:#ffcc00">VELAS ➡️ CACAO ➡️ AGUARDIENTE</span>';
}

function iniciarFaseArcade() {
    faseJuego = 2;
    fragmentosRecolectados = 0;
    document.getElementById("instruccionesFase").innerHTML = '🔥 <span style="color:#ffcc00">¡FASE DE ACCIÓN!</span> Absorbe los bloques flotantes y mantente lejos de los celulares TNT.';

    altares.forEach(a => {
        if (a.id !== 99) {
            fragmentosEspirituales.push({
                x: a.x, y: a.y, r: 28, txt: a.txt, color: a.color,
                vX: (Math.random() * 2 + 1.5) * (Math.random() > 0.5 ? 1 : -1),
                vY: (Math.random() * 2 + 1.5) * (Math.random() > 0.5 ? 1 : -1)
            });
        }
    });

    for (let i = 0; i < 2; i++) {
        enemigosCelulares.push({
x: 425, y: 380 + (i * 20), r: 26, txt: "📱 TNT", color: "#ff3333",
vX: (Math.random() * 3 + 2) * (Math.random() > 0.5 ? 1 : -1),
vY: (Math.random() * 3 + 2) * (Math.random() > 0.5 ? 1 : -1)
});
}
}
cvs.onmousedown = (e) => {
if (faseJuego !== 1) return;
let rect = cvs.getBoundingClientRect(), mx = e.clientX - rect.left, my = e.clientY - rect.top;
if (Math.hypot(mx - altares[0].x, my - altares[0].y) < altares[0].r && pasoActual === 0) {
trazando = true; puntosRuta = [{x: mx, y: my}];
}
};
cvs.onmousemove = (e) => {
let rect = cvs.getBoundingClientRect(), mx = e.clientX - rect.left, my = e.clientY - rect.top;
if (faseJuego === 1) {
if (!trazando) return;
puntosRuta.push({x: mx, y: my});
altares.forEach(a => {
if (Math.hypot(mx - a.x, my - a.y) < a.r) {
if (a.id === 99) {
document.body.classList.add('glitch-flash');
setTimeout(() => document.body.classList.remove('glitch-flash'), 500);
lanzarNotificacion("💣 ¡BOOM! DETONADO 💣", "Chocaste con el Bloque Celular Corrupto. ¡El rezo fue saboteado!", "fail");
} else if (a.id === 1 && pasoActual === 0) {
pasoActual = 1;
} else if (a.id === 2 && pasoActual === 1) {
trazando = false;
lanzarNotificacion("🌟 ¡STAGE CLEAR! 🌟", "¡Conexiones hechas! Prepárate para el modo recolección a toda velocidad.", "success");
iniciarFaseArcade();
}
}
});
} else if (faseJuego === 2) {
orbeJugador.x = mx; orbeJugador.y = my;
}
};
cvs.onmouseup = () => { if (faseJuego === 1) { trazando = false; if(pasoActual < 2) puntosRuta = []; } };
// Dibuja cuadros con bordes pixelados en lugar de círculos lisos aburridos
function dibujarBloquePixel(x, y, r, color, txt, esMalo = false) {
ctx.save();
let size = r * 2;
// Sombra de bloque 2D sólida clásica de Mario/Minecraft
ctx.fillStyle = "rgba(0,0,0,0.3)";
ctx.fillRect(x - r + 6, y - r + 6, size, size);
// Bloque principal
ctx.fillStyle = color;
ctx.fillRect(x - r, y - r, size, size);
// Bordes internos de relieve pixelado
ctx.strokeStyle = esMalo ? "#7a0000" : "#ffffff";
ctx.lineWidth = 4;
ctx.strokeRect(x - r + 2, y - r + 2, size - 4, size - 4);
ctx.restore();
ctx.fillStyle = "#ffffff"; ctx.font = "20px 'VT323'"; ctx.textAlign = "center";
ctx.fillText(txt, x, y + 6);
}
function dibujar() {
ctx.clearRect(0, 0, cvs.width, cvs.height);
// Renderizado de plataformas/bloques nubes flotantes de fondo
particulas.forEach(p => {
p.x -= p.speed; if (p.x < -p.w) p.x = cvs.width;
ctx.fillStyle = "rgba(255, 255, 255, 0.04)";
ctx.fillRect(p.x, p.y, p.w, p.h);
});
if (faseJuego === 1) {
// --- MODO FASE 1: CONEXIÓN EN BLOQUES ---
altares.forEach(a => {
dibujarBloquePixel(a.x, a.y, a.r, a.color, a.txt, a.id === 99);
});
// Hilo de energía láser de Diamante
if (puntosRuta.length > 1) {
ctx.save();
ctx.strokeStyle = "#00ffff"; ctx.lineWidth = 6; ctx.lineCap = "square";
ctx.beginPath(); ctx.moveTo(puntosRuta[0].x, puntosRuta[0].y);
for (let i = 1; i < puntosRuta.length; i++) { ctx.lineTo(puntosRuta[i].x, puntosRuta[i].y); }
ctx.stroke();
ctx.restore();
}
} else if (faseJuego === 2) {
// --- MODO FASE 2: ACCIÓN ARCADE ---
fragmentosEspirituales.forEach((f, index) => {
f.x += f.vX; f.y += f.vY;
if (f.x - f.r < 0 || f.x + f.r > cvs.width) f.vX *= -1;
if (f.y - f.r < 0 || f.y + f.r > cvs.height) f.vY *= -1;
dibujarBloquePixel(f.x, f.y, f.r, f.color, f.txt.split(" ")[1]);
if (Math.hypot(orbeJugador.x - f.x, orbeJugador.y - f.y) < orbeJugador.r + f.r) {
fragmentosEspirituales.splice(index, 1);
fragmentosRecolectados++;
if (fragmentosRecolectados === 3) {
lanzarNotificacion("👑 ¡VICTORIA TOTAL! 👑", "¡Nivel Superado! Conseguiste todos los bloques de la alianza sin detonar las amenazas.", "success");
}
}
});
enemigosCelulares.forEach(e => {
e.x += e.vX; e.y += e.vY;
if (e.x - e.r < 0 || e.x + e.r > cvs.width) e.vX *= -1;
if (e.y - e.r < 0 || e.y + e.r > cvs.height) e.vY *= -1;
// Bloque de celular enemigo parpadea en rojo/negro simulando TNT a punto de estallar
let tntColor = (Math.floor(Date.now() / 200) % 2 === 0) ? "#ff3333" : "#000000";
dibujarBloquePixel(e.x, e.y, e.r, tntColor, "💥 TNT", true);
if (Math.hypot(orbeJugador.x - e.x, orbeJugador.y - e.y) < orbeJugador.r + e.r) {
document.body.classList.add('glitch-flash');
setTimeout(() => document.body.classList.remove('glitch-flash'), 500);
lanzarNotificacion("💥 ¡GAME OVER! 💥", "¡El Bloque TNT explotó cerca de ti! Reajusta tus reflejos tácticos.", "fail");
}
});
// Orbe Cuadrado de Diamante del Jugador
ctx.save();
ctx.fillStyle = orbeJugador.color;
ctx.fillRect(orbeJugador.x - orbeJugador.r, orbeJugador.y - orbeJugador.r, orbeJugador.r * 2, orbeJugador.r * 2);
ctx.strokeStyle = "#ffffff"; ctx.lineWidth = 2;
ctx.strokeRect(orbeJugador.x - orbeJugador.r, orbeJugador.y - orbeJugador.r, orbeJugador.r * 2, orbeJugador.r * 2);
ctx.restore();
ctx.fillStyle = "#ffffff"; ctx.font = "28px 'VT323'"; ctx.textAlign = "left";
ctx.fillText("BLOQUES RECOLECTADOS: " + fragmentosRecolectados + "/3", 30, 45);
}
requestAnimationFrame(dibujar);
}
dibujar();
</script>
</body>
</html>
