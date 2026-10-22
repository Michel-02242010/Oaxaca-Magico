<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chaneque Dash - Oaxaca Mágico</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body{font-family:'Quicksand',sans-serif;background:linear-gradient(135deg,#1A0F08,#162f1b,#1A0F08);min-height:100vh;margin:0;padding:20px;display:flex;justify-content:center;align-items:center;user-select:none;}
        .contenedor-juego{background:rgba(26,15,8,.95);border:4px solid #E6A341;border-radius:25px;padding:25px;max-width:700px;width:100%;text-align:center;box-shadow:0 15px 40px rgba(0,0,0,.7);position:relative;}
        h2{color:#FECE79;font-family:'Fredoka One',cursive;margin:0 0 10px;text-shadow:2px 2px 0 #8C0902;}
        h3{color:#FFFBF2;font-family:'Fredoka One',cursive;margin:0 0 15px;}
        canvas{background:linear-gradient(to bottom,#112111,#224422);border:3px solid #79380B;border-radius:15px;display:none;margin:0 auto;max-width:100%;box-shadow:inset 0 0 20px rgba(0,0,0,.8);}
        .btn-juego{background:#8C0902;color:#FFFBF2;border:none;border-bottom:4px solid #4A0502;padding:14px 28px;font-size:18px;font-weight:bold;border-radius:15px;cursor:pointer;font-family:'Fredoka One',cursive;text-transform:uppercase;}
        .btn-juego:hover{background:#B14A36;transform:scale(1.05);}
        .instrucciones{color:#FFFBF2;line-height:1.6;font-size:15px;background:rgba(0,0,0,.3);padding:15px;border-radius:15px;border:1px solid #79380B;margin-bottom:20px;}
        .pop-up-aprendizaje{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:#FFFBF2;border:4px solid #E6A341;border-radius:20px;padding:20px;width:80%;max-width:450px;color:#361A0C;box-shadow:0 10px 30px rgba(0,0,0,.6);display:none;z-index:100;}
        .pop-up-aprendizaje h4{margin:0 0 10px;color:#8C0902;font-family:'Fredoka One',cursive;font-size:20px;}
        .opcion-trivia{background:rgba(26,15,8,.05);border:2px solid #79380B;border-radius:10px;padding:10px;margin:8px 0;cursor:pointer;font-weight:bold;}
        .opcion-trivia:hover{background:#FECE79;}
        .controles-pantalla{display:none;justify-content:center;margin-top:15px;}
        .btn-control{background:#E6A341;color:#361A0C;border:none;border-bottom:4px solid #79380B;font-size:24px;padding:15px 40px;border-radius:15px;font-weight:bold;cursor:pointer;}
    </style>
</head>
<body>
<div class="contenedor-juego">
    <div id="pantalla-inicio">
        <h2>🌿 CHANEQUE DASH 🌿</h2>
        <h3>¡Aventura Extrema en Miahuatlán!</h3>
        <div class="instrucciones">
            <p><strong>¡Los Chaneques se llevaron las reliquias mágicas!</strong> Corre, esquívalos saltando y junta amuletos dorados. ¡Ten cuidado, si te golpean perderás amuletos y una de tus 3 vidas!</p>
            <p>🎮 <strong>Controles:</strong> Espacio o Flecha Arriba para SALTAR. En celulares usa el botón de abajo.</p>
        </div>
        <button onclick="comenzarAventura()" class="btn-juego">¡Iniciar Juego! 🚀</button>
    </div>
    <div id="pantalla-gameplay" style="display:none;">
        <canvas id="lienzoJuego" width="600" height="250"></canvas>
        <div class="controles-pantalla" id="controlesMovil">
            <button class="btn-control" onmousedown="activarSalto()" ontouchstart="activarSalto()">💥 SALTAR 💥</button>
        </div>
    </div>
    <div id="popupTrivia" class="pop-up-aprendizaje">
        <h4 id="trivia-titulo">✨ ¿Sabías qué? ✨</h4>
        <p id="trivia-texto" style="font-size:14px;line-height:1.4;margin-bottom:15px;"></p>
        <div id="trivia-opciones"></div>
    </div>
    <div id="anuncioFeedback" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:#FFFBF2;border:4px solid #E6A341;border-radius:20px;padding:20px;width:70%;max-width:380px;text-align:center;display:none;z-index:110;box-shadow:0 10px 30px rgba(0,0,0,.6);">
        <h3 id="anuncio-titulo" style="margin:0 0 10px;font-family:'Fredoka One',cursive;"></h3>
        <p id="anuncio-texto" style="color:#361A0C;font-size:14px;line-height:1.4;margin:0;font-weight:bold;"></p>
    </div>
    <div id="pantalla-final" style="display:none;">
        <h2>🏆 ¡Juego Terminado! 🏆</h2>
        <p id="resumen-final" style="color:#FFFBF2;font-size:18px;line-height:1.6;"></p><br>
        <button onclick="reiniciarMision()" class="btn-juego" style="margin-right:10px;">Reintentar 🔁</button>
        <button onclick="window.location.href='../plataforma.php'" class="btn-juego" style="background:#441004;border-color:#1A0F08;">Plataforma 🧭</button>
    </div>
</div>
<script>
const canvas=document.getElementById("lienzoJuego"),ctx=canvas.getContext("2d");
let bucleJuego,puntuacion=0,sabiduriaPuntos=0,tiempoDeJuego=45,temporizadorIntervalo,activo=false;
let vidas=3; // SISTEMA DE VIDAS ORIGINAL
const jugador={x:50,y:190,ancho:30,alto:40,color:"#FECE79",gravedad:0.6,fuerzaSalto:-12,velocidadY:0,enElSuelo:true};
let listaObstaculos=[],listaPremios=[],contadorObstaculos=0,contadorPremios=0;let velocidadMundo=4,preguntasMostradas=0;
const bancoPreguntas=[
    {h:"Los Chaneques son conocidos en Miahuatlán por ser espíritus traviesos. ¿Cuál es su labor principal?",r:[{t:"Cuidar los montes, ríos y la naturaleza silvestre",c:true},{t:"Esconder juguetes en la ciudad",c:false}]},
    {h:"Según las leyendas, si un Chaneque te confunde el camino en el cerro, ¿cómo rompes su truco?",r:[{t:"Poniéndote la ropa al revés",c:true},{t:"Gritando nombres de frutas",c:false}]},
    {h:"Miahuatlán de Porfirio Díaz es una hermosa zona montañosa. ¿A qué región pertenece?",r:[{t:"A la Sierra Sur",c:true},{t:"A los Valles Centrales",c:false}]}
];
function comenzarAventura(){
    document.getElementById("pantalla-inicio").style.display="none";
    document.getElementById("pantalla-gameplay").style.display="block";
    canvas.style.display="block";
    if('ontouchstart' in window)document.getElementById("controlesMovil").style.display="flex";
    resetearDatos();reanudarMotor();
}
function resetearDatos(){puntuacion=0;sabiduriaPuntos=0;tiempoDeJuego=45;preguntasMostradas=0;vidas=3;listaObstaculos=[];listaPremios=[];velocidadMundo=4;jugador.y=190;jugador.velocidadY=0;jugador.enElSuelo=true;}
function reanudarMotor(){activo=true;bucleJuego=requestAnimationFrame(actualizarFotograma);temporizadorIntervalo=setInterval(()=>{tiempoDeJuego--;if(tiempoDeJuego<=0)finalizarPartida();},1000);}
function pausarMotor(){activo=false;clearInterval(temporizadorIntervalo);cancelAnimationFrame(bucleJuego);}
function lanzarPausaEducativa(){
    if(preguntasMostradas>=bancoPreguntas.length)return;
    pausarMotor();
    const popUp=document.getElementById("popupTrivia"),texto=document.getElementById("trivia-texto"),opciones=document.getElementById("trivia-opciones"),anuncio=document.getElementById("anuncioFeedback"),aTitulo=document.getElementById("anuncio-titulo"),aTexto=document.getElementById("anuncio-texto");
    let preg=bancoPreguntas[preguntasMostradas];texto.innerText=preg.h;opciones.innerHTML="";
    preg.r.forEach(r=>{
        let div=document.createElement("div");div.classList.add("opcion-trivia");div.innerText=r.t;
        div.onclick=()=>{
            popUp.style.display="none";
            if(r.c){sabiduriaPuntos+=10;aTitulo.innerText="✨ ¡CORRECTO! ✨";aTitulo.style.color="#27ae60";aTexto.innerText="¡Sumas +10 Puntos de Sabiduría!";}
            else{aTitulo.innerText="🎒 ¡OOPS! 🎒";aTitulo.style.color="#c0392b";aTexto.innerText="Los Chaneques se burlan... ¡Pero ya aprendiste algo nuevo!";}
            anuncio.style.display="block";preguntasMostradas++;
            setTimeout(()=>{anuncio.style.display="none";reanudarMotor();},2200);
        };opciones.appendChild(div);
    });popUp.style.display="block";
}
function actualizarFotograma(){
    if(!activo)return;ctx.clearRect(0,0,canvas.width,canvas.height);
    ctx.fillStyle="#142510";ctx.fillRect(0,230,canvas.width,20);ctx.fillStyle="#E6A341";ctx.fillRect(0,227,canvas.width,3);
    jugador.velocidadY+=jugador.gravedad;jugador.y+=jugador.velocidadY;
    if(jugador.y>=190){jugador.y=190;jugador.velocidadY=0;jugador.enElSuelo=true;}
    ctx.fillStyle=jugador.color;ctx.fillRect(jugador.x,jugador.y,jugador.ancho,jugador.alto);
    ctx.fillStyle="#8C0902";ctx.fillRect(jugador.x-4,jugador.y,jugador.ancho+8,8);ctx.fillStyle="#361A0C";ctx.fillRect(jugador.x+18,jugador.y+14,4,4);
    if(++contadorObstaculos>=100){contadorObstaculos=0;listaObstaculos.push({x:canvas.width,y:200,ancho:25,alto:30,color:"#8b5cf6"});if(velocidadMundo<7)velocidadMundo+=.15;}
    for(let i=listaObstaculos.length-1;i>=0;i--){
        let o=listaObstaculos[i];o.x-=velocidadMundo;ctx.fillStyle=o.color;ctx.fillRect(o.x,o.y,o.ancho,o.alto);ctx.fillStyle="#ff3333";ctx.fillRect(o.x+4,o.y+8,4,4);
        if(jugador.x<o.x+o.ancho&&jugador.x+jugador.ancho>o.x&&jugador.y<o.y+o.alto&&jugador.y+jugador.alto>o.y){
            listaObstaculos.splice(i,1);
            puntuacion=Math.max(0,puntuacion-1); // Pierde puntuación
            vidas--; // Pierde vida
            jugador.color="#ff4d4d";setTimeout(()=>jugador.color="#FECE79",200);
            if(vidas<=0){finalizarPartida();return;}
            continue;
        }
        if(o.x+o.ancho<0)listaObstaculos.splice(i,1);
    }
    if(++contadorPremios>=140){contadorPremios=0;listaPremios.push({x:canvas.width,y:Math.random()*50+90,ancho:18,alto:18,color:"#EFBB55"});}
    for(let j=listaPremios.length-1;j>=0;j--){
        let p=listaPremios[j];p.x-=(velocidadMundo-0.5);ctx.fillStyle=p.color;ctx.beginPath();ctx.arc(p.x+9,p.y+9,9,0,Math.PI*2);ctx.fill();ctx.fillStyle="#FFFBF2";ctx.font="10px Arial";ctx.fillText("✨",p.x+2,p.y+12);
        if(jugador.x<p.x+p.ancho&&jugador.x+jugador.ancho>p.x&&jugador.y<p.y+p.alto&&jugador.y+jugador.alto>p.y){listaPremios.splice(j,1);puntuacion++;if(puntuacion%2===0)lanzarPausaEducativa();continue;}
        if(p.x+p.ancho<0)listaPremios.splice(j,1);
    }

// Renderizado visual de la barra de estado e interfaz
ctx.fillStyle="#FFFBF2";ctx.font="bold 13px 'Quicksand',sans-serif";
ctx.fillText("💎 Amuletos: "+puntuacion,20,30);
ctx.fillText("🎓 Sabiduría: "+sabiduriaPuntos+" pts",140,30);
ctx.fillText("⏱️ Tiempo: "+tiempoDeJuego+"s",canvas.width-110,30);
// Dibujar corazones dinámicos basados en la variable vidas
let vStr = (vidas===3)?"❤️❤️❤️":(vidas===2)?"❤️❤️🖤":"❤️🖤🖤";
ctx.fillText("Vidas: "+vStr,20,53);
bucleJuego=requestAnimationFrame(actualizarFotograma);
}
function activarSalto(){if(jugador.enElSuelo&&activo){jugador.velocidadY=jugador.fuerzaSalto;jugador.enElSuelo=false;}}
window.addEventListener("keydown",e=>{if(e.code==="Space"||e.code==="ArrowUp"){e.preventDefault();activarSalto();}});
function finalizarPartida(){
pausarMotor();document.getElementById("pantalla-gameplay").style.display="none";document.getElementById("pantalla-final").style.display="block";
let t=(puntuacion*5)+sabiduriaPuntos,el=document.getElementById("resumen-final");
    if(vidas<=0){el.innerHTML="🎒 **¡Te quedaste sin vidas!** Los Chaneques te ganaron esta ronda en el bosque de Miahuatlán. Lograste acumular **"+puntuacion+" amuletos**. ¡Reinténtalo para vencerlos!";}
    else{el.innerHTML=t>=30?"🏆 **¡Espectacular!** Juntaste "+puntuacion+" amuletos y "+sabiduriaPuntos+" pts de Sabiduría. ¡Eres el Guardián Supremo de la Sierra Sur! 🌲":"✨ **¡Gran esfuerzo!** Sumaste "+t+" puntos totales combinando acción y respuestas. ¡Inténtalo de nuevo!";}
}
function reiniciarMision(){document.getElementById("pantalla-final").style.display="none";comenzarAventura();}
</script>
</body>
</html>