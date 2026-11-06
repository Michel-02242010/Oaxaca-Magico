<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tesoros del Pacífico</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { 
            background: #ffb703; 
            color: #023047; 
            font-family: 'Fredoka', sans-serif; 
            text-align: center; 
            margin: 0; padding: 20px;
            overflow: hidden;
        }
        h2 { font-size: 26px; text-shadow: 2px 2px 0px #FFF; color: #e26d5c; margin-bottom: 5px; }
        .contenedor-juego {
            position: relative;
            width: 600px;
            height: 320px;
            margin: 20px auto;
        }
        canvas { 
            background: #fb8500; 
            border: 5px solid #023047; 
            border-radius: 20px; 
            box-shadow: 8px 8px 0px #023047;
            position: absolute;
            top: 0; left: 0;
            z-index: 1;
        }
        .pantalla-overlay {
            position: absolute;
            top: 0; left: 0;
            width: 600px;
            height: 320px;
            background: rgba(251, 133, 0, 0.98);
            border: 5px solid #023047;
            border-radius: 20px;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            padding: 20px;
            box-shadow: 8px 8px 0px #023047;
        }
        .box-titulo {
            color: #FFF;
            font-size: 24px;
            margin-bottom: 15px;
            text-shadow: 3px 3px 0px #023047;
        }
        .box-texto {
            color: #023047;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .btn-game {
            padding: 10px 25px;
            font-family: 'Fredoka', sans-serif;
            font-size: 15px;
            font-weight: bold;
            background: #8ecae6;
            color: #023047;
            border: 3px solid #023047;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 4px 4px 0px #023047;
            transition: all 0.2s;
            margin: 6px;
            width: 85%;
        }
        .btn-game:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px #023047;
            background: #FFF;
        }
    </style>
</head>
<body>
    <h2>🎴 JUEGO 3: Tesoros del Pacífico (Marea de Memoria)</h2>
    
    <div class="contenedor-juego">
        <!-- Pantalla Inicial -->
        <div id="pantalla-inicio" class="pantalla-overlay">
            <div class="box-titulo">🌊 COFRES MARINOS</div>
            <div class="box-texto">
                ¡Hola <?= htmlspecialchars($nombre) ?>!<br><br>
                Haz clic sobre las conchas marinas flotantes para emparejar los elementos míticos. Cada acierto abrirá un secreto del océano que deberás responder.
            </div>
            <button class="btn-game" style="width:auto;" onclick="iniciarMarea()">BUSCAR TESOROS</button>
        </div>

        <!-- Pantalla de Trivia con Múltiples Preguntas -->
        <div id="pantalla-trivia" class="pantalla-overlay" style="display: none;">
            <div class="box-titulo" style="color:#ffb703;">❓ TRIVIA DE LA COSTA</div>
            <div class="box-texto" id="trivia-texto">Pregunta</div>
            <button class="btn-game" id="opc-0" onclick="evaluarTrivia(0)">Opción A</button>
            <button class="btn-game" id="opc-1" onclick="evaluarTrivia(1)">Opción B</button>
        </div>

        <!-- Pantalla Feedback -->
        <div id="pantalla-resultado" class="pantalla-overlay" style="display: none;">
            <div class="box-titulo" id="res-titulo">RESULTADO</div>
            <div class="box-texto" id="res-texto">Mensaje explicativo corporativo.</div>
            <button class="btn-game" style="width:auto;" onclick="cerrarResultado()">CONTINUAR REVOLVIENDO</button>
        </div>

        <canvas id="canvasMarea" width="600" height="320"></canvas>
    </div>

<script>
const cvs = document.getElementById("canvasMarea"), ctx = cvs.getContext("2d");
let tiempoFlote = 0, juegoActivo = false;

// Amplio banco de preguntas sobre la Costa de Oaxaca
const bancoPreguntas = [
    { q: "¿En qué municipio costero se encuentra la famosa playa de Zicatela?", ops: ["Santa María Colotepec 🌊", "Salina Cruz ❌"], correcta: 0 },
    { q: "¿Cuál es el baile tradicional de la Costa que se presenta en la Guelaguetza?", ops: ["Las Chilenas Costeñas 💃", "La Danza de la Pluma ❌"], correcta: 0 },
    { q: "¿Qué especie marina protegida llega masivamente a desovar en Mazunte?", ops: ["La Tortuga Golfina 🐢", "El Tiburón Ballena ❌"], correcta: 0 },
    { q: "¿Qué Parque Nacional protege las lagunas y manglares de la Costa?", ops: ["Parque Nacional Lagunas de Chacahua 🌿", "Hierve el Agua ❌"], correcta: 0 },
    { q: "¿Qué artesanía textil con hilos de tinte de caracol de mar es nativa de Pinotepa?", ops: ["Los Pozahuancos de hule purpúreo 🧵", "Los Alebrijes de madera ❌"], correcta: 0 }
];
let preguntaActual = {};

let cartas = [
    { id: 1, x: 50, y: 110, w: 100, h: 100, par: "A", descubierta: false, txt: "🧜‍♀️ Sirena" },
    { id: 2, x: 180, y: 110, w: 100, h: 100, par: "B", descubierta: false, txt: "🌊 Zicatela" },
    { id: 3, x: 310, y: 110, w: 100, h: 100, par: "A", descubierta: false, txt: "🧜‍♀️ Sirena" },
    { id: 4, x: 440, y: 110, w: 100, h: 100, par: "B", descubierta: false, txt: "🌊 Zicatela" }
];
let seleccionadas = [];

