<?php 
include "header.php";
include "admin/bd.php";

$idUser = $_GET["id"];

$sql = "SELECT * FROM usuario WHERE id_User = '$idUser'";

$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) > 0) {
    while($row = $resultado->fetch_assoc()) {
        $nombre = $row['Nom_User'];
        $id=$row['id_User'];
        $apellPat = $row['ApellPat_User'];
        $apellMat = $row['ApellMat_User'];
        $correo = $row['Correo_User'];
        $carrera = $row['Carre_User'];
        $foto = $row['Foto_User'];

        $nombreCompleto = $nombre ." ". $apellPat ." ".$apellMat;
        ?>
        <div class="main">  
            <div class="profile-container"  style="position: relative;">
                <?php
                 if(!empty($foto)){
                        echo('<img src="data:image/jpeg;base64,'.base64_encode($foto).'" alt="Usuario" class="profile-photo">') ;
                        }else{
                            echo('<img src="img/profilephoto.png" alt="Usuario" class="profile-photo">') ;
                        }
                        echo"<a href='#' class='report-link' onclick='showForm($id)'><img class='img_report' src='img/reportar.png' alt='reportar' style='border: none; background: none; position: absolute; top: 0; right: 0; margin: 20px;'></a>";
                #<img src="img/profilephoto.png" class="profile-photo">
                ?>
                <div class="profile-text">
                    <?php ?>
                    <h2><?php echo $nombreCompleto; ?></h2>
                    <p><strong>Correo Electrónico:</strong> <?php echo $correo; ?></p>
                    <p><strong>Nombre de Usuario:</strong> <?php echo $nombre;?></p>
                    <p><strong>Carrera:</strong> <?php echo $carrera;?> </p>
                </div>
                <div class="profile-info">
                    <h2>Información Adicional</h2>
                    <p><strong>Intereses:</strong> Desarrollo de Software, Inteligencia Artificial</p>
                    <p><strong>Habilidades:</strong> Programación en Python, Diseño Web</p>
                    <p><strong>Redes Sociales:</strong> LinkedIn, Twitter</p>
                    <p><strong>Contacto:</strong> Teléfono, Dirección</p>
                 </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "No se encontraron usuarios.";
}
include ("footer.php") ?>
<!-- Formulario modal y Overlay -->
<div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

<div id="formContainer" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); border-radius: 10px; z-index: 1000;">
    <form id="conditionalForm" method="POST" action="admin/reportar_usuario.php" style="width: 100%; height: 100%;">
        <label style="font-size: 1.5em; margin-left:25%;">Reportar Usuario</label><br><br>
        <label for="razon">Razón del reporte:</label>
        <input type="text" id="razon" name="razon" required style="width: 100%;"><br><br>
        <input type="hidden" id="id" name="id">
        <div class="form-buttons" style="margin-top: 20px; text-align: center;">
            <button type="button" id="cancelButton" onclick="hideForm()" style="background-color: red; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">Cancelar</button>
            <button type="submit" id="acceptButton" style="background-color: blue; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Aceptar</button>
        </div>
    </form>
</div>

<script>
    function showForm(id) {
        document.getElementById('formContainer').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('id').value = id;
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