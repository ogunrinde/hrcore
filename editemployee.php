<?php
 include "connection.php";
 session_start();
 //echo $_GET['id'];
 if(isset($_GET['id'])){
 	if($_GET['id'] != ''){
 		$_SESSION['eID'] = base64_decode($_GET['id']);
 		$query = "SELECT * FROM employee_info WHERE id = '".$_SESSION['eID']."'";
		  $result = mysqli_query($conn, $query);
		  if(mysqli_num_rows($result)> 0){
		      while($row = mysqli_fetch_assoc($result)) {
		        $_SESSION['employee'][] = $row;
		      }
		  }
 		$query = "SELECT * FROM employee_payroll_data WHERE employee_info_id = '".$_SESSION['eID']."'";
		  $result = mysqli_query($conn, $query);
		  if(mysqli_num_rows($result)> 0){
		      while($row = mysqli_fetch_assoc($result)) {
		        $_SESSION['employee_payroll_data'][] = $row;
		      }
		  }
		$query = "SELECT departments.dept, departments.id as dept_id, branches.name, branches.id as branch_id FROM departments INNER JOIN branches ON departments.branch_id = branches.id WHERE departments.id = '".$_SESSION['employee'][0]['department_id']."'";
		  $result = mysqli_query($conn, $query);
		  if(mysqli_num_rows($result)> 0){
		      while($row = mysqli_fetch_assoc($result)) {
		        $_SESSION['other_info'][] = $row;
		      }
		  }
		  /*print_r($_SESSION['other_info']);
		  unset($_SESSION['employee']);
		  unset($_SESSION['other_info']);*/
 		header("Location: /outsourcing/employee.php");
 	}
 }
?>