
<?php
include "admin/bd.php";
include "header.php";

$idForo = $_GET["id"];
$idUser = $_SESSION["id"];
$sql = "SELECT * FROM foro WHERE id_Foro = '$idForo'";

$resultado = mysqli_query($conexion, $sql);

echo "<div class='forum-container'>
            <h2> Discusion </h2>
        </div>";

if (mysqli_num_rows($resultado) > 0) {
    $row = mysqli_fetch_assoc($resultado);

    $titulo = $row["Titulo_Foro"];
    $descripcion = $row["Desc_Foro"];
    $fecha = $row["UltimaAct_Foro"];
    echo "<div class='forum-container'>
            <div class='thread'>
                <h3>$titulo</h3>
                <p>$descripcion</p>
                <p>Ultima Actualización: $fecha</p>
            </div>
          </div>";
} else {
    echo "No se encontró ningún foro";
}

echo "<div class='forum-container'>
            <h2> Respuestas </h2>
        </div>";
//Las respuestas

$sql2  = "SELECT * FROM contenido_foro cf LEFT JOIN usuario u ON cf.Usuario_id_User = u.id_User
          WHERE Foro_id_Foro = '$idForo' ORDER BY FechaCreacion_ContenidoF DESC";
$resultado2 = mysqli_query($conexion, $sql2);

if (mysqli_num_rows($resultado2)>0){
    while ($fila = mysqli_fetch_assoc($resultado2)){
        $comentario = $fila["Comentario_ContenidoF"];
        $id_contenidoF = $fila["id_ContenidoF"];
        $ultimaFecha = $fila["FechaCreacion_ContenidoF"];
        $foto =  $fila["Foto_User"];
        $id_usuario_comentario = $fila["Usuario_id_User"];
        
        if($id_usuario_comentario==$idUser)
        {
            echo "<div class='forum-container'>
                    <div class='thread'>";
                    if(!empty($foto)){
                        echo('<a href="perfil_alumno.php" class="navbar__links"><img style="margin-left: -650px; width: 50px; height: 50px; margin-top:10px;" src="data:image/jpeg;base64,'.base64_encode($foto).'" alt="Usuario" class="rounded-logo"></a>') ;
                        }else{
                            echo('<a href="perfil_alumno.php" class="navbar__links"><img style="margin-left: -650px; width: 50px; height: 50px; margin-top:10px;" src="img/profilephoto.png" alt="Usuario" class="rounded-logo"></a>') ;
                        }
                        
                        #<a href='perfil_alumno.php'><img src='$fotoPerfil' alt='Foto de perfil' style='width: 50px; height: 50px;'></a>
                        echo"
                        <p>$comentario</p><br/>
                        <p>Ultima Actualización: $ultimaFecha</p>
                    </div>
                   </div>";
        }else{
        echo "<div class='forum-container'>
                <div class='thread'>";
                    if(!empty($foto)){
                        echo('<a href="perfilUsuario.php?id='.$id_usuario_comentario.'" class="navbar__links"><img style="margin-left: -650px; width: 50px; height: 50px; margin-top:10px;" src="data:image/jpeg;base64,'.base64_encode($foto).'" alt="Usuario" class="rounded-logo"></a>') ;
                        }else{
                            echo('<a href="perfilUsuario.php?id='.$id_usuario_comentario.'" class="navbar__links"><img style="margin-left: -650px; width: 50px; height: 50px; margin-top:10px;" src="img/profilephoto.png" alt="Usuario" class="rounded-logo"></a>') ;
                        }
                    
                    #<a href='perfilUsuario.php?id=$id_usuario_comentario'><img src='$fotoPerfil' alt='Foto de perfil' style='width: 50px; height: 50px;'></a>
                    echo"
                    <p>$comentario</p><br/>
                    <p>Ultima Actualización: $ultimaFecha</p>";
                    echo "<a href='#' class='report-link' onclick='showForm($id_contenidoF)'><img class='img_report' src='img/reportar.png' alt='reportar' style='border: none; background: none;  margin-left:95%; '></a>";
                    echo "
                </div>
              </div>";
        }
    }
}else{
    echo "No se encontraron respuestas";
}
include "footer.php";
?>
<div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

<div id="formContainer" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); border-radius: 10px; z-index: 1000;">
    <form id="conditionalForm" method="POST" action="admin/reportar_CF.php" style="width: 100%; height: 100%;">
        <label style="font-size: 1.5em; margin-left:15%;">Reportar Comentario</label><br><br>
        <label for="razon">Razón del reporte:</label>
        <input type="text" id="razon" name="razon" required style="width: 100%;"><br><br>
        <input type="hidden" id="id_contenidoF" name="id_contenidoF">
        <div class="form-buttons" style="margin-top: 20px; text-align: center;">
            <button type="button" id="cancelButton" onclick="hideForm()" style="background-color: red; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">Cancelar</button>
            <button type="submit" id="acceptButton" style="background-color: blue; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Aceptar</button>
        </div>
    </form>
</div>

<script>
    function showForm(id_contenidoF) {
        document.getElementById('formContainer').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('id_contenidoF').value = id_contenidoF;
    }

    function hideForm() {
        document.getElementById('formContainer').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }

    document.getElementById('conditionalForm').addEventListener('submit', function(event) {
        hideForm();
    });

    document.getElementById('overlay').addEventListener('click', function() {
        hideForm();
    });
</script>