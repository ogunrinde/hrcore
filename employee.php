<?php 
include 'connection.php';
session_start();
$data_dept = [];
$data_branch = [];
$admin_id;
//print_r($_SESSION['other_info']);
//print_r($_SESSION['employee_payroll_data']);
if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
$query = "SELECT * FROM departments WHERE admin_id = '".$admin_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $data_dept[] = $row;
  }
}
$query = "SELECT * FROM employee_info WHERE admin_id = '".$admin_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $data_employee[] = $row;
  }
}
$query = "SELECT * FROM branches WHERE admin_id = '".$admin_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $data_branch[] = $row;
  }
}
//print_r($data_branch);
?>
<?php include "header.php"?>
<!--link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css"-->
<style type="text/css">
  .w3-content, .w3-auto {
    margin-left: auto;
    margin-right: auto;
  }
  .w3-light-grey, .w3-hover-light-grey:hover, .w3-light-gray, .w3-hover-light-gray:hover {
    color: #000!important;
    background-color: #f1f1f1!important;
  }
  .w3-red, .w3-hover-red:hover {
    color: #fff!important;
    background-color: #f44336!important;
  }
  .w3-btn, .w3-button {
    border: none;
    display: inline-block;
    padding: 8px 16px;
    vertical-align: middle;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    background-color: inherit;
    text-align: center;
    cursor: pointer;
    white-space: nowrap;
 }
 .w3-center {
    text-align: center!important;
 }
