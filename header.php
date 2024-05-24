<?php
session_abort();
session_start();    
$foto=$_SESSION["foto"];
if (empty($_SESSION["id"])) {
    header("location: login2.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeConecta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/Styless.css">
    <link rel="stylesheet" href="css/Index.css"> 
    <link rel="stylesheet" href="css/busqueda.css">
    <link rel="stylesheet" href="css/Estilos.css">
    <link rel="stylesheet" href="css/Archi.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="z-index:1100">
        <div class="navbar__container">   
            <a1 href="index.php" id="navbar__logo"><img src="img/logo tec tepic.png" alt="logo">TeConecta</a1>
            <div class="navbar__toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar__menu">
                <?php
                if($_SESSION["perfil"]=="Administrador"){
                    echo'<li class="navbar__item">
                        <a href="admin.php" class="navbar__links"><img src="img/administracion.png" alt="Subir"></a>
                    </li>';
                }?>
                
                <li class="navbar__item">
                    <a href="subirDocs.php" class="navbar__links"><img src="img/subir.png" alt="Subir"></a>
                </li>     
                <li class="navbar__item">
                    <a href="Busqueda.php" class="navbar__links"><img src="img/lupa.png" alt="Buscar"></a>
                </li>
                <li class="navbar__item">
                    <a href="guardados.php" class="navbar__links"><img src="img/guardar.png" alt="Guardar"></a>
                </li>
                <li class="navbar__item">
                    <a href="foro.php" class="navbar__links"><img src="img/mensaje.png" alt="Mensaje"></a>
                </li>
                <li class="navbar__item">
                    <a href="index.php" class="navbar__links"><img src="img/casa.png" alt="Casa"></a>
                </li>
                <li class="navbar__item_usuario">
                    <?php
                    if(!empty($foto)){
                    echo('<a href="perfil_alumno.php" class="navbar__links"><img style="width: 50px; height: 50px;" src="data:image/jpeg;base64,'.base64_encode($foto).'" alt="Usuario" class="rounded-logo"></a>') ;
                    }else{
                        echo('<a href="perfil_alumno.php" class="navbar__links"><img style="width: 50px; height: 50px;" src="img/profilephoto.png" alt="Usuario" class="rounded-logo"></a>') ;
                    }
                    ?>
                </li>
                <li class="navbar__item"><a href="controlador_cerrar_sesion.php" class="navbar__links"><img src="img/salida.png" alt="Salir"></a></li>
                <li>
                    <button class="switch" id="switch">
                    <span><i class="fa-solid fa-sun"></i></span>
                    <span><i class="fa-solid fa-moon"></i></span>
                </button>
                </li>
            </ul>
        </div>
    </nav>

    <aside class ="arreglar">
            <section class="menu-options">
                <h4>Menú</h4>
                <ul>
                <li><a href="videos.php">Galería de videos</a></li>
                    <li><a href="mis_archivos.php">Mis archivos</a></li>
                    <li><a href="fullArchivos.php">Todos los archivos</a></li>
                </ul>
            </section>
            <section class="categories">
                <h4>Categorías</h4>
                <ul>
                    <li><a href="verCategoria.php?cat=Ingenieria en Sistemas Computacionales">Ingeniería en Sistemas</a></li>
                    <li><a href="verCategoria.php?cat=Ingenieria Civil">Ingeniería Civil</a></li>
                    <li><a href="verCategoria.php?cat=Ingenieria Industrial">Ingeniería Industrial</a></li>
                    <li><a href="verCategoria.php?cat=Administracion">Administración</a></li>
                    <li><a href="verCategoria.php?cat=Arquitectura">Arquitectura</a></li>
                    <li><a href="verCategoria.php?cat=Ingenieria Mecatronica">Ing. Mecatronica</a></li>
                    <li><a href="verCategoria.php?cat=Ingenieria Electrica">Ing. Electrica</a></li>
                </ul>
            </section>
    </aside>
    
    <script src="js/tema.js"></script>
    <script src="js/noti.js"></script>
</body>
</html>