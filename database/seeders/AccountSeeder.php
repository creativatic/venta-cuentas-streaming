<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios de prueba (cambia según tu BD)
        $user = User::where('email', 'gerente@gmail.com')->first();
        if (!$user) {
            $this->command->warn('⚠️ Usuario gerente@gmail.com no encontrado. Se omitirá la asignación de cuentas.');
            return;
        }

        // Obtener servicios
        $services = Service::whereIn('name', ['Netflix', 'DGO', 'Spotify', 'YouTube Premium'])->get()->keyBy('name');

        // Lista de cuentas a crear
        $accounts = [
            [
                'user_id' => $user->id,
                'services_id' => $services['Netflix']->id,
                'name_account' => 'Netflix Premium',
                'email_account' => 'netflix@gmail.com',
                'pass_account' => 'claveNetflix123',
                'type_account' => 'completa',
                'price' => $services['Netflix']->price,
                'date_pay' => now()->subDays(10),
                'renewal_date_account' => now()->addDays(20),
                'status' => 'activo',
                'description' => 'Cuenta compartida de Netflix Premium.',
            ],
            [
                'user_id' => $user->id,
                'services_id' => $services['DGO']->id,
                'name_account' => 'DGO Plan Full',
                'email_account' => 'dgo@gmail.com',
                'pass_account' => 'claveDGO123',
                'type_account' => 'perfiles',
                'price' => $services['DGO']->price,
                'date_pay' => now()->subDays(5),
                'renewal_date_account' => now()->addDays(25),
                'status' => 'disponible',
                'description' => 'Cuenta de DirecTV Go con deportes y series.',
            ],
            [
                'user_id' => $user->id,
                'services_id' => $services['Spotify']->id,
                'name_account' => 'Spotify Familiar',
                'email_account' => 'spotify@gmail.com',
                'pass_account' => 'claveSpotify123',
                'type_account' => 'perfiles',
                'price' => $services['Spotify']->price,
                'date_pay' => now()->subDays(3),
                'renewal_date_account' => now()->addDays(27),
                'status' => 'suspendido',
                'description' => 'Cuenta Spotify Premium Familiar.',
            ],
            [
                'user_id' => $user->id,
                'services_id' => $services['YouTube Premium']->id,
                'name_account' => 'YouTube Premium Plus',
                'email_account' => 'youtube@gmail.com',
                'pass_account' => 'claveYT123',
                'type_account' => 'completa',
                'price' => $services['YouTube Premium']->price,
                'date_pay' => now()->subDays(7),
                'renewal_date_account' => now()->addDays(23),
                'status' => 'activo',
                'description' => 'YouTube Premium sin anuncios y con YouTube Music.',
            ],
        ];

        // Insertar cuentas
        foreach ($accounts as $accountData) {
            Account::firstOrCreate(
                ['email_account' => $accountData['email_account']],
                $accountData
            );
        }

        $this->command->info('Cuentas creadas exitosamente.');
    }
}