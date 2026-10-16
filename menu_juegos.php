<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            padding: 10px;
            background: transparent;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            height: auto;
        }

        .tarjeta-juego {
            background: #FFFBF2;
            border: 4px solid #E6A341;
            border-radius: 20px;
            padding: 15px;
            text-align: center;
            width: 165px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            min-height: 240px;
        }

        .icono-juego {
            font-size: 40px;
            margin-bottom: 5px;
        }

        .tarjeta-juego h3 {
            color: #8C0902;
            font-size: 16px;
            margin: 5px 0;
        }

        .tarjeta-juego p {
            color: #361A0C;
            font-size: 12px;
            margin: 0 0 10px 0;
            line-height: 1.3;
        }

        .tarjeta-juego button {
            background: #8C0902;
            color: #FFFBF2;
            border: none;
            padding: 8px 16px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            transition: background 0.2s;
            width: 100%;
        }

        .tarjeta-juego button:hover {
            background: #B14A36;
        }
    </style>
</head>
<body>

        <!-- TARJETA 1: ROMPECABEZAS -->
    <div class="tarjeta-juego">
        <div>
            <div class="icono-juego">🧩</div>
            <h3>El Rompecabezas</h3>
            <p>Responde correctamente los acertijos de Donají para ganar.</p>
        </div>
        <!-- Alternativa: Abre el juego en una pestaña nueva para saltar el bloqueo -->
        <button onclick="window.open('juegos/rompecabezas.php', '_blank')">Jugar 🎮</button>
    </div>

    <!-- TARJETA 2: MEMORAMA -->
    <div class="tarjeta-juego">
        <div>
            <div class="icono-juego">🃏</div>
            <h3>El Memorama</h3>
            <p>¡Encuentra los pares ocultos inspirados en La Llorona!</p>
        </div>
        <button onclick="window.open('juegos/memorama.php', '_blank')">Jugar 🎮</button>
    </div>

    <!-- TARJETA 3: EL FLECHADOR -->
    <div class="tarjeta-juego">
        <div>
            <div class="icono-juego">🏹</div>
            <h3>El Flechador</h3>
            <p>¡Atrapa las flechas sagradas del Sol y esquiva los rayos!</p>
        </div>
        <button onclick="window.open('juegos/flechador.php', '_blank')">Jugar 🎮</button>
    </div>

</body>
</html>
