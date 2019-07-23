<?php
 ob_start();
 include "connection.php";
 include "process_email.php";
 session_start();
 if(isset($_POST['submit'])){
  if($_SESSION['user']['appraisal_flow'] == ''){
     $_SESSION['msg'] = "You can not process appraisal, because you don't have approvals. Kindly add appraisal on the setting page";
     header("Location: staff_settings.php");
     return false;
  }
 	$appraisal_id = mysqli_real_escape_string($conn, $_POST['appraisal_id']);
 	//$appraisal_flow = getappraisal_flow($conn);
  $appraisal_flow = $_SESSION['user']['appraisal_flow'];
    $present = false;
    if(isset($_FILES['appraisal'])){
       if($_FILES['appraisal']['name'] == null) {
          $msg = 'Please attached the filled appraisal';
       }else {
       $error = array();
       $file_ = explode('.',$_FILES['appraisal']['name'])[0];
       $file_ext = explode('.',$_FILES['appraisal']['name'])[1];
       //$i = rand(1,9) * 9999999;
       $file_name = $file_.'_'.strtotime(date('Y-m-d')).'.'.$file_ext;
       $file_size = $_FILES['appraisal']['size'];
       $file_tmp = $_FILES['appraisal']['tmp_name'];
       $file_type = $_FILES['appraisal']['type'];
       //$file_ext = explode('.',$_FILES['image']['name'])[1];
       $extensions = array('xlsx','csv','docx','doc','txt');
       if(in_array($file_ext,$extensions) === false){
        $errors[] = "extension not allowed, please select a docx, xlsx, txt or doc file.";
       }
       if($file_size > 209752){
        $errors[] = "File size too large";
       }
       if(empty($errors)==true){
         move_uploaded_file($file_tmp,"document/".$file_name);
          $app_query = "SELECT * FROM appraisal_replies WHERE appraisal_id = '".$appraisal_id."' && staff_id = '".$_SESSION['user']['id']."'";
           $app_result = mysqli_query($conn, $app_query);
           if(mysqli_num_rows($app_result) > 0){
            while($row = mysqli_fetch_assoc($app_result)) {
              $present = true;
            }
          }
          if($present == true){
              $sql = "UPDATE appraisal_replies SET document_uploaded_by_staff = '".$file_name."', comments_flow = '".$appraisal_flow."' Where staff_id = '".$_SESSION['user']['id']."' && appraisal_id = '".$appraisal_id."'";
                if (mysqli_query($conn, $sql)) {
                  $_SESSION['msg'] = "Appraisal file uploaded";
                  $_SESSION['is_just_filled'] = true;
                  header("Location: /outsourcing/staff_appraisal.php");
                }else {
                  //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                  $_SESSION['msg'] = "Error uploading appraisal, kindly try again later";
                  $_SESSION['is_just_filled'] = true;
                  header("Location: /outsourcing/staff_appraisal.php");
                }        
          }else {
             $sql = "INSERT INTO appraisal_replies (staff_id, appraisal_id, date_created, document_uploaded_by_staff, stage,comments_flow,admin_id)
                VALUES ('".$_SESSION['user']['id']."', '".$_POST['appraisal_id']."', '".date('Y-m-d')."','".$file_name."','','".$appraisal_flow."','".$_SESSION['user']['admin_id']."')";
                if (mysqli_query($conn, $sql)) {
                 if($_SESSION['user']['appraisal_flow'] == ""){ 
                 $_SESSION['msg'] = "Appraisal under processing";
                 $_SESSION['is_just_filled'] = true;
                 header("Location: staff_appraisal.php");return false;}
                 $approvals = explode(";",$_SESSION['user']['appraisal_flow']);
                 if(count($approvals) == 0) { 
                 $_SESSION['msg'] = "Appraisal under processing";
                 $_SESSION['is_just_filled'] = true;
                 header("Location: staff_appraisal.php");return false;}
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
            } else {
                    //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    //$_SESSION['msg'] = "Error creating account";
                    $_SESSION['is_just_filled'] = true;
                    header("Location: /outsourcing/staff_appraisal.php");
                }
          }
          /*$msg = "<div><p>Dear Line Manager,</p><p>".$_SESSION['name']." has completed the appraisal for the year, kindly use the link below to add your remark.</p><p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'http://www.multichase.com/ess/manager.php/?Manager=lManager&staff_id=".base64_encode($_SESSION['id'])."&appraisal_id=".base64_encode($_POST['appraisal_id'])."'>View Appraisal</a></p></div>";
            sendmail($_SESSION['lManager'], $msg,'Appraisal Review');
            $_SESSION["special_msg"] =  "Appraisal has been sent to your line Manager.";*/
       }else {
         $msg = $errors[0];
         $_SESSION['msg'] = $msg;
       }
    }
  }
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