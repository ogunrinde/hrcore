<?php
 session_start();
 $base_url = "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI'].'/');
//echo $base_url;
 if(isset($_GET['item_id']) && $_GET['item_id'] != ''){
   $_SESSION['item_id'] = base64_decode($_GET['item_id']);
   header("Location: /outsourcing/request_details.php");
 }
?>