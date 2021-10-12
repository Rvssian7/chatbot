<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
           'name'=>'Jordan Cuadro',
            'email'=>'jordan_j9@hotmail.com',
            'password'=> Hash::make('jordanj9')
        ]);
    }
}
