<?php
require '../mpdf-development/PHPMailerAutoloadautoload.php'; // Carga el autoload de Composer

use Mpdf\Mpdf;

function generarPDF($contenidoHTML, $nombreArchivo = 'archivo.pdf') {
    // Crea una instancia de MPDF
    $mpdf = new Mpdf();

    // Establece las opciones del documento PDF, como tamaño y orientación
    $mpdf->SetImportUse(); 

    // Lee el contenido HTML y lo convierte en un documento PDF
    $mpdf->WriteHTML($contenidoHTML);

    // Guarda el PDF en el servidor o lo envía al navegador para su descarga
    $mpdf->Output($nombreArchivo, 'D'); // Cambia 'D' a 'F' si deseas guardar el archivo en el servidor
}

// Ejemplo de uso:
$contenidoHTML = "<html><body><h1>Hola, mundo!</h1><p>Este es un ejemplo de contenido HTML convertido a PDF.</p></body></html>";
generarPDF($contenidoHTML);
?>
