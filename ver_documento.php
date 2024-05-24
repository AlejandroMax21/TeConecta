<?php
include("admin/bd.php");

session_start();
if (!isset($_SESSION['id'])) {
    echo "Error: Usuario no autenticado.";
    exit;
}

$idUsuario = $_SESSION['id'];
$idPubli = $_GET['id'];

if (!$conexion) {
    echo "No se realizó la conexión a la base de datos, el error fue: " . mysqli_connect_error();
    exit;
}

// Obtener el archivo a mostrar
$query = "SELECT Archivo_Publi FROM contenido WHERE id_Publi = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, 'i', $idPubli);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $archivo = $row['Archivo_Publi'];
    $rutaArchivo = "admin/files/" . $archivo;
} else {
    echo "No se encontró el archivo.";
    exit;
}

// Registrar el evento 'visto' en la tabla archivos
$queryInsert = "INSERT INTO archivos (Tipo, Fecha, Usuario_id_User) VALUES ('visto', NOW(), ?)";
$stmtInsert = mysqli_prepare($conexion, $queryInsert);
mysqli_stmt_bind_param($stmtInsert, 'i', $idUsuario);
if (!mysqli_stmt_execute($stmtInsert)) {
    echo "Error al registrar la visualización: " . mysqli_error($conexion);
    exit;
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Documento</title>
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
            <h1>Visualización del Documento</h1>
            <iframe src="<?php echo $rutaArchivo; ?>" width="100%" height="600px"></iframe>
        </div>
    </main>

    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>
</body>
</html>
