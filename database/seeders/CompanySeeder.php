<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un registro de ejemplo para la tabla 'companies'
        Company::create([
            'name' => 'Empresa Ejemplo S.A.',
            'business_name' => 'Empresa Ejemplo Sociedad Anónima',
            'tax_id' => '12345678901',
            'phone' => '+51 987654321',
            'email' => 'contacto@empresaejemplo.com',
            'currency' => '$',
            'address' => 'Av. Ejemplo 123, Lima, Perú',
            'description' => 'Esta es una empresa de ejemplo para pruebas.',
        ]);

        // Si deseas crear múltiples registros, puedes usar un bucle o el método `factory` (si tienes una factory definida)
        // Company::factory()->count(10)->create(); // Ejemplo con Factory
    }
}