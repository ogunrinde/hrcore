 <?php
 ob_start();
 include "connection.php";
 session_start();
 $is_exist = 0;
 if(isset($_POST['submit'])){
 $period = mysqli_real_escape_string($conn, $_POST['period']);
 $year = mysqli_real_escape_string($conn, $_POST['year']);
 //$department = mysqli_real_escape_string($conn, $_POST['department']); 
 $user_company = mysqli_real_escape_string($conn, $_POST['user_company']);
 //$appraisal_flow = getappraisal_flow($conn);
  $query = "SELECT * from appraisal WHERE year = '$year' AND period = '$period' AND user_company = '$user_company'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
      $is_exist = 1;
    }
    if($is_exist == 1){
      $_SESSION['msg'] = "You have already uploaded appraisal for year $year with an appraisal period of $period";
       //header("Location: create_appraisal.php");
       //return false;
    }
  if($period != '' && $year != ''){
     if(isset($_FILES['document'])){
     if($_FILES['document']['name'] == null){
        $_SESSION['msg'] = "Kindly attached appraisal file to upload";
        //header("Location: create_appraisal.php");
        //return false;
     }else {
       $error = array();
       $file_ext = explode('.',$_FILES['document']['name'])[1];
       $name = rand(1,9) * 9999999;
       $file_name = strtotime(date('Y-m-d')).'.'.$file_ext;
       $file_size = $_FILES['document']['size'];
       $file_tmp = $_FILES['document']['tmp_name'];
       $file_type = $_FILES['document']['type'];
       $extensions = array('docx','doc','csv','xlsx');
       if(in_array($file_ext,$extensions) === false){
        $errors[] = "extension not allowed, please select a docx, doc, csv or xlsx file.";
       }
       if($file_size > 209752){
        $errors[] = "File size too large";
       }
       if(empty($errors)==true){
         move_uploaded_file($file_tmp,"document/".$file_name);
          $sql = "INSERT INTO appraisal (period, year, document, document_name, admin_id, user_company, date_created)
          VALUES ('".$period."', '".$year."','".$file_name."','".$_FILES['document']['name']."', '".$_SESSION['user']['id']."', '".$user_company."', '".date('Y-m-d')."')";
          if (mysqli_query($conn,$sql ) === TRUE) {
              $_SESSION['msg'] = "Appraisal successfully Uploaded";
              //header("Location: https://www.hrcore.ng/outsourcing/create_appraisal.php");
          } else {
              //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              $_SESSION['msg'] = "Error uploading Appraisal";
              //return false;
              //header("Location: create_appraisal.php");
          }

       }else {
         $msg = $errors[0];
         $_SESSION['msg'] = $msg;
         //header("Location: create_appraisal.php");
         //return false;
       }
     }
   }
  }else {
    $_SESSION['msg'] = "Kindly complete all input field";
    //header("Location: create_appraisal.php");
  }
    echo "<script type='text/javascript'> document.location = 'create_appraisal.php'; </script>";
   
 }
 //header("Location: create_appraisal");
 ob_end_flush();
?>