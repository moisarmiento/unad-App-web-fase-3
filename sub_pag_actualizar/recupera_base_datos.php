<?php
// recupera_base_datos.php
$servername = "localhost"; // Cambia esto si tu servidor es diferente
$username = "root"; // Cambia esto si tu usuario es diferente
$password = ""; // Cambia esto si tu contraseña es diferente
$dbname = "productos_phase2"; // nombre de la base de datos 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Conexión fallida: " . $conn->connect_error]));
}

// Consultar los productos
$sql = "SELECT Codigo, Nombre, Descripción, Categoria, Disponibilidad, Precio, Imagen 
        FROM productos
        ORDER BY Id_Producto DESC 
        LIMIT 5";
$result = $conn->query($sql);

// Inicializar el array de productos
$productos = [];

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row; // Guardar los datos en el array
    }
}

// Cerrar la conexión
$conn->close();

// Devolver los productos en formato JSON
echo json_encode($productos);
?>
