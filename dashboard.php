<?php 
include 'connection.php';
include "check_requirement_leave.php";
session_start();
$appraisal = [];
$leaves = [];
$requisition = [];
$id_card = [];
$show = 'FALSE';
$company = [];
$id_card_processor = [];
$appraisal_uploader = [];
$data_item = [];
$kss = [];
$leave_type = [];
$all_leave_type = [];
$items = [];
$counter_annual = 0;
$counter_casual = 0;
$counter_sick = 0;
$counter_exam = 0;
$counter_paternity = 0;
$counter_maternity = 0;
$year_appraisal = [];
$user_for_leave = [];
$total_staff = 0;
$confirmed_staff = 0;
$pending_leaves = 0;
$branch_staff = [];
$pending_appraisal = 0;
$to_show_leave = [];
$to_show_appraisal = [];
$to_show_audit = [];
//print_r($_SESSION['user']);
  if(!isset($_SESSION['user']['id'])) header("Location: login.php");
 $msg = '';
if($_SESSION['user']['phone_number'] == '') $msg .= '<p>Phone Number,';
if($_SESSION['user']['branch'] == '') $msg .= ' Branch, ';
if($_SESSION['user']['marital_status'] == '') $msg .= 'Marital Status, ';
if($_SESSION['user']['dob'] == '') $msg .= 'Date of Birth, ';
if($_SESSION['user']['department'] == '') $msg .= 'Department, ';
if($_SESSION['user']['lga'] == '') $msg .= 'Local Government Area, ';
if($_SESSION['user']['sorigin'] == '') $msg .= ' State of Origin, '; 
if($_SESSION['user']['address'] == '') $msg .= 'Address, ';
if($_SESSION['user']['cdate_of_employeement'] == '') $msg .= 'Date of Employment, ';
if($_SESSION['user']['leave_flow'] == '') $msg .= 'Leave Approvers,';

  if($_SESSION['user']['category'] == 'staff' && $_SESSION['user']['position'] == ''){
    $query = "SELECT * FROM appraisal_replies INNER JOIN appraisal ON appraisal_replies.appraisal_id = appraisal.id WHERE staff_id = '".$_SESSION['user']['id']."'";
    $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $appraisal[] = $row;
      }
  }
  
  if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
  else if ($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];    
  $query = "SELECT * FROM leave_type WHERE company = '".$_SESSION['user']['user_company']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $all_leave_type[] = $row;
        //$annual = $row['leave_kind'] == 'Annual' ? 
      }
      foreach($all_leave_type as $value){
          if($value['leave_kind'] == 'Maternity'){
              if($_SESSION['user']['gender'] == 'Female')
                 $leave_type[] = $value;
          }else 
            $leave_type[] = $value;
      }
  }
  //print_r($leave_type);
  //echo "aaaaaaaaaaa";
  $counter_annual = 0;
      $counter_casual = 0;
      $counter_sick = 0;
      $counter_exam = 0;
      $counter_paternity = 0;
      $counter_maternity = 0;
      $counter_compasionate = 0;
      //echo $counter_annual;
  $query = "SELECT * FROM leaves WHERE staff_id = '".$_SESSION['user']['id']."' AND processed != 'Cancelled' AND stage !='decline' AND stage !='Decline'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $leaves[] = $row;
        if($row['processed'] == 'Pending') $pending_leaves++;
        
           
        //print_r($leaves);
        $count = get_days($row['start_date'],$row['end_date']);
        //echo $count;
        $year = explode("-", $row['start_date'])[0];
        if($row['leave_type'] == 'Annual' && $year == date('Y')){
          $counter_annual = $counter_annual + $count;
          
        } 
        else if($row['leave_type'] == 'Casual' && $year == date('Y')) $counter_casual = $counter_casual + $count;
        else if($row['leave_type'] == 'Sick' && $year == date('Y')) $counter_sick = $counter_sick + $count;
        else if($row['leave_type'] == 'Maternity' && $year == date('Y') && $_SESSION['user']['gender'] == 'Female') $counter_maternity = $counter_maternity + $count;
            //echo $counter_maternity;
        else if($row['leave_type'] == 'Paternity' && $year == date('Y')) $counter_paternity = $counter_paternity + $count;
        else if($row['leave_type'] == 'Exam' && $year == date('Y')) $counter_exam = $counter_exam + $count;
        else if($row['leave_type'] == 'Compassionate' && $year == date('Y')) $counter_compasionate = $counter_compasionate + $count;
      }
      
      
  }
  //print_r($leaves);
  $query = "SELECT * FROM requesteditem WHERE staff_id = '".$_SESSION['user']['id']."' AND status = 'pending'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $requisition[] = $row;
      }
  }
  $query = "SELECT * FROM id_card WHERE staff_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $id_card[] = $row;
      }
  }
    $query = "SELECT * FROM open_information_portal WHERE admin_id = '".$_SESSION['user']['admin_id']."' AND open_for = '".$_SESSION['user']['department']."'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1){
      $row = mysqli_fetch_assoc($result);
       $data[] = $row;
       //print_r($data);
        if(strtotime(date('Y-m-d')) >= strtotime($data[0]['opening_date']) && strtotime($data[0]['closing_date']) > strtotime(date('Y-m-d'))){
          $show = 'TRUE';
       }else {
          $show = 'FALSE';
          //$_SESSION['msg'] = 'You don\'t have permission to edit this document, wait still permission is granted by the admin';
       }
    }
}else if($_SESSION['user']['category'] == 'admin'){
    $staff_audit = [];
  $user_admin = [];
  $leaves_admin = [];
  $appraisal_admin = [];
  $male = 0;
  $female = 0;
  $confirmed = 0;
  $user_birthday = [];
  $admin_staff = 0; 
  $birthday = [];
  $pension = 0;
  $on_hmo = 0;
  $query = "SELECT * FROM users WHERE admin_id = '".$_SESSION['user']['id']."' AND active = '1'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $user_admin[] = $row;
        if($row['category'] == 'staff' && $row['position'] == '') $admin_staff++;
        if($row['dob'] != ''){
          $month = explode("-",$row['dob'])[1];
          $day = explode("-",$row['dob'])[2];
          if((int)date('m') == $month){
            $user_birthday[] = $row;
            if((int)$day == 1) $day = '1st';
            else if((int)$day == 2) $day = '2nd';
            else if((int)$day == 3) $day = '3rd';
            else $day = $day.'th';
            $birthday[] = $day." ".date('F',strtotime(date('Y-m-d')));
          }
        }
        if($row['gender'] == 'Male') $male++;
        if($row['gender'] == 'Female') $female++;
        if($row['confirmed'] == 'Confirmed') $confirmed++;
        if($row['pension_pin'] != '') $pension++;
        if($row['on_hmo'] == 'Yes') $on_hmo++;
      }
      //print_r($birthday);
  }
  //$user_birth = [];
  //print_r($user_birthday);
  /*for($e = 1; $e <= 31; $e++){
      for($e = 0; $e < count($user_birthday); $e++){
          $day = explode("-",$user_birthday[$e]['dob'])[2];
         if($e == (int)$day){
            $user_birth[] = $user_birthday[$e];
            if((int)$day == 1) $day = '1st';
            else if((int)$day == 2) $day = '2nd';
            else if((int)$day == 3) $day = '3rd';
            else $day = $day.'th';
            $birthday[] = $day." ".date('F',strtotime(date('Y-m-d')));
         }
      }
  }*/
  //print_r($user_birth[0]);
  /*$query = "SELECT * FROM requesteditem WHERE admin_id = '".$_SESSION['user']['id']."' AND status = 'pending'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $requisition[] = $row;
      }
  }
  $query = "SELECT * FROM users WHERE admin_id = '".$_SESSION['user']['id']."' AND upload_appraisal ='1' LIMIT 3";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $appraisal_uploader[] = $row;
      }
  }*/
  if($_SESSION['user']['leave_processing_permission'] == '1'){
      $query = "SELECT * FROM leaves WHERE company_id = '".$_SESSION['user']['company_id']."' AND processed != 'Cancelled' AND stage !='decline' AND stage !='Decline' AND processed != 'Treated' AND year ='".date('Y')."' ";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result)> 0){
          while($row = mysqli_fetch_assoc($result)) {
            if($row['processed'] == 'Pending' && ($row['stage'] == 'Approved' || $row['approved'])) $pending_leaves++;  
            $leaves_admin[] = $row;
          }
      }
  }else {
      $query = "SELECT * FROM leaves WHERE admin_id = '".$_SESSION['user']['id']."' AND processed != 'Cancelled' AND stage !='decline' AND stage !='Decline'";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result)> 0){
          while($row = mysqli_fetch_assoc($result)) {
            if($row['processed'] == 'Pending' && $row['stage'] != 'Approved') $pending_leaves++;  
            $leaves_admin[] = $row;
          }
      }
      //print_r($pending_leaves);
  }
  
  $query = $query = "SELECT * FROM appraisal_replies INNER JOIN appraisal ON appraisal_replies.appraisal_id = appraisal.id WHERE appraisal.admin_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $appraisal_admin[] = $row;
      }
  }
  //print_r($appraisal_admin);
  $query = "SELECT * FROM open_information_portal WHERE admin_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1){
      $row = mysqli_fetch_assoc($result);
       $data[] = $row;
        if(strtotime(date('Y-m-d')) >= strtotime($data[0]['opening_date']) && strtotime($data[0]['closing_date']) > strtotime(date('Y-m-d'))){
          $show = 'TRUE';
       }else {
          $show = 'FALSE';
       }
    }
  $query = "SELECT * FROM company WHERE admin_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_assoc($result);
       $company[] = $row;
        
    }
