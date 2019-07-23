<?php
include "connection.php";
session_start();
if(isset($_POST['submit'])){
	$purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
	$justification = mysqli_real_escape_string($conn, $_POST['justification']);
	$amount = mysqli_real_escape_string($conn, $_POST['amount']);
	$admin_id = $_SESSION['user']['admin_id'];
	$staff_id = $_SESSION['user']['id'];
	$flow = $_SESSION['user']['cash_flow'];
	$sql = "INSERT INTO cash_request (purpose, justification,amount,staff_id, admin_id,flow,date_created)
      VALUES ('".$purpose."', '".$justification."','".$amount."','".$staff_id."','".$admin_id."','".$flow."','".date('Y-m-d')."')";
        if (mysqli_query($conn, $sql)) {
          $_SESSION['msg'] = "Your Cash request is under processing";
          $last_id = $conn->insert_id;
        }else {
        	//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        	//return false;
           $_SESSION['msg'] = "Error while saving data, please try again later";
       }
  	   processattach_document($conn, $_FILES['attach_document'],$admin_id);
}
function processattach_document($conn,$attach_document,$admin_id){
  	if(isset($attach_document)){
       if($attach_document['name'] == null) {
       		  header("Location: make_request");
       }else {

       $error = array(); 
       $file_ext = explode('.',$attach_document['name'])[1];
       $img = explode('.',$attach_document['name'])[0].'_'.strtotime(date('Y-m-d'));
       $file_name = $img.'.'.$file_ext;
       $file_size = $attach_document['size'];
       $file_tmp = $attach_document['tmp_name'];
       $file_type = $attach_document['type'];
       //$file_ext = explode('.',$_FILES['attach_document']['name'])[1];
       $extensions = array('jpeg','jpg','png','doc','docx','pdf','txt','csv','xlsx');
       if(in_array($file_ext,$extensions) === false){
        $errors[] = "extension not allowed, please select a JPEG, JPG, DOC, DOCX,PDF,XLSX,CSV or PNG file.";
       }
       if($file_size > 209752){
        $errors[] = "File size too large";
       }
       if(empty($errors)==true){
         move_uploaded_file($file_tmp,"document/".$file_name);
         $last_id = $conn->insert_id;
          $sql = "UPDATE cash_request SET document = '".$file_name."' Where id = '".$last_id."'";
          if (mysqli_query($conn, $sql)) {
          	header("Location: make_request");
          }else {$_SESSION['msg'] = 'Error updating data'; return false;}
       }else {
         $msg = $errors[0];
         $_SESSION['msg'] = $msg;
         header("Location: make_request");
       }
       }
    }
  }

?>