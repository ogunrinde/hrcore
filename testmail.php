<?php
include "connection.php";
include ('fpdf/fpdf.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
session_start();
require 'class.phpmailer.php'; // path to the PHPMailer class
require 'class.smtp.php';
$pdf_name = 'leave_request'.time().'.pdf';
$dest = 'leave_request/'.$pdf_name;
$start_month = '';
$start_year = '';
$start_day = '';
$end_month = '';
$end_year = '';
$end_day = '';
$company = [];
$approvals_name = [];
$approvals = [];
$_SESSION['leave_id'] = '21';
/*if(!isset($_GET['leave_id'])){
  header("Location: view_leave_flow");
  return false;
}*/

 $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September', 'October', 'November', 'December'];
$query = "SELECT * FROM leaves WHERE id = '".$_SESSION['leave_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $leaves[] = $row;
        $t =  (int)(trim(explode('-',$row['start_date'])[1]));
         $start_month = $month[$t-1];
         $start_year = explode('-',$row['start_date'])[0];
         $start_day = explode('-',$row['start_date'])[2];
         $end_month = $month[$t-1];
         $end_year = explode('-',$row['end_date'])[0];
         $end_day = explode('-',$row['end_date'])[2];
      }
  }
  if($_SESSION['user']['category'] == 'admin' && count($leaves) > 0){
    $query = "SELECT * FROM users WHERE id = '".$leaves[0]['staff_id']."'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)> 0){
        while($row = mysqli_fetch_assoc($result)) {
          $user[] = $row;
        }
    }
  }else if($_SESSION['user']['leave_processing_permission'] == '1' && count($leaves) > 0){
    $query = "SELECT * FROM users WHERE id = '".$leaves[0]['staff_id']."'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)> 0){
        while($row = mysqli_fetch_assoc($result)) {
          $user[] = $row;
        }
    }
  }else {
    $user[0]['name'] = '';
    $user[0]['employee_ID'] = '';
  }
  if($_SESSION['user']['category'] == 'staff' && $_SESSION['user']['leave_processing_permission'] == '1') $admin_id = $_SESSION['user']['admin_id'];
  else if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT * FROM company WHERE admin_id = '".$admin_id."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $company[] = $row;
      }
  }
  //print_r($start_day);
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image('images/header.jpg', 0, 0, 210, 297);
$pdf->Ln(40);
$pdf->SetFont('Times','',12);
$date_now = $month[(int)date('m')].' '.date('d').' '.date('Y');
$pdf->Cell(0,10,$date_now,0,1);
$pdf->Ln(5);
$pdf->SetFont('Times','',12);
$name = isset($user[0]['name']) ? $user[0]['fname'].' '.$user[0]['name'] : '';
$user_company = isset($user[0]['user_company']) ? $user[0]['user_company'] : '';
$address = isset($user[0]['address']) ? $user[0]['address'] : '';
$pdf->Cell(0,10,$name,0,1);
$pdf->Cell(0,10,$user_company,0,1);
$pdf->Cell(0,10,$address,0,1);
$pdf->Ln(10);
$salute = isset($user[0]['name']) ? 'Dear '.$user[0]['fname'].',' : 'Dear,';
$pdf->Cell(0,10,$salute,0,1);
$pdf->Ln(5);

$pdf->SetFont('Times','BU',12);
$pdf->Cell(0,10,'Confirmation of Leave Application',0,1);
$pdf->SetFont('Times','',12);
$leave_type = isset($leaves[0]['leave_type']) ? $leaves[0]['leave_type'] : '';
$pdf->Cell(0,10,'We received your leave request which has already been approved by your unit head/branch manager.',0,1);
$pdf->SetFont('Times','',12);
$cell = 'Therefore, you are to proceed on your ';
$pdf->Cell($pdf->GetStringWidth($cell),3,$cell, 0, 'L');

$pdf->SetFont('Times','B',12);
$cell = $leave_type.' ';
$pdf->Cell($pdf->GetStringWidth($cell),3, $cell, 0, 'L');

$pdf->SetFont('Times','',12);
$cell = 'Leave effective ';
$pdf->Cell($pdf->GetStringWidth($cell),3, $cell, 0, 'L');

$pdf->SetFont('Times','B',12);
$cell = ''.$start_month.' '.$start_day.', '.$start_year.' ';
$pdf->Cell($pdf->GetStringWidth($cell),3, $cell, 0, 'L');

$pdf->SetFont('Times','',12);
$cell = 'and expected to resume';
$pdf->Cell($pdf->GetStringWidth($cell),3, $cell, 0, '1');

$pdf->Ln(2);
$pdf->SetFont('Times','',12);
$boldCell = "on ";
$pdf->Cell($pdf->GetStringWidth($boldCell),3,$boldCell, 0, 'L');

