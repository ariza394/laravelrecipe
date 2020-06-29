<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{   
    protected $fillable = [
        'titulo', 'preparacion', 'ingredientes','imagen','categoria_id'
    ];
    //obtiene la categoria de la receta via Fk
    public function categoria()
    {
        return $this->belongsTo(CategoriaReceta::class);
    }

    //obtiene informacion del usuario via Fk
    public function autor()
    {
        return $this->belongsTo(User::class,'user_id'); //user id es la fk
    }

    //obtiene likes una receta
    public function likes()
    {
        return $this->belongsToMany(User::class,'likes_receta');
    }
}
