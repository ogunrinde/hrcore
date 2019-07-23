<?php
include "connection.php";
session_start();
if(isset($_POST['submit'])){
  $admin_id;
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $id = mysqli_real_escape_string($conn, $_POST['branch_id']);
  if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
  if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT * from departments WHERE dept = '$department'";
  $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
      $_SESSION['msg'] = "This department is already added";
      header("Location: /outsourcing/adddepartment.php");
      return false;
    }
  if($id == '') {
      $_SESSION['msg'] = "Please input the branch";
      header("Location: /outsourcing/adddepartment.php");
      return false;
  }
  $sql = "INSERT INTO departments (branch_id, dept, date_created, admin_id, insert_by)
  VALUES ('".$id."', '".$name."', '".date('Y-m-d')."', '".$admin_id."','".$_SESSION['user']['id']."')";
  if (mysqli_query($conn,$sql ) === TRUE) {
      $_SESSION['msg'] = "New department added";
      header("Location: /outsourcing/department.php");
  } else {
      //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
     $_SESSION['msg'] = "Error updating data, kindly try again later";
     header("Location: /outsourcing/adddepartment.php");
  }
}
if(isset($_POST['update'])){
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $id = mysqli_real_escape_string($conn, $_POST['branch_id']);
  $dept_id = mysqli_real_escape_string($conn, $_POST['dept_id']);
   $sql = "UPDATE departments SET dept = '".$name."', branch_id = '".$id."', date_created = '".date('Y-m-d')."' WHERE id = '".$dept_id."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Record updated successfully";
            header("Location: /outsourcing/department.php");
        } else {
            //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            $_SESSION['msg'] = "Error updating data, kindly try again later";
            header("Location: /outsourcing/department.php");
        }
}
?>