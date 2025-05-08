<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Categorías relacionadas con entornos de oficina
        $officeCategories = [
            'Equipos informáticos',
            'Telefonía',
            'Mobiliario de oficina',
            'Papelería',
            'Organización',
            'Seguridad y salud',
            'Electrodomésticos',
            'Redes y comunicación'
        ];
        
        // Categorías para público general
        $generalCategories = [
            'Alimentación',
            'Hogar',
            'Electrónica de consumo',
            'Ropa y complementos'
        ];
        
        // Insertar todas las categorías
        foreach (array_merge($officeCategories, $generalCategories) as $category) {
            ProductCategory::create([
                'label' => $category
            ]);
        }
    }
}