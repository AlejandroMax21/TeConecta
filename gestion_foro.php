<?php
include("admin/bd.php");

if (!$conexion) {
    echo "No se realizó la conexión a la base de datos, el error fue: " . mysqli_connect_error();
    exit;
}

// Eliminar discusión del foro y sus comentarios
if (isset($_POST['eliminar_discusion'])) {
    $idForo = $_POST['id_Foro'];

    // Eliminar registros en favoritos_discusion
    $queryDeleteFavoritos = "DELETE FROM favoritos_discusion WHERE Foro_id_Foro = ?";
    $stmtFavoritos = mysqli_prepare($conexion, $queryDeleteFavoritos);
    mysqli_stmt_bind_param($stmtFavoritos, 'i', $idForo);
    mysqli_stmt_execute($stmtFavoritos);

    // Eliminar comentarios relacionados
    $queryDeleteComentarios = "DELETE FROM contenido_foro WHERE Foro_id_Foro = ?";
    $stmtComentarios = mysqli_prepare($conexion, $queryDeleteComentarios);
    mysqli_stmt_bind_param($stmtComentarios, 'i', $idForo);
    mysqli_stmt_execute($stmtComentarios);

    // Eliminar la discusión
    $queryDeleteForo = "DELETE FROM foro WHERE id_Foro = ?";
    $stmtForo = mysqli_prepare($conexion, $queryDeleteForo);
    mysqli_stmt_bind_param($stmtForo, 'i', $idForo);
    if (mysqli_stmt_execute($stmtForo)) {
        echo "La discusión y sus comentarios han sido eliminados.";
    } else {
        echo "Error al eliminar la discusión: " . mysqli_error($conexion);
    }
}

// Consultar las discusiones del foro existentes
$queryDiscusiones = "SELECT * FROM foro";
$resultDiscusiones = mysqli_query($conexion, $queryDiscusiones);
if (!$resultDiscusiones) {
    echo "Error al realizar la consulta de discusiones del foro: " . mysqli_error($conexion);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Contenido del Foro</title>
    <link rel="stylesheet" href="css/gestion_foro.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="admin.php" id="navbar__logo"><img src="img/logo_tec.png" alt="Logo Tec Tepic">TeConecta Admin</a>
        </div>
    </nav>

    <main class="main" style="padding: 20px;">
        <h1>Foro de Discusión</h1>
        <div class="forum-container">
            <section class="forum-threads">
                <h2>Discusiones Recientes</h2>
                <?php
                while ($row = mysqli_fetch_assoc($resultDiscusiones)) {
                    $id_Foro = $row["id_Foro"];
                    $fecha = $row["UltimaAct_Foro"];
                    echo "<div class='thread'>";
                    echo "<h3>" . $row["Titulo_Foro"] . "</h3>";
                    echo "<p>" . $row["Desc_Foro"] . "</p>";
                    echo "<a href='verComentariosAdmin.php?id=$id_Foro'>Ver</a>";
                    echo "<form method='POST' action='' style='display:inline;'>";
                    echo "<input type='hidden' name='id_Foro' value='$id_Foro'>";
                    echo "<button type='submit' name='eliminar_discusion'>Eliminar</button>";
                    echo "</form>";
                    echo "</div>";
                }
                ?>
            </section>
        </div>
    </main>

    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>
</body>
</html>
