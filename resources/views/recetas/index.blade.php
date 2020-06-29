@extends('layouts.app')
    
@section('botones')
    @include('ui.navegacion')
@endsection
@section('content')   
    <h2 class="text-center mb-5">Admin your recipes</h2>
    <div class="col-md-10 mx-auto bg-white p-3">
        <table class="table">
            <thead class="bg-primary text-light">
                <tr>
                    <th scole="col">Title</th>
                    <th scole="col">Category</th>
                    <th scole="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recetas as $receta)
                    <tr>
                        <td>{{$receta->titulo}}</td>
                        <td>{{$receta->categoria->nombre}}</td>
                        <td>
                            <eliminar-receta
                                receta-id={{$receta->id}}
                            ></eliminar-receta>
                           <!-- <form action="{{route('recetas.destroy',['receta' => $receta->id])}}" method="POST">
                                //@csrf
                               // @method('delete')
                                <input type="submit" class="btn btn-danger w-100 mb-2" value="Delete &times;"/>
                            </form>-->
                            
                            <a href="{{route('recetas.edit',['receta' => $receta->id])}}" class="btn btn-dark d-block mb-2">Edit</a>
                           <a href="{{route('recetas.show',['receta' => $receta->id])}}" class="btn btn-success d-block">Explore</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-12 mt-4 justify-content-center d-flex">
            {{$recetas->links()}}
        </div>

        <h2 class="text-center my-5">Recipes that you like</h2>
        <div class="col-md-5 mx-auto bg-white p-3">
            @if(count($usuario->meGusta) > 0)
                <ul class="list-group">
                    @foreach($usuario->meGusta as $receta)
                    <li class="list-group-item d-flex justify-content-between align-item-center">
                            <p>{{$receta->titulo}}</p>
                            <a class="btn btn-outline-success text-uppercase" href="{{route('recetas.show',['receta' =>$receta->id])}}">Explore</a>
                        </li> 
                    @endforeach
                </ul>
            @else
                <p class="text-center">You dont have favorte recipes</p>                
            @endif
        </div>

    </div>

@endsection