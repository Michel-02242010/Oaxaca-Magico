<?php session_start(); 
$nombre = $_SESSION['alumno_nombre'] ?? "Explorador"; 
$conceptos = [
    ["id" => 1, "p" => "Baile tradicional de la Cuenca que celebra la piña.", "r" => "Flor de Piña 🍍"],
    ["id" => 2, "p" => "Río majestuoso que le da nombre a la región.", "r" => "Río Papaloapan 🌊"],
    ["id" => 3, "p" => "Especie animal endémica de las selvas.", "r" => "Jaguar 🐆"]
];
$cartas = [];
foreach ($conceptos as $i) {
    $cartas[] = ["id" => $i["id"], "t" => "p", "x" => $i["p"]];
    $cartas[] = ["id" => $i["id"], "t" => "r", "x" => $i["r"]];
}
shuffle($cartas); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mosaico de la Cuenca</title>
    <style>
        body { font-family: sans-serif; background: #06080c; color: #fff; text-align: center; padding: 15px; user-select: none; }
        .contenedor { background: rgba(13, 20, 30, 0.95); border: 3px solid #ff5500; border-radius: 15px; padding: 20px; max-width: 650px; margin: auto; position: relative; }
        .hud { position: absolute; top: 15px; right: 15px; background: #ff5500; padding: 5px 12px; border-radius: 5px; font-weight: bold; font-size: 11px; }
        .inst { border: 1px dashed #ff5500; padding: 12px; margin: 15px auto; text-align: left; font-size: 13px; color: #ffaa66; border-radius: 8px; line-height: 1.5; }
        .cuadricula { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin: 20px 0; }
        .carta { height: 90px; cursor: pointer; background: #111622; border: 2px solid #ff5500; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 11px; padding: 5px; color: #ff5500; transition: 0.2s; }
        .volteada { background: #fffbf2; color: #06080c; border-color: #00ffff; }
        .r-estilo { border-color: #00ff66; color: #00ff66; }
        .emparejada { opacity: 0.2; pointer-events: none; }
        .btn { background: #000; color: #ff5500; border: 2px solid #ff5500; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; margin: 5px; }
        .btn:hover { background: #ff5500; color: #000; }
    </style>
</head>
<body>
<div class="contenedor">
    <div class="hud">⭐ <span id="marcador">0</span> PTS</div>
    <h2>🌾 MOSAICO DE LA CUENCA 🌾</h2>
    <h3>¡Hola, <?= htmlspecialchars($nombre) ?>!</h3>

    <!-- 📌 NUEVO: Panel de Instrucciones Reducido -->
    <div class="inst">
        📌 <strong>INSTRUCCIONES:</strong><br>
        1. Haz clic sobre dos cartas de la cuadrícula para voltearlas.<br>
        2. Encuentra la relación exacta entre la <strong>pregunta / descripción</strong> y su <strong>respuesta correcta</strong>.<br>
        3. Si logras emparejar el par místico, ganarás +10 puntos y las cartas se desvanecerán. ¡Junta los 3 pares para ganar!
    </div>

    <div class="cuadricula">
        <?php foreach ($cartas as $idx => $c): ?>
            <div class="carta" id="c-<?= $idx ?>" data-id="<?= $c['id'] ?>" data-t="<?= $c['t'] ?>" data-txt="<?= htmlspecialchars($c['x']) ?>" onclick="voltear(this)">✨ RECT</div>
        <?php endforeach; ?>
    </div>
    <div id="feedback" style="margin:10px; font-weight:bold; min-height:20px; color:#00ffff;"></div>
    <button onclick="location.reload()" class="btn">RELOAD 🔄</button>
    <button onclick="location.href='../plataforma.php?tab=juegos'" class="btn" style="border-color:#555; color:#555;">EXIT 🚪</button>
</div>
<script>
const audio = {
    play: (f, t) => {
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        const o = ctx.createOscillator(), g = ctx.createGain(); o.type = t;
        f.forEach((freq, i) => o.frequency.setValueAtTime(freq, ctx.currentTime + (i * 0.1)));
        g.gain.setValueAtTime(0.1, ctx.currentTime); g.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.3);
        o.connect(g); g.connect(ctx.destination); o.start(); o.stop(ctx.currentTime + 0.3);
    }
};
let pts = parseInt(sessionStorage.getItem('sabiduria_puntos')) || 0;
document.getElementById('marcador').innerText = pts;
let vol = [], block = false, hits = 0;

function voltear(c) {
    if (block || c.classList.contains('volteada')) return;
    c.classList.add('volteada'); if(c.dataset.t==='r') c.classList.add('r-estilo');
    c.innerText = c.dataset.txt; vol.push(c);
    if (vol.length === 2) {
        block = true;
        const [c1, c2] = vol, f = document.getElementById('feedback');
        if (c1.dataset.id === c2.dataset.id && c1.dataset.t !== c2.dataset.t) {
            audio.play([523, 659, 783], 'sine'); pts += 10;
            sessionStorage.setItem('sabiduria_puntos', pts);
            document.getElementById('marcador').innerText = pts;
            c1.classList.add('emparejada'); c2.classList.add('emparejada');
            f.innerHTML = "✨ ¡Correcto! +10 PTS 🍍"; hits++; vol = []; block = false;
            if (hits === <?= count($conceptos) ?>) f.innerHTML = "🎉 ¡Mosaico Completado! 🌟";
        } else {
            audio.play([150, 80], 'sawtooth'); f.innerHTML = "❌ ¡No corresponden!";
            setTimeout(() => {
                c1.classList.remove('volteada', 'r-estilo'); c2.classList.remove('volteada', 'r-estilo');
                c1.innerText = '✨ RECT'; c2.innerText = '✨ RECT'; vol = []; block = false; f.innerHTML = "";
            }, 1000);
        }
    }
}
</script>
</body>
</html>

