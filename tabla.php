<?php
require('./fpdf186/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('img.jpg', 10, 10, 30);
        $this->SetTextColor(0, 0, 255); // Establece el color del texto a azul
        // Establece el título del documento
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 10, 'Reporte de Clientes', 0, 1, 'C');
        $this->Ln(20); // Agrega un salto de línea
        $this->SetTextColor(0, 0, 0); // Restablece el color del texto a negro
    }

    function Reporte()
    {
        $w = array(15, 30, 30, 35, 40, 20, 40, 45, 20); // Ajusta el ancho de las columnas

        $hostDB = 'localhost';
        $nombreDB = 'ejemplo';
        $usuarioDB = 'root';
        $contrasenaDB = '';
        $hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
        $miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
        $miconsulta = $miPDO->prepare('SELECT * FROM Clientes;');
        $miconsulta->execute();

        $this->SetFont('Arial', '', 10);

        // Cabecera de la tabla
        $this->SetFillColor(0, 200, 200); // Establece el color de fondo de la cabecera
        $this->Cell($w[0], 5, "id", 'LRBT', 0, 'C', true);
        $this->Cell($w[1], 5, utf8_decode("tipo_documento"), 'LRBT', 0, 'C', true); // Decodifica el texto a utf-8
        $this->Cell($w[2], 5, utf8_decode("numero_documento"), 'LRBT', 0, 'C', true);
        $this->Cell($w[3], 5, utf8_decode("nombre_completo"), 'LRBT', 0, 'C', true);
        $this->Cell($w[4], 5, utf8_decode("direccion"), 'LRBT', 0, 'C', true);
        $this->Cell($w[5], 5, utf8_decode("telefono"), 'LRBT', 0, 'C', true);
        $this->Cell($w[6], 5, utf8_decode("email"), 'LRBT', 0, 'C', true);
        $this->Cell($w[7], 5, utf8_decode("fecha_nacimiento_creacion"), 'LRBT', 0, 'C', true);
        $this->Cell($w[8], 5, utf8_decode("estado"), 'LRBT', 0, 'C', true);
        $this->Ln();

        // Contenido de la tabla
        foreach ($miconsulta as $Fila):
            $this->Cell($w[0], 5, $Fila[0], 'LRBT', 0, 'C');
            $this->Cell($w[1], 5, utf8_decode($Fila[1]), 'LRBT', 0, 'C'); // Decodifica el texto a utf-8
            $this->Cell($w[2], 5, utf8_decode($Fila[2]), 'LRBT', 0, 'C');
            $this->Cell($w[3], 5, utf8_decode($Fila[3]), 'LRBT', 0, 'C');
            $this->Cell($w[4], 5, utf8_decode($Fila[4]), 'LRBT', 0, 'C');
            $this->Cell($w[5], 5, utf8_decode($Fila[5]), 'LRBT', 0, 'C');
            $this->Cell($w[6], 5, utf8_decode($Fila[6]), 'LRBT', 0, 'C');
            $this->Cell($w[7], 5, utf8_decode($Fila[7]), 'LRBT', 0, 'C');
            $this->Cell($w[8], 5, utf8_decode($Fila[8]), 'LRBT', 0, 'C');
            $this->Ln();
        endforeach;

        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L'); // Cambia la orientación de la página a horizontal (opcional)
$pdf->Reporte();
$pdf->Output();
?>
