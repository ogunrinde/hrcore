<?php
include "connection.php";
session_start();
if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['pm_email']);
    $pm_name = mysqli_real_escape_string($conn, $_POST['pm_name']);
    $pm_phone_number = mysqli_real_escape_string($conn, $_POST['pm_phone_number']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpasssword']);
    if($email == ''){
        $_SESSION['msg'] = 'Please input the email address';
        header("Location: create_pm.php");
        return false;
    }else if($pm_name == ""){
        $_SESSION['msg'] = 'Please input the people manager name';
        header("Location: create_pm.php");
        return false;
    }
    if($password != $cpassword){
        $_SESSION['msg'] = 'Password Mismatch';
        header("Location: create_pm.php");
        return false;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "SELECT * FROM users WHERE email = '".$email."'";
    $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      $_SESSION['msg'] = 'User already created, please proceed to log In';
  }else {
      $sql = "INSERT INTO users (name, email, password, role, company_name, category,first_time_loggin,department,employee_ID,profile_image,admin_id,lManager,bManager,phone_number)
          VALUES ('".$pm_name."', '".$email."', '".$password."','PM','ICS Limited','admin','0','People Management','".$email."','user_profile.png','','','','".$pm_phone_number."')";
          if (mysqli_query($conn,$sql ) === TRUE) {
              $_SESSION['msg'] = "Account created successfully, kindly login";
              header("Location: create_pm.php");
          } else {
              //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              $_SESSION['msg'] = "Error creating account";
              header("Location: create_pm.php");
          }
  }
}


?>