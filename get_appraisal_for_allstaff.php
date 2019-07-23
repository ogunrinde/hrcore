<?php
 session_start();
 if(isset($_GET['appraisal_id']) && $_GET['appraisal_id'] != ''){
    $appraisal_id = base64_decode($_GET['appraisal_id']);
     $staff_id = base64_decode($_GET['staff_id']);
    $_SESSION['appraisal_id'] = $appraisal_id;
    $_SESSION['staff_id'] = $staff_id;
    //echo $appraisal_id;
    header("Location: /outsourcing/see_thisStaff_appraisal.php");
 }
?>