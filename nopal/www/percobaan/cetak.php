<?php
require('library/fpdf.php');
require 'connect.php';

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Times','B',13);
$pdf->cell(200,10,'Data Barang', 0,0,'C');
$pdf->cell(10,15,'',0,1);
$pdf->SetFont('Times','B',10);
$pdf->cell(10,7,'No', 1,0,'C');
$pdf->cell(50,7,'Kode', 1,0,'C');
$pdf->cell(75,7,'Barang', 1,0,'C');
$pdf->cell(55,7,'Harga', 1,0,'C');
$pdf->cell(10,7,'',0,1);
$pdf->SetFont('Times','',10);
$data = mysqli_query($connect, "SELECT * FROM autocode");
foreach ($data as $key =>$value){
    $pdf->cell(10, 6,$key + 1,1,0,'C');
    $pdf->cell(50, 6,$value['kode'], 1,0);
    $pdf->cell(75, 6,$value['nama_barang'], 1,0);
    $pdf->cell(55, 6,$value['harga'], 1,1);
}
$pdf->Output();
?>
