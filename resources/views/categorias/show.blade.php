@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="titulo-categoria text-uppercase mt-5 mb-4">Category: {{$categoriaReceta->nombre}}</h2>
    </div>
    <div class="row">
        @foreach($recetas as $receta)
            @include('ui.receta')
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-5">
        {{$recetas->links()}}
    </div>
@endsection