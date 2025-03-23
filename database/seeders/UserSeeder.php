<?php 

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1️⃣ Asegurar que exista una compañía por defecto
        $company = Company::firstOrCreate(
            ['id' => 1],
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

        // 2️⃣ Crear permisos si no existen
        $permissionsList = [
            'movimientos',
            'gestionar cuentas',
            'gestionar clientes',
            'empresa',
            'gestionar usuarios'
        ];

        foreach ($permissionsList as $title) {
            Permission::firstOrCreate(['title' => $title]);
        }

        // 3️⃣ Definir los roles y sus permisos
        $rolesPermissions = [
            'Super Admin' => ['movimientos', 'gestionar cuentas', 'gestionar clientes', 'empresa', 'gestionar usuarios'],
            'Gerente' => ['movimientos', 'gestionar cuentas', 'gestionar clientes', 'empresa'],
            'Admin' => ['movimientos', 'gestionar cuentas', 'gestionar clientes'],
            'Distribuidor' => ['movimientos', 'gestionar cuentas', 'gestionar clientes'],
        ];

        // Crear roles y asignar permisos
        foreach ($rolesPermissions as $roleName => $permissionTitles) {
            $role = Role::firstOrCreate(['title' => $roleName]);
            $permissions = Permission::whereIn('title', $permissionTitles)->pluck('id')->toArray();
            $role->permissions()->sync($permissions);
        }

        // 4️⃣ Definir usuarios y sus roles
        $users = [
            [
                'name' => 'Gerente',
                'email' => 'gerente@gmail.com',
                'password' => '12345678',
                'role' => 'Gerente',
            ],
            [
                'name' => 'Admin Ventas',
                'email' => 'adminventas@gmail.com',
                'password' => '12345678',
                'role' => 'Admin',
            ],
            [
                'name' => 'Distribuidor',
                'email' => 'distribuidor@gmail.com',
                'password' => '12345678',
                'role' => 'Distribuidor',
            ],
        ];

        foreach ($users as $userData) {
            // 5️⃣ Crear o encontrar el usuario
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'email_verified_at' => now(),
                    'company_id' => $company->id,
                ]
            );

            // Obtener el rol del usuario
            $role = Role::where('title', $userData['role'])->first();

            // Asignar rol al usuario
            $user->roles()->sync([$role->id]);
        }

        $this->command->info('Usuarios creados con sus respectivos roles y permisos.');
    }
}