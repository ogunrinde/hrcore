<?php
  include "connection.php";
  include "process_email.php";
  session_start();
  $stage = "pending";
  $user = [];
  $item = [];
  if(isset($_GET['status']) && isset($_GET['item_id']) && isset($_GET['approval_details'])){
  	if($_GET['status'] != '' && $_GET['item_id'] != '' && $_GET['approval_details'] != ''){
  		$status = base64_decode(mysqli_real_escape_string($conn, $_GET['status']));
  		$item_id = base64_decode(mysqli_real_escape_string($conn, $_GET['item_id']));
  		$approval_details = base64_decode(mysqli_real_escape_string($conn, $_GET['approval_details']));
  		$flow = base64_decode(mysqli_real_escape_string($conn, $_GET['flow']));
  		$flowby = base64_decode(mysqli_real_escape_string($conn, $_GET['flow_by']));
  		$flows = $flow != '' ? explode(';',$flow) : [];
  		$allflows = "";
  		//echo "asss";
      $is_approval = false;
      $query = "SELECT * FROM requesteditem WHERE id = '".$item_id."'"; 
        $result = mysqli_query($conn, $query);
       if(mysqli_num_rows($result)> 0){
        while($row = mysqli_fetch_assoc($result)) {
          $item[] = $row;
        }
      }
      $query = "SELECT * FROM users WHERE id = '".$item[0]['staff_id']."'"; 
        $result = mysqli_query($conn, $query);
       if(mysqli_num_rows($result)> 0){
        while($row = mysqli_fetch_assoc($result)) {
          $user[] = $row;
        }
      }
  		foreach ($flows as $value) {
  			$who = explode(":", $value)[0];
  			if($allflows != "") $allflows .= ";";
  			if(strtolower($who) == strtolower($flowby)) {
          $is_approval = true;
          $allflows .= $approval_details.":".$status;
        }
  			else $allflows .= $value;
  		}
  		if(isset($_SESSION['user']['category']) && $_SESSION['user']['category'] == 'staff' && $is_approval == false){
  			if($status == 'received') 
  			  $sql = "UPDATE requesteditem SET received = '".$status."', received_date = '".date('Y-m-d')."' WHERE id = '".$item_id."'";
  			else if($status == 'returned')
  			  $sql = "UPDATE requesteditem SET returned = '".$status."', returned_date = '".date('Y-m-d')."' WHERE id = '".$item_id."'";	
	        if (mysqli_query($conn, $sql)) {
	        	$_SESSION['msg'] = "Your remark is noted.";
	        	//echo $_SESSION['msg'];
	        	header("Location: /outsourcing/request_details.php");
	        }else {
	        	$_SESSION['msg'] = "Error updating record, kindly try again later";
	        	 header("Location: /outsourcing/request_details.php");
	        }
  		}else {
        $lastflow = explode(":",$flows[count($flows)-1])[0];
        if($lastflow == $flowby) $stage = $approval_details;
  		$sql = "UPDATE requesteditem SET flow = '".$allflows."', stage = '".$stage."', status = '".$status."' WHERE id = '".$item_id."'";
        if (mysqli_query($conn, $sql)) {
            $send_to_next_approval = 0;
            //print_r($flows);
        	$_SESSION['msg'] = "Your remark is noted.";
          for($s = 0; $s < count($flows); $s++){
              $data = explode(":", $flows[$s]);
              if(count($data) > 0) { $who = $data[0];}
              if($send_to_next_approval == 1) {
                $send_to_next_approval = 0;
                $next_approval = explode(":", $flows[$s]);
                if(count($next_approval) > 1){
                  $email = $next_approval[1];
                  //print_r($user); return false;
                  //echo $user[0]['name']; return false;
                  $msg = "<div><p>Good Day,</p><p>".$user[0]['name']." has requested for ".$item[0]['name'].", kindly log in to account to view  more detail about the request.</p><p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'http://www.hrcore.ng'>Log In to view</a></p></div>";
                  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    process_data($conn,$email,$msg,'Item Request');
                    //echo $email;
                  }
                }
              }
              if($who == $flowby) $send_to_next_approval = 1;
            }
        	//echo $_SESSION['msg'];
        	header("Location: /outsourcing/approval_requisition_view.php");
        }else {
          //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        	$_SESSION['msg'] = "Error updating record, kindly try again later";
        	header("Location: /outsourcing/approval_requisition_view.php");
        }
      }  
       
  	}
  }
?>