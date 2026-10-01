<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mapa de Oaxaca</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        /* Fondo transparente para acoplarse al menú de la plataforma */
        body { font-family: 'Quicksand', sans-serif; margin: 0; padding: 20px; background: transparent; display: flex; justify-content: center; align-items: center; min-height: calc(100vh - 150px); overflow: hidden; }
        
        /* Contenedor principal del mapa táctico */
        .map-container { position: relative; background: #2B160A; border: 5px solid #E6A341; border-radius: 30px; width: 95%; max-width: 900px; height: 580px; box-shadow: 0 15px 35px rgba(0,0,0,0.6); display: flex; flex-wrap: wrap; justify-content: center; align-content: center; gap: 25px; padding: 30px; box-sizing: border-box; }
        
        /* Estilo general para los pines de las 8 regiones de Oaxaca */
        .pin-region { background: #8C0902; color: #FFFBF2; border: 3px solid #361A0C; padding: 14px 22px; font-size: 16px; font-weight: 700; border-radius: 20px; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 6px 0px #4A0502, 0 10px 15px rgba(0,0,0,0.4); transition: all 0.15s ease; user-select: none; }
        .pin-region:hover { background: #B14A36; border-color: #FECE79; transform: translateY(-3px); box-shadow: 0 9px 0px #4A0502, 0 12px 20px rgba(0,0,0,0.5); }
        .pin-region:active { transform: translateY(4px); box-shadow: 0 2px 0px #4A0502, 0 4px 6px rgba(0,0,0,0.3); }
        
        /* Pin especial seleccionado o resaltado (como Sierra Juárez en tu foto) */
        .pin-region.highlight { background: #FFFBF2; color: #1A0F08; border-color: #E6A341; box-shadow: 0 6px 0px #A08068, 0 10px 15px rgba(230,163,65,0.3); }
        .pin-region.highlight:hover { background: #ffffff; border-color: #FECE79; }
        
        /* Botón verde inferior para confirmar e ir a leer */
        .btn-explorar { position: absolute; bottom: 25px; right: 35px; background: #10b957; color: white; border: none; border-bottom: 5px solid #0b9444; padding: 14px 28px; font-size: 18px; font-weight: 700; border-radius: 15px; cursor: pointer; display: flex; align-items: center; gap: 10px; box-shadow: 0 8px 15px rgba(16, 185, 87, 0.3); transition: all 0.1s; text-transform: uppercase; }
        .btn-explorar:hover { background: #2ae881; }
        .btn-explorar:active { transform: translateY(4px); border-bottom-width: 1px; box-shadow: 0 2px 5px rgba(16, 185, 87, 0.2); }
    </style>
</head>
<body>

    <!-- CONTENEDOR DEL TABLERO SIN EL CUADRO DEL ZORRO -->
    <div class="map-container">
        
        <!-- Listado de las 8 regiones ordenadas en cuadrícula flexible -->
        <div class="pin-region" onclick="selectRegion('valles')">📍 Valles Centrales</div>
        <div class="pin-region" onclick="selectRegion('magon')">📍 Flores Magón</div>
        <div class="pin-region highlight" onclick="selectRegion('juarez')">📍 Sierra Juárez</div>
        <div class="pin-region" onclick="selectRegion('mixteca')">📍 La Mixteca</div>
        <div class="pin-region" onclick="selectRegion('sur')">📍 Sierra Sur</div>
        <div class="pin-region" onclick="selectRegion('istmo')">📍 El Istmo</div>
        <div class="pin-region" onclick="selectRegion('costa')">📍 La Costa</div>
        <div class="pin-region" onclick="selectRegion('papaloapan')">📍 Papaloapan</div>

        <!-- Botón verde de acción para disparar las lecturas -->
        <button class="btn-explorar" onclick="irALeyendas()">¡Explorar Historias! 🧭</button>

    </div>

    <script>
        let regionSeleccionada = "juarez"; // Inicia con Sierra Juárez por defecto

        // Función interactiva para cambiar el pin seleccionado con un clic
        function selectRegion(id) {
            regionSeleccionada = id;
            // Quitamos el diseño blanco a todos los pines
            document.querySelectorAll('.pin-region').forEach(p => p.classList.remove('highlight'));
            // Se lo agregamos únicamente al pin que presionó el alumno
            event.currentTarget.classList.add('highlight');
        }

        // Redirección hacia tu documento de leyendas pasando la variable limpia por la URL
        function irALeyendas() {
            if (regionSeleccionada) {
                // Redirige rompiendo el iframe para abrirse de forma limpia
                window.parent.location.href = "leyendas.php?region=" + regionSeleccionada;
            }
        }
    </script>
</body>
</html>