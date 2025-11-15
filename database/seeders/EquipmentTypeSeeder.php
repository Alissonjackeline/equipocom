<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('equipment_types')->insert([
            [
                'Name'       => 'Computadora de Escritorio',
                'Description'=> 'Equipo informático para oficinas administrativas.',
                'Status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Name'       => 'Impresora',
                'Description'=> 'Equipos de impresión para documentos municipales.',
                'Status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Name'       => 'Laptop',
                'Description'=> 'Equipo portátil para uso de gerentes y jefaturas.',
                'Status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Name'       => 'Proyector Multimedia',
                'Description'=> 'Equipo para presentaciones y reuniones institucionales.',
                'Status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Name'       => 'Teléfono IP',
                'Description'=> 'Equipo telefónico para comunicación institucional.',
                'Status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Name'       => 'Escáner',
                'Description'=> 'Equipo para digitalización de documentos físicos.',
                'Status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Name'       => 'Switch de Red',
                'Description'=> 'Dispositivo para distribución de red interna.',
                'Status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Name'       => 'Servidor',
                'Description'=> 'Equipo de alto rendimiento para sistemas institucionales.',
                'Status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}