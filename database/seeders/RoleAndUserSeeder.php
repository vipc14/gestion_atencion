<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\AttentionExecutive;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear Roles
        $adminRole = Role::create(['name' => 'administrador']);
        $supervisorRole = Role::create(['name' => 'supervisor']);
        $userRole = Role::create(['name' => 'usuario de acceso']);

        // Crear Usuario Administrador
        $admin = User::create([
            'name' => 'Admin General',
            'username' => 'admin', // <-- AÑADIDO
            'email' => 'admin@sistema.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole($adminRole);

        // Crear Usuario Supervisor
        $supervisor = User::create([
            'name' => 'Supervisor de Area',
            'username' => 'supervisor', // <-- AÑADIDO
            'email' => 'supervisor@sistema.com',
            'password' => Hash::make('password')
        ]);
        $supervisor->assignRole($supervisorRole);

        // Crear Usuario de Acceso (Agente)
        $executive = AttentionExecutive::where('name', 'Ana Pérez')->first();
        if ($executive) {
            $agent = User::create([
                'name' => 'Agente Ana Pérez',
                'username' => 'aperez', // <-- AÑADIDO
                'email' => 'aperez@sistema.com',
                'password' => Hash::make('password'),
                'attention_executive_id' => $executive->id
            ]);
            $agent->assignRole($userRole);
        }
    }
}
