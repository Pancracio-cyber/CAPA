<?php

use Illuminate\Database\Seeder;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tokens')->insert([
            'token' => env('API_KEY', 'Error'),
            'descripcion' => 'Este es el número token que se utilizará como seguridad en cada API',
            'ip' => '',
            'dominio' => ''
        ]);
    }
}
