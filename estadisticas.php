<?php
include("admin/bd.php");

if (!$conexion) {
    die("No se realizó la conexión a la base de datos: " . mysqli_connect_error());
}

// Consultar el número de usuarios por carrera
$queryCarreras = "SELECT Carre_User, COUNT(*) as num_users FROM usuario GROUP BY Carre_User";
$resultCarreras = mysqli_query($conexion, $queryCarreras);
if (!$resultCarreras) {
    die("Error al realizar la consulta: " . mysqli_error($conexion));
}

$carreras = [];
$numUsuariosCarreras = [];

while ($row = mysqli_fetch_assoc($resultCarreras)) {
    $carreras[] = $row['Carre_User'];
    $numUsuariosCarreras[] = $row['num_users'];
}

// Consultar el número de usuarios por perfil
$queryPerfiles = "SELECT Perfil_User, COUNT(*) as num_users FROM usuario GROUP BY Perfil_User";
$resultPerfiles = mysqli_query($conexion, $queryPerfiles);
if (!$resultPerfiles) {
    die("Error al realizar la consulta: " . mysqli_error($conexion));
}

$perfiles = [];
$numUsuariosPerfiles = [];

while ($row = mysqli_fetch_assoc($resultPerfiles)) {
    $perfiles[] = $row['Perfil_User'];
    $numUsuariosPerfiles[] = $row['num_users'];
}

// Consultar estadísticas de archivos
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

$queryArchivos = "
    SELECT 
        SUM(CASE WHEN Tipo = 'subido' THEN 1 ELSE 0 END) as subidos,
        SUM(CASE WHEN Tipo = 'visto' THEN 1 ELSE 0 END) as vistos,
        SUM(CASE WHEN Tipo = 'descargado' THEN 1 ELSE 0 END) as descargados
    FROM archivos
    WHERE YEAR(Fecha) = $year
";
$resultArchivos = mysqli_query($conexion, $queryArchivos);
$archivosStats = mysqli_fetch_assoc($resultArchivos);

// Consultar el número de inicios de sesión por periodos de 6 meses
$queryIniciosSesion = "
    SELECT 
        CONCAT(YEAR(Fecha), '-', LPAD(CEIL(MONTH(Fecha)/6), 2, '0')) as periodo, 
        COUNT(*) as num_logins 
    FROM logins 
    GROUP BY YEAR(Fecha), CEIL(MONTH(Fecha)/6)
";
$resultIniciosSesion = mysqli_query($conexion, $queryIniciosSesion);
$periodos = [];
$numLogins = [];

while ($row = mysqli_fetch_assoc($resultIniciosSesion)) {
    $periodos[] = $row['periodo'];
    $numLogins[] = $row['num_logins'];
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Usuarios</title>
    <link rel="stylesheet" href="css/admin_estadisticas.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="admin.php" id="navbar__logo"><img src="img/logo_tec.png" alt="Logo Tec Tepic">TeConecta Admin</a>
        </div>
    </nav>

    <main class="main">
        <div class="admin-container">
            <h1>Estadísticas de Usuarios</h1>
            <div class="charts-container">
                <div class="chart-item">
                    <h2>Usuarios por Carrera</h2>
                    <canvas id="carrerasChart"></canvas>
                    <button onclick="downloadChart('carrerasChart', 'Usuarios_por_Carrera.png')">Descargar Gráfica</button>
                </div>
                <div class="chart-item">
                    <h2>Usuarios por Perfil</h2>
                    <canvas id="perfilesChart"></canvas>
                    <button onclick="downloadChart('perfilesChart', 'Usuarios_por_Perfil.png')">Descargar Gráfica</button>
                </div>
                <div class="chart-item">
                    <h2>Archivos por Año</h2>
                    <form method="GET" action="">
                        <label for="year">Seleccionar Año:</label>
                        <select name="year" id="year" onchange="this.form.submit()">
                            <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                                <option value="<?php echo $i; ?>" <?php if ($i == $year) echo 'selected'; ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </form>
                    <canvas id="archivosChart"></canvas>
                    <button onclick="downloadChart('archivosChart', 'Archivos_por_Año.png')">Descargar Gráfica</button>
                </div>
                <div class="chart-item">
                    <h2>Inicios de Sesión por Periodos de 6 Meses</h2>
                    <canvas id="loginsChart"></canvas>
                    <button onclick="downloadChart('loginsChart', 'Inicios_de_Sesion.png')">Descargar Gráfica</button>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>

    <script>
        const carrerasCtx = document.getElementById('carrerasChart').getContext('2d');
        const carrerasChart = new Chart(carrerasCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($carreras); ?>,
                datasets: [{
                    data: <?php echo json_encode($numUsuariosCarreras); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });

        const perfilesCtx = document.getElementById('perfilesChart').getContext('2d');
        const perfilesChart = new Chart(perfilesCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($perfiles); ?>,
                datasets: [{
                    label: '# de Usuarios',
                    data: <?php echo json_encode($numUsuariosPerfiles); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const archivosCtx = document.getElementById('archivosChart').getContext('2d');
        const archivosChart = new Chart(archivosCtx, {
            type: 'bar',
            data: {
                labels: ['Subidos', 'Vistos', 'Descargados'],
                datasets: [{
                    label: '# de Archivos',
                    data: [<?php echo $archivosStats['subidos']; ?>, <?php echo $archivosStats['vistos']; ?>, <?php echo $archivosStats['descargados']; ?>],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const loginsCtx = document.getElementById('loginsChart').getContext('2d');
        const loginsChart = new Chart(loginsCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($periodos); ?>,
                datasets: [{
                    label: '# de Inicios de Sesión',
                    data: <?php echo json_encode($numLogins); ?>,
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function downloadChart(chartId, filename) {
            const chart = document.getElementById(chartId);
            const url_base64 = chart.toDataURL('image/png');
            const a = document.createElement('a');
            a.href = url_base64;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    </script>
</body>
</html>
