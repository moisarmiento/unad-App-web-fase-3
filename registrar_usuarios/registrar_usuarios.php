<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unad_app_web_fase3";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recuperar datos del formulario
$nombre = $_POST['nombre'];
$contraseña = $_POST['contraseña'];
$confirmar_contraseña = $_POST['confirmar_contraseña'];

// Verificar que las contraseñas coincidan
if ($contraseña !== $confirmar_contraseña) {
    die("Las contraseñas no coinciden.");
}

// Verificar si el nombre de usuario ya existe
$sql = "SELECT * FROM usuarios WHERE Nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("El nombre de usuario ya está en uso.");
}


$contraseña_hash = $contraseña;

// Insertar nuevo usuario en la base de datos
$sql = "INSERT INTO usuarios (Nombre, Contraseña) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $nombre, $contraseña_hash);

if ($stmt->execute()) {
    echo "Registro exitoso.";
    header("Location: ../Principal/Principal.html");
} else {
    echo "Error al registrar: " . $stmt->error;
}

// Cerrar sentencias y conexión
$stmt->close();
$conn->close();
?>
