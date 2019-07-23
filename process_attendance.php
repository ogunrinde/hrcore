<?php
include "connection.php";
session_start();
if(isset($_POST['submit'])){
    //echo 'as';
    $e = 0;
    $branch = [];
    //$data = mysqli_real_escape_string($conn, $_POST['data']);
    $data = json_decode($_POST['data']);
    $period = mysqli_real_escape_string($conn, $_POST['period']);
    
    $user = [];
    $query = "SELECT * FROM branches WHERE manager_id = '".$_SESSION['user']['id']."'";
      $result = mysqli_query($conn, $query);
      
      if(mysqli_num_rows($result)> 0){
          while($row = mysqli_fetch_assoc($result)) {
            $user[] = $row;
          }
      }
      //print_r($user);
    foreach($data as $value){

        $exist = select($conn,$value,$period);
        if($exist == 0){
            $p = insert($conn,$value,$_SESSION['user']['id'],$_SESSION['user']['admin_id'],$user,$period);
            $e = $p + 1;
        }else if($exist > 0) {
           $p = update($conn,$value,$period);
           $e = $p + 1;
        }
        
        
    }
    echo $e;
    return false;
}
function insert($conn,$value,$id,$admin_id,$user,$period){
    $p = 0;
    $sql = "INSERT INTO attendances (employee_ID, branchID, days, month, year, admin_id, insert_by, date_created)
          VALUES ('".$value->id."', '".$user[0]['id']."', '".$value->days."','".$period."','".date('Y')."', '".$_SESSION['user']['admin_id']."','".$_SESSION['user']['id']."','".date('Y-m-d')."') ON DUPLICATE KEY UPDATE days = '".$value->days."'";
          if (mysqli_query($conn,$sql ) === TRUE) {
              //$_SESSION['msg'] = "New branch added";
              $p++;
              //header("Location: /outsourcing/branch.php");
          } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
             //$_SESSION['msg'] = "Error updating data, kindly try again later";
             //header("Location: /outsourcing/addbranch.php");
          }
    return $p;      
}
function select($conn,$value,$period){
    $v = 0;
    
     $query = "SELECT * from attendances WHERE employee_ID = '".$value->id."' AND month = '".$period."' AND year = '".date('Y')."'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0){
            $v = 1;
        } 
    return $v;    
}
function update($conn,$value,$period){
    $v = 0;
     $query = "Update attendances SET days = '".$value->days."' WHERE employee_ID = '".$value->id."' AND month = '".$period."' AND year = '".date('Y')."'";
        //$result = mysqli_query($conn, $query);
        if(mysqli_query($conn, $query) == TRUE){
            $v++;
        }else {

        } 
    return $v;    
}
?>