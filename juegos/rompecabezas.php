<?php
session_start();
$nombre_alumno = isset($_SESSION['alumno_nombre']) ? $_SESSION['alumno_nombre'] : "Explorador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Rompecabezas Mágico de Donají</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background: linear-gradient(135deg, #1A0F08, #361A0C, #1A0F08); text-align: center; color: #FECE79; margin: 0; padding: 15px; }
        h2, h4 { font-family: 'Fredoka One', cursive; color: #FECE79; text-shadow: 2px 2px 4px #000; }
        h2 { font-size: 24px; margin: 10px 0; }
        .letrero { position: fixed; top: 50%; left: 50%; transform: translate(-50%,-50%); display: none; z-index: 100; }
        .letrero img { max-width: 320px; border-radius: 20px; box-shadow: 0 20px 40px #000; }
        .opciones { display: flex; flex-direction: column; gap: 8px; max-width: 480px; margin: 0 auto 15px; }
        button { font-family: 'Quicksand', sans-serif; padding: 12px; font-size: 16px; font-weight: bold; cursor: pointer; border: 3px solid #8C0902; border-radius: 20px; background: #FFFBF2; color: #361A0C; border-bottom: 6px solid #5C0501; box-shadow: 0 5px 10px rgba(0,0,0,0.3); transition: all 0.1s; }
        button:hover { background: #FECE79; transform: translateY(-2px); border-bottom-width: 7px; }
        button:active { transform: translateY(4px); border-bottom-width: 2px; }
        button.bien { background: #2E7D32 !important; color: white !important; border-color: #1B5E20 !important; border-bottom-color: #0D2E11 !important; }
        button.mal { background: #C62828 !important; color: white !important; border-color: #B71C1C !important; border-bottom-color: #5F0C0C !important; }
        .juego { display: flex; justify-content: center; gap: 25px; flex-wrap: wrap; }
        #baul { background: rgba(43, 26, 17, 0.7); border: 4px dashed #FECE79; min-width: 210px; max-width: 230px; min-height: 350px; padding: 10px; border-radius: 25px; display: flex; gap: 5px; flex-wrap: wrap; align-content: flex-start; justify-content: center; box-shadow: inset 0 6px 12px #000; }
        .tablero { display: grid; grid-template-columns: repeat(5, 68px); gap: 2px; background: #2A1408; padding: 6px; width: 348px; height: 348px; border-radius: 25px; border: 4px solid #8C0902; box-shadow: 0 15px 30px #000, inset 0 0 20px #000; position: relative; }
/* 🚪 BOTÓN DE SALIR INTERACTIVO EN LA ESQUINA INFERIOR */
.btn-salir-esquina {
    position: fixed;
    bottom: 25px;
    right: 25px;
    font-family: 'Fredoka One', cursive;
    background: #8C0902; /* Tu rojo oaxaqueño */
    color: #FFFBF2;
    border: none;
    border-bottom: 4px solid #4A0502; /* Relieve de botoncito */
    padding: 12px 22px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 15px;
    cursor: pointer;
    box-shadow: 0 6px 12px rgba(0,0,0,0.4);
    z-index: 1000;
    transition: all 0.1s ease;
}

.btn-salir-esquina:hover {
    background: #B14A36;
    transform: translateY(-2px);
}

.btn-salir-esquina:active {
    transform: translateY(2px);
    border-bottom-width: 1px;
}

        /* DISEÑO BASE DE LA CASILLA DEL TABLERO */
.casilla {
    background: rgba(43, 22, 10, 0.4); /* Un tono café transparente y místico */
    border: 1px solid rgba(254, 206, 121, 0.2); /* Borde dorado sutil */
    border-radius: 8px;
    width: 68px;
    height: 68px;
    box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.5); /* Efecto hundido para simular hueco */
    transition: all 0.3s ease; /* Movimiento suave y fluido */
    position: relative;
    overflow: hidden;
}
/* FONDO MÍSTICO QUE CUBRE LA PLATAFORMA */
.modal-oculto {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(26, 15, 8, 0.85);
    display: flex; justify-content: center; align-items: center;
    z-index: 9999;
    opacity: 0; pointer-events: none;
    transition: opacity 0.5s ease-in-out;
}

/* CUANDO SE ACTIVA EL LETRERO */
.modal-oculto.mostrar {
    opacity: 1;
    pointer-events: auto;
}

/* LA TARJETA EN TONOS CREMA Y BORDES DORADOS */
.tarjeta-victoria {
    background: #FFFBF2;
    border: 6px solid #E6A341;
    border-radius: 30px;
    padding: 40px 30px;
    text-align: center;
    max-width: 450px;
    width: 90%;
    box-shadow: 0 20px 50px rgba(0,0,0,0.8);
    transform: scale(0.7);
    transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.modal-oculto.mostrar .tarjeta-victoria {
    transform: scale(1); /* Efecto rebote interactivo */
}

.tarjeta-victoria h2 {
    color: #8C0902;
    font-size: 32px;
    margin-bottom: 15px;
}

.tarjeta-victoria p {
    color: #361A0C;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 25px;
}

/* BOTONES ESTILO MAQUINITA */
.tarjeta-victoria button {
    font-family: 'Fredoka One', cursive;
    background: #8C0902;
    color: #FFFBF2;
    border: none;
    border-bottom: 4px solid #4A0502;
    padding: 12px 24px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 15px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.1s ease;
    margin: 5px;
    width: 80%;
}

.tarjeta-victoria button:hover {
    background: #B14A36;
    transform: translateY(-2px);
}

.tarjeta-victoria button:active {
    transform: translateY(2px);
    border-bottom-width: 1px;
}

/* EFECTO DE ACCIÓN: CUANDO EL NIÑO PASA EL MOUSE POR ENCIMA */
.casilla:hover {
    background: rgba(230, 163, 65, 0.15); /* Destello ámbar transparente */
    border-color: #FECE79; /* Resalta el borde en color oro */
    box-shadow: 0 0 10px rgba(230, 163, 65, 0.4); /* Resplandor mágico */
    transform: scale(1.03); /* Crece sutilmente */
}

/* EFECTO DE INTERACCIÓN: CUANDO LLEVAS LA PIEZA VOLANDO SOBRE LA CASILLA */
.casilla-activa {
    background: rgba(230, 163, 65, 0.4) !important; /* Brillo más fuerte */
    border: 2px dashed #FECE79 !important; /* Borde punteado divertido */
    transform: scale(1.08); /* Se expande indicando que ahí puede soltar la pieza */
}
.pieza { width: 68px; height: 68px; cursor: grab; border-radius: 8px; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.4); }
    </style>
</head>
<body>
    <audio id="musica" src="../sonido/dios.mp3" loop autoplay></audio>
    <div id="ok" class="letrero"><img src="../correcta.png"></div>
    <div id="no" class="letrero"><img src="../incorrecta.png"></div>

    <h2 id="txt-preg">¡Prepara tu mente mística!...</h2>
    <div class="opciones" id="box-opc"></div>

    <div class="juego">
        <div><h4>🎒 Tu Baúl de Piezas</h4><div id="baul" ondragover="event.preventDefault()" ondrop="drop(event)"></div></div>
        <div><h4>🗺️ Tablero</h4><div class="tablero" id="tab-pro"></div></div>
    </div>
<!-- PANTALLA FLOTANTE DE FELICITACIONES (ROMPECABEZAS) -->
<div id="pantalla-ganador" class="modal-oculto">
    <div class="tarjeta-victoria">
        <h2>¡Felicidades, Explorador! 👑🧩</h2>
        <p>¡Increíble! Lograste responder correctamente y armaste por completo el rompecabezas de la Princesa Donají.</p>
        <button onclick="window.location='menu_juegos.php'">Volver a los Juegos 🎮</button>
        <button onclick="location.reload()" style="background: #2D93AD; border-color: #1E6B7E; margin-top: 10px;">Jugar de nuevo 🔄</button>
    </div>
</div>

    <script>
        const alumnoActual = "<?php echo $nombre_alumno; ?>";

        const bancoPreguntas = [
            { q: "Quién era la valiente princesa zapoteca que se convirtió en lirio?", o: ["Donají", "La Llorona", "Mayahuel"], c: 0 },
            { q: "¿De qué región de Oaxaca es originaria esta mística leyenda?", o: ["La Costa", "El Istmo", "Valles Centrales"], c: 2 },
            { q: "¿Qué flor nació donde enterraron la cabeza de la princesa?", o: ["Un Lirio Silvestre", "Un Cempasúchil", "Una Rosa"], c: 0 },
            { q: "¿Con qué pueblo guerrero se enfrentaron los Zapotecas?", o: ["Los Mixtecas", "Los Aztecas", "Los Mayas"], c: 0 },
            { q: "¿Qué río oaxaqueño fue testigo de las batallas?", o: ["Río Papaloapan", "Río Atoyac", "Río Verde"], c: 1 },
            { q: "¿Quién era el príncipe mixteco del que se enamoró Donají?", o: ["Príncipe Nucano", "Cosijopí", "Ocho Venado"], c: 0 },
            { q: "¿Cómo se llamaba el rey zapoteca, padre de Donají?", o: ["Cocijoeza", "Condoy", "Nucano"], c: 0 },
            { q: "¿Qué significa el nombre de la Princesa Donají?", o: ["Flor de oro", "Alma valiosa", "Lirio del río"], c: 1 },
            { q: "¿En qué antiguo escudo oaxaqueño aparece hoy la cabeza de Donají?", o: ["Escudo de Oaxaca de Juárez", "Escudo de Mitla", "Escudo de Monte Albán"], c: 0 },
            { q: "¿Qué ciudad prehispánica defendió el Príncipe Nucano?", o: ["Monte Albán", "Zaachila", "Cuilápam"], c: 2 },
            { q: "¿Por qué Donají fue llevada como rehén por los mixtecas?", o: ["Para asegurar la paz", "Para una fiesta", "Para que fuera reina"], c: 0 },
            { q: "¿Qué ciudad zapoteca era el hogar principal de la familia de Donají?", o: ["Mitla", "Zaachila", "Yagul"], c: 1 },
            { q: "¿En qué época del año se presenta el ballet de Donají en Oaxaca?", o: ["En Navidad", "En la Guelaguetza", "En Día de Muertos"], c: 1 },
            { q: "¿Quién descubrió el lirio intacto con la cabeza de Donají en el río?", o: ["Un tlacuache", "Un pastor", "Un guerrero mixteca"], c: 1 },
            { q: "¿Qué causó que los mixtecas sacrificaran a la princesa?", o: ["Avisó a los zapotecas", "Se escapó de noche", "No quiso casarse"], c: 0 },
            { q: "¿Dónde descansan actualmente los restos de Donají y Nucano?", o: ["En el Templo de Cuilápam", "En Monte Albán", "En la Catedral de Oaxaca"], c: 0 },
            { q: "¿Qué deidad zapoteca predijo un destino trágico en el nacimiento de Donají?", o: ["Los sacerdotes de Mitla", "El Dios Pitao", "Un anciano sabio"], c: 0 },
            { q: "Qué animal sagrado cuidaba el entorno espiritual de la princesa?", o: ["Un jaguar", "Un águila", "Un colibrí"], c: 0 }
        ];

        let preguntasDisponibles = [...bancoPreguntas];
        let piezas = Array.from({length: 25}, (_, i) => (i + 1).toString()), preg;

const t = document.getElementById('tab-pro'); // Buscamos tu ID original
for (let i = 1; i <= 25; i++) {
    const c = document.createElement('div');
    c.className = 'casilla';
    c.dataset.p = i;
    c.id = `casilla-${i}`;
    
    // Tus eventos de arrastre limpios
    c.addEventListener('dragenter', (e) => e.target.classList.add('casilla-activa'));
    c.addEventListener('dragleave', (e) => e.target.classList.remove('casilla-activa'));
    c.addEventListener('dragover', (e) => e.preventDefault());
    c.addEventListener('drop', drop);
    
    t.appendChild(c);
}


        window.onload = () => { setTimeout(next, 1600); document.body.onclick = () => document.getElementById('musica').play(); };

        function next() {
            if (!piezas.length) { document.getElementById('txt-preg').innerText = "¡Ganaste todas las piezas, " + alumnoActual + "! ¡A armar! 🏆"; document.getElementById('box-opc').innerHTML = ""; return; }
            if (preguntasDisponibles.length === 0) preguntasDisponibles = [...bancoPreguntas];

            let idx = Math.floor(Math.random() * preguntasDisponibles.length);
            preg = preguntasDisponibles.splice(idx, 1)[0];

            document.getElementById('txt-preg').innerText = preg.q;
            const box = document.getElementById('box-opc'); box.innerHTML = "";
            preg.o.forEach((opc, i) => {
                const b = document.createElement('button'); b.innerText = opc;
                b.onclick = () => {
                    document.querySelectorAll('.opciones button').forEach(btn => btn.style.pointerEvents = 'none');
                                   if (i === preg.c) {
                    b.classList.add('bien');
                    let idxPz = Math.floor(Math.random() * piezas.length);
let pz = piezas.splice(idxPz, 1)[0]; // El [0] extrae el número limpio del arreglo
let img = document.createElement('img'); img.src = `../img_rompecabezas/${pz}.jpg`;
 img.id = `p-${pz}`; img.className = 'pieza'; img.draggable = true; img.dataset.p = pz;
                        img.ondragstart = (dt) => dt.dataTransfer.setData("text", dt.target.id);
                        document.getElementById('baul').appendChild(img);
                    } else { b.classList.add('mal'); document.querySelectorAll('.opciones button')[preg.c].classList.add('bien'); flash('no'); }
                    setTimeout(next, 1600);
                };
                box.appendChild(b);
            });
        }

        function flash(id) { let el = document.getElementById(id); el.style.display = 'block'; setTimeout(() => el.style.display = 'none', 1200); }

        function drop(e) {
            e.preventDefault();
            let img = document.getElementById(e.dataTransfer.getData("text")), d = e.target;
            if (d.classList.contains('casilla')) d.classList.remove('casilla-activa');
            if (d.classList.contains('casilla') && d.dataset.p === img.dataset.p) {
                d.appendChild(img); img.draggable = false;
                    if(document.querySelectorAll('.casilla .pieza').length === 25) {
            document.getElementById('pantalla-ganador').classList.add('mostrar');
        }} }
    </script>

<!-- PANTALLA FLOTANTE DE FELICITACIONES COMPLETA -->
<div id="pantalla-ganador" class="modal-oculto">
    <div class="tarjeta-victoria">
        <h2>¡Felicidades, Explorador! 👑🧩</h2>
        <p>¡Increíble! Lograste responder correctamente y armaste por completo el rompecabezas de la Princesa Donají.</p>
              <button onclick="window.location.href='../plataforma.php?tab=juegos'">Volver a los Juegos 🎮</button>
        <button onclick="window.location.reload()" style="background: #2D93AD; border-color: #1E6B7E; margin-top: 10px;">Jugar de nuevo 🔄</button>
    </div>
</div>

<!-- 🚪 ¡AQUÍ VA TU BOTÓN DE SALIR EN LA ESQUINA INFERIOR! -->
<button class="btn-salir-esquina" onclick="window.location.href='../plataforma.php?tab=juegos'">Salir 🚪</button>

</body>
</html>
