<?php 
 include 'connection.php';
 session_start();
 if(isset($_GET['staff_id'])){
 	$_SESSION['staff_id'] = mysqli_real_escape_string($conn, base64_decode($_GET['staff_id']));
 	header("Location: /outsourcing/view_profile.php");
 }
?>