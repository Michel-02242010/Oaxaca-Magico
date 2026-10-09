<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Memorama Ancestral - La Llorona del Istmo</title>
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
            padding: 20px; 
        }

        h1 {
            font-family: 'Fredoka One', cursive;
            color: #8C0902;
            text-shadow: 1px 1px 0px #FFF;
            margin-bottom: 5px;
        }

        /* 🗺️ Rejilla del Memorama (4 columnas x 3 filas) */
        .tablero-memorama {
            display: grid;
            grid-template-columns: repeat(4, 90px);
            gap: 12px;
            justify-content: center;
            margin: 25px auto;
            max-width: 420px;
        }

        /* 🎴 Estilo de las Cartas */
        .carta {
            width: 90px;
            height: 120px;
            background: #361A0C; /* Café oscuro por detrás */
            border: 3px solid #8C0902;
            border-radius: 15px;
            cursor: pointer;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.4s ease, border-color 0.2s;
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .carta:hover {
            border-color: #FECE79;
            transform: scale(1.03);
        }

        /* Lógica para voltear */
        .carta.volteada {
            transform: rotateY(180deg);
            background: #FFFBF2; /* Color crema al voltearse */
        }

        .cara {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Reverso de la carta */
        .atras {
            font-size: 35px;
            color: #FECE79;
        }

        /* Cara frontal con tu ilustración */
        .adelante {
            transform: rotateY(180deg);
        }

        .adelante img {
            width: 85%;
            height: 85%;
            object-fit: contain;
        }

        /* Pareja correcta encontrada */
        .carta.emparejada {
            pointer-events: none;
            opacity: 0.85;
            border-color: #2E7D32;
        }
    </style>
</head>
<body>

    <!-- 🎵 BUSCA LA CANCIÓN EN LA CARPETA SALIENDO DE JUEGOS -->
    <audio id="musica" src="../sonido/rojo.mp3" loop autoplay></audio>

    <h1>🎴 Memorama de La Llorona 🎴</h1>
    <p>¡Encuentra los pares de la historia del Istmo de Tehuantepec!</p>

    <div class="tablero-memorama" id="tablero"></div>

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

        function resetearSeleccion() {
            cartasSeleccionadas = [];
            bloqueado = false;
        }

        function comprobarVictoria() {
            const emparejadas = document.querySelectorAll('.emparejada');
            if (emparejadas.length === 12) {
                setTimeout(() => {
                    alert("¡Excelente memoria! Completaste el memorama de La Llorona del Istmo. ✨🎉");
                }, 500);
            }
        }
    </script>
</body>
</html>
