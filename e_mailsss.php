<?php
include "connection.php";
session_start();
require 'class.phpmailer.php'; // path to the PHPMailer class
require 'class.smtp.php';
 function sendmail($to, $msg,$subject){
       $mail = new PHPMailer();
            $mail->IsSMTP();  // telling the class to use SMTP
            $mail->SMTPDebug = 2;
            $mail->Mailer = "smtp";
            $mail->Host = 'smoothtrackerng.com';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            //$mail->Port = 587;
            $mail->SMTPAuth = true; // turn on SMTP authentication
            $mail->Username = "infoselfservice@smoothtrackerng.com"; // SMTP username
            $mail->Password = "Gm{8U_d54C@,"; // SMTP password 
            //$Mail->Priority = 1;

            $mail->AddAddress("".$to."","Name");
            $mail->SetFrom('infoselfservice@smoothtrackerng.com', 'MultChase Selfservice');
            $mail->AddReplyTo('infoselfservice@smoothtrackerng.com','ESS');

            $mail->Subject  = $subject;
            $mail->Body     = $msg;
            $mail->IsHTML(true); 
            $mail->WordWrap = 50;  

            if(!$mail->Send()) {
            //echo 'Message was not sent.';
            //echo 'Mailer error: ' . $mail->ErrorInfo;
            } else {
                  //return true;
                  //header("Location: /ess/responsemsg.php");
             echo 'Message has been sent.';
            }
 }
 function getcompanydetail($conn){
   $data = [];   
   if($_SESSION['user']['category'] == 'staff')   
      $select = "SELECT * from company WHERE admin_id = '".$_SESSION['user']['admin_id']."'";
   else if($_SESSION['user']['category'] == 'admin')
      $select = "SELECT * from company WHERE admin_id = '".$_SESSION['user']['id']."'";
   $result = mysqli_query($conn, $select);
    if(mysqli_num_rows($result) > 0){
      while($r = mysqli_fetch_assoc($result)) {
        $data[] = $r;
     }
    }
    return $data;
 }
?>