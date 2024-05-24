<?php
session_abort();
session_start();
if (empty($_SESSION["id"])) {
    header("location: login2.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Videos</title>
    <link rel="stylesheet" href="css/videos.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <?php include("header.php"); ?>
    <main class="main">
    <div class="video-upload-form">
            <h2>Subir Nuevo Video</h2>
            <form id="video-upload-form" method="post">
                <div class="form-group">
                    <label for="video-title">Título del Video:</label>
                    <input type="text" id="video-title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="video-carrera">Carrera:</label>
                    <select id="video-carrera" name="carrera">
                        <option value="Ingenieria en Sistemas">Ingeniería en Sistemas</option>
                        <option value="Ingenieria Civil">Ingeniería Civil</option>
                        <option value="Ingenieria Industrial">Ingeniería Industrial</option>
                        <option value="Administracion">Administración</option>
                        <option value="Arquitectura">Arquitectura</option>
                        <option value="Ingenieria Quimica">Ingeniería Química</option>
                        <option value="Ingenieria Electrica">Ingeniería Eléctrica</option>
                        <option value="Ingenieria Mecatronica">Ingeniería Mecatrónica</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="video-description">Descripción:</label>
                    <textarea id="video-description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="video-link">Link del Video (URL):</label>
                    <input type="text" id="video-link" name="link" required>
                </div>
                <div class="form-actions">
                    <button type="button" onclick="uploadVideo()" class="submit-btn">Subir Video</button>
                </div>
            </form>
        </div>

        <div class="videos-recomendados">
            <h2>Galería de Videos</h2>
            <div class="videos-container">
                <?php include('php/display_videos.php'); ?>
            </div>
        </div>
    </main>

    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>

    <script>
    function uploadVideo() {
        var formData = new FormData(document.getElementById('video-upload-form'));
        $.ajax({
            url: 'php/upload_video.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response); // Muestra una ventana emergente con la respuesta del servidor
                location.reload(); // Opcional: recargar la página para mostrar los nuevos datos
            },
            error: function() {
                alert('Error al subir el video.');
            }
        });
    }
    </script>
</body>
</html>
