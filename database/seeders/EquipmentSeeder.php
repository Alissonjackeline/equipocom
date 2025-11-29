<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('equipment')->insert([

            [
                'EquipmentType_id' => 1, 
                'CodigoPatri'      => 'PC-001',
                'Series'           => 'SR-12345',
                'Model'            => 'Optiplex 7080',
                'Brand'            => 'Dell',
                'Description'      => 'Computadora de escritorio para oficina',
                'Price'            => 2500.00,
                'status'           => 1,
                'Supplier_id'      => 1,
                'Imagen'           => null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],

            [
                'EquipmentType_id' => 2, // Laptop
                'CodigoPatri'      => 'LP-002',
                'Series'           => 'LP-98765',
                'Model'            => 'ThinkPad L14',
                'Brand'            => 'Lenovo',
                'Description'      => 'Laptop para uso administrativo',
                'Price'            => 3200.00,
                'status'           => 1,
                'Supplier_id'      => 1,
                'Imagen'           => null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],

            [
                'EquipmentType_id' => 3, // Impresora
                'CodigoPatri'      => 'IMP-003',
                'Series'           => 'IMP-45678',
                'Model'            => 'LaserJet Pro M404dn',
                'Brand'            => 'HP',
                'Description'      => 'Impresora láser monocromática',
                'Price'            => 1100.00,
                'status'           => 1,
                'Supplier_id'      => 2,
                'Imagen'           => null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],

        ]);
    }
}