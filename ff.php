<?php
include 'connection.php';
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
    
    $manager = getManagerDetails($conn,'michaeloladipo@keystonebankng.com');
    $employee_ID = isset($manager[0]['employee_ID']) ? $manager[0]['employee_ID'] : '';
               $password = isset($manager[0]['cpassword']) ? $manager[0]['cpassword'] : '';
    print_r($password);

?>