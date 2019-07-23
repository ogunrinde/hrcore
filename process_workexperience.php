 <?php
 include 'connection.php';
 session_start();
 $last_id = "";
 if(isset($_POST['submit'])){
   $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
   $work_from = mysqli_real_escape_string($conn, $_POST['work_from']);
   $work_to = mysqli_real_escape_string($conn, $_POST['work_to']);
   $town = mysqli_real_escape_string($conn, $_POST['town']);
   $address = mysqli_real_escape_string($conn, $_POST['address']);
   $position = mysqli_real_escape_string($conn, $_POST['position']);
    if($company_name == '' || $work_from == '' || $work_to == ''){
      $msg = 'kindly input the all required details';
    }else {
       $sql = "INSERT INTO workexperience (company_name, work_from, work_to, town, address, position,staff_id, admin_id, date_created)
          VALUES ('".$company_name."', '".$work_from."', '".$work_to."','".$town."','".$address."','".$position."','".$_SESSION['user']['id']."','".$_SESSION['user']['admin_id']."','".date('Y-m-d')."')";
            if (mysqli_query($conn, $sql)) {
              $_SESSION['msg'] = "Your record has been updated";
              header("Location: /outsourcing/workexperience.php");
            }else {
              //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
               $_SESSION['msg'] = "Error while update account, please try again later";
               header("Location: /outsourcing/workexperience.php");
           }
    }
  }
  ?>