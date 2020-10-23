@extends('layouts.app')

@section('styles')
    {{-- cdn de OwlCarousel2 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
@endsection

@section('hero')
    <div class="hero-categorias">
        <form  class="container h-100" action={{ route('buscar.show') }}>
            <div class="row h-100 align-items-center">
                <div class="col-md-4 texto-buscar">
                    <p class="display-4">Encuentra una receta para tu próxima comida</p>
                    <input  type="search" 
                            name="buscar" 
                            id=""
                            class="form-control"
                            placeholder="Buscar Receta"
                    >
                </div>
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="container nuevas-recetas">
        <h2 class="titulo-categoria text-uppercase  mb-4">Últimas recetas</h2>
        <div class="owl-carousel owl-theme">
            @foreach($nuevas as $nueva)
                <div class="card">
                    <img src="{{ Storage::url($nueva->imagen) }}" alt="" class="card-img-top">
                    <div class="card-body">
                        <h3>{{  Str::title(Str::limit($nueva->titulo, 23)) }}</h3>
                        {{-- <p>{{ Str::limit(strip_tags($nueva->preparacion), 50) }}</p> --}}
                        <p>{{ Str::words(strip_tags($nueva->preparacion), 20, ' ...') }}</p>
                        <a href="{{ route('recetas.show', $nueva->id) }}" class="btn btn-primary d-block mt-4 text-uppercase font-weight-bold">Ver Receta</a>
                    </div>
                    <div class="card-footer">
                        <span class="text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M6.166 16.943l1.4 1.4-4.622 4.657h-2.944l6.166-6.057zm11.768-6.012c2.322-2.322 4.482-.457 6.066-1.931l-8-8c-1.474 1.584.142 3.494-2.18 5.817-3.016 3.016-4.861-.625-10.228 4.742l9.6 9.6c5.367-5.367 1.725-7.211 4.742-10.228z"/></svg>
                            &nbsp;<fecha-receta fecha="{{ $nueva->created_at }}"></fecha-receta>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <h2 class="titulo-categoria text-uppercase mb-5 mt-4">Recetas por categoria</h2>
    @foreach($recetas as $key => $grupo)
        <div class="container">
            <h2 class="titulo-categoria text-uppercase mt-5 mb-4"> {{ str_replace('-', ' ', $key) }}</h2>
            <div class="row">
                @foreach($grupo as $recetas)
                        @foreach($recetas as $receta)
                            @include('ui.receta')
                        @endforeach
                @endforeach
            </div>
        </div>
    @endforeach

    <h2 class="titulo-categoria text-uppercase mb-5 mt-4">Recetas Populares</h2>
    <div class="container">
        <div class="row">
            @foreach($votadas as $receta)
                @include('ui.receta')
            @endforeach

        </div>
    </div>

@endsection



