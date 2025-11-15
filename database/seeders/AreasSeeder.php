<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            // ------- SEDE 1 -------
            ['name' => 'Alcaldía', 'hq' => 1],
            ['name' => 'Gerencia Municipal', 'hq' => 1],
            ['name' => 'Secretaría General', 'hq' => 1],
            ['name' => 'Asesoría Jurídica', 'hq' => 1],
            ['name' => 'Oficina de Planeamiento y Presupuesto', 'hq' => 1],
            ['name' => 'Oficina de Contabilidad', 'hq' => 1],
            ['name' => 'Oficina de Tesorería', 'hq' => 1],
            ['name' => 'Oficina de Logística', 'hq' => 1],
            ['name' => 'Oficina de Recursos Humanos', 'hq' => 1],
            ['name' => 'Oficina de Tecnología de la Información', 'hq' => 1],
            ['name' => 'Oficina de Control Institucional', 'hq' => 1],
            ['name' => 'Gerencia de Administración', 'hq' => 1],
            ['name' => 'Gerencia de Desarrollo Económico', 'hq' => 1],
            ['name' => 'Cooperación Técnica Internacional', 'hq' => 1],
            ['name' => 'Defensa Civil', 'hq' => 1],
            ['name' => 'Oficina de Imagen Institucional', 'hq' => 1],
            ['name' => 'Archivo Central', 'hq' => 1],
            ['name' => 'Gerencia de Servicios Públicos', 'hq' => 1],
            ['name' => 'Transporte y Seguridad Vial', 'hq' => 1],
            ['name' => 'Catastro Municipal', 'hq' => 1],
            ['name' => 'Registro Civil', 'hq' => 1],

            // ------- SEDE 2 -------
            ['name' => 'Gerencia de Desarrollo Social', 'hq' => 2],
            ['name' => 'Programas Sociales', 'hq' => 2],
            ['name' => 'Demuna', 'hq' => 2],
            ['name' => 'Omaped', 'hq' => 2],
            ['name' => 'Centro Integral del Adulto Mayor (CIAM)', 'hq' => 2],
            ['name' => 'Comedor Popular', 'hq' => 2],
            ['name' => 'Inclusión Social', 'hq' => 2],
            ['name' => 'Juventudes', 'hq' => 2],
            ['name' => 'Participación Vecinal', 'hq' => 2],
            ['name' => 'Gerencia de Educación, Cultura y Deporte', 'hq' => 2],
            ['name' => 'Biblioteca Municipal', 'hq' => 2],
            ['name' => 'Casa de la Cultura', 'hq' => 2],
            ['name' => 'Promoción Empresarial', 'hq' => 2],
            ['name' => 'Centro de Innovación Tecnológica', 'hq' => 2],
            ['name' => 'Oficina de Turismo', 'hq' => 2],
            ['name' => 'Gerencia de Desarrollo Ambiental', 'hq' => 2],
            ['name' => 'Áreas Verdes y Parques', 'hq' => 2],
            ['name' => 'Residuos Sólidos', 'hq' => 2],
            ['name' => 'Salud Ambiental', 'hq' => 2],
            ['name' => 'Zoonosis', 'hq' => 2],
            ['name' => 'Vigilancia Sanitaria', 'hq' => 2],

            // ------- SEDE 3 -------
            ['name' => 'Gerencia de Infraestructura', 'hq' => 3],
            ['name' => 'Obras Públicas', 'hq' => 3],
            ['name' => 'Mantenimiento de Vías', 'hq' => 3],
            ['name' => 'Maestranza', 'hq' => 3],
            ['name' => 'Supervisión de Obras', 'hq' => 3],
            ['name' => 'Desarrollo Urbano', 'hq' => 3],
            ['name' => 'Licencias de Construcción', 'hq' => 3],
            ['name' => 'Licencias de Funcionamiento', 'hq' => 3],
            ['name' => 'Control Urbano', 'hq' => 3],
            ['name' => 'Gerencia de Seguridad Ciudadana', 'hq' => 3],
            ['name' => 'Serenazgo', 'hq' => 3],
            ['name' => 'Cámaras de Videovigilancia', 'hq' => 3],
            ['name' => 'Tránsito y Transporte', 'hq' => 3],
            ['name' => 'Rondas Urbanas', 'hq' => 3],
            ['name' => 'Patrullaje Integrado', 'hq' => 3],
            ['name' => 'Atención al Ciudadano', 'hq' => 3],
            ['name' => 'Mesa de Partes', 'hq' => 3],
            ['name' => 'Saneamiento Físico Legal', 'hq' => 3],
            ['name' => 'Fiscalización y Control', 'hq' => 3],
            ['name' => 'Comercio Ambulatorio', 'hq' => 3],
            ['name' => 'Seguridad Industrial', 'hq' => 3],
        ];

        $data = [];
        foreach ($areas as $area) {
            $data[] = [
                'Name'           => $area['name'],
                'Status'         => 1,
                'Headquarters_id'=> $area['hq'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        DB::table('areas')->insert($data);
    }
}