<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mitos y Leyendas</title>
    <!-- Vinculamos tu archivo CSS limpio -->
    <link rel="stylesheet" href="css/libro.css">
</head>
<body>

    <style>
@font-face {
    font-family: 'texto'; 
    src: url('fuentes/texto.otf') format('truetype');   
}

@font-face {
    font-family: 'titulo';
    src: url('fuentes/titulo.otf') format('truetype');
}

@font-face {
    font-family: 'butter'; 
    src: url('fuentes/butter.otf') format('truetype'); 
    
}

</style>

    <!-- 🔦 CAPA DE OSCURIDAD DE LA ANTORCHA -->
    <div id="capa-antorcha"></div>
<!-- 🎵 AUDIO NATIVO PRECARGADO -->
<audio id="efecto-hoja" src="sonido/sonido_1.mp3" preload="auto"></audio>

    <!-- 📜 ESTRUCTURA DEL CÓDICE -->
    <div class="escena-codice-rpg">
        <div class="libro-contenedor">
            
            <!-- 📑 HOJA IZQUIERDA: EL MITO -->
            <div class="pagina-libro" id="hoja-mito">
                <h2 class="titulo-pagina">El Mito</h2>
                <div class="separador"></div>
                
                <div class="contenido-texto">
                    <p>🔹 <strong>Origen Sagrado:</strong> Narra acontecimientos sagrados y hazañas de seres sobrenaturales en el principio de los tiempos.</p>
                    <p>🔹 <strong>Fuera del Tiempo:</strong> Ocurre en una época cósmica anterior al tiempo real de los humanos.</p>
                    <p>🔹 <strong>Explicación Universal:</strong> Busca explicar el origen del mundo o de la creación.</p>
                </div>
                
                <!-- ID único para la caja de la imagen -->
                <div class="contenedor-ilustracion" id="ilustracion-original-mito">
                    <img src="img_libro/2dios.png" alt="Mito">
                </div>
                
                <button class="boton-uiverse-rpg" id="btn-mito" onclick="controlarNavegacion('mito')">
                    <span>Explorar Mito</span>
                </button>
            </div>

            <!-- 📑 HOJA DERECHA: LA LEYENDA -->
            <div class="pagina-libro" id="hoja-leyenda">
                <h2 class="titulo-pagina">La Leyenda</h2>
                <div class="separador"></div>
                
                <div class="contenido-texto" id="texto-leyenda">
                    <p>🔸 <strong>Base Real:</strong> Está basada en un hecho histórico, un personaje verdadero o un lugar real.</p>
                    <p>🔸 <strong>Tiempo Humano:</strong> Se sitúa en una época histórica concreta y cercana a la comunidad.</p>
                    <p>🔸 <strong>Elemento Fantástico:</strong> Se le agregan detalles mágicos o de misterio propios del folklore.</p>
                </div>
                
                <!-- ID único para la caja de la imagen -->
                <div class="contenedor-ilustracion" id="ilustracion-original-leyenda">
                    <img src="img_libro/2llorona.png" alt="Leyenda">
                </div>
                
                <button class="boton-uiverse-rpg" id="btn-leyenda" onclick="controlarNavegacion('leyenda')">
                    <span>Explorar Leyenda</span>
                </button>
            </div>

        </div> <!-- /libro-contenedor -->
    </div> <!-- /escena-codice-rpg -->

    <script src="js/mito_leyenda.js"></script>

</body>
</html>




<








