<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unad_app_web_fase3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Conexión fallida: " . $conn->connect_error]));
}

if (isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];

    $sql = "DELETE FROM productos WHERE Codigo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Producto eliminado exitosamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al eliminar el producto."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Código de producto no proporcionado."]);
}

$conn->close();
?>
