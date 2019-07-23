<?php
include "connection.php";
session_start();
$msg = '';
$item_category = mysqli_real_escape_string($conn, $_POST['item_category']);
$item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
$item_quantity = mysqli_real_escape_string($conn, $_POST['item_quantity']);
$item_cost = mysqli_real_escape_string($conn, $_POST['item_cost']);
 if(isset($_POST['submit'])){
   if($item_category == ''){
     $_SESSION['msg'] = 'Please select category of Item';
   }
   if($item_name == ''){
     $_SESSION['msg'] = 'Pease select the item name';
   }
   if($item_name){
     $sql = "INSERT INTO items (item_category, item_cost, item_name, item_quantity, admin_id)
          VALUES ('".$_POST['item_category']."', '".$_POST['item_cost']."', '".$_POST['item_name']."','".$_POST['item_quantity']."','".$_SESSION['user']['id']."')";
            if (mysqli_query($conn, $sql)) {
              $_SESSION['msg'] = "New Item added to record";
              $last_id = $conn->insert_id;
            }else {
               $_SESSION['msg'] = "Error while update account, please try again later";
          }
          header("Location: addItems.php");
   }
 }
?>