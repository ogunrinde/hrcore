<?php
include 'connection.php';
session_start();
if(isset($_POST['submit'])){
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $marital_status = mysqli_real_escape_string($conn, $_POST['marital_status']);
    $employee_ID = mysqli_real_escape_string($conn, $_POST['employee_ID']);
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $lga = mysqli_real_escape_string($conn, $_POST['lga']);
    $sorigin = mysqli_real_escape_string($conn, $_POST['sorigin']);
    
    echo $surname.'_'.$fname.'_'.$employee_ID;
}




//echo $msg;
?>