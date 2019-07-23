<?php
include "connection.php";
 $query = "SELECT * FROM company WHERE admin_id = '".$_POST['admin_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
  }
  print_r(base64_encode($data[0]['user_company']));

?>