<?php
 include 'connection.php';
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
 $leave_level = [];
 $requisition_level = [];
 $all_approval = [];
 //print_r($_SESSION['user']);
 /* $query = "SELECT * FROM users WHERE user_company = '".$_SESSION['user']['user_company']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
        if($row['department'] != '') $dept = explode(";",$row['department']);
        else $dept = [];
        //$branch = explode(";", $row['branch']);
        if($row['appraisal_flow'] != '') $appraisal_level = explode(";", $row['appraisal_flow']);
        else $appraisal_level = [];
        if($row['leave_flow'] != '') $leave_level = explode(";", $row['leave_flow']);
        else $leave_level = [];
        if($row['requisition_flow'] != '') $requisition_level = explode(";", $row['requisition_flow']);
        else $requisition_level = [];
      }
  }*/
  //print_r($data);
  //print_r($_SESSION['user']);
 /*$appraisal_approval_details = $appraisal_level;
 $leave_approval_details = $leave_level;
 $requisition_approval_details = $requisition_level;
 for($e = 0; $e < count($appraisal_level); $e++){
  echo $appraisal_level[$e];
  if(count($appraisal_approval_details) > 0){
    $val = $appraisal_approval_details[$e];
    if(!in_array(strtolower($val), $all_approval)){ $all_approval[] = strtolower($val);}
  }
 }
 //print_r($leave_approval_details);
for($e = 0; $e < count($leave_level); $e++){
  if(count($leave_approval_details) > 0){
      $val = $leave_approval_details[$e];
      if(!in_array(strtolower($val), $all_approval)){ $all_approval[] = strtolower($val);}
  }
 }
 //print_r($_SESSION['user']['requisition_flow']);
 for($e = 0; $e < count($requisition_level); $e++){
  if(count($requisition_approval_details) > 0){
      $val = $requisition_approval_details[$e];
      if(!in_array(strtolower($val), $all_approval)){ $all_approval[] = strtolower($val);}
  }
    
 }*/
 //print_r($all_approval);
