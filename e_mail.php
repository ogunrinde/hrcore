<?php
include "connection.php";
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

// Load Composer's autoloader
//require 'vendor/autoload.php';
function sendmail($to,$msg,$subject){
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host = 'hrcore.ng';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
    $mail->Username = 'ess@hrcore.ng';                     // SMTP username
    $mail->Password = 'wROS+cb63zQ(';                               // SMTP password
    $mail->SMTPSecure = 'tls';  
    $mail->SMTPAutoTLS = false;   
    $mail->SMTPOptions = array(
	    'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
	    )
	);                             // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('ess@hrcore.ng', 'HRCORE');
    $mail->addAddress($to, 'Employee');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $msg;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    /*echo 'Message has been sent';
    if($subject == 'Leave Request'){
        echo 'Message has been sent';
        $_SESSION['msg'] = "Your leave request is under processing";
        header("Location: staff_leave_request.php");
    }*/
    return true;
} catch (Exception $e) {
    /*echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    if($subject == 'Leave Request'){
        $_SESSION['msg'] = "Your leave request is under processing";
        header("Location: staff_leave_request.php");
    }*/
    return false;
}
}
 function getcompanydetail($conn){
   $data = [];   
   $select = "SELECT * from company WHERE admin_id = '1'";
   $result = mysqli_query($conn, $select);
    if(mysqli_num_rows($result) > 0){
      while($r = mysqli_fetch_assoc($result)) {
        $data[] = $r;
     }
    }
    return $data;
 }
?>