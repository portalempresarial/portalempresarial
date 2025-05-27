<?php

namespace Database\Seeders;

use App\Models\WholesalerSector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WholesalerSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = [
            'Tecnología',
            'Mobiliario',
            'Papelería',
            'Seguridad y Salud',
            'Electrodomésticos',
            'Equipos informáticos',
            'Telefonía',
            'Mobiliario de oficina',
            'Organización',
            'Redes y comunicación',
            'Alimentación',
            'Hogar',
            'Electrónica de consumo',
            'Ropa y complementos'
        ];

        foreach ($sectors as $sector) {
            WholesalerSector::firstOrCreate(['sector_name' => $sector]);
        }
    }
}
