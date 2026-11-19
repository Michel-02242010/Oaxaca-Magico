<?php
session_start(); if(file_exists("conexion.php"))include("conexion.php"); $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u = trim($_POST['usuario']); $g = trim($_POST['Grupo']); $p = $_POST['contrasena'];
    if (isset($conexion) && !empty($u) && !empty($p)) {
        $u_sql = mysqli_real_escape_string($conexion, $u);
        $res = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$u_sql'");
        if (mysqli_num_rows($res) == 1) {
            $f = mysqli_fetch_assoc($res);
               if ($p == $f['contrasena']) {
            $_SESSION['alumno_id'] = $f['id'];
            $_SESSION['alumno_nombre'] = $f['nombre_alumno'];

            if (isset($_POST['ir_al_mapa'])) {
                header("Location: MapaPlataforma/OaxacaMagico/index.html");
            } else {
                header("Location: inter.php");
            }
            exit();
        } else {
            $error = "¡Contraseña incorrecta!";
        }


        } else {
            // ¡EL TRUCO MÁGICO!: Si no existe, lo guarda automáticamente en la base de datos
            $ins = mysqli_query($conexion, "INSERT INTO usuarios (nombre_alumno, usuario, contrasena, puntos_totales) VALUES ('$u_sql', '$u_sql', '$p', 0)");
            if ($ins) {
                $_SESSION['alumno_id'] = mysqli_insert_id($conexion); $_SESSION['alumno_nombre'] = $u;
                header("Location: inter.php"); exit();
            } else $error = "¡Error al registrar el alumno!";
        }
    } else { $_SESSION['alumno_nombre'] = $_POST['usuario']; header("Location: inter.php"); exit(); }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Oaxaca Mágico!</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        
        @font-face {
    font-family: 'titulo'; 
    src: url('fuentes/titulo.otf') format('truetype'); 
}

@font-face {
    font-family: 'texto';
    src: url('fuentes/texto.otf') format('truetype');
}


@font-face {
    font-family: 'banana'; 
    src: url('fuentes/Yellow Banana.otf') format('truetype'); 
}

