// 🔦 1. MOTOR DE LA ANTORCHA MÍSTICA 
document.addEventListener('mousemove', (e) => {
    const capaAntorcha = document.getElementById('capa-antorcha');
    if (capaAntorcha) {
        const x = e.clientX;
        const y = e.clientY;
        capaAntorcha.style.background = `radial-gradient(circle 150px at ${x}px ${y}px, transparent 0%, rgba(26, 15, 8, 0.96) 100%)`;
    }
});

// 🔄 2. SISTEMA DE EXPLORACIÓN Y MUDANZA DINÁMICA
function controlarNavegacion(seccion) {
    const libro = document.querySelector('.libro-contenedor');
    const btnMito = document.getElementById('btn-mito');
    const btnLeyenda = document.getElementById('btn-leyenda');
    const hojaMito = document.getElementById('hoja-mito');
    const hojaLeyenda = document.getElementById('hoja-leyenda');
    
    // 🚀 CONTROL DEL AUDIO NATIVO DEL HTML
    const sonidoHoja = document.getElementById('efecto-hoja');
    if (sonidoHoja) {
        sonidoHoja.currentTime = 0; // Reinicia el audio por si se da clic rápido
        sonidoHoja.volume = 0.9;    // Sube el volumen al 70%
        sonidoHoja.play().catch(err => console.log("Bloqueo de navegador evitado:", err));
    }

    // ↩️ CONTROL DE REGRESO
    if (libro.classList.contains('modo-explorar-mito') || libro.classList.contains('modo-explorar-leyenda')) {
        libro.classList.remove('modo-explorar-mito', 'modo-explorar-leyenda');
        
        btnMito.querySelector('span').textContent = "Explorar Mito";
        btnLeyenda.querySelector('span').textContent = "Explorar Leyenda";
        
        const clonExistente = document.getElementById('caja-clon-destino');
        if (clonExistente) clonExistente.remove();
        return;
    }
    
    // 🔎 ACCIÓN A: EXPLORAR MITO
    if (seccion === 'mito') {
        libro.classList.add('modo-explorar-mito');
        btnMito.querySelector('span').textContent = "↩ Regresar";
        
        const origenMito = document.getElementById('ilustracion-original-mito');
        const clon = origenMito.cloneNode(true);
        clon.id = "caja-clon-destino";
        
        hojaLeyenda.appendChild(clon);
    } 
    
    // 🔎 ACCIÓN B: EXPLORAR LEYENDA
    else if (seccion === 'leyenda') {
        libro.classList.add('modo-explorar-leyenda');
        btnLeyenda.querySelector('span').textContent = "↩ Regresar";
        
        const origenLeyenda = document.getElementById('ilustracion-original-leyenda');
        const clon = origenLeyenda.cloneNode(true);
        clon.id = "caja-clon-destino";
        
        hojaMito.appendChild(clon);
    }
}
