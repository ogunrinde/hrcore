<?php 
include 'connection.php';
session_start();
$employee = [];
$attendance = [];
$admin_id;
$thisbranch = 'All Branch';
$net = 0;
$gross = 0;
if(!isset($_SESSION['user']['id'])) header("Location: dashboard.php");
if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
if($_SESSION['user']['payroll_only'] == '1') $admin_id = $_SESSION['user']['admin_id'];
//print_r($admin_id);
if($_SESSION['user']['category'] == 'staff') {
    $query = "SELECT employee_info.id, employee_payroll_data.net,employee_payroll_data.gross, employee_info.first_name, employee_info.last_name, employee_info.employee_ID FROM employee_info LEFT JOIN employee_payroll_data ON (employee_payroll_data.admin_id = employee_info.admin_id AND employee_payroll_data.employee_info_id = employee_info.id)  WHERE employee_info.insert_by = '".$_SESSION['user']['id']."'";
}else if($_SESSION['user']['category'] == 'admin' || $_SESSION['user']['payroll_only'] == '1') {
    //echo 'asss';
    $query = "SELECT employee_info.id, employee_payroll_data.net,employee_payroll_data.gross, employee_info.first_name, employee_info.last_name, employee_info.employee_ID FROM employee_info LEFT JOIN employee_payroll_data ON (employee_payroll_data.admin_id = employee_info.admin_id AND employee_payroll_data.employee_info_id = employee_info.id)  WHERE employee_info.admin_id = '".$admin_id."'";
}

$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $employee[] = $row;
  }
}
$_SESSION['month'] = date('F');
//echo date('F');
$query = "SELECT * from attendances WHERE admin_id = '".$admin_id."' AND month = '".date('F')."' AND year = '".date('Y')."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $attendance[] = $row;
  }
}

//print_r($attendance);
$query = "SELECT * from branches WHERE admin_id = '".$admin_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $branches[] = $row;
  }
}
if(isset($_POST['thisbranch'])){
    $employee = [];
    $thisbranch = $_POST['branch'];
    //$_SESSION['branch'] = $thisbranch;
    //echo $thisbranch;
    //print_r($_POST['branch']);
    $query = "SELECT employee_info.id, employee_payroll_data.net,employee_payroll_data.gross, employee_info.first_name, employee_info.last_name, employee_info.employee_ID FROM employee_info LEFT JOIN employee_payroll_data ON (employee_payroll_data.admin_id = employee_info.admin_id AND employee_payroll_data.employee_info_id = employee_info.id)  WHERE employee_info.branch_id = '".$_POST['branch']."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $employee[] = $row;
  }
}
for($t = 0; $t < count($branches); $t++){
    if($_POST['branch'] == $branches[$t]['id']){
        $thisbranch = $branches[$t]['name'];
        //echo $branches[$t]['name'];
        break;
    }
}
//print_r($thisbranch);
}
if(isset($_POST['selectedperiod'])){
    $_SESSION['month'] = trim($_POST['period']);
    $employee = [];
    $attendance = [];
    $period = $_POST['period'];
    if($_SESSION['user']['position'] == 'supervisor'){
        $query = "SELECT employee_info.id, employee_payroll_data.net,employee_payroll_data.gross, employee_info.first_name, employee_info.last_name, employee_info.employee_ID FROM employee_info LEFT JOIN employee_payroll_data ON (employee_payroll_data.insert_by = employee_info.insert_by AND employee_payroll_data.employee_info_id = employee_info.id)  WHERE employee_info.insert_by = '".$_SESSION['user']['id']."'";
    }else {
        $query = "SELECT employee_info.id, employee_payroll_data.net,employee_payroll_data.gross, employee_info.first_name, employee_info.last_name, employee_info.employee_ID FROM employee_info LEFT JOIN employee_payroll_data ON (employee_payroll_data.insert_by = employee_info.insert_by AND employee_payroll_data.employee_info_id = employee_info.id)  WHERE employee_info.admin_id = '".$_SESSION['user']['id']."'";
    }
    
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $employee[] = $row;
      }
    }
    $query = "SELECT * from attendances WHERE admin_id = '".$admin_id."' AND month = '".$period."' AND year = '".date('Y')."'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $attendance[] = $row;
      }
    }
}
//print_r($branches);
$total_topay = 0;
for($r = 0; $r < count($employee); $r++){
    for($p = 0; $p < count($attendance); $p++){
        //echo $employee[$r]['id'].'_'.$attendance[$p]['employee_ID'].'<br>';
        if($employee[$r]['id'] == $attendance[$p]['employee_ID']){
            //echo $employee[$r]['employee_ID'];
             $employee[$r]['attendance'] = $attendance[$p]['days'];
             $perday = (float)$employee[$r]['gross'] / 20;
             $gross = $gross + (float)$employee[$r]['gross'];
             $net  = $net + (float)$employee[$r]['net'];
             $employee[$r]['perday'] = $perday;
             $employee[$r]['to_pay'] = $perday * $attendance[$p]['days'];
             $total_topay = $total_topay + (float)$employee[$r]['to_pay'];
        }
    }
}
//print_r($attendance);
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
  .btn-success a:hover{
      color:red;
  }
