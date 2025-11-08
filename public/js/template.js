// Función para cerrar el sidebar al cargar la página
window.addEventListener("load", function () {
    if (window.innerWidth >= 768) {
        const sidebar = document.getElementById("sidebar");
        const contentContainer = document.querySelector(".content-container");
        const navbar = document.querySelector(".navbar");

        sidebar.style.left = "0"; // Abre el sidebar por defecto en dispositivos desktop
        contentContainer.style.marginLeft = "80px"; // Ajusta el margen izquierdo del contenido
        navbar.style.marginLeft = "80px"; // Ajusta el margen izquierdo del navbar
    }
});

// Función para alternar el sidebar
document
    .getElementById("sidebarCollapse")
    .addEventListener("click", function () {
        const sidebar = document.getElementById("sidebar");
        const contentContainer = document.querySelector(".content-container");
        const navbar = document.querySelector(".navbar");

        if (sidebar.style.left === "-80px" || sidebar.style.left === "") {
            sidebar.style.left = "0";
            contentContainer.style.marginLeft = "80px";
            navbar.style.marginLeft = "80px";
        } else {
            sidebar.style.left = "-80px";
            contentContainer.style.marginLeft = "0";
            navbar.style.marginLeft = "0";
        }
    });
$(document).ready(function () {
    var pdfOrientation = "landscape";

    $("#example").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "pdf",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: "Descargar PDF",
                customize: function (doc) {
                    doc.pageOrientation = pdfOrientation;

                    doc["header"] = function () {
                        return {
                            text: "MUNICIPALIDAD PROVINCIAL DE PIURA",
                            fontSize: 15,
                            alignment: "center",
                            color: "#5197F7",
                            margin: [10, 20, 10, 20], // [izquierda, arriba, derecha, abajo]
                        };
                    };

                    doc["footer"] = function (currentPage, pageCount) {
                        return {
                            text:
                                "Página " +
                                currentPage.toString() +
                                " de " +
                                pageCount,
                            alignment: "center",
                            fontSize: 10,
                        };
                    };

                    doc.styles.tableHeader = {
                        fontSize: 12,
                        bold: true,
                        fillColor: "#5197F7", // Color de fondo para el encabezado de la tabla
                        color: "#ffffff", // Color del texto
                    };

                    doc.styles.tableBodyEven = {
                        fontSize: 10,
                        fillColor: "#ffffff", // Color de fondo para las filas pares
                    };

                    doc.styles.tableBodyOdd = {
                        fontSize: 10,
                        fillColor: "#f5f5f5", // Color de fondo para las filas impares
                    };
                },
                className: "btn btn-danger",
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Imprimir',
                titleAttr: "Imprimir",
                exportOptions: {
                    columns: ":visible",
                },
                customize: function (win) {
                    $(win.document.body)
                        .css("font-size", "10pt")
                        .prepend(
                            '<h2 style="text-align: center;">MUNICIPALIDAD DISTRITAL DE EL ALTO</h2>',
                            '<p style="text-align: center;">Página ' +
                                1 +
                                "</p>"
                        );
                },
                className: "btn btn-primary",
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: "Descargar Excel",
                className: "btn btn-success",
            },
        ],
        lengthMenu: [10, 25, 50, 100],
        order: [[0, "desc"]],
    });
});
