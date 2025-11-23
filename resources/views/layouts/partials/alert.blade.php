@if (session('success'))
<script>
    Swal.fire({
        icon: 'success', 
        title: '<h2 style="color: #4CAF50; font-weight: bold;">¡Éxito!</h2>',
        html: `<p style="font-size: 1.1em; color: #333;">{!! session('success') !!}</p>`, 
        background: 'linear-gradient(to right, #e0f7fa, #ffffff)', 
         width: 'auto', 
        showConfirmButton: true, 
        confirmButtonText: '<span style="font-weight: bold;">Aceptar</span>',
        confirmButtonColor: '#4CAF50', 
        padding: '1em',
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error', 
        title: '<h2 style="color: #f44336; font-weight: bold;">¡Error!</h2>', 
        html: `<p style="font-size: 1.1em; color: #333;">{!! session('error') !!}</p>`, 
        background: 'linear-gradient(to right, #ffebee, #ffffff)',
         width: 'auto', 
        showConfirmButton: true, 
        confirmButtonText: '<span style="font-weight: bold;">Reintentar</span>', 
        confirmButtonColor: '#f44336',
        padding: '1em',
    });
</script>
@endif
