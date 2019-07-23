<?php
 session_start();
 if(isset($_GET['appraisal_id']) && $_GET['appraisal_id'] != ''){
    $appraisal_id = base64_decode($_GET['appraisal_id']);
    $_SESSION['appraisal_id'] = $appraisal_id;
    //echo $appraisal_id;
    header("Location: /outsourcing/see_this_appraisal.php");
 }
?>