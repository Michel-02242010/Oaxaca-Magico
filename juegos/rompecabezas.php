<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Rompecabezas Mágico de Donají - 25 Piezas</title>
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Fredoka+One&family=Quicksand:wght@700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Quicksand', sans-serif; 
            background: linear-gradient(135deg, #F4EBE1, #E6D5C3); 
            text-align: center; 
            color: #4A3525; 
            margin: 0; 
            padding: 10px; 
        }

        h2 {
            font-family: 'Fredoka One', cursive;
            color: #8C0902;
            text-shadow: 1px 1px 0px #FFF;
        }

        /* 📜 Contenedor para mostrar tus pergaminos en grande en el centro */
        .letrero-pergamino { 
            position: fixed; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%) scale(0.7); 
            display: none; 
            z-index: 100; 
            animation: aparecerRapido 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
        .letrero-pergamino img {
            max-width: 380px;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(54, 26, 12, 0.4);
        }
        @keyframes aparecerRapido {
            to { transform: translate(-50%, -50%) scale(1); }
        }

        /* 🗂️ Caja de Opciones de Respuestas */
        .opciones { 
            display: flex; 
            flex-direction: column; 
            gap: 10px; 
            max-width: 500px; 
            margin: 0 auto 20px auto; 
        }
        button { 
            font-family: 'Quicksand', sans-serif;
            padding: 12px; 
            font-size: 16px; 
            font-weight: bold; 
            cursor: pointer; 
            border: 3px solid #8C0902; 
            border-radius: 15px; 
            background: #fff; 
            color: #4A3525; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: 0.2s; 
        }
        button:hover { 
            background: #FECE79; 
            transform: scale(1.02); 
        }
        
        /* 🎪 Zona del Juego Interactiva */
        .juego { 
            display: flex; 
            justify-content: center; 
            gap: 30px; 
            margin-top: 10px; 
            flex-wrap: wrap; 
        }
        
        h4 {
            font-family: 'Fredoka One', cursive;
            color: #361A0C;
            margin: 5px 0;
        }

        /* Baúl de Piezas Ganadas */
        #baul { 
            background: #EEDCC8; 
            border: 3px dashed #8C0902; 
            min-width: 220px; 
            max-width: 240px; 
            min-height: 358px; 
            padding: 10px; 
            border-radius: 20px; 
            display: flex; 
            gap: 6px; 
            flex-wrap: wrap; 
            align-content: flex-start; 
            justify-content: center; 
            overflow-y: auto; 
            box-shadow: inset 0 4px 8px rgba(0,0,0,0.05);
        }
        
        /* Tablero de 5x5 */
        .tablero { 
            display: grid; 
            grid-template-columns: repeat(5, 70px); 
            grid-template-rows: repeat(5, 70px); 
            gap: 2px; 
            background: #361A0C; 
            padding: 5px; 
            width: 358px; 
            height: 358px; 
            border-radius: 20px; 
            box-shadow: 0 8px 16px rgba(54, 26, 12, 0.2); 
        }
        .casilla { 
            background: rgba(255, 255, 255, 0.12); 
            width: 70px; 
            height: 70px; 
            border-radius: 6px; 
        }
        .pieza { 
            width: 70px; 
            height: 70px; 
            cursor: grab; 
            border-radius: 6px; 
            object-fit: cover; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        }
        .pieza:active { cursor: grabbing; }
    </style>
