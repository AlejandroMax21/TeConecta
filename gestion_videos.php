<?php
include("admin/bd.php");

if (!$conexion) {
    echo "No se realizó la conexión a la base de datos, el error fue: " . mysqli_connect_error();
    exit;
}

// Procesar la adición de un nuevo video
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre_video'])) {
    $nombre_video = $_POST['nombre_video'];
    $carrera = $_POST['carrera'];
    $descripcion = $_POST['descripcion'];
    $link = $_POST['link'];

    $query = "INSERT INTO videos (Nombre_Video, Carrera, Descripcion, Link) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, 'ssss', $nombre_video, $carrera, $descripcion, $link);

    if (mysqli_stmt_execute($stmt)) {
        echo "Video agregado exitosamente.";
    } else {
        echo "Error al agregar el video: " . mysqli_error($conexion);
    }
}

// Procesar la eliminación de un video
if (isset($_POST['eliminar'])) {
    $idVideo = $_POST['id_Video'];
    $queryDelete = "DELETE FROM videos WHERE id_Video = ?";
    $stmt = mysqli_prepare($conexion, $queryDelete);
    mysqli_stmt_bind_param($stmt, 'i', $idVideo);
    if (mysqli_stmt_execute($stmt)) {
        echo "El video ha sido eliminado.";
    } else {
        echo "Error al eliminar el video: " . mysqli_error($conexion);
    }
}

// Consultar los videos existentes
$query = "SELECT id_Video, Nombre_Video, Carrera, Descripcion, Link FROM videos";
$result = mysqli_query($conexion, $query);
if (!$result) {
    echo "Error al realizar la consulta: " . mysqli_error($conexion);
    exit;
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Videos</title>
    <link rel="stylesheet" href="css/gestion_videos.css">
    <style>
        .modal {
            display: none; /* Inicialmente oculto */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }
    </style>
    <script>
        function openAddVideoModal() {
            document.getElementById('addVideoModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Optional: Close Modal on clicking outside of the modal content
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="admin.php" id="navbar__logo"><img src="img/logo_tec.png" alt="Logo Tec Tepic">TeConecta Admin</a>
        </div>
    </nav>

    <main class="main">
        <div class="admin-container">
            <h1>Gestión de Videos</h1>
            <button onclick="openAddVideoModal()" class="btn">Agregar Video</button>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Video</th>
                        <th>Carrera</th>
                        <th>Descripción</th>
                        <th>Link</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['id_Video']; ?></td>
                            <td><?php echo $row['Nombre_Video']; ?></td>
                            <td><?php echo $row['Carrera']; ?></td>
                            <td><?php echo $row['Descripcion']; ?></td>
                            <td><a href="<?php echo $row['Link']; ?>" target="_blank">Ver Video</a></td>
                            <td>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="id_Video" value="<?php echo $row['id_Video']; ?>">
                                    <button type="submit" name="eliminar">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal para agregar un nuevo video -->
    <div id="addVideoModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addVideoModal')">&times;</span>
            <h2>Agregar Nuevo Video</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                Nombre del Video: <input type="text" name="nombre_video" required><br>
                Carrera: <input type="text" name="carrera" required><br>
                Descripción: <input type="text" name="descripcion" required><br>
                Link: <input type="url" name="link" required><br>
                <button type="submit">Agregar Video</button>
            </form>
        </div>
    </div>

    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>
</body>
</html>
