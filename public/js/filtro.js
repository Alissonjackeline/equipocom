$(document).ready(function() {
    // Configuración para orientación horizontal en PDF
    var pdfOrientation = "landscape";

    $("#example").DataTable({
        dom: "Bfrtip",
        buttons: [{
                extend: "pdf",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'Descargar PDF',
                customize: function(doc) {
                    // Establecer la orientación del PDF
                    doc.pageOrientation = pdfOrientation;

                    // Agregar un encabezado personalizado
                    doc['header'] = function() {
                        return {
                            text: 'MUNICIPALIDAD PROVINCIAL DE PIURA',
                            fontSize: 15,
                            alignment: 'center',
                            color: '#5197F7',
                            margin: [10, 20, 10, 20] // [izquierda, arriba, derecha, abajo]
                        };
                    };

                    // Agregar un pie de página personalizado
                    doc['footer'] = function(currentPage, pageCount) {
                        return {
                            text: 'Página ' + currentPage.toString() + ' de ' + pageCount,
                            alignment: 'center',
                            fontSize: 10
                        };
                    };

                    // Estilos personalizados para la tabla
                    doc.styles.tableHeader = {
                        fontSize: 12,
                        bold: true,
                        fillColor: '#5197F7', // Color de fondo para el encabezado de la tabla
                        color: '#ffffff' // Color del texto
                    };

                    doc.styles.tableBodyEven = {
                        fontSize: 10,
                        fillColor: '#ffffff' // Color de fondo para las filas pares
                    };

                    doc.styles.tableBodyOdd = {
                        fontSize: 10,
                        fillColor: '#f5f5f5' // Color de fondo para las filas impares
                    };
                },
                className: 'btn btn-danger'
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Imprimir',
                titleAttr: 'Imprimir',
                exportOptions: {
                    columns: ':visible'
                },
                customize: function(win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(
                            '<h2 style="text-align: center;">MUNICIPALIDAD DISTRITAL DE EL ALTO</h2>',
                            '<p style="text-align: center;">Página ' + (1) + '</p>'
                        );
                },
                className: 'btn btn-primary'
            }
        ],
        lengthMenu: [10, 25, 50, 100]
    });
});

