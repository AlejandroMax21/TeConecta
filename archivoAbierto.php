<?php include ('header.php');
if (empty($_SESSION["id"])) {
    header("location: login2.php");
}
$idUser = $_SESSION["id"];
?>
    <div class="main-arch-container">
            <div class="archivo-panel">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "teconecta";
                $id_publicacion = $_GET['id_publicacion'];

                $conn = new mysqli($servername, $username, $password, $database);

                // Consulta SQL 
                $sql = "SELECT c.id_Publi, c.Titulo_Publi, c.Tema_Publi, c.Fecha_Publi, 
                            CONCAT('admin/', SUBSTRING(c.Archivo_Publi, LOCATE('files/', c.Archivo_Publi))) AS Archivo_Publi, 
                            CASE WHEN v.Punto_Valor IS NULL THEN '--' ELSE v.Punto_Valor END AS Punto_Valor, 
                            u.Nom_User, u.ApellPat_User 
                        FROM contenido c 
                        INNER JOIN usuario u ON c.Usuario_id_User = u.id_User 
                        LEFT JOIN valoracion v ON c.id_Publi = v.Contenido_id_Publi 
                        WHERE id_Publi = '$id_publicacion'";
                        
                // Ejecutar la consulta
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $archivo_publi = $row["Archivo_Publi"];
                    echo "<iframe src='https://docs.google.com/gview?url=$archivo_publi&embedded=true' frameborder='0'></iframe>";
                    //echo "<embed src='$archivo_publi' type=''>";
                } else {
                    echo "No se encontraron resultados para la publicación con el ID $id_publicacion.";
                }

                ?>
            </div>
            <div class="comentarios">
                <?php
                include "admin/bd.php";
                $id=$_SESSION["id"];

                //Consulta SQL 
                $sql = "SELECT c.id_Coment, 
                        u.id_User, u.Nom_User, u.ApellPat_User, u.ApellMat_User, u.Foto_User,
                        c.Contenido_id_Publi, c.Contenido_Coment, c.Fecha_Coment 
                        FROM comentario c 
                        INNER JOIN contenido con 
                        ON c.Contenido_id_Publi = con.id_Publi INNER JOIN 
                        usuario u ON c.Usuario_id_User = u.id_User 
                        WHERE con.id_Publi = '$id_publicacion'";
                // Ejecutar la consulta
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $idCom = $row["id_Coment"];
                        $id_usuario_comentario = $row["id_User"];
                        echo "<div class='comentarios-panel'>";
                        echo"<a href='#' class='report-link' onclick='showForm($idCom)'><img class='img_report' src='img/reportar.png' alt='reportar' ></a>";
                        if($id_usuario_comentario==$idUser){
                            if(!empty($row["Foto_User"])){
                                echo('<a href="perfil_alumno.php" ><img class="caliImg" src="data:image/jpeg;base64,'.base64_encode($row["Foto_User"]).'" alt="Usuario" class="rounded-logo"></a>') ;
                            }else{
                                echo('<a href="perfil_alumno.php" ><img class="caliImg" src="img/profilephoto.png" alt="Usuario" class="rounded-logo"></a>') ;
                            }
                        }else{

                            if(!empty($row["Foto_User"])){
                                echo('<a href="perfilUsuario.php?id='.$id_usuario_comentario.'" ><img class="caliImg" src="data:image/jpeg;base64,'.base64_encode($row["Foto_User"]).'" alt="Usuario" class="rounded-logo"></a>') ;
                            }else{
                                echo('<a href="perfilUsuario.php?id='.$id_usuario_comentario.'" ><img class="caliImg" src="img/profilephoto.png" alt="Usuario" class="rounded-logo"></a>') ;
                            }
                        }
                        echo "<h1>{$row["Nom_User"]} {$row["ApellPat_User"]} {$row["ApellMat_User"]}</h2>";
                        echo "<h2>{$row["Fecha_Coment"]}</h3>";
                        echo "<p>{$row["Contenido_Coment"]}</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='comentarios-panel'>";
                    echo "<h2 class='nocom'>¡Se el primero en dar retroalimentación o deja un comentario positivo!</h2>";
                    echo "</div>";
            }
                ?>
            </div>
            <div class="descripcion">
                <div class="descripcion-panel">
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "teconecta";
                    $id_publicacion = $_GET['id_publicacion'];

                    $conn = new mysqli($servername, $username, $password, $database);

                    $sql = "SELECT c.id_Publi, c.Titulo_Publi, c.Tema_Publi, c.Fecha_Publi, 
                                CONCAT('admin/', SUBSTRING(c.Archivo_Publi, LOCATE('files/', c.Archivo_Publi))) AS Archivo_Publi, 
                                CASE WHEN v.Punto_Valor IS NULL THEN '--' ELSE v.Punto_Valor END AS Punto_Valor, 
                                u.Nom_User, u.ApellPat_User, u.Foto_User
                            FROM contenido c 
                            INNER JOIN usuario u ON c.Usuario_id_User = u.id_User 
                            LEFT JOIN valoracion v ON c.id_Publi = v.Contenido_id_Publi 
                            WHERE id_Publi = '$id_publicacion'";

                    // Ejecutar la consulta
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $id_publi=$id_publicacion;
                        $row = $result->fetch_assoc();
                        if(!empty($row["Foto_User"])){
                            echo('<a href="perfil_alumno.php" ><img class="caliImg" src="data:image/jpeg;base64,'.base64_encode($row["Foto_User"]).'" alt="Usuario" class="rounded-logo"></a>') ;
                            }else{
                                echo('<a href="perfil_alumno.php" ><img class="caliImg" src="img/profilephoto.png" alt="Usuario" class="rounded-logo"></a>') ;
                            }
                        echo "<h1>{$row["Titulo_Publi"]}</h1>";
                        echo "<h2 class='nombre-autor'>{$row["Nom_User"]} {$row["ApellPat_User"]} </h2>";
                        echo"<a href='#' class='report_contenido' onclick='showForm1($id_publi)'><img class='img_report' src='img/reportar.png' alt='reportar' ></a>";
                        echo "<p>{$row["Tema_Publi"]}</p>";
                        echo "<h3>Fecha: {$row["Fecha_Publi"]}</h3>";
                        echo "<h2 class='CalNumero'>Calificacion:</h2>";
                        //{$row["Punto_Valor"]}
                    } else {
                        echo "No se encontraron resultados para la publicación con el ID $id_publicacion.";
                    }

                    $sql_avg = "SELECT AVG(Punto_Valor) as promedio FROM valoracion WHERE Contenido_id_Publi = '$id_publicacion'";
                    $result_avg = $conn->query($sql_avg);

                    $promedio = 0;
                    if ($result_avg->num_rows > 0) {
                        $row_avg = $result_avg->fetch_assoc();
                        $promedio = round($row_avg["promedio"]);
                    }

                    ?>
                    <form  method="post" id="form-calif">
                        <input type="textCalif" id="calificacion" name="calificacion" value="<?php echo htmlspecialchars($promedio); ?>">
                    </form>
                </div>
            </div>
            <div class="comentar">
                <?php
                include('admin/bd.php');
                $idPubli = $_GET["id_publicacion"];
                ?>
                <form method="POST" id="form-data" enctype="multipart/form-data" action="admin/enviarComentario.php">
                    <input type="hidden" name="id_publicacion" value="<?php echo $idPubli; ?>">
                    <textarea name="comentario" id="AreaComentar" class="comentario" placeholder="Escribe tu comentario aquí..."></textarea>
                    <button type="submit" class="BotonComentar">Comentar</button> 
                </form>
            </div>

        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calificacion'])) {
            $nuevo_valor = $conn->real_escape_string($_POST['calificacion']);

            if ($nuevo_valor < 101 && $nuevo_valor > 0) {

                $sql_check = "SELECT * FROM valoracion WHERE Contenido_id_Publi='$id_publicacion' AND Usuario_id_User='$id'";
                $result_check = $conn->query($sql_check);

                if ($result_check->num_rows > 0) {
                    $sql_update = "UPDATE valoracion SET Punto_Valor='$nuevo_valor' WHERE Contenido_id_Publi='$id_publicacion' AND Usuario_id_User='$id'";
                    if ($conn->query($sql_update) === TRUE) {
                        echo "<script>
                            window.location.href = window.location.href;
                        </script>";
                    } else {
                        $mensaje = "Error actualizando el registro: " . $conn->error;
                    }
                } else {
                    $sql_insert = "INSERT INTO valoracion (Usuario_id_User, Contenido_id_Publi, Punto_Valor) VALUES ('$id', '$id_publicacion', '$nuevo_valor')";
                    if ($conn->query($sql_insert) === TRUE) {
                        $mensaje = "Valoración añadida exitosamente";
                        $promediar = "INSERT INTO valoracion (Usuario_id_User, Contenido_id_Publi, Punto_Valor) VALUES ('$id', '$id_publicacion', '$nuevo_valor')";
                        echo "<script>
                            window.location.href = window.location.href;
                        </script>";
                    } else {
                        $mensaje = "Error añadiendo la valoración: " . $conn->error;
                    }
                }
            } else {
                echo "<script>
                    alert('Calificación debe ser menor a 100 y mayor a 0');
                </script>";
            }
        }
        ?>

