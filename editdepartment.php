<?php
 include "connection.php";
 session_start();
 //echo $_GET['id'];
 if(isset($_GET['id'])){
 	if($_GET['id'] != ''){
 		$_SESSION['dept_id'] = base64_decode($_GET['id']);

 		$query = "SELECT departments.dept,branches.name, departments.id FROM departments INNER JOIN branches ON (branches.id = departments.branch_id AND departments.id = '".$_SESSION['dept_id']."')";
		  $result = mysqli_query($conn, $query);
		  if(mysqli_num_rows($result)> 0){
		      while($row = mysqli_fetch_assoc($result)) {
		        $_SESSION['department'][] = $row;
		      }
		  }
		  //print_r($_SESSION['department']);
		  //unset($_SESSION['department']);
 		header("Location: /selfservice/adddepartment.php");
 	}
 }
?>