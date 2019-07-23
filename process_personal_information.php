 <?php
 include 'connection.php';
 session_start();
 $last_id = "";
 if(isset($_POST['submit'])){
   $surname = mysqli_real_escape_string($conn, $_POST['surname']);
   $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
   $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
   $gender = mysqli_real_escape_string($conn, $_POST['gender']);
   $dob = mysqli_real_escape_string($conn, $_POST['dob']);
   $town = mysqli_real_escape_string($conn, $_POST['town']);
   $state = mysqli_real_escape_string($conn, $_POST['state']);
   $country = mysqli_real_escape_string($conn, $_POST['country']);
    if($surname == '' && $firstname == '' && $gender == '' && $dob == ""){
      $msg = 'kindly input all the required Information';
    }else {
       $admin_id = select_exist($conn);
       if($admin_id == 0){
       $sql = "INSERT INTO personal_information (surname, firstname, middlename, gender, DOB, town,state, country, staff_id, admin_id, date_created)
          VALUES ('".$surname."', '".$firstname."', '".$middlename."','".$gender."','".$dob."','".$town."', '".$state."','".$country."' ,'".$_SESSION['user']['id']."','".$_SESSION['user']['admin_id']."', '".date('Y-m-d')."')";
            if (mysqli_query($conn, $sql)) {
              $_SESSION['msg'] = "Your record has been updated";
              $last_id = $conn->insert_id;
            }else {
               $_SESSION['msg'] = "Error while update account, please try again later";
           }
      }else {
          Update_data($conn, $surname, $firstname,$middlename,$gender, $dob, $town, $state, $country);
      }
       header("location: /outsourcing/personal_information.php");
    }
  }
  function select_exist($conn){
      $query = "SELECT * FROM personal_information WHERE admin_id = '".$_SESSION['user']['admin_id']."' AND staff_id = '".$_SESSION['user']['id']."'";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result)> 0){
          $row = mysqli_fetch_assoc($result);
          $admin_id = $row['id'];
          return $admin_id;
          //return Update_data($conn, $surname, $firstname,$middlename,$gender, $dob, $town, $state, $country);
      }
      return 0;
  }
  function update_data($conn, $surname, $firstname,$middlename,$gender, $dob, $town, $state, $country){
    $sql = "UPDATE personal_information SET surname = '".$surname."', firstname = '".$firstname."', middlename = '".$middlename."', gender = '".$gender."', DOB = '".$dob."', town = '".$town."', state = '".$state."', country = '".$country."' WHERE staff_id = '".$_SESSION['user']['id']."'";
        if (mysqli_query($conn, $sql)) {
           $_SESSION['msg'] = "Your record has been updated";
        } else {
            $_SESSION['msg'] = "Error updating record, kindly try again later";
            //header("Location: settings.php");
        }
        return true;
  }
  ?>