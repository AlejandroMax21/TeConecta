<?php include ('header.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/principal.css">
    <title>Document</title>
</head>
<body>
<div class="main" id="inicio">
        <center> <h2>Bienvenido a TeConecta</h2></center>
        <center><p>Explora, aprende y conecta con tu comunidad académica.</p></center>
        <?php include ('admin/novedades.php') ?>
    <div class="quick-access">
        <h3>Acceso Rápido</h3>
        <ul class="quick-access-list">
            <li><a href="https://www.tecnm.mx/pdf/Calendario_Academico_TecNM_2023_2024.pdf?a=2" class="quick-link">Calendario académico</a></li>
            <li><a href="https://eve.tepic.tecnm.mx/" class="quick-link">Recursos educativos (EVE)</a></li>
            <li><a href="contacto.html" class="quick-link">Contacto y soporte</a></li>
            <li><a href="preguntasFrecuentes.php" class="quick-link">Preguntas Frecuentes</a></li>
        </ul>
    </div>
<center><p>Contacto: info@teconecta.com</p></center>
</body>
</html>
    
<?php include ('footer.php') ?>