<?php
 include "connection.php";
 session_start();
 $leaves = [];
 $result = [];
 $Jan = 0;
 $Feb = 0;
 $Mar = 0;
 $May = 0;
 $Apr = 0;
 $Jun = 0;
 $Jul = 0;
 $Aug = 0;
 $Sept = 0;
 $Oct = 0;
 $Nov = 0;
 $Dec = 0;
  if($_SESSION['user']['category'] == 'admin')
    $query = "SELECT * FROM leaves WHERE admin_id = '".$_SESSION['user']['id']."'";
  else if($_SESSION['user']['category'] == 'staff')
    $query = "SELECT * FROM leaves WHERE staff_id = '".$_SESSION['user']['id']."'";	
    $res = mysqli_query($conn, $query);
  if(mysqli_num_rows($res)> 0){
      while($row = mysqli_fetch_assoc($res)) {
        $leaves[] = $row;
      }
  }
  foreach ($leaves as $leave) {
  	 $start_month = explode("-",$leave['start_date'])[1];
  	 $start_year = explode("-",$leave['start_date'])[0];
  	 if($start_year == date('Y')){
  	 	 if((int)$start_month == 1) $Jan++;
	  	 else if((int)$start_month == 2) $Feb++;
	  	 else if((int)$start_month == 3) $Mar++;
	  	 else if((int)$start_month == 4) $Apr++;
	  	 else if((int)$start_month == 5) $May++;
	  	 else if((int)$start_month == 6) $Jun++;
	  	 else if((int)$start_month == 7) $Jul++;
	  	 else if((int)$start_month == 8) $Aug++;
	  	 else if((int)$start_month == 9) $Sept++;
	  	 else if((int)$start_month == 10) $Oct++;
	  	 else if((int)$start_month == 11) $Nov++;
	  	 else if((int)$start_month == 12) $Dec++;
  	 }
  }
  $result[0] = $Jan;
  $result[1] = $Feb;
  $result[2] = $Mar;
  $result[3] =$Apr;
  $result[4] = $May;
  $result[5] = $Jun;
  $result[6] = $Jul;
  $result[7] = $Aug;
  $result[8] = $Sept;
  $result[9] = $Oct;
  $result[10] = $Nov;
  $result[11] = $Dec;
  echo(implode(';',$result));
?>