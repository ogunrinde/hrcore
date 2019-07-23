<?php
include "connection.php";
include ('fpdf/fpdf.php');
session_start();
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
//get_days();
$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September', 'October', 'November', 'December'];
$query = "SELECT * FROM leaves WHERE id = '".$_SESSION['leave_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $leaves[] = $row;
        $start_period = $row['start_date'];
        $end_period = $row['end_date'];
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
  //print_r($user);
  //return false;
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
$pdf->SetFont('Times','B',12);
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

//$pdf->Cell(0,10,$user[0]['leave_flow'],0,1);

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
    $cell = 'CC : '.$approvals_name[$c].'';
    $pdf->Cell($pdf->GetStringWidth($cell),3,$cell, 0, '1');
    $pdf->Ln(3);
}

$pdf->Output();
//echo "aaaa";
?>