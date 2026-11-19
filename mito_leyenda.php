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

  
    <div id="capa-antorcha"></div>
    <body>
    
  <button class="boton-uiverse-rpg" id="btn-esquina" onclick="window.location.href='MapaPlataforma/OaxacaMagico/index.html'">
    <span>Ir a mapa</span>
</button>



    <span>Ir a mapa</span>
</button>

    <video autoplay loop muted playsinline id="video-humo-fondo">
        <source src="img_libro/humo.mp4" type="video/mp4">
    </video>

<audio id="efecto-hoja" src="sonido/sonido_1.mp3" preload="auto"></audio>

    <!-- 📜 ESTRUCTURA DEL CÓDICE -->
    <div class="escena-codice-rpg">
        <div class="libro-contenedor">
            
            <!-- 📑 HOJA IZQUIERDA: EL MITO -->
            <div class="pagina-libro" id="hoja-mito">
                <h2 class="titulo-pagina">El Mito</h2>
                <div class="separador"></div>
                
                <div class="contenido-texto">
                 <p id="mito-p1"></p>
                 <p id="mito-p2"></p>
                 <p id="mito-p3"></p>
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
                 <p id="leyenda-p1"></p>
                 <p id="leyenda-p2"></p>
                 <p id="leyenda-p3"></p>
                </div>

                <div class="contenedor-ilustracion" id="ilustracion-original-leyenda">
                    <img src="img_libro/2llorona.png" alt="Leyenda">
                </div>
                
                <button class="boton-uiverse-rpg" id="btn-leyenda" onclick="controlarNavegacion('leyenda')">
                    <span>Explorar Leyenda</span>
                </button>
            </div>

        </div>
    </div> 
    <audio id="audio-mito" src="sonido/1_mito.mp3" preload="auto"></audio>
    <audio id="audio-leyenda" src="sonido/1_leyenda.mp3" preload="auto"></audio>

     
    <script src="js/mito_leyenda.js"></script>
    

</body>
</html>
