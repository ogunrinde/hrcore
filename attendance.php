<?php 
include 'connection.php';
session_start();
$employee = [];
$admin_id;
$period = date('F');
$thisbranch = 'All Branch';
if(!isset($_SESSION['user']['id'])) header("Location: dashboard.php");
if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
//print_r($admin_id);
$query = "SELECT DISTINCT attendances.days,employee_info.id, employee_info.first_name, employee_info.last_name, employee_info.employee_ID FROM employee_info RIGHT JOIN attendances ON (attendances.insert_by = employee_info.insert_by AND employee_info.id = attendances.employee_ID)  WHERE (employee_info.insert_by = '".$_SESSION['user']['id']."' AND attendances.month = '".date('F')."' AND attendances.year = '".date('Y')."')";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $employee[] = $row;
  }
  //$period = date('F');
}
//echo date('F');
//print_r($_SESSION['user']['id']);
$query = "SELECT * from branches WHERE admin_id = '".$admin_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $branches[] = $row;
  }
}
if(isset($_POST['thisbranch'])){
    $employee = [];
    $thisbranch = $_POST['branchname'];
    //print_r($_POST['branch']);
    $query = "SELECT employee_info.id, employee_payroll_data.net,employee_payroll_data.gross, employee_info.first_name, employee_info.last_name, employee_info.employee_ID FROM employee_info INNER JOIN employee_payroll_data ON employee_payroll_data.admin_id = employee_info.admin_id  WHERE employee_info.branch_id = '".$_POST['branch']."'";
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
//print_r($employee);
}
//print_r($_SESSION['user']);
if(isset($_POST['thisperiod'])){
    $employee = [];
    $period = mysqli_real_escape_string($conn, $_POST['period']);
    $query = "SELECT DISTINCT attendances.days,employee_info.id, employee_info.first_name, employee_info.last_name, employee_info.employee_ID FROM employee_info RIGHT JOIN attendances ON (attendances.insert_by = employee_info.insert_by AND employee_info.id = attendances.employee_ID)  WHERE (employee_info.insert_by = '".$_SESSION['user']['id']."' AND attendances.month = '".$period."' AND attendances.year = '".date('Y')."')";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $employee[] = $row;
  }
  //$period = date('F');
}
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
<link href ='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css'/>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Employee Attendance</h3>
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
                    <h2>Attendance <?='(for the month of '.$period.')'?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li>
                          <form action="attendance.php" method="post">
                            <select name = 'period' id = 'period' style='width:200px;' class ='form-control col-md-6 col-sm-12 col-xs-12'>
                                <option value=''></option>
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
                            <button type="submit" id="thismonth"
                                name='thisperiod' value="" style='display:none;'
                                class="btn btn-info">Send</button>
                           </form>
                      </li>
                      <li><a href ="addattendance" class="btn btn-success btn-sm" style="color: #fff;">Add Attendance</a>
                      </li>
                      <li>
                      <form action="process_file.php" method="post">
                            <input type="text" name="which" value = "masterlist" style="display: none;">
                            <button type="submit" id="btnExport"
                                name='export' value="Export to Excel"
                                class="btn btn-info">Export to Excel</button>
                        </form>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class ='error_msg'></div>
                  <div class ='success_msg'></div>
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
                            <th class="column-title text-center">Number of Time at Work </th>
                            <th class="column-title text-center">Option </th>
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
                            <td class="text-center">
                                <?=$employee[$h]['days']?>
                            </td>
                            <td class="text-center">
                              <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-primary btn-sm" href="editemployee.php/?id=<?=base64_encode($employee[$h]['id'])?>">Edit</a>
                                <a class="btn btn-success btn-sm" href="showemployee_payslip.php/?id=<?=base64_encode($employee[$h]['id'])?>">payslip</a>
                              </div>
                            </td>
                          </tr>
                          <?php } } ?>
                        </tbody>
                      </table>
                       <button type="submit" id="submit_attendance"
                                name=''
                                class="btn btn-info">Submit Attendance</button>
                    </div>
                  <?php }else { ?>
                    <p>No Attendance added</p>
                  <?php } ?> 
                  </div>
                </div>
              </div>    
             
        </div>
</div>
</div>
<?php include "footer.php"?>
<script type ='text/javascript'>
    $(function(){
        $('#period').on('change', function(e){
            e.preventDefault();
            let period = $('#period').val();
            if(period == '') return false;
            $('#thismonth').trigger('click');
        })
    })
</script>        
