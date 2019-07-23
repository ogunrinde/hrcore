<?php
  include 'connection.php';
  session_start();
  if(isset($_GET['appraisal_id']) && isset($_GET['staff_id'])){
  	if($_GET['appraisal_id'] != '' && $_GET['staff_id'] != ''){
  		$_SESSION['appraisal_id'] = base64_decode($_GET['appraisal_id']);
  		$_SESSION['staff_id'] = base64_decode($_GET['staff_id']);
  		header("Location: /outsourcing/each_staff_appraisal.php");
  	}
  }
  ?>