<script>
            var forms = document.querySelectorAll('form#form-calif');

            forms.forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    var formData = new FormData(form);

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "archivoAbierto.php?id_publicacion=<?php echo $id_publicacion; ?>", true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var response = xhr.responseText;
                            console.log(response);
                            window.location.reload();
                        }
                    };
                    xhr.send(formData);
                });
            });
        </script>

    
</body>
<!-- Formulario modal y Overlay -->
<div id="overlay1" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

<div id="formContainer1" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); border-radius: 10px; z-index: 1000;">
    <form id="conditionalForm1" method="POST" action="admin/reportar_Contenido.php" style="width: 100%; height: 100%;">
        <label style="font-size: 1.5em; margin-left:25%;">Reportar Publicación</label><br><br>
        <label for="razon">Razón del reporte:</label>
        <input type="text" id="razon" name="razon" required style="width: 100%;"><br><br>
        <input type="hidden" id="id_publi" name="id_publi">
        <div class="form-buttons" style="margin-top: 20px; text-align: center;">
            <button type="button" id="cancelButton" onclick="hideForm1()" style="background-color: red; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">Cancelar</button>
            <button type="submit" id="acceptButton" style="background-color: blue; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Aceptar</button>
        </div>
    </form>
</div>

<script>
    function showForm1(id_publi) {
        document.getElementById('formContainer1').style.display = 'block';
        document.getElementById('overlay1').style.display = 'block';
        document.getElementById('id_publi').value = id_publi;
    }

    function hideForm1() {
        document.getElementById('formContainer1').style.display = 'none';
        document.getElementById('overlay1').style.display = 'none';
    }

    document.getElementById('conditionalForm1').addEventListener('submit', function(event) {
        hideForm1();
    });

    document.getElementById('overlay1').addEventListener('click', function() {
        hideForm1();
    });
</script>
<!-- Formulario modal y Overlay -->
<div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

<div id="formContainer" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); border-radius: 10px; z-index: 1000;">
    <form id="conditionalForm" method="POST" action="admin/reportar_Com_Cont.php" style="width: 100%; height: 100%;">
        <label style="font-size: 1.5em; margin-left:25%;">Reportar Comentario</label><br><br>
        <label for="razon">Razón del reporte:</label>
        <input type="text" id="razon" name="razon" required style="width: 100%;"><br><br>
        <input type="hidden" id="idCom" name="idCom">
        <div class="form-buttons" style="margin-top: 20px; text-align: center;">
            <button type="button" id="cancelButton" onclick="hideForm()" style="background-color: red; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">Cancelar</button>
            <button type="submit" id="acceptButton" style="background-color: blue; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Aceptar</button>
        </div>
    </form>
</div>

<script>
    function showForm(idCom) {
        document.getElementById('formContainer').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('idCom').value = idCom;
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
</html>