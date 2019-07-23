 <?php
 include "connection.php";
 session_start();
 $is_exist = 0;
 if(isset($_POST['submit'])){
 $period = mysqli_real_escape_string($conn, $_POST['app_period']);
 $year = mysqli_real_escape_string($conn, $_POST['app_year']);
 $user_company = mysqli_real_escape_string($conn, $_POST['user_company']); 
 $appraisal_data = mysqli_real_escape_string($conn, $_POST['appraisal_data']);
 $weight_data = mysqli_real_escape_string($conn, $_POST['weight_data']);
  $range = mysqli_real_escape_string($conn, $_POST['range']);
    $query = "SELECT * from appraisal WHERE (year = '$year' AND period = '$period' AND user_company = '$user_company')";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
      $is_exist = 1;
    }
    if($is_exist == 1){
      $_SESSION['msg'] = "You have already uploaded appraisal for year $year with an appraisal period of $period";
       //header("Location: create_appraisal.php");
       //return false;
    }
    if($appraisal_data == ''){
        $_SESSION['msg'] = "No Appraisal Information Added";
        echo "<script type='text/javascript'> document.location = 'create_appraisal.php'; </script>";
        return false;
    }
    $sql = "INSERT INTO appraisal (period, year, document, user_company, document_name, appraisal_data, admin_id, assigned_range, date_created,weight)
    VALUES ('".$period."', '".$year."','', '".$user_company."','input Question','".$appraisal_data."', '".$_SESSION['user']['id']."','".$range."', '".date('Y-m-d')."', '".$weight_data."')";
    if (mysqli_query($conn,$sql ) === TRUE) {
        $_SESSION['msg'] = "Appraisal successfully Uploaded";
        //header("Location: create_appraisal.php");
    } else {
        //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        $_SESSION['msg'] = "Error uploading Appraisal";
        //header("Location: create_appraisal.php");
    }
echo "<script type='text/javascript'> document.location = 'create_appraisal.php'; </script>";

}

?>