<?php

namespace App\Http\Controllers;

use App\Perfil;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth',['except' =>'show']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {   
        //obtener recetas con paginacion
        $recetas = Receta::where('user_id',$perfil->user_id)->paginate(2);

        return view('perfiles.show',compact('perfil','recetas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {   
        
        $this->authorize('view',$perfil);   
        return view('perfiles.edit',compact('perfil'));
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
        //ejecuta policy
        $this->authorize('update',$perfil);

        //validar
        $data = request()->validate([
            'nombre' => 'required',
            'url' => 'required',
            'biografia' => 'required'
        ]);
        
        //si hay imagen
        if($request['imagen']){
            //path image
            $ruta_imagen = $request['imagen']->store('upload-perfiles','public');

            //image resize
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(600,600);
            $img->save();

            $perfil->imagen = $ruta_imagen;
        }

        //Asignar nombre y url
        Auth()->user()->url = $data['url'];
        Auth()->user()->name = $data['nombre'];
        Auth()->user()->save();

        $perfil->biografia = $data['biografia'];
        $perfil->save();

        //redireccionar
        return redirect()->action('RecetaController@index');
    }
}
