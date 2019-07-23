<?php
session_start();
if(isset($_GET['job_id']) && $_GET['job_id'] != ''){
   $_SESSION['this_job'] = base64_decode($_GET['job_id']);
   $_SESSION['this_job_title'] = base64_decode($_GET['title']);
   //echo $_SESSION['this_job_title'];
   header("Location: /ess/jobportal.php");
}
?>