<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['title' => 'movimientos'],
            ['title' => 'gestionar cuentas'],
            ['title' => 'gestionar clientes'],
            ['title' => 'empresa'],
            ['title' => 'gestionar usuarios'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}