<div class="col-md-4 mb-4">
    <div class="card shadow">
        <img  class="card-img-top" src="{{ Storage::url($receta->imagen) }}" alt="">
        <div class="card-body">
            <h3 class="card-title">{{ Str::limit($receta->titulo, 20) }}</h3>
            <p>{{ Str::words(strip_tags($receta->preparacion), 20, ' ...') }}</p>
            <a href="{{ route('recetas.show', $receta->id) }}" class="btn btn-primary d-block mt-4 text-uppercase font-weight-bold">Ver Receta</a>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <p>
                <small class="text-muted"><span class="font-weight-bold text-primary">Publicada:</span></small>
                <fecha-receta fecha="{{ $receta->created_at }}" type="format"></fecha-receta>
            </p>
            <p><span class="font-weight-bold text-primary">{{ count( $receta->likes) }}
                <svg class="icono-ac" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                  {{-- <svg class="icono-ac" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                  </svg> --}}
            </span></p>
        </div>
    </div>
</div> 