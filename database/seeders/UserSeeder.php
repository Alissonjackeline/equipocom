<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si el usuario ya existe
        $user = User::where('Email', 'alisorozcosilva1@gmail.com')->first();
        
        if (!$user) {
            // Crear usuario si no existe
            $user = User::create([
                'Document' => '72489688',
                'Name' => 'ALISSON JACKELIN OROZCO SILVA',
                'Phone' => '986051815',
                'Email' => 'alisorozcosilva1@gmail.com',
                'Password' => bcrypt('alisson'),
                'Status' => 1
            ]);
        }

        $rol = Role::firstOrCreate(['name' => 'administrador']);
        
        $permisos = Permission::all();
    
        $rol->syncPermissions($permisos);
        $user->syncRoles([$rol->name]);
        
        $this->command->info("Usuario {$user->Name} configurado como administrador con todos los permisos.");
    }
}