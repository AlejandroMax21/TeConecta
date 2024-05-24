<?php include "header.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/guardados.css">
</head>
<body>
<main class ="main" style="display: flex; flex-direction: column; align-items: center;">
    <h2><strong>Favoritos</strong></h2>
    
    <h2>Documentos </h2>
    <div class="documents">
        <?php include "admin/verDocumentoGuardado.php"?>
    </div>
    
    <h2>Discusiones de Foro</h2>
    <div class="forum-discussions">
        <div class="forum-discussions">
            <?php include "admin/verDiscusionGuardada.php"?>
        </div>
    </div>
</main>
</body>
</html>

<?php include "footer.php" ?>