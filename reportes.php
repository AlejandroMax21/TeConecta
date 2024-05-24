<?php
include("admin/bd.php");

if (!$conexion) {
    echo "No se realizó la conexión a la base de datos, el error fue: " . mysqli_connect_error();
    exit;
}

// Consultar reportes de contenido
$queryReporteContenido = "SELECT id_RC, id_contenido, razon_RD FROM reporte_contenido";
$resultReporteContenido = mysqli_query($conexion, $queryReporteContenido);
if (!$resultReporteContenido) {
    echo "Error al realizar la consulta de reportes de contenido: " . mysqli_error($conexion);
    exit;
}

// Consultar reportes de foro
$queryReporteForo = "SELECT id_RF, id_F, razon_RF FROM reporte_foro";
$resultReporteForo = mysqli_query($conexion, $queryReporteForo);
if (!$resultReporteForo) {
    echo "Error al realizar la consulta de reportes de foro: " . mysqli_error($conexion);
    exit;
}

// Consultar reportes de comentarios de contenido
$queryReporteComentariosContenido = "SELECT id_RCC, id_CC, razon_RCC FROM reporte_comc";
$resultReporteComentariosContenido = mysqli_query($conexion, $queryReporteComentariosContenido);
if (!$resultReporteComentariosContenido) {
    echo "Error al realizar la consulta de reportes de comentarios de contenido: " . mysqli_error($conexion);
    exit;
}

// Consultar reportes de comentarios de foro
$queryReporteComentariosForo = "SELECT id_RCF, id_CF, razon_RCF FROM reporte_comf";
$resultReporteComentariosForo = mysqli_query($conexion, $queryReporteComentariosForo);
if (!$resultReporteComentariosForo) {
    echo "Error al realizar la consulta de reportes de comentarios de foro: " . mysqli_error($conexion);
    exit;
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link rel="stylesheet" href="css/reportes.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="admin.php" id="navbar__logo"><img src="img/logo_tec.png" alt="Logo Tec Tepic">TeConecta Admin</a>
        </div>
    </nav>

    <main class="main">
        <div class="admin-container">
            <h1>Reportes</h1>

            <h2>Reportes de Contenido</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Contenido</th>
                        <th>Razón</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($resultReporteContenido)): ?>
                        <tr>
                            <td><?php echo $row['id_RC']; ?></td>
                            <td><?php echo $row['id_contenido']; ?></td>
                            <td><?php echo $row['razon_RD']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h2>Reportes de Foro</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Foro</th>
                        <th>Razón</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($resultReporteForo)): ?>
                        <tr>
                            <td><?php echo $row['id_RF']; ?></td>
                            <td><?php echo $row['id_F']; ?></td>
                            <td><?php echo $row['razon_RF']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h2>Reportes de Comentarios de Contenido</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Comentario Contenido</th>
                        <th>Razón</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($resultReporteComentariosContenido)): ?>
                        <tr>
                            <td><?php echo $row['id_RCC']; ?></td>
                            <td><?php echo $row['id_CC']; ?></td>
                            <td><?php echo $row['razon_RCC']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h2>Reportes de Comentarios de Foro</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Comentario Foro</th>
                        <th>Razón</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($resultReporteComentariosForo)): ?>
                        <tr>
                            <td><?php echo $row['id_RCF']; ?></td>
                            <td><?php echo $row['id_CF']; ?></td>
                            <td><?php echo $row['razon_RCF']; ?></td>
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
