function cargar_principal() {
    window.location.href = '../Principal/Principal.html';
}
function cargar_crear() {
    window.location.href = '../sub_pag_crear/sub_pagina_Crear.html';
}

function cargar_actualizar() {
    window.location.href = '../sub_pag_actualizar/sub_pagina_Actualizar.html';
}

function cargar_leer() {
    window.location.href = '../sub_pag_leer/leer.html';
}
// Cargar los productos desde la base de datos
document.addEventListener('DOMContentLoaded', function() {
    cargarProductos();
});

function cargarProductos() {
    fetch('funcion_cargar.php')
        .then(response => response.json())
        .then(productos => {
            const tablaProductos = document.getElementById('tabla-productos');
            tablaProductos.innerHTML = ''; // Limpiar la tabla antes de llenarla

            productos.forEach(producto => {
                // Convertir el valor booleano de producto.Descripción a texto "Sí" o "No" 
                const fila = document.createElement('tr');
               
                fila.innerHTML = `
                    <td>${producto.Codigo}</td>
                    <td>${producto.Nombre}</td>
                    <td>${producto.Descripción}</td> 
                    <td>${producto.Categoria}</td>
                    <td>${producto.Disponibilidad}</td> 
                    <td>${producto.Precio}</td>
                    <td><img src="${producto.Imagen}" alt="Producto" width="50"></td>
                    <td><button onclick="eliminarProducto('${producto.Codigo}')">Eliminar</button></td>
                `;

                tablaProductos.appendChild(fila); // Agregar la fila a la tabla
            });
        })
        .catch(error => console.error('Error al cargar los productos:', error));
}

function eliminarProducto(codigo) {
    const confirmar = confirm("¿Está seguro que desea eliminar este producto?");
    
    if (confirmar) {
        const formData = new FormData();
        formData.append('codigo', codigo);

        fetch('funcion_borrar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Producto eliminado exitosamente.');
                cargarProductos();  // Recargar la lista de productos
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error al eliminar el producto:', error));
    }
}

