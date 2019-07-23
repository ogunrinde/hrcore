<?php 
include 'connection.php';
session_start();
$leaves = [];
$user = [];
$leave_flow = [];
$leave_days = '';
$resumptionday = '';
if(!isset($_SESSION['leave_id'])) header("Location: login.php");
if(isset($_POST['edit'])){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $leave_id = $_POST['leave_id'];
    //echo $start_date.'_'.$end_date.'_'.$leave_id;
    $sql = "Update leaves set start_date = '".$start_date."', end_date = '".$end_date."' where id ='".$leave_id."'";
    if(mysqli_query($conn,$sql)){
        $_SESSION['msg'] = 'Leave Request Edited';
    }else {
        $_SESSION['msg'] = 'Error Editing Data, try again later';
    }
}
if(!isset($_SESSION['leave_id']) && $_SESSION['leave_id'] != '') header("Location: dashboard.php");
   if(isset($_POST['cancel_request'])){
      $sql = "UPDATE leaves SET processed = 'Cancelled' WHERE id = '".$_POST['leave_id']."'";
        if (mysqli_query($conn, $sql)) {
          $_SESSION['msg'] = "Your record has been updated";
        }else {
          //echo "Error: ".mysqli_error($conn);
       } 
  }
  
  if(isset($_POST['update_flow'])){
      $sql = "UPDATE leaves SET flow = '".$_POST['flow']."', stage = '".$_POST['stage']."' WHERE id = '".$_POST['leave_id']."'";
        if (mysqli_query($conn, $sql)) {
          $_SESSION['msg'] = "Your record has been updated";
        }else {
          //echo "Error: ".mysqli_error($conn);
       } 
  }
  $query = "SELECT * FROM leaves WHERE id = '".$_SESSION['leave_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $leaves[] = $row;
      }
  }
   $query = "SELECT * FROM ro";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $ro[] = $row;
      }
  }
  //print_r($leaves);
  if(count($leaves) > 0){
      $end_date = $leaves[0]['end_date'];
     $leave_days =  get_days($leaves[0]['start_date'], $leaves[0]['end_date']);
     $resumptionday = resumptionDate($leaves[0]['end_date']);
  }
   function resumptionDate($end_date){
    	$counter = 0;
    	$resumptionday = '';
     //echo date("N",strtotime($end_date));
     $end_date = date ("Y-m-d", strtotime("+1 day", strtotime($end_date)));
     while($counter == 0){
         if(date("N",strtotime($end_date))<=5) {
        	
        	$resumptionday = date('d M Y',strtotime($end_date));
            $counter++;
            //echo $resumptionday;
        }
        if(counter == 0) $end_date = date ("Y-m-d", strtotime("+1 day", strtotime($end_date)));
     }
     return $resumptionday;
  }
  
  function get_days($start_date,$end_date){
    	$counter = 0;
     $no_included = ['Mon','Tue','Wed','Thu','Fri'];
     //echo date('N',strtotime('2019-03-31'));
     while(strtotime($start_date) <= strtotime($end_date)){
        if(date("N",strtotime($start_date))<=5) {
        	//echo date("N",strtotime($start_date));
            $counter++;
        }
        $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
    
      }
      return $counter;
  }
  if($leaves[0]['flow'] != '') $leave_flow = explode(";", $leaves[0]['flow']);
  //print_r($leave_flow);
  if($_SESSION['user']['category'] == 'admin' && count($leaves) > 0){
      $eachdetManager = [];
      $eachdetvalueEmail = [];
      $eachdetvalueName = [];
    $query = "SELECT * FROM users WHERE id = '".$leaves[0]['staff_id']."'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)> 0){
        while($row = mysqli_fetch_assoc($result)) {
          $user[] = $row;
        }
        //echo 'ass';
        $thisflow = explode(';',$user[0]['leave_flow']);
        //print_r(count($thisflow));
        if(count($thisflow) > 0){
            for($y = 0; $y < count($thisflow); $y++){
                $eachdetManager[] = isset(explode(':',$thisflow[$y])[0]) ? explode(':',$thisflow[$y])[0] : '';
                $eachdetvalueEmail[] = isset(explode(':',$thisflow[$y])[1]) ? explode(':',$thisflow[$y])[1] : '';
            }
        }
        $flowname = explode(';',$user[0]['flow_name']);
        //print_r(count($thisflow));
        if(count($flowname) > 0){
            for($y = 0; $y < count($flowname); $y++){
                //$eachdet[] = isset(explode(':',$flowname[$y])[0]) ? explode(':',$flowname[$y])[0] : '';
                $eachdetvalueName[] = isset(explode(':',$flowname[$y])[1]) ? explode(':',$flowname[$y])[1] : '';
            }
        }
    }
    //print_r($eachdetvalueName);
  }else {
    $user[0]['name'] = '';
    $user[0]['employee_ID'] = '';
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
<link href = "https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">    
<div class="">
        <div class="page-title">
          <div class="title_left">
            
            <h3> <a href = 'view_leave'><i class="fas fa-arrow-left" style = "font-size:30px;"></i></a> Leave Flow</h3>
            <?php if($_SESSION['user']['category'] == 'admin' && $_SESSION['user']['leave_processing_permission'] != '1') { ?>
                    <ul class="nav navbar-left panel_toolbox">
                      <li><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                              Edit Manager Remark
                            </button>
                      </li>
                    </ul>
            <?php  } ?>
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
                        <div class="alert alert-primary" style="background-color: #007bff;font-size:16px;color:#fff" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>
            <?php if($_SESSION['user']['category'] == 'staff' && ($leaves[0]['stage'] == 'Approved' || $leaves[0]['stage'] == 'approved')) {?>
                        <div class="alert alert-primary" style="background-color: #007bff;font-size:16px;color:#fff" role="alert">
                            Congratulations! Your Leave request has been Approved
                        </div>
                  <?php } ?>
            <?php if($_SESSION['user']['category'] == 'admin' && ($leaves[0]['stage'] == 'Approved' || $leaves[0]['stage'] == 'approved')) {?>
                        <div class="alert alert-primary" style="background-color: #007bff;font-size:16px;color:#fff" role="alert">
                            This Leave request has been Approved
                        </div>
                  <?php } ?> 
              <div class="col-md-7 col-sm-12 col-xs-12">               
              <?php for($e = 0; $e < count($leave_flow); $e++) {?>

               <?php if(explode(":",$leave_flow[$e])[0] != 'Regional Manager') {?>
                <div class="x_panel">
                    
                  <div class="x_title">
                    <h2><?=explode(":",$leave_flow[$e])[0]?></h2>
                    <?php
                        for($q = 0; $q < count($eachdetManager); $q++){
                            if(explode(":",$leave_flow[$e])[0] == $eachdetManager[$q]){
                                $manager_name = isset($eachdetvalueName[$q]) ? $eachdetvalueName[$q] : '';
                              $manager_email = isset($eachdetvalueEmail[$q]) ? $eachdetvalueEmail[$q] : '';
                              $det = '<br><p>'.$manager_name.' ('.$manager_email.')</p>';
                            }
                        }
                        //$managedet = 
                         //echo $leave_flow[$e];
                         /*$det = '';
                         $emaildetails = explode(":",$leave_flow[$e])[1];
                         //echo $emaildetails;
                        $sql = "select * from users where email = '".$emaildetails."' Limit 1";
                         $result = mysqli_query($conn, $query);
                          if(mysqli_num_rows($result)> 0){
                              while($row = mysqli_fetch_assoc($result)) {
                                $managerdetails[] = $row;
                              }
                              $manager_name = isset($managerdetails[0]['name']) ? $managerdetails[0]['name'] : '';
                              $manager_fname = isset($managerdetails[0]['fname']) ? $managerdetails[0]['fname'] : '';
                              $manager_email = isset($managerdetails[0]['email']) ? $managerdetails[0]['email'] : '';
                              $det = '<br/><p>'.$manager_name.' '.$manager_fname.' ('.$manager_email.')</p>';
                          }*/
                    ?>
                    <h5 style='float:left;'><?=$det?></h5>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   <div style="width: 100%;margin-left: auto;margin-right: auto;">
                     <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">Approve
                         <?php $_flow = explode(":",$leave_flow[$e])[0];?>
                         <span class="badge badge-pill badge_leave" leave_flow = "<?=$_flow?>" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$leaves[0]['flow']?>" attr_id = "<?=$e?>" id= "approve<?=$e?>" status = "approved" leave_id = "<?=$leaves[0]['id']?>" approval = "<?=$_flow?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                            <?php $flow = explode(";", $leaves[0]['flow']) ?>
                            
                            <?php for ($t = 0; $t < count($flow); $t++) {?>
                            
                               <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                               <?php if($each_flow == explode(":",$leave_flow[$e])[0] && strtolower(explode(":", $flow[$t])[1]) == 'approved') {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df;font-size: 12px;"></i>
                               <?php } ?> 
                            <?php } ?>  
                            
                         </span>
                       </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Decline 
                        <span class="badge badge-pill badge_leave" leave_flow = "<?=$_flow?>" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$leaves[0]['flow']?>" attr_id = "<?=$e?>" id= "decline<?=$e?>" status = "Decline" leave_id = "<?=$leaves[0]['id']?>" approval = "<?=$_flow?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                          <?php $flow = explode(";", $leaves[0]['flow']) ?>
                            <?php for ($t = 0; $t < count($flow); $t++) {?>
                               <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                               <?php if($each_flow == explode(":",$leave_flow[$e])[0] && strtolower(explode(":", $flow[$t])[1]) == 'decline') {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df; font-size: 12px;"></i>
                               <?php } ?> 
                            <?php } ?> 
                         </span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Pending 
                        <span class="badge badge-pill badge_leave" leave_flow = "<?=$_flow?>"" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$leaves[0]['flow']?>" attr_id = "<?=$e?>" id= "pend<?=$e?>" status = "pend" leave_id = "<?=$leaves[0]['id']?>" approval = "<?=$_flow?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                          <?php $flow = explode(";", $leaves[0]['flow']) ?>
                            <?php for ($t = 0; $t < count($flow); $t++) {?>
                               <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                               <?php if($each_flow == explode(":",$leave_flow[$e])[0] && (strtolower(explode(":", $flow[$t])[1]) == 'pend' || strtolower(explode(":", $flow[$t])[1]) == 'pending')) {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df;font-size: 12px;"></i>
                               <?php } ?> 
                            <?php } ?> 
                         </span>
                      </li>
                    </ul>
                  </div>
                  </div>
                  <div style="width: 100%;margin-left: auto;margin-right: auto;">
                      <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-0">
                      <div class="form-group">
                        <label for="exampleInputEmail1"> Remark</label>
                       
                        <?php if($leaves[0]['remarks'] != '') { ?>
                           
                           <?php $remarks = explode(";", $leaves[0]['remarks']) ?> 
                           <?php for ($t = 0; $t < count($remarks); $t++) {?>
                               <?php $each_remark = explode(":", $remarks[$t])[0]; ?>
                               <?php if($each_remark == explode(":",$leave_flow[$e])[0]) {?>
                                <?php $curr = explode(":", $remarks[$t])[1]; ?>
                                <?php if (filter_var($curr, FILTER_VALIDATE_EMAIL)) {?>
                                    <?php  $curr = ''?>
                                  
                                <?php }?>
                               <?php } ?>
                              
                            <?php } ?>
                        <?php } ?>
                        
                        <textarea style='width:100%' <?=$disabled?> leave_flow = "<?=$each_manager?>" full_leave_flow = "<?=$user[0]['leave_flow']?>" email = "<?=$_SESSION['user']['email']?>" class='remark' value = '' id= 'remark<?=$e?>' data = '<?=$each_manager?>'  class = "form-control"><?=$curr?></textarea>
                      </div>
                  </div>
                  </div>
                </div>
                
              
              <?php } } ?> 
              </div>
              <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>New Request</h2>
                    
                    <?php if(strtolower($leaves[0]['stage']) == 'approved' && $_SESSION['user']['leave_processing_permission'] == '1') { ?>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a href ="view_letter.php/?leave_id=<?=base64_encode($_SESSION['leave_id'])?>" class="btn btn-success btn-sm" style="color: #fff;">View Letter</a>
                      </li>
                      <li><a href ="pdf.php/?leave_id=<?=base64_encode($_SESSION['leave_id'])?>" class="btn btn-success btn-sm" style="color: #fff;">Process</a>
                      </li>
                      <?php if ($user[0]['company_name'] == 'ACCESS BANK PLC') { ?>
                      <li><a class="btn btn-success btn-sm" style="color: #fff;" data-toggle="modal" data-target="#exampleModal2">Profile Reliever</a>
                      </li>
                      <?php } ?>
                       
                    </ul>
                  <?php  } ?>
                  <?php if($_SESSION['user']['category'] == 'admin' && $_SESSION['user']['leave_processing_permission'] != '1') { ?>
                    <ul class="nav navbar-right panel_toolbox">
                      <li>
                      <form action = 'view_leave_flow.php' method = 'POST'>
                         <input name = 'leave_id' style='display:none;' value = "<?=$_SESSION['leave_id']?>"/>
                         <button type="submit" name = "cancel_request" class="btn btn-danger" id = '' leave_id = "">
                              Cancel Employee Leave Request 
                            </button>
                       </form>        
                      </li>
                    </ul>
            <?php  } ?> 
                    
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($leaves) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <tbody>
                         <tr>
                           <td style="width: 60%">Request By</td>
                           <td style="width: 40%"><?=$_SESSION['user']['category'] == 'staff' ? $_SESSION['user']['name'] : $user[0]['name']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Employee ID</td>
                           <td style="width: 40%"><?=$_SESSION['user']['category'] == 'staff' ? $_SESSION['user']['employee_ID'] : $user[0]['employee_ID']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Leave Type</td>
                           <td style="width: 40%"><?=$leaves[0]['leave_type']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Start Date</td>
                           <td style="width: 40%"><?=$leaves[0]['start_date']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">End Date</td>
                           <td style="width: 40%"><?=$leaves[0]['end_date']?></td>
                         </tr>
                          <tr>
                           <td style="width: 60%">Leave Days</td>
                           <td style="width: 40%"><?=$leave_days?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Resumption Day</td>
                           <td style="width: 40%"><?=$resumptionday?></td>
                         </tr>
                          <tr>
                           <td style="width: 60%">Required Reliever</td>
                           <td style="width: 40%"><?=$leaves[0]['require_reliever']?></td>
                         </tr>
                          <tr>
                           <td style="width: 60%">Reliever Source</td>
                           <td style="width: 40%"><?=$leaves[0]['reliever_source']?></td>
                         </tr>
                          <tr>
                           <td style="width: 60%">Reliever Name</td>
                           <td style="width: 40%"><?=$leaves[0]['reliever_name']?></td>
                         </tr>
                          <tr>
                           <td style="width: 60%">Reliever Email</td>
                           <td style="width: 40%"><?=$leaves[0]['reliever_email']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Reliever Phone</td>
                           <td style="width: 40%"><?=$leaves[0]['reliever_phone']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Request Date</td>
                           <td style="width: 40%"><?=$leaves[0]['date_created']?></td>
                         </tr>
                         <tr>
                             <td>
                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditModal">
                                    Edit
                                </button>
                             </td>
                        </tr>
                      </table>
                    </div>
                    <?php } ?> 
                  </div>
                </div>
              </div>
              <?php if($_SESSION['user']['category'] != 'admin') {?>
              <!--div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                    <button type="submit" id = 'submit_btn_leave' class="btn btn-success">Update</button>
              </div--> 
              <?php }?>  
        </div>
