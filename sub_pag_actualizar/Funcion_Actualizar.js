// Funciones redireccionar 
function cargar_principal() {
    window.location.href = '../Principal/Principal.html';
}
function cargar_crear() {
    window.location.href = '../sub_pag_crear/sub_pagina_Crear.html';
}
function cargar_borrar(){
    window.location.href = '../sub_pag_borrar/borrar.html';
}
function cargar_leer(){
    window.location.href = '../sub_pag_leer/leer.html';
}

// Funcion_Actualizar
function loadProducts() {
    fetch('recupera_base_datos.php') 
    .then(response => response.json())
    .then(data => {
        const productTableBody = document.getElementById('productTableBody');
        productTableBody.innerHTML = ''; // Limpiar la tabla antes de llenarla

        if (data.length > 0) {
            data.forEach(product => {
                const disponibilidadTexto = product.Disponibilidad === '1' ? 'Sí' : 'No';
                const row = `
                    <tr>
                        <td>${product.Codigo}</td>
                        <td>${product.Nombre}</td>
                        <td>${product.Descripción}</td>
                        <td>${product.Categoria}</td>
                        <td>${disponibilidadTexto}</td>
                        <td>${product.Precio}</td>
                        <td><img src="${product.Imagen}" alt="${product.Nombre}" width="50"></td>
                    </tr>
                `;
                productTableBody.innerHTML += row; // Agregar cada producto a la tabla
            });
        } else {
            const row = `<tr><td colspan="7">No se encontraron productos.</td></tr>`;
            productTableBody.innerHTML += row; // Mostrar mensaje si no hay productos
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('message').innerText = 'Error al cargar los productos.';
    });
}

// Cargar los productos al cargar la página
document.addEventListener('DOMContentLoaded', loadProducts);

