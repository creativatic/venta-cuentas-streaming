<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class, // Depende de `permissions`
            RoleSeeder::class,       // Depende de `permissions`
            CompanySeeder::class,
            SuperAdminSeeder::class, // Depende de `roles` y `permissions`
            UserSeeder::class,       // Depende de `roles` y `permissions`
            ClientSeeder::class,     // Seeders de clientes
            ServiceSeeder::class,    // Nuevo: Seeders de servicios (Netflix, DGO, etc.)
            //AccountSeeder::class,    // Nuevo: Seeders de cuentas con servicios
            AccountClientSeeder::class,
        ]);
    }
}
