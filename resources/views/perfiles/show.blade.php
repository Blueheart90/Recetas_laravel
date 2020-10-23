@extends('layouts.app')
@section('botones')
<a href="{{ route('recetas.index') }}" class="btn btn-outline-primary text-uppercase font-weight mr-2">
    <svg class="icono" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
    </svg>
    Volver
</a>


@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                @if($perfil->imagen)
                    <img src="{{ Storage::url($perfil->imagen) }}" class="w-100 rounded-circle" alt="imagen chef">
                @endif
            </div>
            <div class="col-md-7 mt-5 mt-md-0">
                <h2 class="text-center md-2 text-primary">{{ $perfil->user->name }}</h2>
                <a href="{{ $perfil->user->url }}">Visitar Sitio Web</a>
                <div class="biografia">
                    {!! $perfil->biografia !!}
                </div>
            </div>
        </div>
    </div>
    <h2 class="text-center my-5">Recetas Creadas por: <span class="font-weight-bold text-primary">{{ $perfil->user->name }}</span></h2>
    <div class="container">
        <div class="row">
            @if ( count($recetas) > 0 )
                @foreach($recetas as $receta)
                    @include('ui.receta')
                @endforeach
                <div class="col-12 mt-4 justify-content-center d-flex">

                    {{ $recetas->links() }}
                </div>
            @else
                <p class="text-center w-100">No hay recetas aún...</p>
            @endif
        </div>
    </div>
@endsection