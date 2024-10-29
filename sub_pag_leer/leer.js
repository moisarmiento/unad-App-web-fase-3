function cargar_principal() {
    window.location.href = '../Principal/Principal.html';
}
function cargar_crear() {
    window.location.href = '../sub_pag_crear/sub_pagina_Crear.html';
}
function cargar_borrar(){
    window.location.href = '../sub_pag_borrar/borrar.html';
}
function cargar_actualizar() {
    window.location.href = '../sub_pag_actualizar/sub_pagina_Actualizar.html';
}

function cargarProductos() {
    fetch('funcion_cargar.php')
        .then(response => response.json())
        .then(productos => {
            const tablaProductos = document.getElementById('tabla-productos');
            tablaProductos.innerHTML = '';

            productos.forEach(producto => {
               // const disponibilidadTexto = producto.Disponibilidad === '1' || producto.Disponibilidad === true ? 'Sí' : 'No';

                const fila = document.createElement('tr');

                fila.innerHTML = `
                    <td>${producto.Id_Producto}</td>
                    <td>${producto.Codigo}</td>
                    <td>${producto.Nombre}</td>
                    <td>${producto.Descripción}</td>
                    <td>${producto.Categoria}</td>
                    <td>${producto.Disponibilidad}</td>
                    <td>${producto.Precio}</td>
                    <td><img src="${producto.Imagen}" alt="Producto" width="50"></td>
                `;

                tablaProductos.appendChild(fila);
            });
        })
        .catch(error => console.error('Error al cargar los productos:', error));
}

// Cargar productos al iniciar la página
document.addEventListener('DOMContentLoaded', cargarProductos);
///////////////////////////////////

document.getElementById('searchButton').addEventListener('click', function() {
    const id = document.getElementById('searchBar').value;

    fetch(`funcion_buscar.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            const resultadoDiv = document.getElementById('resultado');
            resultadoDiv.innerHTML = ''; // Limpiar resultados anteriores

            if (data.status === 'success') {
                resultadoDiv.innerHTML = `
                    <h3>Detalles del Producto</h3>
                    <p>ID: ${data.producto.Id_Producto}</p>
                    <p>Código: ${data.producto.Codigo}</p>
                    <p>Nombre: ${data.producto.Nombre}</p>
                    <p>Descripción: ${data.producto.Descripción}</p>
                    <p>Categoría: ${data.producto.Categoria}</p>
                    <p>Disponibilidad: ${data.producto.Disponibilidad}</p>
                    <p>Precio: ${data.producto.Precio}</p>
                `;
            } else {
                resultadoDiv.innerHTML = '<p>Producto no encontrado.</p>';
            }
        })
        .catch(error => console.error('Error al buscar el producto:', error));
});
