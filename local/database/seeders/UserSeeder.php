<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador del Sistema',
            'email' => 'admin@gmail.com',
            'type'=>0,
            'photo'=>'null',
            'codigo'=>'0009',
            'password' => Hash::make('Genios_360'),
        ],
        [
            'name' => 'Tienda del Sistema',
            'email' => 'tienda@gmail.com',
            'type'=>2,
            'photo'=>'null',
            'codigo'=>'00019',
            'password' => Hash::make('Genios_360'),
        ]);
    }
}
