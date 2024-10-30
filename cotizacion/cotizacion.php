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

// Recuperar productos de la base de datos
$sql = "SELECT Id_Producto, Nombre, Precio FROM productos ORDER BY Id_Producto DESC LIMIT 15";
$result = $conn->query($sql);
$productos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
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
    <title>Cotización de Productos</title>
    <link rel="stylesheet" href="cotizacion.css"> <!-- Vincular a la hoja de estilos -->
</head>
<body>

<div class="header">
    <h1>Cotización de Productos</h1>
</div>

<form id="cotizacion-form">
    <div class="productos-container">
        <?php foreach ($productos as $producto): ?>
            <div class="producto">
                <label for="producto_<?php echo $producto['Id_Producto']; ?>">
                    <?php echo htmlspecialchars($producto['Nombre']); ?> - $<?php echo htmlspecialchars($producto['Precio']); ?>
                </label>
                <input type="number" id="producto_<?php echo $producto['Id_Producto']; ?>" name="cantidad[<?php echo $producto['Id_Producto']; ?>]" min="0" value="0" data-precio="<?php echo $producto['Precio']; ?>" class="cantidad">
            </div>
        <?php endforeach; ?>
    </div>

    <div class="total-container">
        <p>Total: $<span id="total">0</span></p>
        <button type="submit">limpiar Cotización</button>
    </div>
</form>

<script>
document.getElementById('cotizacion-form').addEventListener('input', function() {
    let total = 0;
    const cantidades = document.querySelectorAll('.cantidad');

    cantidades.forEach((input) => {
        const precio = parseFloat(input.getAttribute('data-precio'));
        const cantidad = parseInt(input.value) || 0;
        total += precio * cantidad;
    });

    document.getElementById('total').textContent = total.toFixed(2);
});
</script>

</body>
</html>
