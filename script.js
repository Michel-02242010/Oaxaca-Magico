
// DATOS DE LAS OCHO REGIONES
const regiones = {
    "canada": {
        nombre: "Cañada",
        imagen: "img/canada-leyenda.png"
    },

    "papaloapan": {
        nombre: "Papaloapan",
        imagen: "img/papaloapan-leyenda.png"
    },

    "mixteca": {
        nombre: "Mixteca",
        imagen: "img/mixteca-leyenda.png"
    },

    "sierra-norte": {
        nombre: "Sierra Norte",
        imagen: "img/sierra-norte-leyenda.png"
    },

    "valles-centrales": {
        nombre: "Valles Centrales",
        imagen: "img/valles-centrales-leyenda.png"
    },

    "sierra-sur": {
        nombre: "Sierra Sur",
        imagen: "img/sierra-sur-leyenda.png"
    },

    "costa": {
        nombre: "Costa",
        imagen: "img/costa-leyenda.png"
    },

    "istmo": {
        nombre: "Istmo",
        imagen: "img/istmo-leyenda.png"
    }
};


// Posiciones para los nombres.
const posicionesNombres = {
    "costa": { x: 235, y: 317 },
    "sierra-sur": { x: 129, y: 338 },
};

// CARGAR EL SVG

async function cargarMapa() {
    const contenedor = document.getElementById("mapa-oaxaca");

    try {
        const respuesta = await fetch("img/regiones-oaxaca.svg");

        if (!respuesta.ok) {
            throw new Error("No se encontró img/regiones-oaxaca.svg");
        }

        const contenido = await respuesta.text();

        contenedor.innerHTML = contenido;

        const mapa = contenedor.querySelector("svg");

        if (!mapa) {
            throw new Error("El archivo no contiene un elemento SVG.");
        }

        prepararRegiones(mapa);

    } catch (error) {
        console.error("Error al cargar el mapa:", error);

        contenedor.innerHTML =
            '<p class="mensaje-carga">No se pudo cargar el mapa. Revisa la consola.</p>';
    }
}

// PREPARAR LAS OCHO REGIONES

