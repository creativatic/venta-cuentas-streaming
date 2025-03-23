<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Account;
use App\Models\AccountProfile;
use App\Models\PaysProfile;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Datos de los servicios
        $services = [
            [
                'name' => 'Netflix',
                'price_services' => 44.90,
                'individually_price_services' => 4.90,
                'service_profiles' => 4,
                'link' => 'https://www.netflix.com',
                'image' => 'netflix.png',
                'description' => 'Servicio de streaming de series y películas.',
            ],
            [
                'name' => 'DGO',
                'price_services' => 29.90,
                'individually_price_services' => 9.90,
                'service_profiles' => 3,
                'link' => 'https://www.directvgo.com',
                'image' => 'dgo.png',
                'description' => 'Plataforma de streaming de DirecTV.',
            ],
            [
                'name' => 'Spotify',
                'price_services' => 18.90,
                'individually_price_services' => 4.90,
                'service_profiles' => 6,
                'link' => 'https://www.spotify.com',
                'image' => 'spotify.png',
                'description' => 'Servicio de streaming de música.',
            ],
            [
                'name' => 'YouTube Premium',
                'price_services' => 23.90,
                'individually_price_services' => 9.90,
                'service_profiles' => 6,
                'link' => 'https://www.youtube.com/premium',
                'image' => 'youtube.png',
                'description' => 'Servicio premium de YouTube sin anuncios.',
            ],
        ];

        // Iteramos sobre los servicios para crearlos
        foreach ($services as $serviceData) {
            $service = Service::firstOrCreate(['name' => $serviceData['name']], $serviceData);

            // Creamos una cuenta por defecto para este servicio
            $account = Account::create([
                'email_account' => strtolower($serviceData['name']) . '@example.com',
                'pass_account' => 'password123',
                'price' => $serviceData['price_services'],
                'status' => 'activo',
                'type_account' => 'perfiles',
                'services_id' => $service->id,
                'user_id' => 1,
                'name_account' => $serviceData['name'] . ' Account',
                'renewal_date_account' => now()->addMonth(),
                'available_profiles' => $serviceData['service_profiles'], // Total de perfiles disponibles
                'used_profiles' => 0, // Inicialmente no hay perfiles usados
                'description' => $serviceData['description'] // Usar la descripción del servicio
            ]);

            // Generamos los perfiles de acuerdo a la cantidad de perfiles del servicio
            for ($i = 0; $i < $serviceData['service_profiles']; $i++) {
                // Crear el perfil en account_profiles
                $accountProfile = AccountProfile::create([
                    'profile_number' => $i + 1,
                    'profile_name' => 'Perfil ' . ($i + 1),
                    'profile_pin' => str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT), // Genera un PIN aleatorio
                    'price' => $service->price,
                    'accounts_id' => $account->id,
                ]);

                // Crear el registro asociado en pays_profile
                PaysProfile::create([
                    'pay' => 0,
                    'total_pay' => 0,
                    'next_pay' => 0,
                    'date_pay' => now(),
                    'next_date_pay' => now()->addMonth(),
                    'renewal_date_profile' => now()->addMonths(3),
                    'status' => 'activo',
                    'description' => $serviceData['description'],
                    'account_profile_id' => $accountProfile->id,
                ]);
            }
        }

        $this->command->info('Servicios, cuentas y perfiles creados exitosamente.');
    }
}