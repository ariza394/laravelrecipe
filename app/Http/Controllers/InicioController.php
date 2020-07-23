<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    //
    public function index()
    {   
        //mostrar recetas por cantidad de votos
        //$votadas = Receta::has('likes','=',2)->get();
        $votadas =Receta::withCount('likes')->orderBy('likes_count','desc')->take(3)->get(); //withcount crea nueva columna llamada likes_count

        //pobtener recetas nuevas
        $nuevas = Receta::latest()->limit(3)->get();

        //obtener categorias
        $categorias = CategoriaReceta::all();

        //Agrupar recetas por categoria
        $recetas = [];

        foreach($categorias as $categoria){
            $recetas[ Str::slug($categoria->nombre)][] = Receta::where('categoria_id',$categoria->id)->limit(3)->get();
        }

        return view('inicio.index',compact('nuevas','recetas','votadas'));
    }
}
