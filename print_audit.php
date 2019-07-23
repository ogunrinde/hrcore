<?php 
include 'connection.php';
session_start();
$users = [];
 $year = isset($_SESSION['year']) ? $_SESSION['year'] : '';
 $month = isset($_SESSION['month']) ? $_SESSION['month'] : '';

 if($year == '' || $month == '') {
  $users = [];
  $query = "SELECT * FROM staff_audit_replies INNER JOIN users ON users.id = staff_audit_replies.staff_id INNER JOIN staff_audit ON staff_audit.admin_id = staff_audit_replies.admin_id WHERE staff_audit_replies.admin_id = '".$_SESSION['user']['id']."'";
 }else{
   $users = [];
   $query = "SELECT * FROM staff_audit_replies INNER JOIN users ON users.id = staff_audit_replies.staff_id INNER JOIN staff_audit ON staff_audit.admin_id = staff_audit_replies.admin_id WHERE staff_audit_replies.admin_id = '".$_SESSION['user']['id']."' AND staff_audit.month = '".$month."' AND staff_audit.year = '".$year."'";
 }
   $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
      }
  }
?>
<style type="text/css">
 .table-striped>tbody>tr:nth-of-type(odd){
    background-color: #f8fafc;
  }
  .table>tbody>tr>th{
    border-top: none;
  }
  .table>tbody>tr>td{
    border-top: none;
  }
</style>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title></title>

    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <style type="text/css">
 .table-striped>tbody>tr:nth-of-type(odd){
    background-color: #f8fafc;
  }
  .table>tbody>tr>th{
    border-top: none;
  }
  .table>tbody>tr>td{
    border-top: none;
  }
</style>  
<div class="container" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">  
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Audit</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a href ="#" id = "print" class="btn btn btn-sm" style="color: #fff;background-color:#26B99A;">Print Page</a>
                      </li>
                      <li><a href ="audit" id = "" class="btn btn-success btn-sm" style="color: #fff;background-color:#26B99A;">Return</a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead class="" style="background-color: rgba(52,73,94,.94);color:#fff;">
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title">Name</th>
                            <th class="column-title">Employee ID </th>
                            <th class="column-title">Department (Audit Period)</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($users); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$users[$h]['name']?></td>
                            <td class=" "><?=$users[$h]['employee_ID']?></td>
                            <td class=" "><?=$users[$h]['department']?> (<?=$users[$h]['month']?> <?=$users[$h]['year']?>)</td>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4 col-sm-12 col-xs-12">
                
              </div>
            </div>
              <div class="clearfix"></div>
            </div>
          </div>
</div>
<?php unset($_SESSION['month'])?>
<?php unset($_SESSION['year'])?>
<?php include "footer.php"?>
<script type="text/javascript" src="js/appraisal.js"></script>
<script type="text/javascript">
  $(function(){
    $("#print").on("click", function(e){
      e.preventDefault();
      window.print();
    })
  })
</script>
        
