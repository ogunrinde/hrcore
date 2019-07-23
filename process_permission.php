<?php
  include "connection.php";
  include "connection.php";
  include "process_email.php";
  session_start();
  if(isset($_POST['id_request'])){
  	$department = mysqli_real_escape_string($conn, $_POST['department']);
  	$staff_email = mysqli_real_escape_string($conn, $_POST['staff']);
  	if($department != ""){
  		$sql = "UPDATE users SET id_card_permission = '1' WHERE department = '".$department."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "ID Card Processing permission granted to $department";
        } else {
            $_SESSION['msg'] = "Error while granting permission to $department";
            
        }
  	}
  	if($staff_email != "") {
  		$sql = "UPDATE users SET id_card_permission = '1' WHERE email = '".$staff_email."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "ID Card Processing permission granted to user";
            $msg = "The admin has granted you permission to process ID Card request.";
            process_data($conn,$staff_email,$msg,'ID Processing Privilege');
        } else {
            $_SESSION['msg'] = "Error while granting permission to user";
            
        }
        //header("Location: permission.php");
  	}
  	header("Location: permission.php");
  }else if(isset($_POST['upload_appraisal'])){
  	$department = mysqli_real_escape_string($conn, $_POST['department']);
  	$staff_email = mysqli_real_escape_string($conn, $_POST['staff']);
  	if($department != ""){
  		$sql = "UPDATE users SET upload_appraisal = '1' WHERE department = '".$department."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Permission granted to $department";
        } else {
            $_SESSION['msg'] = "Error while granting permission to $department";
            
        }
  	}
  	if($staff_email != "") {
  		$sql = "UPDATE users SET upload_appraisal = '1' WHERE email = '".$staff_email."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "permission granted to user";
        } else {
            $_SESSION['msg'] = "Error while granting permission to user";
            
        }
        //header("Location: permission.php");
  	}
  	header("Location: permission.php");
  }else if(isset($_POST['payroll'])){
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $staff_email = mysqli_real_escape_string($conn, $_POST['staff']);
    if($department != ""){
      $sql = "UPDATE users SET payroll_permission = '1' WHERE department = '".$department."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Payroll Processing permission granted to $department";
        } else {
            $_SESSION['msg'] = "Error while granting permission to $department";
            
        }
    }
    if($staff_email != "") {
      $sql = "UPDATE users SET payroll_permission = '1' WHERE email = '".$staff_email."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Payroll Processing permission granted to user";
            $msg = "The admin has granted you permission to manage employee payroll.";
            process_data($conn,$staff_email,$msg,'ID Processing Privilege');
        } else {
            $_SESSION['msg'] = "Error while granting permission to user";
            
        }
        //header("Location: permission.php");
    }
    header("Location: permission.php");
  }else if(isset($_POST['leave'])){
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $staff_email = mysqli_real_escape_string($conn, $_POST['staff']);
    if($department != ""){
      $sql = "UPDATE users SET leave_processing_permission = '1' WHERE department = '".$department."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "ID Card Processing permission granted to $department";
        } else {
            $_SESSION['msg'] = "Error while granting permission to $department";
            
        }
    }
    if($staff_email != "") {
      $sql = "UPDATE users SET leave_processing_permission = '1' WHERE email = '".$staff_email."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Leave Processing privilege has been granted to user";
            $msg = "The admin has granted you permission to process Leave Request.";
            process_data($conn,$staff_email,$msg,'Leave Processing Privilege');
        } else {
            $_SESSION['msg'] = "Error while granting permission to user";
            
        }
        //header("Location: permission.php");
    }
    header("Location: permission.php");
  }else if(isset($_POST['cash_request'])){
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $staff_email = mysqli_real_escape_string($conn, $_POST['staff']);
    if($department != ""){
      $sql = "UPDATE users SET cash_processing_permission = '1' WHERE department = '".$department."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Cash Request Processing permission granted to $department";
        } else {
            $_SESSION['msg'] = "Error while granting permission to $department";
            
        }
    }
    if($staff_email != "") {
      $sql = "UPDATE users SET cash_processing_permission = '1' WHERE email = '".$staff_email."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Cash Request Processing privilege has been granted to user";
            $msg = "The admin has granted you permission to process cash request.";
            process_data($conn,$staff_email,$msg,'Cash Processing Privilege');
        } else {
            $_SESSION['msg'] = "Error while granting permission to user";
            
        }
        //header("Location: permission.php");
    }
    header("Location: permission.php");
  }

?>