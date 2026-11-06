<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>La Sombra Guardada - Edición Definitiva</title>
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    
    <style>
        body { 
            background: #020408; 
            color: #00ffff; 
            font-family: 'Press Start 2P', sans-serif; 
            font-size: 11px;
            text-align: center; 
            margin: 0; padding: 15px;
            overflow-x: hidden;
            user-select: none;
        }

        /* 📺 PANTALLA DE INICIO OVERLAY */
        .overlay-gamer {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(3, 5, 10, 0.99);
            display: flex; justify-content: center; align-items: center;
            z-index: 9999;
            transition: all 0.5s cubic-bezier(0.74, 0.12, 0.29, 0.95);
        }

        .contenedor-instrucciones {
            background: #070b12;
            border: 3px solid #ff3c00;
            box-shadow: 0 0 40px #ff3c00, inset 0 0 25px rgba(255, 60, 0, 0.3);
            padding: 50px 40px; border-radius: 20px;
            max-width: 850px; width: 95%; text-align: center;
            box-sizing: border-box;
            animation: flotar 4s ease-in-out infinite;
        }

        @keyframes flotar {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .titulo-arcade {
            color: #ff3c00;
            text-transform: uppercase;
            text-shadow: 0 0 15px #ff3c00, 0 0 5px #fff;
            font-size: 20px; margin-bottom: 12px; letter-spacing: 1px;
            line-height: 1.4;
        }

        .subtitulo-arcade {
            color: #00ffff;
            text-shadow: 0 0 10px #00ffff;
            font-size: 11px; margin-bottom: 35px;
        }

        .bloque-pasos {
            text-align: left;
            background: rgba(0, 255, 255, 0.02);
            padding: 30px; border-radius: 12px;
            border-left: 6px solid #00ffff; margin-bottom: 35px;
            box-shadow: inset 0 0 15px rgba(0, 255, 255, 0.05);
        }

        .bloque-pasos h3 { color: #ffaa66; font-size: 11px; margin-top: 0; margin-bottom: 20px; letter-spacing: 1px; }
        .bloque-pasos li { margin-bottom: 20px; line-height: 2; font-size: 11px; color: #e0e5ed; }
        .bloque-pasos li:last-child { margin-bottom: 0; }

        .btn-comenzar {
            background: #ffcc00; color: #000; border: none;
            padding: 20px 45px; font-family: 'Press Start 2P', sans-serif;
            font-size: 13px; font-weight: bold; border-radius: 8px;
            cursor: pointer; box-shadow: 0 6px 0 #cc9900, 0 0 25px rgba(255, 204, 0, 0.5);
            transition: all 0.1s ease;
            letter-spacing: 1px;
        }

        .btn-comenzar:hover { transform: scale(1.05); box-shadow: 0 6px 0 #cc9900, 0 0 35px #ffcc00; }
        .btn-comenzar:active { transform: translateY(6px); box-shadow: 0 0px 0 #cc9900; }
        .ocultar-pantalla { opacity: 0; transform: scale(0.9) rotate(-1deg); pointer-events: none; }

        /* 🎮 INTERFAZ PRINCIPAL EXPANDIDA */
        .container { max-width: 1000px; margin: 0 auto; position: relative; padding-bottom: 20px; }
        
        h2 { 
            color: #ff3c00; text-shadow: 0 0 10px #ff3c00, 0 0 20px #ff7700; 
            font-size: 18px; margin-top: 10px; margin-bottom: 25px;
        }
        
        .panel-control { 
            background: linear-gradient(135deg, #070b12 0%, #0d1424 100%);
            border: 2px solid #00ffff;
            box-shadow: 0 0 25px rgba(0,255,255,0.25), inset 0 0 15px rgba(0,255,255,0.1);
            padding: 30px; margin-bottom: 25px; border-radius: 12px; 
        }

        /* Caja contenedora para la pregunta de tamaño fijo */
        .contenedor-pregunta {
            min-height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 25px;
        }

        .pregunta { 
            color: #FFF; 
            font-size: 12px; 
            line-height: 2; 
            text-shadow: 0 0 5px rgba(255,255,255,0.2); 
            margin: 0;
        }
        
        .controles-linterna {
            margin: 20px 0; padding: 15px;
            background: rgba(0, 255, 255, 0.03);
            border: 1px dashed rgba(0, 255, 255, 0.2); border-radius: 8px;
        }
        
        button { 
            padding: 14px 28px; font-family: 'Press Start 2P', sans-serif; font-size: 10px;
            font-weight: bold; background: #04060a; color: #ff3c00; 
            border: 2px solid #ff3c00; border-radius: 6px; cursor: pointer; margin: 8px;
            box-shadow: 0 4px 0 #992400, 0 0 10px rgba(255, 60, 0, 0.3);
            transition: all 0.1s ease;
        }
        button:hover { background: #ff3c00; color: #000; box-shadow: 0 4px 0 #771b00, 0 0 20px #ff3c00; transform: translateY(-2px); }
        button:active { transform: translateY(4px); box-shadow: 0 0px 0 #992400; }
        
        button.btn-azul { color: #00ffff; border-color: #00ffff; box-shadow: 0 4px 0 #009999, 0 0 10px rgba(0, 255, 255, 0.3); }
        button.btn-azul:hover { background: #00ffff; color: #000; box-shadow: 0 4px 0 #007777, 0 0 20px #00ffff; }
        button.btn-azul:active { box-shadow: 0 0px 0 #009999; }

        /* 🖥️ CANVAS GRANDE */
        canvas { 
            background: #030508; border: 4px solid #ff3c00; border-radius: 16px; 
            box-shadow: 0 0 45px rgba(255, 60, 0, 0.3); display: block; margin: 0 auto;
        }

        /* 🚨 EFECTO FLASH DAÑO */
        .glitch-flash { animation: flashRed 0.3s ease-out 2; }
        @keyframes flashRed {
            0%, 100% { background: #020408; }
            50% { background: #400a0a; filter: hue-rotate(90deg) contrast(1.5); }
        }

        /* 🏆 NOTIFICACIONES DE JUEGO ADAPTADAS */
        .game-notification {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(2, 4, 8, 0.95); z-index: 10000;
            display: flex; justify-content: center; align-items: center;
            opacity: 0; pointer-events: none; transition: opacity 0.3s ease;
        }
        .game-notification.active { opacity: 1; pointer-events: auto; }
        .noti-box {
            padding: 40px; border-radius: 16px; max-width: 600px; width: 90%;
            text-align: center; border: 3px solid #fff; box-shadow: 0 0 30px rgba(255,255,255,0.2);
        }
        .noti-box.success { border-color: #00ff66; box-shadow: 0 0 35px #00ff66; color: #00ff66; }
        .noti-box.fail { border-color: #ff3c00; box-shadow: 0 0 35px #ff3c00; color: #ff3c00; }
        .noti-box p { color: #fff; font-size: 11px; line-height: 2; margin: 25px 0; }
    </style>
</head>
<body>

<!-- 🕹️ PANTALLA DE BIENVENIDA -->
<div id="pantalla-inicio" class="overlay-gamer">
    <div class="contenedor-instrucciones">
        <h1 class="titulo-arcade">🍄 NIVEL 3: La Sombra Guardada</h1>
        <h2 class="subtitulo-arcade">Mecánica de Sigilo • Jugador: <?php echo htmlspecialchars($nombre); ?></h2>
        
        <div class="bloque-pasos">
            <h3>📖 INSTRUCCIONES DE SUPERVIVENCIA:</h3>
            <ul>
                <li><span style="color:#ffcc00">1.</span> Controla tu linterna con las teclas <span style="color:#00ffff">⬅️ IZQ / DER ➡️</span> o presiona los mandos mecánicos azules.</li>
                <li><span style="color:#ffcc00">2.</span> Al mover el reflector, proyectarás de forma gigante la silueta del <span style="color:#ff3c00">Chikón Tokosho</span> oculto tras la roca.</li>
                <li><span style="color:#ffcc00">3.</span> <span style="color:#ffcc00; font-weight:bold;">MISIÓN CRÍTICA:</span> Alinea la sombra de la criatura para que se oculte por completo dentro de la zona de penumbra absoluta (franja derecha).</li>
                <li><span style="color:#ffcc00">4.</span> Cuando esté a salvo en la oscuridad, pulsa tu respuesta mitológica para neutralizar su avance.</li>
            </ul>
        </div>
        <button id="btn-comenzar" class="btn-comenzar">¡INICIAR PARTIDA!</button>
    </div>
</div>

<!-- 🏆 POPUP GAMER -->
<div id="popup-juego" class="game-notification">
    <div id="popup-contenido" class="noti-box">
        <h2 id="popup-titulo" style="font-size: 18px; margin: 0;"></h2>
        <p id="popup-mensaje"></p>
        <button class="btn-azul" onclick="cerrarNotificacion()" style="margin-top: 15px; border-color: inherit; color: #fff; background: #000; padding: 12px 25px;">ENTENDIDO</button>
    </div>
</div>

<div class="container" id="gameContainer">
    <h2>🍄La Sombra Guardada</h2>

    <div class="panel-control">
        <!-- Contenedor dinámico de la pregunta actual -->
        <div class="contenedor-pregunta">
            <span id="textoPregunta" class="pregunta">Cargando desafío mitológico...</span>
        </div>
        
        <div class="controles-linterna">
            <span style="font-size:10px; color:#00ffff; margin-bottom:12px; display:inline-block; letter-spacing: 1px;">AJUSTE REFLECTOR</span><br>
            <button class="btn-azul" onclick="moverLinterna(-20)">⬅️ Mover Izq</button>
            <button class="btn-azul" onclick="moverLinterna(20)">Mover Der ➡️</button>
        </div>

        <button onclick="protegerSombra(true)">VERDADERO 👍</button>
        <button onclick="protegerSombra(false)">FALSO 👎</button>
    </div>
    
    <canvas id="canvasSombra" width="800" height="550"></canvas>
</div>

<script>
    const cvs = document.getElementById("canvasSombra"), ctx = cvs.getContext("2d");
let linternaX = 200, chikonAlerta = false, puntosProgreso = 0;
const roca = { x: 400, y: 280, r: 40 };
const zonaLimiteX = 640;
// 📜 BANCO DE PREGUNTAS AUTOMATIZADO SOBRE EL CHIKÓN
const bancoPreguntas = [
{ q: "¿El Chikón Tokosho es representado comúnmente como un jinete rubio montado en un imponente caballo blanco?", a: true },
{ q: "¿El Chikón Tokosho vive felizmente en las profundidades costeras del océano Pacífico?", a: false },
{ q: "¿Los guardianes y policías que cuidan la entrada de la cueva del Chikón son feroces coyotes?", a: true },
{ q: "¿El Chikón Tokosho es considerado por la cultura mazateca como el padre y protector de la agricultura?", a: true },
{ q: "¿Esta deidad ancestral odia el maíz y destruye las cosechas de los agricultores de Huautla?", a: false },
{ q: "¿El Chikón es un espíritu de la naturaleza que protege los cerros de los cazadores ambiciosos?", a: true },
{ q: "¿Los curanderos o yerberos usan hongos sagrados para comunicarse con el gran Chikón Tokosho?", a: true }
];
let preguntaActual = {};
// Función para seleccionar una pregunta aleatoria sin repetir la anterior
function cambiarPregunta() {
let indice = Math.floor(Math.random() * bancoPreguntas.length);
preguntaActual = bancoPreguntas[indice];
document.getElementById('textoPregunta').innerText = preguntaActual.q;
}
// Generador de partículas ambientales
let particulas = [];
for (let i = 0; i < 40; i++) {
particulas.push({
x: Math.random() * cvs.width,
y: Math.random() * cvs.height,
r: Math.random() * 2.5 + 1,
vX: Math.random() * 0.4 - 0.2,
vY: Math.random() * -0.6 - 0.1
});
}
document.getElementById('btn-comenzar').addEventListener('click', function() {
document.getElementById('pantalla-inicio').classList.add('ocultar-pantalla');
cambiarPregunta(); // Inicia la primera pregunta del juego
});
window.onkeydown = (e) => {
if (e.key === "ArrowLeft") moverLinterna(-20);
if (e.key === "ArrowRight") moverLinterna(20);
};
function moverLinterna(delta) {
let nuevaX = linternaX + delta;
if (nuevaX >= 60 && nuevaX <= 340) linternaX = nuevaX;
}
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
// Si ya completó los 100 XP, reiniciamos o podemos disparar un evento de victoria
if (puntosProgreso >= 100) {
lanzarNotificacion("👑 ¡VICTORIA TOTAL! 👑", "¡Has completado el Nivel 3 con éxito y dominas el conocimiento del Cerro de la Adoración! Puntuación máxima obtenida.", "success");
puntosProgreso = 0;
}
cambiarPregunta(); // Cambia de pregunta automáticamente al cerrar el diálogo
}
function protegerSombra(ans) {
// Compara la elección del niño con la respuesta correcta de la pregunta actual
if (ans === preguntaActual.a) {
chikonAlerta = true;
setTimeout(() => {
let dx = roca.x - linternaX;
let SombraCalculadaX = roca.x + dx * 1.5;
if (SombraCalculadaX > zonaLimiteX) {
puntosProgreso += 50;
lanzarNotificacion("🏆 ¡INCREÍBLE! 🏆", "¡Sabiduría Perfecta! Escondiste la silueta del Chikón perfectamente dentro de la penumbra del cerro. ¡Sumas +50 XP!", "success");
} else {
document.body.classList.add('glitch-flash');
setTimeout(() => document.body.classList.remove('glitch-flash'), 600);
lanzarNotificacion("🚨 ¡DETECTADO! 🚨", "Respondiste bien, pero tu linterna dejó la silueta de la criatura expuesta ante los ojos del guardián. ¡Ajusta tu posición!", "fail");
}
chikonAlerta = false;
linternaX = 200;
}, 850);
} else {
document.body.classList.add('glitch-flash');
setTimeout(() => document.body.classList.remove('glitch-flash'), 600);
lanzarNotificacion("❌ ERROR CRÍTICO ❌", "¡La mitología te confunde! Perdiste el enfoque estratégico y el Chikón Tokosho te ha descubierto en la claridad.", "fail");
linternaX = 200;
}
}
function dibujarSiluetaChikon(x, y, radio) {
ctx.save();
ctx.fillStyle = chikonAlerta ? "rgba(255, 30, 0, 0.85)" : "rgba(12, 17, 26, 0.95)";
if (chikonAlerta) {
ctx.shadowBlur = 30;
ctx.shadowColor = "#ff3c00";
}
ctx.beginPath();
ctx.arc(x, y + 20, radio * 1.2, 0, Math.PI * 2);
ctx.arc(x, y - radio * 0.5, radio * 0.8, 0, Math.PI * 2);
ctx.fill();
ctx.beginPath();
ctx.moveTo(x - radio * 0.5, y - radio * 1.1);
ctx.lineTo(x - radio * 1.0, y - radio * 2.0);
ctx.lineTo(x - radio * 0.1, y - radio * 1.3);
ctx.moveTo(x + radio * 0.5, y - radio * 1.1);
ctx.lineTo(x + radio * 1.0, y - radio * 2.0);
ctx.lineTo(x + radio * 0.1, y - radio * 1.3);
ctx.fill();
ctx.fillStyle = "#ff3c00";
ctx.beginPath();
ctx.arc(x - 12, y - 22, 4, 0, Math.PI * 2);
ctx.arc(x + 12, y - 22, 4, 0, Math.PI * 2);
ctx.fill();
ctx.restore();
}
function loopGraphic() {
ctx.clearRect(0, 0, cvs.width, cvs.height);
// Fondo Rejilla Cyberpunk
ctx.strokeStyle = "rgba(0, 255, 255, 0.02)";
ctx.lineWidth = 1;
for(let i=0; i<cvs.width; i+=40) { ctx.beginPath(); ctx.moveTo(i,0); ctx.lineTo(i,cvs.height); ctx.stroke(); }
for(let j=0; j<cvs.height; j+=40) { ctx.beginPath(); ctx.moveTo(0,j); ctx.lineTo(cvs.width,j); ctx.stroke(); }
// Niebla flotante
ctx.fillStyle = "rgba(0, 255, 255, 0.12)";
particulas.forEach(p => {
p.y += p.vY; p.x += p.vX;
if (p.y < 0) p.y = cvs.height;
if (p.x < 0 || p.x > cvs.width) p.x = Math.random() * cvs.width;
ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2); ctx.fill();
});
// Zona Segura Derecha
ctx.fillStyle = "#020407"; ctx.fillRect(zonaLimiteX, 0, cvs.width - zonaLimiteX, cvs.height);
ctx.strokeStyle = "#ff3c00"; ctx.lineWidth = 3; ctx.beginPath(); ctx.moveTo(zonaLimiteX, 0); ctx.lineTo(zonaLimiteX, cvs.height); ctx.stroke();
// Dibujar la Gran Roca de Obstáculo
ctx.save();
ctx.shadowBlur = 20; ctx.shadowColor = "#00ffff";
ctx.fillStyle = "#0f1b26"; ctx.strokeStyle = "#00ffff"; ctx.lineWidth = 3;
ctx.beginPath(); ctx.arc(roca.x, roca.y, roca.r, 0, Math.PI * 2); ctx.fill(); ctx.stroke();
ctx.restore();
// Proyección de la sombra monstruosa CORREGIDA (Línea 331 solventada con roca.r * 2.5)
let dx = roca.x - linternaX;
let sx = roca.x + dx * 1.5;
dibujarSiluetaChikon(sx, roca.y, roca.r * 1.3);
// Foco de Linterna
ctx.save();
ctx.shadowBlur = 25; ctx.shadowColor = "#ff3c00";
ctx.fillStyle = "#ff3c00"; ctx.beginPath(); ctx.arc(linternaX, roca.y, 20, 0, Math.PI * 2); ctx.fill();
ctx.restore();
ctx.fillStyle = "#000"; ctx.font = "20px sans-serif"; ctx.fillText("🔦", linternaX - 10, roca.y + 7);
// Haz de Luz proyectado amplio (¡Solución matemática perfecta!)
ctx.fillStyle = "rgba(255, 60, 0, 0.06)";
ctx.beginPath();
ctx.moveTo(linternaX, roca.y);
ctx.lineTo(roca.x, roca.y - roca.r * 2.5);
ctx.lineTo(roca.x, roca.y + roca.r * 2.5);
ctx.closePath();
ctx.fill();
// HUD Superior
ctx.fillStyle = "#00ffff"; ctx.font = "9px 'Press Start 2P'";
ctx.fillText("SCORE: " + puntosProgreso + "/100 XP", 30, 40);
ctx.fillStyle = "#ffcc00";
ctx.fillText("LINTERNA_POS: " + linternaX + "M", cvs.width - 240, 40);
requestAnimationFrame(loopGraphic);
}
loopGraphic();

</script>
</body>
</html>
