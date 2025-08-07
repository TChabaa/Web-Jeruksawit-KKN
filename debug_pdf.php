<?php
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;

try {
    echo "Testing DomPDF installation...\n";

    $dompdf = new Dompdf();
    $html = '<h1>Test PDF</h1><p>If you see this, DomPDF is working correctly.</p>';
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $fileName = 'test_pdf_' . time() . '.pdf';
    $filePath = __DIR__ . '/storage/app/temp/' . $fileName;

    // Create directory if it doesn't exist
    if (!file_exists(dirname($filePath))) {
        mkdir(dirname($filePath), 0755, true);
    }

    file_put_contents($filePath, $dompdf->output());

    if (file_exists($filePath)) {
        echo "SUCCESS: PDF created at $filePath\n";
        echo "File size: " . filesize($filePath) . " bytes\n";
    } else {
        echo "ERROR: PDF file was not created\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
