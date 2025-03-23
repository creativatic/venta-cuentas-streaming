<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de clientes de ejemplo
        $clients = [
            [
                'type_client' => 'Empresa',
                'name_client' => 'Tech Solutions S.A.',
                'phone_client' => '+51 987654321',
                'email_client' => 'contacto@techsolutions.com',
                'description' => 'Empresa de soluciones tecnológicas.',
                'address' => 'Av. Tecnológica 123, Lima, Perú',
                'status' => 'Activo',
            ],
            [
                'type_client' => 'Persona Natural',
                'name_client' => 'Juan Pérez',
                'phone_client' => '+51 912345678',
                'email_client' => 'juanperez@gmail.com',
                'description' => 'Cliente recurrente de servicios.',
                'address' => 'Jr. Comercio 456, Arequipa, Perú',
                'status' => 'Activo',
            ],
            [
                'type_client' => 'Empresa',
                'name_client' => 'Comercializadora Andina',
                'phone_client' => '+51 923456789',
                'email_client' => 'ventas@comercialandina.com',
                'description' => 'Distribuidor mayorista de productos.',
                'address' => 'Calle Mayorista 789, Cusco, Perú',
                'status' => 'Pendiente',
            ],
        ];

        // Insertar clientes en la base de datos
        foreach ($clients as $clientData) {
            Client::firstOrCreate(
                ['email_client' => $clientData['email_client']], // Evitar duplicados
                $clientData
            );
        }

        $this->command->info('Clientes creados exitosamente.');
    }
}