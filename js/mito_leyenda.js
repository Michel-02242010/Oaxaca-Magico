// 1. EFECTO DE ANTORCHA (Intacto)
document.addEventListener('mousemove', (e) => {
    const capaAntorcha = document.getElementById('capa-antorcha');
    if (capaAntorcha) {
        const x = e.clientX;
        const y = e.clientY;
        capaAntorcha.style.background = `radial-gradient(circle 400px at ${x}px ${y}px, rgba(253, 238, 184, 0.15) 0%, rgba(26, 15, 8, 0.97) 100%)`;
    }
});

// 2. FUNCIÓN INTEGRADA DE ESCRITURA (Reemplaza a TypeIt sin depender de internet)
let temporizadoresEscritura = [];

function limpiarEscritura() {
    temporizadoresEscritura.forEach(id => clearTimeout(id));
    temporizadoresEscritura = [];
}

function escribirTexto(idElemento, textoHTML, velocidad, alTerminar) {
    const elemento = document.getElementById(idElemento);
    if (!elemento) return;
    
    let i = 0;
    function paso() {
        if (i <= textoHTML.length) {
            // Si detecta una etiqueta HTML como <strong>, la salta de golpe para no romper el formato
            if (textoHTML[i] === '<') {
                let cierre = textoHTML.indexOf('>', i);
                if (cierre !== -1) {
                    i = cierre + 1;
                }
            }
            elemento.innerHTML = textoHTML.slice(0, i);
            i++;
            let timer = setTimeout(paso, velocidad);
            temporizadoresEscritura.push(timer);
        } else if (alTerminar) {
            alTerminar();
        }
    }
    paso();
}

// 3. MUDANZA DINÁMICA Y NARRACIÓN
function controlarNavegacion(seccion) {
    const libro = document.querySelector('.libro-contenedor');
    const btnMito = document.getElementById('btn-mito');
    const btnLeyenda = document.getElementById('btn-leyenda');
    const hojaMito = document.getElementById('hoja-mito');
    const hojaLeyenda = document.getElementById('hoja-leyenda');

    const audioMito = document.getElementById('audio-mito');
    const audioLeyenda = document.getElementById('audio-leyenda');

    const sonidoHoja = document.getElementById('efecto-hoja');
    if (sonidoHoja) {
        sonidoHoja.currentTime = 0;
        sonidoHoja.volume = 0.9;
        sonidoHoja.play().catch(err => console.log("Bloqueo de navegador evitado:", err));
    }

    // Detener audios, cancelar escrituras en curso y vaciar párrafos
    if (audioMito) { audioMito.pause(); audioMito.currentTime = 0; }
    if (audioLeyenda) { audioLeyenda.pause(); audioLeyenda.currentTime = 0; }
    limpiarEscritura();

    document.getElementById('mito-p1').innerHTML = "";
    document.getElementById('mito-p2').innerHTML = "";
    document.getElementById('mito-p3').innerHTML = "";
    document.getElementById('leyenda-p1').innerHTML = "";
    document.getElementById('leyenda-p2').innerHTML = "";
    document.getElementById('leyenda-p3').innerHTML = "";

    // CONTROL DE REGRESO
    if (libro.classList.contains('modo-explorar-mito') || libro.classList.contains('modo-explorar-leyenda')) {
        libro.classList.remove('modo-explorar-mito', 'modo-explorar-leyenda');

        btnMito.querySelector('span').textContent = "Explorar Mito";
        btnLeyenda.querySelector('span').textContent = "Explorar Leyenda";

        const clonExistente = document.getElementById('caja-clon-destino');
        if (clonExistente) clonExistente.remove();
        return;
    }

    // ACCIÓN A: EXPLORAR MITO
    if (seccion === 'mito') {
        libro.classList.add('modo-explorar-mito');
        btnMito.querySelector('span').textContent = "↩ Regresar";

        const origenMito = document.getElementById('ilustracion-original-mito');
        const clon = origenMito.cloneNode(true);
        clon.id = "caja-clon-destino";
        hojaLeyenda.appendChild(clon);

        let timerInicio = setTimeout(() => {
            if (audioMito) {
                audioMito.play().catch(err => console.log("Audio mito pendiente de archivo:", err));
            }

            const t1 = "❖ <strong>Origen Sagrado:</strong> Narra acontecimientos sagrados y hazañas de seres sobrenaturales en el principio de los tiempos.";
            const t2 = "❖ <strong>Fuera del Tiempo:</strong> Ocurre en una época cósmica anterior al tiempo real de los humanos.";
            const t3 = "❖ <strong>Explicación Universal:</strong> Busca explicar el origen del mundo o de la creación.";

            escribirTexto("mito-p1", t1, 58, () => {
                escribirTexto("mito-p2", t2, 58, () => {
                    escribirTexto("mito-p3", t3, 58);
                });
            });
        }, 1000);
        temporizadoresEscritura.push(timerInicio);
    }

    // ACCIÓN B: EXPLORAR LEYENDA
    else if (seccion === 'leyenda') {
        libro.classList.add('modo-explorar-leyenda');
        btnLeyenda.querySelector('span').textContent = "↩ Regresar";

        const origenLeyenda = document.getElementById('ilustracion-original-leyenda');
        const clon = origenLeyenda.cloneNode(true);
        clon.id = "caja-clon-destino";
        hojaMito.appendChild(clon);

        let timerInicio = setTimeout(() => {
            if (audioLeyenda) {
                audioLeyenda.play().catch(err => console.log("Audio leyenda pendiente de archivo:", err));
            }

            const l1 = "❖ <strong>Base Real:</strong> Está basada en un hecho histórico, un personaje verdadero o un lugar real.";
            const l2 = "❖ <strong>Tiempo Humano:</strong> Se sitúa en una época histórica concreta y cercana a la comunidad.";
            const l3 = "❖ <strong>Elemento Fantástico:</strong> Se le agregan detalles mágicos o de misterio propios del folklore.";

            escribirTexto("leyenda-p1", l1, 58, () => {
                escribirTexto("leyenda-p2", l2, 58, () => {
                    escribirTexto("leyenda-p3", l3, 58);
                });
            });
        }, 1000);
        temporizadoresEscritura.push(timerInicio);
    }
}

