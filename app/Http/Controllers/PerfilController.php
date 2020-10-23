<?php

namespace App\Http\Controllers;

use App\Perfil;
use App\Receta;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    public function __construct()
    {
        // Protege todos los metodos con excepcion de show
        $this->middleware('auth', ['except' => 'show']);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        
        // Con paginacion
        $recetas = Receta::where('user_id', $perfil->user_id)->paginate(6);

        return view('perfiles.show', compact('perfil', 'recetas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {
        // Ejecutar el Policy - bloquea el form de edit de un perfil ajeno
        $this->authorize('view', $perfil);

        return view('perfiles.edit', compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {
        // Ejecutar el Policy
        $this->authorize('update', $perfil);

        // Validar
        $validatedData  = $request->validate([
            'nombre' => 'required',
            'url' => 'required',
            'biografia' => 'required'
        ]);

        // Si el user sube una foto
        if($request->hasFile('imagen')){ 

            // obtener ruta de la imagen. eje images/pepito.png
            $ruta = $request->file('imagen')->store('/images/perfils', 'public');

            // resize imagen
            $img = Image::make(public_path('storage/' . $ruta))->fit(600, 600);
            $img->save();

            if (isset($perfil->imagen)) {

                if (Storage::exists( 'public/' . $perfil->imagen)) {
                    Storage::delete( 'public/' . $perfil->imagen);
                } 

            }

            // Se actualiza la ruta
            $validatedData['imagen'] = $ruta; 
        }

        // Asignar nombre y url a user
        auth()->user()->name = $validatedData['nombre'];
        auth()->user()->url = $validatedData['url'];
        auth()->user()->save();

        // Eliminar url y name de $validatedData, ya que estos campos no existen en la tabla perfils y puede ocasionar errores, quizas....
        unset($validatedData['nombre'], $validatedData['url']);

        // Asignar biografia e imagen a perfil
        $perfil->update($validatedData);
        
        return redirect()->action('RecetaController@index');

    }

}
