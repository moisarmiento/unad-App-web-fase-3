<?php
$servername = "localhost"; // Cambia esto si tu servidor es diferente
$username = "root"; // Cambia esto si tu usuario es diferente
$password = ""; // Cambia esto si tu contraseña es diferente
$dbname = "unad_app_web_fase3"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar un array para almacenar productos por categoría
$categorias = [
    'ornamentación' => [],
    'construcción' => [],
    'pintura' => []
];

// Consulta para obtener los cinco últimos productos por cada categoría
$sql = "SELECT Nombre, Precio, Imagen, Categoria FROM productos WHERE Categoria IN ('ornamentación', 'construcción', 'pintura') ORDER BY Id_Producto DESC LIMIT 15";
$result = $conn->query($sql);

// Organizar productos en categorías
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categorias[$row['Categoria']][] = $row;
    }
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="catalogo.css"> <!-- Vincular a la hoja de estilos -->
</head>
<body>

<div class="header">
    <button class="button">Botón 1</button>
    <h1>Productos</h1>
  <!--  <h2>Pintura Construcción Ornamentación</h2> -->
    <button class="button">Botón 2</button>
</div>

<div class="products-container">
    <?php
    // Mostrar productos por categoría
    foreach ($categorias as $categoria => $productos) {
        if (count($productos) > 0) {
            echo '<h3>' . ucfirst($categoria) . '</h3>'; // Título de la categoría
            echo '<div class="categoria-container">'; // Contenedor para la categoría

            foreach (array_slice($productos, 0, 5) as $producto) { // Solo los 5 últimos
                echo '<div class="product">';
                echo '<img src="' . htmlspecialchars($producto['Imagen']) . '" alt="' . htmlspecialchars($producto['Nombre']) . '">';
                echo '<h3>' . htmlspecialchars($producto['Nombre']) . '</h3>';
                echo '<p>Precio: $' . htmlspecialchars($producto['Precio']) . '</p>';
                echo '</div>';
            }

            echo '</div>'; // Cerrar contenedor de la categoría
        }
    }
    ?>
</div>

</body>
</html>
