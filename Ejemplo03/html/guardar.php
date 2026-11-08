<?php
$host = 'db';
$user = 'usuario_app';
$pass = 'password_app';
$db   = 'mi_base_datos';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $apellido);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: index.php");
exit();
?>