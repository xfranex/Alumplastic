<div class="testimonials" data-scroll-index='4'>
  <div class="testimonials-overlay section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-10 offset-md-1">
           <div class="owl-carousel owl-theme">
            @if($horario->tipo === "laboral")
                <div class="testimonial-item text-center">
                    <div class="icon"> <i class="fas fa-clock"></i></div>
                    <p class="m-auto horarioMensaje">{{ $horario->mensaje_laboral }}</p>
                    <div class="testimonial-author text-center">
                        <h4>{{ $horario->hora_mañana }}</h4>
                        <h4>{{ $horario->hora_tarde }}</h4>
                    </div>
                </div>
            @endif
            @if($horario->tipo === "vacaciones")
                <div class="testimonial-item text-center">
                    <div class="icon"> <i class="fas fa-clock"></i></div>
                    <p class="m-auto horarioMensaje">{{ $horario->mensaje_vacaciones }}</p>
                </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>