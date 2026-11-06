<?php
session_start();
$nombre = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Masa de Agua Mística - La Costa</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { 
            background: #00b4d8; 
            color: #FFF; 
            font-family: 'Fredoka', sans-serif; 
            text-align: center; 
            margin: 0; padding: 20px;
            background-image: linear-gradient(135deg, #00b4d8 0%, #0077b6 100%);
        }
        h2 { 
            font-size: 26px; 
            text-shadow: 3px 3px 0px #03045e;
            color: #ffb703;
            margin-bottom: 10px;
        }
        .instrucciones { 
            background: rgba(255, 255, 255, 0.2); 
            border: 3px solid #03045e;
            padding: 15px; max-width: 700px; margin: 0 auto 15px auto;
            border-radius: 15px; font-size: 16px; color: #FFF;
            text-shadow: 1px 1px 2px #03045e;
        }
        canvas { 
            background: #caf0f8; 
            border: 5px solid #03045e; 
            border-radius: 20px; 
            box-shadow: 8px 8px 0px #03045e;
        }
    </style>
</head>
<body>
    <h2>🌊 JUEGO 1: Masa de Agua Mística (Limpieza)</h2>
    <div class="instrucciones">
        <b>MANTÉN EL CLIC PRESIONADO</b> para Estirarte (VERDADERO)<br>
        <b>SUÉLTALO</b> para Comprimirte (FALSO) y cruzar la grieta mística.
    </div>
    <canvas id="canvasAgua" width="650" height="350"></canvas>

<script>
const cvs = document.getElementById("canvasAgua"), ctx = cvs.getContext("2d");
let mousePresionado = false, anchoAgua = 40, altoAgua = 40;
let barreraX = 650, respuestaEvaluada = false;
const respuestaCorrecta = "estirado"; 

cvs.onmousedown = () => { mousePresionado = true; };
cvs.onmouseup = () => { mousePresionado = false; };

function loop() {
    ctx.clearRect(0, 0, cvs.width, cvs.height);

    if (mousePresionado) {
        anchoAgua += (15 - anchoAgua) * 0.15;
        altoAgua += (80 - altoAgua) * 0.15;
    } else {
        anchoAgua += (60 - anchoAgua) * 0.15;
        altoAgua += (25 - altoAgua) * 0.15;
    }

    ctx.save();
    ctx.lineWidth = 4; ctx.strokeStyle = "#03045e";
    ctx.fillStyle = "#0077b6";
    ctx.beginPath(); ctx.ellipse(150, 175, anchoAgua, altoAgua, 0, 0, Math.PI * 2); ctx.fill(); ctx.stroke();
    
    ctx.fillStyle = "#90e0ef";
    ctx.beginPath(); ctx.ellipse(145, 170, anchoAgua*0.6, altoAgua*0.6, 0, 0, Math.PI * 2); ctx.fill();
    ctx.restore();

    barreraX -= 2.5;
    if (barreraX < -50) { barreraX = 650; respuestaEvaluada = false; }

    ctx.save();
    ctx.lineWidth = 4; ctx.strokeStyle = "#03045e";
    ctx.fillStyle = "#e63946";
    ctx.fillRect(barreraX, 0, 30, 110); ctx.strokeRect(barreraX, 0, 30, 110);
    ctx.fillRect(barreraX, 240, 30, 110); ctx.strokeRect(barreraX, 240, 30, 110);
    
    ctx.fillStyle = "#FFF"; ctx.font = "bold 16px 'Fredoka'"; ctx.textAlign = "center";
    ctx.fillText("GRIETA", barreraX + 15, 180);
    ctx.restore();

    if (!respuestaEvaluada && barreraX <= 170 && barreraX >= 130) {
        respuestaEvaluada = true;
        let estadoActual = (anchoAgua < 25) ? "estirado" : "comprimido";
        
        if (estadoActual === respuestaCorrecta) {
            ctx.fillStyle = "rgba(0, 180, 216, 0.4)"; ctx.fillRect(0, 0, cvs.width, cvs.height);
            alert("🏆 ¡Excelente! Tu forma elástica cruzó la grieta y limpió el coral maldito.");
        } else {
            alert("🎒 ¡Incorrecto! Tu forma comprimida chocó con las rocas del arrecife.");
            barreraX = 650;
        }
    }

    requestAnimationFrame(loop);
}
loop();
</script>
</body>
</html>
