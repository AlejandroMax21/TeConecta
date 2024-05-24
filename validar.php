<?php
include("db.php");
session_abort();
session_start();


$usuario = $_POST["usuario"];
$password = $_POST["password"];


$consulta="SELECT* FROM usuario WHERE Correo_User= '$usuario' and Contra_User= '$password'  ";

$resultado=mysqli_query($conexion,$consulta);
#Obtener datos del usuario
$sql=$conexion->query("SELECT* FROM usuario WHERE Correo_User= '$usuario' and Contra_User= '$password' ");
$datos=$sql->fetch_object();
#Datos recopilados
$filas=mysqli_num_rows($resultado);
if(!empty($usuario) or !empty($password)){
if($filas){
    $_SESSION["id"] = $datos->id_User;
    $_SESSION["nombre"] = $datos->Nom_User;
    $_SESSION["apellidoP"] = $datos->ApellPat_User;
    $_SESSION["apellidoM"] = $datos->ApellMat_User;
    $_SESSION["correo"] = $datos->Correo_User;
    $_SESSION["carrera"] = $datos->Carre_User;
    $_SESSION["perfil"] = $datos->Perfil_User;
    $_SESSION["foto"] = $datos->Foto_User;
    $_SESSION["intereses"] = $datos->Intereses_User;
    $_SESSION["habilidades"] = $datos->Habilidades_User;
    $_SESSION["redes"] = $datos->RedesSociales_User;
    $_SESSION["contacto"] = $datos->Contacto_User;
    #$_SESSION["foto"] = !empty($fotoPerfilUsuario) ? $fotoPerfilUsuario: "img/profilephoto.png";
    $conexion->close();
    if($_SESSION["perfil"]=="Administrador"){
        header("location: admin.php");
    }else{
        header("location: index.php");
    }
    
}else{ 
    include("login2.php");
    echo "<script>
            alert('Correo o contraseña equivocada');
            </script>";
}
}else{include("login2.php");
    echo "<script>
            alert('Rellena todos los campos');
            </script>";
    }
mysqli_free_result( $resultado );
mysqli_close($conexion);
?>