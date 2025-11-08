// Función para actualizar el valor del campo de fecha y hora
function actualizarFechaHora() {
    var fechaInput = document.getElementById("fecha_hora");
    var fechaActual = new Date();
    var fechaHoraActual = fechaActual.getFullYear() + "-" +
        ("0" + (fechaActual.getMonth() + 1)).slice(-2) + "-" +
        ("0" + fechaActual.getDate()).slice(-2) + "T" +
        ("0" + fechaActual.getHours()).slice(-2) + ":" +
        ("0" + fechaActual.getMinutes()).slice(-2) + ":" +
        ("0" + fechaActual.getSeconds()).slice(-2);
    fechaInput.value = fechaHoraActual;
}

// Actualizar la fecha y hora cada segundo
setInterval(actualizarFechaHora, 1000);
actualizarFechaHora();

function updateCounter() {
    var textarea = document.getElementById('asunto');
    var counter = document.getElementById('counter');
    var maxLength = 1000;
    var currentLength = textarea.value.length;
    counter.textContent = currentLength + '/' + maxLength;

    if (currentLength > maxLength) {
        textarea.value = textarea.value.substring(0, maxLength);
        counter.textContent = maxLength + '/' + maxLength;
    }
}

document.addEventListener("DOMContentLoaded", function() {
    var documentoSelect = document.getElementById('documento_id');
    var numInformeLabel = document.getElementById('num_informe_label');
    var numInformeContainer = document.getElementById('num_informe_container');

    function actualizarLabelInforme(selectedOption) {
        if (selectedOption !== '') {
            numInformeLabel.textContent = 'N° ' + selectedOption;
        } else {
            numInformeLabel.textContent = 'N° Informe:';
        }
    }

    function toggleNumInformeField() {
        var selectedOption = documentoSelect.value;

        if (selectedOption !== '') {
            numInformeContainer.style.display = 'block'; 
        } else {
            numInformeContainer.style.display = 'none';
        }
    }
    documentoSelect.addEventListener('change', function() {
        var selectedOption = documentoSelect.options[documentoSelect.selectedIndex].text;
        actualizarLabelInforme(selectedOption); 
        toggleNumInformeField(); 
    });

    var initialOption = documentoSelect.options[documentoSelect.selectedIndex].text;
    actualizarLabelInforme(initialOption);
    toggleNumInformeField();
});