
const visor      = document.getElementById("visor");
const pergamino  = document.getElementById("pergamino");
const btnVer     = document.getElementById("btn-ver-mito");
const elTitulo   = document.getElementById("titulo-mito");
const elTexto    = document.getElementById("texto-mito");
const videoFondo = document.getElementById("video-fondo");

let mitoActual = null, audio = null, palabras = [], tiempos = [], raf = null;

/* ---------- ABRIR EL VISOR ---------- */
function abrirVisor(id) {
  mitoActual = MITOS[id];

  // Si hacen clic en una región que aún no agregas a mito.js
  if (!mitoActual) {
    alert("La leyenda de esta región aún está en construcción.");
    window.location.href = "../OaxacaMagico/index.html";
    return;
  }

  detener();

  // Cambia el título de la pestaña y el video de fondo según la región
  document.title = mitoActual.nombre;
  videoFondo.src = mitoActual.video;
  videoFondo.load();
  

  elTitulo.innerHTML = "";
  elTexto.innerHTML = "";
  palabras = [];

  mitoActual.frases.forEach((frase, i) => {
    const destino = frase.titulo ? elTitulo : elTexto;
    frase.texto.split(/\s+/).forEach(p => {
      const s = document.createElement("span");
      s.className = "w";
      s.textContent = p + " ";
      s.dataset.frase = i;
      destino.appendChild(s);
      palabras.push(s);
    });
  });

  pergamino.classList.remove("abierto");
  btnVer.hidden = false;
  visor.classList.remove("oculto");
}

/* ---------- DETENER / VOLVER AL MAPA ---------- */

function detener() {
  cancelAnimationFrame(raf);
  if (videoFondo) videoFondo.pause();
  if (audio) { audio.pause(); audio = null; }
}

function cerrarVisor() {
  detener();
  window.location.href = "../OaxacaMagico/index.html";
}

/* ---------- BOTONES ---------- */
document.addEventListener("click", e => {
  const boton = e.target.closest("button");
  if (!boton) return;

  if (boton.id === "btn-volver")   cerrarVisor();
  if (boton.id === "btn-ver-mito") verMito();
});

function verMito() {
  btnVer.hidden = true;
  videoFondo.play();                     // <-- El video inicia aquí al dar clic
  pergamino.classList.add("abierto");
  setTimeout(iniciarNarracion, 1400);
}

  


/* ---------- SINCRONIZACIÓN ---------- */
function calcularTiempos(duracion) {
  const pesos = palabras.map(w => w.textContent.length);
  tiempos = [];
  mitoActual.frases.forEach((f, i) => {
    const ini = f.t;
    const fin = mitoActual.frases[i + 1] ? mitoActual.frases[i + 1].t : duracion;
    const idx = palabras.map((w, k) => (+w.dataset.frase === i ? k : -1)).filter(k => k >= 0);
    const suma = idx.reduce((a, k) => a + pesos[k], 0);
    let acc = 0;
    idx.forEach(k => {
      tiempos[k] = ini + (acc / suma) * (fin - ini);
      acc += pesos[k];
    });
  });
}

function revelarHasta(i) {
  palabras.forEach((w, k) => w.classList.toggle("on", k <= i));
  const w = palabras[i];
  // Solo se desplaza la narración (el título queda fijo)
  if (w && w.parentElement === elTexto) {
    elTexto.scrollTo({ top: w.offsetTop - elTexto.clientHeight * 0.5, behavior: "smooth" });
  }
}

function seguir() {
  if (!audio) return;
  let i = -1;
  for (let k = 0; k < tiempos.length; k++) {
    if (audio.currentTime >= tiempos[k]) i = k; else break;
  }
  revelarHasta(i);
  if (!audio.ended && !audio.paused) raf = requestAnimationFrame(seguir);
}

/* Mensaje en pantalla si el audio falla (así sabes qué revisar) */
function avisar(msg) {
  console.error(msg);
  let a = document.getElementById("aviso");
  if (!a) {
    a = document.createElement("div");
    a.id = "aviso";
    a.style.cssText = "position:fixed;left:50%;bottom:1rem;transform:translateX(-50%);z-index:99;" +
      "background:#5a1e0c;color:#fff3d6;padding:.7rem 1.2rem;border-radius:6px;font:1rem Georgia,serif;max-width:90vw;text-align:center";
    document.body.appendChild(a);
  }
  a.textContent = msg;
}

function iniciarNarracion() {
  audio = new Audio(mitoActual.audio);
  calcularTiempos(audio.duration || 99999);     // tiempos provisionales

  audio.addEventListener("loadedmetadata", () => calcularTiempos(audio.duration));
  audio.addEventListener("ended", () => revelarHasta(palabras.length - 1));

  audio.play().then(seguir).catch(err =>
    avisar("No se pudo reproducir el audio (" + mitoActual.audio + "): " + err.message));
}
/* ---------- ABRIR AUTOMATICAMENTE AL ENTRAR DESDE EL MAPA ---------- */
window.addEventListener("DOMContentLoaded", () => {
  const parametros = new URLSearchParams(window.location.search);
  const regionElegida = parametros.get("region") || "mixteca";
  abrirVisor(regionElegida);
});
