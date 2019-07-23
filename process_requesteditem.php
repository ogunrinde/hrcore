<?php
include 'connection.php';
include "process_email.php";
session_start();
 $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
 $justification = mysqli_real_escape_string($conn, $_POST['justification']);
 $item_quantity = mysqli_real_escape_string($conn, $_POST['item_quantity']);
 $item_cost = mysqli_real_escape_string($conn, $_POST['item_cost']);
 if(isset($_POST['submit'])){
   if($_SESSION['user']['requisition_flow'] == ''){
     $_SESSION['msg'] = "You can not process requisition, because you don't have approvals. Kindly add requisition approval on the setting page";
     header("Location: staff_settings.php");
     return false;
   }
   if($item_name == ''){
     $_SESSION['msg'] = 'No item selected';
   }
   if($item_quantity == ''){
     $_SESSION['msg'] = 'Please select the required quantity';
   }
   if(isset($item_name) && $item_name != ''){

      $sql = "INSERT INTO requesteditem (item, justification, quantity, cost, date_created,staff_id, status,flow,admin_id)
          VALUES ('".$item_name."','".$justification."' , '".$item_quantity."', '".$item_cost."','".date('Y-m-d')."', '".$_SESSION['user']['id']."','pending', '".$_SESSION['user']['requisition_flow']."', '".$_SESSION['user']['admin_id']."')";
        if (mysqli_query($conn, $sql)) {
             if($_SESSION['user']['requisition_flow'] == ""){ 
               $_SESSION['msg'] = "Your request is being processed";
               header("Location: requestitems.php");return false;}
               $approvals = explode(";",$_SESSION['user']['requisition_flow']);
               if(count($approvals) == 0) { 
               $_SESSION['msg'] = "Your request is being processed";
               header("Location: requestitems.php");return false;}
               $get_first_approval_details = explode(":",$approvals[0]);
               if(count($get_first_approval_details) > 1) $get_first_approval_email = $get_first_approval_details[1];
               //include "process_email.php";
               $msg = "<div><p>Good Day,</p><p>".$_SESSION['user']['name']." has requested for ".$item_name.", kindly log in to account to view  more detail about the request.</p><p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'http://www.hrcore.ng'>Log In to view</a></p></div>";
               if (filter_var($get_first_approval_email, FILTER_VALIDATE_EMAIL)) {
                  process_data($conn,$get_first_approval_email,$msg,'Request');
                  //echo $get_first_approval_email;
                   $_SESSION['msg'] = "Your request is being processed";
                   header("Location: requestitems.php");
                }
               
              /*$msgdetails = "<div><p>Dear Admin,</p><p>".$_SESSION['name']." has requsted for ".$_POST['item'].", kindly log in to account to view  more detail.</p><p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'http://www.multichase.com/ess/requesteditems.php'>View Item</a></p></div>";
                $_SESSION['special_msg'] = "Your request is being processed";
                sendmail($admin[0]['email'], $msgdetails,'Item Request');*/
               
              //$last_id = $conn->insert_id;
            }else {
               $_SESSION['msg'] = "Error while update account, please try again later";
                //echo "Error updating record: " . mysqli_error($conn);
               header("Location: requestitems.php");
               //echo mysqli_error($conn);
        } 
   }
 }
?>