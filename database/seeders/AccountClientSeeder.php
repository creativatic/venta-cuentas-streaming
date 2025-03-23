<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\Client;

class AccountClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las cuentas y clientes
        $accounts = Account::all();
        $clients = Client::all();

        // Si no hay cuentas o clientes, evitar errores
        if ($accounts->isEmpty() || $clients->isEmpty()) {
            $this->command->warn('⚠️ No hay cuentas o clientes para asignar.');
            return;
        }

        // Asignar clientes aleatorios a cada cuenta
        foreach ($accounts as $account) {
            $randomClients = $clients->random(rand(1, 2)); // Asigna 1 o 2 clientes por cuenta
            $account->clients()->attach($randomClients);
        }

        $this->command->info('Relaciones entre cuentas y clientes creadas exitosamente.');
    }
}