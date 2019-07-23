<?php
    //$pass = 'Z57ppWeT75njs3yl';
    //$username = 'selfservice_user';
    //$db = 'selfservicedb';
    /*$pass = ')FjqHa0zh7hg';
    $username = 'smoothtr_service';
    $db = 'smoothtr_selfservicedb';
    $host = 'localhost';*/
    $pass = '';
    $db = 'hrcoreng_outsourcingdb';
    $host = 'localhost';
    $username = 'root';
    $conn = mysqli_connect($host, $username, $pass,$db);
    if($conn){
    	//echo 'connected';
    }
    else {
    	//echo "failed";
    }
    //db: smoothtr_selfservicedb
    //smoothtr_service
    //)FjqHa0zh7hg
?>
