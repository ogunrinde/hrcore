<?php
  include 'connection.php';
  session_start(); 
  $msg = '';
  $data = [];
  $admin_id = '';
  //echo $_POST['appraisalflow'];
  $query = "SELECT * FROM company WHERE admin_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
  }
  if(isset($_POST['submit'])){
       $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
       $address = mysqli_real_escape_string($conn, $_POST['address']);
       $user_company = mysqli_real_escape_string($conn, $_POST['user_company']);
        $sql = "UPDATE users SET first_time_loggin = '0' WHERE id = '".$_SESSION['user']['id']."'";
        if (mysqli_query($conn, $sql)) { $msg =  true; } else { }
       //echo $branch;
    if(count($data) > 0){
       $sql = "UPDATE company SET company_name = '".$company_name."', user_company = '".$user_company."', address = '".$address."' WHERE id = '".$data[0]['id']."'";
        if (mysqli_query($conn, $sql)) {
            $msg =  true;
        } else {
           $msg = false;
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            $_SESSION['msg'] = "Error updating data, kindly try again later";
            //return false;
        }
    }else {
      $sql = "INSERT INTO company (company_name, address, admin_id, date_created, user_company)
          VALUES ('".$company_name."','".$address."','".$_SESSION['user']['id']."','".date('Y-m-d')."','".$user_company."')";
          if (mysqli_query($conn,$sql ) === TRUE) {
              $msg = true;
              //header("Location: login.php");
          } else {
              //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
             $_SESSION['msg'] = "Error updating data, kindly try again later";
              $msg = false;
          }
    }
    if(isset($_FILES['image'])){
       if($_FILES['image']['name'] == null) {
            echo $msg;
       }else {
       $error = array(); 
       $file_ext = explode('.',$_FILES['image']['name'])[1];
       $img = explode('.',$_FILES['image']['name'])[0].'_'.strtotime(date('Y-m-d'));
       $file_name = $img.'.'.$file_ext;
       $file_size = $_FILES['image']['size'];
       $file_tmp = $_FILES['image']['tmp_name'];
       $file_type = $_FILES['image']['type'];
       //$file_ext = explode('.',$_FILES['image']['name'])[1];
       $extensions = array('jpeg','jpg','png');
       if(in_array($file_ext,$extensions) === false){
        $errors[] = "extension not allowed, please select a JPEG or PNG file.";
       }
       if($file_size > 209752){
        $errors[] = "File size too large";
       }
       if(empty($errors)==true){
         move_uploaded_file($file_tmp,"images/".$file_name);
          $sql = "UPDATE company SET image = '".$file_name."' Where admin_id = '".$_SESSION['user']['id']."'";
          if (mysqli_query($conn, $sql)) {
            $_SESSION['logo'] = $file_name;
            $msg = true;
          }else {$_SESSION['msg'] = 'Error updating data'; $msg = false;}

       }else {
         $msg = $errors[0];
         $_SESSION['msg'] = $msg;
         $msg = false;
       }
       }
    }
    /*aaaaaaaaaaif($appraisalflow != ''){
       $category = [];
       $appraisal_flow = explode(";", $appraisalflow);
       $query = "SELECT * FROM category";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)> 0){
            while($row = mysqli_fetch_assoc($result)) {
              $category = $row;
            }
            foreach ($appraisal_flow as $value) {
              if(in_array($value, $category)) {}
            }
        }
    }*/
    echo $msg;
    return false;
  }  
?>