cvs.onclick = (e) => {
    if (!juegoActivo || seleccionadas.length >= 2) return;
    let rect = cvs.getBoundingClientRect(), mx = e.clientX - rect.left, my = e.clientY - rect.top;
    
    cartas.forEach(c => {
        let dy = Math.sin(tiempoFlote + c.x) * 8;
        if (mx > c.x && mx < c.x + c.w && my > c.y + dy && my < c.y + c.h + dy) {
            if (!c.descubierta && !seleccionadas.includes(c)) {
                c.descubierta = true; 
                seleccionadas.push(c);
                if (seleccionadas.length === 2) comprobarMarea();
            }
        }
    });
};

function iniciarMarea() {
    document.getElementById("pantalla-inicio").style.display = "none";
    juegoActivo = true;
    animarMarea();
}

function comprobarMarea() {
    let [c1, c2] = seleccionadas;
    if (c1.par === c2.par) {
        juegoActivo = false;
        // Lanzar una pregunta aleatoria del banco
        preguntaActual = bancoPreguntas[Math.floor(Math.random() * bancoPreguntas.length)];
        document.getElementById("trivia-texto").innerText = preguntaActual.q;
        document.getElementById("opc-0").innerText = preguntaActual.ops[0];
        document.getElementById("opc-1").innerText = preguntaActual.ops[1];
        
        setTimeout(() => {
            document.getElementById("pantalla-trivia").style.display = "flex";
        }, 600);
    } else {
        setTimeout(() => {
            c1.descubierta = false; c2.descubierta = false;
            seleccionadas = [];
        }, 1000);
    }
}

function evaluarTrivia(opcion) {
    document.getElementById("pantalla-trivia").style.display = "none";
    const resTitulo = document.getElementById("res-titulo");
    const resTexto = document.getElementById("res-texto");

    if (opcion === preguntaActual.correcta) {
        resTitulo.innerText = "🏆 ¡SABIDURÍA DE LA COSTA!";
        resTitulo.style.color = "#FFF";
        resTexto.innerHTML = "¡Excelente respuesta! Demostraste conocer las riquezas naturales y culturales de nuestras hermosas playas de Oaxaca.";
    } else {
        resTitulo.innerText = "🎒 marea de aprendizaje";
        resTitulo.style.color = "#023047";
        resTexto.innerHTML = "¡Casi lo logras! Recuerda repasar las leyendas y datos de la costa para la próxima ola.";
        // Voltear las cartas de nuevo por fallar la pregunta
        seleccionadas[0].descubierta = false;
        seleccionadas[1].descubierta = false;
    }
    seleccionadas = [];
    document.getElementById("pantalla-resultado").style.display = "flex";
}

function cerrarResultado() {
    document.getElementById("pantalla-resultado").style.display = "none";
    
    // Validar si ya se ganaron todas las cartas
    if (cartas.every(c => c.descubierta)) {
        document.getElementById("res-titulo").innerText = "🥇 ¡CONQUISTADOR MARINO!";
        document.getElementById("res-texto").innerText = "¡Increíble! Encontraste todos los cofres místicas y respondiste los enigmas del Pacífico.";
        document.getElementById("pantalla-resultado").style.display = "flex";
        // Cambiar comportamiento del botón final
        document.querySelector("#pantalla-resultado .btn-game").onclick = () => location.reload();
    } else {
        juegoActivo = true;
    }
}

function animarMarea() {
    ctx.clearRect(0, 0, cvs.width, cvs.height);
    tiempoFlote += 0.04;

    cartas.forEach(c => {
        let dephY = Math.sin(tiempoFlote + c.x) * 8; 

        ctx.save();
        ctx.lineWidth = 4; ctx.strokeStyle = "#023047";
        ctx.fillStyle = c.descubierta ? "#FFF" : "#8ecae6";
        ctx.fillRect(c.x, c.y + dephY, c.w, c.h);
        ctx.strokeRect(c.x, c.y + dephY, c.w, c.h);
        ctx.restore();

        // Reemplazo completo de texto simple dibujando vectores nítidos internos
        ctx.save();
        ctx.fillStyle = "#023047";
        ctx.font = "bold 13px 'Fredoka'"; ctx.textAlign = "center";
        
        if (c.descubierta) {
            ctx.fillText(c.txt, c.x + 50, c.y + 55 + dephY);
        } else {
            // Dibujar icono de Concha Marina geométrica en vez de emoji
            ctx.fillStyle = "#ffb703";
            ctx.beginPath();
            ctx.arc(c.x + 50, c.y + 50 + dephY, 15, 0, Math.PI, true);
ctx.lineTo(c.x + 50, c.y + 65 + dephY);
ctx.fill();
ctx.fillStyle = "#023047";
ctx.font = "11px 'Fredoka'";
ctx.fillText("COFRE", c.x + 50, c.y + 35 + dephY);
}
ctx.restore();
});
requestAnimationFrame(animarMarea);
}
</script>
</body>
</html>