$pdf->SetFont('Times','B',12);
$cell = ''.$end_month.' '.$end_day.', '.$end_year.'.';
$pdf->Cell($pdf->GetStringWidth($cell),3,$cell, 0, 'L');

/*
$pdf->Cell(0,10,'Therefore, you are to proceed on your '.$leave_type.' Leave effective '.$start_month.' '.$start_day.', '.$start_year.' and expected to resume' ,0,1); 
$pdf->SetFont('Arial','',10);
$boldCell = "on ";
$pdf->Cell($pdf->GetStringWidth($boldCell),3,$boldCell, 0, 'L');



$pdf->SetFont('Times','B',12);
$cell = ''.$end_month.' '.$end_day.', '.$end_year.'.';
$pdf->Cell($pdf->GetStringWidth($cell),3,$cell, 0, 'L');
*/

$pdf->Ln(5);



$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Thank you',0,1);
$pdf->Ln(5);

$pdf->Cell(0,10,'Yours Faithfully,',0,1);
$boldCell = "For: ";
$pdf->Cell($pdf->GetStringWidth($boldCell),3,$boldCell, 0, 'L');


$pdf->SetFont('Times','B',12);
$cell = 'ICSOUTSOURCING';
$pdf->Cell($pdf->GetStringWidth($cell),3,$cell, 0, '1');
$pdf->Ln(5);
$pdf->SetFont('Times','',12);
if($user[0]['leave_flow'] != ''){
    $flow = explode(";",$user[0]['leave_flow']);
    $flow_name = explode(";",$user[0]['flow_name']);
    //print_r($flow_name);
    for($r = 0; $r < count($flow); $r++){
        $each_flow = explode(":", $flow[$r]);
        $each_flow_name = explode(":", $flow_name[$r]);
        if(count($each_flow) > 1) $approvals[] = $each_flow[1];
        if(count($each_flow_name) > 1) $approvals_name[] = $each_flow_name[1];
    }
}
for($c = 0; $c < count($approvals_name); $c++){
    $cell = 'CC :'.$approvals_name[$c].'';
    $pdf->Cell($pdf->GetStringWidth($cell),3,$cell, 0, '1');
    $pdf->Ln(3);
}

$pdf->Output('F', $dest);
updateLeave($conn,$leaves);
$msg = "<p>Dear ".$user[0]['name'].",</p><p style='margin-top:10px;'>We received your leave request which has already been approved by your unit head/branch manager. Therefore, you are to proceed on your ".$leave_type." Leave effective ".$start_month.' '.$start_day.', '.$start_year." and expected to resume on ".$end_month.' '.$end_day.', '.$end_year.".</p><p style='margin-top:10px;'>Thank You</p><p style='margin-top:5px;'>Your Faithfully,</p><p style='margin-top:5px;'>For: ICSOUTSOURCING</p>";
//print_r($user);
sendmail('ogunrindeomotayo@gmail.com',$msg,'Leave Confirmation',$approvals,$dest);
//$pdf->Output();
$_SESSION['msg'] = "Letter Sent to Employee and Approvals";
//header("Location: view_leave_flow");
//echo "<script type='text/javascript'> document.location = '/outsourcing/view_leave_flow.php'; </script>";
//header("Location: /outsourcing/downloadpdf.php/?file=leave_request&filename=".$pdf_name."");

function updateLeave($conn,$leaves){
     $sql = "UPDATE leaves SET processed = 'Treated' WHERE id = '".$leaves[0]['id']."'";
        if (mysqli_query($conn, $sql)) {
        } else {
          //echo "Error updating record: " . mysqli_error($conn);
        }
        return true;
  }
function sendmail($to,$msg,$subject,$approvals,$dest){
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host = 'hrcore.ng';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
    $mail->Username = 'ess@hrcore.ng';                     // SMTP username
    $mail->Password = 'wROS+cb63zQ(';                               // SMTP password
    $mail->SMTPSecure = 'tls';  
    $mail->SMTPAutoTLS = false;   
    $mail->SMTPOptions = array(
	    'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
	    )
	);                             // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('ess@hrcore.ng', 'Leave Confirmation');
    $mail->addAddress($to, 'ESS');     // Add a recipient
    for($r = 0; $r < count($approvals); $r++){
        $mail->addCC($approvals[$r]);
    }
    $mail->addCC('leave@icsoutsourcing.com');
    $mail->addCC('ogunrindeomotayo@gmail.com');
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    $mail->addAttachment($dest);         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $msg;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
    /*if($subject == 'Leave Request'){
        echo 'Message has been sent';
        $_SESSION['msg'] = "Your leave request is under processing";
        header("Location: staff_leave_request.php");
    }*/
    return true;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    /*if($subject == 'Leave Request'){
        $_SESSION['msg'] = "Your leave request is under processing";
        header("Location: staff_leave_request.php");
    }*/
    return false;
}
}  
//header("Location: /outsourcing/downloadpdf.php/?file=leave_request&filename=".$pdf_name."")
?>