$leave_request = 0; 
$appraisal_request = 0;   
//print_r($leaves_admin[0]['year']);
for($r = 0; $r < count($leaves_admin);$r++){
    if($leaves_admin[$r]['year'] == date('Y')){
        if($leaves_admin[$r]['flow'] != ''){
          $flow = explode(';',$leaves_admin[$r]['flow']);
          $is_added = false;
          for($t=0;$t<count($flow);$t++){
            $each_flow = explode(":",$flow[$t]);
            if(count($each_flow) > 1){

              if (filter_var($each_flow[1], FILTER_VALIDATE_EMAIL) && $is_added == false) {
                    $is_added = true;
                    $leave_request++;
              }
            }
          }
        }
    }
  }  
  //print_r($appraisal_admin);
  for($r = 0; $r < count($appraisal_admin);$r++){
    if($appraisal_admin[$r]['year'] == date('Y')){
        if($appraisal_admin[$r]['comments_flow'] != ''){
          $flow = explode(';',$appraisal_admin[$r]['comments_flow']);
          //print_r($flow);
          $is_added = false;
          for($t=0;$t<count($flow);$t++){
            $each_flow = explode(":",$flow[$t]);
            if(count($each_flow) > 1){
              //print_r($each_flow);
              if (filter_var($each_flow[1], FILTER_VALIDATE_EMAIL) && $is_added == false) {
                    $is_added = true;
                    $appraisal_request++;
              }
            }
          }
        }
    }
  }
    $query = "SELECT staff_audit_replies.id as reply_id, month,year,users.role, users.id as user_id,users.name,users.fname,users.mname,users.department,users.branch,users.leave_flow FROM staff_audit INNER JOIN staff_audit_replies ON staff_audit_replies.audit_id = staff_audit.id INNER JOIN users ON users.id = staff_audit_replies.staff_id WHERE staff_audit.admin_id = '".$_SESSION['user']['id']."' AND staff_audit_replies.branch_manager_replies = 'Pending'";
 $app_result = mysqli_query($conn, $query);
  if(mysqli_num_rows($app_result) > 0){
     while($row = mysqli_fetch_assoc($app_result)) {
          $staff_audit[] = $row;
     }
  }
  //print_r($staff_audit);
}
else if($_SESSION['user']['position'] == 'Line Manager' || $_SESSION['user']['position'] == 'Branch Manager' || $_SESSION['user']['position'] == 'HR' || $_SESSION['user']['position'] == 'Regional Manager' || $_SESSION['user']['position'] == 'Approver') {
    $query = "SELECT * FROM appraisal_replies INNER JOIN appraisal ON appraisal_replies.appraisal_id = appraisal.id WHERE appraisal.admin_id = '".$_SESSION['user']['admin_id']."'";
    $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $appraisal[] = $row;
      }
  }
    $query = "SELECT * FROM leaves WHERE staff_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      $counter_annual = 0;
      $counter_casual = 0;
      $counter_sick = 0;
      $counter_exam = 0;
      $counter_paternity = 0;
      $counter_maternity = 0;
      while($row = mysqli_fetch_assoc($result)) {
        $leaves[] = $row;
        $count = get_days($row['start_date'],$row['end_date']);
        $year = explode("-", $row['start_date'])[0];
        if($row['leave_type'] == 'Annual' && $year == date('Y')) $counter_annual = $counter_annual + $count;
        else if($row['leave_type'] == 'Casual' && $year == date('Y')) $counter_casual = $counter_casual + $count;
        else if($row['leave_type'] == 'Sick' && $year == date('Y')) $counter_sick = $counter_sick + $count;
        else if($row['leave_type'] == 'Maternity' && $year == date('Y')) $counter_sick = $counter_maternity + $count;
        else if($row['leave_type'] == 'Paternity' && $year == date('Y')) $counter_sick = $counter_paternity + $count;
        else if($row['leave_type'] == 'Exam' && $year == date('Y')) $counter_sick = $counter_exam + $count;
      }
  }
}else if($_SESSION['user']['position'] == 'People Management'){
  $query = "SELECT * FROM leaves WHERE admin_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $leaves[] = $row;
      }
  }
}
  if($_SESSION['user']['category'] == 'admin'){
    $query = "SELECT * FROM requesteditem WHERE admin_id = '".$_SESSION['user']['id']."' ORDER BY id DESC LIMIT 3";
  }else {
    $query = "SELECT * FROM requesteditem WHERE staff_id = '".$_SESSION['user']['id']."' ORDER BY id DESC LIMIT 3";
  }
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data_item[] = $row;
      }
  }
 $query = "SELECT * FROM users WHERE admin_id = '".$_SESSION['user']['admin_id']."' AND active = '1'";
 $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) > 0){
     while($row = mysqli_fetch_assoc($result)) {
          $user_for_leave[] = $row;
     }
  }
  
  //print_r($user_for_leave);
