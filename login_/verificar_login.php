<?php
session_start(); // Iniciar la sesión al principio del archivo

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unad_app_web_fase3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$contraseña = $_POST['contraseña'];

// Consulta para obtener la contraseña y el número de compras
$sql = "SELECT Contraseña, Num_compras FROM usuarios WHERE Nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Usuario no encontrado.");
}

$row = $result->fetch_assoc();
$contraseña_db = $row['Contraseña'];
$num_compras = $row['Num_compras'];

if ($contraseña === $contraseña_db) {
    // Guardar el nombre de usuario y el número de compras en la sesión
    $_SESSION['usuario'] = $nombre;
    $_SESSION['num_compras'] = $num_compras;
    
    // Redirigir a diferentes páginas según el usuario
    if ($nombre === "control_maestro" && $contraseña === "987654321") {
        header("Location: ../sub_pag_actualizar/sub_pagina_Actualizar.html");
        exit();
    }

    header("Location: ../catalogo/catalogo.php"); 
    exit();
} else {
    die("Contraseña incorrecta.");
}

$stmt->close();
$conn->close();
?>
