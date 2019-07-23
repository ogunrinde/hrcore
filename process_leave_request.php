<?php
  include "connection.php";
  session_start();
  include "process_email.php";
  //session_start();
  include "check_requirement_leave.php";
  //session_start();
    $msg = '';
    if($_SESSION['user']['phone_number'] == '') $msg .= '<p>Phone Number,';
    if($_SESSION['user']['branch'] == '') $msg .= ' Branch, ';
    if(strtolower($_SESSION['user']['branch']) == 'not updated') $msg .= ' Branch, ';
    if($_SESSION['user']['name'] == '') $msg .= ' Surname, ';
    if($_SESSION['user']['fname'] == '') $msg .= ' First Name, ';
    if($_SESSION['user']['mname'] == '') $msg .= ' Middle Name, ';
    if($_SESSION['user']['marital_status'] == '') $msg .= 'Marital Status, ';
    if($_SESSION['user']['dob'] == '') $msg .= 'Date of Birth, ';
    if($_SESSION['user']['department'] == '') $msg .= 'Department, ';
    if($_SESSION['user']['lga'] == '') $msg .= 'Local Government Area, ';
    if($_SESSION['user']['sorigin'] == '') $msg .= ' State of Origin, '; 
    if($_SESSION['user']['address'] == '') $msg .= 'Address, ';
    if($_SESSION['user']['cdate_of_employeement'] == '') $msg .= 'Date of Employment, ';
   
