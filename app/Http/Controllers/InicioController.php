<?php

namespace App\Http\Controllers;

use App\Receta;
use App\Categoria_receta;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    //
    public function index()
    {
        // Mostrar las recetas por cantidad de likes
        $votadas = Receta::withCount('likes')->orderBy('likes_count', 'desc')->limit(3)->get();

        // Obtener las recetas mas nuevas. El medoto latest hace lo mismo que el codigo de abajo
        // $nuevas = Receta::orderBy('created_at', 'DESC')->get();
        $nuevas = Receta::latest()->limit(6)->get();

        // Obtener todas las categorias
        $categorias = Categoria_receta::all();
        
        
        // Agrupar recetas por categoria
        $recetas = [];
        
        foreach($categorias as $categoria) {
            // Consulta
            $rc = Receta::where('categoria_id', $categoria->id)->limit(3)->get();

            //  Se asegura de no incluir una categoria sin recetas
            if ($rc->isNotEmpty()) {
                $recetas[Str::slug($categoria->nombre)][] = $rc;
            }

        }



        return view('inicio.index', compact('nuevas', 'recetas', 'votadas'));
    }
}
