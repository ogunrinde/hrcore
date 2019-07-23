<?php 
include "connection.php";
session_start();

if(isset($_POST['submit'])){
	$branch = mysqli_real_escape_string($conn, $_POST['branch']);
	$report_type = mysqli_real_escape_string($conn, $_POST['report_type']);
	$month = mysqli_real_escape_string($conn, $_POST['month']);
	$year = mysqli_real_escape_string($conn, $_POST['year']);
     if($_SESSION['user']['payroll_only'] == '1') $admin_id = $_SESSION['user']['admin_id'];
     else $admin_id = $_SESSION['user']['id'];
    if($branch == '') {
		$_SESSION['msg'] = 'Please select the branch to report';
		header("Location: /outsourcing/masterlist.php");
        return false;
    } 
    if($report_type == ''){
    	$_SESSION['msg'] = 'Please select the report type';
		header("Location: /outsourcing/masterlist.php");
        return false;
    }
	if($branch == 'all'){
		if($report_type == 'supervisors'){
			 getsupervisors($conn,$admin_id,$branch);
			 exit();
		}else if($report_type == 'employee_info_payroll'){
			getemployee_payroll($conn,$admin_id,$branch);
			exit();
		}else if($report_type =='employee_info'){
			getemployee_only($conn,$admin_id,$branch);
			exit();
			
		}else if($report_type == 'female' || $report_type == 'male'){
			getemployee_gender($conn,$admin_id,$branch);
			exit();
		}else if($report_type == 'attendance'){
			if($month == '' && $year == '') {
				$_SESSION['msg'] = 'Please select the month and th year';
				header("Location: /outsourcing/masterlist.php");
                return false;
			}
			getattendance($conn,$admin_id,$branch);
			exit();
			
		}
	}else {
		if($report_type == 'supervisors'){
			 getsupervisors($conn,$admin_id,$branch);
			 exit();
		}else if($report_type == 'employee_info_payroll'){
			getemployee_payroll($conn,$admin_id,$branch);
			exit();
		}else if($report_type =='employee_info'){
			getemployee_only($conn,$admin_id,$branch);
			exit();
			
		}else if($report_type == 'female' || $report_type == 'male'){
			getemployee_gender($conn,$admin_id,$branch);
			exit();
		}else if($report_type == 'attendance'){
			if($month == '' && $year == '') {
				$_SESSION['msg'] = 'Please select the month and the year';
				header("Location: /outsourcing/masterlist.php");
                return false;
			}
			getattendance($conn,$admin_id,$branch);
			exit();
			
		}
	}

}
function getsupervisors($conn,$admin_id,$branch){
  $branch_name = mysqli_real_escape_string($conn, $_POST['branch_name']);
	if($branch == 'all')
       $query = "SELECT name as surname, fname as first_name, mname as middle_name, email, phone_number from users WHERE admin_id = '".$admin_id."' AND position = 'supervisor'";
    else 
       $query = "SELECT name as surname, fname as first_name, mname as middle_name, email, phone_number from users WHERE admin_id = '".$admin_id."' AND branch = '".$branch_name."' AND position = 'supervisor'";
   $productResult = mysqli_query($conn, $query);
    $filename = "Export_excel_supervisors.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    if(mysqli_num_rows($productResult)> 0){
      foreach ($productResult as $row) {
        if (! $isPrintHeader) {
            echo implode("\t", array_keys($row)) . "\n";
            $isPrintHeader = true;
        }
        echo implode("\t", array_values($row)) . "\n";
       }  
    }else {}
}
function getemployee_payroll($conn,$admin_id,$branch){
   if($branch == 'all')	
	  $query = "SELECT employee_info.id, employee_payroll_data.net,employee_payroll_data.gross, employee_info.first_name, employee_info.last_name, employee_info.employee_ID FROM employee_info LEFT JOIN employee_payroll_data ON (employee_payroll_data.admin_id = employee_info.admin_id AND employee_payroll_data.employee_info_id = employee_info.id)  WHERE employee_info.admin_id = '".$admin_id."'";
	 else 
       $query = "SELECT employee_info.id, employee_payroll_data.net,employee_payroll_data.gross, employee_info.first_name, employee_info.last_name, employee_info.employee_ID FROM employee_info LEFT JOIN employee_payroll_data ON (employee_payroll_data.admin_id = employee_info.admin_id AND employee_payroll_data.employee_info_id = employee_info.id)  WHERE employee_info.admin_id = '".$admin_id."' AND branch = '".$branch."'";
	  $productResult = mysqli_query($conn, $query);
    $filename = "Export_excel_payroll.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    if(mysqli_num_rows($productResult)> 0){
      foreach ($productResult as $row) {
        if (! $isPrintHeader) {
            echo implode("\t", array_keys($row)) . "\n";
            $isPrintHeader = true;
        }
        echo implode("\t", array_values($row)) . "\n";
       }  
    }else {}
}
function getemployee_only($conn,$admin_id,$branch){
	if($branch == 'all')
	   $query = "SELECT first_name, last_name,middlename, email, date_of_birth, employee_ID, status, gender,place_of_birth, FROM employee_info  WHERE admin_id = '".$admin_id."'";
    else
    	$query = "SELECT first_name, last_name,middlename, email, date_of_birth, employee_ID, status, gender,place_of_birth, FROM employee_info  WHERE admin_id = '".$admin_id."' AND branch = '".$branch."'";
	$productResult = mysqli_query($conn, $query);
    $filename = "Export_excel.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    if(mysqli_num_rows($productResult)> 0){
      foreach ($productResult as $row) {
        if (! $isPrintHeader) {
            echo implode("\t", array_keys($row)) . "\n";
            $isPrintHeader = true;
        }
        echo implode("\t", array_values($row)) . "\n";
       }  
    }else {}
}
function getemployee_gender($conn,$admin_id,$branch) {
	if($branch == 'all'){
      $query = "SELECT first_name, last_name,middlename, email, date_of_birth, employee_ID, status, gender,place_of_birth, FROM employee_info  WHERE admin_id = '".$admin_id."' AND gender ='".$report_type."'";
  }else {
    $query = "SELECT first_name, last_name,middlename, email, date_of_birth, employee_ID, status, gender,place_of_birth, FROM employee_info  WHERE admin_id = '".$admin_id."' AND gender ='".$report_type."' AND branch = '".$branch."'";
  }
     	
	$productResult = mysqli_query($conn, $query);
    $filename = "Export_excel_gender.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    if(mysqli_num_rows($productResult)> 0){
      foreach ($productResult as $row) {
        if (! $isPrintHeader) {
            echo implode("\t", array_keys($row)) . "\n";
            $isPrintHeader = true;
        }
        echo implode("\t", array_values($row)) . "\n";
       }  
    }else {}
}
function getattendance($conn,$admin_id,$branch){
	if($branch == 'all')
	   $query = "SELECT * from attendances WHERE admin_id = '".$admin_id."' AND month = '".$month."' AND year = '".$year."'";
    else 
       $query = "SELECT * from attendances WHERE admin_id = '".$admin_id."' AND month = '".$month."' AND year = '".$year."'";
	$productResult = mysqli_query($conn, $query);
    $filename = "Export_excel_attendance.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    if(mysqli_num_rows($productResult)> 0){
      foreach ($productResult as $row) {
        if (! $isPrintHeader) {
            echo implode("\t", array_keys($row)) . "\n";
            $isPrintHeader = true;
        }
        echo implode("\t", array_values($row)) . "\n";
       }  
    }else {}
}
?>