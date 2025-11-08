<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGCAEC - @yield('title')</title>
    <link rel="icon" href="{{ asset('img/inventario.png') }}" type="image/x-icon">
    <script src="https://kit.fontawesome.com/4dbafb7e3a.js" crossorigin="anonymous"></script>
    <link href="{{ asset('Css/partes.css') }}" rel="stylesheet" />
    <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Datatables -->
     <link href="{{ asset('Css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
     <link href="{{ asset('Css/buttons.bootstrap5.css') }}" rel="stylesheet" />

    @stack('css')
</head>

<body>
    <x-navigation-header />
    <div class="content-container">
        @yield('content')
    </div>

    <x-navigation-menu />

    @php
        $currentPageUrl = url()->current();
    @endphp
    <script>
        const currentPageUrl = "{{ $currentPageUrl }}";

        let activeLink = localStorage.getItem('activeLink') || null;

        function activateLink(event, link) {
            event.preventDefault();

            const links = document.querySelectorAll('.nav-link');

            links.forEach(function(link) {
                link.classList.remove('active');
            });

            link.classList.add('active');

            activeLink = link;

            localStorage.setItem('activeLink', activeLink.href);

            window.location.href = link.href;
        }

        // Establece el enlace activo inicialmente según la página actual
        const defaultLink = document.querySelector(`.nav-link[href="${currentPageUrl}"]`);
        if (defaultLink) {
            defaultLink.classList.add('active');
            activeLink = defaultLink;
            localStorage.setItem('activeLink', activeLink.href);
        }
    </script>

    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <!-- Datatables -->
   

     <!-- Datatables -->
     <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
     <script src="{{ asset('js/dataTables.bootstrap5.js') }}"></script>
     <script src="{{ asset('js/dataTables.buttons.js') }}"></script>
     <script src="{{ asset('js/buttons.bootstrap5.js') }}"></script>
     <script src="{{ asset('js/buttons.colVis.js') }}"></script>
     <script src="{{ asset('js/buttons.html5.js') }}"></script>
     <script src="{{ asset('js/buttons.print.js') }}"></script>
     <script src="{{ asset('js/jszip.js') }}"></script>
     <script src="{{ asset('js/pdfmake.js') }}"></script>
     <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <x-footer></x-footer>
    @stack('js')
</body>

{{-- @guest
   @include('errors.401') 
@endguest --}}

</html>
