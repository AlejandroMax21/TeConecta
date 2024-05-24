<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "teconecta";

$conexion = mysqli_connect($host, $user, $password, $database);
if (!$conexion) {
    echo "No se realizó la conexión a la base de datos, el error fue: " . mysqli_connect_error();
}

// Verifica si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoge los datos del formulario
    $userName = $_POST['userName'];
    $userLastName1 = $_POST['userLastName1'];
    $userLastName2 = $_POST['userLastName2'];
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword']; // Considera hashear esta contraseña.
    $userRole = $_POST['userRole'];

    // Preparar la sentencia SQL para insertar los datos
    $query = "INSERT INTO usuario (Nom_User, ApellPat_User, ApellMat_User, Correo_User, Contra_User, Perfil_User) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conexion->error);
    }

    // Hashear la contraseña antes de guardarla
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    // Vincular parámetros
    $stmt->bind_param('ssssss', $userName, $userLastName1, $userLastName2, $userEmail, $hashedPassword, $userRole);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $stmt->close();
        $conexion->close();
        // Redirigir al usuario a la página de gestión de usuarios después de agregar al usuario
        header('Location: ../gestion_usuarios.php');
        exit;
    } else {
        echo "Error al agregar usuario: " . $stmt->error;
        $stmt->close();
        $conexion->close();
    }
} else {
    // No es una solicitud POST
    echo "Método no permitido.";
}
?>