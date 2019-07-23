<?php
 include "connection.php";
 session_start();
 if(isset($_POST['submit'])){
   $knowledge = mysqli_real_escape_string($conn, $_POST['editor1']);
   $sql = "INSERT INTO kss (information, staff_id,admin_id, date_created)
          VALUES ('".$knowledge."', '".$_SESSION['user']['id']."', '".$_SESSION['user']['admin_id']."', '".date('Y-m-d')."')";
          if (mysqli_query($conn,$sql ) === TRUE) {
              $_SESSION['msg'] = "Knowledge shared has been dispatched";
              header("Location: /outsourcing/share_knowledge.php");
          } else {
              //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              $_SESSION['msg'] = "Error saving information";
              header("Location: register.php");
          }
 }
?>