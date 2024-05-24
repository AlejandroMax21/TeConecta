<?php
include("admin/bd.php");

// Conexión a la base de datos
if (!$conexion) {
    echo "No se realizó la conexión a la base de datos, el error fue: " . mysqli_connect_error();
    exit;
}

// Procesar la adición de un nuevo usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $apellidoPaterno = $_POST['apellidoPaterno'];
    $apellidoMaterno = $_POST['apellidoMaterno'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $carrera = $_POST['carrera'];
    $perfil = $_POST['perfil'];
    $intereses = $_POST['intereses'];
    $habilidades = $_POST['habilidades'];
    $redesSociales = $_POST['redesSociales'];
    $contacto = $_POST['contacto'];

    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = file_get_contents($_FILES['foto']['tmp_name']);
    }

    $query = "INSERT INTO usuario (Nom_User, ApellPat_User, ApellMat_User, Correo_User, Contra_User, Carre_User, Perfil_User, Foto_User, Intereses_User, Habilidades_User, RedesSociales_User, Contacto_User)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, 'ssssssssssss', $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $contrasena, $carrera, $perfil, $foto, $intereses, $habilidades, $redesSociales, $contacto);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Usuario agregado exitosamente.";
    } else {
        echo "Error al agregar el usuario: " . mysqli_error($conexion);
    }
}

// Procesar la importación de archivo SQL
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['sqlFile'])) {
    $file = $_FILES['sqlFile']['tmp_name'];
    $sql = file_get_contents($file);
    if (mysqli_multi_query($conexion, $sql)) {
        echo "Archivo SQL importado exitosamente.";
    } else {
        echo "Error al importar el archivo SQL: " . mysqli_error($conexion);
    }
}

// Procesar la búsqueda de usuarios
$whereClauses = [];
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search = $_GET['search'];
    $whereClauses[] = "id_User LIKE '%$search%'";
    $whereClauses[] = "Nom_User LIKE '%$search%'";
    $whereClauses[] = "CONCAT(Nom_User, ' ', ApellPat_User, ' ', ApellMat_User) LIKE '%$search%'";
    $whereClauses[] = "Carre_User LIKE '%$search%'";
}

$whereSQL = '';
if (count($whereClauses) > 0) {
    $whereSQL = 'WHERE ' . implode(' OR ', $whereClauses);
}

// Consulta para obtener los datos de todos los usuarios
$query = "SELECT id_User, Nom_User, ApellPat_User, ApellMat_User, Correo_User, Carre_User, Perfil_User FROM usuario $whereSQL";
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
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="css/admin_usuarios.css">
    <style>
        .modal {
            display: none;
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

        .search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar {
            flex-grow: 1;
            margin-right: 1px;
        }

        .search-bar input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .btn-container {
            display: flex;
            gap: 1px;
        }

        .btn-container .btn {
            padding: 10px 20px;
            background-color: #005f73;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-container .btn:hover {
            background-color: #014f5a;
        }

        .btn-container form {
            display: inline;
        }
    </style>
    <script>
        function openAddUserModal() {
            document.getElementById('addUserModal').style.display = 'block';
        }

        function openImportSQLModal() {
            document.getElementById('importSQLModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

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
    <div class="container">
        <h1>Gestión de Usuarios</h1>
        <div class="search-container">
            <div class="search-bar">
                <form method="GET" action="">
                    <input type="text" name="search" placeholder="Buscar por ID, nombre, nombre completo o carrera" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    <button type="submit">Buscar</button>
                </form>
            </div>
            <div class="btn-container">
                <button onclick="openAddUserModal()" class="btn">Agregar Usuario</button>
                <button onclick="openImportSQLModal()" class="btn">Importar Usuarios</button>
            </div>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>Carrera</th>
                <th>Perfil</th>
                <th>Acciones</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id_User'] . "</td>";
                echo "<td>" . $row['Nom_User'] . "</td>";
                echo "<td>" . $row['ApellPat_User'] . "</td>";
                echo "<td>" . $row['ApellMat_User'] . "</td>";
                echo "<td>" . $row['Correo_User'] . "</td>";
                echo "<td>" . $row['Carre_User'] . "</td>";
                echo "<td>" . $row['Perfil_User'] . "</td>";
                echo "<td><a href='editar.php?id=" . $row['id_User'] . "'>Editar</a> | <a href='eliminar.php?id=" . $row['id_User'] . "'>Eliminar</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <!-- Modal para agregar un nuevo usuario -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addUserModal')">&times;</span>
            <h2>Agregar Nuevo Usuario</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                Nombre: <input type="text" name="nombre" required><br>
                Apellido Paterno: <input type="text" name="apellidoPaterno" required><br>
                Apellido Materno: <input type="text" name="apellidoMaterno" required><br>
                Correo: <input type="email" name="correo" required><br>
                Contraseña: <input type="password" name="contrasena" required><br>
                Carrera: <input type="text" name="carrera" required><br>
                Perfil: <select name="perfil" required>
                    <option value="Alumno">Alumno</option>
                    <option value="Maestro">Maestro</option>
                    <option value="Administrador">Administrador</option>
                </select><br>
                Foto: <input type="file" name="foto" accept="image/*"><br>
                Intereses: <textarea name="intereses"></textarea><br>
                Habilidades: <textarea name="habilidades"></textarea><br>
                Redes Sociales: <textarea name="redesSociales"></textarea><br>
                Contacto: <textarea name="contacto"></textarea><br>
                <button type="submit">Agregar Usuario</button>
            </form>
        </div>
    </div>

    <!-- Modal para importar archivo SQL -->
    <div id="importSQLModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('importSQLModal')">&times;</span>
            <h2>Importar archivo SQL</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="sqlFile" accept=".sql" required>
                <button type="submit">Importar</button>
            </form>
        </div>
    </div>
</body>
</html>
