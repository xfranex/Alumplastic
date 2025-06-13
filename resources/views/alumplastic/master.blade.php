<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Alumplastic</title>
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ asset('alumplastic/style.css') }}"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ asset('alumplastic/css/jquery.fancybox.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('alumplastic/css/owl.carousel.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('alumplastic/css/owl.theme.default.min.css') }}"/>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
@include('alumplastic.partials.navbar')
@include('alumplastic.partials.bannerPrincipal')
@include('alumplastic.partials.about')

<div class="services section-padding bg-grey" data-scroll-index="2">
  <div class="container">
    <div class="row justify-content-center">
      @include('alumplastic.partials.cuadradosProductos') <!--foreach hacer-->
    </div>
  </div>
</div>

@include('alumplastic.partials.galeria')
@include('alumplastic.partials.pasarela')
@include('alumplastic.partials.contacto')
@include('alumplastic.partials.footer')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
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