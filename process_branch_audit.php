<?php
 include "connection.php";
 session_start();
 
 if(isset($_POST['submit'])){
     $sql = "UPDATE staff_audit_replies SET branch_manager_replies = '".$_POST['status']."' WHERE id = '".$_POST['reply_id']."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] =  "Record updated successfully";
             header("Location: dashboard.php");
            
        } else {
            //echo "Error updating record: " . mysqli_error($conn);
            header("Location: dashboard.php");
        }
 }

?>