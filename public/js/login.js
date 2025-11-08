document.addEventListener("DOMContentLoaded", function() {
    var currentDateTime = new Date();
    var currentHour = currentDateTime.getHours();

    var startBlockHour = 7; // 7:00 AM en formato de 24 horas
    var endBlockHour = 17; // 5:00 PM en formato de 24 horas

    // Verifica si la hora actual está dentro del rango permitido (7:00 AM a 5:00 PM)
    if (currentHour >= startBlockHour && currentHour < endBlockHour) {
        // Si es así, mostrar el formulario de login normalmente
        var loginForm = `
            <form id="login-form" action="/login" method="post">
                @csrf
                <img src="{{ asset('img/escudo.png') }}" alt="Escudo" width="110px">
                <h5 class="pt-3">MUNICIPALIDAD DISTRITAL DE EL ALTO</h5>
                <h6 class="pt-1">Bienvenido al sistema de expedientes👋🏻</h6>
                @if ($errors->any())
                    @foreach ($errors->all() as $item)
                        <script>
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "{{ $item }}",
                            });
                        </script>
                    @endforeach
                @endif

                <div class="form-group pt-3 text-start">
                    <label>Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu email" required>
                </div>
                <div class="form-group pt-3 text-start">
                    <label>Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                </div>

                <div class="form-group pt-2">
                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </div>
            </form>
            <a class="buscar d-flex justify-content-end pt-2" href="{{ route('home') }}">Buscar expediente</a>
        `;
        document.getElementById('login-container').innerHTML = loginForm;
    } else {
        // Si no está dentro del rango permitido, mostrar mensaje de acceso restringido
        var restrictedAccessMessage = `
            <img src="{{ asset('img/escudo.png') }}" alt="Escudo" width="110px">
            <h5 class="pt-3">MUNICIPALIDAD DISTRITAL DE EL ALTO</h5>
            <h6 class="pt-1">Acceso Restringido</h6>
            <p>Solo se puede ingresar al sistema de expedientes<br> entre las 7:00 AM y las 5:00 PM.</p>
        `;
        document.getElementById('login-container').innerHTML = restrictedAccessMessage;
    }
});