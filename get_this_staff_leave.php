<?php
 include 'connection.php';
 session_start();
 if(isset($_GET['leave_id']) && isset($_GET['staff_id'])){
 	if($_GET['leave_id'] != '' && $_GET['staff_id'] != ''){
 		$_SESSION['leave_id'] = base64_decode($_GET['leave_id']);
 		$_SESSION['staff_id'] = base64_decode($_GET['staff_id']);
 		//echo $_SESSION['staff_id'];
 		header("Location: /outsourcing/approval_leave_view.php");
 	}
 }
?>