<?php

namespace App\Http\Controllers;

use App\Receta;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;

class LikesController extends Controller
{
   
    public function __construct()
    {
        $this->Middleware('auth');
    }
    

    public function update(Request $request, Receta $receta)
    {
        return auth()->user()->meGusta()->toggle($receta);
    }

    
}
