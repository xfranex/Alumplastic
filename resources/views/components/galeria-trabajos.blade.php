<div class="portfolio section-padding" data-scroll-index='3'>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 section-title text-center">
                <h3>Nuestros Trabajos</h3>
                <p id="negro">Te compartimos un poco de lo que hacemos</p>
                <span class="section-title-line"></span>
            </div>
            <div class="filtering text-center mb-30">
                <button type="button" data-filter='*' class="active">Todos</button>
                @foreach ($carpinterias as $carpinteria)
                    <button type="button" data-filter='.{{ $carpinteria->id }}'>{{ $carpinteria->nombre }}</button>
                @endforeach
            </div>
            <div class="gallery no-padding col-lg-12 col-sm-12">
                @foreach ($trabajos as $trabajo)
                    <div class="col-lg-4 col-sm-6 {{ $trabajo->carpinteria_id }} no-padding">
                        <div class="item-img"> <a class="single-image"
                                href="{{ asset('storage/' . $trabajo->imagen) }}"></a>
                            <div class="part-img"> <img src="{{ asset('storage/' . $trabajo->imagen) }}" alt="imagen">
                                <div class="overlay-img">
                                    <h4>{{ $trabajo->carpinteria->nombre }}</h4>
                                    <h6>Carpintería</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
