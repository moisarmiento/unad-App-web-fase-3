<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unad_app_web_fase3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Conexión fallida: " . $conn->connect_error]));
}

$sql = "SELECT Codigo, Nombre, Descripción, Categoria, Disponibilidad, Precio, Imagen FROM productos ORDER BY Id_Producto DESC";
$result = $conn->query($sql);

$productos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

$conn->close();

echo json_encode($productos);
?>