if($_SESSION['user']['position'] == 'Line Manager' || $_SESSION['user']['position'] == 'Branch Manager' || $_SESSION['user']['position'] == 'HR' || $_SESSION['user']['position'] == 'Regional Manager' || $_SESSION['user']['position'] == 'Approver') {
     $staff_audit = [];
     $query = "SELECT leaves.id as leave_id,leaves.leave_type,leaves.flow,leaves.justification,leaves.require_reliever, leaves.staff_id,users.id as user_id FROM leaves INNER JOIN users ON users.id = leaves.staff_id WHERE leaves.admin_id = '".$_SESSION['user']['admin_id']."' AND leaves.stage != 'approved' AND leaves.stage != 'decline' AND leaves.processed != 'Cancelled' AND leaves.stage != 'Decline' AND year = '".date('Y')."'";
 $app_result = mysqli_query($conn, $query);
  if(mysqli_num_rows($app_result) > 0){
     while($row = mysqli_fetch_assoc($app_result)) {
          $leaves[] = $row;
     }
  }
  
  $query = "SELECT staff_audit_replies.id as reply_id, month,year,users.role, users.id as user_id,users.name,users.fname,users.mname,users.department,users.branch,users.leave_flow FROM staff_audit INNER JOIN staff_audit_replies ON staff_audit_replies.audit_id = staff_audit.id INNER JOIN users ON users.id = staff_audit_replies.staff_id WHERE staff_audit.admin_id = '".$_SESSION['user']['admin_id']."' AND staff_audit_replies.branch_manager_replies = 'Pending'";
 $app_result = mysqli_query($conn, $query);
  if(mysqli_num_rows($app_result) > 0){
     while($row = mysqli_fetch_assoc($app_result)) {
          $staff_audit[] = $row;
     }
  }
  //print_r($staff_audit);
  if(count($staff_audit) > 0 ){
      for($e = 0; $e < count($staff_audit); $e++){
          if($staff_audit[$e]['leave_flow'] != ""){
              $flow = explode(";",$staff_audit[$e]['leave_flow']);
              for($t = 0; $t < count($flow); $t++){
                  $each_flow = explode(":",$flow[$t]);
                  if(count($each_flow) > 1){
                      
                      if($each_flow[0] == 'Branch Manager'){
                          if(trim(strtolower($each_flow[1])) == trim(strtolower($_SESSION['user']['email']))){
                              //echo 'ass';
                              $to_show_audit[] = $staff_audit[$e];
                              
                          }
                      }
                  }
              }
          }
      }
  }
   //print_r($to_show_audit); 
}
//print_r($user_for_leave);
for ($i=0; $i < count($leaves); $i++) { 
  if($leaves[$i]['flow'] != ''){
    //echo $user[$i]['appraisal_flow'];
  $leave_approval_details = explode(";", $leaves[$i]['flow']);
  if(count($leave_approval_details) > 0){
    for($r = 0; $r < count($leave_approval_details); $r++){
      $email = explode(":", $leave_approval_details[$r])[1]; //email of approval
      //echo $email."<br>";
      if($email == $_SESSION['user']['email']){
          $pending_leaves = $pending_leaves + 1;
      }
    }
    
    
  }
 }
}
for ($i=0; $i < count($appraisal); $i++) { 
  if($appraisal[$i]['comments_flow'] != ''){
    //echo $user[$i]['appraisal_flow'];
  $app_approval_details = explode(";", $appraisal[$i]['comments_flow']);
  if(count($app_approval_details) > 0){
    for($r = 0; $r < count($app_approval_details); $r++){
      $email = explode(":", $app_approval_details[$r])[1]; //email of approval
      //echo $email."<br>";
      if($email == $_SESSION['user']['email']){
          $pending_appraisal = $pending_appraisal + 1;
      }
    }
    
    
  }
 }
}
//print_r($user_for_leave);
//echo $_SESSION['user']['email'];
for ($i=0; $i < count($user_for_leave); $i++) { 
  $p = 0;
  if($user_for_leave[$i]['leave_flow'] != ''){
    //echo $user_for_leave[$i]['leave_flow'];
  $leave_approval_details = explode(";", $user_for_leave[$i]['leave_flow']);
  //print_r($leave_approval_details);
  if(count($leave_approval_details) > 0){
    for($r = 0; $r < count($leave_approval_details); $r++){
      $email = explode(":", $leave_approval_details[$r])[1]; //email of approval
      //echo $email."<br>";
      
      if(strtolower(trim($email)) == strtolower(trim($_SESSION['user']['email']))){
          $p = 1;
          //echo $email;
        $branch_staff[] = $user_for_leave[$i];
        if($user_for_leave[$i]['confirmed'] == 'confirmed') $confirmed_staff = $confirmed_staff + 1;
        foreach ($leaves as $value) {
         
          if($value['staff_id'] == $user_for_leave[$i]['id']){
              //print_r($value);
            $to_remark[]  = $user_for_leave[$i];
            $to_show_leave[] = $value;
          }
        }
      }
    }
    if($p == 1) $total_staff = $total_staff + 1;
    
  }
 }
}
//print_r($branch_staff);
/*for ($i=0; $i < count($user_for_leave); $i++) { 
  if($user_for_leave[$i]['appraisal_flow'] != ''){
    //echo $user[$i]['appraisal_flow'];
  $appraisal_approval_details = explode(";", $user_for_leave[$i]['appraisal_flow']);
  if(count($appraisal_approval_details) > 0){
    for($r = 0; $r < count($appraisal_approval_details); $r++){
      $email = explode(":", $appraisal_approval_details[$r])[1];//email of approval
      //echo $email."<br>";
      if($email == $_SESSION['user']['email']){
        $pending_appraisal = $pending_appraisal + 1;  
        foreach ($appraisal as $value) {
          if($value['staff_id'] == $user_for_leave[$i]['id']){
            $to_remark[]  = $user_for_leave[$i];
            $to_show_appraisal[] = $value;
          }
        }
      }
    }
    
    
  }
 }
}*/
for ($i=0; $i < count($appraisal); $i++) { 
  if($appraisal[$i]['comments_flow'] != ''){
    //echo $user[$i]['appraisal_flow'];
  $appraisal_approval_details = explode(";", $appraisal[$i]['comments_flow']);
  if(count($appraisal_approval_details) > 0){
    for($r = 0; $r < count($appraisal_approval_details); $r++){
      $email = explode(":", $appraisal_approval_details[$r])[1];//email of approval
      
      if($email == $_SESSION['user']['email']){
          //echo $email."<br>";
        $pending_appraisal = $pending_appraisal + 1;  
        //foreach ($appraisal as $value) {
            
         for($q = 0; $q < count($user_for_leave);$q++){
              if($appraisal[$i]['staff_id'] == $user_for_leave[$q]['id']){
                $to_remark[]  = $user_for_leave[$q];
                $to_show_appraisal[] = $appraisal[$i];
              }
         }        
          
          
          
          
        //}
      }
    }
    
    
  }
 }
}
//echo $counter_annual;
  //print_r($to_show_appraisal);
  //print_r($leaves);
