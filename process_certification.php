 <?php
 include 'connection.php';
 session_start();
 $last_id = "";
 if(isset($_POST['submit'])){
   $certification = mysqli_real_escape_string($conn, $_POST['certification_name']);
   $date_cert = mysqli_real_escape_string($conn, $_POST['date_cert']);
    if($certification == '' || $date_cert == ''){
      $msg = 'kindly input the required information';
    }else {
       $sql = "INSERT INTO certifications (certification_name, date_cert,staff_id, admin_id)
          VALUES ('".$certification."', '".$date_cert."','".$_SESSION['user']['id']."','".$_SESSION['user']['admin_id']."')";
            if (mysqli_query($conn, $sql)) {
              $_SESSION['msg'] = "Your record has been updated";
              $last_id = $conn->insert_id;
            }else {
               $_SESSION['msg'] = "Error while update account, please try again later";
           }
      if(isset($_FILES['file'])){
       if($_FILES['file']['name'] == null) {
            header("Location: /outsourcing/certifications.php");
       }else{
        //echo "aaaaa";
         $error = array();
         $file_ext = explode('.',$_FILES['file']['name'])[1];
         $file_name = strtotime(date('Y-m-d')).'.'.$file_ext;
         $file_size = $_FILES['file']['size'];
         $file_tmp = $_FILES['file']['tmp_name'];
         $file_type = $_FILES['file']['type'];
         //$file_ext = explode('.',$_FILES['file']['name'])[1];
         $extensions = array('docx','xlsx','doc','pdf','jpg','jpeg','png');
         if(in_array($file_ext,$extensions) === false){
          $errors[] = "extension not allowed, please select a JPEG, PNG, docx, doc, xslx, pdf file.";
         }
         if($file_size > 209752){
          $errors[] = "File size too large";
         }
         if(empty($errors)==true){
           move_uploaded_file($file_tmp,"document/".$file_name);
            $sql = "UPDATE certifications SET document = '".$file_name."' Where id = '".$last_id."'";
            if (mysqli_query($conn, $sql)) {
              $_SESSION['msg'] = "Your record has been updated";
              header("Location: /outsourcing/certifications.php");
            }else {
              //echo "aaaaaaaaaaaaa";
            }

         }else {
           $msg = $errors[0];
           $_SESSION['msg'] = $msg;
           header("Location: /outsourcing/certifications.php");
         }
       }
      }
    }
  }
  ?>