<?php 

session_abort();
session_start();
if (empty($_SESSION["id"])) {
    header("location: login2.php");
}

include "header.php";
include "admin/bd.php";

$idForo = $_GET["id"];
$sql = "SELECT Titulo_Foro FROM foro WHERE id_Foro = '$idForo'";
$resultado = mysqli_query($conexion, $sql);

if($resultado && mysqli_num_rows($resultado)>0){
  $fila = mysqli_fetch_assoc($resultado);
  $titulo = $fila["Titulo_Foro"];
}else{
  $titulo = "Titulo no encontrado";
}

?>

<form method="POST" action="admin/comentarios.php" enctype="multipart/form-data">
    <div class="col-md-6 offset-md-3">
      <label for="disabledTextInput" class="form-label">Titulo:</label>
      <input type="text" id="disabledTextInput" class="form-control" placeholder='<?= $titulo ?>' readonly>
      <input type="hidden" name="id" value='<?= $idForo ?>'>
        <label for="exampleFormControlTextarea1" class="form-label">Comentar:</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" name ="comentario" rows="3"></textarea>
        <button type="submit" class="submit-btn">Confirmar</button>
    </div>
</form>
<?php include "footer.php"?>