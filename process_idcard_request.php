<?php
 include 'connection.php';
 session_start();
 $msg = '';
    if($_SESSION['user']['phone_number'] == '') $msg .= '<p>Phone Number,';
    if($_SESSION['user']['branch'] == '') $msg .= ' Branch, ';
    if($_SESSION['user']['name'] == '') $msg .= ' Surname, ';
    if($_SESSION['user']['fname'] == '') $msg .= ' First Name, ';
    if($_SESSION['user']['mname'] == '') $msg .= ' Middle Name, ';
    if($_SESSION['user']['marital_status'] == '') $msg .= 'Marital Status, ';
    if($_SESSION['user']['dob'] == '') $msg .= 'Date of Birth, ';
    if($_SESSION['user']['department'] == '') $msg .= 'Department, ';
    if($_SESSION['user']['lga'] == '') $msg .= 'Local Government Area, ';
    if($_SESSION['user']['sorigin'] == '') $msg .= ' State of Origin, '; 
    if($_SESSION['user']['address'] == '') $msg .= 'Address, ';
    if($_SESSION['user']['cdate_of_employeement'] == '') $msg .= 'Date of Employment, ';
   
if($_SESSION['user']['leave_flow'] == '') $msg .= 'Leave Approvers';
    if($msg != '') {
        header("Location: request_idcard.php");
        return false;
    }
 if(isset($_FILES['signature'])){
         
       if($_SESSION['user']['profile_image'] == 'user_profile.png'){
           $_SESSION['msg'] = 'Kindly upload your Passport';
            header("Location: request_idcard.php");
            return false;
       }
       if($_SESSION['user']['profile_image'] == ''){
           $_SESSION['msg'] = 'Kindly upload your Passport';
            header("Location: request_idcard.php");
            return false;
       }
       if($_SESSION['user']['branch'] == '' || $_SESSION['user']['fname'] == "" || $_SESSION['user']['name'] == ''){
           $_SESSION['msg'] = 'Kindly Update your employment details';
            header("Location: request_idcard.php");
            return false;
       }
       if($_FILES['signature']['name'] == null || !isset($_FILES['signature']['name'])) {
         $justification = mysqli_real_escape_string($conn, $_POST['justification']);
         $_SESSION['msg'] = 'Upload Signature';
            header("Location: request_idcard.php");
         //getsignature($conn,$justification);
       }else {
       $error = array();
       $file_ext = explode('.',$_FILES['signature']['name'])[1];
       $img = rand(1,9) * 9999999;
       $_name = str_replace("/","",$_SESSION['user']['employee_ID']);
       $file_name = $_name.'SIG.'.$file_ext;
       $file_size = $_FILES['signature']['size'];
       $file_tmp = $_FILES['signature']['tmp_name'];
       $file_type = $_FILES['signature']['type'];
       //$file_ext = explode('.',$_FILES['signature']['name'])[1];
       $extensions = array('jpeg','jpg','png');
       if(in_array($file_ext,$extensions) === false){
        $errors[] = "extension not allowed, please select a JPEG or PNG file.";
       }
       if($file_size > 2005097){
        $errors[] = "File size too large";
       }
       if(empty($errors)==true){
         
         //echo $file_to_delete;
         //return false;
         $_name = str_replace("/","",$_SESSION['user']['employee_ID']);
         $png = 'document/signature/'.$_name.'SIG.png';
         $jpg = 'document/signature/'.$_name.'SIG.jpg';
         $jpeg = 'document/signature/'.$_name.'SIG.jpeg';
         if(file_exists($png)){
            if(unlink($png)){
                //echo $png;
                //return false;
               process($conn,$file_name,$justification,$file_tmp);
            }
         }else if(file_exists($jpg)){
            if(unlink($jpg)){
               process($conn,$file_name,$justification,$file_tmp);
            }
         }else if(file_exists($jpeg)){
            if(unlink($jpeg)){
               process($conn,$file_name,$justification,$file_tmp);
            }
         }else{
            process($conn,$file_name,$justification,$file_tmp);
         } 
       }else {
         $_SESSION['msg'] = $errors[0];
       }
      header("Location: request_idcard.php");
    }
 }
 function process($conn,$file_name,$justification,$file_tmp){
   $sql = "INSERT INTO id_card (staff_id, admin_id, date_created, signature,status, justification)
          VALUES ('".$_SESSION['user']['id']."', '".$_SESSION['user']['admin_id']."', '".date('Y-m-d')."','".$file_name."', 'pending','".$justification."')";
          if (mysqli_query($conn,$sql ) === TRUE) {
            move_uploaded_file($file_tmp,"document/signature/".$file_name);  
            $_SESSION['msg'] = 'Request under processing';
            //header("Location: request_idcard.php");
          } else {
            $_SESSION['msg'] = 'Error while saving information, please try again later';
            //header("Location: request_idcard.php");
          }
    return true;      
 }
?>