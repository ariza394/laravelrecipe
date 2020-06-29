@extends('layouts.app')


@section('content')

    <article class="contenido-receta bg-white p-5 shadow">
         <h1 class="text-center mb-4">{{$receta->titulo}}</h1>
         <div class="imagen-receta">
             <img src="/storage/{{$receta->imagen}}" class="w-100" alt="">
         </div>

         <div class="receta-meta mt-3">
             <p>
                 <span class="font-weight-bold text-primary">Write in:</span>
                 <a class="text-dark" href="{{route('categorias.show',['categoriaReceta' => $receta->categoria->id])}}">
                    {{$receta->categoria->nombre}}
                 </a>
             </p>
             <p>
                <span class="font-weight-bold text-primary">Author:</span>
                <a class="text-dark" href="{{route('perfiles.show',['perfil' => $receta->autor->id])}}">
                    {{$receta->autor->name}}
                 </a>
            </p>

            <p>
                <span class="font-weight-bold text-primary">Fecha:</span>
                {{--mostrar usuario--}}
                @php
                    $fecha = $receta->created_at
                @endphp
                <fecha-receta fecha="{{$fecha}}"></fecha-receta>
            </p>

            <div class="ingredientes">
                <h2 class="my-3 text-primary">Ingredients</h2>
                {!! $receta->ingredientes !!} {{--vienen con esos signos por que son de tipo text largo, estan guardados en la db con divs etc--}}
            </div>

            <div class="preparacion">
                <h2 class="my-3 text-primary">Preparation</h2>
                {!! $receta->preparacion !!}
            </div>
            {{--Buton for likes--}}
            <div class="justify-content-center row text-center">
                <like-Button
                    receta-id="{{$receta->id}}"
                    like="{{$like}}"
                    likes="{{$likes}}"
                ></like-Button>
            </div>            
         </div>
    </article>
@endsection