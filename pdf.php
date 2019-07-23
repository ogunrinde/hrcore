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
if(!isset($_GET['leave_id'])){
  header("Location: view_leave_flow");
  return false;
}

 $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September', 'October', 'November', 'December'];
$query = "SELECT * FROM leaves WHERE id = '".$_SESSION['leave_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $leaves[] = $row;
        $t =  (int)(trim(explode('-',$row['start_date'])[1]));
         $end_period = $row['end_date'];
         $start_month = $month[$t-1];
         $start_year = explode('-',$row['start_date'])[0];
         $start_day = explode('-',$row['start_date'])[2];
         $end_month = $month[$t-1];
         $end_year = explode('-',$row['end_date'])[0];
         $end_day = explode('-',$row['end_date'])[2];
      }
  }
   $query = "SELECT * FROM users WHERE id = '".$leaves[0]['admin_id']."'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)> 0){
        while($row = mysqli_fetch_assoc($result)) {
          $pm_data[] = $row;
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
$pdf->Ln(55);
$pdf->SetFont('Times','',12);
$date_now = $month[(int)date('m') -1].' '.date('d').',  '.date('Y');
$pdf->Cell(0,10,$date_now,0,1);
$pdf->Ln(5);
$pdf->SetFont('Times','',12);

/*$name = isset($user[0]['name']) ? $user[0]['fname'].' '.$user[0]['name'] : '';
$user_company = isset($user[0]['user_company']) ? $user[0]['user_company'] : '';
$branch = isset($user[0]['branch']) ? $user[0]['branch'] : '';
$branch = "$branch Branch";
$pdf->Cell(0,10,$name,0,1);
$pdf->Cell(0,10,$user_company,0,1);
$pdf->Cell(0,10,$branch,0,1);
$pdf->Ln(10);
$salute = isset($user[0]['name']) ? 'Dear '.$user[0]['fname'].',' : 'Dear,';*/


$name = isset($user[0]['name']) ? strtoupper($user[0]['name']) : '';
$user_company = isset($user[0]['company_name']) ? $user[0]['company_name'] : '';
$role = isset($user[0]['role']) ? $user[0]['role'] : '';
$branch = isset($user[0]['branch']) ? $user[0]['branch'] : '';
$branch = "$branch Branch";
$pdf->Cell(0,10,$name,0,1);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,"$user_company ($role),",0,1);
$pdf->Cell(0,10,$branch,0,1);
$pdf->Ln(10);
$salute = $user[0]['fname'] != '' ? 'Dear '.strtoupper($user[0]['fname']).',' : 'Dear '.strtoupper($user[0]['name']).',';
$pdf->SetFont('Times','B',12);
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
//$cell = ''.$end_month.' '.$end_day.', '.$end_year.'.';
$cell = get_days($end_period); 
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
$pdf->Cell(0,10,'Thank you.',0,1);
$pdf->Ln(5);

$pdf->Cell(0,10,'Yours Faithfully,',0,1);
$boldCell = "for: ";
$pdf->Cell($pdf->GetStringWidth($boldCell),3,$boldCell, 0, 'L');

$pdf->SetFont('Times','B',12);
$cell = 'ICS Outsourcing Limited';
$pdf->Cell($pdf->GetStringWidth($cell),3,$cell, 0, '1');
$pdf->Ln(10);
$pdf->Image('images/sign.PNG', 7, 195, 51, 29);
$pdf->Ln(20);
$cell = 'Kunbi Adekeye';
$pdf->Cell($pdf->GetStringWidth($cell),3,$cell, 0, '1');
$pdf->Ln(5);
$cell = 'Head, People Outsourcing';
$pdf->Cell($pdf->GetStringWidth($cell),3,$cell, 0, '1');
$pdf->Ln(5);
$pdf->SetFont('Times','',12);


/*$pdf->SetFont('Times','B',12);
$cell = 'ICSOUTSOURCING';
$pdf->Cell($pdf->GetStringWidth($cell),3,$cell, 0, '1');
$pdf->Ln(15);
$pdf->SetFont('Times','',12);*/


function get_days($end_date){
	$counter = 0;
 $no_included = ['Mon','Tue','Wed','Thu','Fri'];
 $end_date = date ("Y-m-d", strtotime("+1 day", strtotime($end_date)));
 //echo date('N',strtotime('2019-03-31'));
 while($counter == 0){
    if(date("N",strtotime($end_date)) <= 5) {
    	//echo date("N",strtotime($start_date));
        $counter++;
    }else
      $end_date = date ("Y-m-d", strtotime("+1 day", strtotime($end_date)));

  }
  $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September', 'October', 'November', 'December'];
  $t =  (int)(trim(explode('-',$end_date)[1]));
         $end_month = $month[$t-1];
         $end_year = explode('-',$end_date)[0];
         $end_day = explode('-',$end_date)[2];
        $date =  ''.$end_month.' '.$end_day.', '.$end_year.'.';
  return $date;
}


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
//$pdf->Output();
updateLeave($conn,$leaves);
$msg = "<p>Dear ".$user[0]['name'].",</p><p style='margin-top:10px;'>Please find attached the approval for your <b>Annual Leave</b> application.</p><p style='margin-top:10px;'>Kindly contact your People Manager at ICS Outsourcing Limited if you have any concern with respect to this approval.</p><p style='margin-top:10px;'>Regards,</p><p style='margin-top:5px;'>Leave Management Desk,</p><p>ICS Outsourcing Limited.</p>";
sendmail($user[0]['email'],$msg,'Leave Confirmation',$approvals,$dest,$pm_data);
//return false;
//$pdf->Output();
$_SESSION['msg'] = "Letter Sent to Employee and Approvals";
//header("Location: view_leave_flow");
echo "<script type='text/javascript'> document.location = '/outsourcing/view_leave_flow.php'; </script>";
//header("Location: /outsourcing/downloadpdf.php/?file=leave_request&filename=".$pdf_name."");

function updateLeave($conn,$leaves){
     $sql = "UPDATE leaves SET processed = 'Treated', date_treated = '".date('Y-m-d')."' WHERE id = '".$leaves[0]['id']."'";
        if (mysqli_query($conn, $sql)) {
        } else {
          //echo "Error updating record: " . mysqli_error($conn);
        }
        return true;
  }
function sendmail($to,$msg,$subject,$approvals,$dest,$pm_data){
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
    if(isset($pm_data[0]['email'])) $mail->addCC($pm_data[0]['email']);
    //$mail->addCC('ogunrindeomotayo@gmail.com');
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
    /*echo 'Message has been sent';
    if($subject == 'Leave Request'){
        echo 'Message has been sent';
        $_SESSION['msg'] = "Your leave request is under processing";
        header("Location: staff_leave_request.php");
    }*/
    return true;
} catch (Exception $e) {
    /*echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    if($subject == 'Leave Request'){
        $_SESSION['msg'] = "Your leave request is under processing";
        header("Location: staff_leave_request.php");
    }*/
    return false;
}
}  
//header("Location: /outsourcing/downloadpdf.php/?file=leave_request&filename=".$pdf_name."")
?>