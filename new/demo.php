<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//require('fpdf/fpdf.php');
$conn = mysqli_connect('localhost', 'root', '', 'demodb');
//$query = 'SELECT * FROM ai_students';

//$result = mysqli_query($conn, $query);

require('fpdf/fpdf.php');

// Connect to database...

// Define your columns like so:
$columns = array(array("name" => "id",             "width" => 10),
                 array("name" => "full_name",           "width" => 30),
                 array("name" => "email", "width" => 20));

$pdf = new FPDF();
$pdf->AddPage();

// Table header
$pdf->SetFillColor(232, 232, 232);
$pdf->SetFont('Arial', 'B', 8);
foreach ($columns as $column)
{
    $pdf->Cell($column['width'], 6, strtoupper($column['name']), 1, 0, 'L', 1);
}
$pdf->Ln();

// Table rows
$pdf->SetFont('Arial', '', 8);
$result = mysqli_query($conn, "SELECT id, full_name, email FROM ai_students");
while ($row = mysqli_fetch_assoc($result))
{
    foreach ($columns as $column)
    {
        //$pdf->Cell($column['width'], 6, $row[$column['full_name']], 1);
        $pdf->Cell($column['width'], 6, $row['full_name'], 1);
    }
    //$pdf->Ln();
}
$pdf->Ln();

// Clean up
mysqli_free_result($result);
mysqli_close($conn);
ob_start();
$pdf->Output();

?>