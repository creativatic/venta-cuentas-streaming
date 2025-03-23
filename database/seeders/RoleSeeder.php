<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['title' => 'Super Admin'],
            ['title' => 'Gerente'],
            ['title' => 'Admin'],
            ['title' => 'Distribuidor'],
            ['title' => 'User'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}