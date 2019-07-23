<?php 
include 'connection.php';
session_start();
$kss = [];
$admin_id;
$users = [];
$show_month = "";
$show_year = "";
$ID = "";
$audited = 'false';
$audit_begin = 'false';
$id_permission = [];
$leave_permission = [];
$payroll_permission = [];
 if(!isset($_SESSION['user']['id'])) header("Location: login.php");
 if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
 else if ($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT kss.information,users.name,users.employee_ID FROM kss INNER JOIN users ON kss.staff_id = users.id WHERE kss.admin_id = '".$admin_id."'ORDER BY kss.id LIMIT 1";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $kss[] = $row;
      }
  }
  $query = "SELECT * FROM staff_audit WHERE admin_id = '".$_SESSION['user']['admin_id']."' ORDER BY id DESC LIMIT 1";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $month = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEPT','OCT','NOV','DEC'];
        $now_month = (int)date('m') - 1;
        $this_month = $month[$now_month];
        echo $row['month'];
        if($this_month == $row['month'] && $row['year'] == date('Y')){
          $audit_begin = 'true'; $show_month = $row['month'];
          $show_year = $row['year'];
          $ID = $row['id'];
        } 
        $users[] = $row;
      }
  }
  $query = "SELECT * FROM users WHERE admin_id = '".$_SESSION['user']['id']."' AND id_card_permission ='1'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0) {
      while($row = mysqli_fetch_assoc($result)) {
          $id_permission[] = $row;
        } 
  }
  $query = "SELECT * FROM users WHERE admin_id = '".$_SESSION['user']['id']."' AND leave_processing_permission ='1'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0) {
      while($row = mysqli_fetch_assoc($result)) {
          $leave_permission[] = $row;
        } 
  }
  $query = "SELECT * FROM users WHERE admin_id = '".$_SESSION['user']['id']."' AND payroll_permission ='1'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0) {
      while($row = mysqli_fetch_assoc($result)) {
          $payroll_permission[] = $row;
        } 
  }
  //print_r($audit_begin);
?>
<?php include "header.php"?>
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
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>GRANTED PERMISSION</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
               <?php if(isset($_SESSION['msg']) && $_SESSION['msg'] != '') {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>           
              <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>ID Card Processing</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="table-responsive">
                      <?php if(count($id_permission) > 0) {?>
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title">Name</th>
                            <th class="column-title">Employee ID </th>
                            <th class="column-title">Department</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($id_permission); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$id_permission[$h]['name']?></td>
                            <td class=" "><?=$id_permission[$h]['employee_ID']?></td>
                            <td class=" "><?=$id_permission[$h]['department']?></td>
                           <?php }?>
                        </tbody>
                      </table>
                      <?php }else {?>
                         No user with this permission
                      <?php } ?>  
                    </div>
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Leave Management Processing</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="table-responsive">
                      <?php if(count($leave_permission) > 0) {?>
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title">Name</th>
                            <th class="column-title">Employee ID </th>
                            <th class="column-title">Department</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($leave_permission); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$leave_permission[$h]['name']?></td>
                            <td class=" "><?=$leave_permission[$h]['employee_ID']?></td>
                            <td class=" "><?=$leave_permission[$h]['department']?></td>
                           <?php }?>
                        </tbody>
                      </table>
                      <?php }else {?>
                         No user with this permission
                      <?php } ?>  
                    </div>
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Payroll Processing</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="table-responsive">
                      <?php if(count($payroll_permission) > 0) {?>
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title">Name</th>
                            <th class="column-title">Employee ID </th>
                            <th class="column-title">Department</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($payroll_permission); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$payroll_permission[$h]['name']?></td>
                            <td class=" "><?=$payroll_permission[$h]['employee_ID']?></td>
                            <td class=" "><?=$payroll_permission[$h]['department']?></td>
                           <?php }?>
                        </tbody>
                      </table>
                      <?php }else {?>
                         No user with this permission
                      <?php } ?>  
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12">
                  <div class="x_panel">
                  <div class="x_title">
                    <h2>KSS shared by (<span style="font-size: 13px;"><?=isset($kss[0]['name']) ? $kss[0]['name'] : ''?></span>)</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php if(count($kss) > 0) {?>
                    <p style="text-align: justify;"><?=$kss[0]['information']?></p>
                    <?php } else { ?>
                      <p style="text-align: justify;">No Information shared</p>
                    <?php } ?> 
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
<?php include "footer.php"?>
<script type="text/javascript" src="js/appraisal.js"></script>
        
