<?php
  include "connection.php";
  include "process_email.php";
  session_start();
  $exist = 1;
  if(isset($_POST['submit'])){
    $employee_ID = mysqli_real_escape_string($conn, $_POST['employee_ID']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    //$password = mysqli_real_escape_string($conn, $_POST['password']);
    //$cpassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $company = mysqli_real_escape_string($conn, $_POST['user_company']);
    /*if($password != $cpassword){
    	 $_SESSION['msg'] = 'Password does not match';
    	 header("Location: register.php");
    	 return false;
    }*/
    if($employee_ID == ''){
         $_SESSION['msg'] = 'Employee ID is Empty';
    	 header("Location: register.php");
    	 return false;
    }
    if($company == ''){
         $_SESSION['msg'] = 'Company Field is Empty';
    	 header("Location: register.php");
    	 return false;
    }
    /*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $_SESSION['msg'] = 'Input is not a valid email';
         header("Location: register.php");
         return false;
    }*/
    //$cpassword = $password;
    if($company == 'Polaris Bank Limited'){
        $pass = 'polaris';
        $cpassword = 'polaris';
    }else {
        $pass = 'selfservice';
        $cpassword = 'selfservice';
    }
    //$cpassword = 'selfservice';
    $password = password_hash(strtolower($pass), PASSWORD_DEFAULT);
   
    $exist = isAccountCreated($conn, $employee_ID);
    if ($exist == 0) {
    	$_SESSION['msg'] = "User already exist, proceed to log In";
        header("Location: create_user.php");
    }else{
        $admin_id = findPM($conn,$company);
    	$sql = "INSERT INTO users (name, email, password, role, company_name, category,first_time_loggin,department,employee_ID,profile_image,admin_id,lManager,bManager,cpassword,user_company, active)
          VALUES ('', '".$email."', '".$password."','','".$company."','staff','1','','".$employee_ID."','user_profile.png','".$admin_id."','','','".$cpassword."','".$company."','1')";
          if (mysqli_query($conn,$sql ) === TRUE) {
              $_SESSION['msg'] = "Account created successfully, kindly login";
              header("Location: create_user.php");
          } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              //$_SESSION['msg'] = "Error creating account";
              //header("Location: register.php");
          }
          $msg = "<div><p>Hello ".$email.",</p><p>Welcome to HRCORE, An account has been created for you by your People Manager</p><p>Your password is: <b>".$pass."</b> and User ID is: <b>".$employee_ID."</b>.</p><p>Kindly follow the link below to log In and complete other required Information.</p>  <a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'https://www.hrcore.ng/outsourcing'>Log In to Continue</a></div>";
           if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                process_data($conn,$email,$msg,'New Account');
               $_SESSION['msg'] = "Account Details has been sent to the Employee by Email";
               //header("Location: staff_leave_request.php");
            }
    }
  }
  function findPM($conn,$company){
      //$admin_id = $_SESSION['user']['admin_id'];
      $query = "SELECT * FROM users WHERE company_name = '".$company."' LIMIT 1";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result)> 0){
          while($row = mysqli_fetch_assoc($result)) {
            $admin_id = $row['admin_id'];
          }
      }
      return $admin_id;
  }
  function isAccountCreated($conn, $employee_ID){
  	$query = "SELECT * from users WHERE employee_ID = '".$employee_ID."'";
  	$result = mysqli_query($conn, $query);
  	if(mysqli_num_rows($result) > 0){
  		return 0;
  	}
  	return 1;
  }
?>