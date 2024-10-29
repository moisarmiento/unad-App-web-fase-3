<?php
$servername = "localhost"; // Cambia esto si tu servidor es diferente
$username = "root"; // Cambia esto si tu usuario es diferente
$password = ""; // Cambia esto si tu contraseña es diferente
$dbname = "unad_app_web_fase3"; // nombre de la base de datos 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recuperar datos del formulario
$nombre = $_POST['nombre'];
$contraseña = $_POST['contraseña'];

// Verificar si el nombre de usuario existe
$sql = "SELECT Contraseña FROM usuarios WHERE Nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Usuario no encontrado.");
}

// Recuperar la contraseña de la base de datos
$row = $result->fetch_assoc();
$contraseña_db = $row['Contraseña'];

// Verificar la contraseña
if ($contraseña === $contraseña_db) {
    // Si el usuario es "control_maestro" y la contraseña es "987654321"
    if ($nombre === "control_maestro" && $contraseña === "987654321") {
        echo "Bienvenido Control Maestro";
        // O redirigir a una página específica para el Control Maestro
        // header("Location: ../ControlMaestro/ControlMaestro.html");
        exit(); // Asegúrate de usar exit después de header
    }

    // Contraseña correcta para otros usuarios, redirigir a la página principal
    header("Location: ../Principal/Principal.html");
    exit(); // Asegúrate de usar exit después de header
} else {
    die("Contraseña incorrecta.");
}

// Cerrar sentencias y conexión
$stmt->close();
$conn->close();
?>

