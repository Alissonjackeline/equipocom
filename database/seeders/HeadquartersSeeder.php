<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeadquartersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('headquarters')->insert([
            [
                'Name'       => 'Sede Central',
                'Address'    => 'Av. Principal 123 - Centro',
                'Phone'      => '073-456789',
                'Status'     => 1,
                'Entity_id'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'Name'       => 'Sede de Servicios Municipales',
                'Address'    => 'Calle Comercio 456 - Urb. Popular',
                'Phone'      => '073-987654',
                'Status'     => 1,
                'Entity_id'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'Name'       => 'Sede Desarrollo Social',
                'Address'    => 'Jr. Progreso 789 - Sector Norte',
                'Phone'      => '073-112233',
                'Status'     => 1,
                'Entity_id'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}