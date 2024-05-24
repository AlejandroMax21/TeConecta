<?php
session_abort();
session_start();
if (!empty($_SESSION["id"])) {
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/Login.css">
    <title>TeConecta</title>
</head>
<body>
<header class="header"> <!-- Encabezado principal -->
        <h1>TeConecta</h1> <!-- Cambiado a h1 -->
        <h2>"Conéctate con el conocimiento, conecta con el mundo".</h2>
    </header>
    <img src="img/escudo_itt_grande.png">
    <section>
        <form method="post" action="validar.php">
            <h1>Inicio</h1>
            <div class="inputbox">
                <ion-icon name="mail-outline"></ion-icon>
                <input name="usuario" id="usuario" type="email" title="Ingresa el usuario">
                <label>Usuario</label>
            </div>
            <div class="inputbox">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input name="password" id="password" type="password" title="Ingresa la contraseña">
                <label>Contraseña</label>
            </div>
            <div class="forget">
                <a href="contra_forg.html">Olvide mi contraseña</a>
            </div>
            <button name="btn_ingresar" id="btn_ingresar"> Iniciar</button>
        </form>
    </section>
    <center> <p class="footer-text">¡Conócenos!<br> Somos una plataforma dedicada a compartir conocimiento y experiencias.<br>Te ofrecemos un espacio donde puedes aprender de otros usuarios y compartir tus conocimientos.<br>¡Ponte en contacto y únete a nuestra comunidad para formar parte de esta experiencia de aprendizaje colaborativo!<br>Contacto: teconecta450@gmail.com</p></center>
    <script src="js/tema.js"></script>
</body>
</html>