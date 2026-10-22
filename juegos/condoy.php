<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rey Condoy - Oaxaca Mágico</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body{font-family:'Quicksand',sans-serif;background:linear-gradient(135deg,#1A0F08,#3a2211,#1A0F08);min-height:100vh;margin:0;padding:20px;display:flex;justify-content:center;align-items:center;user-select:none;}
        .contenedor-juego{background:rgba(26,15,8,.95);border:4px solid #E6A341;border-radius:25px;padding:25px;max-width:700px;width:100%;text-align:center;box-shadow:0 15px 40px rgba(0,0,0,.7);position:relative;}
        h2{color:#FECE79;font-family:'Fredoka One',cursive;margin:0 0 10px;text-shadow:2px 2px 0 #8C0902;}
        h3{color:#FFFBF2;font-family:'Fredoka One',cursive;margin:0 0 15px;}
        canvas{background:linear-gradient(to bottom,#1b110b,#4a3225);border:3px solid #79380B;border-radius:15px;display:none;margin:0 auto;max-width:100%;box-shadow:inset 0 0 20px rgba(0,0,0,.8);cursor:crosshair;}
        .btn-juego{background:#8C0902;color:#FFFBF2;border:none;border-bottom:4px solid #4A0502;padding:14px 28px;font-size:18px;font-weight:bold;border-radius:15px;cursor:pointer;font-family:'Fredoka One',cursive;text-transform:uppercase;}
        .btn-juego:hover{background:#B14A36;transform:scale(1.05);}
                /* 📜 ESTILOS DEL NUEVO PERGAMINO */
        .pergamino-instrucciones {
            background: linear-gradient(185deg, #2c160a 0%, #170d06 100%);
            border: 2px dashed #E6A341;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            position: relative;
            box-shadow: 0 0 15px rgba(230, 163, 65, 0.2), inset 0 0 10px rgba(0,0,0,0.6);
        }

        .icono-alerta {
            font-size: 28px;
            display: block;
            margin-bottom: 10px;
            animation: flotarMistico 2s infinite alternate ease-in-out;
        }

        .texto-principal {
            color: #FFFBF2;
            line-height: 1.6;
            font-size: 15px;
            margin: 0 0 18px 0;
        }

        .caja-controles {
            background: rgba(230, 163, 65, 0.08);
            border-left: 4px solid #8C0902;
            padding: 12px 15px;
            border-radius: 0 12px 12px 0;
            text-align: left;
        }

        .control-badge {
            font-family: 'Fredoka One', cursive;
            font-size: 12px;
            background: #8C0902;
            color: #FFFBF2;
            padding: 3px 10px;
            border-radius: 8px;
            display: inline-block;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .caja-controles p {
            color: #FECE79;
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }

        @keyframes flotarMistico {
            0% { transform: translateY(0); filter: drop-shadow(0 0 2px #E6A341); }
            100% { transform: translateY(-5px); filter: drop-shadow(0 0 8px #EFBB55); }
        }

                /* 📜 NUEVO PERGAMINO DE TRIVIA GIGANTE */
        .pop-up-aprendizaje {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(135deg, #FFFBF2 0%, #F5E6CC 100%);
            border: 5px solid #E6A341;
            border-radius: 25px;
            padding: 30px;
            width: 90%;          /* Mucho más ancho */
            max-width: 550px;    /* Más grande en pantallas de escritorio */
            color: #361A0C;
            box-shadow: 0 20px 50px rgba(0,0,0,0.8), inset 0 0 15px rgba(140, 9, 2, 0.1);
            display: none;
            z-index: 100;
            animation: entradaMagica 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .pop-up-aprendizaje h4 {
            margin: 0 0 15px 0;
            color: #8C0902;
            font-family: 'Fredoka One', cursive;
            font-size: 26px;     /* Texto de título más grande */
            text-shadow: 1px 1px 0px #FECE79;
        }

        .pop-up-aprendizaje p {
            font-size: 17px;     /* Pregunta más legible para el niño */
            line-height: 1.5;
            margin-bottom: 25px;
            font-weight: bold;
        }

        /* 🎯 BOTONES DE OPCIONES ESTILO CASSETTE 3D */
        .opcion-trivia {
            background: #FFFBF2;
            color: #361A0C;
            border: 3px solid #79380B;
            border-bottom: 6px solid #4A2207; /* Efecto hundido 3D */
            border-radius: 15px;
            padding: 16px 20px;   /* Botones más gruesos y fáciles de picar */
            margin: 12px 0;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.1s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .opcion-trivia:hover {
            background: #FECE79;
            border-color: #8C0902;
            border-bottom-color: #4A0502;
            transform: translateY(-2px);
        }

        .opcion-trivia:active {
            transform: translateY(3px);
            border-bottom-width: 3px; /* Se hunde al hacer clic */
        }

        /* Animación de apertura suave */
        @keyframes entradaMagica {
            0% { transform: translate(-50%, -40%) scale(0.8); opacity: 0; }
            100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
        }
    </style>
</head>
<body>
<div class="contenedor-juego">
    <div id="pantalla-inicio">
        <h2>👑 EL REY CONDOY 👑</h2>
        <h3>Guardián de la Sierra Norte</h3>
                <!-- 📜 NUEVO DISEÑO DE PERGAMINO MÍSTICO -->
        <div class="pergamino-instrucciones">
            <span class="icono-alerta">🛡️✨</span>
            <p class="texto-principal">
                <strong>¡La paz de las montañas Mixes corre peligro!</strong> Toma el control del heroico Rey Condoy y usa tu fuerza colosal para lanzar rocas gigantes contra los campamentos invasores.
            </p>
            <div class="caja-controles">
                <span class="control-badge">🎯 CONTROLES</span>
                <p>¡Arrastra la roca hacia atrás para apuntar con tu resortera y suéltala con fuerza!</p>
            </div>
        </div>

        <button onclick="comenzarAventura()" class="btn-juego">¡Defender la Sierra! 🚀</button>
    </div>
    <div id="pantalla-gameplay" style="display:none;"><canvas id="lienzoJuego" width="600" height="300"></canvas></div>
    <div id="popupTrivia" class="pop-up-aprendizaje">
        <h4>✨ ¡Poder Ancestral! ✨</h4>
        <p id="trivia-texto" style="font-size:14px;line-height:1.4;margin-bottom:15px;"></p>
        <div id="trivia-opciones"></div>
    </div>
        <!-- 📢 LETRERO DE RETROALIMENTACIÓN GIGANTE -->
    <div id="anuncioFeedback" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:linear-gradient(135deg, #FFFBF2, #FECE79); border:5px solid #8C0902; border-radius:25px; padding:35px 20px; width:85%; max-width:480px; text-align:center; display:none; z-index:110; box-shadow:0 15px 40px rgba(0,0,0,0.7);">
        <h3 id="anuncio-titulo" style="margin:0 0 15px; font-family:'Fredoka One', cursive; font-size: 28px;"></h3>
        <p id="anuncio-texto" style="color:#361A0C; font-size:16px; line-height:1.5; margin:0; font-weight:bold;"></p>
    </div>

    <div id="pantalla-final" style="display:none;">
        <h2>🏆 ¡Batalla Concluida! 🏆</h2>
        <p id="resumen-final" style="color:#FFFBF2;font-size:18px;line-height:1.6;"></p><br>
        <button onclick="reiniciarMision()" class="btn-juego" style="margin-right:10px;">Volver a luchar 🔁</button>
        <button onclick="window.location.href='../plataforma.php'" class="btn-juego" style="background:#441004;border-color:#1A0F08;">Plataforma 🧭</button>
    </div>
</div>
<script>

const canvas=document.getElementById("lienzoJuego"),ctx=canvas.getContext("2d");
let bucleJuego,puntuacion=0,sabiduriaPuntos=0,activo=false,vidas=3,arrastrando=false,preguntasMostradas=0,esRocaMagica=false;
const resortera={x:100,y:200},roca={x:100,y:200,r:15,vX:0,vY:0,lanzada:false};
let listaEnemigos=[],contadorEnemigos=0;
const bancoPreguntas=[
    {h:"El Rey Condoy es el máximo héroe mitológico de un pueblo oaxaqueño muy importante. ¿Cuál es?",r:[{t:"El pueblo Mixe (los jamás conquistados)",c:true},{t:"El pueblo Zapoteco de los valles",c:false}]},
    {h:"¿Qué poder asombroso tenía el Rey Condoy según los relatos de la Sierra Norte?",r:[{t:"Podía construir palacios y mover cerros en una noche",c:true},{t:"Podía transformarse en un jaguar de fuego",c:false}]},
    {h:"La majestuosa Sierra Norte es el hogar de Condoy. ¿Qué tipo de naturaleza la caracteriza?",r:[{t:"Bosques templados llenos de neblina y árboles altos",c:true},{t:"Grandes desiertos áridos con nopales",c:false}]}
];
function comenzarAventura(){document.getElementById("pantalla-inicio").style.display="none";document.getElementById("pantalla-gameplay").style.display="block";canvas.style.display="block";resetearDatos();reanudarMotor();}
function resetearDatos(){puntuacion=0;sabiduriaPuntos=0;preguntasMostradas=0;vidas=3;listaEnemigos=[];resetearRoca();}
function resetearRoca(){roca.x=resortera.x;roca.y=resortera.y;roca.vX=0;roca.vY=0;roca.lanzada=false;esRocaMagica=false;}
function reanudarMotor(){activo=true;bucleJuego=requestAnimationFrame(actualizarFotograma);}
function pausarMotor(){activo=false;cancelAnimationFrame(bucleJuego);}
function lanzarPausaEducativa(){
    if(preguntasMostradas>=bancoPreguntas.length)return;pausarMotor();
    const popUp=document.getElementById("popupTrivia"),texto=document.getElementById("trivia-texto"),opciones=document.getElementById("trivia-opciones"),anuncio=document.getElementById("anuncioFeedback"),aTitulo=document.getElementById("anuncio-titulo"),aTexto=document.getElementById("anuncio-texto");
    let preg=bancoPreguntas[preguntasMostradas];texto.innerText=preg.h;opciones.innerHTML="";
    preg.r.forEach(r=>{
        let div=document.createElement("div");div.classList.add("opcion-trivia");div.innerText=r.t;
        div.onclick=()=>{
            popUp.style.display="none";
            if(r.c){sabiduriaPuntos+=10;esRocaMagica=true;aTitulo.innerText="🔥 ¡ROCA DE FUEGO! 🔥";aTitulo.style.color="#e67e22";aTexto.innerText="¡Correcto! Desbloqueas la Roca Gigante. ¡Próximo tiro potenciado!";}
            else{aTitulo.innerText="🛡️ ROCA COMÚN 🛡️";aTitulo.style.color="#7f8c8d";aTexto.innerText="Incorrecto. Sigues usando rocas normales, ¡pero aprendiste el mito!";}
            anuncio.style.display="block";preguntasMostradas++;setTimeout(()=>{anuncio.style.display="none";reanudarMotor();},2500);
        };opciones.appendChild(div);
    });popUp.style.display="block";
}
function actualizarFotograma(){
    if(!activo)return;ctx.clearRect(0,0,canvas.width,canvas.height);
    ctx.fillStyle="#2e1a0c";ctx.fillRect(0,250,canvas.width,50);ctx.fillStyle="#1c3d17";ctx.beginPath();ctx.moveTo(0,250);ctx.lineTo(150,150);ctx.lineTo(250,250);ctx.fill();
    ctx.fillStyle="#FECE79";ctx.fillRect(110,115,20,35);ctx.fillStyle="#8C0902";ctx.fillRect(105,115,30,6);
    if(!roca.lanzada){ctx.strokeStyle="#79380B";ctx.lineWidth=4;ctx.beginPath();ctx.moveTo(resortera.x,resortera.y);ctx.lineTo(roca.x,roca.y);ctx.stroke();}
    if(roca.lanzada){roca.vY+=0.25;roca.x+=roca.vX;roca.y+=roca.vY;if(roca.y>250||roca.x>canvas.width){resetearRoca();if(puntuacion>0&&puntuacion%2===0&&preguntasMostradas<bancoPreguntas.length){lanzarPausaEducativa();}}}
    let rRango=esRocaMagica?roca.r*1.6:roca.r;ctx.fillStyle=esRocaMagica?"#e67e22":"#7f8c8d";ctx.beginPath();ctx.arc(roca.x,roca.y,rRango,0,Math.PI*2);ctx.fill();
    if(++contadorEnemigos>=120){contadorEnemigos=0;listaEnemigos.push({x:canvas.width-40,y:210,w:30,h:40,color:"#8C0902"});}
    for(let i=listaEnemigos.length-1;i>=0;i--){
        let e=listaEnemigos[i];e.x-=0.8;ctx.fillStyle=e.color;ctx.fillRect(e.x,e.y,e.w,e.h);ctx.fillStyle="#FFFBF2";ctx.font="10px Arial";ctx.fillText("🎪",e.x+8,e.y+22);
        if(roca.x+rRango>e.x&&roca.x-rRango<e.x+e.w&&roca.y+rRango>e.y&&roca.y-rRango<e.y+e.h){listaEnemigos.splice(i,1);puntuacion++;resetearRoca();if(puntuacion%2===0){lanzarPausaEducativa();}continue;}
        if(e.x<150){listaEnemigos.splice(i,1);vidas--;if(vidas<=0){finalizarPartida();return;}}
    }
    ctx.fillStyle="#FFFBF2";ctx.font="bold 13px 'Quicksand',sans-serif";ctx.fillText("🎪 Campamentos: "+puntuacion,20,30);ctx.fillText("🎓 Sabiduría: "+sabiduriaPuntos+" pts",240,30);
    ctx.fillText("Vidas Mixes: "+"❤️".repeat(vidas)+"🖤".repeat(3-vidas),20,53);bucleJuego=requestAnimationFrame(actualizarFotograma);
}
function obtenerPos(e){const r=canvas.getBoundingClientRect(),t=e.touches?e.touches:e;return{x:(t.clientX-r.left)*(canvas.width/r.width),y:(t.clientY-r.top)*(canvas.height/r.height)};}
function presionar(e){if(roca.lanzada||!activo)return;let pos=obtenerPos(e);if(Math.hypot(pos.x-roca.x,pos.y-roca.y)<30)arrastrando=true;}
function mover(e){if(!arrastrando)return;let pos=obtenerPos(e),dist=Math.hypot(pos.x-resortera.x,pos.y-resortera.y);if(dist<80){roca.x=pos.x;roca.y=pos.y;}}
function soltar(){if(!arrastrando)return;arrastrando=false;roca.vX=(resortera.x-roca.x)*0.15;roca.vY=(resortera.y-roca.y)*0.15;roca.lanzada=true;}
canvas.addEventListener("mousedown",presionar);canvas.addEventListener("mousemove",mover);window.addEventListener("mouseup",soltar);
canvas.addEventListener("touchstart",presionar);canvas.addEventListener("touchmove",mover);window.addEventListener("touchend",soltar);
function finalizarPartida(){
    pausarMotor();document.getElementById("pantalla-gameplay").style.display="none";document.getElementById("pantalla-final").style.display="block";let el=document.getElementById("resumen-final");
    el.innerHTML=vidas<=0?"🎒 **¡Defensa superada!** Los invasores avanzaron por la Sierra Norte. Lograste derribar "+puntuacion+" campamentos. ¡Inténtalo de nuevo con la fuerza de Condoy!":"🏆 **¡Victoria Épica!** Defendiste las montañas sagradas sumando "+sabiduriaPuntos+" pts de Sabiduría. ¡El Rey Condoy te nombra Guardián Supremo! 🌲";
}
function reiniciarMision(){document.getElementById("pantalla-final").style.display="none";comenzarAventura();}
</script>
</body>
</html>
