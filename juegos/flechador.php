<?php 
session_start(); 
$n = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador"; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Flechador PRO</title>
    <style>
        @font-face { font-family: 'CF'; src: url('fuentes/Childer.otf') format('opentype'); }
        body { font-family: 'CF', sans-serif; background: #1A0F08; margin: 0; overflow: hidden; color: #FECE79; text-align: center; }
        #arena { position: relative; width: 700px; height: 500px; background: linear-gradient(#361A0C, #5C3A21); border: 6px solid #E6A341; border-radius: 25px; margin: 30px auto 10px auto; overflow: hidden; cursor: crosshair; box-shadow: 0 15px 35px rgba(0,0,0,0.6); }
        #marcador { position: absolute; top: 15px; left: 20px; font-size: 24px; color: #FFFBF2; text-shadow: 2px 2px #000; }
        #jefe-sol { position: absolute; top: 40px; left: 320px; font-size: 60px; z-index: 5; }
        #guerrero { position: absolute; bottom: 10px; left: 325px; font-size: 55px; transform-origin: center bottom; z-index: 6; }
        .fl-disp { position: absolute; font-size: 30px; z-index: 4; transform: rotate(-45deg); }
        .modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(16, 9, 5, 0.95); display: flex; justify-content: center; align-items: center; z-index: 1500; }
        .tarjeta { background: #FFFBF2; border: 5px solid #E6A341; border-radius: 30px; padding: 25px; width: 85%; max-width: 440px; color: #361A0C; }
        .opc-btn, .btn-salir { font-family: 'CF', sans-serif; font-weight: bold; cursor: pointer; border-radius: 12px; }
        .opc-btn { display: block; width: 100%; padding: 12px; margin: 10px 0; background: #361A0C; color: #FFFBF2; border: none; font-size: 18px; }
        .opc-btn:hover { background: #8C0902; }
        .btn-salir { background: #8C0902; color: #FFFBF2; border: none; padding: 12px 25px; font-size: 16px; margin-top: 10px; }
        #feedback { display: none; position: fixed; top: 35%; left: 50%; transform: translate(-50%, -50%); padding: 15px 30px; border-radius: 15px; font-size: 30px; font-weight: bold; color: #FFFBF2; z-index: 2000; text-shadow: 2px 2px 5px #000; font-family: 'CF', sans-serif; }
    </style>
</head>
<body>
    <audio id="musica" src="musica_flechador.mp3" loop></audio>
    <div id="arena">
        <div id="marcador">Flechazos: <span id="puntos">0</span>/5</div>
        <div id="jefe-sol">☀️</div><div id="guerrero">🏹</div>
    </div>
    <button class="btn-salir" onclick="salir()">🚪 Salir a Juegos</button>

    <div id="m-inst" class="modal"><div class="tarjeta">
        <h2>🏹 Batalla Mixteca PRO ☀️</h2>
        <p>¡Hola, <strong><?= htmlspecialchars($n) ?></strong>! Mueve el ratón para apuntar el arco y haz clic izquierdo para disparar al Sol en movimiento.</p>
        <button class="opc-btn" style="background:#8C0902" onclick="iniciar()">🔥 ¡Iniciar!</button>
    </div></div>

    <div id="feedback"></div>

    <div id="m-preg" class="modal" style="display:none;"><div class="tarjeta">
        <h3>🔥 Reto Ancestral 🔥</h3><p id="txt-preg" style="font-weight:bold; font-size:20px;"></p><div id="opts"></div>
    </div></div>

    <div id="m-fin" class="modal" style="display:none;"><div class="tarjeta">
        <h2>👑 ¡Héroe Mixteco! 👑</h2><p>¡Venciste al Sol con tu gran puntería y sabiduría!</p>
        <button class="opc-btn" onclick="location.reload()">🔄 Reiniciar</button>
        <button class="btn-salir" onclick="salir()">Ir a Juegos</button>
    </div></div>

    <script>
        let juego = false, aciertos = 0, idx = 0, pregAct = {}, solX = 320, solDir = 1, solSpd = 4, bucleSol;
        const arena = document.getElementById('arena'), sol = document.getElementById('jefe-sol'), g = document.getElementById('guerrero'), fdb = document.getElementById('feedback');

        const preguntas = [
            { p: "¿A qué región de Oaxaca pertenece la leyenda del Flechador del Sol?", o: ["La Mixteca", "El Istmo", "Valles Centrales"], c: 0 },
            { p: "¿Contra quién peleaba el valiente guerrero mixteco?", o: ["Un jaguar", "El Sol", "Un río místico"], c: 1 },
            { p: "¿Por qué peleaba el guerrero contra el Sol?", o: ["Porque era dueño de las tierras", "Para salvar una princesa", "Por su oro"], c: 0 },
            { p: "¿Qué usó el guerrero para vencer al Sol al atardecer?", o: ["Espada de obsidiana", "Flechas sagradas", "Escudo de oro"], c: 1 },
            { p: "¿Qué representan las nubes de colores al atardecer?", o: ["Polvo", "La sangre del Sol herido", "Neblina"], c: 1 }
        ];

        function mezclar(arr) { for (let i = arr.length - 1; i > 0; i--) { const j = Math.floor(Math.random() * (i + 1)); [arr[i], arr[j]] = [arr[j], arr[i]]; } }
        mezclar(preguntas);

        arena.addEventListener('mousemove', (e) => {
            if (!juego) return;
            const r = arena.getBoundingClientRect();
            g.style.transform = `rotate(${Math.atan2(e.clientX - r.left - 352, r.bottom - e.clientY - 10) * (180 / Math.PI)}deg)`;
        });

        arena.addEventListener('click', (e) => {
            if (!juego) return;
            const r = arena.getBoundingClientRect(), fl = document.createElement('div');
            fl.className = 'fl-disp'; fl.innerHTML = '🏹'; fl.style.left = '340px'; fl.style.top = '430px'; arena.appendChild(fl);
            let fX = 340, fY = 430, ang = Math.atan2(e.clientY - r.top - 430, e.clientX - r.left - 340), sX = Math.cos(ang) * 14, sY = Math.sin(ang) * 14;

            let col = setInterval(() => {
                if (!juego) { clearInterval(col); fl.remove(); return; }
                fX += sX; fY += sY; fl.style.left = fX + 'px'; fl.style.top = fY + 'px';
                if (fY < (sol.offsetTop + 55) && fY > sol.offsetTop && fX > sol.offsetLeft && fX < (sol.offsetLeft + 55)) { 
                    clearInterval(col); fl.remove(); lanzarPreg(); 
                }
                if (fY < 0 || fY > 500 || fX < 0 || fX > 700) { clearInterval(col); fl.remove(); }
            }, 20);
        });

        function iniciar() { document.getElementById('m-inst').style.display = 'none'; document.getElementById('musica').play().catch(()=>{}); juego = true; bucleSol = setInterval(moverSol, 20); }
        function moverSol() { solX += solDir * (solSpd + aciertos * 0.9); if (solX > 630 || solX < 10) solDir *= -1; sol.style.left = solX + 'px'; }

        function lanzarPreg() {
            juego = false; clearInterval(bucleSol); document.querySelectorAll('.fl-disp').forEach(f => f.remove());
            if (idx >= preguntas.length) { mezclar(preguntas); idx = 0; }
            pregAct = preguntas[idx]; document.getElementById('txt-preg').innerText = pregAct.p;
            const box = document.getElementById('opts'); box.innerHTML = '';
            pregAct.o.forEach((opc, i) => {
                const btn = document.createElement('button'); btn.className = 'opc-btn'; btn.innerText = opc; btn.onclick = () => revisar(i); box.appendChild(btn);
            });
            document.getElementById('m-preg').style.display = 'flex';
        }

        function revisar(i) {
            document.getElementById('m-preg').style.display = 'none';
            if (i === pregAct.c) { aciertos++; document.getElementById('puntos').innerText = aciertos; msg('¡FLECHAZO DIRECTO! 🏹☀️', '#4caf50'); }
            else { msg('¡INCORRECTO! El Sol se recupera ☀️', '#8C0902'); }
            idx++;
            if (aciertos === 5) { setTimeout(() => document.getElementById('m-fin').style.display = 'flex', 1800); } 
            else { setTimeout(() => { juego = true; bucleSol = setInterval(moverSol, 20); }, 2000); }
        }

        function msg(t, c) { fdb.innerText = t; fdb.style.backgroundColor = c; fdb.style.display = 'block'; setTimeout(() => fdb.style.display = 'none', 1800); }
        function salir() { let a = document.getElementById('musica'); if (a) a.pause(); window.location.href = '../plataforma.php?tab=juegos'; }
    </script>
</body>
</html>

