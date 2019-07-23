<?php
include "connection.php";
session_start();
if(isset($_POST['submit'])){
	$employee_ID = mysqli_real_escape_string($conn, $_POST['employee_ID']);
	$basic_salary = mysqli_real_escape_string($conn, $_POST['basic_salary']);
	$housing = mysqli_real_escape_string($conn, $_POST['housing']);
	$transport = mysqli_real_escape_string($conn, $_POST['transport']);
	$lunch = mysqli_real_escape_string($conn, $_POST['lunch']);
	$utility = mysqli_real_escape_string($conn, $_POST['utility']);
	$education = mysqli_real_escape_string($conn, $_POST['education']);
	$entertainment = mysqli_real_escape_string($conn, $_POST['entertainment']);
	$hmo = mysqli_real_escape_string($conn, $_POST['hmo']);
	$leave = mysqli_real_escape_string($conn, $_POST['leave']);
	$xmas = mysqli_real_escape_string($conn, $_POST['xmas']);
	$pension_company = mysqli_real_escape_string($conn, $_POST['pension_company']);
	$pension_earning = mysqli_real_escape_string($conn, $_POST['pension_earning']);
	$tax = mysqli_real_escape_string($conn, $_POST['tax']);
	$gross = mysqli_real_escape_string($conn, $_POST['gross']);
	$service_charge = mysqli_real_escape_string($conn, $_POST['service_charge']);
	$vat = mysqli_real_escape_string($conn, $_POST['vat']);
	$net = mysqli_real_escape_string($conn, $_POST['net']);

    $furniture = mysqli_real_escape_string($conn, $_POST['furniture']);
	$q_allowance = mysqli_real_escape_string($conn, $_POST['q_allowance']);
	$gli = mysqli_real_escape_string($conn, $_POST['gli']);
	$medical = mysqli_real_escape_string($conn, $_POST['medical']);
	$eca = mysqli_real_escape_string($conn, $_POST['eca']);
	$itf = mysqli_real_escape_string($conn, $_POST['itf']);
    $nhf = mysqli_real_escape_string($conn, $_POST['nhf']);
	$bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
	$account_number = mysqli_real_escape_string($conn, $_POST['account_number']);
	if($employee_ID == ''){
		$_SESSION['msg'] = "Please input the employee ID";
        header("Location: /outsourcing/employee"); 	
        return false;
	}
	$query = "SELECT * from employee_payroll_data WHERE employee_info_data = '$employee_ID'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
      $_SESSION['msg'] = "This user information has already been added";
      header("Location: /outsourcing/employee"); 	
      return false;
    }
    if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
    if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
    $sql = "INSERT INTO employee_payroll_data (employee_info_id, basic_salary, housing, transport, lunch, utility,education,entertainment,HMO,leave_bonus,xmas,pension_company,pension_earning,tax,gross,service_charge,VAT,NET, account_number,bank_name,insert_by, date_created, furniture, q_allowance,medical,GLI,ECA,ITF,NHF,admin_id)
          VALUES ('".$employee_ID."', '".$basic_salary."', '".$housing."','".$transport."','".$lunch."','".$utility."','".$education."','".$entertainment."','".$hmo."','".$leave."','".$xmas."','".$pension_company."','".$pension_earning."','".$tax."','".$gross."','".$service_charge."','".$vat."','".$net."','".$account_number."','".$bank_name."','".$_SESSION['user']['id']."','".date('Y-m-d')."','".$furniture."','".$q_allowance."','".$medical."','".$gli."','".$eca."','".$itf."','".$nhf."','".$admin_id."')";
          if (mysqli_query($conn,$sql ) === TRUE) {
              $_SESSION['msg'] = "Employee Information updated";
              header("Location: /outsourcing/employee");
          } else {
              //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              $_SESSION['msg'] = "Error updating account";
              header("Location: /outsourcing/employee");
          }
}
if(isset($_POST['update'])){
	$ID = mysqli_real_escape_string($conn, $_POST['employee_ID']);
	$basic_salary = mysqli_real_escape_string($conn, $_POST['basic_salary']);
	$housing = mysqli_real_escape_string($conn, $_POST['housing']);
	$transport = mysqli_real_escape_string($conn, $_POST['transport']);
	$lunch = mysqli_real_escape_string($conn, $_POST['lunch']);
	$utility = mysqli_real_escape_string($conn, $_POST['utility']);
	$education = mysqli_real_escape_string($conn, $_POST['education']);
	$entertainment = mysqli_real_escape_string($conn, $_POST['entertainment']);
	$hmo = mysqli_real_escape_string($conn, $_POST['hmo']);
	$leave = mysqli_real_escape_string($conn, $_POST['leave']);
	$xmas = mysqli_real_escape_string($conn, $_POST['xmas']);
	$pension_company = mysqli_real_escape_string($conn, $_POST['pension_company']);
	$pension_earning = mysqli_real_escape_string($conn, $_POST['pension_earning']);
	$tax = mysqli_real_escape_string($conn, $_POST['tax']);
	$gross = mysqli_real_escape_string($conn, $_POST['gross']);
	$service_charge = mysqli_real_escape_string($conn, $_POST['service_charge']);
	$vat = mysqli_real_escape_string($conn, $_POST['vat']);
	$net = mysqli_real_escape_string($conn, $_POST['net']);
	$furniture = mysqli_real_escape_string($conn, $_POST['furniture']);
	$q_allowance = mysqli_real_escape_string($conn, $_POST['q_allowance']);
	$gli = mysqli_real_escape_string($conn, $_POST['gli']);
	$medical = mysqli_real_escape_string($conn, $_POST['medical']);
	$eca = mysqli_real_escape_string($conn, $_POST['eca']);
	$itf = mysqli_real_escape_string($conn, $_POST['itf']);
    $nhf = mysqli_real_escape_string($conn, $_POST['nhf']);
	$bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
	$account_number = mysqli_real_escape_string($conn, $_POST['account_number']);
    $sql = "UPDATE employee_payroll_data SET basic_salary = '".$basic_salary."', housing = '".$housing."', transport = '".$transport."', lunch = '".$lunch."', utility = '".$utility."',education = '".$education."', entertainment = '".$entertainment."', HMO = '".$hmo."', leave_bonus = '".$leave."',xmas = '".$xmas."', pension_company = '".$pension_company."', pension_earning = '".$pension_earning."', tax = '".$tax."', gross = '".$gross."', service_charge = '".$service_charge."', VAT = '".$vat."', NET = '".$net."', account_number = '".$account_number."',bank_name = '".$bank_name."', furniture = '".$furniture."',q_allowance = '".$q_allowance."', GLI = '".$gli."', medical = '".$medical."', ECA = '".$eca."', ITF = '".$itf."', NHF = '".$nhf."', updated_by = '".date('Y-m-d')."' WHERE employee_info_id = '".$ID."'";
          if (mysqli_query($conn, $sql)) {
              $_SESSION['msg'] = "Employee payroll information updated";
              header("Location: /outsourcing/employee");
          } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              //$_SESSION['msg'] = "Error updating account";
              //header("Location: /outsourcing/employee");
          }
}

?>