<div class="contact section-padding" data-scroll-index='5'>
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-title text-center">
                <h3>Contacto</h3>
                <p>Rellene todos los datos y nos pondremos en contacto lo antes posible con usted</p>
                <span class="section-title-line"></span>
            </div>
            <div class="col-lg-5 col-md-5 pr-4">
                <div class="part-info">
                    <div class="info-box">
                        <div class="icon"> <i class="fas fa-phone"></i> </div>
                        <div class="content">
                            <h4>Teléfono :</h4>
                            <p>696610158</p>
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="icon"> <i class="fas fa-map-marker-alt"></i> </div>
                        <div class="content">
                            <h4>Dirección :</h4>
                            <p>Calle Grisén, San Felix</p>
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="icon"> <i class="fas fa-envelope"></i> </div>
                        <div class="content">
                            <h4>Correo :</h4>
                            <p>alumplastic@yahoo.es</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 pl-4">
                <div class="contact-form" id="contacto">
                    <form action="{{ route('consultas.store') }}" class='form' id='contact-form' method='post' novalidate>
                        @csrf
                        <div class="messages"></div>
                        <div class="controls">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input id="form_name" type="text" name="nombre" placeholder="Nombre *"
                                            value="{{ old('nombre') }}">
                                        @error('nombre')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input id="form_number" type="number" name="telefono" placeholder="Teléfono *"
                                            value="{{ old('telefono') }}">
                                        @error('telefono')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input id="form_email" type="email" name="email" placeholder="Email *"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <input id="form_message" name="mensaje" class="form-control" placeholder="Mensaje *"
                                        rows="4" value="{{ old('mensaje') }}"></input>
                                    @error('mensaje')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="bttn" id="bttnC">Enviar</button>
                                    @if (session('successContacto'))
                                        <div id="success-message"
                                            class="mt-4 !text-green-600 text-center font-bold mensajeContacto">
                                            {{ session('successContacto') }}
                                        </div>
                                        <script>
                                            setTimeout(() => {
                                                const msg = document.getElementById('success-message');
                                                if (msg) {
                                                    msg.style.transition = 'opacity 0.5s ease';
                                                    msg.style.opacity = '0';
                                                    setTimeout(() => msg.remove(), 500);
                                                }
                                            }, 6000);
                                        </script>
                                    @endif
                                </div>
                                <script>
                                    document.getElementById('contact-form').addEventListener('submit', function() {
                                        const btn = document.getElementById('bttnC');
                                        btn.disabled = true;
                                        btn.textContent = 'Enviando';
                                    });
                                </script>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
