<?php
 session_start();
 $base_url = "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI'].'/');
//echo $base_url;
 if(isset($_GET['cash_id']) && $_GET['cash_id'] != '' && $_GET['staff_id'] != ''){
   $_SESSION['cash_id'] = base64_decode($_GET['cash_id']);
   $_SESSION['staff_id'] = base64_decode($_GET['staff_id']);
   //echo $_SESSION['cash_id'];
   header("Location: /outsourcing/cash_remark");
 }
?>