<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jesus David',
            'email' => 'chuchober@hotmail.com',
            'password' => Hash::make('123456'),
            'url' => 'www.google.com',
        ]);
        
        // $user->perfil()->create();

        User::create([
            'name' => 'Jacobo',
            'email' => 'jacobo@hotmail.com',
            'password' => Hash::make('123456'),
            'url' => 'www.google.com',
        ]);
        
        User::create([
            'name' => 'Gabriel',
            'email' => 'gabriel@hotmail.com',
            'password' => Hash::make('123456'),
            'url' => 'www.google.com',
        ]);



    }
}
