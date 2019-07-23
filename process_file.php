<?php
include 'connection.php';
session_start();

if (isset($_POST["export"])) {
    if($_POST['which'] == 'masterlist'){
       $value =  masterlist($conn);
       exit();
    }
    if($_POST['which'] == 'branch'){
       $value =  branch($conn);
       exit();
    }
    if($_POST['which'] == 'audit'){
       $value =  audit($conn);
       exit();
    }
    if($_POST['which'] == 'directory'){
       $value =  directory($conn);
       exit();
    }
}
function masterlist($conn){
    $employee = [];
    if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
    if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
    //print_r($admin_id);
    $query = "SELECT employee_info.first_name, employee_info.last_name, employee_info.employee_ID, employee_payroll_data.basic_salary,employee_payroll_data.housing, employee_payroll_data.transport,employee_payroll_data.lunch,employee_payroll_data.utility,employee_payroll_data.education,employee_payroll_data.entertainment,employee_payroll_data.HMO,employee_payroll_data.leave_bonus,employee_payroll_data.xmas,employee_payroll_data.pension_company,employee_payroll_data.pension_earning,employee_payroll_data.tax,employee_payroll_data.service_charge,employee_payroll_data.VAT,employee_payroll_data.gross,employee_payroll_data.NET FROM employee_info LEFT JOIN employee_payroll_data ON (employee_payroll_data.admin_id = employee_info.admin_id AND employee_payroll_data.employee_info_id = employee_info.id)  WHERE employee_info.admin_id = '".$admin_id."'";
    //$query = "SELECT employee_info.first_name, employee_info.last_name, employee_info.employee_ID FROM employee_info WHERE admin_id = '".$admin_id."'";
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
    
    //return $employee;
}
function branch($conn){
    $employee = [];
    if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
    if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
    //print_r($admin_id);
    $query = "SELECT name,address,phone_number,email FROM branches WHERE admin_id = '".$admin_id."'";
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
function directory($conn){
    if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
    if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
    //print_r($admin_id);
    $query = "SELECT users.name,users.fname,users.mname,users.employee_ID, users.user_company, users.phone_number, users.department,users.branch, users.role,users.email,users.position, users.gender, users.state_of_origin, users.marital_status FROM users WHERE admin_id = '".$admin_id."'";
    $productResult = mysqli_query($conn, $query);
    $filename = "Export_excel_directory.xls";
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
function audit($conn){
    if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
    if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
    $year = $_POST['year'];
    $month = $_POST['month'];
    if($_POST['month'] == '' || $_POST['year'] == ''){
        $query = "SELECT users.name,users.fname, users.mname,users.employee_ID, users.department,users.branch, users.role,users.email,staff_audit.month,staff_audit.year, staff_audit_replies.branch_manager_replies FROM staff_audit_replies INNER JOIN users ON users.id = staff_audit_replies.staff_id INNER JOIN staff_audit ON staff_audit.admin_id = staff_audit_replies.admin_id WHERE staff_audit_replies.admin_id = '".$admin_id."'";
    }else {
        $query = "SELECT users.name,users.fname, users.mname, users.employee_ID, users.department,users.branch, users.role,users.email,staff_audit.month,staff_audit.year,staff_audit_replies.branch_manager_replies FROM staff_audit_replies INNER JOIN users ON users.id = staff_audit_replies.staff_id INNER JOIN staff_audit ON staff_audit.admin_id = staff_audit_replies.admin_id WHERE staff_audit_replies.admin_id = '".$admin_id."' AND staff_audit.month = '".$month."' AND staff_audit.year = '".$year."'";
    }
   $filename = "Export_excel.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $productResult = mysqli_query($conn, $query);
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