<?php
// Conexión a la base de datos
$servername = "localhost"; // Cambia esto si tu servidor es diferente
$username = "root"; // Cambia esto si tu usuario es diferente
$password = ""; // Cambia esto si tu contraseña es diferente
$dbname = "unad_app_web_fase3"; // la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $disponibilidad = $_POST['disponible'] ; 
    $precio = $_POST['precio'];

    // Guardar imagen
    $imagen = $_FILES['imagen']['name'];
    $imagen_temp = $_FILES['imagen']['tmp_name'];
    $imagen_path = "../IMAGENES/" . $imagen; 
    move_uploaded_file($imagen_temp, $imagen_path);

    // Insertar los datos en la tabla de productos
    $sql = "INSERT INTO productos (Codigo, Nombre, Descripción, Categoria, Disponibilidad, Precio, Imagen) 
            VALUES ('$codigo', '$nombre', '$descripcion', '$categoria', '$disponibilidad', '$precio', '$imagen_path')";

    if ($conn->query($sql) === TRUE) {
        echo "Exito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
