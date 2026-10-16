<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Memorama Ancestral - La Llorona del Istmo</title>
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Fredoka+One&family=Quicksand:wght@700&display=swap" rel="stylesheet">
    
    <style>
        /* FONDO OSCURO QUE CUBRE LA PLATAFORMA */
.modal-oculto {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(26, 15, 8, 0.85); /* Café místico transparente */
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

/* LA TARJETA LLAMATIVA DE VICTORIA */
.tarjeta-victoria button {
    font-family: 'Fredoka One', cursive; /* O la fuente redonda que uses */
    background: #8C0902; /* Rojo oaxaqueño */
    color: #FFFBF2;
    border: none;
    border-bottom: 4px solid #4A0502; /* Relieve de maquinita */
    padding: 12px 24px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 15px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.1s ease;
    margin: 5px;
}

.tarjeta-victoria button:hover {
    background: #B14A36;
    transform: translateY(-2px);
}

.tarjeta-victoria button:active {
    transform: translateY(2px);
    border-bottom-width: 1px;
}

.modal-oculto.mostrar .tarjeta-victoria {
    transform: scale(1); /* Efecto rebote infantil y divertido */
}

.tarjeta-victoria h2 {
    color: #8C0902;
    font-size: 32px;
    margin-bottom: 15px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}

.tarjeta-victoria p {
    color: #361A0C;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 25px;
}

        body { 
            font-family: 'Quicksand', sans-serif; 
            background: linear-gradient(135deg, #F4EBE1, #E6D5C3); 
            text-align: center; 
            color: #4A3525; 
            margin: 0; 
            padding: 20px; 
        }

        h1 {
            font-family: 'Fredoka One', cursive;
            color: #8C0902;
            text-shadow: 1px 1px 0px #FFF;
            margin-bottom: 5px;
        }
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

/* 🗺️ Rejilla del Memorama (4 columnas x 3 filas) - ¡Tarjetas Grandes! */
.tablero-memorama {
    display: grid;
    grid-template-columns: repeat(4, 140px); /* Columnas más anchas para niños */
    gap: 20px; /* Espacio divertido entre cartas */
    justify-content: center;
    margin: 25px auto;
    max-width: 650px;
}

.carta {
    width: 140px;  
    height: 180px; 
    perspective: 1000px;
    cursor: pointer;
    position: relative; /* Esto amarra las caras y evita que se estiren hacia abajo */
}
/* EFECTO DE ROTACIÓN EN 3D AL HACER CLIC */
.carta.volteada .atras {
    transform: rotateY(180deg);
}

.carta.volteada .adelante {
    transform: rotateY(0deg);
}

/* ESTILO DE TRANSICIÓN PARA QUE EL GIRO SEA SUAVE */
.cara {
    transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    transform-style: preserve-3d;
}


.cara {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    border-radius: 12px;
    border: 4px solid #E6A341; /* Tu característico borde dorado */
    box-shadow: 0 6px 12px rgba(0,0,0,0.3);
}

/* LA IMAGEN O MITO QUE LLEVA ADENTRO */
.cara img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Se adapta sin deformarse */
    border-radius: 8px;
}

/* REVERSO DE LA CARTA (La parte de la estrellita que se ve al inicio) */
.atras {
    background: #361A0C; /* El café original */
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CARA FRONTAL CON TU ILUSTRACIÓN DE LA LLORONA */
.adelante {
    background: #FFFBF2; /* Fondo crema claro */
    transform: rotateY(180deg);
}

    </style>
</head>
<body>

    <!-- 🎵 BUSCA LA CANCIÓN EN LA CARPETA SALIENDO DE JUEGOS -->
    <audio id="musica" src="../sonido/rojo.mp3" loop autoplay></audio>

    <h1>🎴 Memorama de La Llorona 🎴</h1>
    <p>¡Encuentra los pares de la historia del Istmo de Tehuantepec!</p>

    <div class="tablero-memorama" id="tablero"></div>
    <!-- PANTALLA FLOTANTE DE FELICITACIONES -->
<div id="pantalla-ganador" class="modal-oculto">
    <div class="tarjeta-victoria">
        <h2>¡Felicidades, Explorador! 👑🌟</h2>
        <p>¡Que buena memoria tienes amigo!</p>
  <button onclick="window.location.href='../plataforma.php?tab=juegos'">Volver a los Juegos 🎮</button>
        <button onclick="window.location.reload()" style="background: #2D93AD; border-color: #1E6B7E; margin-top: 10px;">Jugar de nuevo 🔄</button>

    </div>
</div>
<!-- 🚪 ¡AQUÍ PON EL BOTÓN DE SALIR EN TU MEMORAMA! -->
<button class="btn-salir-esquina" onclick="window.location.href='../plataforma.php?tab=juegos'">Salir 🚪</button>

    <script>
        // 📸 LAS RUTAS SALEN DE LA CARPETA "JUEGOS" Y ENTRAN A "IMG_MEMORAMA"
        const imagenesCartas = [
            '../img_memorama/m1.jpg', 
            '../img_memorama/m2.jpg', 
            '../img_memorama/m3.jpg', 
            '../img_memorama/m4.jpg', 
            '../img_memorama/m5.jpg', 
            '../img_memorama/m6.jpg'
        ];
        
        let baraja = [...imagenesCartas, ...imagenesCartas];
        baraja.sort(() => Math.random() - 0.5);

        const tablero = document.getElementById('tablero'); 
        let cartasSeleccionadas = [];
        let bloqueado = false;

        baraja.forEach((imgSrc) => {
            const carta = document.createElement('div');
            carta.className = 'carta';
            carta.dataset.nombre = imgSrc;

            carta.innerHTML = `
                <div class="cara atras">✨</div>
                <div class="cara adelante">
                    <img src="${imgSrc}" alt="Mito">
                </div>
            `;

            carta.onclick = () => voltearCarta(carta);
            tablero.appendChild(carta);
        });

        window.onload = () => {
            document.body.onclick = () => document.getElementById('musica').play();
        };

        function voltearCarta(carta) {
            if (bloqueado || carta.classList.contains('volteada') || carta.classList.contains('emparejada')) return;

            carta.classList.add('volteada');
            cartasSeleccionadas.push(carta);

            if (cartasSeleccionadas.length === 2) {
                comprobarPareja();
            }
        }

        function comprobarPareja() {
            bloqueado = true;
            let [carta1, carta2] = cartasSeleccionadas;

            if (carta1.dataset.nombre === carta2.dataset.nombre) {
                carta1.classList.add('emparejada');
                carta2.classList.add('emparejada');
                resetearSeleccion();
                comprobarVictoria();
            } else {
                setTimeout(() => {
                    carta1.classList.remove('volteada');
                    carta2.classList.remove('volteada');
                    resetearSeleccion();
                }, 1000);
            }
        }
        //prueba de cambio hg

        function resetearSeleccion() {
            cartasSeleccionadas = [];
            bloqueado = false;
        }

function comprobarVictoria() {
    const emparejadas = document.querySelectorAll('.emparejada');
    if (emparejadas.length === 12) {
        setTimeout(() => {
            // Activamos tu letrero interactivo en la pantalla
            document.getElementById('pantalla-ganador').classList.add('mostrar');
        }, 500);
    }
}

    </script>
</body>
</html>
