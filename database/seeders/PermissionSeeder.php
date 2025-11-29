<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            // Permisos 
            'Ver-Catalogo',

            'Editar-Empresa',

            'Ver-Sedes',
            'Crear-Sedes',
            'Editar-Sedes',
            'Estado-Sedes',

            'Ver-Areas',
            'Crear-Areas',
            'Editar-Areas',
            'Estado-Areas',

            'Ver-Usuario',
            'Crear-Usuario',
            'Editar-Usuario',
            'Estado-Usuario',

            'Ver-Rol',
            'Crear-Rol',
            'Editar-Rol',
            'Eliminar-Rol',
            
            'Perfil',

            'Ver-Tipo-Equipo',
            'Crear-Tipo-Equipo',
            'Editar-Tipo-Equipo',
            'Estado-Tipo-Equipo',

            'Ver-Proveedor',
            'Crear-Proveedor',
            'Editar-Proveedor',
            'Estado-Proveedor',

            'Ver-Inventario',
            'Crear-Inventario',
            'Editar-Inventario',
            'Eliminar-Inventario',
            'Historial-Inventario',

            'Ver-Asignacion',
            'Crear-Asignacion',
            'Editar-Asignacion',
            'Eliminar-Asignacion',

            'Ver-Devolucion',
            'Crear-Devolucion',
            'Editar-Devolucion',
            'Eliminar-Devolucion',

            'Ver-Jefe',
            'Crear-Jefe',
            'Editar-Jefe',
            'Estado-Jefe',

        ];
        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}