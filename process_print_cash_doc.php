<?php
include "connection.php";
include ('fpdf/fpdf.php');
require 'class.phpmailer.php'; // path to the PHPMailer class
require 'class.smtp.php';
if(isset($_GET['cash_id'])){
  if($_GET['cash_id'] != ''){
    $cash_id = base64_decode($_GET['cash_id']);
    $filename = trim(base64_decode($_GET['filename']));
    $query = "SELECT * FROM cash_request WHERE id = '".$cash_id."'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)> 0){
        while($row = mysqli_fetch_assoc($result)) {
          $cash[] = $row;
        }
    }
  }
}
$dest = 'cash_request/'.$filename.'.pdf';
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image('images/doc.png', -15, 0, 100, 100);
$pdf->Ln(30);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'March 22, 2019',0,1);
$pdf->Ln(10);
$pdf->SetFont('Times','B',12);
$pdf->Cell(0,10,'Francis Ukute',0,1);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Polaris Bank Limited',0,1);
$pdf->Cell(0,10,'Ogba',0,1);
$pdf->Ln(20);
$pdf->Cell(0,10,'Dear Francis,',0,1);
$pdf->Ln(5);
$pdf->SetFont('Times','BU',12);
$pdf->Cell(0,10,'Confirmation of Leave Application',0,1);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'We received your leave request which has already been approved by your unit head/branch manager.',0,1);
$pdf->Cell(0,10,'Therefore, you are to proceed on your causal Leave effective March 28, 2019 and expected to resume' ,0,1); 
$pdf->SetFont('Arial','',10);
$boldCell = "on ";
$pdf->Cell($pdf->GetStringWidth($boldCell),3,$boldCell, 0, 'L');


$pdf->SetFont('Times','B',12);
$cell = 'April 22, 2019.';
$pdf->Cell($pdf->GetStringWidth($cell),3,$cell, 0, 'L');


$pdf->Ln(5);



$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Thank you',0,1);
$pdf->Ln(5);

$pdf->Cell(0,10,'Yours Faithfully,',0,1);
$boldCell = "For: ";
$pdf->Cell($pdf->GetStringWidth($boldCell),3,$boldCell, 0, 'L');


$pdf->SetFont('Times','B',12);
$cell = 'ICS Outsourcing Limited';
$pdf->Cell($pdf->GetStringWidth($cell),3,$cell, 0, 'L');

$pdf->Output('F', $dest);
header("Location: /outsourcing/downloadpdf.php/?file=cash_request&filename=".$filename.".pdf")
?>