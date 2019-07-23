<?php
 include "connection.php";
 session_start();
 //echo $_GET['id'];
 if(isset($_GET['id'])){
 	if($_GET['id'] != ''){
 		$_SESSION['eID'] = base64_decode($_GET['id']);
 		//echo $_SESSION['eID'];
 		$_SESSION['employee_payroll_data'] = [];
 		$_SESSION['employee_payroll_data'] = [];
 		$query = "SELECT * FROM employee_info WHERE id = '".$_SESSION['eID']."'";
		  $result = mysqli_query($conn, $query);
		  if(mysqli_num_rows($result)> 0){
		      while($row = mysqli_fetch_assoc($result)) {
		        $_SESSION['employee'][] = $row;
		      }
		  }
		  //print_r($_SESSION['employee']);
 		$query = "SELECT * FROM employee_payroll_data WHERE employee_info_id = '".$_SESSION['eID']."'";
		  $result = mysqli_query($conn, $query);
		  if(mysqli_num_rows($result)> 0){
		      while($row = mysqli_fetch_assoc($result)) {
		        $_SESSION['employee_payroll_data'][] = $row;
		      }
		  }
		  //print_r($_SESSION['employee_payroll_data']);
		$query = "SELECT departments.dept, departments.id as dept_id, branches.name, branches.id as branch_id FROM departments LEFT JOIN branches ON departments.branch_id = branches.id WHERE departments.id = '".$_SESSION['employee'][0]['department_id']."'";
		  $result = mysqli_query($conn, $query);
		  if(mysqli_num_rows($result)> 0){
		      while($row = mysqli_fetch_assoc($result)) {
		        $_SESSION['other_info'][] = $row;
		      }
		  }
		if(!isset($_SESSION['employee_payroll_data'])){
			$_SESSION['msg'] = "You have not input '".$_SESSION["user"]["name"]."''s payroll data";
			header("Location: /outsourcing/masterlist.php");
		} 
	
		if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
		else if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
		//echo $admin_id;
		$query = "SELECT * from company WHERE admin_id = '".$admin_id."'";
		  $result = mysqli_query($conn, $query);
		  if(mysqli_num_rows($result)> 0){
		      while($row = mysqli_fetch_assoc($result)) {
		        $_SESSION['company'] = $row;
		      }
		  }
		  	//print_r($_SESSION['employee_payroll_data']);
		  //echo $_SESSION['company_image'];
		//print_r($_SESSION['employee_payroll_data']);
		//unset($_SESSION['employee_payroll_data']);
		//echo 'a';
		echo '<script> window.location.href = "/outsourcing/seepayslip.php"</script>';
 		header("Location: /outsourcing/seepayslip.php");
 	}
 }
?>