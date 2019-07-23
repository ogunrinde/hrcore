<?php
include "connection.php";
session_start();
if(!isset($_SESSION['user']['id']) || $_SESSION['user']['id']) header("Location: /outsourcing/login.php");
if(isset($_POST['submit'])){
  $admin_id;
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
  if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT * from branches WHERE email = '$email'";
  $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
      $_SESSION['msg'] = "This branch is already added";
      header("Location: /outsourcing/addbranch.php");
      return false;
    }

  $sql = "INSERT INTO branches (name, phone_number, email, address, date_created, admin_id, insert_by)
  VALUES ('".$name."', '".$phone_number."', '".$email."','".$address."','".date('Y-m-d')."', '".$admin_id."','".$_SESSION['user']['id']."')";
  if (mysqli_query($conn,$sql ) === TRUE) {
      $_SESSION['msg'] = "New branch added";
      header("Location: /outsourcing/branch.php");
  } else {
      //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
     $_SESSION['msg'] = "Error updating data, kindly try again later";
     header("Location: /outsourcing/addbranch.php");
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