function prepararRegiones(mapa) {
    const espacioSVG = "http://www.w3.org/2000/svg";

    let defs = mapa.querySelector("defs");

    if (!defs) {
        defs = document.createElementNS(espacioSVG, "defs");
        mapa.insertBefore(defs, mapa.firstChild);
    }

    Object.entries(regiones).forEach(([id, datos]) => {
        const region = mapa.querySelector("#region-" + id);

        if (!region) {
            console.warn("No se encontró la forma:", "region-" + id);
            return;
        }

        const caja = region.getBBox();

        // Crear un recorte con la forma real de la región.
        const clip = document.createElementNS(espacioSVG, "clipPath");
        const idClip = "recorte-imagen-" + id;

        clip.setAttribute("id", idClip);
        clip.setAttribute("clipPathUnits", "userSpaceOnUse");

        const forma = region.cloneNode(true);
        forma.removeAttribute("id");

        clip.appendChild(forma);
        defs.appendChild(clip);

        // Crear la imagen correspondiente a la región.
        const imagen = document.createElementNS(espacioSVG, "image");

        imagen.setAttribute("href", datos.imagen);
        imagen.setAttribute("x", caja.x);
        imagen.setAttribute("y", caja.y);
        imagen.setAttribute("width", caja.width);
        imagen.setAttribute("height", caja.height);
        imagen.setAttribute("preserveAspectRatio", "xMidYMid slice");
        imagen.setAttribute("clip-path", `url(#${idClip})`);
        imagen.setAttribute("class", "imagen-region");
        imagen.setAttribute("pointer-events", "none");

       // Crear un grupo para la pieza completa
        const pieza = document.createElementNS(
        espacioSVG,
       "g"
        );

        pieza.classList.add("pieza-region");

        // Colocar el grupo antes de la región
        region.parentNode.insertBefore(pieza, region);

        // Agrupar imagen y forma
        pieza.appendChild(imagen);
        pieza.appendChild(region);
        // Preparar la forma para su interacción.
        region.classList.add("region-interactiva");
        region.setAttribute("role", "button");
        region.setAttribute("tabindex", "0");
        region.setAttribute("aria-label", datos.nombre);

      
// NOMBRE DE CADA REGIÓN

const texto = document.createElementNS(
    espacioSVG,
    "text"
);

const posicion = posicionesNombres[id];

const xTexto = posicion
    ? posicion.x
    : caja.x + caja.width / 2;

const yTexto = posicion
    ? posicion.y
    : caja.y + caja.height / 2;

texto.setAttribute("x", xTexto);
texto.setAttribute("y", yTexto);

texto.setAttribute("text-anchor", "middle");
texto.setAttribute("dominant-baseline", "middle");

texto.setAttribute(
    "class",
    "nombre-region nombre-" + id
);

// Dividir los nombres largos en dos líneas.
const nombresEnDosLineas = {
    "sierra-norte": ["Sierra", "Norte"],
    "valles-centrales": ["Valles", "Centrales"]
};

const lineas = nombresEnDosLineas[id];

if (lineas) {
    lineas.forEach((linea, indice) => {
        const tspan = document.createElementNS(
            espacioSVG,
            "tspan"
        );

        tspan.textContent = linea;
        tspan.setAttribute("x", xTexto);

        tspan.setAttribute(
            "dy",
            indice === 0 ? "-0.55em" : "1.1em"
        );

        texto.appendChild(tspan);
    });
} else {
    texto.textContent = datos.nombre;
}

// El nombre pertenece a su propia pieza.
pieza.appendChild(texto);
// Al pasar el cursor o enfocar, la pieza se activa y se dibuja encima.
const activar = () => {
    pieza.classList.add("activa");

    const padre = pieza.parentNode;
    if (padre.lastElementChild !== pieza) {
        padre.appendChild(pieza);
    }
};

const desactivar = () => pieza.classList.remove("activa");

region.addEventListener("mouseenter", activar);
region.addEventListener("mouseleave", desactivar);
region.addEventListener("focus", activar);
region.addEventListener("blur", desactivar);
        // El clic funciona de forma independiente en cada región.
        const seleccionar = () => seleccionarRegion(id);
       

        region.addEventListener("click", seleccionar);

        region.addEventListener("keydown", evento => {
            if (evento.key === "Enter" || evento.key === " ") {
                evento.preventDefault();
                seleccionar();
            }
        });
    });
}



// SELECCIÓN DE REGIÓN
// Por ahora no abre videos.

function seleccionarRegion(id) {
    const region = regiones[id];

    if (!region) return;

    console.log("Región seleccionada:", region.nombre);

    // Aquí conectaremos el video de cada región posteriormente.
}


// Iniciar al cargar el archivo JavaScript.
cargarMapa();

// HUMO: dos videos que se alternan con fundido

(function () {
    const a = document.getElementById("humo-a");
    const b = document.getElementById("humo-b");
    if (!a || !b) return;

    const FUNDIDO = 1.5; // segundos, igual que en el CSS

    function vigilar(actual, siguiente) {
        actual.addEventListener("timeupdate", () => {
            const faltan = actual.duration - actual.currentTime;

            if (faltan <= FUNDIDO && siguiente.paused) {
                siguiente.currentTime = 0;
                siguiente.play();
                siguiente.classList.add("visible");
                actual.classList.remove("visible");
            }
        });

        actual.addEventListener("ended", () => {
            actual.currentTime = 0;
            actual.pause();
        });
    }

    vigilar(a, b);
    vigilar(b, a);

    a.addEventListener("playing", () => a.classList.add("visible"), { once: true });
    a.play().catch(() => {});
})();