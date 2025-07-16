<nav class="navbar navbar-expand-lg">
  <div class="container"> 
    <div class="d-flex w-100 justify-content-between align-items-center">
      <a class="navbar-brand navbar-logo" href="{{ route('welcome') }}"> 
        <img src="{{ asset('alumplastic/images/logo.svg') }}" alt="logo" class="logo-1"> 
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> 
        <span class="fas fa-bars"></span> 
      </button>
    </div>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="0">Inicio</a> </li>
        <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="1">Conócenos</a> </li>
        <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="2">Productos</a> </li>
        <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="3">Trabajos</a> </li>
        <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="4">Horario</a> </li>
        <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="5">Contacto</a> </li>
        <li class="nav-item"> <a class="nav-link" href="{{ route('login') }}">Administración</a> </li>
      </ul>
    </div>
  </div>
</nav>
