<?php
include("header.php");
$idUser=$_SESSION["id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Archivos</title>
    <link rel="stylesheet" href="css/verCategoria.css">
</head>
<body>
    <main class="main">
        <?php include("admin/mostrarTodo.php");?>
    </main>
</body>
</html>