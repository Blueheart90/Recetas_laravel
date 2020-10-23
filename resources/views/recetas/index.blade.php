@extends('layouts.app')

@section('botones')

    @include('ui.navegacion')

@endsection

@section('content')
    <h2 class="text-center mb-5">Administra tus Recetas</h2>
    <div class="col-md-10 mx-auto bg-white p-3">
        <table class="table">
            <thead class="bg-primary text-light">
                <tr>
                    <th scole="col">Titulo</th>
                    <th scole="col">Categoría</th>
                    <th scole="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recetas as $receta)
                    <tr>
                        <td>{{ $receta->titulo }}</td>
                        <td>{{ $receta->categoria->nombre }}</td>
                        <td>
                            {{-- <form action="{{ route('recetas.destroy', $receta->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <input type="submit" class="btn btn-danger w-100 mb-2" value="Eliminar &times;">

                            </form> --}}
                            <eliminar-receta receta-id="{{ $receta->id }}">
                            </eliminar-receta>
                            <a href="{{ route('recetas.edit', $receta->id) }}" class="btn btn-secondary mb-2 d-block">
                                <svg class="icono-ac" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                  </svg>
                                Editar
                            </a>
                            <a href="{{ route('recetas.show', $receta->id) }}" class="btn btn-success d-block">
                                <svg class="icono-ac" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                  </svg>
                                Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-12 mt-4 justify-content-center d-flex">

            {{ $recetas->links() }}
        </div>

        <h2 class="text-center-my-5">Recetas que te gustan</h2>
        @if (  count($usuario->meGusta) > 0 )
            <div class="col-md-10 mx-auto bg-white p-3">
                <ul class="list-group">
                    @foreach( $usuario->meGusta as $receta )
                        <li class="list-group-item d-flex justify-content-between aling-items-center">
                            <p> {{ $receta->titulo }} </p>
                            <a  class="btn btn-outline-success" href="{{ route('recetas.show', $receta->id) }}">Ver</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <p class="text-center">No tienes recetas en favoritos aún.</p>
        @endif
    </div>

@endsection