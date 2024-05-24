<?php
include("admin/bd.php");

$idForo = $_GET["id"];

if (!$conexion) {
    echo "No se realizó la conexión a la base de datos, el error fue: " . mysqli_connect_error();
    exit;
}

// Eliminar comentario del foro
if (isset($_POST['eliminar_comentario'])) {
    $idContenidoF = $_POST['id_ContenidoF'];

    // Eliminar el comentario del foro
    $queryDelete = "DELETE FROM contenido_foro WHERE id_ContenidoF = ?";
    $stmt = mysqli_prepare($conexion, $queryDelete);
    mysqli_stmt_bind_param($stmt, 'i', $idContenidoF);
    if (mysqli_stmt_execute($stmt)) {
        echo "El comentario ha sido eliminado.";
    } else {
        echo "Error al eliminar el comentario: " . mysqli_error($conexion);
    }
}

// Eliminar discusión completa y sus comentarios
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
        header("Location: gestion_foro.php");
        exit;
    } else {
        echo "Error al eliminar la discusión: " . mysqli_error($conexion);
    }
}

// Obtener la discusión principal
$queryForo = "SELECT * FROM foro WHERE id_Foro = '$idForo'";
$resultForo = mysqli_query($conexion, $queryForo);

if (mysqli_num_rows($resultForo) > 0) {
    $row = mysqli_fetch_assoc($resultForo);
    $titulo = $row["Titulo_Foro"];
    $descripcion = $row["Desc_Foro"];
    $fecha = $row["UltimaAct_Foro"];
} else {
    echo "No se encontró la discusión.";
    exit;
}

// Consultar los comentarios del foro
$queryComentarios = "SELECT cf.id_ContenidoF, cf.Comentario_ContenidoF, cf.FechaCreacion_ContenidoF, u.Foto_User, u.id_User FROM contenido_foro cf LEFT JOIN usuario u ON cf.Usuario_id_User = u.id_User WHERE cf.Foro_id_Foro = '$idForo' ORDER BY cf.FechaCreacion_ContenidoF DESC";
$resultComentarios = mysqli_query($conexion, $queryComentarios);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios de la Discusión</title>
    <link rel="stylesheet" href="css/gestion_foro.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="gestion_foro.php" id="navbar__logo"><img src="img/logo_tec.png" alt="Logo Tec Tepic">TeConecta Admin</a>
        </div>
    </nav>

    <main class="main">
        <div class="forum-container">
            <div class="thread">
                <h3><?php echo $titulo; ?></h3>
                <p><?php echo $descripcion; ?></p>
                <p>Última Actualización: <?php echo $fecha; ?></p>
                <form method='POST' action='' style='display:inline;'>
                    <input type='hidden' name='id_Foro' value='<?php echo $idForo; ?>'>
                    <button type='submit' name='eliminar_discusion'>Eliminar Discusión Completa</button>
                </form>
            </div>
        </div>

        <div class="forum-container">
            <h2>Respuestas</h2>
        </div>
        
        <?php
        if (mysqli_num_rows($resultComentarios) > 0) {
            while ($fila = mysqli_fetch_assoc($resultComentarios)) {
                $comentario = $fila["Comentario_ContenidoF"];
                $ultimaFecha = $fila["FechaCreacion_ContenidoF"];
                $foto = $fila["Foto_User"];
                $id_usuario_comentario = $fila["id_User"];
                $id_contenidoF = $fila["id_ContenidoF"];
                
                echo "<div class='forum-container'>
                        <div class='thread'>";
                if (!empty($foto)) {
                    echo '<a href="perfilUsuario.php?id=' . $id_usuario_comentario . '" class="navbar__links"><img style="width: 50px; height: 50px;" src="data:image/jpeg;base64,' . base64_encode($foto) . '" alt="Usuario" class="rounded-logo"></a>';
                } else {
                    echo '<a href="perfilUsuario.php?id=' . $id_usuario_comentario . '" class="navbar__links"><img style="width: 50px; height: 50px;" src="img/profilephoto.png" alt="Usuario" class="rounded-logo"></a>';
                }
                echo "<p>$comentario</p><br/>
                      <p>Última Actualización: $ultimaFecha</p>
                      <form method='POST' action='' style='display:inline;'>
                          <input type='hidden' name='id_ContenidoF' value='$id_contenidoF'>
                          <button type='submit' name='eliminar_comentario'>Eliminar Comentario</button>
                      </form>
                      </div>
                      </div>";
            }
        } else {
            echo "No se encontraron respuestas.";
        }
        ?>
    </main>

    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>
</body>
</html>

