<?php
// Script de prueba para generar un PDF
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

// Generar un PDF simple
try {
    $pdf = Pdf::loadHTML('<h1>Test de PDF</h1><p>Esta es una prueba para verificar la generación de PDF</p>');
    
    // Verificar si el directorio existe
    $directory = 'public/delivery_notes';
    if (!Storage::exists($directory)) {
        Storage::makeDirectory($directory);
        echo "Directorio creado: $directory\n";
    } else {
        echo "El directorio ya existe: $directory\n";
    }
    
    // Guardar el PDF
    $pdfFileName = 'test_pdf_' . time() . '.pdf';
    $pdfPath = 'delivery_notes/' . $pdfFileName;
    if (Storage::put('public/' . $pdfPath, $pdf->output())) {
        echo "PDF guardado correctamente en: storage/app/public/$pdfPath\n";
        
        // Verificar si el archivo existe
        if (Storage::exists('public/' . $pdfPath)) {
            echo "Verificado: el archivo existe\n";
            echo "Tamaño del archivo: " . Storage::size('public/' . $pdfPath) . " bytes\n";
        } else {
            echo "Error: el archivo no existe después de guardarlo\n";
        }
    } else {
        echo "Error al guardar el PDF\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
    echo "Traza:\n" . $e->getTraceAsString() . "\n";
}
