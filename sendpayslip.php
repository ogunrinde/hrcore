<?php
  include "connection.php";
  include "process_email.php";
  include ('fpdf/fpdf.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/SMTP.php';
    require 'class.phpmailer.php'; // path to the PHPMailer class
    require 'class.smtp.php';
  $data = [];//getcompanydetail($conn);
   echo 'aa';
	return false;
  if(isset($_GET['eID']) && isset($_GET['email'])){
  	$eID = base64_decode($_GET['eID']);
  	$email = base64_decode($_GET['email']);
	$query = "SELECT * FROM employee_info WHERE id = '".$eID."'";
	  $result = mysqli_query($conn, $query);
	  if(mysqli_num_rows($result)> 0){
	      while($row = mysqli_fetch_assoc($result)) {
	        $_SESSION['employee'][] = $row;
	      }
	  }
	 
	$query = "SELECT * FROM employee_payroll_data WHERE employee_info_id = '".$eID."'";
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
	$month = ["JAN", "FEB", "MAR", "APR", "MAY", "JUNE", "JULY", "AUG","SEPT","OCT", "NOV", "DEC"];
	$t = (int)date("m") - 1;
	$this_month = $month[$t];  
	$basic_salary = ""; 
	$housing = "";
	$utility = "";
	$transport = "";
	$furniture = "";
	$entertainment = "";
	$education = "";
	$q_allowance = "";
	$lunch = "";
	$leave_bonus = "";
	$pension_earning = "";
	$pension_company = "";
	$GLI = "";
	$ECA = "";
	$NHF = "";
	$xmas = ""; 
	$ITF ="";
	$NET = "";
	echo 'aa';
	return false;
	//header("Location: /outsourcing/payslip.php");
	if(isset($_SESSION['employee_payroll_data'][0]['basic_salary']) && $_SESSION['employee_payroll_data'][0]['basic_salary'] != "") {
              $basic_salary = "<tr>
              <td>BASIC SALARY</td>
              <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['basic_salary'])."</td>
              </tr>";
    }
	if(isset($_SESSION['employee_payroll_data'][0]['housing']) && $_SESSION['employee_payroll_data'][0]['housing'] != "") {
		  $housing = "<tr>
		  <td>HOUSING</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['housing'])."</td>
		  </tr>";
	} 
	if(isset($_SESSION['employee_payroll_data'][0]['transport']) && $_SESSION['employee_payroll_data'][0]['transport'] != "") {
		  $transport = "<tr>
		  <td>TRANSPORT</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['transport'])."</td>
		  </tr>";
	} 
	if(isset($_SESSION['employee_payroll_data'][0]['education']) && $_SESSION['employee_payroll_data'][0]['education'] != "") {
		  $education = "<tr>
		  <td>EDUCATION</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['education'])."</td>
		  </tr>";
	} 
	if(isset($_SESSION['employee_payroll_data'][0]['utility']) && $_SESSION['employee_payroll_data'][0]['utility'] != "") {
		  $utility = "<tr>
		  <td>UTILITY</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['utility'])."</td>
		  </tr>";
	} 
	if(isset($_SESSION['employee_payroll_data'][0]['lunch']) && $_SESSION['employee_payroll_data'][0]['lunch'] != "") {
		  $lunch = "<tr>
		  <td>LUNCH</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['lunch'])."</td>
		  </tr>";
	} 
	if(isset($_SESSION['employee_payroll_data'][0]['entertainment']) && $_SESSION['employee_payroll_data'][0]['entertainment'] != "") {
		  $entertainment = "<tr>
		  <td>ENTERTAINMENT</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['entertainment'])."</td>
		  </tr>";
	} 
	if(isset($_SESSION['employee_payroll_data'][0]['ITF']) && $_SESSION['employee_payroll_data'][0]['ITF'] != "") {
		  $ITF = "<tr>
		  <td>ITF</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['ITF'])."</td>
		  </tr>";
	}
	if(isset($_SESSION['employee_payroll_data'][0]['furniture']) && $_SESSION['employee_payroll_data'][0]['furniture'] != "") {
		  $furniture = "<tr>
		  <td>FURNITURE</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['furniture'])."</td>
		  </tr>";
	}
	if(isset($_SESSION['employee_payroll_data'][0]['q_allowance']) && $_SESSION['employee_payroll_data'][0]['q_allowance'] != "") {
		  $leave_bonus = "<tr>
		  <td>QUARTERLY ALLOWANCE</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['q_allowance'])."</td>
		  </tr>";
	}   
	if(isset($_SESSION['employee_payroll_data'][0]['leave_bonus']) && $_SESSION['employee_payroll_data'][0]['leave_bonus'] != "") {
		  $leave_bonus = "<tr>
		  <td>ENTERTAINMENT</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['leave_bonus'])."</td>
		  </tr>";
	} 
	if(isset($_SESSION['employee_payroll_data'][0]['gross']) && $_SESSION['employee_payroll_data'][0]['gross'] != "") {
		  $gross = "<tr>
		  <td>GROSS SALARY</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['gross'])."</td>
		  </tr>";
	}
	if(isset($_SESSION['employee_payroll_data'][0]['NET']) && $_SESSION['employee_payroll_data'][0]['NET'] != "") {
		  $NET = "<tr>
		  <td>NET SALARY</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['NET'])."</td>
		  </tr>";
	}  
	if(isset($_SESSION['employee_payroll_data'][0]['pension_company']) && $_SESSION['employee_payroll_data'][0]['pension_company'] != "") {
		  $pension_company = "<tr>
		  <td>PENSION (EMPLOYER)</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['pension_company'])."</td>
		  </tr>";
	} 
	if(isset($_SESSION['employee_payroll_data'][0]['pension_earning']) && $_SESSION['employee_payroll_data'][0]['pension_earning'] != "") {
		  $pension_earning = "<tr>
		  <td>PENSION (EMPLOYEE)</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['pension_earning'])."</td>
		  </tr>";
	} 
	if(isset($_SESSION['employee_payroll_data'][0]['tax']) && $_SESSION['employee_payroll_data'][0]['tax'] != "") {
		  $tax = "<tr>
		  <td>TAX</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['tax'])."</td>
		  </tr>";
	}
	if(isset($_SESSION['employee_payroll_data'][0]['ECA']) && $_SESSION['employee_payroll_data'][0]['ECA'] != "") {
		  $ECA = "<tr>
		  <td>ECA</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['ECA'])."</td>
		  </tr>";
	}
	if(isset($_SESSION['employee_payroll_data'][0]['ITF']) && $_SESSION['employee_payroll_data'][0]['ITF'] != "") {
		  $ITF = "<tr>
		  <td>ITF</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['ITF'])."</td>
		  </tr>";
	}  
	if(isset($_SESSION['employee_payroll_data'][0]['GLI']) && $_SESSION['employee_payroll_data'][0]['GLI'] != "") {
		  $GLI = "<tr>
		  <td>GLI</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['GLI'])."</td>
		  </tr>";
	} 
	if(isset($_SESSION['employee_payroll_data'][0]['NHF']) && $_SESSION['employee_payroll_data'][0]['NHF'] != "") {
		  $NHF = "<tr>
		  <td>NHF</td>
		  <td colspan='2'>".number_format($_SESSION['employee_payroll_data'][0]['NHF'])."</td>
		  </tr>";
	}  
	$msg = '<div class="">
        <div class="" style="width: 90%;margin-left: auto;margin-right: auto;font-size:16px;">  
        <table class="table table-bordered">
          <thead>
            <tr style="width: 100%;">
              <th colspan="2" scope="col" style="">ICS OUTSOURCING LIMITED</th>
              <th colspan="3" scope="col" style="">PAYSLIP FOR '.date("d").' '.$this_month.' '.date("Y").'</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">EMP. CODE:</th>
              <td>'.$_SESSION['employee'][0]['employee_ID'].'</td>
              <th>PAYMODE</th>
              <td colspan="2">'.$_SESSION['company']['company_name'].'</td>
            </tr>
            <tr>
              <th scope="row">EMP.NAME</th>
              <td>'.$_SESSION['employee'][0]['last_name'].' '.$_SESSION['employee'][0]['first_name'].'</td>
              <th>Grade</th>
              <td colspan="2">BANKING ASSOCIATE 3</td>
            </tr>
            <tr>
              <th scope="row">DEPARTMENT</th>
              <td colspan="2">SUPPORT</td>
              <th>CATEGORY</th>
              <td colspan="2">DEVELOPER</td>
            </tr>
            <tr>
              <th scope="row">LOCATION</th>
              <td colspan="2">OGUDU BRANCH</td>
              <th>POSITION</th>
              <td colspan="2">TELLER</td>
            </tr>
          </tbody>
        </table>
      <div class="flex">
        <div>
          <table class="table table-bordered">
            <tr style="width: 100%;">
              <th style="width: 300px;">ALLOWANCES/EARNING</th>
              <th colspan="2">NGN</th>
            </tr>
            '.$basic_salary.'
            '.$housing.'
            '.$transport.'
          	'.$lunch.'
          	'.$education.'
          	'.$entertainment.'
          	'.$ITF.'
          	'.$furniture.'
          	'.$q_allowance.'
          	'.$gross.'
          	'.$NET.'
              </tr>    
              <tr>
              <th>REMARK</th>
              <td colspan="3"></td>
              </tr>
          </table>
        </div>
        <div>
          <table  class="table table-bordered">
              <tr>
              <th>DEDUCTIONS</th>
              <th colspan="2">NGN</th>
              </tr>
 			 '.$pension_company.'
 			 '.$pension_earning.'
 			 '.$tax.'
 			 '.$NHF.'
 			 '.$ECA.'
 			 '.$ITF.'
 			 '.$GLI.'
              <th>TOTAL DEDUCTION</th>
              <td colspan="2"></td>
              </tr>
          </table>
        </div>
      </div>
       <div>
       </div>
       </div>
      </div>';
      //echo $msg;
     //process_data($conn,$email,$msg,'Payslip');
    //sendmail($email,$msg, 'Payslip');
    //$_SESSION['msg'] = "Payslip sent";
    //header("Location: /outsourcing/masterlist");
  }
?>