<!DOCTYPE html>
<html lang="es" translate="no">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google" content="notranslate">
<title>Alumplastic</title>
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('alumplastic/style.css') }}"/>
<link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('alumplastic/css/jquery.fancybox.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('alumplastic/css/owl.carousel.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('alumplastic/css/owl.theme.default.min.css') }}"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@vite(['resources/js/productos/app.jsx'])
</head>

<body>
@include('alumplastic.partials.navbar')
@include('alumplastic.partials.bannerPrincipal')
@include('alumplastic.partials.about')
@include('alumplastic.partials.productos')

<x-galeria-trabajos/>

@include('alumplastic.partials.pasarela')
@include('alumplastic.partials.contacto')
@include('alumplastic.partials.footer')

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('alumplastic/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('alumplastic/js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('alumplastic/js/scrollIt.min.js') }}"></script>
<script src="{{ asset('alumplastic/js/isotope.pkgd.min.js') }}"></script>
<script>
    window.logoSrc = "{{ asset('alumplastic/images/logo.svg') }}";
</script>
<script src="{{ asset('alumplastic/js/animacion.js') }}"></script>
</body>
</html>