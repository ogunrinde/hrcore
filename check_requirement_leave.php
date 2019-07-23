<?php
include "connection.php";
//session_start();
$counter = 0;
//return print_r($_SESSION['user']);
//test($conn,$_SESSION['user']);
$p = 0; 
function get_days($start_date,$end_date){
	$counter = 0;
 $no_included = ['Mon','Tue','Wed','Thu','Fri'];
 //echo date('N',strtotime('2019-03-31'));
 while(strtotime($start_date) <= strtotime($end_date)){
    if(date("N",strtotime($start_date))<=5) {
    	//echo date("N",strtotime($start_date));
        $counter++;
    }
    $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));

  }
  return $counter;
}
function get_annual_leave_and_process($conn,$staff_id,$leave_type,$year, $start_date,$end_date,$user){
   $all_used_annual_leave = 0;	
   $query = "SELECT * FROM leaves WHERE year = '".$year."' AND staff_id = '".$staff_id."' AND leave_type = '".$leave_type."' AND processed != 'Cancelled' AND stage != 'decline'";
	  $result = mysqli_query($conn, $query);
	  if(mysqli_num_rows($result)> 0){
	  	 while($row = mysqli_fetch_assoc($result)){
	  	 	//print_r($row);
	  	 	$used_annual_leave = get_days($row['start_date'],$row['end_date']);
	  	 	$all_used_annual_leave = $all_used_annual_leave + $used_annual_leave;
	  	 }
	  	 $going_leave = get_days($start_date,$end_date);
	  	 $total = $going_leave + $all_used_annual_leave;
		 $specified = get_allowed_days($conn,$user,$leave_type);
		 //echo $specified;
         if($total > $specified) return 'Leave Processing Failed...The specified number of days you can go for '.$leave_type.' Leave is '.$specified.' days in a year, however you have '.($specified - $all_used_annual_leave).' days left';
         else return 1;

	  }else {
	  	 $going_leave = get_days($start_date,$end_date);
		 $specified = get_allowed_days($conn,$user,$leave_type);
         if($going_leave > $specified) return 'Leave Processing Failed...The specified number of days you can go for '.$leave_type.' Leave is '.$specified.' days';
         else return 1;
	  } 

}
function get_allowed_days($conn, $user,$leave_kind){
	$query = "SELECT * FROM leave_type WHERE company = '".$user['user_company']."' AND leave_kind = '".$leave_kind."'";
	  $result = mysqli_query($conn, $query);
	  if(mysqli_num_rows($result)> 0){
	  	 $row = mysqli_fetch_assoc($result);
		 return $row['days'];
	  }else {
	  	 return 100000;
	  } 
}
function check_annual_first_before_casual($conn,$staff_id,$year,$start_date,$end_date,$user,$leave_type){
    $all_used_annual_leave = 0;	
    $query = "SELECT * FROM leaves WHERE year = '".$year."' AND staff_id = '".$staff_id."' AND leave_type = 'Annual' AND processed != 'Cancelled' AND stage != 'decline'";
	  $result = mysqli_query($conn, $query);
	  if(mysqli_num_rows($result)> 0){
	  	 while($row = mysqli_fetch_assoc($result)){
	  	 	$used_annual_leave = get_days($row['start_date'],$row['end_date']);
	  	 	$all_used_annual_leave = $all_used_annual_leave + $used_annual_leave;
	  	 }
	  	 $going_leave = get_days($start_date,$end_date);
	  	 //$total = $going_leave + $all_used_annual_leave;
		 $specified = get_allowed_days($conn,$user,'Annual');
		 //echo $total;
		 //return $all_used_annual_leave."__".$specified;
         if((int)$all_used_annual_leave == (int)$specified){
         	return causal_leave_process($conn,$staff_id,$leave_type,$year, $start_date,$end_date,$user);
         	
         } 
         else return 'You have to exhaust your Annual leave before requesting for '.$leave_type.' leave';

	  }else {
	  	 return 'You have to exhaust your Annual leave before requesting for '.$leave_type.' leave';
	  }
}

//other_leave_process
function other_leave_process($conn,$staff_id,$leave_type,$year, $start_date,$end_date,$user){
   $all_used_leave = 0;	
   $query = "SELECT * FROM leaves WHERE year = '".$year."' AND staff_id = '".$staff_id."' AND leave_type = '".$leave_type."' AND processed != 'Cancelled' AND stage != 'decline'";
	  $result = mysqli_query($conn, $query);
	  if(mysqli_num_rows($result)> 0){
	  	 while($row = mysqli_fetch_assoc($result)){
	  	 	//print_r($row);
	  	 	$used_leave = get_days($row['start_date'],$row['end_date']);
	  	 	$all_used_leave = $all_used_leave + $used_leave;
	  	 }
	  	 $going_leave = get_days($start_date,$end_date);
	  	 $total = $going_leave + $all_used_leave;
		 $specified = get_allowed_days($conn,$user,$leave_type);
		 //echo $specified;
		 $left = $specified - $all_used_leave;
         if($total > $specified) return 'Leave Processing Failed...You have '.$left.' days left for '.$leave_type.' Leave this year';
         else return 1;

	  }else {
	  	 $going_leave = get_days($start_date,$end_date);
		 $specified = get_allowed_days($conn,$user,$leave_type);
         if($going_leave > $specified) return 'Leave Processing Failed...The specified number of days you can go for '.$leave_type.' leave is '.$specified.' days in a year';
         else return 1;
	  } 

}


function causal_leave_process($conn,$staff_id,$leave_type,$year, $start_date,$end_date,$user){
   $all_used_casual_leave = 0;	
   $query = "SELECT * FROM leaves WHERE year = '".$year."' AND staff_id = '".$staff_id."' AND leave_type = '".$leave_type."' AND processed != 'Cancelled' AND stage != 'decline'";
	  $result = mysqli_query($conn, $query);
	  if(mysqli_num_rows($result)> 0){
	  	 while($row = mysqli_fetch_assoc($result)){
	  	 	//print_r($row);
	  	 	$used_casual_leave = get_days($row['start_date'],$row['end_date']);
	  	 	$all_used_casual_leave = $all_used_casual_leave + $used_casual_leave;
	  	 }
	  	 $going_leave = get_days($start_date,$end_date);
	  	 $total = $going_leave + $all_used_casual_leave;
		 $specified = get_allowed_days($conn,$user,$leave_type);
		 //echo $specified;
         $left = $specified - $all_used_casual_leave;
         if($total > $specified) return 'Leave Processing Failed...You have '.$left.' days left for '.$leave_type.' Leave this year';
         else return 1;

	  }else {
	  	 $going_leave = get_days($start_date,$end_date);
		 $specified = get_allowed_days($conn,$user,$leave_type);
         if($going_leave > $specified) return 'Leave Processing Failed...The specified number of days you can go for '.$leave_type.' leave is '.$specified.' days in a year';
         else return 1;
	  } 

}
function test($conn,$user){
	//($conn,$staff_id,$year,$start_date,$end_date)
  $state = check_annual_first_before_casual($conn,'23','2019','2019-03-27','2019-03-29',$user,'Casual');	
  //$state = get_annual_leave_and_process($conn,'23','Annual','2019','2019-03-27','2019-03-29',$user);
  //echo $state;
}

?>