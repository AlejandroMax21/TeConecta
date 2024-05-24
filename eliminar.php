<?php
include("admin/bd.php");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$id = $_GET['id'];

// Eliminar los registros en la tabla contenido que están asociados con el usuario
$query = "DELETE FROM contenido WHERE Usuario_id_User = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);

// Ahora eliminar el usuario
$query = "DELETE FROM usuario WHERE id_User = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);

mysqli_close($conexion);

header("Location: gestion_usuarios.php");
exit;
?>