</style>
<div class="right_col" role="main">              
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Employee Master List</h3>
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
            <?php if(isset($_SESSION['msg'])) {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
            <?php } ?>        
                
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <?php if($_SESSION['user']['position'] == 'supervisor') { ?>  
                      <h2>Employee Data <?='('.$_SESSION['user']['branch'].' Branch)'?></h2>
                    <?php }else { ?>
                      <h2>Employee Data <?='('.$thisbranch.')'?></h2>
                    <?php } ?>
                    <ul class="nav navbar-right panel_toolbox">
                      <li>
                          <form action="masterlist.php" method="post">
                            <select name = 'period' id = 'getperiod' style='width:200px;' class ='form-control col-md-6 col-sm-12 col-xs-12'>
                                <option value = ""><?=isset($_SESSION['month']) ? $_SESSION['month'] : ''?></option>
                                <option value=''>Select Month</option>
                                <option value='January'>January</option>
                                <option value='February'>February</option>
                                <option value='March'>March</option>
                                <option value='April'>April</option>
                                <option value='May'>May</option>
                                <option value='June'>June</option>
                                <option value='July'>July</option>
                                <option value='August'>August</option>
                                <option value='September'>September</option>
                                <option value='October'>October</option>
                                <option value='November'>November</option>
                                <option value='December'>December</option>
                                
                            </select>
                            <button type="submit" id="selectedperiod"
                                name='selectedperiod' value="" style='display:none;'
                                class="btn btn-info">Selected Branch</button>
                           </form>
                      </li>    
                      <li>
                          <form action="masterlist.php" method="post">
                            <?php if ($_SESSION['user']['category'] == 'admin'){ ?>  
                            <select name = 'branch' id = 'getbranch' style='width:200px;' class ='form-control col-md-6 col-sm-12 col-xs-12'>
                                <option value=''><?=isset($_SESSION['branch']) ? $_SESSION['branch'] : ''?></option>
                                <option value=''>Select Branch</option>
                                <?php for ($r = 0; $r < count($branches); $r++) { ?>
                                   <option value ='<?=$branches[$r]['id']?>'><?=$branches[$r]['name']?></option>
                                <?php  } ?>
                            </select>
                            
                            <?php } ?>
                            <button type="submit" id="branches"
                                name='thisbranch' value="" style='display:none;'
                                class="btn btn-info">selected Branch</button>
                           </form>
                      </li>
                      <?php if($_SESSION['user']['position'] == 'supervisor' || $_SESSION['user']['category'] == 'admin') { ?>
                      <li><a href ="employee" class="btn btn-success btn-sm" style="color: #fff;">Add Employee</a>
                      </li>
                      <?php } ?>
                       <?php if($_SESSION['user']['category'] == 'admin' || $_SESSION['user']['payroll_only'] == '1') { ?>
                      <li>

                          <button type="submit" id="sendpayslip"
                                name='sendpayslip' value="Export to Excel"
                                class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Send Payslip</button>
                      
                      <!--form action="process_file.php" method="post">
                            <input type="text" name="which" value = "masterlist" style="display: none;">
                            <button type="submit" id="btnExport"
                                name='export' value="Export to Excel"
                                class="btn btn-info">Export to Excel</button>
                        </form-->
                      </li>
                      
                      <li>
                          <button type="submit" id="sendpayslip"
                                name='sendpayslip' value="Export to Excel"
                                class="btn btn-info" data-toggle="modal" data-target="#reportModal">Report</button>
                      </li>
                      <?php } ?>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($employee) > 0) {?>  
                    <div class="table-responsive">
                      
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title text-center">S/N </th>
                            <th class="column-title text-center">Surname </th>
                            <th class="column-title text-center">First Name </th>
                            <th class="column-title text-center">Employee ID </th>
                            <th class="column-title text-center">Gross Salary (&#8358;) </th>
                            <th class="column-title text-center">Net Salary (&#8358;)</th>
                            <th class="column-title text-center">Attendance(Period)</th>
                            <th class="column-title text-center">Payment based on (Attendance)</th>
                            <th class="column-title text-center">Options</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php if(count($employee) > 0) {?>
                          <?php for ($h = 0; $h < count($employee); $h++) {?>
                            
                          <tr class="pointer">
                            <td class="a-center text-center">
                              <?=$h + 1?>
                            </td>
                            <td class="text-center"> <?=$employee[$h]['last_name']?></td>
                            <td class="text-center"><?=$employee[$h]['first_name']?></td>
                            <td class="text-center"><?=$employee[$h]['employee_ID']?></td>
                            <td class="text-center"><?=number_format($employee[$h]['gross'])?></td>
                            <td class="text-center"><?=number_format($employee[$h]['net'])?></td>
                            <td class="text-center"><?=isset($employee[$h]['attendance']) ? $employee[$h]['attendance'] : 'Not Updated'?></td>
                            <td class="text-center"><?=isset($employee[$h]['to_pay'])? number_format($employee[$h]['to_pay']): ''?></td>
                            <td class="text-center">
                              <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-primary btn-sm" href="editemployee.php/?id=<?=base64_encode($employee[$h]['id'])?>">Edit</a>
                                <a class="btn btn-success btn-sm" href="showemployee_payslip.php/?id=<?=base64_encode($employee[$h]['id'])?>">payslip</a>
                              </div>
                            </td>
                          </tr>
                          <?php } } ?>
                          <tr class="pointer">
                              <td></td><td></td><td></td><td class="text-center" style='font-size:1.3em;'>Total</td><td class="text-center" style='font-size:1.2em;'><?=number_format($gross)?> NGN</td><td class="text-center" style='font-size:1.2em;'><?=number_format($net)?> NGN</td><td class="text-center" style='font-size:1.2em;'></td><td class="text-center" style='font-size:1.2em;'><?=number_format($total_topay)?> NGN</td>
                              <td></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  <?php }else { ?>
                    <p>No Employee added</p>
                  <?php } ?> 
                  </div>
                </div>
              </div>    
             
        </div>
</div>
</div>
<?php include "footer.php"?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Payslip</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action = 'payslip_pdf.php' method = 'POST'>
              <div class="form-group">
                <label for="exampleInputEmail1">Branch</label>
                <select class="form-control" name='slipbranch'>
                     <option value = ''></option>
                     <option value = 'all'>All Branch</option>
                     <?php for ($r = 0; $r < count($branches); $r++) { ?>
                        <option value ='<?=$branches[$r]['id']?>'><?=$branches[$r]['name']?></option>
                     <?php  } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Copy Administrator</label>
                 <div class="form-check">
                      <input class="form-check-input" type="radio" name="radios" id="exampleRadios1" value="Yes" checked>
                      <label class="form-check-label" for="exampleRadios1">
                        Yes
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="radios" id="exampleRadios2" value="No">
                      <label class="form-check-label" for="exampleRadios2">
                         No
                      </label>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name ='submit' class="btn btn-primary">Send Payslip</button>
              </div>
            </form>
      </div>
      
    </div>
  </div>
</div>
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Generate Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action = 'generate_report.php' method = 'POST'>
              <div class="form-group">
                <label for="exampleInputEmail1">Branch</label>
                <select class="form-control" name='branch' id="branchdetails">
                     <option value = ''></option>
                     <option value = 'all'>All Branch</option>
                     <?php for ($r = 0; $r < count($branches); $r++) { ?>
                        <option value ='<?=$branches[$r]['id'] ?>'><?=$branches[$r]['name']?></option>
                     <?php  } ?>
                </select>
              </div>
              <div>
                <input style="display: none;" type="text" name="branch_name" value="" id ='getbranchname'>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Report Type</label>
                <select class="form-control" name='report_type'>
                     <option value = ''></option>
                     <option value = 'supervisors'>Supervisors</option>
                     <option value = 'employee_info_payroll'>Employee Information and Payroll</option>
                     <option value = 'employee_info'>Employee Information Only</option>
                     <option value = 'female'>Female</option>
                     <option value = 'male'>Male</option>
                     <option value = 'attendance'>Attendance</option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Period</label>
                <select class="form-control" name='month'>
                     <option value=''>Select Month</option>
                      <option value='January'>January</option>
                      <option value='February'>February</option>
                      <option value='March'>March</option>
                      <option value='April'>April</option>
                      <option value='May'>May</option>
                      <option value='June'>June</option>
                      <option value='July'>July</option>
                      <option value='August'>August</option>
                      <option value='September'>September</option>
                      <option value='October'>October</option>
                      <option value='November'>November</option>
                      <option value='December'>December</option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Period</label>
                <select class="form-control" name='year'>
                      <option value=''>Select Year</option>
                      <option value='2019'>2019</option>
                      <option value='2020'>2020</option>
                      <option value='2021'>2021</option>
                      <option value='2022'>2022</option>
                </select>
              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name ='submit' class="btn btn-primary">Generate Report</button>
              </div>
            </form>
      </div>
      
    </div>
  </div>
</div>
<script>
    $(function(){
        $('#getbranch').on('change', function(e){
            if($('#getbranch').val() == '') return false;
            $('#branches').trigger('click');
        })
    });
    $('#getperiod').on('change', function(e){
        if($('#getperiod').val() == '') return false;
        $('#selectedperiod').trigger('click');
    });
    $('#branchdetails').on('change', function(e){
      e.preventDefault();
      //alert('as');
      $('#getbranchname').val($('#branchdetails option:selected').text());
    })
</script>
        
