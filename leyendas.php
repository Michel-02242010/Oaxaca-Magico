<style>
    .grid-didactico{display:flex;gap:25px;max-width:850px;width:90vw;z-index:10;margin-top:10px}
    .tarjeta-conocimiento{background:rgba(33,1,0,0.9);border:5px solid #E6A341;border-radius:30px;padding:30px 20px;text-align:center;color:#FFFBF2;flex:1;box-shadow:0 12px 24px rgba(0,0,0,0.5);display:flex;flex-direction:column;align-items:center;transition:all 0.3s}
    .tarjeta-conocimiento:hover{transform:scale(1.04) translateY(-5px);box-shadow:0 15px 30px rgba(230,163,65,0.3)}
    .tarjeta-conocimiento h2{color:#FECE79;margin:8px 0;font-size:24px;text-shadow:2px 2px 0px #000}
    .anim-icono{font-size:55px;margin-bottom:12px;animation:bal 3s ease-in-out infinite alternate}
    @keyframes bal { 0%{transform:rotate(-8deg)} 100%{transform:rotate(8deg) scale(1.08)} }
    .caja-definicion{font-size:15px;line-height:1.5;text-align:justify;background:#502A38;padding:15px;border-radius:15px;border-left:5px solid #B14A36;margin-bottom:20px;font-weight:bold;color:#FECE79}
    .btn-aventura-oro{background:#E6A341;color:#210100;border:none;border-bottom:5px solid #9c6823;padding:12px 25px;font-weight:bold;font-size:17px;border-radius:15px;cursor:pointer;width:85%;transition:all 0.1s;text-align:center}
    .btn-aventura-oro:hover{background:#FECE79}
    .btn-aventura-oro:active{transform:translateY(4px);border-bottom-width:1px}

    .pergamino-magico{display:none;background:rgba(33,1,0,0.95);border:5px dashed #B14A36;border-radius:35px;max-width:750px;width:90vw;padding:35px;box-shadow:0 15px 35px rgba(0,0,0,0.6);text-align:center}
    .pergamino-magico h1{color:#E6A341;margin:0 0 12px 0;font-size:26px}
    .pergamino-magico p{font-size:16px;line-height:1.6;text-align:justify;margin-bottom:25px;font-weight:bold;color:#FECE79}
    .btn-menu-regresar{background:#502A38;color:#FECE79;border:none;border-bottom:4px solid #191121;padding:12px 22px;font-weight:bold;border-radius:12px;cursor:pointer;margin-right:10px}
</style>

<div style="display:flex;flex-direction:column;align-items:center;width:100%;z-index:10">
    <div id="titulosConcepto" style="text-align:center; margin-bottom:15px">
        <h1 style="font-size:32px;text-shadow:3px 3px 0 #000;margin:0;color:#E6A341">¡La Academia del Gran Explorador! 🧭</h1>
        <p style="font-size:16px;font-weight:bold;margin:5px 0 0 0;color:#FECE79;text-shadow:1px 1px 2px #000">¡Aprende los secretos de las historias antes de escoger tu misión en el mapa!</p>
    </div>

    <div id="cajasConcepto" class="grid-didactico">
        <div class="tarjeta-conocimiento">
            <div class="anim-icono">🌌</div>
            <h2>¿Qué es un Mito?</h2>
            <div class="caja-definicion">🧠 Un mito es un relato mágico súper antiguo creado para explicar misterios colosales: cómo nació el sol, las estrellas o las hermosas montañas de Oaxaca. ¡Sus protagonistas son dioses con superpoderes, gigantes o fuerzas de la naturaleza!</div>
            <button class="btn-aventura-oro" onclick="abrirCuentoMuestra('mito')">¡Aprender Mitos! 🚀</button>
        </div>
        <div class="tarjeta-conocimiento">
            <div class="anim-icono">🦊</div>
            <h2>¿Qué es una Leyenda?</h2>
            <div class="caja-descripcion caja-definicion">🍃 Una leyenda es un cuento maravilloso basado en un hecho real que sucedió hace tiempo en algún pueblo oaxaqueño. Se transmite de abuelitos a nietos y con los años le añaden magia, guardianes o criaturas del bosque.</div>
            <button class="btn-aventura-oro" onclick="abrirCuentoMuestra('leyenda')">¡Ver Leyendas! 🚀</button>
        </div>
    </div>

    <div id="pantallaCuento" class="pergamino-magico">
        <h1 id="titCuento">Título de la Historia</h1>
        <p id="txCuento">Cargando cuento legendario...</p>
        <div>
            <button class="btn-menu-regresar" onclick="cerrarCuentoMuestra()">📖 Regresar a las Definiciones</button>
            <button class="btn-aventura-oro" style="width:auto;padding:12px 25px" onclick="location.href='plataforma.php?seccion=mapa'">🧭 ¡Ir a las Misiones del Mapa!</button>
        </div>
    </div>
</div>

<script>
    const cuentosIntroduccion = {
        mito: { titulo: "🌌 Mito Ancestral: El Águila que Creó el Día", texto: "Cuentan los sabios antiguos que al principio del tiempo todo el estado de Oaxaca estaba sumergido en una noche eterna y fría. Un día, una gigantesca Águila de Fuego voló desde lo alto del universo y se posó sobre el árbol de copal más grande de la Sierra. Al abrir su pico para cantar, de sus plumas brotaron chispas de oro tan brillantes que empujaron toda la oscuridad hacia el fondo de los barrancos, creando así el primer amanecer para que los niños pudieran correr y sembrar maíz. ¡Por eso el sol sale todos los días!" },
        leyenda: { titulo: "🦊 Leyenda Mágica: Los Guardianes de la Sierra", texto: "¡Abre bien tus oídos, explorador! Cuenta la leyenda que en los bosques más escondidos y húmedos de Oaxaca habitan los Mokuan, unos duendecillos mágicos del tamaño de un hongo que visten sombreros hechos de hojas secas. Los abuelitos dicen que son los cuidadores de las plantas. Si un niño entra a la Sierra gritando o tirando basura, los Mokuan se enojan y soplan un viento que borra sus huellas del suelo para que camine en círculos. Pero si eres un niño limpio que cuida los árboles y les dejas una fruta de regalo, ellos cantarán canciones alegres y te guiarán con luciérnagas doradas para llevarte a salvo de regreso a casa." }
    };
    function abrirCuentoMuestra(t) {
        document.getElementById('cajasConcepto').style.display = 'none';
        document.getElementById('titulosConcepto').style.display = 'none';
        document.getElementById('titCuento').innerText = cuentosIntroduccion[t].titulo;
        document.getElementById('txCuento').innerText = `"${cuentosIntroduccion[t].texto}"`;
        document.getElementById('pantallaCuento').style.display = 'block';
    }
    function cerrarCuentoMuestra() {
        document.getElementById('pantallaCuento').style.display = 'none';
        document.getElementById('cajasConcepto').style.display = 'flex';
        document.getElementById('titulosConcepto').style.display = 'block';
    }
</script>