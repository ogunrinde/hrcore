<?php
 include "connection.php";
 session_start();
 //echo $_GET['id'];
 if(isset($_GET['id'])){
 	if($_GET['id'] != ''){
 		$_SESSION['branch_id'] = base64_decode($_GET['id']);

 		$query = "SELECT * FROM branches WHERE id = '".$_SESSION['branch_id']."'";
		  $result = mysqli_query($conn, $query);
		  if(mysqli_num_rows($result)> 0){
		      while($row = mysqli_fetch_assoc($result)) {
		        $_SESSION['branch'][] = $row;
		      }
		  }
 		header("Location: /outsourcing/addbranch.php");
 	}
 }
?>