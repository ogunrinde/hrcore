<?php 
  include 'connection.php';
  session_start();
  if(isset($_POST['submit'])){
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    if($category == '') {
    	$_SESSION['msg'] = 'Kindly select a category';
    	header("Location: basic_settings.php");
    	return false;
    }else {
       updateUser($conn,$category);
    }
  }
  function updateUser($conn, $category){
  	 $sql = "UPDATE users SET category = '".$category."', first_time_loggin = '1' WHERE email = '".$_SESSION['user']['email']."'";
        if (mysqli_query($conn, $sql)) {
            echo "Record updated successfully";
            $_SESSION['user'][0]['category'] = $category;
            if($category == 'admin') header("Location: admin_settings.php");
            else if($category == 'staff') header("Location: staff_settings.php");
            else if($category == 'lManager' || $category == 'bManager') header("Location: manager_account.php");
        } else {
            echo "Error updating record: " . mysqli_error($conn);
            header("Location: settings.php");
        }
  }
?>