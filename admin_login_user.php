<?php
  include "connection.php";
  session_start();
  $user = [];
  if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    isUserExist($conn,$email, $password);
  }
  function isUserExist($conn,$email, $password){
    echo $email;
    $query = "SELECT * from users WHERE email = '$email'";
  	$result = mysqli_query($conn, $query);
  	if(mysqli_num_rows($result) > 0){
  		$row = mysqli_fetch_assoc($result);
      //print_r($email);
  		$user[] = $row;
  		 $verify = password_verify($password,$row['password']);
         if($verify){
           if($user[0]['first_time_loggin'] == '1'){
              $_SESSION['user'] = $user[0];
              updateUser($conn,'admin');
              header("Location: admin_settings");
            }else {
            	$_SESSION['user'] = $user[0];
                //function has_admin_changed_approvals();
                header("Location: dashboard");
            }
         }else {
              $_SESSION['msg'] = "Username and password does not match";
              header("Location: admin_login.php");
         }
  	}else {
       $_SESSION['msg'] = "No username with such email, kindly create an account";
       header("Location: admin_login");
    }
  }
   function updateUser($conn, $category){
     $sql = "UPDATE users SET category = '".$category."', first_time_loggin = '1' WHERE email = '".$_SESSION['user']['email']."'";
        if (mysqli_query($conn, $sql)) {
            echo "Record updated successfully";
            $_SESSION['user']['category'] = $category;
        } else {
            echo "Error updating record: " . mysqli_error($conn);
            //header("Location: settings");
        }
  }
?>