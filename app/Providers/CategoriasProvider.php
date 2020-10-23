<?php

namespace App\Providers;

use App\Categoria_receta;
use View;
use Illuminate\Support\ServiceProvider;

class CategoriasProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Registra todo antes de que laravel comienze
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Se ejecuta cuando la aplicacion esta lista
        View::composer('*', function($view) {
            $categorias = Categoria_receta::all();
            $view->with('categorias', $categorias);
        });

    }
}
