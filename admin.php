<?php
session_start();
if (empty($_SESSION["id"])) {
    header("location: login2.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="admin.php" id="navbar__logo"><img src="img/logo_tec.png" alt="Logo Tec Tepic">TeConecta Admin</a>
            <a href="index.php" class="navbar__links"><img src="img/administracion.png" alt="Salir"></a>
            <a href="controlador_cerrar_sesion.php" class="navbar__links"><img src="img/salida.png" alt="Salir"></a>
        </div>
    </nav>

    <main class="main">
        <div class="admin-container">
            <h1>Bienvenido al Panel de Administración</h1>
            <div class="admin-sections">
                <div class="admin-card">
                    <a href="gestion_usuarios.php">Gestión de Usuarios</a>
                </div>
                <div class="admin-card">
                    <a href="gestion_contenido.php">Gestión de Contenido</a>
                </div>
                <div class="admin-card">
                    <a href="estadisticas.php">Estadísticas</a>
                </div>
                <div class="admin-card">
                    <a href="reportes.php">Reportes</a>
                </div>
                <div class="admin-card">
                    <a href="gestion_foro.php">Gestión de Foros</a>
                </div>
                <div class="admin-card">
                    <a href="gestion_videos.php">Gestión de Videos</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>
</body>
</html>
