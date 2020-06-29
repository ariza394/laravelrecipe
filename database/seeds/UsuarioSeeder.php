<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $user = User::create([
            'name' => 'Carlos',
            'email' => 'correo@correo.com',
            'password' => Hash::make('12345678'),
            'url' => 'http://laravelpage.com',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $user->perfil()->create();

        $user2 = User::create([
            'name' => 'Ivan',
            'email' => 'correo2@correo.com',
            'password' => Hash::make('12345678'),
            'url' => 'http://laravelpage.com',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $user2->perfil()->create();

    }
}
