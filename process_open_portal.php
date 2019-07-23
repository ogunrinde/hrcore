<?php
 include 'connection.php';
 session_start();
 if(isset($_POST['submit'])){
 	$opening_date = mysqli_real_escape_string($conn, $_POST['opening_date']);
 	$closing_date = mysqli_real_escape_string($conn, $_POST['closing_date']);
 	$open_for = mysqli_real_escape_string($conn, $_POST['open_for']);
 	$info_id = mysqli_real_escape_string($conn, $_POST['info_id']);
    echo $open_for;
 	if($opening_date != '' && $closing_date != '' && $open_for != ''){
      $query = "SELECT * FROM open_information_portal WHERE admin_id = '".$_SESSION['user']['id']."' AND open_for = '".$open_for."'";
	  $res = mysqli_query($conn, $query);
	  if(mysqli_num_rows($res)> 0){
		$sql = "UPDATE open_information_portal SET opening_date = '".$opening_date."', closing_date = '".$closing_date."', open_for = '".$open_for."', date_created = '".date('Y-m-d')."' WHERE admin_id = '".$_SESSION['user']['id']."' AND open_for = '".$open_for."'";
	     if (mysqli_query($conn, $sql)) {
	        $_SESSION['msg'] =  "Employee Information will be open between ".$opening_date." and ".$closing_date."";
	        header("Location: /outsourcing/open_portal.php");
	    } else {
	        $_SESSION['msg'] = "Error while update account, please try again later";
	        //echo "Error updating record: " . mysqli_error($conn);
	        header("Location: /outsourcing/open_portal.php");
	           
	    }  
	  }else {
     	  insert_data($conn,$opening_date,$closing_date, $open_for, $_SESSION['user']['id']);
          header("Location: /outsourcing/open_portal.php");
     }		
     
   }
 }
 function insert_data($conn, $opening_date,$closing_date, $open_for, $_id){
 	$sql = "INSERT INTO open_information_portal (opening_date, closing_date, open_for, admin_id, date_created)
          VALUES ('".$opening_date."', '".$closing_date."', '".$open_for."','".$_id."', '".date('Y-m-d')."')";
            if (mysqli_query($conn, $sql)) {
               $_SESSION['msg'] = "Employee Information will be open between ".$opening_date." and ".$closing_date."";
            }else {
               $_SESSION['msg'] = "Error while update account, please try again later";
               //echo "Error updating record: " . mysqli_error($conn);
          }
 }
?>