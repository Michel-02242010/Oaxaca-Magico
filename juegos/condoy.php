<?php session_start();
$name = $_SESSION['alumno_nombre'] ?? "Explorador";
$qa = [
    ["q" => "El Rey Condoy es el máximo héroe mitológico de un pueblo oaxaqueño muy importante. ¿Cuál es?", "c" => "El pueblo Mixe (los jamás conquistados)", "i" => "El pueblo Zapoteco de los valles"],
    ["q" => "¿Qué poder asombroso tenía el Rey Condoy según los relatos de la Sierra Norte?", "c" => "Podía construir palacios y mover cerros en una noche", "i" => "Podía transformarse en un jaguar de fuego"],
    ["q" => "La majestuosa Sierra Norte es el hogar de Condoy. ¿Qué tipo de naturaleza la caracteriza?", "c" => "Bosques templados llenos de neblina y árboles altos", "i" => "Grandes desiertos áridos con nopales"]
];
$item = $qa[array_rand($qa)];
$opts = [["t" => $item["c"], "ok" => "true"], ["t" => $item["i"], "ok" => "false"]];
shuffle($opts); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Rey Condoy</title>
    <style>
        body { background: #1a0f08; color: #fff; font-family: sans-serif; text-align: center; padding: 15px; }
        .inst { border: 1px dashed #e6a341; padding: 12px; margin: 10px auto; max-width: 600px; color: #fece79; text-align: left; font-size: 13px; }
        .tablero { background: #2c160a; border: 2px dashed #e6a341; padding: 15px; margin: 15px auto; max-width: 600px; display: flex; justify-content: center; }
        .domino { display: flex; width: 300px; height: 100px; border: 2px solid #79380b; background: #fffbf2; color: #361a0c; border-radius: 10px; }
        .mitad { flex: 1; display: flex; align-items: center; justify-content: center; padding: 10px; font-size: 12px; font-weight: bold; }
        .vacia { background: #1b110b; color: #fece79; font-size: 24px; border-left: 2px dashed #79380b; }
        .correcta { background: #fece79; color: #8c0902; border-left: 2px dashed #79380b; }
        .arrastrable { cursor: grab; margin: 10px; }
        .btn { padding: 10px 20px; background: #8c0902; color: #fff; border: none; border-radius: 8px; cursor: pointer; margin: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>👑 EL REY CONDOY (Puntos: <span id="pts">0</span>)</h2>
    <h3>¡Hola, <?=htmlspecialchars($name)?>!</h3>

    <div class="inst">
        📌 <strong>REGLAS:</strong> Arrastra una de las fichas de abajo y suéltala directamente sobre el espacio con el signo <strong>"?"</strong> si consideras que completa correctamente la pregunta de la leyenda.
    </div>

    <div class="tablero" ondragover="event.preventDefault()" ondrop="drop(event)">
        <div class="domino">
            <div class="mitad"><?=$item['q']?></div>
            <div class="vacia" id="zona">?</div>
        </div>
    </div>

    <div style="display:flex; justify-content:center;" id="opts">
        <?php foreach($opts as $i => $o): ?>
            <div class="domino arrastrable" id="op-<?=$i?>" draggable="true" data-ok="<?=$o['ok']?>" ondragstart="e=>e.dataTransfer.setData('text',e.target.id)">
                <div class="mitad" style="background:#8c0902; color:#fff; max-width:35px;">🛡️</div>
                <div class="mitad txt"><?=$o['t']?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <p id="fb" style="font-weight:bold; font-size:16px;"></p>
    <button class="btn" onclick="location.reload()">Siguiente 🔄</button>
    <button class="btn" style="background:#441004" onclick="location.href='../plataforma.php?tab=juegos'">Salir 🚪</button>

    <script>
    let pts = parseInt(sessionStorage.getItem('sabiduria_puntos')) || 0;
    document.getElementById('pts').innerText = pts;

    function drop(e) {
        e.preventDefault();
        let el = document.getElementById(e.dataTransfer.getData("text"));
        if (!el) return;
        
        if (el.getAttribute('data-ok') === "true") {
            pts += 10;
            sessionStorage.setItem('sabiduria_puntos', pts);
            document.getElementById('pts').innerText = pts;
            document.getElementById('fb').style.color = "#fece79";
            document.getElementById('fb').innerText = "🔥 ¡CORRECTO! +10 PUNTOS 🎉";
            document.getElementById('zona').className = "mitad correcta";
            document.getElementById('zona').innerText = el.querySelector('.txt').innerText;
            document.getElementById('opts').style.display = "none";
        } else {
            document.getElementById('fb').style.color = "#ff4d4d";
            document.getElementById('fb').innerText = "❌ ¡Esa pieza no encaja! Intenta de nuevo.";
        }
    }
    </script>
</body>
</html>
