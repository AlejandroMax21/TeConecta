
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="css/editar_perfil.css">
</head>
<body>
    <?php include('header.php');
    $name=$_SESSION["nombre"];
    $apep=$_SESSION["apellidoP"];
    $apem=$_SESSION["apellidoM"];
    $int=$_SESSION["intereses"] ;
    $hab=$_SESSION["habilidades"];
    $red=$_SESSION["redes"] ;
    $con=$_SESSION["contacto"];?>
    <main class="main">
        <form class="cuadro" action= "admin/editar.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label><br>
                <input type="text" id="nombre" name="nombre" onkeypress="return SoloLetras(event);" required <?php echo'value="'.$name.'"'?>>
            </div>
            <div class="form-group">
                <label for="apellidoP">Apellido Paterno:</label><br>
                <input type="text" id="apellidoP" name="apellidoP" onkeypress="return SoloLetras(event);" required <?php echo'value="'.$apep.'"'?>>
            </div>
            <div class="form-group">
                <label for="apellidoM">Apellido Materno:</label><br>
                <input type="text" id="apellidoM" name="apellidoM" onkeypress="return SoloLetras(event);" required <?php echo'value="'.$apem.'"'?>>
            </div>
            <div class="form-group">
                <label for="interes">Interes:</label><br>
                <input type="text" id="interes" name="interes" <?php echo'value="'.$int.'"'?>>
            </div>
            <div class="form-group">
                <label for="habilidad">Habilidades:</label><br>
                <input type="text" id="habilidad" name="habilidad" <?php echo'value="'.$hab.'"'?>>
            </div>
            <div class="form-group">
                <label for="redes">Redes Sociales:</label><br>
                <input type="text" id="redes" name="redes" <?php echo'value="'.$red.'"'?>>
            </div>
            <div class="form-group">
                <label for="contacto">Contacto:</label><br>
                <input type="text" id="contacto" name="contacto" <?php echo'value="'.$con.'"'?>>
            </div>
            <button name="btn_guardar" id="btn_guardar" class ="btn_guardar">Guardar</button>
        </form>
        
    </div>
    
    </main>
    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>
    <script>
        function SoloLetras(event) {
            var letra = event.keyCode;
            if((letra>64 && letra<91)||(letra>96 && letra<123) || (letra ==8) || (letra==32)){
                return true;
            }else{return false;}
        }
    </script>

</body>
</html>