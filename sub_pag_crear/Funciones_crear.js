
// Funcion_Actualizar
function cargar_principal() {
    window.location.href = '../Principal/Principal.html';
}
function cargar_actualizar() {
    window.location.href = '../sub_pag_actualizar/sub_pagina_Actualizar.html';
}
function cargar_crear(){
    window.location.href = '../sub_pag_crear/sub_pagina_Crear.html';
}
function cargar_borrar(){
    window.location.href = '../sub_pag_borrar/borrar.html';
}
function cargar_leer(){
    window.location.href = '../sub_pag_leer/leer.html';
}

// Evitar el envío por defecto del formulario
document.getElementById("productForm").addEventListener("submit", function(event) {
    event.preventDefault(); 

    let formData = new FormData(this);

    fetch('Ingreso_de_datos.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        const messageDiv = document.getElementById("message");
        if (result.includes("Exito")) {
            messageDiv.textContent = "La información fue enviada correctamente.";
            messageDiv.style.color = "green"; 
            // Mostrar alerta de confirmación
            if (confirm("La información fue enviada correctamente")) {
                // Redirigir a la página de actualización si el usuario acepta
                cargar_actualizar();
            }else {
                cargar_crear();
            }
        } else {
            messageDiv.textContent = "Hubo un problema al enviar la información.";
            messageDiv.style.color = "red"; 
        }
        console.log(result); // Muestra la respuesta en la consola
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
