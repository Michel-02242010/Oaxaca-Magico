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
                $_SESSION['alumno_id'] = $f['id']; $_SESSION['alumno_nombre'] = $f['nombre_alumno'];
                header("Location: plataforma.php"); exit();
            } else $error = "¡Contraseña incorrecta!";
        } else {
            // ¡EL TRUCO MÁGICO!: Si no existe, lo guarda automáticamente en la base de datos
            $ins = mysqli_query($conexion, "INSERT INTO usuarios (nombre_alumno, usuario, contrasena, puntos_totales) VALUES ('$u_sql', '$u_sql', '$p', 0)");
            if ($ins) {
                $_SESSION['alumno_id'] = mysqli_insert_id($conexion); $_SESSION['alumno_nombre'] = $u;
                header("Location: plataforma.php"); exit();
            } else $error = "¡Error al registrar el alumno!";
        }
    } else { $_SESSION['alumno_nombre'] = $_POST['usuario']; header("Location: plataforma.php"); exit(); }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Oaxaca Mágico!</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif;

        background: linear-gradient(-45deg, #4A2E1B, #5C3A21, #8C4F2B, #361A0C);background-size: 400% 400%; animation: movF0 12s ease infinite; min-height: 100vh; margin: 0; display: flex; justify-content: center; align-items: center; overflow: hidden; position: relative; }
        @keyframes movF0 { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
        .intro-screen { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #1A0F08, #361A0C); z-index: 100; display: flex; flex-direction: column; justify-content: center; align-items: center; transition: transform 0.8s cubic-bezier(0.77, 0, 0.175, 1); }
        .title-main { font-family: 'Fredoka One', cursive; font-size: 56px; color: #FECE79; text-shadow: 4px 4px 0px #8C0902; margin: 0 0 10px 0; text-align: center; }
        .subtitle-sub { font-size: 20px; color: #FFFBF2; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 40px; text-shadow: 2px 2px 4px rgba(0,0,0,0.6); opacity: 0.9; }
        .btn-empezar { font-family: 'Quicksand', sans-serif; background: linear-gradient(135deg, #E6A341, #8C0902); color: white; border: none; padding: 20px 50px; font-size: 24px; font-weight: 700; border-radius: 20px; cursor: pointer; animation: pulso 1.5s infinite alternate; text-transform: uppercase; box-shadow: 0 0 20px rgba(230,163,65,0.4); }
        @keyframes pulso { 0% { transform: scale(1); } 100% { transform: scale(1.06); box-shadow: 0 0 35px rgba(230,163,65,0.7); } }
        .estrella, .burbuja, .chispa { position: absolute; border-radius: 50%; pointer-events: none; }
        .estrella { background: #FFFBF2; width: 4px; height: 4px; box-shadow: 0 0 8px #FFF; animation: titilar 2s infinite ease-in-out; }
        @keyframes titilar { 0%, 100% { opacity: 0.2; transform: scale(0.8); } 50% { opacity: 1; transform: scale(1.2); } }
        .burbuja { position: absolute; background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.25), rgba(230,163,65,0.1) 40%, rgba(140,9,2,0.2)); border: 1px solid rgba(255,255,255,0.3); animation: flotar 7s linear infinite; }
        @keyframes flotar { 0% { transform: translateY(110vh) scale(0.8); opacity: 0; } 10% { opacity: 0.7; } 100% { transform: translateY(-20vh) translateX(50px) scale(1.3); opacity: 0; } }
        .chispa { background: #FECE79; box-shadow: 0 0 12px #E6A341; animation: subirCh 5s linear infinite; }
        @keyframes subirCh { 0% { transform: translateY(110vh) scale(0.5); opacity: 0; } 100% { transform: translateY(-10vh) translateX(-30px) scale(1); opacity: 0; } }
        .login-box { background: rgba(26,15,8,0.85); backdrop-filter: blur(10px); border: 3px solid #E6A341; border-radius: 30px; max-width: 360px; width: 85%; padding: 35px 30px; text-align: center; box-shadow: 0 25px 50px rgba(0,0,0,0.7); z-index: 10; opacity: 0; transform: scale(0.8); transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .login-box.mostrar { opacity: 1; transform: scale(1); }
        h1 { font-family: 'Fredoka One', cursive; color: #fff; font-size: 32px; margin: 0 0 10px; } h1 span { color: #FECE79; } p { font-size: 15px; color: #FFFBF2; margin-bottom: 25px; }
        .lbl-datos { display: block; text-align: left; font-size: 14px; color: #FECE79; margin: 0 0 6px 4px; font-weight: 700; text-transform: uppercase; }
        input { font-family: 'Quicksand', sans-serif; width: 100%; padding: 14px 18px; box-sizing: border-box; border-radius: 14px; border: 2px solid #5C3A21; font-size: 16px; font-weight: 700; color: #fff; background: #2B160A; outline: none; margin-bottom: 16px; }
        input:focus { border-color: #FECE79; background: #1A0F08; }
        .btn-jugar { font-family: 'Quicksand', sans-serif; background: linear-gradient(135deg, #E6A341, #8C0902); color: #fff; border: none; padding: 16px; font-size: 19px; font-weight: 700; border-radius: 16px; cursor: pointer; width: 100%; margin-top: 10px; }
    </style>
</head>
<body>
    <audio id="musica" src="rojo.mp3" loop></audio>

    <div class="estrella" style="top: 15%; left: 12%;"></div>
    <div class="estrella" style="top: 25%; left: 78%;"></div>
    <div class="estrella" style="top: 70%; left: 18%;"></div>
    <div class="burbuja" style="left: 15%; width: 55px; height: 55px; animation-duration: 7s;"></div>
    <div class="burbuja" style="left: 65%; width: 50px; height: 50px; animation-duration: 9s;"></div>
    <div class="chispa" style="left: 40%; width: 6px; height: 6px; animation-duration: 6s;"></div>

    <div id="introScreen" class="intro-screen" <?php echo !empty($error) ? 'style="transform: translateY(-100%);"' : ''; ?>>
        <div class="burbuja" style="left: 5%; width: 45px; height: 45px; animation-duration: 6s;"></div>
        <div class="burbuja" style="left: 85%; width: 55px; height: 55px; animation-duration: 8s;"></div>
        <h1 class="title-main">OAXACA MÁGICO</h1>
        <h2 class="subtitle-sub">Mitos y Leyendas de Oaxaca</h2>
        <button type="button" id="btnEmpezar" class="btn-empezar">¡EMPEZAR AVENTURA! ➔</button>
    </div>

    <div id="loginBox" class="login-box <?php echo !empty($error) ? 'mostrar' : ''; ?>">
        <h1>¡Hola, <span>Amig@</span>!</h1><p>Escribe tus datos para comenzar la aventura.</p>
        <?php if(!empty($error)): ?><p style="color:#FF8A8A; font-weight:700; margin:0 0 15px;"><?php echo $error; ?></p><?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label class="lbl-datos">Nombre:</label>
            <input type="text" name="usuario" placeholder="Escribe tu usuario aquí" required autocomplete="off">
            <label class="lbl-datos">Grupo:</label>
            <input type="text" name="Grupo" placeholder="Escribe tu grupo" required autocomplete="off">
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
function togglePassword() {
    const inputPass = document.getElementById('txt-contrasena');
    const svgOjo = document.getElementById('svg-ojo');
    
    if (inputPass.type === 'password') {
        inputPass.type = 'text';
        // Código visual para el ojo abierto/activado (puedes cambiarle el color a tu dorado #FECE79 si quieres que resalte al mostrar)
        svgOjo.setAttribute('stroke', '#FECE79');
        svgOjo.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
    } else {
        inputPass.type = 'password';
        // Vuelve a estar oculto y en color blanco
        svgOjo.setAttribute('stroke', '#FFFFFF');
        svgOjo.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
    }
}
</script>

    </div>

    <script>
        <?php if (!empty($error)): ?> document.getElementById('introScreen').style.transform = 'translateY(-100%)'; document.getElementById('loginBox').classList.add('mostrar'); <?php endif; ?>
        document.getElementById('btnEmpezar').addEventListener('click', function() {
            document.getElementById('musica').play().catch(() => {});
            document.getElementById('introScreen').style.transform = 'translateY(-100%)';
            setTimeout(() => { document.getElementById('loginBox').classList.add('mostrar'); }, 400);
        });
    </script>
</body>
</html>