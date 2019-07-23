<?php
  include "connection.php";
  session_start();
  $user = [];
  if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = strtolower($email);
    isUserExist($conn,$email, $password);
  }
  function isUserExist($conn,$email, $password){
    //echo $email;
    $query = "SELECT * from users WHERE employee_ID = '$email'";
  	$result = mysqli_query($conn, $query);
  	if(mysqli_num_rows($result) > 0){
  		$row = mysqli_fetch_assoc($result);
  		
  		$user[] = $row;
  		 $verify = password_verify(strtolower($password),$row['password']);
         if($verify){
           if($user[0]['first_time_loggin'] == '1'){
           	    $_SESSION['user'] = $user[0];
                updateUser($conn, 'staff');
                //echo "aaaaa";
      //print_r($email);
                if($_SESSION['user']['category'] == 'staff') header("Location: staff_settings");
                if($_SESSION['user']['category'] == 'admin') header("Location: admin_settings");
                //header("Location: basic_settings");
            }else {
            	$_SESSION['user'] = $user[0];
            	print_r($_SESSION[0]);
            	if($_SESSION['user']['position'] == 'supervisor' || $_SESSION['user']['payroll_only'] =='1'){
            	    header("Location: masterlist");
            	    return false;
            	}
            	  
                //function has_admin_changed_approvals();
                /*$msg = '';
                if($_SESSION['user']['phone_number'] == '') $msg .= '<p>Phone Number,';
                if($_SESSION['user']['branch'] == '') $msg .= ' Branch, ';
                if($_SESSION['user']['marital_status'] == '') $msg .= 'Marital Status, ';
                if($_SESSION['user']['dob'] == '') $msg .= 'Date of Birth, ';
                if($_SESSION['user']['department'] == '') $msg .= 'Department, ';
                if($_SESSION['user']['lga'] == '') $msg .= 'Local Government Area, ';
                if($_SESSION['user']['sorigin'] == '') $msg .= ' State of Origin, '; 
                if($_SESSION['user']['address'] == '') $msg .= 'Address, ';
                if($_SESSION['user']['cdate_of_employeement'] == '') $msg .= 'Date of Employment ';
                if($_SESSION['user']['leave_flow'] == '') $msg .= 'Leave Approvers';
                if($msg != '' && $_SESSION['user']['category'] == 'staff'){
                     $_SESSION['msg'] = '<h4>Kindly input the following Information:</h4><p>'.$msg.'</p>';
                     header("Location:staff_settings.php");
                }else */
                header("Location: dashboard");
            }
         }else {
              $_SESSION['msg'] = "Username and password does not match";
              header("Location: login");
         }
  	}else {
       $_SESSION['msg'] = "No username with such email, kindly create an account";
       header("Location: login");
    }
  }
  function updateUser($conn, $category){
     $msg = 0;
     $sql = "UPDATE users SET category = '".$category."', first_time_loggin = '1' WHERE email = '".$_SESSION['user']['email']."'";
        if (mysqli_query($conn, $sql)) {
            $msg = 1;
            //echo "Record updated successfully";
            $_SESSION['user']['category'] = $category;
        } else {
            $msg = 0;
            //echo "Error updating record: " . mysqli_error($conn);
            //header("Location: settings.php");
        }
        return $msg;
  }
?>