?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="dashboard">Dashboard</a></li>
                    </ul>
                  </li>
                  <?php if($_SESSION['user']['category'] == 'admin'){?>
                      <li><a><i class="fa fa-cog"></i> Manage Account <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="user_account">Account</a></li>
                        </ul>
                      </li>
                  <?php }?>
                  <?php if($_SESSION['user']['category'] == 'staff') { ?>
                  
                  <li><a><i class="fa fa-home"></i> Download Forms <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href = "downloadfile.php/?to=long&filename=nhf_form.pdf">NHF form</a></li>
                      <li><a href = "downloadfile.php/?to=long&filename=change_hospital.docx">Change of Hospital form</a></li>
                      <li><a href = "downloadfile.php/?to=long&filename=exit_form.pdf">Exit form</a></li>
                      <li><a href = "downloadfile.php/?to=long&filename=non_such.pdf">NON such HMO form</a></li>
                      <li><a href = "downloadfile.php/?to=long&filename=loan_application.pdf">Loan Application form</a></li>
                      <li><a href = "downloadfile.php/?to=long&filename=loan_calculator.pdf">Loan Calculator</a></li>
                      <li><a href = "downloadfile.php/?to=long&filename=loan_renewal.pdf">Loan Renewal form</a></li>
                      <li><a href = "downloadfile.php/?to=long&filename=oceanic_health_form.pdf">Oceanic Health form</a></li>
                    </ul>
                  </li>
                  <?php  } ?>
                  <?php if($_SESSION['user']['category'] == 'admin') {?>
                  <li><a><i class="fa fa-file"></i> HRCORE Manual <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="downloadfile.php/?to=long&filename=manual.pdf">Download Manual</a></li>
                    </ul>
                  </li>
                  <?php } ?>
                  <!--li><a><i class="fa fa-desktop"></i>Requisition<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php if($_SESSION['user']['category'] == 'admin' || $_SESSION['user']['add_item_permission'] == '1') { ?>
                        <li><a href="addItems">Add Items</a></li>
                      <?php } ?>
                      <?php if($_SESSION['user']['category'] == 'staff') { ?>
                      <li><a href="requestitems">Request Item</a></li>
                      <?php } ?>
                      <li><a href="requesteditems">Requested Item</a></li>
                      <li><a href="inventory">Inventory</a></li>
                      <?php if($_SESSION['user']['position'] != '') {?>
                      <li><a href="requisition_remark">Remark</a></li>
                      <?php } ?>  
                    </ul>
                  </li-->
                  <!--li><a><i class="fa fa-money"></i>Cash Request<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php if($_SESSION['user']['category'] == 'staff') { ?>
                      <li><a href="make_request">Request</a></li>
                      <li><a href="requestedcash">Requested Cash</a></li>
                      <?php } ?>
                      
                      <?php if($_SESSION['user']['category'] == 'admin' || $_SESSION['user']['cash_processing_permission'] == '1') { ?>
                        <li><a href="all_cash_request">Process Cash Request</a></li>
                      <?php  } ?>
                      <?php if($_SESSION['user']['position'] != '') {?>
                      <li><a href="manager_remark">Remark</a></li>
                      <?php } ?>  
                    </ul>
                  </li-->
                  <?php if($_SESSION['user']['category'] == 'admin') { ?>
                  <li><a><i class="fa fa-edit"></i> Leave Tool<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      
                      <li><a href="leave_types">Leave Types</a></li>
                      
                      
                    </ul>
                  </li>
                  <?php } ?>
                  <li><a><i class="fa fa-edit"></i> Leave Management<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php if($_SESSION['user']['category'] == 'staff' && $_SESSION['user']['position'] =='') { ?>
                      <li><a href="staff_leave_request">Leave Request</a></li>
                      <li><a href="view_leave">View Leave</a></li>
                      <?php } ?>
                      <?php if($_SESSION['user']['category'] == 'admin') { ?>
                      <li><a href="view_leave">View Leave</a></li>
                      <?php } ?>
                      <?php if($_SESSION['user']['position'] != '') {?>
                      <li><a href="leave_remark">Leave Approvals</a></li>
                      <?php } ?>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-desktop"></i>Appraisal Management<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php if($_SESSION['user']['category'] == 'admin') {?>
                       <li><a href="create_appraisal">Create Appraisal</a></li>
                      <?php } ?>
                      <li><a href="appraisals">Appraisals</a></li>
                      <?php if($_SESSION['user']['category'] == 'staff') {?>
                       <li><a href="see_appraisals">Monitor Appraisal</a></li>
                      <?php } ?>
                      
                       <!--li><a href="staff_filled_appraisal">Monitor Appraisal</a></li-->
                       <?php if($_SESSION['user']['category'] == 'admin') {?>
                       <li><a href="all_staff_appraisal.php">Monitor Appraisal</a></li>
                       <li><a href="export_appraisal.php">Export Data</a></li>
                      <?php } ?>
                      <?php if($_SESSION['user']['position'] != '') {?>
                      <li><a href="appraisal_remark">Remark</a></li>
                      <?php } ?>
                    </ul>
                  </li>
                  <!--li><a><i class="fa fa-table"></i> Employee Information <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php if($_SESSION['user']['category'] == 'staff') {?>
                      <li><a href="qualification">Qualification</a></li>
                      <?php } ?>
                      <?php if($_SESSION['user']['category'] == 'admin') {?>
                      <li><a href="open_portal">Open Portal</a></li>
                      <li><a href="employee_information">Employee Information</a></li>
                      <?php }?>
                      <?php if($_SESSION['user']['category'] == 'staff') {?>
                      <li><a href="personal_information">Personal Information</a></li>  
                      <li><a href="workexperience">Work Experience</a></li>
                      <li><a href="certifications">Professional Certification</a></li>
                    <?php }?>
                    </ul>
                  </li-->
                  <?php if($_SESSION['user']['position'] == '') { ?>
                  <li><a><i class="fa fa-desktop"></i>ID Request<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php if($_SESSION['user']['category'] == 'staff') {?>
                       <li><a href="request_idcard">Make Request</a></li>
                       <li><a href="view_id_request_status">View status</a></li>
                      <?php } ?>
                      
                      <?php if($_SESSION['user']['category'] == 'admin' || $_SESSION['user']['id_card_permission'] == '1'){ ?>
                      <li><a href="view_all_id_request">View Request</a></li>
                     <?php } ?>
                    </ul>
                  </li>
                  <?php } ?>
                   <?php if($_SESSION['user']['category'] == 'admin') {?>
                  <li><a><i class="fa fa-users"></i>Staff Directory<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="staff_directory">Staff Directory</a></li>
                    </ul>
                  </li>
                  <?php } ?>
                  
                  <?php if($_SESSION['user']['category'] == 'staff' && $_SESSION['user']['position'] == '') {?>
                  <li><a><i class="fa fa-users"></i>Employee Update<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="staff_settings">Employee Update</a></li>
                    </ul>
                  </li>
                  <?php } ?>
                  <?php if($_SESSION['user']['category'] == 'staff'  && $_SESSION['user']['position'] == '') {?>
                  <li><a><i class="fa fa-users"></i>Staff Audit<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                     <?php if($_SESSION['user']['category'] == 'staff') {?>    
                      <li><a href="staff_audit">Staff Audit</a></li>
                     <?php } ?> 
                      <?php if($_SESSION['user']['category'] == 'admin') {?>
                      <li><a href="audit">Audit</a></li>  
                      <li><a href="begin_audit">Begin Audit</a></li>
                      <?php  } ?>
                    </ul>
                  </li>
                  <?php } ?>
                  <?php if($_SESSION['user']['category'] == 'admin') {?>
                  <li><a><i class="fa fa-users"></i>Staff Audit<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                     <?php if($_SESSION['user']['category'] == 'staff') {?>    
                      <li><a href="staff_audit">Staff Audit</a></li>
                     <?php } ?> 
                      <?php if($_SESSION['user']['category'] == 'admin') {?>
                      <li><a href="audit">Audit</a></li>  
                      <li><a href="begin_audit">Begin Audit</a></li>
                      <?php  } ?>
                    </ul>
                  </li>
                  <?php } ?>
                  <!--li><a><i class="fa fa-bar-chart-o"></i>kss dashboard<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="kss">kss</a></li>
                      <li><a href="share_knowledge">Share knowledge</a></li>
                    </ul>
                  </li-->
                </ul>
              </div>
              <?php if($_SESSION['user']['category'] == 'admin') {?>
              <div class="menu_section">
                <h3>Create Employee</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Employee <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="create_user">Add Employee</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
             <?php } ?>
              <?php if($_SESSION['user']['category'] == 'admin') {?>
              <div class="menu_section">
                <h3>Permission</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Permission <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="permission">Grant Permission</a></li>
                      <li><a href="access">Access</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
             <?php } ?>
             <div class="menu_section">
                <h3>Password</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Change Password <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="change_password">Change Password</a></li>
                    </ul>
                  </li>
                  </ul>
              </div>
              <?php if($_SESSION['user']['category'] == 'admin' || $_SESSION['user']['payroll_permission'] =='1') {?>
              <div class="menu_section">
                <h3>Payroll</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Administration <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="branch">Manage Branch</a></li>
                      <li><a href="department">Manage Department</a></li>
                      <li><a href="supervisors">Manage users</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Employee <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="employee">Add Employee</a></li>
                      <li><a href="masterlist">MasterList</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Employee Attendance <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="attendance">Attendance</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
             <?php } ?>
             <?php if($_SESSION['user']['category'] == 'staff' && $_SESSION['user']['position'] =='supervisor') {?>
              <div class="menu_section">
                <h3>Payroll</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Administration <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="">Manage Branch</a></li>
                      <li><a href="">Manage Department</a></li>
                      <li><a href="">Manage Supervisors</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Employee <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="employee">Add Employee</a></li>
                      <li><a href="masterlist">MasterList</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Employee Attendance <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="attendance">Attendance</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
             <?php } ?>
            </div>
            <!-- /sidebar menu -->                     