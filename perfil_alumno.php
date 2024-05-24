<?php
session_abort();
session_start();
if (empty($_SESSION["id"])) {
    header("location: login2.php");
}
$foto=$_SESSION["foto"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="css/Estilos.css">
</head>
<body>
    <?php include('header.php')?>
    <main class="main" style="padding: 80px 20px;">
        <div class="profile-container">
            <div class="profile-header">
            <?php
            if(!empty($foto)){
            echo '<a href="subir_foto.php"><img style="width: 120px; height: 120px;" src="data:image/jpeg;base64,'.base64_encode($foto).'"/></a>';
            }else{
                echo '<a href="subir_foto.php"><img style="width: 120px; height: 120px;" src="img/profilephoto.png"/></a>';
            }
            ?>
                
                <p><b>Correo Electrónico:</b> </p><?php  echo ("<p>" . $_SESSION['correo'] . "</p>");   ?>
                <p><b>Nombre de Usuario:</b><?php
                $name = $_SESSION["nombre"];
                $apeP = $_SESSION["apellidoP"];
                $apeM = $_SESSION["apellidoM"];
                $carre = $_SESSION["carrera"];
                echo ("<p>" . $name ." ". $apeP . " " . $apeM . "</p>");    
                #Cambiar los datos a variables locales, e imprimir esas, cambiarlas una vez se edite el usuario

                echo ("</p>");
                echo ("<p><b>Carrera:</b></p>");
                echo ("<p>". $carre ."</p>");
                ?>
                <button name="btn_editar" id="btn_editar" class ="btn_editar"><a href="editar_perfil.php" class="link">Editar</a></button>
                <br>
            </div>
            <div class="profile-info">
                <h2>Información Adicional</h2>
                <?php
                echo("<p><strong>Intereses:</strong> ".$_SESSION['intereses']."</p>");
                echo("<p><strong>Habilidades:</strong> ".$_SESSION['habilidades']."</p>");
                echo("<p><strong>Redes Sociales:</strong> ".$_SESSION['redes']."</p>");
                echo("<p><strong>Contacto:</strong> ".$_SESSION['contacto']."</p>");
                ?>
            </div>
        </div>
    </main>
        <center><p>Contacto: info@teconecta.com</p></center>
    <script src="/TeConecta/js/app.js"></script>

</body>
</html>
