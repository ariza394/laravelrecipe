@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.3/trix.min.css" integrity="sha256-6kLTaBcx5YzpT29NiHTRE/QbWWlKpFjAdVUAmptRGOk=" crossorigin="anonymous" />
@endsection

@section('botones')
    <a href="{{route('recetas.index')}}" class="btn btn-outline-primary mr-2 text-uppercase font-weight-bold">
        <svg class="icono" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
        Admin Recipes
    </a>
@endsection

@section('content')

  <h1 class="text-center">Edit my Account</h1>
    <div class="justify-content-center mt-5">
        <div class="col-md-10 bg-white p-3">
            <form 
                action="{{route('perfiles.update',['perfil' => $perfil->id])}}"
                method="POST"
                enctype="multipart/form-data"
            >  
                @csrf
                @method('put') 
                {{--Nombre--}}
                <div class="form-group">
                    <label for="nombre">Name</label>
                    <input type="text" 
                        name="nombre" 
                        id="nombre" 
                        placeholder="Your Name" 
                        class="form-control @error('nombre') is-invalid @enderror"
                        value="{{$perfil->usuario->name}}"
                    />

                    @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                {{--Url--}}
                <div class="form-group">
                    <label for="url">WebSite</label>
                    <input type="text" 
                        name="url" 
                        id="url" 
                        placeholder="Your WebSite" 
                        class="form-control @error('url') is-invalid @enderror"
                        value="{{$perfil->usuario->url}}"
                    />

                    @error('url')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                {{--Biografia--}}
                <div class="form-group mt-2">
                    <label for="biografia">Biography</label>
                    <input id="biografia" type="hidden" name="biografia" value="{{$perfil->biografia}}">
                    <trix-editor 
                        input="biografia"
                        class="form-control @error('biografia') is-invalid  @enderror"
                    ></trix-editor>
                    @error('biografia')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                
                {{--Imagen--}}
                <div class="form-group mt-2">
                    <label for="imagen">Image</label>
                    <input 
                        id="imagen" 
                        type="file" 
                        class="form-control @error('imagen')  is-invalid @enderror"
                        name="imagen"
                        disabled
                    >
                    <h6>Sorry, images are not available in production by costs</h6>
                    @if($perfil->imagen)
                        <div class="mt-4">
                            <p>Current Image:</p>
                           <!-- <img src="/storage/{{$perfil->imagen}}" alt="" style="width:300px">-->
                           <img src="{{asset('images/chef.jpg')}}"alt="chef img" style="width:300px">
                        </div>
                        @error('imagen')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    @endif                    
                </div>

                {{--Submit--}}
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Save Changes">
                </div>
            </form>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.3/trix.min.js" 
        integrity="sha256-UILSuo1S5AFy4RyVZ9Xm7v8EVWLdv3IujsyN83s3wRw=" crossorigin="anonymous" defer>
    </script> 
@endsection