</head>
<body>

    <!-- Tu música de fondo tradicional automatizada -->
    <audio id="musica" src="dios.mp3" loop autoplay></audio>
    
    <!-- Tus imágenes fijas de pergaminos cargando desde tu carpeta -->
    <div id="ok" class="letrero-pergamino"><img src="correcta.png" alt="¡Respuesta Correcta!"></div>
    <div id="no" class="letrero-pergamino"><img src="incorrecta.png" alt="¡Respuesta Incorrecta!"></div>

    <h2 id="txt-preg">Cargando desafío...</h2>
    <div class="opciones" id="box-opc"></div>

    <div class="juego">
        <div>
            <h4>🎒 Tu Baúl de Piezas</h4>
            <div id="baul" ondragover="event.preventDefault()" ondrop="drop(event)"></div>
        </div>
        <div>
            <h4>🖼️ Tablero Mágico (5x5)</h4>
            <div class="tablero" id="tablero-pro"></div>
        </div>
    </div>

    <script>
        // Banco de preguntas de la historia de la Princesa Donají
        const preguntas = [
            { q: "¿Quién era la princesa zapoteca que se convirtió en lirio?", o: ["Donají", "Mayahuel", "Iztaccíhuatl"], c: 0 },
            { q: "¿De qué región de Oaxaca es la Leyenda de Donají?", o: ["La Costa", "Valles Centrales", "El Istmo"], c: 1 },
            { q: "¿Flor que nació donde enterraron a Donají?", o: ["Un Lirio", "Cempasúchil", "Rosa"], c: 0 },
            { q: "¿Con qué cultura pelearon los Zapotecas?", o: ["Mixtecas", "Aztecas", "Mayas"], c: 0 },
            { q: "¿Qué río oaxaqueño aparece en la historia?", o: ["Papaloapan", "Río Atoyac", "Río Balsas"], c: 1 },
            { q: "¿Qué significa el nombre de Donají?", o: ["Alma grande", "Flor de lirio", "Alma valiosa"], c: 2 },
            { q: "¿Quién era el príncipe mixteco del que se enamoró?", o: ["Nucano", "Cosijopí", "Ocho Venado"], c: 0 },
            { q: "¿Cómo se llamaba el padre de la Princesa Donají?", o: ["Cocijoeza", "Teozacualco", "Condoy"], c: 0 },
            { q: "En la actualidad, ¿dónde está grabado el escudo con la cabeza de Donají?", o: ["Ayuntamiento de Oaxaca de Juárez", "En un museo de CDMX", "En las iglesias de Mitla"], c: 0 },
            { q: "¿Qué ciudad zapoteca era el centro de poder de su padre?", o: ["Mitla", "Zaachila", "Monte Albán"], c: 1 }
        ];

        // Lista del 1 al 25 que coincide exactamente con tus archivos 1.jpg, 2.jpg...
        let piezas = Array.from({length: 25}, (_, i) => (i + 1).toString());
        let preg;

        // Generar las 25 casillas del tablero con su número identificador
        const tableroPro = document.getElementById('tablero-pro');
        for (let i = 1; i <= 25; i++) {
            const casilla = document.createElement('div');
            casilla.className = 'casilla';
            casilla.dataset.p = i;
            casilla.id = `casilla-${i}`;
            casilla.setAttribute('ondragover', 'event.preventDefault()');
            casilla.setAttribute('ondrop', 'drop(event)');
            tableroPro.appendChild(casilla);
        }

        window.onload = () => { 
            next(); 
            document.body.onclick = () => document.getElementById('musica').play(); 
        };

        function next() {
            if (!piezas.length) { 
                document.getElementById('txt-preg').innerText = "¡Felicidades! Tienes las 25 piezas desparramadas en el baúl. ¡Completa el rompecabezas! 🏆"; 
                document.getElementById('box-opc').innerHTML = "";
                return; 
            }
            preg = preguntas[Math.floor(Math.random() * preguntas.length)];
            document.getElementById('txt-preg').innerText = preg.q;
            const box = document.getElementById('box-opc'); box.innerHTML = "";
            
            preg.o.forEach((opc, i) => {
                const b = document.createElement('button'); b.innerText = opc;
                b.onclick = () => {
                    if (i === preg.c) {
                        alertFlash('ok');
                        // Elige una pieza al azar de tu lista numérica
                        let pz = piezas.splice(Math.floor(Math.random() * piezas.length), 1);
                        
                        // Creación y asignación de tu imagen correspondiente (ejemplo: 12.jpg)
                        let img = document.createElement('img'); 
                        img.src = `${pz}.jpg`; 
                        img.id = `p-${pz}`; 
                        img.className = 'pieza'; 
                        img.draggable = true; 
                        img.dataset.p = pz;
                        img.ondragstart = (e) => e.dataTransfer.setData("text", e.target.id);
                        
                        document.getElementById('baul').appendChild(img);
                    } else { 
                        alertFlash('no'); 
                        alert(`¡Cerca! La respuesta correcta era: ${preg.o[preg.c]}`); 
                    }
                    setTimeout(next, 1500); 
                };
                box.appendChild(b);
            });
        }

        function alertFlash(id) {
            let el = document.getElementById(id); el.style.display = 'block';
            setTimeout(() => el.style.display = 'none', 1300); 
        }

        function drop(e) {
            e.preventDefault();
            let img = document.getElementById(e.dataTransfer.getData("text"));
            let destino = e.target;

            // Inserta la imagen si el número de la casilla coincide con el dataset del archivo gráfico
            if (destino.classList.contains('casilla') && destino.dataset.p === img.dataset.p) {
                destino.appendChild(img);
                img.draggable = false; 
                if(document.querySelectorAll('.casilla .pieza').length === 25) {
                    setTimeout(() => alert("¡Increíble trabajo! Has terminado el rompecabezas entero. 🎉✨"), 300);
                }
            } 
            // Si la regresa al contenedor del baúl
else if (destino.id === 'baul') {
destino.appendChild(img);
}
}