<?php
include "connection.php";
include "process_email.php";
session_start();
if(isset($_POST['submit'])){
  $admin_id;
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $branch = mysqli_real_escape_string($conn, $_POST['branch']);
  $role = mysqli_real_escape_string($conn, $_POST['role']);
//password = mysqli_real_escape_string($conn, $_POST['password']);

  if($role == 'supervisor' && ($name == '' || $phone_number == '' || $email == '' || $address == '' || $branch == '')){
      $_SESSION['msg'] = "All Input field are required";
      header("Location: /outsourcing/addsupervisors.php");
      return false;
  }else if($role == 'NBC' && $name == '' || $phone_number == '' || $email == '' || $address == ''){
     $_SESSION['msg'] = "All Input field are required except branch";
      header("Location: /outsourcing/addsupervisors.php");
      return false;
  }
  if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
  if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  if($role == 'supervisor'){
      $query = "SELECT * from users WHERE email = '$email'";
      $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0){
          $_SESSION['msg'] = "This Supervisor is already added";
          header("Location: /outsourcing/addsupervisors.php");
          return false;
        }
  }else {
      $password = password_hash('nbc2019', PASSWORD_DEFAULT);
      $query = "SELECT * from users WHERE email = '$email'";
      $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0){
          $_SESSION['msg'] = "This User is already ADDED";
          header("Location: /outsourcing/addsupervisors.php");
          return false;
        }else{
          $sql = "INSERT INTO users (name, phone_number, email,employee_ID, address, date_created, admin_id, password,cpassword,branch, position, category, company_id,payroll_only)
          VALUES ('".$name."', '".$phone_number."', '".$email."','".$email."','".$address."','".date('Y-m-d')."', '".$admin_id."','".$password."','nbc2019','".$branchdetails[0]."','".$role."','staff','2','1')";
           if (mysqli_query($conn,$sql ) === TRUE) {
                $query = "update branches SET manager_id = '".$conn->insert_id."' WHERE id = '".$branchdetails[1]."'";
                $result = mysqli_query($conn, $query);
                $msg = "<div><p>Good Day ".$name.",</p><p>You have been created as a NBC staff on HRCORE</p><p style='color:red;'>Your login Details is username : ".$email." and Password: nbc2019</p> <p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'https://www.hrcore.ng/outsourcing/login'>Log In to view</a></p></div>";
                           if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                //$manager = getManagerDetails($conn,$get_first_approval_email);
                                process_data($conn,$email,$msg,'NBC Staff Created');
                                $_SESSION['msg'] = "New ".$role." staff added";
                                header("Location: /outsourcing/addsupervisors.php");
                                return false;
                            }
                  
              }else{
                      $_SESSION['msg'] = "Error updating data, kindly try again later";
                      header("Location: /outsourcing/branch.php");
                      return false;
              }
        }
  }
  $password = password_hash('nbc2019', PASSWORD_DEFAULT);
  $branchdetails = explode('%',$branch);
  $sql = "INSERT INTO users (name, phone_number, email,employee_ID, address, date_created, admin_id, password,cpassword,branch, position, category, company_id)
  VALUES ('".$name."', '".$phone_number."', '".$email."','".$email."','".$address."','".date('Y-m-d')."', '".$admin_id."','".$password."','nbc2019','".$branchdetails[0]."','supervisor','staff','2')";
  if (mysqli_query($conn,$sql ) === TRUE) {
    $query = "update branches SET manager_id = '".$conn->insert_id."' WHERE id = '".$branchdetails[1]."'";
    $result = mysqli_query($conn, $query);
    $msg = "<div><p>Good Day ".$name.",</p><p>You have been created as a supervisor to manage ".$branch." Branch</p><p style='color:red;'>Your login Details is username : ".$email." and Password: nbc2019</p> <p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'https://www.hrcore.ng/outsourcing/login'>Log In to view</a></p></div>";
               if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    //$manager = getManagerDetails($conn,$get_first_approval_email);
                    process_data($conn,$email,$msg,'Supervisor Created');
                    $_SESSION['msg'] = "New Supervisor added";
                    header("Location: /outsourcing/addsupervisors.php");
                }
      
  } else {
      //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
     $_SESSION['msg'] = "Error updating data, kindly try again later";
     header("Location: /outsourcing/addsupervisors.php");
  }
}
if(isset($_POST['update'])){
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);
   $sql = "UPDATE branches SET name = '".$name."', phone_number = '".$phone_number."', email = '".$email."', address = '".$address."' WHERE id = '".$branch_id."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Record updated successfully";
            header("Location: /outsourcing/branch.php");
        } else {
            $_SESSION['msg'] = "Error updating data, kindly try again later";
            header("Location: /outsourcing/branch.php");
        }
}
?>