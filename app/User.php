<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //evento que se ejecuta despues del usuario creado
    protected static function boot(){
        parent::boot();

        //Asigna perfil
        static::created(function($user){
            
            $user->perfil()->create();
        });
    }

    /**relacion 1:n es uno a muchos de usuario a recetas */
    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    //relaccion 1 a 1 usuario perfil
    public function perfil(){
        return $this->hasOne(Perfil::class);
    }

    //receta que el usuario le ha dado me gusta
    public function meGusta()
    {
        return $this->belongsToMany(Receta::class,'likes_receta');
    }
}
