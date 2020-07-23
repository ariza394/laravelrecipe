@extends('layouts.app')

@section('styles')

@endsection

@section('hero')
    <div class="hero-categorias">
        <form action="{{route('buscar.show')}}" class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-md-4 texto-buscar">
                    <p class="display-4">Find your recipe</p>
                    <input 
                        type="search"
                        name="buscar"
                        class="form-control"
                        placeholder="Find Your Recipe"
                    >
                </div>
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="container nuevas-recetas">        
        <h2 class="titulo-categoria text-uppercase mt-5 mb-4">Last Recipes</h2>
        <div class="row">
            @foreach($nuevas as $nueva)
                <div class="col-md-4">
                    <div class="card">
                        <img src="/storage/{{$nueva->imagen}}" alt="receta" class="card-img-top">
                        <!--<img src="{{ asset("/images/$nueva->imagen.jpg") }}" alt="receta" class="card-img-top">-->
                        <div class="card-body">
                            <h3>{{$nueva->titulo}}</h3>
                            <p>{{ Str::words( strip_tags($nueva->preparacion),20)}} </p>
                            <a href="{{route('recetas.show',['receta' => $nueva->id])}}" 
                                class="btn btn-primary d-block font-weight-bold text-uppercase">Explore
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container">
        <h2 class="titulo-categoria text-uppercase mt-5 mb-4">Recipes with more votes</h2>
        
        <div class="row">
                @foreach($votadas as $receta)
                    @include('ui.receta')
                @endforeach 
        </div>
    </div>

    @foreach($recetas as $key => $grupo)
        <div class="container">
            <h2 class="titulo-categoria text-uppercase mt-5 mb-4">{{ str_replace('-',' ',$key)}}</h2>
            
            <div class="row">
                @foreach($grupo as $recetas)
                    @foreach($recetas as $receta)
                        @include('ui.receta')
                    @endforeach                    
                @endforeach
            </div>
        </div>
    @endforeach
@endsection