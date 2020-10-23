<?php

namespace App\Http\Controllers;

use App\User;
use App\Receta;
use Barryvdh\DomPDF\PDF;
use App\Categoria_receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class RecetaController extends Controller
{
    public function __construct()
    {
        // Protege todos los metodos con excepcion de show
        // $this->middleware('auth', ['except' => 'show']);
        $this->middleware('auth', ['except' => ['show', 'search']]);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Auth::user();

        // $recetas = Auth::user()->recetas;

        // Con paginacion
        $recetas = Receta::where('user_id', $usuario->id)->paginate(3);
        
        return view('recetas.index', compact('recetas', 'usuario'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // DB::table('categoria_receta')->get()->pluck('nombre', 'id')->dd();
        
        // Obtener categorias sin modelo
        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre', 'id');
        
        // Con modelo
        $categorias = Categoria_receta::all(['id', 'nombre']);
        
        return view('recetas.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validatedData  = $request->validate([
            'titulo' => 'required|min:6',
            'ingredientes' => 'required',
            'preparacion' => 'required',
            'imagen' => 'required|image',
            'categoria_id' => 'required',
        ]);
        // obtener ruta de la imagen. eje images/pepito.png
        $ruta = $request->file('imagen')->store('/images/recetas', 'public');
        
        // resize imagen
        $img = Image::make(public_path('storage/' . $ruta))->fit(1000, 550);
        $img->save();
        $validatedData['imagen'] = $ruta;

        // almacenar receta sin modelo
        // DB::table('recetas')->insert([
        //     'titulo' => $validatedData ['titulo'],
        //     'ingredientes' => $validatedData ['ingredientes'],
        //     'preparacion' => $validatedData ['preparacion'],
        //     'imagen' => $ruta,
        //     'user_id' => Auth::user()->id,
        //     'categoria_id' => $validatedData ['categoria']

        // ]);
        
        // Del usuario autenticado actual le creamos una receta
        // auth()->user()->recetas()->create([
        //     'titulo' => $validatedData ['titulo'],
        //     'ingredientes' => $validatedData ['ingredientes'],
        //     'preparacion' => $validatedData ['preparacion'],
        //     'imagen' => $ruta,
        //     'categoria_id' => $validatedData ['categoria']
        // ]);

        // Menos codigo
        auth()->user()->recetas()->create($validatedData);



        return redirect()->action('RecetaController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        // Obtener si el user actual le gusta la receta y esta autenticado
        // El método contains determina si la colección contiene un elemento determinado en forma bool
        $like = ( auth()->user() ) ? auth()->user()->meGusta->contains($receta->id)  : false;

        // Cantidad de likes
        $totalLikes = $receta->likes->count();

        return view('recetas.show', compact('receta', 'like', 'totalLikes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        // Policy
        $this->authorize('view', $receta);

        $categorias = Categoria_receta::all(['id', 'nombre']);
        return view('recetas.edit', compact('categorias', 'receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */

     // Devuelve el objeto receta, si se cambia por $id, devolvera solo el identificador
    public function update(Request $request, Receta $receta)
    {
        // Revisar el Policy ------ (nombre del metodo en el Policy, modelo actual)
        $this->authorize('update', $receta);
    
        $validatedData  = $request->validate([
            'titulo' => 'required|min:6',
            'ingredientes' => 'required',
            'preparacion' => 'required',
            // 'imagen' => 'required|image',
            'categoria_id' => 'required',
        ]);
 

        

        if($request->hasFile('imagen')){ 


            // obtener ruta de la imagen. eje images/pepito.png
            $ruta = $request->file('imagen')->store('/images/recetas', 'public');

            // resize imagen
            $img = Image::make(public_path('storage/' . $ruta))->fit(1000, 550);
            $img->save();

            if (isset($receta->imagen)) {

                if (Storage::exists( 'public/' . $receta->imagen)) {
                    Storage::delete( 'public/' . $receta->imagen);
                } 

            }

            // Se actualiza la ruta
            $validatedData['imagen'] = $ruta; 
        }

        $receta->update($validatedData);
        return redirect()->action('RecetaController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        $this->authorize('delete', $receta);
        
        if (isset($receta->imagen)) {
  
            if (Storage::exists( 'public/' . $receta->imagen)) {
                Storage::delete( 'public/' . $receta->imagen);
            }            
        }
        
        $receta->delete();
        return redirect()->action('RecetaController@index');

    
    }
    public function search(Request $request)
    {
        $busqueda = $request['buscar'];
        
        $recetas = Receta::where('titulo', 'like', '%' . $busqueda . '%')->paginate(3);
        $recetas->appends(['buscar' => $busqueda]);


        return view('busqueda.show', compact('recetas', 'busqueda'));
    }
    public function imprimir(Receta $receta)
    {
        // retreive all records from db
        // $data = Receta::all();
        // dd($receta);
        // El "\" se usa para que no tome PDF como un controller
        $pdf = \PDF::loadView('recetas.print', compact('receta'));


   

        // download PDF file with download method
        // return $pdf->download('pdf_file.pdf');
        return $pdf->stream($receta->titulo . '.pdf');

    }
}

