<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\Wholesaler;
use App\Models\WholesalerProduct;
use Illuminate\Database\Seeder;

class WholesalerProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Productos para entorno de oficina - detalles específicos
        $officeProducts = [
            'Equipos informáticos' => [
                [
                    'name' => 'Ordenador de sobremesa profesional',
                    'reference' => 'COMP-001',
                    'description' => 'Ordenador de sobremesa profesional con procesador i5, 16GB RAM, 512GB SSD, Windows 11 Pro, tarjeta gráfica integrada',
                    'price' => 799.99,
                    'stock' => 999999,
                    'image' => 'ordenador_sobremesa.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Portátil empresarial',
                    'reference' => 'COMP-002',
                    'description' => 'Portátil empresarial con procesador i7, 16GB RAM, 512GB SSD, Windows 11 Pro, pantalla FHD 14" antirreflejo, teclado retroiluminado',
                    'price' => 1199.99,
                    'stock' => 999999,
                    'image' => 'portatil_empresarial.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Monitor UltraWide 34"',
                    'reference' => 'MON-001',
                    'description' => 'Monitor LED IPS UltraWide 34" (21:9), resolución WQHD, HDR 10, altura y rotación ajustables, altavoces integrados',
                    'price' => 399.99,
                    'stock' => 999999,
                    'image' => 'monitor_ultrawide.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Impresora láser multifunción color',
                    'reference' => 'PRINT-001',
                    'description' => 'Impresora multifunción láser color: impresión, copia, escáner, fax. Velocidad 27 ppm, Wi-Fi Direct, pantalla táctil color',
                    'price' => 499.99,
                    'stock' => 999999,
                    'image' => 'impresora_multifuncion.jpg',
                    'is_office_related' => true
                ]
            ],
            'Telefonía' => [
                [
                    'name' => 'Teléfono IP ejecutivo',
                    'reference' => 'TEL-001',
                    'description' => 'Teléfono IP ejecutivo con pantalla táctil LCD color, teclas programables, audio HD, Bluetooth integrado, manos libres',
                    'price' => 245.99,
                    'stock' => 999999,
                    'image' => 'telefono_ip.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Smartphone empresarial',
                    'reference' => 'TEL-002',
                    'description' => 'Smartphone corporativo con Android Enterprise, 8GB RAM, 256GB almacenamiento, pantalla AMOLED 6.1", cámara 50MP, resistente al agua',
                    'price' => 749.99,
                    'stock' => 999999,
                    'image' => 'smartphone_empresarial.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Centralita telefónica IP',
                    'reference' => 'TEL-003',
                    'description' => 'Centralita IP expandible hasta 384 extensiones, comunicaciones unificadas, videoconferencia, mensajería instantánea',
                    'price' => 1299.99,
                    'stock' => 999999,
                    'image' => 'centralita_ip.jpg',
                    'is_office_related' => true
                ]
            ],
            'Mobiliario de oficina' => [
                [
                    'name' => 'Silla ergonómica ejecutiva malla',
                    'reference' => 'MOB-001',
                    'description' => 'Silla ergonómica premium con malla transpirable, soporte lumbar ajustable, reposabrazos 3D, inclinación sincronizada, base de aluminio pulido',
                    'price' => 1179.99,
                    'stock' => 999999,
                    'image' => 'silla_ergonomica.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Mesa de oficina en L estructura aluminio',
                    'reference' => 'MOB-002',
                    'description' => 'Mesa en forma de L con estructura de aluminio, superficie de melamina de alta resistencia, sistema de gestión de cables integrado',
                    'price' => 759.99,
                    'stock' => 999999,
                    'image' => 'mesa_oficina_L.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Armario archivador metálico 4 cajones',
                    'reference' => 'MOB-003',
                    'description' => 'Armario metálico de alta seguridad con 4 cajones para carpetas colgantes A4/Folio, sistema antivuelco, cerradura centralizada',
                    'price' => 349.99,
                    'stock' => 999999,
                    'image' => 'armario_archivador.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Estantería modular 5x5 compartimentos',
                    'reference' => 'MOB-004',
                    'description' => 'Estantería modular con 25 compartimentos, fabricada en aglomerado de alta densidad con acabado en melamina, 182x182cm',
                    'price' => 189.99,
                    'stock' => 999999,
                    'image' => 'estanteria_modular.jpg',
                    'is_office_related' => true
                ]
            ],
            'Papelería' => [
                [
                    'name' => 'Papel multifunción premium A4 80g',
                    'reference' => 'PAP-001',
                    'description' => 'Caja con 5 resmas (2500 hojas) de papel multifunción premium para impresoras láser e inkjet, alta blancura, certificación ecológica',
                    'price' => 24.99,
                    'stock' => 999999,
                    'image' => 'papel_premium.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 50 bolígrafos gel retráctiles',
                    'reference' => 'PAP-002',
                    'description' => 'Caja con 50 bolígrafos gel retráctiles tinta azul, punta 0.7mm, grip de caucho, clip metálico, tinta gel de secado rápido',
                    'price' => 52.99,
                    'stock' => 999999,
                    'image' => 'boligrafos_gel.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 10 agendas profesionales 2025',
                    'reference' => 'PAP-003',
                    'description' => 'Pack 10 agendas profesionales 2025, tamaño A5, tapa dura, papel marfil sin ácido, bolsillo interior, cierre elástico',
                    'price' => 199.99,
                    'stock' => 999999,
                    'image' => 'agendas_profesionales.jpg',
                    'is_office_related' => true
                ]
            ],
            'Organización' => [
                [
                    'name' => 'Bandeja documentos triple apilable',
                    'reference' => 'ORG-001',
                    'description' => 'Conjunto de 3 bandejas apilables de poliestireno de alta resistencia, tamaño A4, diseño ergonómico con frontal curvado',
                    'price' => 29.99,
                    'stock' => 999999,
                    'image' => 'bandeja_documentos.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 10 archivadores palanca lomo ancho',
                    'reference' => 'ORG-002',
                    'description' => 'Pack 10 archivadores de palanca lomo ancho (75mm), tamaño A4, cartón forrado en polipropileno, mecanismo niquelado',
                    'price' => 49.99,
                    'stock' => 999999,
                    'image' => 'archivadores_palanca.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Organizador de escritorio metálico',
                    'reference' => 'ORG-003',
                    'description' => 'Organizador metálico con malla de acero para escritorio, incluye separador de documentos, bandeja para correspondencia, portalápices',
                    'price' => 34.99,
                    'stock' => 999999,
                    'image' => 'organizador_escritorio.jpg',
                    'is_office_related' => true
                ]
            ],
            'Seguridad y salud' => [
                [
                    'name' => 'Botiquín primeros auxilios homologado',
                    'reference' => 'SEG-001',
                    'description' => 'Botiquín metálico homologado para empresas de 10-50 trabajadores, contenido según normativa, cierre con llave',
                    'price' => 85.99,
                    'stock' => 999999,
                    'image' => 'botiquin_homologado.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Extintor polvo ABC 6kg homologado',
                    'reference' => 'SEG-002',
                    'description' => 'Extintor homologado de polvo ABC de 6kg con eficacia 27A-183B, válvula con manómetro, soporte para pared, certificación CE',
                    'price' => 69.99,
                    'stock' => 999999,
                    'image' => 'extintor_homologado.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Kit señalización emergencia fotoluminiscente',
                    'reference' => 'SEG-003',
                    'description' => 'Pack completo de señalización fotoluminiscente para oficinas (salida, extintor, evacuación, primeros auxilios), homologado',
                    'price' => 59.99,
                    'stock' => 999999,
                    'image' => 'senalizacion_emergencia.jpg',
                    'is_office_related' => true
                ]
            ],
            'Electrodomésticos' => [
                [
                    'name' => 'Cafetera profesional de cápsulas',
                    'reference' => 'ELECT-001',
                    'description' => 'Cafetera profesional de cápsulas con depósito de agua 1.8L, 5 tamaños de taza, calentamiento rápido, apagado automático',
                    'price' => 249.99,
                    'stock' => 999999,
                    'image' => 'cafetera_profesional.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Microondas digital multifunción 28L',
                    'reference' => 'ELECT-002',
                    'description' => 'Microondas profesional con función horno y grill, capacidad 28L, 900W, distribución uniforme del calor, interior antibacteriano',
                    'price' => 189.99,
                    'stock' => 999999,
                    'image' => 'microondas_digital.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Dispensador de agua fría y caliente',
                    'reference' => 'ELECT-003',
                    'description' => 'Dispensador de agua con conexión a red, filtración avanzada, tecnología antimicrobiana, agua fría, ambiente y caliente',
                    'price' => 599.99,
                    'stock' => 999999,
                    'image' => 'dispensador_agua.jpg',
                    'is_office_related' => true
                ]
            ],
            'Redes y comunicación' => [
                [
                    'name' => 'Router empresarial seguridad avanzada',
                    'reference' => 'NET-001',
                    'description' => 'Router de seguridad empresarial con firewall, VPN, filtrado de contenido, 10 puertos Gigabit Ethernet, gestión en la nube',
                    'price' => 649.99,
                    'stock' => 999999,
                    'image' => 'router_empresarial.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Switch 24 puertos PoE gestionable',
                    'reference' => 'NET-002',
                    'description' => 'Switch gestionable de 24 puertos Gigabit Ethernet con PoE+, 2 puertos SFP, capacidad de conmutación de 52 Gbps',
                    'price' => 399.99,
                    'stock' => 999999,
                    'image' => 'switch_24puertos.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 10 cables Ethernet Cat6a ultradelgados',
                    'reference' => 'NET-003',
                    'description' => 'Pack de 10 cables de red Ethernet Cat6a ultrafinos, 10 Gbps, longitud 3 metros, conectores RJ45 blindados',
                    'price' => 59.99,
                    'stock' => 999999,
                    'image' => 'cables_ethernet.jpg',
                    'is_office_related' => true
                ]
            ]
        ];
        
        // Productos para público general
        $generalProducts = [
            'Alimentación' => [
                [
                    'name' => 'Caja 24 botellas agua mineral 50cl',
                    'reference' => 'ALIM-001',
                    'description' => 'Caja con 24 botellas de 50cl de agua mineral natural, baja mineralización, pH neutro, ideal para oficinas y consumo diario',
                    'price' => 15.99,
                    'stock' => 999999,
                    'image' => 'agua_mineral.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Pack 30 snacks variados individuales',
                    'reference' => 'ALIM-002',
                    'description' => 'Surtido de 30 bolsas individuales de snacks variados: patatas fritas, frutos secos, cortezas, aceitunas y galletas saladas',
                    'price' => 24.99,
                    'stock' => 999999,
                    'image' => 'snacks_variados.jpg',
                    'is_office_related' => false
                ]
            ],
            'Hogar' => [
                [
                    'name' => 'Juego de toallas 100% algodón 3 piezas',
                    'reference' => 'HOG-001',
                    'description' => 'Set de 3 toallas 100% algodón peinado 600g/m², incluye toalla de baño, toalla de manos y toalla facial, varios colores disponibles',
                    'price' => 34.99,
                    'stock' => 999999,
                    'image' => 'toallas_algodon.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Lámpara de mesa diseño contemporáneo',
                    'reference' => 'HOG-002',
                    'description' => 'Lámpara de mesa de diseño con base de aluminio y difusor de vidrio opalino, altura 36cm, diámetro 33cm, bombilla LED incluida',
                    'price' => 249.99,
                    'stock' => 999999,
                    'image' => 'lampara_diseno.jpg',
                    'is_office_related' => false
                ]
            ],
            'Electrónica de consumo' => [
                [
                    'name' => 'Auriculares inalámbricos cancelación ruido',
                    'reference' => 'ELEC-001',
                    'description' => 'Auriculares inalámbricos circumaurales con cancelación de ruido adaptativa, Bluetooth 5.2, autonomía de 30 horas, estuche de transporte',
                    'price' => 329.99,
                    'stock' => 999999,
                    'image' => 'auriculares_cancelacion.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Smartwatch multideporte GPS',
                    'reference' => 'ELEC-002',
                    'description' => 'Reloj inteligente con pantalla AMOLED, GPS integrado, monitorización avanzada de salud 24/7, más de 25 aplicaciones deportivas',
                    'price' => 399.99,
                    'stock' => 999999,
                    'image' => 'smartwatch_gps.jpg',
                    'is_office_related' => false
                ]
            ],
            'Ropa y complementos' => [
                [
                    'name' => 'Corbata seda natural ejecutiva',
                    'reference' => 'ROPA-001',
                    'description' => 'Corbata 100% seda natural hecha a mano, ancho 7,5cm, largo 152cm, diversos diseños ejecutivos, acabado mate con entretela de lana',
                    'price' => 49.99,
                    'stock' => 999999,
                    'image' => 'corbata_seda.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Pack 5 calcetines ejecutivos largos',
                    'reference' => 'ROPA-002',
                    'description' => 'Pack 5 pares de calcetines ejecutivos largos (hasta la rodilla) de hilo de algodón peinado, refuerzo en puntera y talón',
                    'price' => 39.99,
                    'stock' => 999999,
                    'image' => 'calcetines_ejecutivos.jpg',
                    'is_office_related' => false
                ]
            ]
        ];

        // Asignar productos a los mayoristas según su categoría, aplicando multiplicador aleatorio al precio
        $allProducts = $officeProducts + $generalProducts;

        foreach ($allProducts as $categoryLabel => $products) {
            // Obtener la categoría
            $category = ProductCategory::where('label', $categoryLabel)->first();
            
            if ($category) {
                // Encontrar mayoristas que tengan esta categoría
                $wholesalers = Wholesaler::whereHas('categories', function($query) use ($category) {
                    $query->where('product_categories.id', $category->id);
                })->get();
                
                // Si no hay mayoristas específicos para esta categoría, asignar a cualquier mayorista
                if ($wholesalers->isEmpty()) {
                    $wholesalers = Wholesaler::inRandomOrder()->limit(1)->get();
                }
                
                // Asignar productos a los mayoristas con multiplicador aleatorio de precios
                foreach ($wholesalers as $wholesaler) {
                    foreach ($products as $product) {
                        // Aplicar multiplicador aleatorio entre 0.9 y 1.10 para ventaja competitiva
                        $priceMultiplier = mt_rand(90, 110) / 100;
                        $product['price'] = round($product['price'] * $priceMultiplier, 2);
                        
                        $product['wholesaler_id'] = $wholesaler->id;
                        $product['category_id'] = $category->id;
                        
                        WholesalerProduct::create($product);
                    }
                }
            }
        }
    }
}