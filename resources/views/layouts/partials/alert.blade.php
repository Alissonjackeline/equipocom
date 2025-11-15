@if (session('success'))
<script>
    Swal.fire({
        icon: 'success', // Ícono de éxito
        title: '<h2 style="color: #4CAF50; font-weight: bold;">¡Éxito!</h2>', // Título estilizado
        html: `<p style="font-size: 1.1em; color: #333;">{!! session('success') !!}</p>`, // Mensaje estilizado
        background: 'linear-gradient(to right, #e0f7fa, #ffffff)', // Fondo degradado
         width: 'auto', // Ancho adaptativo
        showConfirmButton: true, // Mostrar botón de confirmación
        confirmButtonText: '<span style="font-weight: bold;">Aceptar</span>', // Texto del botón
        confirmButtonColor: '#4CAF50', // Color del botón
        padding: '1em', // Espaciado interno
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error', // Ícono de error
        title: '<h2 style="color: #f44336; font-weight: bold;">¡Error!</h2>', // Título estilizado
        html: `<p style="font-size: 1.1em; color: #333;">{!! session('error') !!}</p>`, // Mensaje estilizado
        background: 'linear-gradient(to right, #ffebee, #ffffff)', // Fondo degradado
         width: 'auto', // Ancho adaptativo
        showConfirmButton: true, // Mostrar botón de confirmación
        confirmButtonText: '<span style="font-weight: bold;">Reintentar</span>', // Texto del botón
        confirmButtonColor: '#f44336', // Color del botón
        padding: '1em', // Espaciado interno
    });
</script>
@endif
