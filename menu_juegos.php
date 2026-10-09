<!-- 🎮 CONTENEDOR DE DESAFÍOS MÁGICOS -->
<div class="grid-juegos-container" style="display: flex; justify-content: center; gap: 25px; margin-top: 30px; flex-wrap: wrap; padding: 0 20px;">

    <!-- 🧩 TARJETA 1: EL ROMPECABEZAS MÁGICO (VINCULADO A TU ARCHIVO) -->
    <div class="card-flotante" onclick="location.href='rompecabezas.php'">
        <div class="icono-animado">🧩</div>
        <h3>El Rompecabezas</h3>
        <p>Responde las preguntas de la Princesa Donají para ganar las 25 piezas y armar su hermosa imagen mística.</p>
    </div>

    <!-- 🧠 TARJETA 2: TRIVIA RELÁMPAGO -->
    <div class="card-flotante" onclick="location.href='#'" style="opacity: 0.85;">
        <div class="icono-animado">🧠</div>
        <h3>Trivia Relámpago</h3>
        <p>Responde preguntas y demuestra tu sabiduría ancestral sobre los mitos y leyendas oaxaqueñas.</p>
    </div>

    <!-- 🕵️‍♂️ TARJETA 3: PALABRAS OCULTAS -->
    <div class="card-flotante" onclick="location.href='#'" style="opacity: 0.85;">
        <div class="icono-animado">🕵️‍♂️</div>
        <h3>Palabras Ocultas</h3>
        <p>Adivina el concepto secreto de las historias tradicionales antes de que se agoten tus vidas.</p>
    </div>

</div>

<!-- 🎨 ESTILOS PARA EL EFECTO FLOTANTE DIVERTIDO -->
<style>
    .card-flotante {
        background: #FFFBF2;
        border: 4px solid #8C0902;
        border-radius: 25px;
        width: 240px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 10px 20px rgba(54, 26, 12, 0.15);
        cursor: pointer;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease, border-color 0.2s;
    }

    /* 🔥 Al pasar el mouse, la tarjeta se eleva y cambia de color al tono amarillo oaxaqueño */
    .card-flotante:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 30px rgba(140, 9, 2, 0.25);
        border-color: #FECE79;
    }

    .icono-animado {
        font-size: 45px;
        margin-bottom: 10px;
        transition: transform 0.3s ease;
    }

    .card-flotante:hover .icono-animado {
        transform: scale(1.2) rotate(5deg);
    }

    .card-flotante h3 {
        font-family: 'Fredoka One', cursive;
        color: #361A0C;
        margin: 10px 0;
        font-size: 20px;
    }

    .card-flotante p {
        font-size: 14px;
        color: #5C3A21;
        line-height: 1.5;
        margin: 0;
    }
</style>

