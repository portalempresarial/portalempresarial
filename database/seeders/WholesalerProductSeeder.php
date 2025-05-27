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
        $officeProducts = [            'Equipos informáticos' => [
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
                ],
                [
                    'name' => 'Servidor empresarial rack 1U',
                    'reference' => 'COMP-003',
                    'description' => 'Servidor empresarial formato rack 1U, doble procesador Xeon, 64GB RAM ECC, 4x1TB SSD RAID, doble fuente alimentación',
                    'price' => 2499.99,
                    'stock' => 999999,
                    'image' => 'servidor_rack.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'NAS 4 bahías para almacenamiento en red',
                    'reference' => 'COMP-004',
                    'description' => 'Dispositivo NAS de 4 bahías para almacenamiento en red, CPU quad-core, 4GB RAM, RAID 0/1/5/10, compatible con discos de hasta 20TB',
                    'price' => 599.99,
                    'stock' => 999999,
                    'image' => 'nas_4bahias.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Tablet profesional con lápiz digital',
                    'reference' => 'COMP-005',
                    'description' => 'Tablet profesional de 12.9" con lápiz digital incluido, 256GB almacenamiento, WiFi+Celular, ideal para diseñadores y profesionales',
                    'price' => 1099.99,
                    'stock' => 999999,
                    'image' => 'tablet_profesional.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Escáner documentos alta velocidad ADF',
                    'reference' => 'COMP-006',
                    'description' => 'Escáner profesional de documentos alta velocidad 60ppm, ADF para 100 hojas, escaneo dúplex, conectividad USB/WiFi/Ethernet',
                    'price' => 749.99,
                    'stock' => 999999,
                    'image' => 'escaner_documentos.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Monitor profesional 27" 4K calibrado',
                    'reference' => 'MON-002',
                    'description' => 'Monitor profesional para diseño gráfico 27" 4K, calibrado de fábrica, 99% Adobe RGB, calibrador incorporado, visera antireflejos',
                    'price' => 899.99,
                    'stock' => 999999,
                    'image' => 'monitor_calibrado.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Plotter de impresión gran formato 44"',
                    'reference' => 'PRINT-002',
                    'description' => 'Plotter de impresión profesional de gran formato 44", resolución 2400x1200dpi, 8 tintas pigmentadas, WiFi/Ethernet, stand incluido',
                    'price' => 2899.99,
                    'stock' => 999999,
                    'image' => 'plotter_impresion.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Lector código de barras inalámbrico',
                    'reference' => 'COMP-007',
                    'description' => 'Lector código de barras inalámbrico profesional, alcance 100m, batería 20h, resistente a caídas desde 1.8m, IP65',
                    'price' => 219.99,
                    'stock' => 999999,
                    'image' => 'lector_barras.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 5 discos duros externos USB-C 2TB',
                    'reference' => 'COMP-008',
                    'description' => 'Pack de 5 discos duros externos USB-C, 2TB cada uno, velocidad transferencia hasta 550MB/s, carcasa metálica resistente',
                    'price' => 499.99,
                    'stock' => 999999,
                    'image' => 'discos_externos.jpg',
                    'is_office_related' => true
                ]
            ],            'Telefonía' => [
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
                ],
                [
                    'name' => 'Pack 5 walkie talkies profesionales',
                    'reference' => 'TEL-004',
                    'description' => 'Set de 5 walkie talkies profesionales, alcance hasta 10km, 16 canales, batería 18h, cargador múltiple incluido, IP67',
                    'price' => 299.99,
                    'stock' => 999999,
                    'image' => 'walkie_talkies.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Terminal punto de venta móvil',
                    'reference' => 'TEL-005',
                    'description' => 'Terminal punto de venta móvil con lector tarjetas integrado, impresora térmica, batería 10h, pantalla táctil 7", Android POS',
                    'price' => 599.99,
                    'stock' => 999999,
                    'image' => 'terminal_venta.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Auricular Bluetooth profesional',
                    'reference' => 'TEL-006',
                    'description' => 'Auricular Bluetooth profesional con cancelación de ruido activa, 24h conversación, multipunto, estuche cargador incluido',
                    'price' => 129.99,
                    'stock' => 999999,
                    'image' => 'auricular_bluetooth.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Sistema de audioconferencia HD',
                    'reference' => 'TEL-007',
                    'description' => 'Sistema de audioconferencia para salas medianas, micrófonos 360º, captación hasta 6m, Bluetooth, USB, ampliable con satélites',
                    'price' => 499.99,
                    'stock' => 999999,
                    'image' => 'audioconferencia_hd.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Intercomunicador oficina 5 estaciones',
                    'reference' => 'TEL-008',
                    'description' => 'Sistema intercomunicador para oficina con 5 estaciones, comunicación full-duplex, alcance 300m, alimentación PoE',
                    'price' => 349.99,
                    'stock' => 999999,
                    'image' => 'intercomunicador_oficina.jpg',
                    'is_office_related' => true
                ]
            ],            'Mobiliario de oficina' => [
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
                ],
                [
                    'name' => 'Mesa de reuniones ovalada 8 personas',
                    'reference' => 'MOB-005',
                    'description' => 'Mesa de reuniones ovalada para 8 personas, superficie en cristal templado 12mm, patas acero inoxidable, pasacables central',
                    'price' => 899.99,
                    'stock' => 999999,
                    'image' => 'mesa_reuniones.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 4 sillas confidente apilables',
                    'reference' => 'MOB-006',
                    'description' => 'Set de 4 sillas confidente apilables, estructura de acero cromado, asiento y respaldo tapizado en símil piel, uso intensivo',
                    'price' => 249.99,
                    'stock' => 999999,
                    'image' => 'sillas_confidente.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Biombo separador oficina modular',
                    'reference' => 'MOB-007',
                    'description' => 'Biombo separador acústico modular para oficina, estructura aluminio, panel textil fonoabsorbente, dimensiones 160x160cm',
                    'price' => 359.99,
                    'stock' => 999999,
                    'image' => 'biombo_separador.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Mostrador recepción modular en L',
                    'reference' => 'MOB-008',
                    'description' => 'Mostrador de recepción modular en L con frontal iluminado LED, superficie madera y frontales cristal, mostrador alto con reposapiés',
                    'price' => 1599.99,
                    'stock' => 999999,
                    'image' => 'mostrador_recepcion.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Cajonera con ruedas 3 cajones',
                    'reference' => 'MOB-009',
                    'description' => 'Cajonera con ruedas, 3 cajones con guías metálicas, fabricada en melamina 19mm, cerradura centralizada, dimensiones 42x59x58cm',
                    'price' => 149.99,
                    'stock' => 999999,
                    'image' => 'cajonera_ruedas.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Perchero pie metálico 8 perchas',
                    'reference' => 'MOB-010',
                    'description' => 'Perchero de pie metálico con 8 perchas giratorias, base de mármol estable, altura 187cm, acabado cromado mate, paragüero incluido',
                    'price' => 89.99,
                    'stock' => 999999,
                    'image' => 'perchero_pie.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Armario alto melamina con puertas',
                    'reference' => 'MOB-011',
                    'description' => 'Armario alto de melamina con puertas y cerradura, 4 estantes regulables, dimensiones 90x200x45cm, disponible en varios acabados',
                    'price' => 299.99,
                    'stock' => 999999,
                    'image' => 'armario_melamina.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Conjunto 4 mesas trabajo en isla',
                    'reference' => 'MOB-012',
                    'description' => 'Conjunto de 4 mesas de trabajo enfrentadas en isla, estructura metálica, separadores frontales, electrificación integrada',
                    'price' => 1299.99,
                    'stock' => 999999,
                    'image' => 'mesas_isla.jpg',
                    'is_office_related' => true
                ]
            ],            'Papelería' => [
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
                ],
                [
                    'name' => 'Caja 1000 grapas galvanizadas 24/6',
                    'reference' => 'PAP-004',
                    'description' => 'Caja con 1000 grapas galvanizadas 24/6, alta resistencia, para grapadoras estándar, no se atascan',
                    'price' => 2.99,
                    'stock' => 999999,
                    'image' => 'grapas_galvanizadas.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 50 carpetas clasificadoras A4',
                    'reference' => 'PAP-005',
                    'description' => 'Pack de 50 carpetas clasificadoras A4 con 12 separadores, cubiertas de polipropileno, pestañas personalizables',
                    'price' => 79.99,
                    'stock' => 999999,
                    'image' => 'carpetas_clasificadoras.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Caja 100 fundas multitaladro A4',
                    'reference' => 'PAP-006',
                    'description' => 'Caja de 100 fundas multitaladro A4, polipropileno de 80 micras, acabado cristal, antirreflectantes, apertura superior',
                    'price' => 19.99,
                    'stock' => 999999,
                    'image' => 'fundas_multitaladro.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 20 blocs de notas adhesivas',
                    'reference' => 'PAP-007',
                    'description' => 'Pack de 20 blocs de 100 notas adhesivas cada uno, tamaño 76x76mm, colores surtidos neón, adhesivo reposicionable',
                    'price' => 15.99,
                    'stock' => 999999,
                    'image' => 'notas_adhesivas.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 20 rotuladores pizarra blanca',
                    'reference' => 'PAP-008',
                    'description' => 'Set de 20 rotuladores para pizarra blanca, punta biselada, 4 colores surtidos, tinta borrado en seco sin residuos',
                    'price' => 24.99,
                    'stock' => 999999,
                    'image' => 'rotuladores_pizarra.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Lote 3 cuadernos espiral A4 tapa dura',
                    'reference' => 'PAP-009',
                    'description' => 'Lote de 3 cuadernos de espiral A4 con tapa dura, 80 hojas microperforadas, papel 90g/m², cuadrícula 5mm',
                    'price' => 12.99,
                    'stock' => 999999,
                    'image' => 'cuadernos_espiral.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Caja 20 grapadoras de oficina',
                    'reference' => 'PAP-010',
                    'description' => 'Caja con 20 grapadoras metálicas de oficina, capacidad 25 hojas, compatible con grapas estándar 24/6 y 26/6',
                    'price' => 119.99,
                    'stock' => 999999,
                    'image' => 'grapadoras_oficina.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 12 pegamentos en barra 40g',
                    'reference' => 'PAP-011',
                    'description' => 'Pack de 12 pegamentos en barra de 40g, sin disolventes, lavable, secado rápido, no arruga el papel',
                    'price' => 17.99,
                    'stock' => 999999,
                    'image' => 'pegamento_barra.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Set 4 tijeras oficina acero inoxidable',
                    'reference' => 'PAP-012',
                    'description' => 'Set de 4 tijeras de oficina en acero inoxidable, mango ergonómico de plástico, diferentes tamaños (13cm, 17cm, 21cm, 25cm)',
                    'price' => 19.99,
                    'stock' => 999999,
                    'image' => 'tijeras_acero.jpg',
                    'is_office_related' => true
                ]
            ],            'Organización' => [
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
                ],
                [
                    'name' => 'Pack 100 carpetas colgantes A4 colores',
                    'reference' => 'ORG-004',
                    'description' => 'Pack de 100 carpetas colgantes A4 en colores surtidos, visor transparente, varillas metálicas, fabricadas en cartón reciclado',
                    'price' => 79.99,
                    'stock' => 999999,
                    'image' => 'carpetas_colgantes.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Sistema archivado modular con cajones',
                    'reference' => 'ORG-005',
                    'description' => 'Sistema de archivo modular con 5 cajones, acceso frontal, capacidad 500 folios por cajón, etiqueteros frontales incluidos',
                    'price' => 129.99,
                    'stock' => 999999,
                    'image' => 'sistema_archivado.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 50 cajas archivo definitivo',
                    'reference' => 'ORG-006',
                    'description' => 'Pack de 50 cajas de archivo definitivo, cartón kraft reciclado resistente, lomo 10cm, sistema de montaje automático',
                    'price' => 59.99,
                    'stock' => 999999,
                    'image' => 'cajas_archivo.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Kit 10 separadores oficina cristal',
                    'reference' => 'ORG-007',
                    'description' => 'Kit de 10 separadores de oficina en cristal templado y soportes de aluminio, modulares, dimensiones 60x40cm por módulo',
                    'price' => 499.99,
                    'stock' => 999999,
                    'image' => 'separadores_cristal.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Organizador cables escritorio pack 20',
                    'reference' => 'ORG-008',
                    'description' => 'Pack de 20 organizadores de cables para escritorio, silicona flexible, autoadhesivos, 5 colores surtidos, capacidad 5 cables cada uno',
                    'price' => 24.99,
                    'stock' => 999999,
                    'image' => 'organizador_cables.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Lote 10 revisteros oficina metálicos',
                    'reference' => 'ORG-009',
                    'description' => 'Lote de 10 revisteros de oficina metálicos para documentos A4, diseño en malla de acero, varios colores disponibles',
                    'price' => 79.99,
                    'stock' => 999999,
                    'image' => 'revisteros_oficina.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Sistema clasificación documentos 24 departamentos',
                    'reference' => 'ORG-010',
                    'description' => 'Sistema de clasificación de documentos con 24 departamentos, estructura modular ampliable, fabricado en PVC, etiquetas incluidas',
                    'price' => 149.99,
                    'stock' => 999999,
                    'image' => 'clasificacion_documentos.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Clasificador acordeón A-Z con cerradura',
                    'reference' => 'ORG-011',
                    'description' => 'Clasificador acordeón con 26 departamentos A-Z, cierre con cerradura, asa para transporte, fabricado en polipropileno reforzado',
                    'price' => 34.99,
                    'stock' => 999999,
                    'image' => 'clasificador_acordeon.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Carrito organizador 3 niveles',
                    'reference' => 'ORG-012',
                    'description' => 'Carrito organizador multifunción con 3 niveles, ruedas silenciosas con freno, estructura metálica, bandejas extraíbles',
                    'price' => 89.99,
                    'stock' => 999999,
                    'image' => 'carrito_organizador.jpg',
                    'is_office_related' => true
                ]
            ],            'Seguridad y salud' => [
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
                ],
                [
                    'name' => 'Sistema alarma incendios inalámbrico',
                    'reference' => 'SEG-004',
                    'description' => 'Sistema de alarma de incendios inalámbrico para oficinas, 5 detectores de humo, 2 pulsadores, central con batería de respaldo',
                    'price' => 349.99,
                    'stock' => 999999,
                    'image' => 'alarma_incendios.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Kit videovigilancia IP 4 cámaras',
                    'reference' => 'SEG-005',
                    'description' => 'Kit de videovigilancia IP con 4 cámaras Full HD, grabador NVR, disco duro 2TB, visión nocturna, acceso remoto desde smartphone',
                    'price' => 499.99,
                    'stock' => 999999,
                    'image' => 'videovigilancia_ip.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Control acceso biométrico huella y tarjeta',
                    'reference' => 'SEG-006',
                    'description' => 'Sistema de control de acceso biométrico con lector de huella digital y tarjetas RFID, hasta 1000 usuarios, registro histórico',
                    'price' => 299.99,
                    'stock' => 999999,
                    'image' => 'control_acceso.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Caja fuerte ignífuga documentos',
                    'reference' => 'SEG-007',
                    'description' => 'Caja fuerte ignífuga para documentos y soportes digitales, cerradura electrónica y llave, protección 1 hora a 927°C',
                    'price' => 499.99,
                    'stock' => 999999,
                    'image' => 'caja_fuerte.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 5 reposapies ergonómicos ajustables',
                    'reference' => 'SEG-008',
                    'description' => 'Pack de 5 reposapies ergonómicos con altura y ángulo ajustable, superficie antideslizante, favorecen postura correcta',
                    'price' => 149.99,
                    'stock' => 999999,
                    'image' => 'reposapies_ergonomicos.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Lote 10 soportes monitor elevables',
                    'reference' => 'SEG-009',
                    'description' => 'Lote de 10 soportes para monitor elevables y ajustables, mejoran postura cervical, con organizador para documentos',
                    'price' => 199.99,
                    'stock' => 999999,
                    'image' => 'soportes_monitor.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Kit destructora documentos oficina',
                    'reference' => 'SEG-010',
                    'description' => 'Destructora de documentos para oficina, corte en partículas 4x38mm (nivel P-4), capacidad 15 hojas, papelera 27L, destruye tarjetas y CDs',
                    'price' => 249.99,
                    'stock' => 999999,
                    'image' => 'destructora_documentos.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Filtros privacidad monitor pack 5 unidades',
                    'reference' => 'SEG-011',
                    'description' => 'Pack de 5 filtros de privacidad para monitores de 24", visibles solo frontalmente, protección luz azul, fácil instalación',
                    'price' => 179.99,
                    'stock' => 999999,
                    'image' => 'filtros_privacidad.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Lámparas emergencia LED pack 6',
                    'reference' => 'SEG-012',
                    'description' => 'Pack de 6 lámparas de emergencia LED, autonomía 3h, 200 lúmenes, batería recargable, interruptor test, certificado CE',
                    'price' => 119.99,
                    'stock' => 999999,
                    'image' => 'lamparas_emergencia.jpg',
                    'is_office_related' => true
                ]            ],            'Electrodomésticos' => [
                [
                    'name' => 'Cafetera profesional de cápsulas',
                    'reference' => 'ELDO-001',
                    'description' => 'Cafetera profesional de cápsulas con depósito de agua 1.8L, 5 tamaños de taza, calentamiento rápido, apagado automático',
                    'price' => 249.99,
                    'stock' => 999999,
                    'image' => 'cafetera_profesional.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Microondas digital multifunción 28L',
                    'reference' => 'ELDO-002',
                    'description' => 'Microondas profesional con función horno y grill, capacidad 28L, 900W, distribución uniforme del calor, interior antibacteriano',
                    'price' => 189.99,
                    'stock' => 999999,
                    'image' => 'microondas_digital.jpg',
                    'is_office_related' => true
                ],
                [                    'name' => 'Dispensador de agua fría y caliente',
                    'reference' => 'ELDO-003',
                    'description' => 'Dispensador de agua con conexión a red, filtración avanzada, tecnología antimicrobiana, agua fría, ambiente y caliente',
                    'price' => 599.99,
                    'stock' => 999999,
                    'image' => 'dispensador_agua.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Nevera office compacta 85L',
                    'reference' => 'ELDO-004',
                    'description' => 'Nevera compacta para oficina, capacidad 85L, eficiencia energética A++, silenciosa (<40dB), estantes regulables en altura',
                    'price' => 199.99,
                    'stock' => 999999,
                    'image' => 'nevera_compacta.jpg',
                    'is_office_related' => true
                ],
                [                    'name' => 'Purificador aire HEPA oficina grande',
                    'reference' => 'ELDO-005',
                    'description' => 'Purificador de aire con filtro HEPA H13 para oficinas hasta 100m², indicador calidad aire, modo silencioso, programable',
                    'price' => 349.99,
                    'stock' => 999999,
                    'image' => 'purificador_hepa.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Lámpara escritorio LED regulable',
                    'reference' => 'ELDO-006',
                    'description' => 'Lámpara de escritorio LED con brillo y temperatura de color regulable, puerto USB integrado, temporizador, memoria de configuración',
                    'price' => 89.99,
                    'stock' => 999999,
                    'image' => 'lampara_escritorio.jpg',
                    'is_office_related' => true
                ],
                [                    'name' => 'Ventilador torre silencioso oficina',
                    'reference' => 'ELDO-007',
                    'description' => 'Ventilador de torre silencioso para oficina, 3 velocidades, oscilación 80º, temporizador 8h, mando a distancia, filtro antipolvo',
                    'price' => 119.99,
                    'stock' => 999999,
                    'image' => 'ventilador_torre.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Sistema audio bluetooth conference',
                    'reference' => 'ELDO-008',
                    'description' => 'Sistema de audio bluetooth para salas de conferencias, altavoces 360º, micrófonos omnidireccionales, cancelación eco y ruido',
                    'price' => 449.99,
                    'stock' => 999999,
                    'image' => 'audio_conference.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Calentador agua instantáneo office',
                    'reference' => 'ELECT-009',
                    'description' => 'Calentador de agua instantáneo para oficina, 2500W, capacidad 5L, temperatura regulable, display digital, autoapagado',
                    'price' => 79.99,
                    'stock' => 999999,
                    'image' => 'calentador_agua.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Aspirador sin cable vertical',
                    'reference' => 'ELECT-010',
                    'description' => 'Aspirador sin cable vertical para oficinas, batería 40 minutos, filtro HEPA, accesorios para diferentes superficies',
                    'price' => 199.99,
                    'stock' => 999999,
                    'image' => 'aspirador_vertical.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Trituradora hielo eléctrica bar',
                    'reference' => 'ELECT-011',
                    'description' => 'Trituradora de hielo eléctrica para office/bar, capacidad 12kg/h, depósito transparente, operación silenciosa',
                    'price' => 159.99,
                    'stock' => 999999,
                    'image' => 'trituradora_hielo.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Tostadora profesional 4 ranuras',
                    'reference' => 'ELECT-012',
                    'description' => 'Tostadora profesional de 4 ranuras extra anchas, 7 niveles de tostado, funciones descongelación y recalentamiento',
                    'price' => 89.99,
                    'stock' => 999999,
                    'image' => 'tostadora_profesional.jpg',
                    'is_office_related' => true
                ]
            ],            'Redes y comunicación' => [
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
                ],
                [
                    'name' => 'Access Point WiFi 6 profesional',
                    'reference' => 'NET-004',
                    'description' => 'Access Point WiFi 6 (802.11ax) profesional, MU-MIMO 4x4, hasta 300 clientes simultáneos, PoE+, gestión centralizada',
                    'price' => 349.99,
                    'stock' => 999999,
                    'image' => 'access_point.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Firewall hardware con VPN y filtrado',
                    'reference' => 'NET-005',
                    'description' => 'Firewall hardware con VPN SSL/IPSec, filtrado de contenido, antivirus integrado, IPS/IDS, balanceo de carga WAN',
                    'price' => 999.99,
                    'stock' => 999999,
                    'image' => 'firewall_hardware.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'NAS empresarial 8 bahías rack',
                    'reference' => 'NET-006',
                    'description' => 'NAS empresarial formato rack 2U, 8 bahías hot-swap, procesador Xeon, 16GB RAM ECC, redundancia fuente alimentación',
                    'price' => 1999.99,
                    'stock' => 999999,
                    'image' => 'nas_empresarial.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Kit 5 adaptadores Powerline 2000Mbps',
                    'reference' => 'NET-007',
                    'description' => 'Kit de 5 adaptadores Powerline AV2000 con punto de acceso WiFi integrado, puerto Gigabit, encriptación 128 bits',
                    'price' => 299.99,
                    'stock' => 999999,
                    'image' => 'adaptadores_powerline.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Armario Rack 19" 42U con ventilación',
                    'reference' => 'NET-008',
                    'description' => 'Armario Rack 19" 42U con puerta delantera de cristal, ventilación forzada, 4 ruedas, 800x1000mm, carga hasta 800kg',
                    'price' => 1299.99,
                    'stock' => 999999,
                    'image' => 'armario_rack.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Regleta rack 8 tomas con protección',
                    'reference' => 'NET-009',
                    'description' => 'Regleta para rack 19" con 8 tomas Schuko, protección sobretensión, interruptor, cable 3m, 16A, montaje horizontal',
                    'price' => 69.99,
                    'stock' => 999999,
                    'image' => 'regleta_rack.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Sistema KVM 8 puertos con cables',
                    'reference' => 'NET-010',
                    'description' => 'Sistema KVM de 8 puertos con rack mount 1U, cables USB/HDMI incluidos, función autoscan, soporte resolución 4K',
                    'price' => 499.99,
                    'stock' => 999999,
                    'image' => 'sistema_kvm.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Pack 5 discos duros NAS 8TB',
                    'reference' => 'NET-011',
                    'description' => 'Pack de 5 discos duros especiales para NAS, 8TB cada uno, 7200rpm, CMR, optimizados para funcionamiento 24/7',
                    'price' => 1499.99,
                    'stock' => 999999,
                    'image' => 'discos_nas.jpg',
                    'is_office_related' => true
                ],
                [
                    'name' => 'Panel parcheo 48 puertos Cat6 apantallado',
                    'reference' => 'NET-012',
                    'description' => 'Panel de parcheo 48 puertos Cat6 FTP apantallado, 1U, organizador cables trasero, terminación IDC, compatible PoE+',
                    'price' => 189.99,
                    'stock' => 999999,
                    'image' => 'panel_parcheo.jpg',
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
                ],
                [
                    'name' => 'Caja 50 cápsulas café compatible',
                    'reference' => 'ALIM-003',
                    'description' => 'Pack de 50 cápsulas de café premium compatibles, mezcla arábica y robusta, tostado medio, intensidad 7/10, notas aromáticas',
                    'price' => 19.99,
                    'stock' => 999999,
                    'image' => 'capsulas_cafe.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Selección de tés premium 60 sobres',
                    'reference' => 'ALIM-004',
                    'description' => 'Selección de 60 sobres de té premium (verde, negro, rojo, infusiones), pirámides biodegradables, calidad superior',
                    'price' => 29.99,
                    'stock' => 999999,
                    'image' => 'seleccion_tes.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Caja 100 sobres azúcar individual',
                    'reference' => 'ALIM-005',
                    'description' => 'Caja con 100 sobres individuales de azúcar blanco refinado de 8g, calidad extra, ideal para café y té',
                    'price' => 5.99,
                    'stock' => 999999,
                    'image' => 'azucar_sobres.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Lote 50 barritas energéticas variadas',
                    'reference' => 'ALIM-006',
                    'description' => 'Surtido de 50 barritas energéticas proteicas de diferentes sabores, ideales como snack saludable entre horas',
                    'price' => 45.99,
                    'stock' => 999999,
                    'image' => 'barritas_energeticas.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Pack 24 refrescos variados 33cl',
                    'reference' => 'ALIM-007',
                    'description' => 'Surtido de 24 latas de refrescos variados (cola, naranja, limón) en formato de 33cl, para office y reuniones',
                    'price' => 18.99,
                    'stock' => 999999,
                    'image' => 'refrescos_variados.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Cesta gourmet productos delicatessen',
                    'reference' => 'ALIM-008',
                    'description' => 'Cesta regalo con selección de 15 productos gourmet: aceites, conservas, chocolates, vinos y embutidos de primera calidad',
                    'price' => 89.99,
                    'stock' => 999999,
                    'image' => 'cesta_gourmet.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Lote 48 chocolatinas surtidas',
                    'reference' => 'ALIM-009',
                    'description' => 'Pack de 48 chocolatinas individuales surtidas de primeras marcas, perfectas para áreas de descanso y breaks',
                    'price' => 32.99,
                    'stock' => 999999,
                    'image' => 'chocolatinas_surtidas.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Mix frutos secos premium 5kg',
                    'reference' => 'ALIM-010',
                    'description' => 'Mezcla premium de frutos secos seleccionados: almendras, pistachos, anacardos, nueces y avellanas, formato 5kg para empresas',
                    'price' => 69.99,
                    'stock' => 999999,
                    'image' => 'frutos_secos.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Lote 100 galletas individuales',
                    'reference' => 'ALIM-011',
                    'description' => 'Pack de 100 galletas individuales variadas, perfectas para acompañar café o té en meetings y recepciones',
                    'price' => 27.99,
                    'stock' => 999999,
                    'image' => 'galletas_individuales.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Aceite de oliva virgen extra 5L',
                    'reference' => 'ALIM-012',
                    'description' => 'Aceite de oliva virgen extra de primera presión en frío, cosecha temprana, acidez <0,4%, formato 5 litros',
                    'price' => 39.99,
                    'stock' => 999999,
                    'image' => 'aceite_oliva.jpg',
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
                ],
                [
                    'name' => 'Cafetera italiana aluminio 12 tazas',
                    'reference' => 'HOG-003',
                    'description' => 'Cafetera italiana de aluminio para 12 tazas, válvula de seguridad, mango ergonómico resistente al calor, apta para todo tipo de cocinas',
                    'price' => 29.99,
                    'stock' => 999999,
                    'image' => 'cafetera_italiana.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Juego 6 vasos cristal premium',
                    'reference' => 'HOG-004',
                    'description' => 'Set de 6 vasos de cristal premium sin plomo, capacidad 350ml, diseño elegante, aptos para lavavajillas, base reforzada',
                    'price' => 24.99,
                    'stock' => 999999,
                    'image' => 'vasos_cristal.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Alfombra salón pelo corto 160x230cm',
                    'reference' => 'HOG-005',
                    'description' => 'Alfombra de salón moderna con pelo corto, dimensiones 160x230cm, antideslizante, antimanchas, fácil limpieza',
                    'price' => 129.99,
                    'stock' => 999999,
                    'image' => 'alfombra_salon.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Juego de sábanas algodón egipcio',
                    'reference' => 'HOG-006',
                    'description' => 'Juego completo de sábanas 100% algodón egipcio 300 hilos, incluye sábana encimera, bajera y dos fundas de almohada',
                    'price' => 79.99,
                    'stock' => 999999,
                    'image' => 'sabanas_algodon.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Set 4 plantas artificiales decorativas',
                    'reference' => 'HOG-007',
                    'description' => 'Conjunto de 4 plantas artificiales decorativas con macetas incluidas, aspecto natural, perfectas para decorar sin mantenimiento',
                    'price' => 44.99,
                    'stock' => 999999,
                    'image' => 'plantas_artificiales.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Cortina opaca térmica 140x250cm',
                    'reference' => 'HOG-008',
                    'description' => 'Cortina opaca con propiedades térmicas y acústicas, dimensiones 140x250cm, tejido poliéster de alta densidad, con ollaos',
                    'price' => 39.99,
                    'stock' => 999999,
                    'image' => 'cortina_opaca.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Batería de cocina 12 piezas acero inox',
                    'reference' => 'HOG-009',
                    'description' => 'Set completo de 12 piezas de cocina en acero inoxidable 18/10, apto para todo tipo de cocinas incluida inducción',
                    'price' => 159.99,
                    'stock' => 999999,
                    'image' => 'bateria_cocina.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Juego 3 cuadros decorativos modernos',
                    'reference' => 'HOG-010',
                    'description' => 'Conjunto de 3 cuadros decorativos con diseños abstractos modernos, marco de aluminio, listos para colgar',
                    'price' => 69.99,
                    'stock' => 999999,
                    'image' => 'cuadros_decorativos.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Manta polar extra suave 220x240cm',
                    'reference' => 'HOG-011',
                    'description' => 'Manta polar de microfibra extra suave, tamaño 220x240cm, antiestática, no suelta pelo, resistente a lavados',
                    'price' => 34.99,
                    'stock' => 999999,
                    'image' => 'manta_polar.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Cubertería 24 piezas acero inox 18/10',
                    'reference' => 'HOG-012',
                    'description' => 'Set completo de cubertería para 6 comensales (24 piezas) en acero inoxidable 18/10, acabado pulido espejo, apto para lavavajillas',
                    'price' => 79.99,
                    'stock' => 999999,
                    'image' => 'cuberteria_acero.jpg',
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
                ],
                [
                    'name' => 'Altavoz Bluetooth portátil resistente agua',
                    'reference' => 'ELEC-003',
                    'description' => 'Altavoz portátil Bluetooth 5.0, resistente al agua IPX7, batería de 20h, graves potentes, micrófono integrado para llamadas',
                    'price' => 89.99,
                    'stock' => 999999,
                    'image' => 'altavoz_bluetooth.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Tableta Android 10.5" 128GB',
                    'reference' => 'ELEC-004',
                    'description' => 'Tableta Android con pantalla 10.5" QHD, procesador octa-core, 6GB RAM, 128GB almacenamiento, batería 7000mAh, cámara 13MP',
                    'price' => 349.99,
                    'stock' => 999999,
                    'image' => 'tableta_android.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Cámara de acción 4K resistente agua',
                    'reference' => 'ELEC-005',
                    'description' => 'Cámara deportiva 4K/60fps, sumergible 40m, estabilizador de imagen, WiFi, control por voz, batería intercambiable',
                    'price' => 199.99,
                    'stock' => 999999,
                    'image' => 'camara_accion.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Powerbank 20000mAh carga rápida',
                    'reference' => 'ELEC-006',
                    'description' => 'Batería externa 20000mAh con carga rápida 22.5W, 2 puertos USB-A, 1 USB-C, carga simultánea de 3 dispositivos',
                    'price' => 39.99,
                    'stock' => 999999,
                    'image' => 'powerbank_carga_rapida.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Reproductor MP3 32GB con Bluetooth',
                    'reference' => 'ELEC-007',
                    'description' => 'Reproductor MP3 con 32GB capacidad, Bluetooth 5.0, radio FM, grabación de voz, reproducción 60h, pantalla táctil',
                    'price' => 59.99,
                    'stock' => 999999,
                    'image' => 'reproductor_mp3.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Kit cargadores inalámbricos triple',
                    'reference' => 'ELEC-008',
                    'description' => 'Set de 3 cargadores inalámbricos Qi de 15W para smartphone, reloj inteligente y auriculares, compatible con múltiples dispositivos',
                    'price' => 79.99,
                    'stock' => 999999,
                    'image' => 'cargadores_inalambricos.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'TV Smart LED 55" UHD 4K',
                    'reference' => 'ELEC-009',
                    'description' => 'Televisor Smart LED 55" Ultra HD 4K, HDR10, Dolby Vision, sistema operativo Android TV, Chromecast integrado',
                    'price' => 599.99,
                    'stock' => 999999,
                    'image' => 'tv_smart_led.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Sistema de sonido 5.1 home cinema',
                    'reference' => 'ELEC-010',
                    'description' => 'Sistema de audio home cinema 5.1 con subwoofer inalámbrico, 1000W potencia total, Bluetooth, HDMI ARC, USB, óptico',
                    'price' => 499.99,
                    'stock' => 999999,
                    'image' => 'sistema_sonido.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Dron con cámara 4K plegable',
                    'reference' => 'ELEC-011',
                    'description' => 'Dron plegable con cámara 4K estabilizada, autonomía 30 minutos, alcance 8km, evitación de obstáculos, modos de vuelo inteligentes',
                    'price' => 799.99,
                    'stock' => 999999,
                    'image' => 'dron_camara.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Consola videojuegos última generación',
                    'reference' => 'ELEC-012',
                    'description' => 'Consola de videojuegos última generación con 1TB almacenamiento, resolución 4K, raytracing, incluye mando inalámbrico',
                    'price' => 499.99,
                    'stock' => 999999,
                    'image' => 'consola_videojuegos.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Lector de libros electrónicos 32GB',
                    'reference' => 'ELEC-013',
                    'description' => 'E-reader con pantalla de 7" sin reflejos, 32GB de almacenamiento, luz integrada regulable, resistente al agua IPX8',
                    'price' => 129.99,
                    'stock' => 999999,
                    'image' => 'lector_electronico.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Proyector Full HD WiFi portátil',
                    'reference' => 'ELEC-014',
                    'description' => 'Proyector LED Full HD 1080p, WiFi, Bluetooth, 6000 lúmenes, ratio contraste 10000:1, altavoces integrados',
                    'price' => 299.99,
                    'stock' => 999999,
                    'image' => 'proyector_fullhd.jpg',
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
                ],
                [
                    'name' => 'Camisa business slim fit no plancha',
                    'reference' => 'ROPA-003',
                    'description' => 'Camisa business slim fit, 100% algodón egipcio, tratamiento no necesita plancha, cuello semiformal, puños simples',
                    'price' => 59.99,
                    'stock' => 999999,
                    'image' => 'camisa_business.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Americana blazer lana fría azul',
                    'reference' => 'ROPA-004',
                    'description' => 'Americana blazer en lana fría super 120s, azul marino, corte slim fit, botones metálicos, 2 aberturas traseras',
                    'price' => 249.99,
                    'stock' => 999999,
                    'image' => 'blazer_azul.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Cinturón piel vacuno reversible',
                    'reference' => 'ROPA-005',
                    'description' => 'Cinturón reversible negro/marrón en piel de vacuno con hebilla giratoria, ancho 3,5cm, largo ajustable 110-130cm',
                    'price' => 45.99,
                    'stock' => 999999,
                    'image' => 'cinturon_reversible.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Maletín ejecutivo piel premium',
                    'reference' => 'ROPA-006',
                    'description' => 'Maletín ejecutivo en piel premium con multiples compartimentos, refuerzo interior, asas y bandolera ajustable, cierre seguridad',
                    'price' => 199.99,
                    'stock' => 999999,
                    'image' => 'maletin_ejecutivo.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Zapatos oxford piel negro',
                    'reference' => 'ROPA-007',
                    'description' => 'Zapatos oxford en piel de primera calidad color negro, suela de cuero, plantilla acolchada, forro transpirable',
                    'price' => 129.99,
                    'stock' => 999999,
                    'image' => 'zapatos_oxford.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Vestido cocktail corte recto',
                    'reference' => 'ROPA-008',
                    'description' => 'Vestido cocktail corte recto en poliéster elástico, largo hasta la rodilla, manga 3/4, escote redondo, forro interior',
                    'price' => 119.99,
                    'stock' => 999999,
                    'image' => 'vestido_cocktail.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Gemelos acero inoxidable diseño clásico',
                    'reference' => 'ROPA-009',
                    'description' => 'Gemelos en acero inoxidable pulido con diseño clásico atemporal, sistema de cierre fácil, presentados en caja de regalo',
                    'price' => 34.99,
                    'stock' => 999999,
                    'image' => 'gemelos_acero.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Pañuelo bolsillo seda natural',
                    'reference' => 'ROPA-010',
                    'description' => 'Pañuelo de bolsillo en seda natural 100% con acabados a mano, diseños variados, medidas 33x33cm',
                    'price' => 29.99,
                    'stock' => 999999,
                    'image' => 'panuelo_seda.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Falda tubo lana elastizada',
                    'reference' => 'ROPA-011',
                    'description' => 'Falda de tubo en lana elastizada, largo por la rodilla, abertura trasera, forro interior, cinturilla reforzada',
                    'price' => 79.99,
                    'stock' => 999999,
                    'image' => 'falda_tubo.jpg',
                    'is_office_related' => false
                ],
                [
                    'name' => 'Bolso shopper piel premium',
                    'reference' => 'ROPA-012',
                    'description' => 'Bolso shopper en piel premium, interior forrado con múltiples bolsillos, cierre con cremallera, asas reforzadas',
                    'price' => 149.99,
                    'stock' => 999999,
                    'image' => 'bolso_shopper.jpg',
                    'is_office_related' => false
                ]
            ]
        ];        // Asignar productos a los mayoristas según su categoría, aplicando multiplicador aleatorio al precio
        $allProducts = $officeProducts + $generalProducts;

        foreach ($allProducts as $categoryLabel => $products) {
            // Obtener la categoría
            $category = ProductCategory::where('label', $categoryLabel)->first();
            
            if ($category) {
                // Encontrar mayoristas que tengan esta categoría específicamente asignada
                $wholesalers = Wholesaler::whereHas('categories', function($query) use ($category) {
                    $query->where('product_categories.id', $category->id);
                })->get();
                
                // Solo asignar productos si hay mayoristas específicos para esta categoría
                if (!$wholesalers->isEmpty()) {
                    // Asignar productos a los mayoristas con multiplicador aleatorio de precios
                    // Procesamos cada mayorista una sola vez para cada categoría
                    foreach ($wholesalers as $wholesaler) {
                        foreach ($products as $product) {
                            // Aplicar multiplicador aleatorio entre 0.9 y 1.10 para ventaja competitiva
                            $priceMultiplier = mt_rand(90, 110) / 100;
                            $product['price'] = round($product['price'] * $priceMultiplier, 2);
                            
                            $product['wholesaler_id'] = $wholesaler->id;
                            $product['category_id'] = $category->id;
                              // Verificar si ya existe un producto con esta referencia para este mayorista
                            $existingProduct = WholesalerProduct::where('wholesaler_id', $wholesaler->id)
                                ->where('reference', $product['reference'])
                                ->first();
                                
                            if (!$existingProduct) {
                                WholesalerProduct::create($product);
                            }
                        }
                    }
                }
            }
        }
    }
}