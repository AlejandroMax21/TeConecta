<?php
session_abort();
session_start();
if (empty($_SESSION["id"])) {
    header("location: login2.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos en TeConecta</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<?php include('header.php')?>

    <main class="main">
        <div class="documents-container">
            <h2>Documentos Disponibles</h2>
            <!-- Código PHP aquí para generar la lista de documentos -->
            <ul class="document-list">
                <!-- Ejemplo de cómo se mostrarían los documentos -->
                <li>
                    <h3>Titulo del Documento</h3>
                    <p>Subido por: Autor del Documento</p>
                    <a href="path/al/documento.pdf" download>Descargar</a>
                </li>
                <!-- Repetir bloques <li> para cada documento obtenido de la BD -->
            </ul>
        </div>
    </main>

    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>
</body>
</html>
