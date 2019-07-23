 <?php
 include 'connection.php';
 session_start();
 $last_id = "";
 if(isset($_POST['submit'])){
   $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
   $grade = mysqli_real_escape_string($conn, $_POST['grade']);
   $institution = mysqli_real_escape_string($conn, $_POST['institution']);
   $course_of_study = mysqli_real_escape_string($conn, $_POST['course_of_study']);
   $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
   $date_obtained = mysqli_real_escape_string($conn, $_POST['date_obtained']);
    if($qualification == ''){
      $msg = 'kindly input the qualification you acquired';
    }else {
       $sql = "INSERT INTO qualifications (qualification_name, grade, institution, course_of_study, date_obtained, specialization,staff_id, admin_id)
          VALUES ('".$qualification."', '".$grade."', '".$institution."','".$course_of_study."','".$date_obtained."','".$specialization."','".$_SESSION['user']['id']."','".$_SESSION['user']['admin_id']."')";
            if (mysqli_query($conn, $sql)) {
              $_SESSION['msg'] = "Your record has been updated";
              $last_id = $conn->insert_id;
            }else {
               $_SESSION['msg'] = "Error while update account, please try again later";
           }
      if(isset($_FILES['file'])){
       if($_FILES['file']['name'] == null) {
            header("Location: /outsourcing/qualification.php");
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
            $sql = "UPDATE qualifications SET document = '".$file_name."' Where id = '".$last_id."'";
            if (mysqli_query($conn, $sql)) {
              $_SESSION['msg'] = "Your record has been updated";
              header("Location: /outsourcing/qualification.php");
            }else {
              //echo "aaaaaaaaaaaaa";
            }

         }else {
           $msg = $errors[0];
           $_SESSION['msg'] = $msg;
           header("Location: /outsourcing/qualification.php");
         }
       }
      }
    }
  }
  ?>