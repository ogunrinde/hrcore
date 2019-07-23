<?php 
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include 'connection.php';
session_start();
$items = [];
$user = [];
$company = [];
$requisition_flow = [];
$full_requisition_flow;
$manager = [];
//echo $_SESSION['requestitem_id'];

if(!isset($_SESSION['leave_id'])) header("Location: requesteditems.php");

  $query = "SELECT * FROM leaves WHERE id = '".$_SESSION['leave_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $leave[] = $row;
      }
  }
  $sql = "SELECT * FROM users WHERE id = '".$_SESSION['staff_id']."'";
  $res = mysqli_query($conn, $sql);
      if(mysqli_num_rows($res)> 0){
          while($row = mysqli_fetch_assoc($res)) {
            $user[] = $row;
          }
          $full_leave_flow = $user[0]['leave_flow'];
          $manager = explode(";",$user[0]['leave_flow']);
          
  }
  $Req_sql = "SELECT * FROM company WHERE admin_id = '".$_SESSION['user']['admin_id']."'";
      $res = mysqli_query($conn, $Req_sql);
      if(mysqli_num_rows($res)> 0){
          while($row = mysqli_fetch_assoc($res)) {
            $company[] = $row;
          }
          $leave_flow = explode(";",$company[0]['leave_flow']);
      }
  //print_r($items);
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
            <h3>Approve Leave</h3>
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
            <div class="col-md-8 col-sm-12 col-xs-12">
               
              <?php for($e = 0; $e < count($manager); $e++) {?>
               <?php if(explode(":",$manager[$e])[0] != 'Regional Manager') {?>
               <?php $each_manager = explode(":", $manager[$e])[0]; ?> 
               <?php $email = explode(":", $manager[$e])[1]; ?> 
               <?php if(strtolower(trim($email)) == strtolower(trim($_SESSION['user']['email']))) {?>
               <?php $link = 'badge_leave';?>   
               <?php $disabled = '';?>      
               <?php }else {?>
               <?php $link = '';?>   
               <?php $disabled = 'disabled';?> 
               <?php } ?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2 style="text-transform: capitalize;"><?=$each_manager?></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <div style="width: 100%;margin-left: auto;margin-right: auto;">
                     <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">Approve
                         <span class="badge badge-pill <?=$link?>" full_leave_flow = "<?=$user[0]['leave_flow']?>" email = "<?=strtolower(trim($_SESSION['user']['email']))?>" leave_flow = "<?=$each_manager?>" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$leave[0]['flow']?>" attr_id = "<?=$e?>" id= "approve<?=$e?>" status = "approved" leave_id = "<?=$leave[0]['id']?>" approval = "<?=$each_manager?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                            <?php $flow = explode(";", $leave[0]['flow']) ?>

                            <?php for ($t = 0; $t < count($flow); $t++) {?>
                               <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                               
                               <?php if($each_manager == $each_flow && (explode(":", $flow[$t])[1] == 'approved' || explode(":", $flow[$t])[1] == 'Approved')) {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df;font-size: 12px;"></i>
                               <?php } ?> 
                            <?php } ?>  
                            
                         </span>
                       </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Decline 
                        <span class="badge badge-pill <?=$link?>" full_leave_flow = "<?=$user[0]['leave_flow']?>" email = "<?=strtolower(trim($_SESSION['user']['email']))?>" leave_flow = "<?=$each_manager?>" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$leave[0]['flow']?>" attr_id = "<?=$e?>" id= "decline<?=$e?>" status = "decline" leave_id = "<?=$leave[0]['id']?>" approval = "<?=$each_manager?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                          <?php $flow = explode(";", $leave[0]['flow']) ?>
                            <?php for ($t = 0; $t < count($flow); $t++) {?>
                               <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                               <?php if($each_manager == $each_flow && (explode(":", $flow[$t])[1] == 'decline' || explode(":", $flow[$t])[1] == 'Decline')) {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df; font-size: 12px;"></i>
                               <?php } ?> 
                            <?php } ?> 
                         </span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Pending 
                        <span class="badge badge-pill <?=$link?>" full_leave_flow = "<?=$user[0]['leave_flow']?>" email = "<?=strtolower(trim($_SESSION['user']['email']))?>" leave_flow = "<?=$each_manager?>" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$leave[0]['flow']?>" attr_id = "<?=$e?>" id= "pend<?=$e?>" status = "pend" leave_id = "<?=$leave[0]['id']?>" approval = "<?=$each_manager?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                          <?php $flow = explode(";", $leave[0]['flow']) ?>
                            <?php for ($t = 0; $t < count($flow); $t++) {?>
                               <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                               <?php if($each_manager == $each_flow && explode(":", $flow[$t])[1] == 'pend') {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df;font-size: 12px;"></i>
                               <?php } ?> 
                            <?php } ?> 
                         </span>
                      </li>
                    </ul>
                  </div>
                  <div style="width: 100%;margin-left: auto;margin-right: auto;">
                      <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-0">
                      <div class="form-group">
                        <label for="exampleInputEmail1"><?=$each_manager?> Remark</label>
                        
                        <?php if($leave[0]['remarks'] != '') { ?>
                           <?php $remarks = explode(";", $leave[0]['remarks']) ?>
                           <?php for ($t = 0; $t < count($remarks); $t++) {?>
                               <?php $each_remark = explode(":", $remarks[$t])[0]; ?>
                               <?php if($each_remark == $each_manager) {?>
                                <?php $curr = explode(":", $remarks[$t])[1]; ?>
                                <?php if (filter_var($curr, FILTER_VALIDATE_EMAIL)) {?>
                                    <?php  $curr = ''?>
                                  
                                <?php }?>
                               <?php } ?>
                              
                            <?php } ?>
                        <?php } ?>
                        
                        <textarea style='width:100%' <?=$disabled?> leave_flow = "<?=$each_manager?>" full_leave_flow = "<?=$user[0]['leave_flow']?>" full_remark_flow = "<?=$user[0]['remarks']?>" email = "<?=$_SESSION['user']['email']?>" class='remark' value = '' id= 'remark<?=$e?>' data = '<?=$each_manager?>'  class = "form-control"><?=$curr?></textarea>
                      </div>
                  </div>
                  </div>
                  
                  <?php if($_SESSION['user']['category'] != 'admin' && strtolower(trim($_SESSION['user']['email'])) == strtolower(trim($email))) {?>
                      <div class="col-md-8 col-sm-6 col-xs-12 col-md-offset-0"> 
                            <button type="submit" id = '' class="btn btn-success submit_btn_leave"><?=$each_manager?> Update</button>
                      </div> 
                      <?php }?>  
                  </div>
                </div>
                
              <?php } }?>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                 <div class="x_panel">
                  <div class="x_title">
                    <h2>Leave Request</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                             <td scope="row">Request By</td>
                             <td><?=$user[0]['name']?></td>
                        </tr>
                        <tr>
                             <td scope="row">Employee ID</td>
                             <td><?=$user[0]['employee_ID']?></td>
                        </tr>
                        <?php for ($y = 0; $y < count($leave); $y++) {?>
                        <tr>
                             <td scope="row">Leave Type</td>
                             <td><?=$leave[$y]['leave_type']?></td>
                        </tr>
                        <tr>
                             <td scope="row">Start Date</td>
                             <td><?=$leave[$y]['start_date']?></td>
                        </tr>
                        <tr>
                             <td scope="row">End Date</td>
                             <td><?=$leave[$y]['end_date']?></td>
                        </tr>
                        <tr>
                             <td scope="row">Required Reliever</td>
                             <td><?=$leave[$y]['require_reliever']?></td>
                        </tr>
                        <tr>
                             <td scope="row">Reliever Source</td>
                             <td><?=$leave[$y]['reliever_source']?></td>
                        </tr>
                        <tr>
                             <td scope="row">Reliever Name</td>
                             <td><?=$leave[$y]['reliever_name']?></td>
                        </tr>
                        <tr>
                             <td scope="row">Reliever Email</td>
                             <td><?=$leave[$y]['reliever_email']?></td>
                        </tr>
                        <tr>
                             <td scope="row">Reliever Phone</td>
                             <td><?=$leave[$y]['reliever_phone']?></td>
                        </tr>
                        <tr>
                             <td scope="row">Request Date</td>
                             <td><?=$leave[$y]['date_created']?></td>
                        </tr>
                        
                        <?php } ?>
                      </tbody>
                    </table> 
                   <!--div style="width: 100%;margin-left: auto;margin-right: auto;">
                     <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">Request By
                       
                         <span class="badge badge-pill" style="font-size: 15px;font-weight: 300; background-color: #fff;color:#73879C"><?=$user[0]['name']?></span>
                       </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Employee ID 
                        <span class="badge badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$user[0]['employee_ID']?></span>
                      </li>
                      <?php for ($y = 0; $y < count($leave); $y++) {?>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Leave Type <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$leave[$y]['leave_type']?></span></li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Start Date <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$leave[$y]['start_date']?></span></li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">End Date 
                        <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$leave[$y]['end_date']?></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Required Reliever 
                        <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$leave[$y]['require_reliever']?></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Reliever Source 
                        <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$leave[$y]['reliever_source']?></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Reliever Name 
                        <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$leave[$y]['reliever_name']?></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Reliever Email 
                        <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$leave[$y]['reliever_email']?></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Reliever Phone 
                        <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$leave[$y]['reliever_phone']?></span>
                      </li>
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                        Request Date 
                        <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$leave[$y]['date_created']?></span>
                      </li>
                      <?php } ?>
                    </ul>
                  </div-->
                  </div>
                </div>
            </div>
              <?php if($_SESSION['user']['category'] != 'admin') {?>
              <!--div class="col-md-8 col-sm-6 col-xs-12 col-md-offset-2"> 
                    <button type="submit" id = 'submit_btn_leave' class="btn btn-success">Update</button>
              </div--> 
              <?php }?>  
        </div>
</div>
</div>

<?php include "footer.php"?>

        
