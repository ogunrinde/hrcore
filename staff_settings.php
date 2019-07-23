<?php 
 include "connection.php";
 session_start();
 $data = [];
 $dept = [];
 $branch = [];
 $appraisal_level = [];
 $appraisal_flow_details = [];
 $requisition_approval_details = [];
 $leave_approval_details = [];
 $appraisal_approval_details = [];
 $requisition_flow_details = [];
 $leave_flow_details = [];
 $cash_flow_details = [];
 $cash_approval_details = [];
 $leave_level = [];
 $requisition_level = [];
 $all_approval = [];
 $comp_appraisal_level = [];
 $comp_requisition_level = [];
 $comp_cash_level = [];
 $comp_leave_level = []; 
 $managing_company = "";
 $leaves_data = [];
 $leaves_data_name = [];
 $leaves_data_phone = [];
 $appraisal_data = [];
 $cash_data = [];
 $req_data = [];
 $user_company = [];
 $pm = [];
 if(!isset($_SESSION['user'])) header("Location: login");
 $msg = '';
if($_SESSION['user']['email'] == '') $msg .= '<p>Email Address, '; 
if($_SESSION['user']['gender'] == '') $msg .= 'Gender, '; 
if($_SESSION['user']['phone_number'] == '') $msg .= 'Phone Number,';
if($_SESSION['user']['branch'] == '') $msg .= ' Branch, ';
if(strtolower($_SESSION['user']['branch']) == 'not updated') $msg .= ' Branch, ';
if($_SESSION['user']['name'] == '') $msg .= ' Surname, ';
if($_SESSION['user']['fname'] == '') $msg .= ' First Name, ';
if($_SESSION['user']['mname'] == '') $msg .= ' Middle Name, ';
if($_SESSION['user']['marital_status'] == '') $msg .= 'Marital Status, ';
if($_SESSION['user']['dob'] == '') $msg .= 'Date of Birth, ';
if($_SESSION['user']['department'] == '') $msg .= 'Department, ';
if($_SESSION['user']['role'] == '') $msg .= 'Role, ';
if($_SESSION['user']['lga'] == '') $msg .= 'Local Government Area, ';
if($_SESSION['user']['sorigin'] == '') $msg .= ' State of Origin, '; 
if($_SESSION['user']['address'] == '') $msg .= 'Address, ';
if($_SESSION['user']['cdate_of_employeement'] == '') $msg .= 'Date of Employment, ';

if($_SESSION['user']['leave_flow'] == '') $msg .= 'Leave Approvers';
if($msg != '' && $_SESSION['user']['category'] == 'staff'){
     $_SESSION['msg'] = '<h4>The following information are required, before you can apply for leave:</h4><p><b>'.$msg.'</b></p>';
     //header("Location:staff_settings.php");
}
 $query = "SELECT * from users where id = '".$_SESSION['user']['admin_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $pm[] = $row;
      }
  }
  //print_r($pm);
  $query = "SELECT * from company";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
  }
  
  for($r = 0; $r < count($data); $r++){
    if($data[$r]['admin_id'] == $_SESSION['user']['admin_id']){
      $managing_company = $data[$r]['company_name'];
      break;
    }
  } 
  //$_SESSIN['user']['leave_flow']
  if($_SESSION['user']['leave_flow'] != ""){
    $leaves = explode(";", $_SESSION['user']['leave_flow']);
    if(count($leaves) > 0){
      foreach ($leaves as $value) {
         $each_leave = explode(":", $value);
         if(count($each_leave) > 1) $leaves_data[] = isset($each_leave[1]) ? $each_leave[1] : ''; 
      }
    }
  } 
  if($_SESSION['user']['flow_name'] != ""){
    $leaves = explode(";", $_SESSION['user']['flow_name']);
    if(count($leaves) > 0){
      foreach ($leaves as $value) {
         $each_leave = explode(":", $value);
         if(count($each_leave) > 1) $leaves_data_name[] = isset($each_leave[1]) ? $each_leave[1] : ''; 
      }
    }
  } 
  if($_SESSION['user']['flow_phone'] != ""){
    $leaves = explode(";", $_SESSION['user']['flow_phone']);
    if(count($leaves) > 0){
      foreach ($leaves as $value) {
         $each_leave = explode(":", $value);
         if(count($each_leave) > 1) $leaves_data_phone[] = isset($each_leave[1]) ? $each_leave[1] : ''; 
      }
    }
  } 
  if($_SESSION['user']['appraisal_flow'] != ""){
    $appraisal = explode(";", $_SESSION['user']['appraisal_flow']);
    if(count($appraisal) > 0){
      foreach ($appraisal as $value) {
         $each_appraisal = explode(":", $value);
         if(count($each_appraisal) > 1) $appraisal_data[] = isset($each_appraisal[1]) ? $each_appraisal[1] : ''; 
      }
    }
  }  
  if($_SESSION['user']['cash_flow'] != ""){
    $cash = explode(";", $_SESSION['user']['cash_flow']);
    if(count($cash) > 0){
      foreach ($cash as $value) {
         $each_cash = explode(":", $value);
         if(count($each_cash) > 1) $cash_data[] = isset($each_cash[1]) ? $each_cash[1] : ''; 
      }
    }
  }  
  if($_SESSION['user']['requisition_flow'] != ""){
    $req = explode(";", $_SESSION['user']['requisition_flow']);
    if(count($req) > 0){
      foreach ($req as $value) {
         $each_req = explode(":", $value);
         if(count($each_req) > 1) $req_data[] = isset($each_req[1]) ? $each_req[1] : ''; 
      }
    }
  } 
  for($e = 0; $e < count($data); $e++){
    if($data[$e]['admin_id'] == $_SESSION['user']['admin_id']){
      $user_company = explode(";",$data[$e]['user_company']);
    }
  } 
  //print_r($user_company);
