<?php 
include 'connection.php';
session_start();
$employee = [];
$admin_id;
$thisbranch = $_SESSION['user']['position'] == 'supervisor' ? $_SESSION['user']['branch'] :'All Branch';
if(!isset($_SESSION['user']['id'])) header("Location: dashboard.php");
if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
//print_r($admin_id);
$query = "SELECT DISTINCT employee_info.id, employee_info.first_name, employee_info.last_name, employee_info.employee_ID FROM employee_info  WHERE employee_info.insert_by = '".$_SESSION['user']['id']."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $employee[] = $row;
  }
}
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
                    <h2>Attendance <?='('.$thisbranch.')'?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li>
                          <form action="masterlist.php" method="post">
                            <select name = '' id = 'periodmonth' style='width:200px;' class ='form-control col-md-6 col-sm-12 col-xs-12'>
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
                            <button type="submit" id="branches"
                                name='thisbranch' value="" style='display:none;'
                                class="btn btn-info">Export to Excel</button>
                           </form>
                      </li>
                      <li><a href ="attendance" class="btn btn-success btn-sm" style="color: #fff;">Attendance</a>
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
                                <input type ='number' employee_infoid = '<?=$employee[$h]['id']?>' id = 'attendance<?=$h?>' attr_id = '<?=$h?>' class='form-control attendance' value ='0'/>
                                <small id ='msg<?=$h?>' class='text-danger'></small>
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
                    <p>No Employee added</p>
                  <?php } ?> 
                  </div>
                </div>
              </div>    
             
        </div>
</div>
</div>
<?php include "footer.php"?>
<script type="text/javascript">
    $(function(){
        let data = [];
        $('.attendance').on('keyup', function(e){
            
            let days = $('#'+this.id+'').val();
            if(days > 20) {
                $('.error_msg').html('');
                $('.error_msg').html('<div class="alert alert-primary" role="alert" style="background-color:red;color:#fff;font-size:14px" id ="">There are only 20 working Days in a month</div>');
                $('#'+this.id+'').val('0');
                days = '0';
            }
            let row = $('#'+this.id+'').attr('attr_id');
            let employee_ID = $('#'+this.id+'').attr('employee_infoid');
            //let employee_ID = $('#'+this.id+'').attr('employee_infoid');
             //alert(isNaN('890'));
             let index = data.findIndex(x => x.id == employee_ID);
             if(index < 0) data.push({id:employee_ID, days:days});
             else data[index].days = days;
             //console.log(data);
            
        });
    $('#submit_attendance').on('click', function(e){
        e.preventDefault();
        console.log(data);
        //let data = [];
        //alert('a');
        let period = $('#periodmonth').val();
        //alert(period);
        if (period == '') {
            $('.success_msg').html('');
            $('.error_msg').html('');
            $('.error_msg').html('<div class="alert alert-primary" role="alert" style="background-color:red;color:#fff;font-size:14px" id =""> Please select the attendance Period</div>');
            return false;
        }
        if(data.length == 0) {
            $('.error_msg').html('');
            $('.error_msg').html('<div class="alert alert-primary" role="alert" style="background-color:red;color:#fff;font-size:14px" id =""> No Attendance added</div>');
            return false;
        }
        //console.log(data);
        let attendance = JSON.stringify(data);
        console.log(attendance);
        $('.success_msg').html('');
        $('.error_msg').html('');
                    $('.success_msg').html('<div class="alert alert-primary" role="alert" style="background-color:#337ab7;color:#fff;font-size:14px" id ="">Processing....</div>');
        $.ajax({
            url: 'process_attendance.php',
            method: 'POST',
            data:{data:attendance, period: period, submit:true},
            success:function(res){
                //alert(res);
                if(res > 0){
                    $('.success_msg').html('');
                    $('.success_msg').html('<div class="alert alert-primary" role="alert" style="background-color:#337ab7;color:#fff;font-size:14px" id ="">Attendance updated for the month</div>');
                }
                
            }
        })
    })    
        
    })
</script>
        
