<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BossesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bosses = [];

        for ($i = 1; $i <= 63; $i++) {
            $bosses[] = [
                'Document'   => str_pad($i, 8, '0', STR_PAD_LEFT),
                'Name'       => 'Jefe Área ' . $i,
                'Cargo'      => 'Responsable del Área ' . $i,
                'Area_id'    => $i,
                'Phone'      => '9' . rand(10000000, 99999999),
                'Status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('bosses')->insert($bosses);
    }
}