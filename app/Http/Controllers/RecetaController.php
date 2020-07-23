<?php

namespace App\Http\Controllers;

use App\CategoriaReceta;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{

    public function __construct()
    {   
        //metodo para obligar a estar autenticado
        $this->middleware('auth',['except' => ['show','search']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //Auth::user()->recetas->dd();
        //$recetas = Auth::user()->recetas;
        
        $usuario = Auth::user();

        //recetas con paginacion
        $recetas = Receta::where('user_id',$usuario->id)->paginate(2);

        return view('recetas.index',compact('recetas','usuario'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        //obtener categorias sin modelo
        //$categorias = DB::table('categoria_recetas')->get()->pluck('nombre','id');

        //con modelo
        $categorias = CategoriaReceta::all(['id','nombre']);

        return view('recetas.create',compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //dd($request->all()) ver lo que viene
        //dd($request['imagen']) un solo campo
        //dd($request['imagen']->store('upload-recetas','public')); //public->carpeta principal  upload-recetas->nueva carpeta

        //validation
        $data = request()->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'required||image'
        ]);
        
        //path image
        $ruta_imagen = $request['imagen']->store('upload-recetas','public');

        //image resize
        $img = Image::make(public_path("storage/{$ruta_imagen}"));
        $img->save();

        //insert data(sin modelo)
       /* DB::table('recetas')->insert([
            'titulo' => $data['titulo'],
            'preparacion' =>$data['preparacion'],
            'ingredientes' =>$data['ingredientes'],
            'imagen' => $ruta_imagen,
            'user_id' =>Auth::user()->id,
            'categoria_id' =>$data['categoria']
        ]);*/

        //insertar con modelo
        auth()->user()->recetas()->create([
            'titulo' => $data['titulo'],
            'preparacion' =>$data['preparacion'],
            'ingredientes' =>$data['ingredientes'],
            'imagen' => $ruta_imagen,
            'imagen' => $data['categoria'],
            'categoria_id' =>$data['categoria']
        ]); 

        //redireccionar
        return redirect()-> action('RecetaController@index');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show($receta)
    {   
        $receta = Receta::findOrFail($receta);

        //obtiene si el usuario actual le gusta la receta y esta autenticado
        $like = (auth()->user()) ?  auth()->user()->megusta->contains($receta) : false;

        //pasa la cantidad de likes a la vista
        $likes = $count = $receta->likes->count();

        return view('recetas.show',compact('receta','like','likes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {   
        $this->authorize('view',$receta);
        //revisa condicion
        $categorias = CategoriaReceta::all(['id','nombre']);
        return view('recetas.edit',compact('categorias','receta')); //view es la carpeta de vitas, y pued el nombre es edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {   
        $this->authorize('update',$receta);
        //validation
        $data = request()->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required'
        ]);

        //Asigna valores
        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];

        //return $request;
        //si el usuario sube una imagen
        if(request('imagen')){             
          //path image
            $ruta_imagen = $request['imagen']->store('upload-recetas','public');

            //image resize
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000,550); 
            $img->save();
            
            //asignar al objecto
            $receta->imagen=$ruta_imagen;
        }
        $receta->save();

        //redirecciona
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
        
        //revisa condicion
        $this->authorize('delete',$receta);
        $receta->delete();

        return redirect()->action('RecetaController@index');
    }

    public function search(Request $request)
    {   
        $busqueda = $request->get('buscar');
        //$busqueda = $request['buscar']; //buscar por que en el input viene como buscar el name

        $recetas = Receta::where('titulo','like','%'.$busqueda.'%')->paginate(2);
        $recetas->appends(['buscar' => $busqueda]);

        return view('busquedas.show',compact('recetas','busqueda'));
    }
}