if($_SESSION['user']['leave_flow'] == '') $msg .= 'Leave Approvers';
if($_SESSION['user']['leave_flow'] != ''){
    $manager_count = explode(';',$_SESSION['user']['leave_flow']);
    if(count($manager_count) < 2) $msg .= 'Two Approvals are required';
}
    if($msg != '') {
        header("Location: staff_leave_request.php");
        return false;
    }
   function one_year($start_date,$end_date){
     $counter = 0;
     while(strtotime($start_date) <= strtotime($end_date)){
            $counter++;
        $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
    
      }
      return $counter;
    }
    function getManagerDetails($conn,$email){
        
      $sql = "SELECT * from users WHERE email = '".$email."' LIMIT 1";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result)> 0){
        while($row = mysqli_fetch_assoc($result)) {
          $manager[] = $row;
        }
      }
        return $manager;
    }
  if(isset($_POST['submit'])){
    if($_SESSION['user']['cdate_of_employeement'] == ''){
        $_SESSION['msg'] = "You can not process leave request, because you haven't input the Date of Employment. Kindly update this record on the settings Page";
         header("Location: staff_settings.php");
         //print_r($_SESSION['user']['leave_flow']);
         return false;
    }  
    if($_SESSION['user']['leave_flow'] == ''){
     $_SESSION['msg'] = "You can not process leave request, because you don't have approvals. Kindly add leave approvals on the setting page";
     header("Location: staff_settings.php");
     //print_r($_SESSION['user']['leave_flow']);
     return false;
    }
    $total_days = one_year($_SESSION['user']['cdate_of_employeement'],date('Y-m-d'));
    $leave_type = mysqli_real_escape_string($conn, $_POST['leave_type']);
    if((int)$total_days < 365 && $leave_type != 'Leave Without Pay') {
        $_SESSION['msg'] = 'You can not apply for leave now, until after 1 year of Employment';
         header("Location: staff_leave_request.php");
        return false;
    }
     $leave_type = mysqli_real_escape_string($conn, $_POST['leave_type']);
     $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
     $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
     $justification = mysqli_real_escape_string($conn, $_POST['justification']);
     $reliever_required = mysqli_real_escape_string($conn, $_POST['reliever_required']);
     $reliever_source = mysqli_real_escape_string($conn, $_POST['reliever_source']);
     $reliever_name = mysqli_real_escape_string($conn, $_POST['reliever_name']);
     $reliever_email = mysqli_real_escape_string($conn, $_POST['reliever_email']);
     $reliever_phone = mysqli_real_escape_string($conn, $_POST['reliever_phone']);
     $staff_id = $_SESSION['user']['id'];
     $year = date('Y');
     if($leave_type == ''){
        $_SESSION['msg'] = 'kindly specify the type of leave';
        header("Location: staff_leave_request.php");
        return false;
     }
     if($start_date == ''){
        $_SESSION['msg'] = 'kindly specify the starting date';
        header("Location: staff_leave_request.php");
        return false;
     }
     if($end_date == ''){
        $_SESSION['msg'] = 'kindly specify the end date';
        header("Location: staff_leave_request.php");
        return false;
     }
     if($leave_type != '' && $start_date != '' && $end_date != ''){
      if(strtotime($start_date) < strtotime(date('Y-m-d'))){
        $_SESSION['msg'] = 'Please select the appropriate leave Start Date';
        header("Location: staff_leave_request.php");
        return false;
      }
      if(strtotime($end_date) < strtotime($start_date)){
        $_SESSION['msg'] = 'Please select the appropriate leave End Date';
        header("Location: staff_leave_request.php");
        return false;
      }
      /*if(strtotime($end_date) == strtotime($start_date)){
        $_SESSION['msg'] = 'Please select the appropriate leave Start and End Date';
        header("Location: staff_leave_request.php");
        return false;
      }*/
      if(date("N",strtotime($start_date))>5){
          $_SESSION['msg'] = 'You can not start your leave on Saturday or Sunday, kindly select the appropriate start Date';
          header("Location: staff_leave_request.php");
          return false;
      }
      if(date("N",strtotime($end_date))>5){
          $_SESSION['msg'] = 'You can not end your leave on Saturday or Sunday, kindly select the appropriate End Date';
          header("Location: staff_leave_request.php");
          return false;
      }
      if($leave_type == 'Annual'){
        //echo "aaaaaaaaaaaaaa<br>";
        $state = get_annual_leave_and_process($conn,$staff_id,$leave_type,$year, $start_date,$end_date,$_SESSION['user']);
        //echo "aaaaaaaaaaaaaappppppppppppppppp<br>";
        //echo $state;
        if($state != '1'){
          $_SESSION['msg'] = $state;
          header("Location: staff_leave_request.php");
          //echo 'aaaaaaaaaaaaaaaaaa';
          return false;
        }
      }else if($leave_type == 'Casual'){
        $state = check_annual_first_before_casual($conn,$staff_id,$year,$start_date,$end_date,$_SESSION['user'],$leave_type);
        if($state != 1){
          $_SESSION['msg'] = $state;
          header("Location: staff_leave_request.php");
          return false;
        }
      }else {
          $state = other_leave_process($conn,$staff_id,$leave_type,$year, $start_date,$end_date,$_SESSION['user']);
        if($state != 1){
          $_SESSION['msg'] = $state;
          header("Location: staff_leave_request.php");
          return false;
        }
      }
      //return 'aaaaaaaaa';
      $sql = "INSERT INTO leaves (leave_type, start_date, end_date, justification, require_reliever, reliever_source,reliever_name,reliever_email,reliever_phone,stage,status,date_created,staff_id,admin_id,flow,processed,year)
      VALUES ('".$leave_type."', '".$start_date."', '".$end_date."','".$justification."','".$reliever_required."','".$reliever_source."','".$reliever_name."','".$reliever_email."','".$reliever_phone."','Pending','','".date('Y-m-d')."','".$_SESSION['user']['id']."','".$_SESSION['user']['admin_id']."', '".$_SESSION['user']['leave_flow']."','Pending','".date('Y')."')";
          if (mysqli_query($conn, $sql)) {
               if($_SESSION['user']['leave_flow'] == ""){ 
               $_SESSION['msg'] = "Your leave request is under processing";
               header("Location: staff_leave_request.php");return false;}
               $approvals = explode(";",$_SESSION['user']['leave_flow']);
               //print_r($approvals);
               if(count($approvals) == 0) { 
               $_SESSION['msg'] = "Your Leave Request has been sent to your Leave Approval";
               header("Location: staff_leave_request.php");return false;}
               $get_first_approval_details = explode(":",$approvals[0]);
               if(count($get_first_approval_details) > 1) $get_first_approval_email = trim($get_first_approval_details[1]);
               $manager = getManagerDetails($conn,$get_first_approval_email);
               //echo $get_first_approval_email;
               $employee_ID = isset($manager[0]['employee_ID']) ? $manager[0]['employee_ID'] : '';
               $password = isset($manager[0]['cpassword']) ? $manager[0]['cpassword'] : '';
               $msg = "<div><p>Good Day,</p><p>".$_SESSION['user']['name']." ".$_SESSION['user']['fname']." ".$_SESSION['user']['mname']." has requested for ".$leave_type." leave. As the ".$get_first_approval_details[0].", kindly log In and take the neccessary action on this request.</p><p style='color:red;'>Your login Details is username : ".$employee_ID." and Password: ".$password."</p> <p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'https://www.hrcore.ng/outsourcing/login'>Log In to view</a></p></div>";
               if (filter_var($get_first_approval_email, FILTER_VALIDATE_EMAIL)) {
                    //$manager = getManagerDetails($conn,$get_first_approval_email);
                    process_data($conn,$get_first_approval_email,$msg,'Leave Request');
                   $_SESSION['msg'] = "Your leave request is under processing";
                   header("Location: staff_leave_request.php");
                }
              /*$_SESSION['msg'] = "Appraisal under processing";
              $_SESSION['is_just_filled'] = true;
              header("Location: /selfservice/staff_appraisal.php");*/
            } else {
              //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              $_SESSION['msg'] = "Error while saving leave request,plese try again later";
              header("Location: staff_leave_request.php");
              //Your leave request is under processing
          }
     }
  }
?>