</style>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Employee Information</h3>
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
         <?php if(isset($_SESSION['msg'])) {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>
         <?php if(isset($_SESSION['employee']) && !isset($_SESSION['employee_payroll_data'])) {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            You have not input <?=$_SESSION['employee'][0]['first_name']?> <?=$_SESSION['employee'][0]['last_name']?> (Employee ID : <?=$_SESSION['employee'][0]['employee_ID']?>) payroll data
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>          
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Profile Information</a></li>
            <li><a data-toggle="tab" href="#menu2">Payroll</a></li>
          </ul>
        
          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="row">
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Add Employee</h2>
                            <ul class="nav navbar-right panel_toolbox">
                            <li>
                              <a class="btn btn-info" href="masterlist.php" style="color:#fff;">Employee List</a>
                            </li>
                          </ul>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <br />
                            <form action="process_employee_basic_info.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
        
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Branch Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="branch_id" class="form-control">
                                      <option value="<?=isset($_SESSION['other_info']) ? $_SESSION['other_info'][0]['branch_id']:''?>"><?=isset($_SESSION['other_info']) ? $_SESSION['other_info'][0]['name']:''?></option>
                                      <?php for ($d = 0; $d < count($data_branch);$d++) {?>
                                        <?php if($data_branch[$d]['branch_id'] == '') {?>
                                          <option value="<?=$data_branch[$d]['id']?>"><?=$data_branch[$d]['name']?></option>
                                    <?php } } ?>
                                    </select>
                                </div>
                              </div>
                              <div class="form-group" style="display: none;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Branch ID <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="branch_ID" class="form-control col-md-7 col-xs-12" type="text" value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['branch_id']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sub Branch Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="sub_branch_id" class="form-control">
                                      <option value="<?=isset($_SESSION['other_info']) ? $_SESSION['other_info'][0]['branch_id']:''?>"><?=isset($_SESSION['other_info']) ? $_SESSION['other_info'][0]['name']:''?></option>
                                      <?php for ($d = 0; $d < count($data_branch);$d++) {?>
                                          <?php if($data_branch[$d]['branch_id'] != '') {?>
                                            <option value="<?=$data_branch[$d]['id']?>"><?=$data_branch[$d]['name']?></option>
                                    <?php } } ?>
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Department <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="department_id" class="form-control">
                                      <option value ="<?=isset($_SESSION['other_info']) ? $_SESSION['other_info'][0]['dept_id']:''?>"><?=isset($_SESSION['other_info']) ? $_SESSION['other_info'][0]['dept']:''?></option>
                                      <?php for ($d = 0; $d < count($data_dept);$d++) {?>
                                      <option value="<?=$data_dept[$d]['id']?>"><?=$data_dept[$d]['dept']?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="first_name" class="form-control col-md-7 col-xs-12" type="text" value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['first_name']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Last Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="last_name" class="form-control col-md-7 col-xs-12" required="required" type="text" value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['last_name']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Middle Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="middle_name" class="form-control col-md-7 col-xs-12" required="required" type="text" value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['middle_name']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="email" class="form-control col-md-7 col-xs-12" required="required" type="email" value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['email']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee ID <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="employee_ID" class="form-control col-md-7 col-xs-12" required="required" type="text" value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['employee_ID']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date of Birth <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="date_of_birth" class="form-control col-md-7 col-xs-12" required="required" type="date" value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['date_of_birth']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status<span ></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="status" class="form-control col-md-7 col-xs-12" type="text" value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['status']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Gender <span class="required">*</span>
                                      </label>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                       <select name="gender" class="form-control">
                                         <option value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['gender']:''?>"><?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['gender']:''?></option>
                                         <option value="male">Male</option>
                                         <option value="female">Female</option>

                                       </select>
                                      </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Blood Type
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="blood_type" class="form-control col-md-7 col-xs-12"  type="text" value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['blood_type']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Citizenship
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="citizenship" class="form-control col-md-7 col-xs-12" type="text" value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['citizenship']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Place of Birth
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="place_of_birth" class="form-control col-md-7 col-xs-12" type="text" value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['place_of_birth']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Religion
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="religion" class="form-control col-md-7 col-xs-12" type="text" value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['religion']:''?>">
                                </div>
                              </div>
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <?php if(isset($_SESSION['employee'])) {?>
                                    <button type="submit" name="update" class="btn btn-success">Update</button>
                                  <?php }else { ?>
                                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                  <?php } ?>  
                                </div>
                              </div>
        
                            </form>
                          </div>
                        </div>
                     </div>
                </div>
            </div>
            <div id="menu2" class="tab-pane fade">
             <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Employee Payroll </h2><span><?=isset($_SESSION['employee_payroll_data']) ? '': '()'?></span>
                        <div class="clearfix"></div>
                      </div>

                      <div class="x_content">
                        <br />       
                         <form action="process_employee_payroll_data.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee ID
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="employee_ID" class="form-control col-md-7 col-xs-12">
                                      <option value ="<?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['id']:''?>"><?=isset($_SESSION['employee']) ? $_SESSION['employee'][0]['employee_ID']:''?></option>
                                       <?php for ($t = 0; $t < count($data_employee); $t++) { ?>
                                         <option value="<?=$data_employee[$t]['id']?>"><?=$data_employee[$t]['employee_ID']?></option>
                                       <?php  } ?> 
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Basic Salary
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="basic_salary" name="basic_salary" class="form-control col-md-7 col-xs-12" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['basic_salary']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Housing 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="housing" name="housing" class="form-control col-md-7 col-xs-12" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['housing']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Transport
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="transport" name="transport" class="form-control col-md-7 col-xs-12" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['transport']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Lunch
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="lunch" name="lunch" class="form-control col-md-7 col-xs-12"  type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['lunch']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Utility 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="utility" name="utility" class="form-control col-md-7 col-xs-12" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['utility']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Education
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="education" name="education" class="form-control col-md-7 col-xs-12"  type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['education']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Furniture
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="furniture" name="furniture" class="form-control col-md-7 col-xs-12"  type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['furniture']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Entertainment
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="entertainment" name="entertainment" class="form-control col-md-7 col-xs-12" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['entertainment']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Quarter Allowance
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="q_allowance" name="q_allowance" class="form-control col-md-7 col-xs-12" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['q_allowance']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">GLI
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="gli" name="gli" class="form-control col-md-7 col-xs-12" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['GLI']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ECA
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="eca" name="eca" class="form-control col-md-7 col-xs-12" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['ECA']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ITF
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="itf" name="itf" class="form-control col-md-7 col-xs-12" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['ITF']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">NHF
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="nhf" name="nhf" class="form-control col-md-7 col-xs-12" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['NHF']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Medical
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="medical" name="medical" class="form-control col-md-7 col-xs-12" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['medical']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">HMO
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="hmo" name="hmo" class="form-control col-md-7 col-xs-12" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['HMO']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Leave
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input id="leave" name="leave" class="form-control col-md-7 col-xs-12" placeholder = "" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['leave_bonus']:''?>">
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <button type="button" class="btn btn-primary" id ='cal_leave'>Calculate</button>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Christmas Bonus
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input id="xmas" name="xmas" class="form-control col-md-7 col-xs-12" placeholder = "" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['xmas']:''?>">
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <button type="" class="btn btn-primary" id ='cal_xmas'>Calculate</button>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Pension (Company)
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input name="pension_company" id ='pension_company' class="form-control col-md-4 col-xs-12" placeholder = "" type="text" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['pension_company']:''?>">
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <button type="" class="btn btn-primary" id ='cal_pension_company'>Calculate</button>
                                </div>
                              </div>
                             <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Pension (from Earning)
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input id="pension_earning" name="pension_earning" class="form-control col-md-7 col-xs-12" placeholder = "" type="text" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['pension_earning']:''?>">
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <button type="" class="btn btn-success" id ='cal_pension_from_earning'>Calculate</button>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tax
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input id="tax" name="tax" class="form-control col-md-7 col-xs-12" placeholder = "" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['tax']:''?>">
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <button type="" class="btn btn-success" id ='cal_tax'>Calculate</button>
                                </div>
                              </div>
                             <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Gross
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input id="gross" name="gross" class="form-control col-md-7 col-xs-12" placeholder = "" type="text" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['tax']:''?>">
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <button type="" class="btn btn-success" id = "cal_gross">Calculate</button>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Service Charge
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input id="service_charge" name="service_charge" class="form-control col-md-7 col-xs-12" placeholder = "" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['service_charge']:''?>">
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <button type="" class="btn btn-success" id = "cal_service_charge">Calculate</button>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">VAT
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input id="vat" name="vat" class="form-control col-md-7 col-xs-12" placeholder = "" type="text" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['VAT']:''?>">
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <button type="" class="btn btn-primary" id="cal_vat">Calculate</button>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Net
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input id="net" name="net" class="form-control col-md-7 col-xs-12" placeholder = "" type="number" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['NET']:''?>">
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <button type="" class="btn btn-primary" id="cal_net">Calculate</button>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Account Number
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="account_number" class="form-control col-md-7 col-xs-12" placeholder = "" type="text" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['account_number']:''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bank Name
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="bank_name" class="form-control col-md-7 col-xs-12" placeholder = "" type="text" value ="<?=isset($_SESSION['employee_payroll_data']) ? $_SESSION['employee_payroll_data'][0]['bank_name']:''?>">
                                </div>
                              </div>
                             
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <?php if(isset($_SESSION['employee_payroll_data'])) {?>
                                    <button type="submit" name="update" class="btn btn-success">Update</button>
                                  <?php }else { ?>
                                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                  <?php } ?>
                                </div>
                              </div>
        
                            </form>    
                      </div>
                    </div>
                </div> 
            </div>
            </div>
          </div>
        </div>
<?php unset($_SESSION['employee']);?>
<?php unset($_SESSION['other_info']);?>   
<?php unset($_SESSION['employee_payroll_data']);?>     
</div>
</div>
<!-- Modal -->
<button type="button" id ="open_modal" style="display: none;" data-toggle="modal" data-target="#show_modal"></button>
<div class="modal fade" id="show_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border: none;">
        <h2 class="modal-title" id="exampleModalLabel">Payroll</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="border: none;position: relative;">
        <div class="row" style="padding: 10px;">
          <h2 id = "to_calculate" style="margin-top: -20px;font-weight: 200"></h2>
          <p style="font-size: 17px;">Tick the one that applies</p>
          <input type="number" class="" style="padding: 4px 4px;" id = "valueInpercentage" name="" placeholder="in percentage">% of
        </div>
        <div class="row">
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_salary" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>Basic Salary
          </div>
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_housing" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>Housing 
          </div>
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_transport" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>Transport
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_education" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>Education
          </div>
          <div class="col-md-4">
            <span class="badge  badge-pill" id="m_entertainment" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>Entertainment 
          </div>
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_lunch" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>Lunch
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_utility" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>Utility
          </div>
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_furniture" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>Furniture
          </div>
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_quarterly_allowance" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>Quarterly Allowance
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_medical" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>Medical
          </div>
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_GLI" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>GLI
          </div>
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_ECA" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>ECA
          </div>
        </div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_ITF" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>ITF
          </div>
          <div class="col-md-4">
            <span class="badge  badge-pill" id = "m_NHF" style="width: 25px;height: 25px;border-radius: 12px;border: 1px solid #ccc;position: relative;left: 0;margin-right: 20px;background-color: #fff;">
            </span>NHF
          </div>
        </div>
        <div class="row" style="margin-top: 10px;text-align: center;font-size: 18px;">
          <div>&#8358; <span id = "show_calculated_value"></span></div>
        </div>
      </div>
      <div class="modal-footer" style="border: none;">
        <button type="button" class="btn btn-primary" id = "continue" class="close" data-dismiss="modal" aria-label="Close">continue</button>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"?>
<script type="text/javascript">
  $(function(){
    let b_salary = 0;
    let housing = 0;
    let transport = 0;
    let education = 0;
    let entertainment = 0;
    let lunch = 0;
    let utility = 0;
    let tomultiply  = 0; 
    let calculate_array = [];
    let which = 0;
    let toupdateValue = 0;
    $("#cal_pension_company").on("click", function(e){
      e.preventDefault();
      //alert("as");
      $("#to_calculate").text("Calculate Company contribution to Pension");
        b_salary = $("#basic_salary").val() != '' ? parseFloat($("#basic_salary").val()) : 0;
        housing = $("#housing").val() != '' ?  parseFloat($("#housing").val()) : 0;
        transport = $("#transport").val() != '' ? parseFloat($("#transport").val()) : 0;
        education = $("#education").val() != '' ? parseFloat($("#education").val()) : 0;
        entertainment = $("#entertainment").val() != '' ? parseFloat($("#entertainment").val()) : 0;
        utility = $("#utility").val() != '' ? parseFloat($("#utility").val()) : 0;
        lunch = $("#lunch").val() != '' ? parseFloat($("#lunch").val()) : 0;
        furniture = $("#furniture").val() != '' ? parseFloat($("#furniture").val()) : 0;
        q_allowance = $("#q_allowance").val() != '' ? parseFloat($("#q_allowance").val()) : 0;
        medical = $("#medical").val() != '' ? parseFloat($("#medical").val()) : 0;
        gli = $("#gli").val() != '' ? parseFloat($("#gli").val()) : 0;
        eca = $("#eca").val() != '' ? parseFloat($("#eca").val()) : 0;
        itf = $("#itf").val() != '' ? parseFloat($("#itf").val()) : 0;
        nhf = $("#nhf").val() != '' ? parseFloat($("#nhf").val()) : 0;
        calculate_array = [];
        which = 'pension_company';
        $("#open_modal").trigger("click");
    })
    $("#cal_leave").on("click", function(e){
      e.preventDefault();
      //alert("as");
      $("#to_calculate").text("Calculate Contribution of Leave");
        b_salary = $("#basic_salary").val() != '' ? parseFloat($("#basic_salary").val()) : 0;
        housing = $("#housing").val() != '' ?  parseFloat($("#housing").val()) : 0;
        transport = $("#transport").val() != '' ? parseFloat($("#transport").val()) : 0;
        education = $("#education").val() != '' ? parseFloat($("#education").val()) : 0;
        entertainment = $("#entertainment").val() != '' ? parseFloat($("#entertainment").val()) : 0;
        utility = $("#utility").val() != '' ? parseFloat($("#utility").val()) : 0;
        lunch = $("#lunch").val() != '' ? parseFloat($("#lunch").val()) : 0;
        furniture = $("#furniture").val() != '' ? parseFloat($("#furniture").val()) : 0;
        q_allowance = $("#q_allowance").val() != '' ? parseFloat($("#q_allowance").val()) : 0;
        medical = $("#medical").val() != '' ? parseFloat($("#medical").val()) : 0;
        gli = $("#gli").val() != '' ? parseFloat($("#gli").val()) : 0;
        eca = $("#eca").val() != '' ? parseFloat($("#eca").val()) : 0;
        itf = $("#itf").val() != '' ? parseFloat($("#itf").val()) : 0;
        nhf = $("#nhf").val() != '' ? parseFloat($("#nhf").val()) : 0;
        calculate_array = [];
        which = 'leave';
        $("#open_modal").trigger("click");
    });
    $("#cal_xmas").on("click", function(e){
      e.preventDefault();
      $("#to_calculate").text("Calculate Contribution to Christms");
        b_salary = $("#basic_salary").val() != '' ? parseFloat($("#basic_salary").val()) : 0;
        housing = $("#housing").val() != '' ?  parseFloat($("#housing").val()) : 0;
        transport = $("#transport").val() != '' ? parseFloat($("#transport").val()) : 0;
        education = $("#education").val() != '' ? parseFloat($("#education").val()) : 0;
        entertainment = $("#entertainment").val() != '' ? parseFloat($("#entertainment").val()) : 0;
        utility = $("#utility").val() != '' ? parseFloat($("#utility").val()) : 0;
        lunch = $("#lunch").val() != '' ? parseFloat($("#lunch").val()) : 0;
        furniture = $("#furniture").val() != '' ? parseFloat($("#furniture").val()) : 0;
        q_allowance = $("#q_allowance").val() != '' ? parseFloat($("#q_allowance").val()) : 0;
        medical = $("#medical").val() != '' ? parseFloat($("#medical").val()) : 0;
        gli = $("#gli").val() != '' ? parseFloat($("#gli").val()) : 0;
        eca = $("#eca").val() != '' ? parseFloat($("#eca").val()) : 0;
        itf = $("#itf").val() != '' ? parseFloat($("#itf").val()) : 0;
        nhf = $("#nhf").val() != '' ? parseFloat($("#nhf").val()) : 0;
        calculate_array = [];
        which = 'xmas';
        $("#open_modal").trigger("click");
    });
    $("#cal_pension_from_earning").on("click", function(e){
      e.preventDefault();
      $("#to_calculate").text("Calculate Contribution to Christms");
        b_salary = $("#basic_salary").val() != '' ? parseFloat($("#basic_salary").val()) : 0;
        housing = $("#housing").val() != '' ?  parseFloat($("#housing").val()) : 0;
        transport = $("#transport").val() != '' ? parseFloat($("#transport").val()) : 0;
        education = $("#education").val() != '' ? parseFloat($("#education").val()) : 0;
        entertainment = $("#entertainment").val() != '' ? parseFloat($("#entertainment").val()) : 0;
        utility = $("#utility").val() != '' ? parseFloat($("#utility").val()) : 0;
        lunch = $("#lunch").val() != '' ? parseFloat($("#lunch").val()) : 0;
        furniture = $("#furniture").val() != '' ? parseFloat($("#furniture").val()) : 0;
        q_allowance = $("#q_allowance").val() != '' ? parseFloat($("#q_allowance").val()) : 0;
        medical = $("#medical").val() != '' ? parseFloat($("#medical").val()) : 0;
        gli = $("#gli").val() != '' ? parseFloat($("#gli").val()) : 0;
        eca = $("#eca").val() != '' ? parseFloat($("#eca").val()) : 0;
        itf = $("#itf").val() != '' ? parseFloat($("#itf").val()) : 0;
        nhf = $("#nhf").val() != '' ? parseFloat($("#nhf").val()) : 0;
        calculate_array = [];
        which = 'pension_earning';
        $("#open_modal").trigger("click");
    });
    $("#cal_tax").on("click", function(e){
      e.preventDefault();
      $("#to_calculate").text("Calculate to Tax");
        b_salary = $("#basic_salary").val() != '' ? parseFloat($("#basic_salary").val()) : 0;
        housing = $("#housing").val() != '' ?  parseFloat($("#housing").val()) : 0;
        transport = $("#transport").val() != '' ? parseFloat($("#transport").val()) : 0;
        education = $("#education").val() != '' ? parseFloat($("#education").val()) : 0;
        entertainment = $("#entertainment").val() != '' ? parseFloat($("#entertainment").val()) : 0;
        utility = $("#utility").val() != '' ? parseFloat($("#utility").val()) : 0;
        lunch = $("#lunch").val() != '' ? parseFloat($("#lunch").val()) : 0;
        furniture = $("#furniture").val() != '' ? parseFloat($("#furniture").val()) : 0;
        q_allowance = $("#q_allowance").val() != '' ? parseFloat($("#q_allowance").val()) : 0;
        medical = $("#medical").val() != '' ? parseFloat($("#medical").val()) : 0;
        gli = $("#gli").val() != '' ? parseFloat($("#gli").val()) : 0;
        eca = $("#eca").val() != '' ? parseFloat($("#eca").val()) : 0;
        itf = $("#itf").val() != '' ? parseFloat($("#itf").val()) : 0;
        nhf = $("#nhf").val() != '' ? parseFloat($("#nhf").val()) : 0;
        calculate_array = [];
        which = 'tax';
        $("#open_modal").trigger("click");
    });
    $("#cal_gross").on("click", function(e){
      e.preventDefault();
      $("#to_calculate").text("Calculate to Tax");
        b_salary = $("#basic_salary").val() != '' ? parseFloat($("#basic_salary").val()) : 0;
        housing = $("#housing").val() != '' ?  parseFloat($("#housing").val()) : 0;
        transport = $("#transport").val() != '' ? parseFloat($("#transport").val()) : 0;
        education = $("#education").val() != '' ? parseFloat($("#education").val()) : 0;
        entertainment = $("#entertainment").val() != '' ? parseFloat($("#entertainment").val()) : 0;
        utility = $("#utility").val() != '' ? parseFloat($("#utility").val()) : 0;
        lunch = $("#lunch").val() != '' ? parseFloat($("#lunch").val()) : 0;
        furniture = $("#furniture").val() != '' ? parseFloat($("#furniture").val()) : 0;
        q_allowance = $("#q_allowance").val() != '' ? parseFloat($("#q_allowance").val()) : 0;
        medical = $("#medical").val() != '' ? parseFloat($("#medical").val()) : 0;
        gli = $("#gli").val() != '' ? parseFloat($("#gli").val()) : 0;
        eca = $("#eca").val() != '' ? parseFloat($("#eca").val()) : 0;
        itf = $("#itf").val() != '' ? parseFloat($("#itf").val()) : 0;
        nhf = $("#nhf").val() != '' ? parseFloat($("#nhf").val()) : 0;
        calculate_array = [];
        which = 'gross';
        $("#open_modal").trigger("click");
    });
    $("#cal_service_charge").on("click", function(e){
      e.preventDefault();
      $("#to_calculate").text("Calculate Service Charge");
        b_salary = $("#basic_salary").val() != '' ? parseFloat($("#basic_salary").val()) : 0;
        housing = $("#housing").val() != '' ?  parseFloat($("#housing").val()) : 0;
        transport = $("#transport").val() != '' ? parseFloat($("#transport").val()) : 0;
        education = $("#education").val() != '' ? parseFloat($("#education").val()) : 0;
        entertainment = $("#entertainment").val() != '' ? parseFloat($("#entertainment").val()) : 0;
        utility = $("#utility").val() != '' ? parseFloat($("#utility").val()) : 0;
        lunch = $("#lunch").val() != '' ? parseFloat($("#lunch").val()) : 0;
        furniture = $("#furniture").val() != '' ? parseFloat($("#furniture").val()) : 0;
        q_allowance = $("#q_allowance").val() != '' ? parseFloat($("#q_allowance").val()) : 0;
        medical = $("#medical").val() != '' ? parseFloat($("#medical").val()) : 0;
        gli = $("#gli").val() != '' ? parseFloat($("#gli").val()) : 0;
        eca = $("#eca").val() != '' ? parseFloat($("#eca").val()) : 0;
        itf = $("#itf").val() != '' ? parseFloat($("#itf").val()) : 0;
        nhf = $("#nhf").val() != '' ? parseFloat($("#nhf").val()) : 0;
        calculate_array = [];
        which = 'service_charge';
        $("#open_modal").trigger("click");
    });
    $("#cal_net").on("click", function(e){
      e.preventDefault();
      $("#to_calculate").text("Calculate to Net Profit");
        b_salary = $("#basic_salary").val() != '' ? parseFloat($("#basic_salary").val()) : 0;
        housing = $("#housing").val() != '' ?  parseFloat($("#housing").val()) : 0;
        transport = $("#transport").val() != '' ? parseFloat($("#transport").val()) : 0;
        education = $("#education").val() != '' ? parseFloat($("#education").val()) : 0;
        entertainment = $("#entertainment").val() != '' ? parseFloat($("#entertainment").val()) : 0;
        utility = $("#utility").val() != '' ? parseFloat($("#utility").val()) : 0;
        lunch = $("#lunch").val() != '' ? parseFloat($("#lunch").val()) : 0;
        furniture = $("#furniture").val() != '' ? parseFloat($("#furniture").val()) : 0;
        q_allowance = $("#q_allowance").val() != '' ? parseFloat($("#q_allowance").val()) : 0;
        medical = $("#medical").val() != '' ? parseFloat($("#medical").val()) : 0;
        gli = $("#gli").val() != '' ? parseFloat($("#gli").val()) : 0;
        eca = $("#eca").val() != '' ? parseFloat($("#eca").val()) : 0;
        itf = $("#itf").val() != '' ? parseFloat($("#itf").val()) : 0;
        nhf = $("#nhf").val() != '' ? parseFloat($("#nhf").val()) : 0;
        calculate_array = [];
        which = 'net';
        $("#open_modal").trigger("click");
    });
    $("#cal_vat").on("click", function(e){
      e.preventDefault();
      $("#to_calculate").text("Calculate VAT");
        b_salary = $("#basic_salary").val() != '' ? parseFloat($("#basic_salary").val()) : 0;
        housing = $("#housing").val() != '' ?  parseFloat($("#housing").val()) : 0;
        transport = $("#transport").val() != '' ? parseFloat($("#transport").val()) : 0;
        education = $("#education").val() != '' ? parseFloat($("#education").val()) : 0;
        entertainment = $("#entertainment").val() != '' ? parseFloat($("#entertainment").val()) : 0;
        utility = $("#utility").val() != '' ? parseFloat($("#utility").val()) : 0;
        lunch = $("#lunch").val() != '' ? parseFloat($("#lunch").val()) : 0;
        furniture = $("#furniture").val() != '' ? parseFloat($("#furniture").val()) : 0;
        q_allowance = $("#q_allowance").val() != '' ? parseFloat($("#q_allowance").val()) : 0;
        medical = $("#medical").val() != '' ? parseFloat($("#medical").val()) : 0;
        gli = $("#gli").val() != '' ? parseFloat($("#gli").val()) : 0;
        eca = $("#eca").val() != '' ? parseFloat($("#eca").val()) : 0;
        itf = $("#itf").val() != '' ? parseFloat($("#itf").val()) : 0;
        nhf = $("#nhf").val() != '' ? parseFloat($("#nhf").val()) : 0;
        calculate_array = [];
        which = 'vat';
        $("#open_modal").trigger("click");
    });
    $(".badge").on('click', function(e){
      e.preventDefault();
      let val = $("#"+this.id+"").children().length;
      let id;
      let pos;
      let sum = 0;
      if(val == 0){
        tomultiply = parseFloat($("#valueInpercentage").val()) / 100;
        $("#"+this.id+"").append('<i class="fas fa-check" style="padding: 0px;color: #4e73df"></i>');
        if(this.id == 'm_salary') calculate_array.push(b_salary);
        if(this.id == 'm_housing') calculate_array.push(housing);
        if(this.id == 'm_transport') calculate_array.push(transport);
        if(this.id == 'm_education') calculate_array.push(education);
        if(this.id == 'm_entertainment') calculate_array.push(entertainment); 
        if(this.id == 'm_utility') calculate_array.push(utility); 
        if(this.id == 'm_lunch') calculate_array.push(lunch); 
        if(this.id == 'm_NHF') calculate_array.push(nhf);
        if(this.id == 'm_ITF') calculate_array.push(itf);
        if(this.id == 'm_ECA') calculate_array.push(eca);
        if(this.id == 'm_GLI') calculate_array.push(gli);
        if(this.id == 'm_furniture') calculate_array.push(furniture); 
        if(this.id == 'm_quarterly_allowance') calculate_array.push(q_allowance);
        if(this.id == 'm_medical') calculate_array.push(medical);
        for(let j = 0; j < calculate_array.length; j++){
          sum = sum + parseFloat(calculate_array[j]);
        }
        if(tomultiply > 0){
          toupdateValue =  tomultiply * sum;
        }else {tomultiply = 1; toupdateValue =  tomultiply * sum; }
        $("#show_calculated_value").text(toupdateValue);
      }else {
        $("#"+this.id+"").find("i").remove();
        //$("#"+this.id+"").append('<i class="fas fa-check" style="padding: 0px;color: #4e73df"></i>');
        if(this.id == 'm_salary'){
          let index = calculate_array.indexOf(b_salary);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_housing'){
          let index = calculate_array.indexOf(housing);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_transport'){
          let index = calculate_array.indexOf(transport);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_education'){
          let index = calculate_array.indexOf(education);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_lunch'){
          let index = calculate_array.indexOf(lunch);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_utility'){
          let index = calculate_array.indexOf(utility);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_entertainment'){
          let index = calculate_array.indexOf(entertainment);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_ITF'){
          let index = calculate_array.indexOf(itf);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_medical'){
          let index = calculate_array.indexOf(medical);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_NHF'){
          let index = calculate_array.indexOf(nhf);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_ECA'){
          let index = calculate_array.indexOf(eca);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_GLI'){
          let index = calculate_array.indexOf(gli);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_quarterly_allowance'){
          let index = calculate_array.indexOf(q_allowance);
          calculate_array[index] = 0;
        }
        if(this.id == 'm_furniture'){
          let index = calculate_array.indexOf(furniture);
          calculate_array[index] = 0;
        }
        for(let j= 0; j < calculate_array.length; j++){
          sum = sum + parseFloat(calculate_array[j]);
        }
        if(tomultiply > 0){
          toupdateValue =  tomultiply * sum;
        }
        $("#show_calculated_value").text(toupdateValue);
      }
    });
    $("#continue").on("click", function(e){
      tomultiply = 0;
      $("#valueInpercentage").val('');
      $("#show_calculated_value").text(0);
      $("#m_salary").find("i").remove();
      $("#m_transport").find("i").remove();
      $("#m_entertainment").find("i").remove();
      $("#m_education").find("i").remove();
      $("#m_housing").find("i").remove();
      $("#m_utility").find("i").remove();
      $("#m_lunch").find("i").remove();
      if(which == 'pension_company'){
        $("#pension_company").val(toupdateValue);
      }
      if(which == 'leave'){
        $("#leave").val(toupdateValue);
      }
      if(which == 'xmas'){
        $("#xmas").val(toupdateValue);
      }
      if(which == 'pension_earning'){
        $("#pension_earning").val(toupdateValue);
      }
      if(which == 'tax'){
        $("#tax").val(toupdateValue);
      }
      if(which == 'gross'){
        $("#gross").val(toupdateValue);
      }
      if(which == 'service_charge'){
        $("#service_charge").val(toupdateValue);
      }
      if(which == 'net'){
        $("#net").val(toupdateValue);
      }
      if(which == 'vat'){
        $("#vat").val(toupdateValue);
      }
    });
    $("#valueInpercentage").on("keydown", function(e){
        sum = 0;
        tomultiply = parseFloat($("#valueInpercentage").val()) / 100;
        for(let j = 0; j < calculate_array.length; j++){
          sum = sum + parseFloat(calculate_array[j]);
        }
        if(tomultiply > 0){
          toupdateValue =  tomultiply * sum;
        }else {tomultiply = 1; toupdateValue =  tomultiply * sum; }
        $("#show_calculated_value").text(toupdateValue);
    })
  })
</script>
        