@font-face {
    font-family: 'butter'; 
    src: url('fuentes/butter.otf') format('truetype'); 
    
}

        body { font-family: 'Quicksand', sans-serif;

        background: linear-gradient(-45deg, #352317, #58361d, rgb(124, 69, 35), #361A0C);background-size: 400% 400%; animation: movF0 12s ease infinite; min-height: 100vh; margin: 0; display: flex;
         justify-content: center; align-items: center; overflow: hidden; position: relative; }
        @keyframes movF0 { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
        .intro-screen { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #1A0F08, #361A0C); z-index: 100; display: flex; flex-direction: column; background: transparent;
         justify-content: center; align-items: center; transition: transform 0.8s cubic-bezier(0.77, 0, 0.175, 1);  }
        .title-main { font-family: 'titulo'; font-size: 80px; color: #FECE79; text-shadow: 4px 4px 0px #8C0902; margin: 0 0 10px 0; text-align: center; }
        .subtitle-sub { font-size: 20px; color: #FFFBF2; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 40px; text-shadow: 2px 2px 4px rgba(0,0,0,0.6); opacity: 0.9; }
        .btn-empezar { background-color: transparent !important; border: none !important; outline: none !important;  box-shadow: none !important; padding: 0 !important;  background-image: url('img_inter/boton.png');
         background-size: 100% 100%;  background-position: center; width: 495px;  height:200px; display: inline-flex; justify-content: center; align-items: center; font-family: 'butter', sans-serif; color: #FBECC3; 
        font-size: 26px;  font-weight: 700; text-transform: uppercase; letter-spacing: 2px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.9);cursor: pointer; animation: pulso 1.5s infinite alternate; 
        transition: transform 0.2s ease, filter 0.2s ease; filter: drop-shadow(0 0 8px rgba(254, 206, 121, 0.6))}
        .btn-empezar:hover { transform: scale(1.03); filter: brightness(1.2) drop-shadow(0 0 20px rgba(245, 172, 44, 0.9)); }
        .btn-empezar:active { transform: scale(0.98);}
        @keyframes pulso { 0% { transform: scale(1); } 100% { transform: scale(1.06); box-shadow: 0 0 35px rgba(230,163,65,0.7); } }
        .estrella, .burbuja, .chispa { position: absolute; border-radius: 50%; pointer-events: none; }
        .estrella { background: #FFFBF2; width: 4px; height: 4px; box-shadow: 0 0 8px #FFF; animation: titilar 2s infinite ease-in-out; }
        @keyframes titilar { 0%, 100% { opacity: 0.2; transform: scale(0.8); } 50% { opacity: 1; transform: scale(1.2); } }
        .burbuja { position: absolute; background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.25), rgba(230,163,65,0.1) 40%, rgba(140,9,2,0.2)); border: 1px solid rgba(255,255,255,0.3); animation: flotar 7s linear infinite; }
        @keyframes flotar { 0% { transform: translateY(110vh) scale(0.8); opacity: 0; } 10% { opacity: 0.7; } 100% { transform: translateY(-20vh) translateX(50px) scale(1.3); opacity: 0; } }
        .chispa { background: #FECE79; box-shadow: 0 0 12px #E6A341; animation: subirCh 5s linear infinite; }
        @keyframes subirCh { 0% { transform: translateY(110vh) scale(0.5); opacity: 0; } 100% { transform: translateY(-10vh) translateX(-30px) scale(1); opacity: 0; } }
        .login-box { background: rgba(26,15,8,0.85); backdrop-filter: blur(10px); border: 3px solid #E6A341; border-radius: 30px; max-width: 360px; width: 85%; padding: 35px 30px; text-align: center;
         box-shadow: 0 25px 50px rgba(0,0,0,0.7); z-index: 10; opacity: 0; transform: scale(0.8); transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .login-box.mostrar { opacity: 1; transform: scale(1); }
        h1 { font-family: 'titulo', cursive; color: #fff; font-size: 32px; margin: 0 0 10px; } h1 span { color: #FECE79; } p { font-size: 15px; color: #FFFBF2; margin-bottom: 25px; }
        .lbl-datos { font-family:'texto'; display: block; text-align: left; font-size: 18px; color: #FECE79; margin: 0 0 6px 4px; font-weight: 700; text-transform: uppercase; letter-spacing:2px; }
        input { font-family: 'texto'; width: 100%; padding: 14px 18px; box-sizing: border-box; border-radius: 14px; border: 2px solid #5C3A21; font-size: 16px; font-weight: 700; color: #fff; background: #2B160A; outline: none; margin-bottom: 16px; }
        input:focus { border-color: #FECE79; background: #1A0F08; }
 .btn-jugar { font-family: 'butter', sans-serif; 
       display: inline-block;
       width: 700;
        background: linear-gradient(135deg, #E6A341, #8C0902); 
        color: #fff; 
        border: none; 
        padding: 16px; 
        font-size: 19px; 
        font-weight: 700; 
        border-radius: 16px; 
        cursor: pointer; 
        width: 100%; 
        margin-top: 10px; 
        letter-spacing: 2px; }       
        p{font-family:"texto"; font-size:18px; text-align: center; color:white;}
        .pointer-particles {position: fixed; top: 0; left: 0; width: 100%; height: 100vh; z-index: 1; pointer-events: none; }

        .btn-jugar { font-family: 'Quicksand', sans-serif; background: linear-gradient(135deg, #E6A341, #8C0902); color: #fff; border: none; padding: 16px; font-size: 19px; font-weight: 700; border-radius: 16px; cursor: pointer; width: 100%; margin-top: 10px; }
        .contenedor-casilla { display: flex; align-items: center; gap: 10px; margin: 5px 0 15px 4px; color: #FFFBF2; font-size: 14px; font-weight: bold; text-align: left; cursor: pointer; }
        .contenedor-casilla input { width: auto; margin: 0; accent-color: #E6A341; cursor: pointer; }

        /* Diseño base y posición fija en la esquina superior derecha */
#btn-profa-login.boton-uiverse-rpg {
    position: fixed;
    top: 25px;
    right: 25px;
    z-index: 99999;
    
    /* Tamaño ajustado para que quepa el texto largo sin deformarse */
    width: auto;
    height: auto;
    padding: 12px 22px;
    margin-bottom: 0;
    
    /* Colores café madera de tu diseño RPG */
    border-radius: 6px;
    border: 2px solid #3b1907;
    background-color: #3b1907;
    box-shadow: 0 4px 6px rgba(0,0,0,0.3);
    overflow: hidden;
    transition: all 0.5s ease-in;
    cursor: pointer;
}

/* Cortinas internas animadas (Rojo Vino y Café Místico) */
#btn-profa-login.boton-uiverse-rpg::before,
#btn-profa-login.boton-uiverse-rpg::after {
    content: '';
    position: absolute;
    top: 0;
    width: 0;
    height: 100%;
    transform: skew(15deg);
    transition: all 0.5s;
    overflow: hidden;
    z-index: -1;
}

#btn-profa-login.boton-uiverse-rpg::before {
    left: -10px;
    background: #895737;
}

#btn-profa-login.boton-uiverse-rpg::after {
    right: -10px;
    background: #c08552;
}

/* Efecto al pasar el mouse (Hover) */
#btn-profa-login.boton-uiverse-rpg:hover::before,
#btn-profa-login.boton-uiverse-rpg:hover::after {
    width: 58%;
}

/* Estilo del texto color crema pergamino */
#btn-profa-login.boton-uiverse-rpg span {
    color: #FBECC3;
    font-family: 'butter', sans-serif;
    font-size: 14px;
    font-weight: bold;
    transition: all 0.3s ease-in;
    letter-spacing: 1px;
    position: relative;
    z-index: 2;
}

        
    </style>
</head>
<body>
     <pointer-particles style="position: absolute; 
 top: 0;
  left: 0;
  width: 100%; 
  height: 100%; 
 min-height: 100vh;
  z-index: 1; 
  pointer-events: none; 
  display: block;"></pointer-particles>
  
      <script src="js/particulas_index.js"></script>
    <!-- Botón solicitado por la profa, se activa solo en esta pantalla -->
     <button type="button" onclick="irALoginDirecto()" id="btn-profa-login" class="boton-uiverse-rpg" style="display: none;">
    <span> 🏰 YA TENGO UNA CUENTA 🗺️</span>
</button>

    <audio id="musica" src="rojo.mp3" loop></audio>


    <div id="introScreen" class="intro-screen" <?php echo !empty($error) ? 'style="transform: translateY(-100%);"' : ''; ?>>
        <h1 class="title-main">OAXACA MÁGICO</h1>
        <h2 class="subtitle-sub">Mitos y Leyendas de Oaxaca</h2>
     <button type="button" id="btnEmpezar" class="btn-empezar">¡EMPEZAR AVENTURA!</button>
    </div>

    <div id="loginBox" class="login-box <?php echo !empty($error) ? 'mostrar' : ''; ?>">
        <h1>¡Hola, <span>Amig@</span>!</h1><p>Escribe tus datos para comenzar la aventura.</p>
        <?php if(!empty($error)): ?><p style="color:#FF8A8A; font-weight:700; margin:0 0 15px;"><?php echo $error; ?></p><?php endif; ?>
       <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="guardarUsuarioMistico()">
            <label class="lbl-datos">Nombre:</label>
            <input type="text" name="usuario" placeholder="Escribe tu usuario aquí" required autocomplete="off">
            <div id="contenedor-grupo">
    <label class="lbl-datos" id="lbl-grupo">Grupo:</label>
    <input type="text" name="Grupo" id="txt-grupo" placeholder="Escribe tu grupo" required autocomplete="off">
</div>
            <label class="lbl-datos">Contraseña:</label>
<div class="password-contenedor" style="position: relative; width: 100%;">
    <input type="password" name="contrasena" id="txt-contrasena" placeholder="Escribe tu clave secreta" required style="width: 100%; padding-right: 45px; box-sizing: border-box;">
    <span id="btn-ojo" onclick="togglePassword()" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; display: flex; align-items: center;">
        <!-- Icono del ojito blanco brillante -->
        <svg id="svg-ojo" xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 22px; height: 22px; transition: 0.2s;">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        </svg>
    </span>
</div>
            <button class="btn-jugar" type="submit">INGRESAR</button>
        </form>
          <script>
        // 1. Función para cambiar al login de usuarios con cuenta
        function irALoginDirecto() {
            const contenedorGrupo = document.getElementById('contenedor-grupo');
            const txtGrupo = document.getElementById('txt-grupo');
            const btnEnviar = document.querySelector('.btn-jugar');
            const tituloCaja = document.querySelector('#loginBox h1');

            // Creamos la marca oculta para avisarle a PHP que vaya directo al mapa
            let checkMapa = document.querySelector('input[name="ir_al_mapa"]');
            if (!checkMapa) {
                checkMapa = document.createElement('input');
                checkMapa.type = 'hidden';
                checkMapa.name = 'ir_al_mapa';
                document.querySelector('form').appendChild(checkMapa);
            }

            // Modificamos la interfaz para el alumno con cuenta
            if (contenedorGrupo) contenedorGrupo.style.display = 'none';
            if (txtGrupo) txtGrupo.removeAttribute('required');
            if (tituloCaja) tituloCaja.innerHTML = "¡Inicia <span>Sesión</span>!";
            if (btnEnviar) btnEnviar.innerText = "INGRESAR AL MAPA ➔";
            
            checkMapa.value = 'si';

            // Saltamos la pantalla inicial si sigue visible y mostramos el login
            const introScreen = document.getElementById('introScreen');
            const loginBox = document.getElementById('loginBox');
            if (introScreen) introScreen.style.transform = 'translateY(-100%)';
            if (loginBox) loginBox.classList.add('mostrar');
        }

        // 2. Conexión directa al botón para asegurar que nunca falle el clic
        const btnProfa = document.getElementById('btn-profa-login');
        if (btnProfa) {
            btnProfa.addEventListener('click', irALoginDirecto);
        }

        // 3. Función del ojito de la contraseña
        function togglePassword() {
            const inputPass = document.getElementById('txt-contrasena');
            const svgOjo = document.getElementById('svg-ojo');
            
            if (inputPass.type === 'password') {
                inputPass.type = 'text';
                svgOjo.setAttribute('stroke', '#FECE79');
                svgOjo.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                inputPass.type = 'password';
                svgOjo.setAttribute('stroke', '#FFFFFF');
                svgOjo.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        // 4. Memorizar usuario
        function guardarUsuarioMistico() {
            const inputUsuario = document.querySelector('input[name="usuario"]');
            if (inputUsuario && inputUsuario.value.trim() !== "") {
                localStorage.setItem('explorador_usuario', inputUsuario.value.trim());
            }
        }

        // 5. Control de error PHP y botón "¡EMPEZAR AVENTURA!"
        <?php if (!empty($error)): ?> 
            document.getElementById('introScreen').style.transform = 'translateY(-100%)'; 
            document.getElementById('loginBox').classList.add('mostrar'); 
            document.getElementById('btn-profa-login').style.display = 'block';
        <?php endif; ?>

        document.getElementById('btnEmpezar').addEventListener('click', function() {
            document.getElementById('musica').play().catch(() => {});
            document.getElementById('introScreen').style.transform = 'translateY(-100%)';
            setTimeout(() => { 
                document.getElementById('loginBox').classList.add('mostrar'); 
                document.getElementById('btn-profa-login').style.display = 'block';
            }, 400);
        });
    </script>
</body>
</html>
