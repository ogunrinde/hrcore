<?php
 ob_start();
 include "connection.php";
 include "process_email.php";
 session_start();
 if(isset($_POST['submit'])){
  if($_SESSION['user']['appraisal_flow'] == ''){
     $_SESSION['msg'] = "You can not process appraisal, because you don't have approvals. Kindly add appraisal on the setting page";
     header("Location: staff_settings.php");
     //return false;
  }
 	$appraisal_id = mysqli_real_escape_string($conn, $_POST['appraisal_id']);
 	$all_remark = mysqli_real_escape_string($conn, $_POST['all_remark']);
 	$all_justification = mysqli_real_escape_string($conn, $_POST['all_justification']);
  //$appraisal_flow = getappraisal_flow($conn);
  $appraisal_flow = $_SESSION['user']['appraisal_flow'];
 	 $sql = "INSERT INTO appraisal_replies (appraisal_id, staff_id, admin_id, staff_remarks, staff_justifications, date_created, comments_flow)
          VALUES ('".$appraisal_id."', '".$_SESSION['user']['id']."', '".$_SESSION['user']['admin_id']."','".$all_remark."','".$all_justification."','".date('Y-m-d')."','".$appraisal_flow."')";
            if (mysqli_query($conn, $sql)) {
               if($_SESSION['user']['appraisal_flow'] == ""){ 
               $_SESSION['msg'] = "Appraisal under processing";
               $_SESSION['is_just_filled'] = true;
               header("Location: staff_appraisal.php");return false;}
               $approvals = explode(";",$_SESSION['user']['appraisal_flow']);
               if(count($approvals) == 0) { 
               $_SESSION['msg'] = "Appraisal under processing";
               $_SESSION['is_just_filled'] = true;
               header("Location: staff_appraisal.php");}
               $get_first_approval_details = explode(":",$approvals[0]);
               if(count($get_first_approval_details) > 1) $get_first_approval_email = $get_first_approval_details[1];
               $msg = "<div><p>Good Day,</p><p>".$_SESSION['user']['name']." has completed the appraisal for the period. As the ".$get_first_approval_details[0].", kindly log In and add your remark to this staff appraisal.</p><p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'https://www.hrcore.ng'>Log In to view</a></p></div>";
               if (filter_var($get_first_approval_email, FILTER_VALIDATE_EMAIL)) {
                  process_data($conn,$get_first_approval_email,$msg,'Appraisal');
                   $_SESSION['msg'] = "Appraisal under processing";
                   $_SESSION['is_just_filled'] = true;
                   header("Location: staff_appraisal.php");
                }
              /*$_SESSION['msg'] = "Appraisal under processing";
              $_SESSION['is_just_filled'] = true;
              header("Location: /outsourcing/staff_appraisal.php");*/
            }else {
              //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
               $_SESSION['msg'] = "Error whiling saving appraisal, please try again later";
               header("Location: staff_appraisal.php");
           }
    //echo "<script type='text/javascript'> document.location = 'staff_appraisal.php'; </script>";
    ob_end_flush();
 }
 function getappraisal_flow($conn){
  $data = [];
  $app_query = "SELECT * FROM company WHERE admin_id = '".$_SESSION['user']['admin_id']."'";
    $result = mysqli_query($conn, $app_query);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data[0]['appraisal_flow'];
    }
    return '';
}
?>