?>
<style>
    .settings{ width:100%;margin-left:auto;margin-right:auto; }
     
</style>
<?php
  if($_SESSION['user']['address'] == ''){ ?>
      <style>
          #address{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['email'] == ''){ ?>
      <style>
          #email{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['role'] == ''){ ?>
      <style>
          #role{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['leave_flow'] == ''){ ?>
      <style>
          #leave_lManager, #lManager_phone, #lManager_name{
              border: 1px solid red;
          }
          #leave_bManager, #bManager_phone, #bManager_name{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
 <?php if($_SESSION['user']['fname'] == ''){ ?>
      <style>
          #fname{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['name'] == ''){ ?>
      <style>
          #address{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['marital_status'] == ''){ ?>
      <style>
          #marital_status{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['mname'] == ''){ ?>
      <style>
          #mname{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['phone_number'] == ''){ ?>
      <style>
          #phone_number{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['gender'] == ''){ ?>
      <style>
          #gender{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['branch'] == ''){ ?>
      <style>
          #branch{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['cdate_of_employeement'] == ''){ ?>
      <style>
          #date_of_employment{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['department'] == ''){ ?>
      <style>
          #department{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['lga'] == ''){ ?>
      <style>
          #lga{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['sorigin'] == ''){ ?>
      <style>
          #sorigin{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['dob'] == ''){ ?>
      <style>
          #dob{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
  <?php if($_SESSION['user']['marital_status'] == ''){ ?>
      <style>
          #dob{
              border: 1px solid red;
          }
      </style>
  <?php } ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="asset/img/hr.png" type="image/ico" />

    <title>HR CORE </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">



    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>

  <body class="nav-md">
    <div class="container body" style="background-color: #f8fafc;overflow-x:hidden;">
      <div class="">
        <!-- top navigation -->
        <?php include 'top.php' ?>
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main" style="width:100%;margin-left:0px;">
            <div class="">
                <div class="page-title">
                  <div class="title_left">
                      <a href = 'dashboard' class='btn btn-info btn-sm'><i class="fas fa-arrow-left" style = "font-size:20px;">    Go to Dashboard</i></a>
                    <h3>Staff Settings</h3>
                  </div>
    
                  <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                      <div class="input-group">
                        <!--input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button">Go!</button>
                        </span-->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div> 
                <div class="row settings" style="">
                   <?php if(isset($_SESSION['msg'])) {?>
                        <div class="alert alert-primary" style="background-color: red;color:#fff" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Staff Details</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                        <form id="" action="process_staff_data.php" method="POST" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                          <div class="form-group">
                             <div style="text-align: center;margin-bottom: 10px;" id = "uploadimg"><img style="width: 100px;height: 100px;" class="uploadimg" src="images/<?=$_SESSION['user']['profile_image']?>" alt=""></div>
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="admin_email">Service Provider <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="admin_id" onchange="getval(this);" class="form-control" id = "admin_id">
                               <option value="<?=isset($_SESSION['user']['admin_id']) ? $_SESSION['user']['admin_id'] : ''?>"> <?=isset($_SESSION['user']['admin_id']) ? $managing_company : ''?></option>
                              <?php for($r = 0; $r < count($data); $r++){?>
                                <option value = "<?=isset($data[$r]['admin_id']) ? $data[$r]['admin_id'] : '';?>"> <?=isset($data[$r]['admin_id']) ? $data[$r]['company_name'] : ''?></option>
                              <?php } ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="admin_email">Company Name <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="user_company" disabled = 'true' class="form-control" id = "user_company" value="<?=isset($_SESSION['user']['user_company']) ? $_SESSION['user']['user_company'] : ''?>"/>
                           
                            <small class="loading_company"></small>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Surname <span class="required"style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="name" value="<?=isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : ''?>" name = "name" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">first Name <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="fname" value="<?=isset($_SESSION['user']['fname']) ? $_SESSION['user']['fname'] : ''?>" name = "fname" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Middle Name <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="mname" value="<?=isset($_SESSION['user']['mname']) ? $_SESSION['user']['mname'] : ''?>" name = "mname" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email <span class="required"style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="email" id="email" value="<?=isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : ''?>" name = "email" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Phone Number <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="phone_number" value="<?=isset($_SESSION['user']['phone_number']) ? $_SESSION['user']['phone_number'] : ''?>" name="phone_number" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Gender <span class="required"style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select class="form-control col-md-7 col-xs-12" name="gender" id="gender">
                                <option value = "<?=isset($_SESSION['user']['gender']) ? $_SESSION['user']['gender'] : ''?>"><?=isset($_SESSION['user']['gender']) ? $_SESSION['user']['gender'] : ''?></option>
                                <option value = "Male">Male</option>
                                <option value="Female">Female</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="marital_status">Marital Status <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="marital_status" value="<?=isset($_SESSION['user']['marital_status']) ? $_SESSION['user']['marital_status'] : ''?>" name="marital_status" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nationality">Nationality <span class="required" style="color:red;"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="nationality" value="<?=isset($_SESSION['user']['nationality']) ? $_SESSION['user']['nationality'] : ''?>" name="nationality" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Employee ID <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="employee_ID" value="<?=isset($_SESSION['user']['employee_ID']) ? $_SESSION['user']['employee_ID'] : ''?>" name = "employee_ID" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                           <!--div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Role <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="role" value="<?=isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : ''?>" name = "role" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div-->
                          <?php if(count($data) > 0) {?>
                           <!--div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Position <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="position" class="form-control" id = "position">
                               <option value=""></option>
                               <option value="Line Manager">Line Manager</option>
                               <option value="Branch Manager">Branch Manager</option>
                               <option value="Regional Manager">Region Manager</option>
                            </select>
                            </div>
                          </div-->
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Department <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                             <input name="department" value="<?=isset($_SESSION['user']['department']) ? $_SESSION['user']['department'] : ''?>" class="form-control" id = "department"/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Branch <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input name="branch" value="<?=isset($_SESSION['user']['branch']) ? $_SESSION['user']['branch'] : ''?>" class="form-control" id = "branch"/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Role <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name = 'role' id = "role" class="form-control col-md-7 col-xs-12">
                                 <option value="<?=isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : ''?>"><?=isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : ''?></option>
                                 <option value='MARKETING OFFICER'>MARKETING OFFICER</option>
                                 <option value='BUSINESS DEVELOPMENT OFFICER (MARKETING EXECUTIVE)'>BUSINESS DEVELOPMENT OFFICER (MARKETING EXECUTIVE)</option>
                                 <option value='CARDS & DISPUTE RESOLUTION OFFICER'>CARDS & DISPUTE RESOLUTION OFFICER</option>
                                 <option value='CASH MANAGEMENT OFFICER'>CASH MANAGEMENT OFFICER</option>
                                 <option value='CENTRALIZED TRANSACTIONS OFFICER'>CENTRALIZED TRANSACTIONS OFFICER</option>
                                 <option value='CONTROL SUPPORT OFFICER'>CONTROL SUPPORT OFFICER </option>
                                 <option value='CREDIT ADMIN OFFICER'>CREDIT ADMIN OFFICER</option>
                                 <option value='CUSTOMER CARE OFFICER'>CUSTOMER CARE OFFICER</option>
                                 <option value='CUSTOMER SERVICE OFFICER'>CUSTOMER SERVICE OFFICER</option>
                                 <option value='CUSTOMER SERVICE OFFICER/LOAN INPUTTER'>CUSTOMER SERVICE OFFICER/LOAN INPUTTER</option>
                                 <option value='CUSTOMER SERVICE REPRESENTATIVE'>CUSTOMER SERVICE REPRESENTATIVE</option>
                                 <option value='DOMESTIC OPERATIONS OFFICER'>DOMESTIC OPERATIONS OFFICER</option>
                                 <option value='E-CHANNELS OPERATIONS OFFICER'>E-CHANNELS OPERATIONS OFFICER</option>
                                 <option value='FRONT DESK OFFICERS'>FRONT DESK OFFICERS</option>
                                 <option value='GENERAL ADMINISTRATION OFFICER'>GENERAL ADMINISTRATION OFFICER</option>
                                 <option value='INTERNATIONAL OPERATION OFFICER'>INTERNATIONAL OPERATION OFFICER</option>
                                 <option value='LEGAL REGIONAL OFFICER'>LEGAL REGIONAL OFFICER</option>
                                 <option value='MICR OFFICER'>MICR OFFICER</option>
                                 <option value='MONEY TRANSFER OFFICER'>MONEY TRANSFER OFFICER</option>
                                 <option value='PERSONAL ASSISTANT'>PERSONAL ASSISTANT</option>
                                 <option value='PRIORITY BANKING OFFICER'>PRIORITY BANKING OFFICER</option>
                                 <option value='POS SUPPORT OFFICER'>POS SUPPORT OFFICER</option>
                                 <option value='RECONCILIATION SUPPORT OFFICER'>RECONCILIATION SUPPORT OFFICER</option>
                                 <option value='RECORD & INFORMATION MANAGEMENT OFFICER'>RECORD & INFORMATION MANAGEMENT OFFICER</option>
                                 <option value='RECOVERY SUPPORT OFFICER'>RECOVERY SUPPORT OFFICER</option>
                                 <option value='REGIONAL BC HELP DESK OFFICER'>REGIONAL BC HELP DESK OFFICER</option>
                                 <option value='REGIONAL SUPPORT OFFICER'>REGIONAL SUPPORT OFFICER</option>
                                 <option value='RESIDENT COMPLIANCE OFFICER'>RESIDENT COMPLIANCE OFFICER</option>
                                 <option value='REVENUE OPERATIONS OFFICER'>REVENUE OPERATIONS OFFICER</option>
                                 <option value='SPECIAL ASSETS SUPPORT OFFICER'>SPECIAL ASSETS SUPPORT OFFICER</option>
                                 <option value='TRANSACTION OFFICER'>TRANSACTION OFFICER</option>
                                 <option value='Internal Security Guard'>Internal Security Guard</option>
                                 <option value='Dispatch Rider'>Dispatch Rider</option>
                                 <option value='Tea Girl'>Tea Girl</option>
                                 <option value='Office Assistant'>Office Assistant</option>
                                 <option value='Driver'>Driver</option>
                                  <option value='Cash Loader'>Cash Loader</option>
                                 <option value='Tea Girl'>Technician</option>
                                 <option value='Office Assistant'>Technician</option>
                                 <option value='Cash Management Officer'>Cash Management Officer</option>
                            </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="address" value="<?=isset($_SESSION['user']['address']) ? $_SESSION['user']['address'] : ''?>" class="form-control" id = "address"><?=isset($_SESSION['user']['address']) ? $_SESSION['user']['address'] : ''?></textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Date of Birth <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="date" name="" value="<?=isset($_SESSION['user']['dob']) ? $_SESSION['user']['dob'] : ''?>" class="form-control" id = "dob"/>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Religion <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="religion" class="form-control" id = "religion">
                               <option value="<?=isset($_SESSION['user']['religion']) ? $_SESSION['user']['religion'] : ''?>"><?=isset($_SESSION['user']['religion']) ? $_SESSION['user']['religion'] : ''?></option>
                               <option value="Christianity">Christianity</option>
                               <option value="Islam">Islam</option>
                               <option value="Others">Others</option>
                            </select>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Spouse Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="" value="<?=isset($_SESSION['user']['sname']) ? $_SESSION['user']['sname'] : ''?>" class="form-control" id = "sname"/>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Town 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="" value="<?=isset($_SESSION['user']['town']) ? $_SESSION['user']['town'] : ''?>" class="form-control" id = "town"/>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">LGA of Origin<span class="required" style='color:red'>*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="" value="<?=isset($_SESSION['user']['lga']) ? $_SESSION['user']['lga'] : ''?>" class="form-control" id = "lga"/>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">State of Origin<span class="required" style='color:red'>*</span> 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="" value="<?=isset($_SESSION['user']['sorigin']) ? $_SESSION['user']['sorigin'] : ''?>" class="form-control" id = "sorigin"/>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">State of Residence<span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="" value="<?=isset($_SESSION['user']['sresidence']) ? $_SESSION['user']['sresidence'] : ''?>" class="form-control" id = "sresidence"/>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">No of children 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" name="" value="<?=isset($_SESSION['user']['children']) ? $_SESSION['user']['children'] : ''?>" class="form-control" id = "children"/>
                            </div>
                          </div>
                          
                          
                          
                          <?php } ?>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Upload profile Image <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="file" name="image" onchange="readURL(this)" id="loadimg" style="display: none;">
                              <button type="button" id="showfile" class="btn btn-info">Upload Image</button>
                            </div>
                          </div>
                          <?php if(count($data) == 0) {?>
                          <div class="ln_solid"></div>
                          <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="button">Cancel</button>
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <button type="submit" name = "submit" class="btn btn-success" id = 'basic_data'>Submit</button>
                          </div>
                        </div>
                        <?php } ?>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row settings" style="">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Information</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Degree
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select name="" id="degree" class="form-control col-md-7 col-xs-12">
                                    <option value="<?=isset($_SESSION['user']['degree']) ? $_SESSION['user']['degree'] : ''?>"><?=isset($_SESSION['user']['degree']) ? $_SESSION['user']['degree'] : ''?></option>
                                    <option value="Ph.D">Ph.D</option>
                                    <option value="M.Sc">M.Sc</option>
                                    <option value="M.BA">M.BA</option>
                                    <option value="B.Sc">B.Sc</option>
                                    <option value="B.TECH">B.TECH</option>
                                    <option value="B.ENG">B.ENG</option>
                                    <option value="B.A">B.A</option>
                                    <option value="HND">HND</option>
                                    <option value="OND">OND</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Institution
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="institution" class="form-control col-md-7 col-xs-12" id = 'institution' value="<?=isset($_SESSION['user']['institution']) ? $_SESSION['user']['institution'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Course of Study<span class="required"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="course_of_study" class="form-control col-md-7 col-xs-12" id = 'course_of_study' value="<?=isset($_SESSION['user']['course']) ? $_SESSION['user']['course'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Grade
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="grade" class="form-control col-md-7 col-xs-12" id = 'grade' value="<?=isset($_SESSION['user']['grade']) ? $_SESSION['user']['grade'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">NYSC Certificate No
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="" class="form-control col-md-7 col-xs-12" id = 'nysc_cert' value="<?=isset($_SESSION['user']['nysc_cert']) ? $_SESSION['user']['nysc_cert'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Date of Employment<span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="date" name="" value="<?=isset($_SESSION['user']['cdate_of_employeement']) ? $_SESSION['user']['cdate_of_employeement'] : ''?>" class="form-control col-md-7 col-xs-12" id = 'date_of_employment'>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Confirmed<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select name="confirmed" id="confirmed" class="form-control col-md-7 col-xs-12">
                                    <option value="<?=isset($_SESSION['user']['confirmed']) ? $_SESSION['user']['confirmed'] : ''?>"><?=isset($_SESSION['user']['confirmed']) ? $_SESSION['user']['confirmed'] : ''?></option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="unconfirmed">Unconfirmed</option>
                                  </select>
                                </div>
                              </div>
                          </form>
                      </div>
                    </div>
                    
                     <div class="x_panel">
                      <div class="x_title">
                        <h2>Second Degree/ Qualification</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Degree<span class="required"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select name="" id="sdegree" class="form-control col-md-7 col-xs-12">
                                    <option value="<?=isset($_SESSION['user']['sdegree']) ? $_SESSION['user']['sdegree'] : ''?>"><?=isset($_SESSION['user']['sdegree']) ? $_SESSION['user']['sdegree'] : ''?></option>
                                    <option value="Ph.D">Ph.D</option>
                                    <option value="M.Sc">M.Sc</option>
                                    <option value="M.BA">M.BA</option>
                                    <option value="B.Sc">B.Sc</option>
                                    <option value="B.TECH">B.TECH</option>
                                    <option value="B.ENG">B.ENG</option>
                                    <option value="B.A">B.A</option>
                                    <option value="HND">HND</option>
                                    <option value="OND">OND</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Institution
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="institution" class="form-control col-md-7 col-xs-12" id = 'sinstitution' value="<?=isset($_SESSION['user']['sinstitution']) ? $_SESSION['user']['sinstitution'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Course of Study
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="course_of_study" class="form-control col-md-7 col-xs-12" id = 'scourse_of_study' value="<?=isset($_SESSION['user']['scourse_of_study']) ? $_SESSION['user']['scourse_of_study'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Grade
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="grade" class="form-control col-md-7 col-xs-12" id = 'sgrade' value="<?=isset($_SESSION['user']['sgrade']) ? $_SESSION['user']['sgrade'] : ''?>">
                                </div>
                              </div>
   
                          </form>
                      </div>
                    </div>
                    
                     <div class="x_panel">
                      <div class="x_title">
                        <h2>Third Degree/ Qualification</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Degree<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select name="" id="tdegree" class="form-control col-md-7 col-xs-12">
                                    <option value="<?=isset($_SESSION['user']['tdegree']) ? $_SESSION['user']['tdegree'] : ''?>"><?=isset($_SESSION['user']['tdegree']) ? $_SESSION['user']['tdegree'] : ''?></option>
                                    <option value="Ph.D">Ph.D</option>
                                    <option value="M.Sc">M.Sc</option>
                                    <option value="M.BA">M.BA</option>
                                    <option value="B.Sc">B.Sc</option>
                                    <option value="B.TECH">B.TECH</option>
                                    <option value="B.ENG">B.ENG</option>
                                    <option value="B.A">B.A</option>
                                    <option value="HND">HND</option>
                                    <option value="OND">OND</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Institution
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="institution" class="form-control col-md-7 col-xs-12" id = 'tinstitution' value="<?=isset($_SESSION['user']['tinstitution']) ? $_SESSION['user']['tinstitution'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Course of Study
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="course_of_study" class="form-control col-md-7 col-xs-12" id = 'tcourse_of_study' value="<?=isset($_SESSION['user']['tcourse_of_study']) ? $_SESSION['user']['tcourse_of_study'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Grade
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="grade" class="form-control col-md-7 col-xs-12" id = 'tgrade' value="<?=isset($_SESSION['user']['tgrade']) ? $_SESSION['user']['tgrade'] : ''?>">
                                </div>
                              </div>
   
                          </form>
                      </div>
                    </div>
                    
                    
                     <div class="x_panel">
                      <div class="x_title">
                        <h2>Professional Certificate</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Professional Qualification
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="institution" class="form-control col-md-7 col-xs-12" id = 'professional_qualification_one' value="<?=isset($_SESSION['user']['professional_qualification_one']) ? $_SESSION['user']['professional_qualification_one'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Awarding Body
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="course_of_study" class="form-control col-md-7 col-xs-12" id = 'award_body_one' value="<?=isset($_SESSION['user']['award_body_one']) ? $_SESSION['user']['award_body_one'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Award Year
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="grade" class="form-control col-md-7 col-xs-12" id = 'award_year_one' value="<?=isset($_SESSION['user']['award_year_one']) ? $_SESSION['user']['award_year_one'] : ''?>">
                                </div>
                              </div>
   
                          </form>
                      </div>
                    </div>
                    
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Professional Certificate 2</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Professional Qualification
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="institution" class="form-control col-md-7 col-xs-12" id = 'professional_qualification_two' value="<?=isset($_SESSION['user']['professional_qualification_two']) ? $_SESSION['user']['professional_qualification_two'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Awarding Body
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="" class="form-control col-md-7 col-xs-12" id = 'award_body_two' value="<?=isset($_SESSION['user']['award_body_two']) ? $_SESSION['user']['award_body_two'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Award Year
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="" class="form-control col-md-7 col-xs-12" id = 'award_year_two' value="<?=isset($_SESSION['user']['award_year_two']) ? $_SESSION['user']['award_year_two'] : ''?>">
                                </div>
                              </div>
   
                          </form>
                      </div>
                    </div>
                    
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Professional Certificate 3</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Professional Qualification
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="" class="form-control col-md-7 col-xs-12" id = 'professional_qualification_three' value="<?=isset($_SESSION['user']['professional_qualification_three']) ? $_SESSION['user']['professional_qualification_three'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Awarding Body
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="" class="form-control col-md-7 col-xs-12" id = 'award_body_three' value="<?=isset($_SESSION['user']['award_body_three']) ? $_SESSION['user']['award_body_three'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Award Year
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="" class="form-control col-md-7 col-xs-12" id = 'award_year_three' value="<?=isset($_SESSION['user']['award_year_three']) ? $_SESSION['user']['award_year_three'] : ''?>">
                                </div>
                              </div>
   
                          </form>
                      </div>
                    </div>
                    
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>HMO</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">On HMO?
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select name="" id="on_hmo" class="form-control col-md-7 col-xs-12">
                                    <option value="<?=isset($_SESSION['user']['on_hmo']) ? $_SESSION['user']['on_hmo'] : ''?>"><?=isset($_SESSION['user']['on_hmo']) ? $_SESSION['user']['on_hmo'] : ''?></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">HMO
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="pm_name" class="form-control col-md-7 col-xs-12" id = 'hmo' value="<?=isset($_SESSION['user']['hmo']) ? $_SESSION['user']['hmo'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">HMO Number
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="number" name="pm_number" class="form-control col-md-7 col-xs-12" id = 'hmo_number' value="<?=isset($_SESSION['user']['hmo_number']) ? $_SESSION['user']['hmo_number'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">HMO Plan
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <textarea type="text" name="" class="form-control col-md-7 col-xs-12"  id = 'hmo_plan' value=""><?=isset($_SESSION['user']['hmo_plan']) ? $_SESSION['user']['hmo_plan'] : ''?></textarea>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">HMO Hospital
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="" class="form-control col-md-7 col-xs-12"  id = 'hmo_hospital' value="<?=isset($_SESSION['user']['hmo_hospital']) ? $_SESSION['user']['hmo_hospital'] : ''?>"/>
                                </div>
                              </div>
                              
                              
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">HMO status
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="" class="form-control col-md-7 col-xs-12"  id = 'hmo_status' value="<?=isset($_SESSION['user']['hmo_status']) ? $_SESSION['user']['hmo_status'] : ''?>"/>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">HMO remarks
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="" class="form-control col-md-7 col-xs-12"  id = 'hmo_remarks' value="<?=isset($_SESSION['user']['hmo_remarks']) ? $_SESSION['user']['hmo_remarks'] : ''?>"/>
                                </div>
                              </div>
                              
                              
                              
                              
                              
                              
                          </form>
                      </div>
                    </div>

                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Pension</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Pension
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="pm_name" class="form-control col-md-7 col-xs-12" id = 'pension' value="<?=isset($_SESSION['user']['pension']) ? $_SESSION['user']['pension'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Pension Number
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="pm_number" class="form-control col-md-7 col-xs-12" id = 'pension_number' value ="<?=isset($_SESSION['user']['pension_pin']) ? $_SESSION['user']['pension_pin'] : ''?>">
                                </div>
                              </div>
                              
                              
                          </form>
                      </div>
                    </div>

                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Next of Kin</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Full Name
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="pm_name" class="form-control col-md-7 col-xs-12" id = 'kname' value="<?=isset($_SESSION['user']['kname']) ? $_SESSION['user']['kname'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Phone Number
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="number" name="pm_number" class="form-control col-md-7 col-xs-12" id = 'kphnumber' value="<?=isset($_SESSION['user']['kphnumber']) ? $_SESSION['user']['kphnumber'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Address
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <textarea type="text" name="" class="form-control col-md-7 col-xs-12"  id = 'kaddress' value=""><?=isset($_SESSION['user']['kaddress']) ? $_SESSION['user']['kaddress'] : ''?></textarea>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Date of Birth
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="date" name="" class="form-control col-md-7 col-xs-12"  id = 'kdob' value="<?=isset($_SESSION['user']['kdob']) ? $_SESSION['user']['kdob'] : ''?>"/>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Gender
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select name="" id="kgender" class="form-control col-md-7 col-xs-12">
                                    <option value="<?=isset($_SESSION['user']['kgender']) ? $_SESSION['user']['kgender'] : ''?>"><?=isset($_SESSION['user']['kgender']) ? $_SESSION['user']['kgender'] : ''?></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                  </select>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Relationship
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="" class="form-control col-md-7 col-xs-12"  id = 'relationship_kin' value="<?=isset($_SESSION['user']['relationship_kin']) ? $_SESSION['user']['relationship_kin'] : ''?>"/>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Email
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="" class="form-control col-md-7 col-xs-12"  id = 'email_kin' value="<?=isset($_SESSION['user']['email_kin']) ? $_SESSION['user']['email_kin'] : ''?>"/>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Is Beneficiary?
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select name="" id="kin_is_beneficiary" class="form-control col-md-7 col-xs-12">
                                    <option value="<?=isset($_SESSION['user']['kin_is_beneficiary']) ? $_SESSION['user']['kin_is_beneficiary'] : ''?>"><?=isset($_SESSION['user']['kin_is_beneficiary']) ? $_SESSION['user']['kin_is_beneficiary'] : ''?></option>
                                    <option value=""></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                  </select>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Is Dependent? 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select name="" id="kin_is_dependent" class="form-control col-md-7 col-xs-12">
                                    <option value="<?=isset($_SESSION['user']['kin_is_dependent']) ? $_SESSION['user']['kin_is_dependent'] : ''?>"><?=isset($_SESSION['user']['kin_is_dependent']) ? $_SESSION['user']['kin_is_dependent'] : ''?></option>
                                    <option value=""></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                  </select>
                                </div>
                              </div>
                              
                              
                              
                              
                          </form>
                      </div>
                    </div>
                    <!--div class="x_panel">
                      <div class="x_title">
                        <h2>People Manager</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Name
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="pm_name" class="form-control col-md-7 col-xs-12" id = 'pm_name' value="<?=isset($pm[0]['name']) ? $pm[0]['name'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Phone Number
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="number" name="pm_number" class="form-control col-md-7 col-xs-12" id = 'pm_number' value="<?=isset($pm[0]['phone_number']) ? $pm[0]['phone_number'] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Email
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="pm_email" class="form-control col-md-7 col-xs-12"  id = 'pm_email' value="<?=isset($pm[0]['email']) ? $pm[0]['email'] : ''?>">
                                </div>
                              </div>
                              
                              
                          </form>
                      </div>
                    </div-->
                   </div>
                </div>

                <?php if(count($data) > 0) {?>
                  <div class="row settings" style="">
                   <?php if(isset($_SESSION['msg'])) {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Approvals</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Line Manager Name<span class="required" style='color:red'>*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="lManager_name" class="form-control col-md-7 col-xs-12" id = 'lManager_name' value="<?=isset($leaves_data_name[0]) ? $leaves_data_name[0] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Line Manager Email<span class="required" style ='color:red;'>*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="leave_lManager" class="form-control col-md-7 col-xs-12" id = 'leave_lManager' value="<?=isset($leaves_data[0]) ? $leaves_data[0] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Line Manager Phone<span class="required" style='color:red;'>*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="lManager_phone" class="form-control col-md-7 col-xs-12" id = 'lManager_phone' value="<?=isset($leaves_data_phone[0]) ? $leaves_data_phone[0] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Branch Manager Name<span class="required" style='color:red'>*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="bManager_name" class="form-control col-md-7 col-xs-12" id = 'bManager_name' value="<?=isset($leaves_data_name[1]) ? $leaves_data_name[1] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Branch Manager Email<span class="required" style='color:red'>*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="leave_bManager" class="form-control col-md-7 col-xs-12" id = 'leave_bManager' value="<?=isset($leaves_data[1]) ? $leaves_data[1] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Branch Manager Phone<span class="required" style = 'color:red'>*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="bManager_phone" class="form-control col-md-7 col-xs-12" id = 'bManager_phone' value="<?=isset($leaves_data_phone[1]) ? $leaves_data_phone[1] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Regional Manager Name<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="rManager_name" class="form-control col-md-7 col-xs-12" id = 'rManager_name' value="<?=isset($leaves_data_name[2]) ? $leaves_data_name[2] : ''?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Regional Manager Email<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="leave_rManager" value="<?=isset($leaves_data[2]) ? $leaves_data[2] : ''?>" class="form-control col-md-7 col-xs-12" id = 'leave_rManager'>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Regional Manager Phone<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="rManager_phone" class="form-control col-md-7 col-xs-12" id = 'rManager_phone' value="<?=isset($leaves_data_phone[2]) ? $leaves_data_phone[2] : ''?>">
                                </div>
                              </div>
                          </form>
                      </div>
                    </div>
                   </div>
                  </div>
                  <div class="row settings" style="">
                   <?php if(isset($_SESSION['msg'])) {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>
                  <div class="alert alert-primary loading" style="background-color: #d1ecf1;" role="alert">
                            Processing Request.....
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                            <button type="button" id = 'staff_btn' class="btn btn-success">Submit</button>
                  </div>
                    <!--div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Appraisal Approvals</h2>

                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                          <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Line Manager Email<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="appraisal_lManager" value="<?=isset($appraisal_data[0]) ? $appraisal_data[0] : ''?>" class="form-control col-md-7 col-xs-12" id = 'appraisal_lManager'>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Branch Manager Email<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="appraisal_lManager" value="<?=isset($appraisal_data[1]) ? $appraisal_data[1] : ''?>" class="form-control col-md-7 col-xs-12" id = 'appraisal_bManager'>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Regional Manager Email<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="appraisal_rManager" value="<?=isset($appraisal_data[2]) ? $appraisal_data[2] : ''?>" class="form-control col-md-7 col-xs-12" id = 'appraisal_rManager'>
                                </div>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div-->
                  <!--div class="row" style="width:60%;margin-left:auto;margin-right:auto;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Requisition Approvals</h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                          <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Line Manager Email<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="req_lManager" value="<?=isset($req_data[0]) ? $req_data[0] : ''?>" class="form-control col-md-7 col-xs-12" id = 'req_lManager'>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Branch Manager Email<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="req_bManager" value="<?=isset($req_data[1]) ? $req_data[1] : ''?>" class="form-control col-md-7 col-xs-12" id = 'req_bManager'>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Regional Manager Email<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="req_rManager" value="<?=isset($req_data[2]) ? $req_data[2] : ''?>" class="form-control col-md-7 col-xs-12" id = 'req_rManager'>
                                </div>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div-->
                  <!--div class="row" style="width:60%;margin-left:auto;margin-right:auto;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Cash Approvals</h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                          <br />
                          <form id="" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Line Manager Email<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="cash_lManager" value="<?=isset($cash_data[0]) ? $cash_data[0] : ''?>" class="form-control col-md-7 col-xs-12" id = 'cash_lManager'>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Branch Manager Email<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="cash_bManager" value="<?=isset($cash_data[1]) ? $cash_data[1] : ''?>" class="form-control col-md-7 col-xs-12" id = 'cash_bManager'>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Regional Manager Email<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" name="cash_rManager" value="<?=isset($cash_data[2]) ? $cash_data[2] : ''?>" class="form-control col-md-7 col-xs-12" id = 'cash_rManager'>
                                </div>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div-->
                  <!--div class="row" style="width:60%;margin-left:auto;margin-right:auto;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="x_panel">
                        <div class="alert alert-primary loading" style="background-color: #d1ecf1;" role="alert">
                            Processing Request.....
                        </div>
                        <div class="x_content">
                          <br />
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                            <button type="button" id = 'staff_btn' class="btn btn-success">Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </div-->
                <?php } ?>
              </div>
          </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="vendors/Flot/jquery.flot.js"></script>
    <script src="vendors/Flot/jquery.flot.pie.js"></script>
    <script src="vendors/Flot/jquery.flot.time.js"></script>
    <script src="vendors/Flot/jquery.flot.stack.js"></script>
    <script src="vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="/build/js/custom.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="js/staff_settings.js"></script>
    <script type="text/javascript">
       $(function(){
        $(".loading").fadeOut("fast");
        $("#admin_id").on("change", function(e){
          let value = $(this).val();
          $(".loading_company").text("Loading Company details.....")
           $.post("specific_company.php",
            { admin_id: value },
            function(data, status){
               let company = atob(data);
               //alert(company);
               let companies = [];
                companies = company.split(";");
                companies.forEach(function(each_company){
                  $("#user_company").append("<option value = '"+each_company+"'> "+each_company+"</option>");
                  $(".loading_company").text('');
                })
            });
        });

       });
    </script>
  </body>
</html>
