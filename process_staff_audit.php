<?php
include "connection.php";
session_start();
include "process_email.php";

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
    if($_SESSION['user']['leave_flow'] == '') $msg .= 'Manager Details' ;
    if($_SESSION['user']['leave_flow'] != ''){
        $manager_count = explode(';',$_SESSION['user']['leave_flow']);
        if(count($manager_count) < 2) $msg .= 'Two Approvals are required';
    }
    if($msg != '') {
        header("Location: staff_audit.php");
        return false;
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
	$month = mysqli_real_escape_string($conn, $_POST['month']);
	$year = mysqli_real_escape_string($conn, $_POST['year']);
  $company = mysqli_real_escape_string($conn, $_POST['user_company']);
	//$staff_id = $_SESSION['user']['id'];
	 $sql = "INSERT INTO staff_audit (month, year,staff_id, admin_id, company)
      VALUES ('".$month."', '".$year."','0','".$_SESSION['user']['id']."', '".$company."')";
        if (mysqli_query($conn, $sql)) {
          $_SESSION['msg'] = "Your staff audit Created";
          //$last_id = $conn->insert_id;
        }else {
           $_SESSION['msg'] = "Error while update account, please try again later";
       }
       //print_r($_SESSION['user']);
       header("Location: /outsourcing/begin_audit");
       //return false;
}else if(isset($_POST['audit'])) {
	$audit_id = mysqli_real_escape_string($conn, $_POST['audit_id']);
	$sql = "INSERT INTO staff_audit_replies (audit_id,staff_id, admin_id, branch_manager_replies)
      VALUES ('".$audit_id."', '".$_SESSION['user']['id']."','".$_SESSION['user']['admin_id']."','Pending')";
        if (mysqli_query($conn, $sql)) {
          
          if($_SESSION['user']['leave_flow'] != ""){
              $flow = explode(";",$_SESSION['user']['leave_flow']);
              for($t = 0; $t < count($flow); $t++){
                  $each_flow = explode(":",$flow[$t]);
                  if(count($each_flow) > 1){
                      
                      if($each_flow[0] == 'Branch Manager'){
                          $get_first_approval_email = trim($each_flow[1]);
                          $manager = getManagerDetails($conn,$get_first_approval_email);
                           //echo $get_first_approval_email;
                           $employee_ID = isset($manager[0]['employee_ID']) ? $manager[0]['employee_ID'] : '';
                           $password = isset($manager[0]['cpassword']) ? $manager[0]['cpassword'] : '';
                          $msg = "<div><p>Good Day,</p><p>You have a pending staff audit on behalf of ".$_SESSION['user']['name']." ".$_SESSION['user']['fname']." for the month of ".$month." ".$year.". kindly log In and take the neccessary action on this request.</p><p style='color:red;'>Your login Details is employee ID : ".$employee_ID." and Password: ".$password."</p> <p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'https://www.hrcore.ng/outsourcing/login'>Log In to view</a></p></div>";
                               if (filter_var($get_first_approval_email, FILTER_VALIDATE_EMAIL)) {
                                    //$manager = getManagerDetails($conn,$get_first_approval_email);
                                    process_data($conn,$get_first_approval_email,$msg,'Staff Audit');
                                   $_SESSION['msg'] = "Your record has been updated";
                                }
                      }
                  }
              }
          }
          //$last_id = $conn->insert_id;
        }else {
           $_SESSION['msg'] = "Error while update account, please try again later";
       }
       header("Location: /outsourcing/staff_audit");
}

?>