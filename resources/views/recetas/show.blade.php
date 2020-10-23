@extends('layouts.app')

@section('botones')
    <a href="{{ route('recetas.index') }}" class="btn btn-outline-primary text-uppercase font-weight mr-2">
        <svg class="icono" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
        </svg>
        Volver
    </a>
    <a href="{{ route('recetas.imprimir', $receta) }}" class="btn btn-outline-primary text-uppercase font-weight mr-2">
        <svg class="icono" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
        </svg>
        imprimir pdf
    </a>
@endsection

@section('content')
    {{-- {{$receta}} --}}
    <article class="contenido-receta bg-white p-5 shadow">
    <h1 class="text-center mb-4">{{ $receta->titulo }}</h1>

    <div class="imagen-receta">
        <img src="{{ Storage::url($receta->imagen) }}" class="w-100" alt="">
    </div>
    <div class="receta-meta mt-3">
        <p>
            <span class="font-weight-bold text-primary">Escrito en:</span>
            <a class="text-dark" href="{{ route('categorias.show', $receta->categoria->id) }}">{{ $receta->categoria->nombre }}</a>
        </p>
        <p>
            <span class="font-weight-bold text-primary">Autor:</span>
            <a class="text-dark" href="{{ route('perfiles.show', $receta->user->id) }}">{{ $receta->user->name }}</a>
            
        </p>
        <p>
            <span class="font-weight-bold text-primary ">Creado:</span>
            @php
                $fecha = $receta->created_at
            @endphp

            <fecha-receta fecha="{{ $fecha }}" type="format"></fecha-receta>
        </p>
        <p>
            <span class="font-weight-bold text-primary">Ultima modificacion:</span>
            <fecha-receta fecha="{{ $receta->updated_at }}"></fecha-receta>
        </p>
        <div class="ingredientes">
            <h2 class="my-3 text-primary">Ingredientes</h2>
            {!! $receta->ingredientes !!}
        </div>
        <div class="preparacion">
            <h2 class="my-3 text-primary">Preparacion</h2>
            {!! $receta->preparacion !!}
        </div>
        <div class="justify-content-center row text-center">
            
            <like-button 
                receta-id="{{ $receta->id }}"
                like="{{ $like }}"
                likes="{{ $totalLikes }}"
                >
            </like-button>
            
        </div>
    </div>
    </article>
@endsection

