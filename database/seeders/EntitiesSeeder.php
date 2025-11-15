<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('entities')->insert([
            [
                'Razon' => 'MUNICIPALIDAD PROVINCIAL DE PIURA',
                'Ruc' => '20547896321',
                'Representative' => 'Juan Pérez López',
                'Address' => 'Av. ',
                'Phone' => '987654321',
                'Correo' => 'contacto@muni.com',
                'Image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}