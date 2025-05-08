<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\Wholesaler;
use Illuminate\Database\Seeder;

class WholesalerProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wholesalerCategories = [
            'Tecnología' => [
                'Equipos informáticos',
                'Telefonía',
                'Redes y comunicación'
            ],
            'Mobiliario' => [
                'Mobiliario de oficina'
            ],
            'Papelería' => [
                'Papelería',
                'Organización'
            ],
            'Seguridad y Salud' => [
                'Seguridad y salud'
            ],
            'Electrodomésticos' => [
                'Electrodomésticos'
            ]
        ];
        
        foreach ($wholesalerCategories as $sector => $categoryLabels) {
            // Obtener mayoristas del sector
            $wholesalers = Wholesaler::where('sector', $sector)->get();
            
            // Obtener categorías
            $categories = ProductCategory::whereIn('label', $categoryLabels)->get();
            
            // Asignar categorías a cada mayorista del sector
            foreach ($wholesalers as $wholesaler) {
                foreach ($categories as $category) {
                    $wholesaler->categories()->attach($category->id);
                }
            }
        }
    }
}