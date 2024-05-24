<?php
include("admin/bd.php");

if (!$conexion) {
    echo "No se realizó la conexión a la base de datos, el error fue: " . mysqli_connect_error();
    exit;
}

// Eliminar contenido y enviar correo al usuario
if (isset($_POST['eliminar'])) {
    $idPubli = $_POST['id_Publi'];
    
    // Obtener la información del usuario
    $queryUser = "SELECT usuario.Correo_User FROM contenido JOIN usuario ON contenido.Usuario_id_User = usuario.id_User WHERE contenido.id_Publi = ?";
    $stmt = mysqli_prepare($conexion, $queryUser);
    mysqli_stmt_bind_param($stmt, 'i', $idPubli);
    mysqli_stmt_execute($stmt);
    $resultUser = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($resultUser);
    $correoUsuario = $user['Correo_User'];

    // Eliminar la publicación
    $queryDelete = "DELETE FROM contenido WHERE id_Publi = ?";
    $stmt = mysqli_prepare($conexion, $queryDelete);
    mysqli_stmt_bind_param($stmt, 'i', $idPubli);
    if (mysqli_stmt_execute($stmt)) {
        // Enviar correo electrónico
        $to = $correoUsuario;
        $subject = "Notificación de eliminación de contenido";
        $message = "Estimado usuario,\n\nSu contenido con ID $idPubli ha sido eliminado de nuestro sistema.\n\nSaludos,\nTeConecta";
        $headers = "From: no-reply@teconecta.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "El contenido ha sido eliminado y se ha notificado al usuario.";
        } else {
            echo "El contenido ha sido eliminado, pero no se pudo notificar al usuario.";
        }
    } else {
        echo "Error al eliminar el contenido: " . mysqli_error($conexion);
    }
}

// Consultar las publicaciones existentes
$query = "SELECT id_Publi, Titulo_Publi, Tema_Publi, Fecha_Publi, Archivo_Publi, ContenidoSensible_Publi, Status_publi, Usuario_id_User FROM contenido";
$result = mysqli_query($conexion, $query);
if (!$result) {
    echo "Error al realizar la consulta: " . mysqli_error($conexion);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Contenido</title>
    <link rel="stylesheet" href="css/gestion_contenido.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="admin.php" id="navbar__logo"><img src="img/logo_tec.png" alt="Logo Tec Tepic">TeConecta Admin</a>
        </div>
    </nav>

    <main class="main">
        <div class="admin-container">
            <h1>Gestión de Contenido</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Tema</th>
                        <th>Fecha</th>
                        <th>Archivo</th>
                        <th>Contenido Sensible</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['id_Publi']; ?></td>
                            <td><?php echo $row['Titulo_Publi']; ?></td>
                            <td><?php echo $row['Tema_Publi']; ?></td>
                            <td><?php echo $row['Fecha_Publi']; ?></td>
                            <td><?php echo $row['Archivo_Publi']; ?></td>
                            <td><?php echo $row['ContenidoSensible_Publi'] ? 'Sí' : 'No'; ?></td>
                            <td><?php echo $row['Status_publi']; ?></td>
                            <td>
                                <a href="admin/files/<?php echo $row['Archivo_Publi']; ?>" target="_blank">Ver</a>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="id_Publi" value="<?php echo $row['id_Publi']; ?>">
                                    <button type="submit" name="eliminar">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>
</body>
</html>
