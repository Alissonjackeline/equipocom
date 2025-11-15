<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([

            [
                'Company_name' => 'Tecnología Global S.A.',
                'Ruc'          => '20123456789',
                'Phone'        => '987654321',
                'Address'      => 'Av. Progreso 123 - Centro',
                'Status'       => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            [
                'Company_name' => 'Servicios Informáticos del Norte',
                'Ruc'          => '20456789123',
                'Phone'        => '912345678',
                'Address'      => 'Jr. Comercio 456 - Urb. Norte',
                'Status'       => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            [
                'Company_name' => 'Proveedores & Soluciones SAC',
                'Ruc'          => '20987654321',
                'Phone'        => '901234567',
                'Address'      => 'Calle Industrial 789 - Zona Sur',
                'Status'       => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

        ]);
    }
}