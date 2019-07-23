<?php
 session_start();
 if(isset($_GET['staff_id']) && isset($_GET['request_id'])){
 	if($_GET['staff_id'] != '' && $_GET['request_id'] != ''){
 		$_SESSION['staff_id'] = base64_decode($_GET['staff_id']);
 		$_SESSION['request_id'] = base64_decode($_GET['request_id']);
 	    header("Location: /outsourcing/id_card_details.php");
 	}else {
 	   $_SESSION['msg'] = "Error loading data, please try again later";	
 	   header("Location: /outsourcing/view_all_id_request.php");	
 	}
 }
?>