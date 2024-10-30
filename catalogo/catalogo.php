<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unad_app_web_fase3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$categorias = [
    'ornamentación' => [],
    'construcción' => [],
    'pintura' => []
];

$sql = "SELECT Id_Producto, Nombre, Precio, Imagen, Descripción, Categoria FROM productos WHERE Categoria IN ('ornamentación', 'construcción', 'pintura') ORDER BY Id_Producto DESC LIMIT 15";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categorias[$row['Categoria']][] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="catalogo.css">
    <style>
        /* Ocultar el modal inicialmente */
        #modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }
    </style>
</head>
<body>

<div class="header">
    <button class="button" onclick="cargar_principal()">salir</button>
    <h1>Productos</h1>
    <button class="button" onclick="cargar_cotizar()">Cotizar</button>
</div>

<!-- Modal -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modal-title"></h2>
        <img id="modal-image" src="" alt="Imagen del producto" style="width: 150px; height: 150px; object-fit: cover;">
        <p id="modal-description"></p>
        <p>Precio total: $<span id="modal-price"></span></p>
        <label for="quantity">Cantidad:</label>
        <input type="number" id="quantity" name="quantity" min="1" value="1" oninput="updatePrice()">
        <button onclick="comprarProducto()">Confirmar Compra</button>
    </div>
</div>

<div id="compra-info" class="compra-info" style="display: none;">
    <p id="compra-mensaje"></p>
</div>

<div class="products-container">
    <?php
    foreach ($categorias as $categoria => $productos) {
        if (count($productos) > 0) {
            echo '<h3>' . ucfirst($categoria) . '</h3>';
            echo '<div class="categoria-container">';

            foreach (array_slice($productos, 0, 5) as $producto) {
                echo '<div class="product">';
                echo '<img src="' . htmlspecialchars($producto['Imagen']) . '" alt="' . htmlspecialchars($producto['Nombre']) . '">';
                echo '<h3>' . htmlspecialchars($producto['Nombre']) . '</h3>';
                echo '<p>Precio: $<span class="precio-unitario">' . htmlspecialchars($producto['Precio']) . '</span></p>';
                echo '<button onclick="openModal(\'' . htmlspecialchars(json_encode($producto)) . '\')">Comprar</button>';
                echo '</div>';
            }

            echo '</div>';
        }
    }
    ?>
</div>

<script>
let currentProductPrice = 0;

function openModal(productData) {
    const product = JSON.parse(productData);
    currentProductPrice = parseFloat(product.Precio);

    document.getElementById("modal-title").textContent = product.Nombre;
    document.getElementById("modal-image").src = product.Imagen;
    document.getElementById("modal-price").textContent = currentProductPrice.toFixed(2);
    document.getElementById("modal-description").textContent = "Descripción del producto: " + product.Descripción;
    document.getElementById("quantity").value = 1; // Reset quantity
    document.getElementById("modal").style.display = "block";
}

function updatePrice() {
    const quantity = parseInt(document.getElementById("quantity").value);
    const totalPrice = (currentProductPrice * quantity).toFixed(2);
    document.getElementById("modal-price").textContent = totalPrice;
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}

function comprarProducto() {
    const quantity = document.getElementById("quantity").value;
    const message = "Has comprado " + quantity + " unidades del producto por un total de $" + (currentProductPrice * quantity).toFixed(2);

    document.getElementById("compra-mensaje").textContent = message;
    document.getElementById("compra-info").style.display = "block";

    closeModal();
}
function cargar_principal() {
    window.location.href = '../Principal/Principal.html';
}
function cargar_cotizar() {
    window.location.href = '../cotizacion/cotizacion.php';
}

</script>

</body>
</html>
