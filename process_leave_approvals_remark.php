<?php
  include "connection.php";
  //session_start();
  include "process_email.php";
  session_start();
  $stage = "pending";
  //print_r($_SESSION['user']);
   function getManagerDetails($conn,$email){
        
      $sql = "SELECT * from users WHERE email = '".$email."' LIMIT 1";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result)> 0){
        while($row = mysqli_fetch_assoc($result)) {
          $manager[] = $row;
        }
      }
        return $manager;
    }
  if(isset($_GET['status']) && isset($_GET['leave_id']) && isset($_GET['approval_details'])){
    //print_r($_GET['approval_details']);
  	if($_GET['status'] != '' && $_GET['leave_id'] != '' && $_GET['approval_details'] != ''){
      //print_r($_GET['status']);
       $query = "SELECT * FROM leaves WHERE id = '".base64_decode($_GET['leave_id'])."'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)> 0){
            while($row = mysqli_fetch_assoc($result)) {
              $leave[] = $row;
            }
        }
        $sql = "SELECT * FROM users WHERE id = '".$leave[0]['staff_id']."'";
        $res = mysqli_query($conn, $sql);
            if(mysqli_num_rows($res)> 0){
                while($row = mysqli_fetch_assoc($res)) {
                  $user[] = $row;
                }
                $full_leave_flow = $user[0]['leave_flow'];
                
        }
       //print_r($_GET['status']); 
  		$status = base64_decode(mysqli_real_escape_string($conn, $_GET['status']));
  		$remark = base64_decode(mysqli_real_escape_string($conn, $_GET['remark']));
  		$leave_id = base64_decode(mysqli_real_escape_string($conn, $_GET['leave_id']));
  		$approval_details = base64_decode(mysqli_real_escape_string($conn, $_GET['approval_details']));
  		$flow = base64_decode(mysqli_real_escape_string($conn, $_GET['flow']));
  		$flowby = base64_decode(mysqli_real_escape_string($conn, $_GET['flow_by']));
  		$flows = $flow != '' ? explode(';',$flow) : [];
  		$allflows = "";
  		$remarks = $leave[0]['remarks'] == '' ? [] : explode(';',$leave[0]['remarks']);
  		$allremarks = "";
  		foreach ($flows as $value) {
  			$who = explode(":", $value)[0];
  			if($allflows != "") $allflows .= ";";
  			if($allremarks != "") $allremarks .= ";";
  			if($who == $flowby){
  			    //echo $approval_details;
  			    $allflows .= $approval_details.":".$status;
  			    $allremarks .= $approval_details.":".$remark;
  			}
  			else {
  			    //echo 'okay';
  			    $allflows .= $value;
  			    if($leave[0]['remarks'] == '') $allremarks .= $value;
  			    else {
  			        $get_remarks = explode(';',$leave[0]['remarks']);
  			        foreach($get_remarks as $val){
  			            $title_msg = explode(':',$val);
  			            if(count($title_msg) > 1){
  			                $title_b = explode(':',$value);
  			                if(count($title_b) > 1){
  			                    if($title_msg[0] == $title_b[0]){
  			                        $allremarks .= $val;
  			                    }
  			                }else {
  			                    $allremarks .= '';
  			                }
  			            }else {
  			                $allremarks .= '';
  			            }
  			        }
  			        
  			        
  			    }
  			    
  			}
  		}
  		
      


      //echo $allremarks;
      //return false;

        $lastflow = explode(":",$flows[count($flows)-1])[0];
        //if($lastflow == $flowby && $leave[0]['status'] == 'approved') $stage = $status;
        if($status == 'decline') $stage = $status;
        
        
        $check_flow = explode(';',$leave[0]['flow']);
        $lmanager = '';
        $bmanager = '';
        for($i = 0; $i < count($check_flow); $i++){
            $eachflow = explode(':', $check_flow[$i]);
            if(count($eachflow) > 1){
                if($eachflow[0] == 'Line Manager' && $eachflow[1] == 'approved') $lmanager = 'approved';
                if($eachflow[0] == 'Branch Manager' && $eachflow[1] == 'approved')
                    $bmanager = 'approved';
            }
        }
        
        if($flowby == 'Line Manager' && $bmanager == 'approved' && $status == 'approved') $stage = $status;
        if($flowby == 'Branch Manager' && $lmanager == 'approved' && $status == 'approved') $stage = $status;

        
        //if($flowby == 'Branch Manager') $lManager_remark = $status;
  		$sql = "UPDATE leaves SET flow = '".$allflows."',remarks = '".$allremarks."', stage = '".$stage."', status = '".$status."' WHERE id = '".$leave_id."'";
        if (mysqli_query($conn, $sql)) {
          $send_to_next_approval = 0;
          for($s = 0; $s < count($flows); $s++){
            $data = explode(":", $flows[$s]);
            if(count($data) > 0) $who = $data[0];
            if($send_to_next_approval == 1) {
              $send_to_next_approval = 0;
              $next_approval = explode(":", $flows[$s]);
              if(count($next_approval) > 1){
                $email = trim($next_approval[1]);
                $manager = getManagerDetails($conn,$email);
                //echo $get_first_approval_email;
                $employee_ID = isset($manager[0]['employee_ID']) ? $manager[0]['employee_ID'] : '';
                $password = isset($manager[0]['cpassword']) ? $manager[0]['cpassword'] : '';
                $msg = "<div><p>Good Day,</p><p>".$user[0]['name']." has requested for ".$leave[0]['leave_type']." leave. As the ".$next_approval[0].", kindly log In and take the neccessary action on this request. </p> <p style='color:red;'>Your login Details is username : ".$employee_ID." and Password: ".$password."</p><p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'https://www.hrcore.ng/outsourcing/login'>Log In to view</a></p></div>";
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    //$status = $email;
                    if($status == 'approved' || $status == 'Approved'){
                        process_data($conn,$email,$msg,'Leave Request');
                        if($stage == 'Approved' || $stage == 'approved'){
                             $lmanager = "<div><p>Good Day,</p><p>".$user[0]['name']." has requested for ".$leave[0]['leave_type']." leave. As the Leave Manager, kindly log In and take the neccessary action on this request. </p><p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'https://www.hrcore.ng/outsourcing/login'>Log In to view</a></p></div>";
                             //process_data($conn,'leave@icsoutsourcing.com',$lmanager,'Leave Request');
                        }
                    }
                      
                }
              }
            }
            if($who == $flowby) $send_to_next_approval = 1;
          }
          $status = '<b style="text-transform:uppercase">'.$status.'</b>';
          $_SESSION['msg'] = "You have successfully $status this leave request";
        	//echo $_SESSION['msg'];
        	//$_SESSION['msg'] = 'Remark Noted';
        	//header("Location: approval_leave_view.php");
        	//echo "<script type='text/javascript'> document.location = 'approval_leave_view.php'; </script>";
        }else {
            //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            //return false;
        	$_SESSION['msg'] = "Error updating record, kindly try again later";
        	 //header("Location: approval_leave_view.php");
        	 //echo "<script type='text/javascript'> document.location = 'approval_leave_view.php'; </script>";
        } 
       
  	}
  }
  echo "<script type='text/javascript'> document.location = '/outsourcing/approval_leave_view.php'; </script>";
?>