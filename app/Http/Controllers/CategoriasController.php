<?php

namespace App\Http\Controllers;

use App\Categoria_receta;
use App\Receta;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    //
    public function show(Categoria_receta $categoria)
    {
        $recetas = Receta::where('categoria_id', $categoria->id)->paginate(3);
        return view('categorias.show', compact('recetas', 'categoria'));
    }
}
