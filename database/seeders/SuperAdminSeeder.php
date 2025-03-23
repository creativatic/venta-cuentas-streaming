<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Company; // Importa el modelo Company
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Asegurar que exista una compañía con ID 1
        $company = Company::firstOrCreate(
            ['id' => 1], // Buscar o crear una compañía con ID 1
            [
                'name' => 'Empresa Ejemplo S.A.',
                'business_name' => 'Empresa Ejemplo Sociedad Anónima',
                'tax_id' => '12345678901',
                'phone' => '+51 987654321',
                'email' => 'contacto@empresaejemplo.com',
                'address' => 'Av. Ejemplo 123, Lima, Perú',
                'description' => 'Esta es una empresa de ejemplo para pruebas.',
            ]
        );

        // 1. Crear el usuario SuperAdmin
        $superadmin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'company_id' => $company->id, // Usar el ID de la compañía creada
            ]
        );

        // 2. Asegurar que existe el rol de Super Admin
        $superAdminRole = Role::firstOrCreate(['title' => 'Super Admin']);

        // 3. Asignar todos los permisos al rol Super Admin
        $permissions = Permission::all();
        
        // Si no hay permisos, crear los básicos
        if ($permissions->isEmpty()) {
            $permissionTitles = [
                'movimientos',
                'gestionar cuentas',
                'gestionar clientes',
                'empresa',
                'gestionar usuarios',
            ];

            foreach ($permissionTitles as $title) {
                Permission::firstOrCreate(['title' => $title]);
            }
            
            $permissions = Permission::all();
        }

        // Asignar todos los permisos al rol Super Admin
        $superAdminRole->permissions()->sync($permissions->pluck('id')->toArray());

        // 4. Asignar el rol de Super Admin al usuario
        $superadmin->roles()->sync([$superAdminRole->id]);

        $this->command->info('Usuario Superadmin creado y permisos asignados correctamente');
    }
}