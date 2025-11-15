@if (session('success')) 
<script>
    Swal.fire({
        title: '<h2 style="color: #4CAF50; font-weight: bold;">¡Éxito!</h2>', // Título estilizado
        html: `<p style="font-size: 1em; color: #333;">{!! session('success') !!}</p>`, // Mensaje estilizado
        imageUrl: '{{ asset('img/correcto.png') }}', // Ruta de la imagen personalizada
        imageWidth: 80, // Tamaño de la imagen ajustado
        imageHeight: 80,
        imageAlt: 'Éxito', // Texto alternativo
        background: 'linear-gradient(to right, #e0f7fa, #ffffff)', // Fondo degradado
        width: 'auto', // Ancho adaptativo
        showConfirmButton: true, // Botón de confirmación
        confirmButtonText: '<span style="font-weight: bold;">Aceptar</span>', // Texto del botón
        confirmButtonColor: '#4CAF50', // Color del botón
        padding: '1em', // Espaciado interno
        customClass: {
            container: 'swal-container-responsive', // Clase personalizada
        },
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        title: '<h2 style="color: #f44336; font-weight: bold;">¡Error!</h2>', // Título estilizado
        html: `<p style="font-size: 1em; color: #333;">{!! session('error') !!}</p>`, // Mensaje estilizado
        imageUrl: '{{ asset('img/incorrecto.png') }}', // Ruta de la imagen personalizada
        imageWidth: 80, // Tamaño de la imagen ajustado
        imageHeight: 80,
        imageAlt: 'Error', // Texto alternativo
        background: 'linear-gradient(to right, #ffebee, #ffffff)', // Fondo degradado
        width: 'auto', // Ancho adaptativo
        showConfirmButton: true, // Botón de confirmación
        confirmButtonText: '<span style="font-weight: bold;">Reintentar</span>', // Texto del botón
        confirmButtonColor: '#f44336', // Color del botón
        padding: '1em', // Espaciado interno
        customClass: {
            container: 'swal-container-responsive', // Clase personalizada
        },
    });
</script>
@endif
