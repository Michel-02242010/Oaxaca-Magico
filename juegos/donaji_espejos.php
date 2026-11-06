<?php 
session_start(); $nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador"; 
$banco = [
    ["p" => "¿Qué señal envió Donají a su padre para advertir la traición?", "ok" => "Un lirio silvestre con un mensajero 🪶", "no" => "Un enjambre de flechas encendidas 🔥"],
    ["p" => "¿A qué pueblo indígena pertenecía la valiente princesa Donají?", "ok" => "Al pueblo Zapoteco 👑", "no" => "Al Imperio Mexica 🛡️"],
    ["p" => "¿Quién era el príncipe mixteco que se enamoró de Donají?", "ok" => "El príncipe Nucano 🏹", "no" => "El rey Condoy ⛰️"],
    ["p" => "¿Qué flor mística brotó en el lugar donde descansaba Donají?", "ok" => "Un lirio de azucena dorada ⚜️", "no" => "Una flor de cempasúchil 🧡"],
    ["p" => "¿En qué emblemática zona arqueológica se desarrolla esta historia?", "ok" => "Monte Albán 🏛️", "no" => "Teotihuacán ☀️"],
    ["p" => "¿Cuál era el rol original de Donají al ser entregada a los mixtecas?", "ok" => "Prenda de paz y rehén de honor ✨", "no" => "Espía secreta del rey 🗡️"],
    ["p" => "¿Qué gran ciudad actual tiene a Donají en su escudo oficial?", "ok" => "Oaxaca de Juárez 🌆", "no" => "Miahuatlán 🌲"],
    ["p" => "¿Qué significa el bello nombre de la princesa Donají?", "ok" => "Alma grande o alma valiosa 💝", "no" => "Flor de primavera 🌸"],
    ["p" => "¿Quién era el padre de Donají y gran soberano zapoteco?", "ok" => "El rey Cosijoeza 👑", "no" => "El rey Condoy 🦅"],
    ["p" => "Al final de la leyenda, ¿qué valor demostraron mixtecos y zapotecos?", "ok" => "Unión, respeto y paz duradera 🤝", "no" => "Envidia y batallas eternas ⚔️"]
];
shuffle($banco);
?>
<!DOCTYPE html>
<html lang="es"><head><meta charset="UTF-8"><title>Código de Pétalos</title>
<link href="https://googleapis.com" rel="stylesheet">
<style>
    body { font-family: 'Quicksand', sans-serif; background: #060403; color: #fff; text-align: center; padding: 20px; user-select: none; }
    .contenedor { background: linear-gradient(180deg, #160e0a, #0a0604); border: 4px solid #b8860b; border-radius: 16px; padding: 25px; max-width: 850px; margin: auto; position: relative; box-shadow: 0 0 50px rgba(184,134,11,0.4), inset 0 0 40px #000; overflow: hidden; }
    .hud-barra { display: flex; justify-content: space-between; align-items: center; background: linear-gradient(90deg, #21160e, #130d09); border: 2px solid #b8860b; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-family: 'Cinzel', serif; }
    .marcador-puntos { font-size: 14px; color: #ffd700; font-weight: bold; }
    .vidas-retro { display: flex; gap: 6px; }
    .corazon { font-size: 18px; color: #ff3366; transition: all 0.3s; text-shadow: 0 0 5px #ff3366; }
    .corazon.muerto { filter: grayscale(100%) opacity(0.15); text-shadow: none; }
    h2 { font-family: 'Cinzel', serif; color: #ffd700; text-shadow: 0 0 10px rgba(184,134,11,0.6); margin: 5px 0; font-size: 26px; }
    .pantalla-inicio { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle, #1a100a 30%, #050302 100%); border-radius: 12px; display: none; flex-direction: column; justify-content: center; align-items: center; z-index: 200; padding: 30px; box-sizing: border-box; }
    .cuadro-instrucciones { background: rgba(10,6,4,0.96); border: 3px dashed #b8860b; padding: 25px; border-radius: 10px; max-width: 520px; box-shadow: 0 0 30px #000; font-size: 14px; line-height: 1.5; }
    .barra-tiempo-contenedor { width: 100%; height: 8px; background: #221105; border-radius: 4px; margin: 10px 0; overflow: hidden; border: 1px solid #b8860b; }
    .barra-tiempo { width: 100%; height: 100%; background: linear-gradient(90deg, #ffd700, #ff3366); }
    .escenario { position: relative; height: 360px; border: 3px solid #b8860b; border-radius: 12px; background: radial-gradient(circle at bottom center, #26170f, #050302); overflow: hidden; margin: 15px 0; box-shadow: inset 0 0 60px #000; }
    .opcion { position: absolute; top: 32%; width: 260px; padding: 22px 15px; background: linear-gradient(180deg, #1c130d, #100a06); border: 2px solid #4a3221; border-radius: 6px; font-weight: bold; cursor: pointer; transition: all 0.2s; z-index: 10; font-size: 14px; display: flex; align-items: center; justify-content: center; min-height: 55px; box-shadow: 0 10px 20px #000; color: #dfd5c6; border-top: 4px solid #5c3f2b; }
    .opcion.izq { left: 35px; } .opcion.der { right: 35px; }
    .opcion.iluminada { border-color: #ffd700; background: #2d1b0f; color: #ffd700; box-shadow: 0 0 30px rgba(255,215,0,0.5); text-shadow: 0 0 5px #ffd700; }
    .espejo-rayo { position: absolute; bottom: 40px; left: 50%; width: 6px; height: 310px; background: linear-gradient(to top, rgba(255,215,0,0.05), #fff, #ffd700); transform-origin: bottom center; transform: translateX(-50%); pointer-events: none; box-shadow: 0 0 20px #ffd700, 0 0 40px #b8860b; }
    .objeto-espejo { position: absolute; bottom: 15px; left: calc(50% - 25px); width: 50px; height: 50px; background: linear-gradient(135deg, #2b1c12, #100a06); border: 3px solid #b8860b; border-radius: 50%; z-index: 5; }
    .objeto-espejo::after { content: ''; position: absolute; top: 0; left: 22px; width: 6px; height: 25px; background: #ffd700; border-radius: 3px; box-shadow: 0 0 8px #ffd700; }
    .btn { background: linear-gradient(180deg, #3d2719, #21150e); color: #ffd700; border: 2px solid #b8860b; padding: 12px 28px; border-radius: 4px; cursor: pointer; font-weight: bold; font-family: 'Cinzel', serif; text-transform: uppercase; font-size: 12px; margin: 10px 5px; box-shadow: 0 4px 0 #0d0805; }
    .btn:hover { background: #4a301f; }
    #feedback { font-size: 19px; font-weight: bold; margin: 15px; min-height: 35px; color: #ffd700; font-family: 'Cinzel', serif; }
</style></head>
<body>
<div class="contenedor">
    <div class="pantalla-inicio" id="pantalla-inicial">
        <h2>📜 EL CÓDICE DE LOS ESPEJOS 📜</h2><br>
        <div class="cuadro-instrucciones">
            <p style="font-size:15px; color:#ffd700; font-family:'Cinzel',serif;">MISIÓN SAGRADA: <?= htmlspecialchars($nombre) ?></p>
            <p>Los reflejos de Monte Albán guardan los secretos de la región. Orienta los espejos sagrados antes de que se agote el tiempo.</p>
            <p>⏱️ <strong>REGLAS DE ACCIÓN:</strong> Tienes 8 segundos por pregunta. Si fallas o el tiempo llega a cero, perderás un corazón.</p>
            <p>🎮 <strong>CONTROLES:</strong> Mueve el cursor por el cuadro negro para apuntar la luz del espejo hacia tu respuesta y haz clic.</p>
        </div>
        <button onclick="iniciarJuego()" class="btn">INICIAR CRÓNICA 👑</button>
    </div>

    <div class="hud-barra">
        <div class="marcador-puntos">SABIDURÍA: <span id="marcador">0000</span></div>
        <div class="vidas-retro" id="contenedor-vidas">
            <span class="corazon" id="v-1">❤️</span><span class="corazon" id="v-2">❤️</span><span class="corazon" id="v-3">❤️</span><span class="corazon" id="v-4">❤️</span><span class="corazon" id="v-5">❤️</span>
        </div>
    </div>

    <h2>🪞 CÓDIGO DE PÉTALOS 🪞</h2>
    <div class="barra-tiempo-contenedor"><div class="barra-tiempo" id="timer-bar"></div></div>
    <p id="pregunta-texto" style="color:#e6ded2; font-weight:bold; font-size:17px; min-height:45px; display:flex; align-items:center; justify-content:center; font-family:'Cinzel',serif; text-transform:uppercase;"></p>
    
    <div class="escenario" id="escenario">
        <div class="opcion izq" id="opc-izq" onclick="validarRespuesta(this)"></div>
        <div class="opcion der" id="opc-der" onclick="validarRespuesta(this)"></div>
        <div class="espejo-rayo" id="rayo"></div>
        <div class="objeto-espejo" id="espejo-fisico"></div>
    </div>
    <div id="feedback"></div>
    <div>
        <button onclick="reiniciarPartida()" class="btn" style="border-color:#ff3366; color:#ff3366; box-shadow: 0 4px 0 #4a0011;">REINICIAR JUEGO 🔄</button>
        <button onclick="location.href='../plataforma.php?tab=juegos'" class="btn" style="border-color:#777; color:#999; box-shadow: 0 4px 0 #222;">SALIR 🚪</button>
    </div>
</div>

<script>
const preguntas = <?= json_encode($banco) ?>;
let indicePregunta = 0, pts = parseInt(sessionStorage.getItem('sabiduria_puntos')) || 0, vidas = 5, respondido = false, tiempoRestante = 80, intervaloTiempo;
const esc = document.getElementById('escenario'), rayo = document.getElementById('rayo'), esp = document.getElementById('espejo-fisico'), oI = document.getElementById('opc-izq'), oD = document.getElementById('opc-der'), pInit = document.getElementById('pantalla-inicial'), tBar = document.getElementById('timer-bar');

document.getElementById('marcador').innerText = String(pts).padStart(4, '0');

if (!sessionStorage.getItem('donaji_bienvenida_vista')) { pInit.style.display = 'flex'; } else { activarPregunta(); }
function iniciarJuego() { sessionStorage.setItem('donaji_bienvenida_vista', 'true'); pInit.style.display = 'none'; activarPregunta(); }
function reiniciarPartida() { sessionStorage.removeItem('donaji_bienvenida_vista'); sessionStorage.setItem('sabiduria_puntos', 0); location.reload(); }

function activarPregunta() {
    if (indicePregunta >= preguntas.length) {
        clearInterval(intervaloTiempo);
        document.getElementById('feedback').innerHTML = "🎉 ¡Felicidades! Completaste todo el Códice Sagrado sin repetir.";
        oI.style.display = oD.style.display = 'none'; return;
    }
    respondido = false; document.getElementById('feedback').innerHTML = "";
    oI.style.background = oD.style.background = ""; oI.style.color = oD.style.color = "#dfd5c6";
    let actual = preguntas[indicePregunta];
    document.getElementById('pregunta-texto').innerText = "¿" + actual.p + "?";
    let izqCorrecto = Math.random() < 0.5;
    oI.innerText = izqCorrecto ? actual.ok : actual.no; oI.setAttribute('data-correct', izqCorrecto ? '1' : '0');
    oD.innerText = izqCorrecto ? actual.no : actual.ok; oD.setAttribute('data-correct', izqCorrecto ? '0' : '1');
tiempoRestante = 80; tBar.style.width = "100%"; clearInterval(intervaloTiempo); intervaloTiempo = setInterval(relojJuego, 100);
}
function relojJuego() {
if (respondido) return; tiempoRestante--; tBar.style.width = (tiempoRestante / 80 * 100) + "%";
if (tiempoRestante <= 0) { clearInterval(intervaloTiempo); quitarVida("¡TIEMPO AGOTADO! La señal se desvaneció."); }
}
function quitarVida(mensaje) {
respondido = true; document.getElementById('feedback').innerHTML = "⚠️ " + mensaje;
document.getElementById("v-" + vidas).classList.add('muerto'); vidas--;
if (vidas <= 0) { clearInterval(intervaloTiempo); document.getElementById('feedback').innerHTML = "💀 GAME OVER // Energía mística agotada."; return; }
siguientePasoMagico();
}
esc.addEventListener('mousemove', (e) => {
if (respondido) return;
const r = esc.getBoundingClientRect();
let angulo = Math.atan2((e.clientX - r.left) - (r.width / 2), (r.height - 40) - (e.clientY - r.top)) * (180 / Math.PI);
angulo = Math.max(-75, Math.min(75, angulo));
rayo.style.transform = "translateX(-50%) rotate(" + angulo + "deg)";
esp.style.transform = "rotate(" + angulo + "deg)";
oI.classList.remove('iluminada'); oD.classList.remove('iluminada');
if (angulo < -18) oI.classList.add('iluminada'); if (angulo > 18) oD.classList.add('iluminada');
});
function validarRespuesta(elm) {
if (respondido || vidas <= 0) return; respondido = true; clearInterval(intervaloTiempo);
const fd = document.getElementById('feedback'), ok = elm.getAttribute('data-correct') === '1';
if (ok) {
pts += 10; sessionStorage.setItem('sabiduria_puntos', pts); document.getElementById('marcador').innerText = String(pts).padStart(4, '0');
elm.style.background = "#ffd700"; elm.style.color = "#000"; fd.innerHTML = "🏆 TRANSMISIÓN EXITOSA // EL REFLEJO REVELÓ LA VERDAD"; siguientePasoMagico();
} else {
elm.style.background = "#ff3366"; elm.style.color = "#fff"; quitarVida("SEÑAL INTERCEPTADA POR LOS ADVERSARIOS");
}
}
function siguientePasoMagico() { indicePregunta++; setTimeout(() => { if (vidas > 0) activarPregunta(); }, 2000); }
</script></body></html>