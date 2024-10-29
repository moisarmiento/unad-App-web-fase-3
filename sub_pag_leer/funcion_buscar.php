<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unad_app_web_fase3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Conexión fallida: " . $conn->connect_error]));
}

$id = $_GET['id'];
$sql = "SELECT * FROM productos WHERE Id_Producto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $producto = $result->fetch_assoc();
    echo json_encode(["status" => "success", "producto" => $producto]);
} else {
    echo json_encode(["status" => "error", "message" => "Producto no encontrado."]);
}

$stmt->close();
$conn->close();
?>
