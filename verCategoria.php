<?php
include("header.php");
$cat=$_GET["cat"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style></style>
    <link rel="stylesheet" href="css/verCategoria.css">
</head>
<body>
    <main class="main">
        
        <?php echo"<h2><strong>$cat</strong></h2>";?>

        <div class="documents">
            <?php include "admin/mostrarCategoria.php"?>
        </div>

    </main>
</body>
</html>