?>

<?php include "header.php"?>
<style type="text/css">
 .table-striped>tbody>tr:nth-of-type(odd){
    background-color: #f8fafc;
  }
  .table>tbody>tr>th{
    border-top: none;
  }
  .table>tbody>tr>td{
    border-top: none;
  }
</style>
 
 <div class="right_col" role="main">
          <!-- top tiles -->
          <?php if($_SESSION['user']['category'] == 'staff' && $_SESSION['user']['position'] == '') { ?>
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Appraisals Filled</span>
              <div class="count"><?=count($appraisal)?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> ID Card Request</span>
              <div class="count"><?=count($id_card)?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> On HMO</span>
              <?php if($_SESSION['user']['category'] == 'staff') { ?>
                 <div class="count green"><?=$_SESSION['user']['on_hmo'] == 'Yes' ? 'Yes' : 'No'?></div>
              <?php } ?> 
            </div>
            <?php if($_SESSION['user']['category'] == 'admin') {?>
               <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Payroll Access</span>
              <?php if($_SESSION['user']['category'] == 'staff') { ?>
              <div class="count green"><?=$_SESSION['user']['payroll_permission'] == '1' ? 'TRUE' : 'FALSE'?></div>
              <?php }else { ?>
                 <div class="count green">TRUE</div>
              <?php } ?> 
            </div>
            <?php  } ?>
            
            <!--div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Employee Portal</span>
              <div class="count green"><?=$show?></div>
            </div-->
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Pending Leave Request</span>
              <div class="count"><?=$pending_leaves?></div>
            </div>
             <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Completed Employee Update</span>
              <?php if($msg != '') {?>
                <div class="count green">FALSE</div>
              <?php }else { ?>
                <div class="count green">TRUE</div>
              <?php } ?>
            </div>
          </div>
          <?php  } ?>
          <?php if($_SESSION['user']['position'] == 'Line Manager' || $_SESSION['user']['position'] == 'Branch Manager' || $_SESSION['user']['position'] == 'HR' || $_SESSION['user']['position'] == 'Regional Manager' || $_SESSION['user']['position'] == 'Approver') { ?>
             <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Staff </span>
              <div class="count"><?=$total_staff?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Pension</span>
              <div class="count"><?=$pension?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Confirmed Staff</span>
                 <div class="count green"><?=$confirmed_staff?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Pending Appraisal</span>
                 <div class="count green">0</div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Pending Leave Request</span>
              <div class="count"><?=$pending_leaves?></div>
            </div>
          </div>
          <?php } ?>
          <?php if($_SESSION['user']['category'] == 'admin') {?>
            <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Staff </span>
              <div class="count"><?=$admin_staff?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Male</span>
              <div class="count"><?=$male?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Female</span>
                 <div class="count green"><?=$female?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Pension</span>
                 <div class="count green"><?=$pension?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Confirmed</span>
              <div class="count"><?=$confirmed?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> On HMO</span>
                 <div class="count green"><?=$on_hmo?></div>
            </div>
          </div>
          <?php } ?>
          <!-- /top tiles -->
           <div class="row">
            <?php if($_SESSION['user']['category'] == 'admin') {?>      
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 style='color:#1ABB9C;font-weight:bolder;'>Pending Approvals in <?=date('Y')?></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                  
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N </th>
                            <th class="column-title">Category</th>
                            <th class="column-title">Pendings </th>
                            <th class="column-title">More </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr class="pointer">
                            <td class="a-center ">
                              1
                            </td>
                            <td class="">Leave Request</td>
                            <td class=" "><?= $pending_leaves?></td>
                            <?php if($_SESSION['user']['leave_processing_permission'] == '1')  { ?>
                              <td class=" "><a href="view_leave" class="btn btn-success btn-sm">View</a></td>
                            <?php }else {?>
                              <td class=" "><a href="view_leave" class="btn btn-success btn-sm">View</a></td>
                            <?php } ?>  
                          </tr>
                          <tr class="pointer">
                            <td class="a-center ">
                              2
                            </td>
                            <td class="">Staff Audit</td>
                            <td class=" "><?=count($staff_audit)?></td>
                            <td class=" "><a href="audit" class="btn btn-primary btn-sm">View</a></td>
                          </tr>
                          <tr class="pointer">
                            <td class="a-center ">
                              3
                            </td>
                            <td class="">Appraisal Reviews</td>
                            <td class=" "><?=$appraisal_request?></td>
                            <td class=" "><a href="appraisal_remark" class="btn btn-info btn-sm">View</a></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2 style='color:#1ABB9C;font-weight:bolder;'>Birthdays in <?=date('F',strtotime(date('Y-m-d')));?></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                  
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N </th>
                            <th class="column-title">Employee</th>
                            <th class="column-title">Branch</th>
                            <th class="column-title">Address</th>
                            <th class="column-title">Birthday </th>
                          </tr>
                        </thead>

                        <tbody>
                        <?php for($s = 0; $s < count($user_birthday); $s++) { ?>
                         <?php if((int)$birthday[$s] == (int)date('d').'th') { ?>
                          <tr class="pointer" style='background-color:yellow'>
                            <td class="a-center ">
                              <?=$s+1?>
                            </td>
                            <td class=""><?=$user_birthday[$s]['name']?></td>
                            <td class=""><?=$user_birthday[$s]['branch']?></td>
                            <td class=""><?=$user_birthday[$s]['address']?></td>
                            <td class=" "><?=$birthday[$s]?></td>
                          </tr>
                           <?php } else { ?>
                          <tr class="pointer" style=''>
                            <td class="a-center ">
                              <?=$s+1?>
                            </td>
                            <td class=""><?=$user_birthday[$s]['name']?></td>
                            <td class=""><?=$user_birthday[$s]['branch']?></td>
                            <td class=""><?=$user_birthday[$s]['address']?></td>
                            <td class=" "><?=$birthday[$s]?></td>
                          </tr>
                        <?php  } } ?>
                        </tbody>
                      </table>
                    </div>
                    
                  </div>
                </div>
            </div>
            <?php } ?>
           </div>
          <br />
          <?php if($_SESSION['user']['position'] == 'Line Manager' || $_SESSION['user']['position'] == 'Branch Manager' || $_SESSION['user']['position'] == 'HR' || $_SESSION['user']['position'] == 'Regional Manager' || $_SESSION['user']['position'] == 'Approver') {?>
              <div class = 'row'>
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Pending Leave Approvals</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($to_show_leave) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title text-center">Name</th>
                            <th class="column-title text-center">Department </th>
                            <th class="column-title text-center">Role </th>
                            <th class="column-title text-center">leave type </th>
                            <th class="column-title text-center">More </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($to_show_leave); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class="text-center"><?=$to_remark[$h]['name']?> <?=$to_remark[$h]['fname']?> <?=$to_remark[$h]['mname']?></td>
                            <td class="text-center"><?=$to_remark[$h]['department']?></td>
                            <td class="text-center"><?=$to_remark[$h]['role']?></td>
                            <td class="text-center"><?=$to_show_leave[$h]['leave_type']?></td>
                            <td class="text-center"><a href="get_this_staff_leave.php/?leave_id=<?=base64_encode($to_show_leave[$h]['leave_id'])?>&staff_id=<?=base64_encode($to_show_leave[$h]['staff_id'])?>" class="btn btn-sm btn-success">View</a></td>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php } else { ?>
                       You have no leave to approve
                    <?php } ?>
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Pending Appraisal Approval</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($to_show_appraisal) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title text-center">Name</th>
                            <th class="column-title text-center">Department </th>
                            <th class="column-title text-center">Role </th>
                            <th class="column-title text-center">Appraisal period </th>
                            <th class="column-title text-center">More </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($to_show_appraisal); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class="text-center"><?=$to_remark[$h]['name']?></td>
                            <td class="text-center"><?=$to_remark[$h]['department']?></td>
                            <td class="text-center"><?=$to_remark[$h]['role']?></td>
                            <td class="text-center"><?=$to_show_appraisal[$h]['period']?></td>
                            <td class="text-center"><a href="get_this_staff_appraisal.php/?appraisal_id=<?=base64_encode($to_show_appraisal[$h]['appraisal_id'])?>&staff_id=<?=base64_encode($to_show_appraisal[$h]['staff_id'])?>" class="btn btn-sm btn-success">View</a></td>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php } else { ?>
                       You have no appraisal to remark
                    <?php } ?>
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Staff Audit</h2>
                    <div class="clearfix"></div>
                  </div>
                  <?php if(isset($_SESSION['msg'])) {?>
                        <div class="alert alert-primary" style="background-color: #007bff;font-size:16px;color:#fff" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>  

                  <div class="x_content">
                   <?php if(count($to_show_audit) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title text-center">Name</th>
                            <th class="column-title text-center">Department </th>
                            <th class="column-title text-center">Role </th>
                            <th class="column-title text-center">Audit Month  </th>
                            <th class="column-title text-center">Audit Year  </th>
                            <th class="column-title text-center">Remark  </th>
                            <th class="column-title text-center">More </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($to_show_audit); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class="text-center"><?=$to_show_audit[$h]['name']?> <?=$to_show_audit[$h]['fname']?></td>
                            <td class="text-center"><?=$to_show_audit[$h]['department']?></td>
                            <td class="text-center"><?=$to_show_audit[$h]['role']?></td>
                            <td class="text-center"><?=$to_show_audit[$h]['month']?></td>
                            <td class="text-center"><?=$to_show_audit[$h]['year']?></td>
                            <form action = 'process_branch_audit.php' method = "POST">
                            <td class="text-center">
                                <select name = "status" id = "status" class="form-control" required = 'true'>
                                    <option value=""></option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <!--option value="Pending">Pending</option-->
                                </select>
                            </td>
                            <td class="text-center">
                                <input style="display:none;" name="reply_id" value="<?=$to_show_audit[$h]['reply_id']?>" />
                                <button type ='submit' name='submit' class="btn btn-success">Update</button>
                                
                            </td>
                            </form>            
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php } else { ?>
                       You have no staff to audit
                    <?php } ?>
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Branch Staff of <?=$_SESSION['user']['position']?></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($branch_staff) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title text-center">Employee</th>
                            <th class="column-title text-center">Gender </th>
                            <th class="column-title text-center">Branch </th>
                            <th class="column-title text-center"> Job Role </th>
                            <th class="column-title text-center">Date of Birth </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($branch_staff); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class="text-center"><?=$branch_staff[$h]['name']?></td>
                            <td class="text-center"><?=$branch_staff[$h]['gender']?></td>
                            <td class="text-center"><?=$branch_staff[$h]['branch']?></td>
                            <td class="text-center"><?=$branch_staff[$h]['role']?></td>
                            <td class="text-center"><?=$branch_staff[$h]['dob']?></td>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php } else { ?>
                       No staff record
                    <?php } ?>
                  </div>
                </div>
            </div> 
            </div>
          <?php } ?>
          <?php if($_SESSION['user']['role'] == 'PM') {?>
          <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="height: 200px;">
                  <div class="x_title">
                    <h2>Special Access or Permission<small></small></h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                             <td scope="row">ID Processing Permission </td>
                             <td><?=$_SESSION['user']['id_card_permission'] == '1' ? 'Access Granted' : 'Restricted'?> </td>
                        </tr>
                        <tr>
                             <td scope="row">Appraisal Upload Permission </td>
                             <td><?=$_SESSION['user']['upload_appraisal'] == '1' ? 'Access Granted' : 'Restricted'?> </td>
                        </tr>
                        <tr>
                             <td scope="row">Payroll Management Permission </td>
                             <td><?=$_SESSION['user']['payroll_permission'] == '1' ? 'Access Granted' : 'Restricted'?> </td>
                        </tr>
                        <tr>
                             <td scope="row">Leave Management Permission </td>
                             <td><?=$_SESSION['user']['payroll_permission'] == '1' ? 'Access Granted' : 'Restricted'?> </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
          </div>  
          <div class="row">

            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="x_panel" style="height: 250px;">
                  <div class="x_title">
                    <h2>Appraisal Flow<small></small></h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-striped">
                      <tbody>
                        <?php if($_SESSION['user']['appraisal_flow']) {?>
                          <?php $appraisal = explode(";",$_SESSION['user']['appraisal_flow'])?>
                          <?php for($r = 0; $r < count($appraisal); $r++) {?>
                        <tr>
                          <?php if($appraisal[$r] != '') {?>
                            <?php $app_details = explode(":",$appraisal[$r]) ?>
                            <?php if(count($app_details) > 0) {?>
                             <td scope="row"><?=$app_details[0]?></td>
                             <td><?=$app_details[1]?> </td>
                        </tr>
                        <?php } } } }?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="x_panel" style="height: 250px;">
                  <div class="x_title">
                    <h2>Requisition Flow<small></small></h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-striped">
                      <tbody>
                        <?php if($_SESSION['user']['requisition_flow']) {?>
                          <?php $requisition = explode(";",$_SESSION['user']['requisition_flow'])?>
                          <?php for($r = 0; $r < count($requisition); $r++) {?>
                        <tr>
                          <?php if($requisition[$r] != '') {?>
                            <?php $req_details = explode(":",$requisition[$r]) ?>
                            <?php if(count($req_details) > 0) {?>
                             <td scope="row"><?=$req_details[0]?></td>
                             <td><?=$req_details[1]?> </td>
                        </tr>
                        <?php } } } }?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>


            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="x_panel" style="height: 250px;">
                  <div class="x_title">
                    <h2>Leave Flow<small></small></h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-striped">
                      <tbody>
                        <?php if($_SESSION['user']['leave_flow']) {?>
                          <?php $leave = explode(";",$_SESSION['user']['leave_flow'])?>
                          <?php for($r = 0; $r < count($leave); $r++) {?>
                        <tr>
                          <?php if($leave[$r] != '') {?>
                            <?php $leave_details = explode(":",$leave[$r]) ?>
                            <?php if(count($leave_details) > 0) {?>
                             <td scope="row"><?=$leave_details[0]?></td>
                             <td><?=$leave_details[1]?> </td>
                        </tr>
                        <?php } } } }?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>

          </div>
          <?php  } ?>
          <?php if($_SESSION['user']['category'] == 'staff' && $_SESSION['user']['position'] == '')  {?>
            <div class = 'row'>
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 style='color:#1ABB9C;font-weight:bolder'>Leave Application in <?=date('Y')?></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                  
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N </th>
                            <th class="column-title">Leave Type </th>
                            <th class="column-title">Days Allowed </th>
                            <th class="column-title">Days Taken </th>
                            <th class="column-title">Days Left </th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          
                          <?php for ($h = 0; $h < count($leave_type); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                                <?=$h + 1?>
                            </td>
                            <td class=""><?=$leave_type[$h]['leave_kind']?></td>
                            <td class=" "><?=$leave_type[$h]['days']?></td>
                            
                            <?php if($leave_type[$h]['leave_kind'] == 'Annual') { ?>
                              <td class=""><?=$counter_annual?></td>
                            <?php }else if($leave_type[$h]['leave_kind'] == 'Casual'){ ?>
                            <td class=" "><?=$counter_casual?></td>
                            <?php }else if($leave_type[$h]['leave_kind'] == 'Sick') {?>
                            <td class=" "><?=$counter_sick?></td>
                            <?php }else if($leave_type[$h]['leave_kind'] == 'Maternity' && $_SESSION['user']['gender'] == 'Female') {?>
                            <td class=" "><?=$counter_maternity?></td>
                            <?php } else if($leave_type[$h]['leave_kind'] == 'Exam') {?>
                            <td class=" "><?=$counter_exam?></td>
                            <?php } else if($leave_type[$h]['leave_kind'] == 'Paternity') {?>
                            <td class=" "><?=$counter_paternity?></td>
                            <?php }else if ($leave_type[$h]['leave_kind'] == 'Compassionate') { ?>
                               <td class=" "><?=(int)$leave_type[$h]['days'] - $counter_compasionate?></td>
                            <?php } ?>
                            <?php if($leave_type[$h]['leave_kind'] == 'Annual') { ?>
                            <td class=" "><?=(int)$leave_type[$h]['days'] -  $counter_annual?></td>
                            <?php }else if($leave_type[$h]['leave_kind'] == 'Casual'){ ?>
                            <td class=" "><?=(int)$leave_type[$h]['days'] - $counter_casual?></td>
                            <?php }else if($leave_type[$h]['leave_kind'] == 'Sick') {?>
                            <td class=" "><?=(int)$leave_type[$h]['days'] - $counter_sick?></td>
                            <?php }else if($leave_type[$h]['leave_kind'] == 'Maternity') {?>
                            <td class=" "><?=(int)$leave_type[$h]['days'] - $counter_maternity?></td>
                            <?php } else if($leave_type[$h]['leave_kind'] == 'Exam') {?>
                            <td class=" "><?=(int)$leave_type[$h]['days'] - $counter_exam?></td>
                            <?php } else if($leave_type[$h]['leave_kind'] == 'Paternity') {?>
                            <td class=" "><?=(int)$leave_type[$h]['days'] - $counter_paternity?></td>
                            <?php } else if ($leave_type[$h]['leave_kind'] == 'Compassionate') { ?>
                            <td class=" "><?=(int)$leave_type[$h]['days'] - $counter_compasionate?></td>
                            <?php } ?>
                          </tr>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php if(count($leave_type) == 0 ){ ?>
                       No record found
                    <?php } ?>
                  </div>
                </div>
            </div> 
            </div>
            <div class = 'row'>
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 style='color:#1ABB9C;font-weight:bolder'>Performance Appraisal for 2018 / 2019</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                  
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N </th>
                            <th class="column-title">Appraisal Period </th>
                            <th class="column-title">Self Rating </th>
                            <th class="column-title">Final Rating </th>
                            <th class="column-title">Recommendation </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($appraisal); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$appraisal[$h]['period']?></td>
                            <td class=" "></td>
                            <td class=" "></td>
                            <td class=" "></td>
                            <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <?php if(count($leave_type) == 0 ){ ?>
                       No record found
                    <?php } ?>
                  </div>
                </div>
            </div> 
            </div>
            <div class="row">

            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="x_panel" style="height: 250px;">
                  <div class="x_title">
                    <h2 style='color:#1ABB9C;font-weight:bolder'>Reporting Line for <?=$_SESSION['user']['name']?><small></small></h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-striped">
                      <tbody>
                        
                        <?php if($_SESSION['user']['flow_name'] != '') {?>
                          <?php $appraisal = explode(";",$_SESSION['user']['flow_name'])?>
                          <?php for($r = 0; $r < count($appraisal); $r++) {?>
                        <tr>
                          <?php if($appraisal[$r] != '') {?>
                            <?php $app_details = explode(":",$appraisal[$r]) ?>
                            <?php if(count($app_details) > 0) {?>
                             <td scope="row"><?=$app_details[0]?></td>
                             <td><?=$app_details[1]?> </td>
                        </tr>
                        <?php } } } }?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>


            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="x_panel" style="height: 250px;">
                  <div class="x_title">
                    <h2 style='color:#1ABB9C;font-weight:bolder'>Approvals<small></small></h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-striped">
                      <tbody>
                        <?php if($_SESSION['user']['leave_flow']) {?>
                          <?php $leave = explode(";",$_SESSION['user']['leave_flow'])?>
                          <?php for($r = 0; $r < count($leave); $r++) {?>
                        <tr>
                          <?php if($leave[$r] != '') {?>
                            <?php $leave_details = explode(":",$leave[$r]) ?>
                            <?php if(count($leave_details) > 0) {?>
                             <td scope="row"><?=$leave_details[0]?></td>
                             <td><?=$leave_details[1]?> </td>
                        </tr>
                        <?php } } } }?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>

          </div>
          <?php } ?>
          
          
         
          </div>
        </div>
<?php include "footer.php"?>
<script type="text/javascript" src="js/appraisal.js"></script>
<script>
  data = [];
  $(function(e){
    $.ajax({
      method: "get",
      url: "get_all_leave_request.php",
      success: function(resp){
        //alert(resp);
        data = resp.split(";");
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September","October","November", "December"],
        datasets: [{
            label: '# of Request',
            data: data,
            backgroundColor: [
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)'
            ],
            borderColor: [
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)',
                'rgba(115, 135, 156, 0.7)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                },gridLines: {
                  display: false ,
                  color: "#FFFFFF"
                },
            }],
            xAxes: [{
                ticks: {
                    beginAtZero:true
                },gridLines: {
                  display: false ,
                  color: "#f8fafc"
                },
            }]
        }
    }
});
      }
    })
  });
console.log(data);  
</script>
        
