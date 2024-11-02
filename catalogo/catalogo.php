<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php"); // Redirigir al inicio de sesión si no está autenticado
    exit();
}

$usuario = $_SESSION['usuario'];
$num_compras = $_SESSION['num_compras'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unad_app_web_fase3";

// Establecer conexión con la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Definir categorías y preparar para almacenar productos por categoría
$categorias = [
    'ornamentación' => [],
    'construcción' => [],
    'pintura' => []
];

// Consulta para obtener productos por categorías específicas
$sql = "SELECT Id_Producto, Nombre, Precio, Imagen, Descripción, Categoria FROM productos WHERE Categoria IN ('ornamentación', 'construcción', 'pintura') ORDER BY Id_Producto DESC LIMIT 15";
$result = $conn->query($sql);

// Organizar productos en el arreglo de categorías
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
    <link rel="stylesheet" href="catalogo.css">
    <style>
        /* Estilo para ocultar el modal inicialmente */
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

        /* Estilo para el descuento en rojo */
        .discount {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Encabezado con botones de navegación -->
<div class="header">
    <button class="button" onclick="cargar_principal()">Salir</button>
    <h1>Productos</h1>
    <button class="button" onclick="cargar_cotizar()">Cotizar</button>
</div>

<!-- ventana emergente para detalles de producto -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modal-title"></h2>
        <img id="modal-image" src="" alt="Imagen del producto" style="width: 150px; height: 150px; object-fit: cover;">
        <p id="modal-description"></p>
        <p>Precio total: $<span id="modal-price"></span></p>
        
        <!-- Campo de entrada para cantidad y descuento -->
        <label for="quantity">Cantidad:</label>
        <input type="number" id="quantity" name="quantity" min="1" value="1" oninput="updatePrice()">
        
        <!-- Mostrar usuario y número de compras -->
        <!--<p><strong>Usuario:</strong> <?php  //echo htmlspecialchars($usuario); ?></p> -->
       <!-- <p><strong>Número de compras:</strong> <?php  //echo htmlspecialchars($num_compras); ?></p> -->


        <!-- Texto para mostrar el descuento -->
        <p>Descuento: <span id="discount" class="discount"></span></p>
        <button onclick="comprarProducto()">Confirmar Compra</button>
    </div>
</div>

<!-- Información de compra -->
<div id="compra-info" class="compra-info" style="display: none;">
    <p id="compra-mensaje"></p>
</div>

<!-- Contenedor de productos -->
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
    // Obtener el número de compras de la sesión PHP y pasarlo a JavaScript
    const numCompras = <?php echo json_encode($num_compras); ?>; // Esto asegurará que el valor se maneje correctamente en JavaScript
   // console.log("Número de compras:", numCompras); // Verificar 

// Variable para almacenar el precio actual del producto
let currentProductPrice = 0;

// Función para abrir el modal con los datos del producto
function openModal(productData) {
    const product = JSON.parse(productData); // Analizar los datos del producto desde JSON
    currentProductPrice = parseFloat(product.Precio); // Obtener el precio del producto

    // Configurar el contenido del modal
    document.getElementById("modal-title").textContent = product.Nombre; // Título
    document.getElementById("modal-image").src = product.Imagen; // Imagen del producto
    document.getElementById("modal-description").textContent = "Descripción del producto: " + product.Descripción; // Descripción
    document.getElementById("modal-price").textContent = currentProductPrice.toFixed(2); // Precio inicial
    document.getElementById("quantity").value = 1; // Restablecer cantidad a 1
    document.getElementById("discount").textContent = "$0"; // Restablecer descuento a $0

    // Calcular y mostrar el descuento inicial
    updatePrice(); // Llamar a la función para calcular el precio y el descuento inicial

    // Mostrar el modal
    document.getElementById("modal").style.display = "block";
}


// Función para actualizar el precio total y mostrar el descuento
function updatePrice() {
    const quantity = parseInt(document.getElementById("quantity").value);
    let totalPrice = currentProductPrice * quantity;
    
    // Calcular el descuento basado en la cantidad y el número de compras del usuario
    let discount = 0;
   // console.log("quantity:", quantity); // Verificar en la consola
    
    if (numCompras >= 10) {
        // Descuento base del 10% por comprar 10 o más productos
        discount = totalPrice * 0.10;
        totalPrice -= discount; // Precio después del descuento
    }// Aplicar un 5% adicional si el usuario ha hecho más de 5 compras
    else if(numCompras >= 5) {
            discount += totalPrice * 0.05; // 5% adicional
            totalPrice -= discount;
        }
    else if(numCompras >= 2) {
            discount += totalPrice * 0.02; // 5% adicional
            totalPrice -= discount;
        }

    // Actualizar el precio y el descuento en el modal
    document.getElementById("modal-price").textContent = totalPrice.toFixed(2);
    document.getElementById("discount").textContent = discount > 0 ? "$" + discount.toFixed(2) : "$0";
}

// Función para cerrar el modal
function closeModal() {
    document.getElementById("modal").style.display = "none";
}

// Función para confirmar la compra y mostrar mensaje
function comprarProducto() {
    const quantity = document.getElementById("quantity").value;
    const message = "Has comprado " + quantity + " unidades del producto por un total de $" + (currentProductPrice * quantity).toFixed(2);

    document.getElementById("compra-mensaje").textContent = message;
    document.getElementById("compra-info").style.display = "block";

    closeModal();
}

// Funciónes para cargar las páginas y destruir la sesión
function cargar_principal() {
    DESTRUYE();
    window.location.href = '../Principal/Principal.html';
}
function cargar_cotizar(){
    DESTRUYE();
      window.location.href = '../cotizacion/cotizacion.php';
}
function DESTRUYE(){
    <?php session_destroy(); ?>
}

</script>
</body>
</html>