</div>
</div>
<?php include "footer.php"?>
<script type = "text/javascript"></script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                 <?php if($leaves[0]['flow'] != '') { ?>
                 
                 <?php $line_manager = ''; $branch_manager = ''; $regional_manager = '';?>
                <?php $flow = explode(";", $leaves[0]['flow']) ?>
                                            
                <?php for ($t = 0; $t < count($flow); $t++) {?>
                   
                   <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                       <?php if(strtolower($each_flow) == 'line manager') {
                         $line_manager = ucwords(explode(":", $flow[$t])[1]);
                         }else if (strtolower($each_flow) == 'branch manager') { 
                         $branch_manager = ucwords(explode(":", $flow[$t])[1]); 
                         }else if(strtolower($each_flow) == 'regional manager'){
                         $regional_manager = ucwords(explode(":", $flow[$t])[1]);
                         }
                        ?>
                <?php } ?>
                <?php } ?>
                 <form action = 'view_leave_flow.php' method = "POST">
                  <?php if($branch_manager != '') { ?>
                  <div class="form-group">
                  
                    <label for="exampleInputEmail1">Line Manager</label>
                    <select name = "line_manager" branch_manager = '<?=$branch_manager?>' regional_manager = '<?=$regional_manager?>' line_manager = '<?=$line_manager?>' class="form-control manager" id = 'line'>
                       <option value = '<?=$line_manager?>'><?=$line_manager?></option>
                       <option value = 'Approved'>Approve</option>
                       <option value = 'Decline'>Decline</option>
                       <option value = 'Pending'>Pending</option>
                    </select>
                  </div>
                  <?php } ?>
                  <?php if($branch_manager != '') { ?>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Branch Manager</label>
                   <select name = "branch_manager" branch_manager = '<?=$branch_manager?>' regional_manager = '<?=$regional_manager?>' line_manager = '<?=$line_manager?>' class="form-control manager" id = 'branch_m'>
                       <option value = '<?=$branch_manager?>'><?=$branch_manager?></option>
                       <option value = 'Approved'>Approve</option>
                       <option value = 'Decline'>Decline</option>
                       <option value = 'Pending'>Pending</option>
                    </select>
                  </div>
                  <?php } ?> 
                  <?php if($regional_manager != '') { ?>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Regional Manager</label>
                    <select name = "regional_manager" line_manager = '<?=$line_manager?>' branch_manager = '<?=$branch_manager?>' regional_manager = '<?=$regional_manager?>' class="form-control manager" id = 'regional'>
                       <option value = '<?=$regional_manager?>'><?=$regional_manager?></option>
                       <option value = 'Approved'>Approve</option>
                       <option value = 'Decline'>Decline</option>
                       <option value = 'Pending'>Pending</option>
                    </select>
                  </div>
                  <?php } ?>
                  <div class="form-group" style = "display:none;">
                    <label for="exampleInputPassword1">Id</label>
                    <input type="text" name = "leave_id" value = "<?=$leaves[0]['id']?>" class="form-control" placeholder="">
                  </div>
                  <div class="form-group" style = "display:none;">
                    <label for="exampleInputPassword1">Stage</label>
                    <input type="text" id = 'stage' name = "stage" class="form-control" placeholder="">
                  </div>
                  <div class="form-group" style = "display:none;">
                    <label for="exampleInputPassword1">flow</label>
                    <input type="text" id = 'flow' name = "flow" class="form-control" placeholder="">
                  </div>
                  <input type="submit" id = 'submit_details' name = "update_flow" class="btn btn-primary hide"/>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel2">Profer Reliever</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form method = 'POST' action = 'process_ro.php'>
            <div class="form-group" style='margin-top:20px;'>
                <label for="exampleFormControlSelect1">Select Location</label>
                <select id = 'location' ro='<?=json_encode($ro)?>' name = 'locationid' class="form-control">
                <option value = ''></option>
                  <?php for($r = 0; $r < count($ro); $r++) {?>
                    <option value = '<?=isset($ro[$r]['id']) ? $ro[$r]['id'] : ''?>'><?=isset($ro[$r]['location']) ? $ro[$r]['location'] : ''?></option>
                  <?php  } ?>
                </select>
                
          </div>
          <div class="form-group" style='margin-top:20px;display:none;'>
                <label for="exampleFormControlSelect1">Name</label>
                <input type = "text" id = 'ro_location' name = "location" class = 'form-control' placeholder = 'ro location'/>
                
          </div>
          <div class="form-group" style='margin-top:20px;'>
                <label for="exampleFormControlSelect1">Name</label>
                <input type = "text" id = 'ro_name' name = "ro_name" class = 'form-control' placeholder = 'ro name'/>
                
          </div>
          <div class="form-group" style='margin-top:20px;'>
                <label for="exampleFormControlSelect1">Email</label>
                <input type = "text" id = 'ro_email_' name = "ro_email_" class = 'form-control' placeholder = 'ro email'/>
                
          </div>
          <button type = 'submit' id = 'profer' class = 'btn btn-primary' name = 'submit'>Submit</button>
         </form>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form method = "POST" action="view_leave_flow.php">
              <div class="form-group" style = 'display:none;'>
                <label for="exampleInputEmail1">Start Date</label>
                <input type="text" name = 'leave_id' class="form-control" id="" aria-describedby="emailHelp" value='<?=$leaves[0]['id']?>'>
                
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Start Date</label>
                <input type="date" name = 'start_date' class="form-control" id="" aria-describedby="emailHelp" required = "true" value='<?=$leaves[0]['start_date']?>'>
                
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">End Date</label>
                <input type="date" name ='end_date' class="form-control" id="date_end" required = "true" value = '<?=$leaves[0]['end_date']?>'>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Resumption Date</label>
                <input type="text" class="form-control" id="resumptionDate" disabled value = ''>
              </div>
              <button name = 'edit' type="submit" class="btn btn-primary">Submit</button>
            </form>
      </div>
      
    </div>
  </div>
