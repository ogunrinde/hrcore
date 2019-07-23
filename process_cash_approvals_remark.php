<?php
  include "connection.php";
  include "process_email.php";
  //session_start();
  $stage = "pending";
  if(isset($_GET['status']) && isset($_GET['cash_id']) && isset($_GET['approval_details'])){
  	if($_GET['status'] != '' && $_GET['cash_id'] != '' && $_GET['approval_details'] != ''){
       $query = "SELECT * FROM cash_request WHERE id = '".base64_decode($_GET['cash_id'])."'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)> 0){
            while($row = mysqli_fetch_assoc($result)) {
              $cash[] = $row;
            }
        }
        //print_r($cash); return false;
        $sql = "SELECT * FROM users WHERE id = '".$cash[0]['staff_id']."'";
        $res = mysqli_query($conn, $sql);
            if(mysqli_num_rows($res)> 0){
                while($row = mysqli_fetch_assoc($res)) {
                  $user[] = $row;
                }
                $full_cash_flow = $user[0]['cash_flow'];
                
        }
  		$status = base64_decode(mysqli_real_escape_string($conn, $_GET['status']));
  		$cash_id = base64_decode(mysqli_real_escape_string($conn, $_GET['cash_id']));
  		$approval_details = base64_decode(mysqli_real_escape_string($conn, $_GET['approval_details']));
  		$flow = base64_decode(mysqli_real_escape_string($conn, $_GET['flow']));
  		$flowby = base64_decode(mysqli_real_escape_string($conn, $_GET['flow_by']));
  		$flows = $flow != '' ? explode(';',$flow) : [];
  		$allflows = "";
  		foreach ($flows as $value) {
  			$who = explode(":", $value)[0];
  			if($allflows != "") $allflows .= ";";
  			if($who == $flowby) $allflows .= $approval_details.":".$status;
  			else $allflows .= $value;
  		}
        $lastflow = explode(":",$flows[count($flows)-1])[0];
        if($lastflow == $flowby) $stage = $approval_details;
  		$sql = "UPDATE cash_request SET flow = '".$allflows."', stage = '".$stage."', status = '".$status."' WHERE id = '".$cash_id."'";
        if (mysqli_query($conn, $sql)) {
          $send_to_next_approval = 0;
        	$_SESSION['msg'] = "Your remark is noted.";
          for($s = 0; $s < count($flows); $s++){
            $data = explode(":", $flows[$s]);
            if(count($data) > 0) $who = $data[0];
            if($send_to_next_approval == 1) {
              $send_to_next_approval = 0;
              $next_approval = explode(":", $flows[$s]);
              if(count($next_approval) > 1){
                $email = $next_approval[1];
                $msg = "<div><p>Good Day,</p><p>".$user[0]['name']." has requested for Cash. As the ".$next_approval[0].", kindly log In and add your remark to this staff Request.</p><p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'http://www.hrcore.ng'>Log In to view</a></p></div>";
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  process_data($conn,$email,$msg,'Cash Request');
                }
              }
            }
            if($who == $flowby) $send_to_next_approval = 1;
          }
        	//echo $_SESSION['msg'];
        	header("Location: /selfservice/cash_remark.php");
        }else {
        	$_SESSION['msg'] = "Error updating record, kindly try again later";
        	 header("Location: /selfservice/cash_remark.php");
        } 
       
  	}
  }
?>