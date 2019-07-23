<?php 
include 'connection.php';
session_start();
$leaves = [];
 $month = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUNE', 'JULY', 'AUG','SEPT', 'OCT', 'NOV', 'DEC'];
 $year = [];
 $all_months = [];
 $day = [];
 $filled_appraisal = [];
 //echo $_SESSION['user']['category'];
 if(!isset($_SESSION['user']['id'])) header("Location: login.php");
  if($_SESSION['user']['category'] == 'staff'){
    $query = "SELECT users.name,users.fname,users.mname,users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created, leaves.stage,leaves.processed FROM leaves INNER JOIN users ON users.id = leaves.staff_id AND users.id = leaves.staff_id WHERE leaves.staff_id = '".$_SESSION['user']['id']."' ORDER BY leaves.id DESC";
  }
  else if(trim($_SESSION['user']['category']) == 'admin' && $_SESSION['user']['leave_processing_permission'] != '1'){
      //echo $_SESSION['user']['category'];
    $query = "SELECT users.name,users.fname, users.mname, users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created,leaves.stage, leaves.processed FROM leaves INNER JOIN users ON users.id = leaves.staff_id AND users.active = '1' WHERE leaves.admin_id = '".$_SESSION['user']['id']."' ORDER BY leaves.id DESC";
  }
  else if(trim($_SESSION['user']['category']) == 'admin' && $_SESSION['user']['leave_processing_permission'] == '1'){
      //print_r($_SESSION['user']);
    $query = "SELECT users.name, users.fname,users.mname, users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created,leaves.stage, leaves.processed FROM leaves INNER JOIN users ON users.admin_id = leaves.admin_id AND users.id = leaves.staff_id AND users.active = '1' WHERE leaves.processed != 'Cancelled' AND leaves.stage != 'decline' AND leaves.processed = 'Pending'  ORDER BY leaves.id DESC";
  }
  
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $leaves[] = $row;
         $t =  (int)(trim(explode('-',$row['date_created'])[1]));
         $all_months[] = $month[$t-1];
         $year[] = explode('-',$row['date_created'])[0];
         $day[] = explode('-',$row['date_created'])[2];
      }
  }
  if(isset($_POST['treated'])){
   $year = [];
   $all_months = [];
   $day = [];
   $filled_appraisal = []; 
   $leaves = []; 
  if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
  else $admin_id = $_SESSION['user']['id']; 
    if($_SESSION['user']['category'] == 'staff'){
    $query = "SELECT users.name,users.fname,users.mname,users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created, leaves.stage,leaves.processed FROM leaves INNER JOIN users ON (users.id = leaves.staff_id AND users.id = leaves.staff_id AND leaves.processed = 'Treated')  WHERE leaves.staff_id = '".$_SESSION['user']['id']."' ORDER BY leaves.id DESC";
  }
  else if(trim($_SESSION['user']['category']) == 'admin' && $_SESSION['user']['leave_processing_permission'] != '1'){
      //echo $_SESSION['user']['category'];
    $query = "SELECT users.name,users.fname,users.mname, users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created,leaves.stage, leaves.processed FROM leaves INNER JOIN users ON (users.id = leaves.staff_id AND users.active = '1' AND leaves.processed = 'Treated') WHERE leaves.admin_id = '".$_SESSION['user']['id']."' ORDER BY leaves.id DESC";
  }
  else if(trim($_SESSION['user']['category']) == 'admin' && $_SESSION['user']['leave_processing_permission'] == '1'){
      //print_r($_SESSION['user']);
    $query = "SELECT users.name, users.fname,users.mname, users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created,leaves.stage, leaves.processed FROM leaves INNER JOIN users ON (users.admin_id = leaves.admin_id AND users.id = leaves.staff_id AND users.active = '1' AND leaves.processed = 'Treated') ORDER BY leaves.id DESC";
  }
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $leaves[] = $row;
         $t =  (int)(trim(explode('-',$row['date_created'])[1]));
         $all_months[] = $month[$t-1];
         $year[] = explode('-',$row['date_created'])[0];
         $day[] = explode('-',$row['date_created'])[2];
      }
  }
}
  if(isset($_POST['pendingleavemanager'])){
   $year = [];
   $all_months = [];
   $day = [];
   $filled_appraisal = []; 
   $leaves = []; 
  if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
  else $admin_id = $_SESSION['user']['id']; 
  if($_SESSION['user']['category'] == 'staff'){
    $query = "SELECT users.name, users.fname,users.mname, users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created, leaves.stage,leaves.processed FROM leaves INNER JOIN users ON (users.id = leaves.staff_id AND users.id = leaves.staff_id AND leaves.processed = 'Pending' AND leaves.stage = 'Approved') WHERE leaves.staff_id = '".$_SESSION['user']['id']."' ORDER BY leaves.id DESC";
  }
  else if(trim($_SESSION['user']['category']) == 'admin' && $_SESSION['user']['leave_processing_permission'] != '1'){
      //echo $_SESSION['user']['category'];
    $query = "SELECT users.name, users.fname,users.mname, users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created,leaves.stage, leaves.processed FROM leaves INNER JOIN users ON (users.id = leaves.staff_id AND users.active = '1' AND leaves.processed = 'Pending' AND leaves.stage = 'Approved') WHERE leaves.admin_id = '".$_SESSION['user']['id']."' ORDER BY leaves.id DESC";
  }
  else if(trim($_SESSION['user']['category']) == 'admin' && $_SESSION['user']['leave_processing_permission'] == '1'){
      //print_r($_SESSION['user']);
    $query = "SELECT users.name,users.fname,users.mname, users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created,leaves.stage, leaves.processed FROM leaves INNER JOIN users ON (users.admin_id = leaves.admin_id AND users.id = leaves.staff_id AND users.active = '1' AND leaves.processed = 'Pending' AND leaves.stage = 'Approved') ORDER BY leaves.id DESC";
  }
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $leaves[] = $row;
         $t =  (int)(trim(explode('-',$row['date_created'])[1]));
         $all_months[] = $month[$t-1];
         $year[] = explode('-',$row['date_created'])[0];
         $day[] = explode('-',$row['date_created'])[2];
      }
  }
  //print_r($leaves);
}
  if(isset($_POST['pendingmanager'])){
   $year = [];
   $all_months = [];
   $day = [];
   $filled_appraisal = []; 
   $leaves = []; 
  if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
  else $admin_id = $_SESSION['user']['id']; 
  if($_SESSION['user']['category'] == 'staff'){
    $query = "SELECT users.name, users.fname,users.mname, users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created, leaves.stage,leaves.processed FROM leaves INNER JOIN users ON (users.id = leaves.staff_id AND users.id = leaves.staff_id AND leaves.processed = 'Pending') WHERE leaves.staff_id = '".$_SESSION['user']['id']."' ORDER BY leaves.id DESC";
  }
  else if(trim($_SESSION['user']['category']) == 'admin' && $_SESSION['user']['leave_processing_permission'] != '1'){
      //echo $_SESSION['user']['category'];
    $query = "SELECT users.name, users.fname,users.mname, users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created,leaves.stage, leaves.processed FROM leaves INNER JOIN users ON (users.id = leaves.staff_id AND users.active = '1' AND leaves.stage != 'Approved') WHERE leaves.admin_id = '".$_SESSION['user']['id']."' ORDER BY leaves.id DESC";
  }
  else if(trim($_SESSION['user']['category']) == 'admin' && $_SESSION['user']['leave_processing_permission'] == '1'){
      //print_r($_SESSION['user']);
    $query = "SELECT users.name,users.fname,users.mname, users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created,leaves.stage, leaves.processed FROM leaves INNER JOIN users ON (users.admin_id = leaves.admin_id AND users.id = leaves.staff_id AND users.active = '1' AND leaves.stage != 'Approved') ORDER BY leaves.id DESC";
  }
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $leaves[] = $row;
         $t =  (int)(trim(explode('-',$row['date_created'])[1]));
         $all_months[] = $month[$t-1];
         $year[] = explode('-',$row['date_created'])[0];
         $day[] = explode('-',$row['date_created'])[2];
      }
  }
  //print_r($leaves);
}
if(isset($_POST['search'])){
   $year = [];
   $all_months = [];
   $day = [];
   $filled_appraisal = []; 
   $leaves = []; 
   $search = mysqli_real_escape_string($conn, $_POST['find']);
  $query = "SELECT users.name,users.fname,users.mname, users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created,leaves.stage, leaves.processed FROM leaves INNER JOIN users ON users.admin_id = leaves.admin_id AND users.id = leaves.staff_id AND users.active = '1' WHERE (users.employee_ID = '$search' AND (leaves.processed ='Pending' || leaves.processed = 'Treated'))";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)> 0){
            while($row = mysqli_fetch_assoc($result)) {
              $leaves[] = $row;
               $t =  (int)(trim(explode('-',$row['date_created'])[1]));
               $all_months[] = $month[$t-1];
               $year[] = explode('-',$row['date_created'])[0];
               $day[] = explode('-',$row['date_created'])[2];
            }
        }
  if(count($leaves) > 0){}
  else {
    $query = "SELECT users.name,users.fname,users.mname, users.user_company, users.employee_ID,users.department,leaves.start_date, leaves.end_date, leaves.justification, leaves.id as leave_id, leaves.leave_type, leaves.date_created,leaves.stage, leaves.processed FROM leaves INNER JOIN users ON users.admin_id = leaves.admin_id AND users.id = leaves.staff_id AND users.active = '1' WHERE users.user_company = '$search'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)> 0){
            while($row = mysqli_fetch_assoc($result)) {
              $leaves[] = $row;
               $t =  (int)(trim(explode('-',$row['date_created'])[1]));
               $all_months[] = $month[$t-1];
               $year[] = explode('-',$row['date_created'])[0];
               $day[] = explode('-',$row['date_created'])[2];
            }
        }
  }  
}
 $query = "SELECT * from company where company_name = 'Icsoutsourcing'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
        //echo $row['id'];
      }
  }
  //print_r($data);
  for($e = 0; $e < count($data); $e++){
    //if($data[$e]['admin_id'] == $_SESSION['user']['admin_id']){
      $user_company = explode(";",$data[$e]['user_company']);
    //}
  }

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
                <h3>View Request</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-12 col-xs-12 form-group pull-right top_search">
                  <form method="POST" action="view_leave.php">
                    <div class="input-group">
                      <input type="text" class="form-control" name = "find" placeholder="Search by ID or Company">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="submit" name="search">Go!</button>
                      </span>
                    </div>
                  </form>
                  <div style='float:right;margin-right:5px;'>
                      <button type="submit" name="report" class="btn btn-warning" style=background-color:'#73879C' data-toggle="modal" data-target="#reportModal">Report</button>
                  </div>
                  
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <?php if(count($leaves) > 0) {?>
                    <?php if($_SESSION['user']['category'] == 'admin') { ?>
                      
                      <div class="btn-group" role="group" aria-label="Basic example">
                        <form method="POST" action="view_leave.php">
                            <button type="submit" name = "all" class="btn btn-success" style=background-color:'#73879C'>All</button>
                            <button type="submit" name = "treated" class="btn btn-success">Treated</button>
                            <button type="submit" name="pendingleavemanager" class="btn btn-primary" style=background-color:'#73879C'>Pending with Leave Manager</button>
                            <button type="submit" name="pendingmanager" class="btn btn-info" style=background-color:'#73879C'>Pending with Managers</button>
                            
                        </form>
                        
                      </div>
                    
                    
                    <?php } ?>
                    <div class="table-responsive" style='margin-top:20px;'>
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N </th>
                            <th class="column-title">Name </th>
                            <th class="column-title">Employee ID </th>
                            <th class="column-title">Company </th>
                            <th class="column-title">Leave Type </th>
                            <th class="column-title">Applied Date </th>
                            <th class="column-title">Stage with Approvals </th>
                            <th class="column-title">Stage with Leave Manager </th>
                            <th class="column-title">More </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($leaves); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$leaves[$h]['name']?> <?=$leaves[$h]['fname']?> <?=$leaves[$h]['mname']?></td>
                            <td class=" "><?=$leaves[$h]['employee_ID']?></td>
                            <td class=" "><?=$leaves[$h]['user_company']?></td>
                            <td class=" "><?=$leaves[$h]['leave_type']?></td>
                            <td class=" "><?=$day[$h]?> <?=$all_months[$h]?> <?=$year[$h]?></td>
                            <td class=" " style="text-transform:capitalize"><?=$leaves[$h]['stage']?></td>
                            <td class=" " style="text-transform:capitalize"><?=$leaves[$h]['processed']?></td>
                            <th class="column-title"><a href="see_leave_request.php/?leave_id=<?=base64_encode($leaves[$h]['leave_id'])?>" class="btn btn-sm btn-success">Details</a> </th>
                          </tr>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php  }else {?>
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Leave Request</h2>
                        <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                          <br />
                          No request yet
                        </div>
                      </div>
                    <?php } ?>  
                  </div>
                </div>
              </div>
          </div>
        </div>
        
        <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                   <form action = 'process_report.php' method='post'>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Period</label>
                        <select name="month" class="form-control">
                         <option value=""></option>
                         <option value="1">JAN</option>
                         <option value="2">FEB</option>
                         <option value="3">MAR</option>
                         <option value="4">APR</option>
                         <option value="5">MAY</option>
                         <option value="6">JUN</option>
                         <option value="7">JUL</option>
                         <option value="8">AUG</option>
                         <option value="9">SEPT</option>
                         <option value="10">OCT</option>
                         <option value="11">NOV</option>
                         <option value="12">DEC</option>
                       </select>
                      </div>
                      <button type="submit" name='report' class="btn btn-primary">Submit</button>
                    </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
<?php include "footer.php"?>
        
