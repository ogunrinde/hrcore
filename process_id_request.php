<?php
include "connection.php";
include "process_email.php";
session_start();
if(isset($_POST['submit'])){
	$comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $remark = mysqli_real_escape_string($conn, $_POST['remark']);
    $request_id = mysqli_real_escape_string($conn, $_POST['id_card_request_id']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $signature = mysqli_real_escape_string($conn, $_POST['signature']);

    //echo $request_id;
    $sql = "UPDATE id_card SET status = '".$remark."', comment = '".$comment."' WHERE IID = '".$request_id."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Request $remark";
            msg($conn,$name,$email,$comment,$remark);
            if(strtolower($remark) == 'decline'){
                //$file_to_delete = 'document/signature/'.$signature;
                //unlink($file_to_delete);
            }
            header("Location: /outsourcing/view_all_id_request.php");
            
        } else {
            //echo "Error updating record: " . mysqli_error($conn);
            $_SESSION['msg'] = "Error updating comment, kindly try again later";
            header("Location: /outsourcing/view_all_id_request.php");
        }
}

if(isset($_POST['approved'])){
    $request_id = mysqli_real_escape_string($conn, $_POST['request_id']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    //echo $request_id;
    $sql = "UPDATE id_card SET status = 'Approved' WHERE IID = '".$request_id."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Request Approved";
            msg($conn,$name,$email,'','approved');
            header("Location: /outsourcing/view_all_id_request.php");
            
        } else {
            //echo "Error updating record: " . mysqli_error($conn);
            $_SESSION['msg'] = "Error updating comment, kindly try again later";
            header("Location: /outsourcing/view_all_id_request.php");
        }
}

if(isset($_POST['delete'])){
    $request_id = mysqli_real_escape_string($conn, $_POST['request_id']);
     $signature = mysqli_real_escape_string($conn, $_POST['signature']);
    $sql = "UPDATE id_card SET status = 'deleted' WHERE IID = '".$request_id."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Request Deleted";
            //msg($conn,$name,$email,'','approved');
            //$file_to_delete = 'document/signature/'.$signature;
            //unlink($file_to_delete);
            header("Location: /outsourcing/view_all_id_request.php");
            
        } else {
            //echo "Error updating record: " . mysqli_error($conn);
            $_SESSION['msg'] = "Error deleting comment, kindly try again later";
            header("Location: /outsourcing/view_all_id_request.php");
        }
}
function msg($conn,$name,$email,$comment,$remark){
    $comment = strtolower($remark) == 'approved' ? 'Your ID Card request has been approved and is in processing' : $comment;
    $msg = "<div><p>Good Day ".$name.",</p><p>".$comment."</p> <p><a  style ='padding:7px;color:#fff;background-color:#4e73df;margin:10px;border-radius: 3px;text-decoration:none' href = 'https://www.hrcore.ng/outsourcing/login'>Log In to view</a></p></div>";
               if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    process_data($conn,$email,$msg,'ID Card Request');
                }
    return true;            
}
if(isset($_POST['justification_update'])){
	$justification = mysqli_real_escape_string($conn, $_POST['justification']);
    $request_id = mysqli_real_escape_string($conn, $_POST['id_card_request_id']);
    //echo $request_id;
    $sql = "UPDATE id_card SET justification = '".$justification."', status = 'Staff updated Justification' WHERE IID = '".$request_id."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = "Justification updated";
            header("Location: /outsourcing/view_id_request_status.php");
            
        } else {
            //echo "Error updating record: " . mysqli_error($conn);
            $_SESSION['msg'] = "Error updating comment, kindly try again later";
            header("Location: /outsourcing/view_id_request_status.php");
        }
}
?>