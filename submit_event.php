<?php
session_abort();
session_start();    
if (empty($_SESSION["id"])) {
    header("location: login2.php");
}

include("admin/bd.php");

$conexion = mysqli_connect($host, $user, $password, $database);
if (!$conexion) {
    die("No se realizó la conexión a la base de datos: " . mysqli_connect_error());
}

$title = $_POST['title'];
$date = $_POST['date'];
$time = $_POST['time'];
$location = $_POST['location'];
$url = $_POST['url'];
$description = $_POST['description'];

// Aquí deberías incluir lógica para determinar si es una inserción o actualización
// Por ejemplo, podrías verificar si se envía un 'event_id' como parte del formulario para decidir

$query = "INSERT INTO events (title, date, time, location, url, description) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($query);
if (!$stmt) {
    echo "Error al preparar la consulta: " . $conexion->error;
    exit;
}
$stmt->bind_param("ssssss", $title, $date, $time, $location, $url, $description);

if ($stmt->execute()) {
    // Cierre del statement y conexión antes de la redirección.
    $stmt->close();
    $conexion->close();
    // Redirección a la página de gestión de eventos después de un éxito.
    header('Location: ../gestion_eventos.php');
    exit;
} else {
    echo "Error al guardar el evento: " . $stmt->error;
    // Asegúrate de cerrar el statement y la conexión incluso si hay un error.
    $stmt->close();
    $conexion->close();
    exit;
}
?>
