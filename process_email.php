<?php
include "connection.php";
include "e_mail.php";
include "email_template.php";
function process_data($conn,$to,$content, $subject){
	$data = [];
	$r = false;
	$data = getcompanydetail($conn);
	//$content = "This is to inform all interested applicant to get involved";
	$msg = template($data,$content);
	$r = sendmail($to,$msg, $subject);
	return $r;
}


?>