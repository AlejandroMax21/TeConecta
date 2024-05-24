<?php
include("admin/bd.php");

if (!$conexion) {
    die("No se realizó la conexión a la base de datos: " . mysqli_connect_error());
}

$idPubli = $_GET['id'];
$idUsuario = $_SESSION['id']; // Asumiendo que el ID del usuario está almacenado en la sesión

// Obtener el nombre del archivo
$query = "SELECT Archivo_Publi FROM contenido WHERE id_Publi = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, 'i', $idPubli);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $archivo = $row['Archivo_Publi'];
    $rutaArchivo = "admin/files/" . $archivo;

    // Registrar la visualización del archivo
    $fecha = date('Y-m-d H:i:s');
    $queryInsert = "INSERT INTO archivos (Tipo, Fecha, Usuario_id_User) VALUES ('visto', ?, ?)";
    $stmtInsert = mysqli_prepare($conexion, $queryInsert);
    mysqli_stmt_bind_param($stmtInsert, 'si', $fecha, $idUsuario);
    mysqli_stmt_execute($stmtInsert);
} else {
    die("No se encontró el archivo.");
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Archivo</title>
    <link rel="stylesheet" href="css/ver_documento.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="admin.php" id="navbar__logo"><img src="img/logo_tec.png" alt="Logo Tec Tepic">TeConecta Admin</a>
        </div>
    </nav>

    <main class="main">
        <div class="document-container">
            <h1>Visualización del Archivo</h1>
            <iframe src="<?php echo $rutaArchivo; ?>" width="100%" height="600px"></iframe>
        </div>
    </main>

    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>
</body>
</html>
