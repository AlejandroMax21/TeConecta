<?php
session_abort();
session_start();    
if (empty($_SESSION["id"])) {
    header("location: login2.php");
}

include("admin/bd.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = $_GET['id'];

    $query = "DELETE FROM usuario WHERE id_User = ?";
    $stmt = $conexion->prepare($query);
    if ($stmt) {
        $stmt->bind_param('i', $userId);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "El usuario ha sido eliminado exitosamente.";
            } else {
                echo "No se encontró el usuario o no se pudo eliminar.";
            }
        } else {
            echo "Error al ejecutar la eliminación: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
    $conexion->close();
} else {
    echo "Solicitud inválida.";
}
?>