</div>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
        <script>
           $(function(){
            let approval = '';
            let status = '';
              $(".manager").on("change", function(e){
                  approval = '';
                  let is_exist_line = $('#line').attr('line_manager');
                  let is_exist_branch = $('#branch_m').attr('branch_manager');
                  let is_exist_regional = $('#regional').attr('regional_manager');
                  //alert(is_exist_regional);
                  
                  if(is_exist_line != '' && is_exist_line != undefined){
                    if(approval !=  "") approval += ";";
                    approval += 'Line Manager:'+$('#line').val();
                    if($('#branch_m').val() == 'Approved') $('#stage').val('Approved');
                    else if($('#regional').val() == 'Approved') $('#stage').val('Approved');
                    else $('#stage').val('');
                  }
                  if(is_exist_branch != '' && is_exist_branch != undefined){
                    if(approval !=  "") approval += ";";
                    approval += 'Branch Manager:'+ $('#branch_m').val();
                    //alert($('#branch_m').val());
                    if($('#branch_m').val() == 'Approved') $('#stage').val('Approved');
                    else $('#stage').val('');
                    
                  }
                  if(is_exist_regional != undefined && is_exist_regional != ''){
                   if(approval !=  "") approval += ";";
                    approval += 'Regional Manager:'+ $('#regional').val();
                    if($('#regional').val() == 'Approved') $('#stage').val('Approved');
                    else $('#stage').val('');
                  }
                  $('#flow').val(approval);
                  //alert(approval);
                  $('#submit_details').removeClass('hide');
              });
           });
        </script>
        <script>
          $(function(e){
            $("#cancel_leave").on('click', function(e){
              let leave_id = $(this).attr('leave_id');
               Swal.fire({
              title: 'Are you sure?',
              text: "Do you want to cancel this request",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Cancel it!'
            }).then((result) => {
              if (result.value) {
                
                 //window.location.href = "/outsourcing/cancel_leave/?leave_id="+btoa(leave_id);
              }
            });
            })
             
          
          });
           
        </script>
        <script>
    
        function resumptionDate(end_date) {
        let counter = 0;
        let resumptionDate = '';
        var end_date = new Date(end_date);
        end_date.setDate(end_date.getDate()+1);
        console.log(end_date);
          while(counter == 0) {
            if(end_date.getDay()<6 && end_date.getDay() > 0) {
              console.log(end_date.getDay());
                counter++;
                console.log(counter);
            }
            
            if(counter == 0) end_date.setDate(end_date.getDate()+1);
          }
          $("#resumptionDate").val(end_date.toString().slice(0, 15));
          // return counter;
       }
       $('#date_end').on('change', function(e){
           //alert('as');
           let enddate = $('#date_end').val();
           e.preventDefault();
           resumptionDate(enddate);
       })
    </script>
    <script>
       $('#location').on('change', function(e){
           let ro = $(this).attr('ro');
           ro = JSON.parse(ro);
           for(let e = 0; e < ro.length; e++){
             if(ro[e]['id'] == $('#location').val()){
                $('#ro_location').val(ro[e]['location']);
                $('#ro_name').val(ro[e]['name']);
                $('#ro_email_').val(ro[e]['email']);
             }
           }
       });
    </script>
        
        
