<?php
 include "connection.php";
 include "process_email.php";
 session_start();
 $to_update_comment;
 $appraisal = [];
 $user = [];
 if(isset($_POST['submit'])){
 	$appraisal_id = mysqli_real_escape_string($conn, $_POST['appraisal_id']);
 	$comment = mysqli_real_escape_string($conn, $_POST['comment']);
 	$staff_id = mysqli_real_escape_string($conn, $_POST['staff_id']);
 	$all_lmanager_justification = mysqli_real_escape_string($conn, $_POST['all_lmanager_justification']);
 	$all_lmanager_remarks = mysqli_real_escape_string($conn, $_POST['all_lmanager_remarks']);
 	//echo $all_lmanager_justification;
 	//return false;
 	if($comment == '') $comment = 'No Comment';
 	if($appraisal_id == '' || $staff_id == ''){
 	    $_SESSION['msg'] = 'Kindly add comment to appraisal';
 		header("Location: /outsourcing/approval_appraisal_view.php");
 	}else{
 		$query = "SELECT * FROM appraisal_replies WHERE appraisal_id = '".$appraisal_id."' AND staff_id = '".$staff_id."'"; 
        $result = mysqli_query($conn, $query);
       if(mysqli_num_rows($result)> 0){
	      while($row = mysqli_fetch_assoc($result)) {
	        $appraisal[] = $row;
	      }
	  }
	  $query = "SELECT * FROM users WHERE id = '".$staff_id."'"; 
        $result = mysqli_query($conn, $query);
       if(mysqli_num_rows($result)> 0){
	      while($row = mysqli_fetch_assoc($result)) {
	        $user[] = $row;
	      }
	  }
	  //print_r($appraisal);
	  if($appraisal[0]['comments_flow'] != ""){
	  	$appraisal_flow = explode(";", $appraisal[0]['comments_flow']);
	  	$toremove;
	  	$update_comment;
	  	 for($f = 0; $f < count($appraisal_flow); $f++){
	  	 	if($appraisal_flow[$f] != ""){
	  	 		$who = explode(":", $appraisal_flow[$f])[0];
	  	 		$current_comment = explode(":", $appraisal_flow[$f])[1];
	  	 		if(strtolower($who) == strtolower($_SESSION['user']['position'])){
	  	 		   $toremove = $appraisal_flow[$f];
                   $update_comment = $who.':'.$comment;
	  	 		}
	  	 	}
	  	 }
         $pos = array_search($toremove, $appraisal_flow);
         $appraisal_flow[$pos] = $update_comment;
         $to_update_comment = implode(";", $appraisal_flow);
         $sql = "UPDATE appraisal_replies SET lManager_remarks = '".$all_lmanager_remarks."', lManager_justification = '".$all_lmanager_justification."', comments_flow = '".$to_update_comment."' WHERE appraisal_id = '".$appraisal_id."' AND staff_id = '".$staff_id."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Comment updated successfully";
            $appraisal_flow = $user[0]['appraisal_flow'];
            for($s = 0; $s < count($user[0]['appraisal_flow']); $s++){
	            $data = explode(":", $appraisal_flow[$s]);
	            if(count($data) > 0) $who = $data[0];
	            if($send_to_next_approval == 1) {
	            	$send_to_next_approval = 0;
	              $next_approval = explode(":", $appraisal_flow[$s]);
	              if(count($next_approval) > 1){
	                $email = $next_approval[1];
	                $msg = "<div><p>Good Day,</p><p>".$user[0]['name']." has completed the appraisal for the period. As the ".$next_approval[0].", kindly log In and add your remark to this staff appraisal.</p><p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'http://www.hrcore.ng'>Log In to view</a></p></div>";
	                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	                  process_data($conn,$email,$msg,'Appraisal');
	                }
	              }
	            }
	            if($who == $flowby) $send_to_next_approval = 1;
            }
            header("Location: approval_appraisal_view.php");
        } else {
            echo "Error updating record: " . mysqli_error($conn);
            $_SESSION['msg'] = 'Error updating comment, please try again later';
            header("Location: approval_appraisal_view.php");
        }
	  }
	  
 	}
 }
?>