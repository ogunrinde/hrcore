<?php 
include 'connection.php';
session_start();
$items = [];
$user = [];
$company = [];
$requisition_flow = [];
$full_requisition_flow;
//echo $_SESSION['requestitem_id'];
if(!isset($_SESSION['requestitem_id']) && $_SESSION['requestitem_id'] != '') header("Location: requesteditems.php");

  $query = "SELECT * FROM requesteditem WHERE id = '".$_SESSION['requestitem_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
      }
  }
  $sql = "SELECT * FROM users WHERE id = '".$_SESSION['staff_id']."'";
  $res = mysqli_query($conn, $sql);
      if(mysqli_num_rows($res)> 0){
          while($row = mysqli_fetch_assoc($res)) {
            $user[] = $row;
          }
          $full_requisition_flow = $user[0]['requisition_flow'];
          
  }
  if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  else $admin_id = $_SESSION['user']['admin_id'];
  $Req_sql = "SELECT * FROM company WHERE admin_id = '".$admin_id."'";
      $res = mysqli_query($conn, $Req_sql);
      if(mysqli_num_rows($res)> 0){
          while($row = mysqli_fetch_assoc($res)) {
            $company[] = $row;
          }
          $requisition_flow = explode(";",$company[0]['requisition_flow']);
      }
  //print_r($items);
?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Request Item</h3>
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
                    <h2>Request</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <div style="width: 50%;margin-left: auto;margin-right: auto;">
                     <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">Request By
                       
                         <span class="badge badge-pill" style="font-size: 15px;font-weight: 300; background-color: #fff;color:#73879C"><?=$user[0]['name']?></span>
                       </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Employee ID: 
                        <span class="badge badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$user[0]['employee_ID']?></span>
                      </li>
                      <?php for ($y = 0; $y < count($items); $y++) {?>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Item Name <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$items[$y]['item']?></span></li>
                      <li class="list-group-item">Justification : <?=$items[$y]['justification']?></li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Quantity 
                        <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$items[$y]['quantity']?></span>
                      </li>
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                        Request Date 
                        <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$items[$y]['date_created']?></span>
                      </li>
                      <?php } ?>
                    </ul>
                  </div>
                  </div>
                </div>
            </div>
              <?php for($e = 0; $e < count($requisition_flow); $e++) {?>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?=$requisition_flow[$e]?></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <div style="width: 50%;margin-left: auto;margin-right: auto;">
                     <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">Approve
                         <span class="badge badge-pill badge_request" full_requisition_flow = "<?=$user[0]['requisition_flow']?>" email = "<?=$_SESSION['user']['email']?>" requisition_flow = "<?=$requisition_flow[$e]?>"" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$items[0]['flow']?>" attr_id = "<?=$e?>" id= "approve<?=$e?>" status = "approved" item_id = "<?=$items[0]['id']?>" approval = "<?=$requisition_flow[$e]?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                            <?php $flow = explode(";", $items[0]['flow']) ?>

                            <?php for ($t = 0; $t < count($flow); $t++) {?>
                               <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                               <?php if($each_flow == $requisition_flow[$e] && explode(":", $flow[$t])[1] == 'approved') {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df;font-size: 12px;"></i>
                               <?php } ?> 
                            <?php } ?>  
                            
                         </span>
                       </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Decline 
                        <span class="badge badge-pill badge_request" full_requisition_flow = "<?=$user[0]['requisition_flow']?>" email = "<?=$_SESSION['user']['email']?>" requisition_flow = "<?=$requisition_flow[$e]?>"" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$items[0]['flow']?>" attr_id = "<?=$e?>" id= "decline<?=$e?>" status = "decline" item_id = "<?=$items[0]['id']?>" approval = "<?=$requisition_flow[$e]?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                          <?php $flow = explode(";", $items[0]['flow']) ?>
                            <?php for ($t = 0; $t < count($flow); $t++) {?>
                               <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                               <?php if($each_flow == $requisition_flow[$e] && explode(":", $flow[$t])[1] == 'decline') {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df; font-size: 12px;"></i>
                               <?php } ?> 
                            <?php } ?> 
                         </span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Pending 
                        <span class="badge badge-pill badge_request" full_requisition_flow = "<?=$user[0]['requisition_flow']?>" email = "<?=$_SESSION['user']['email']?>" requisition_flow = "<?=$requisition_flow[$e]?>"" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$items[0]['flow']?>" attr_id = "<?=$e?>" id= "pend<?=$e?>" status = "pend" item_id = "<?=$items[0]['id']?>" approval = "<?=$requisition_flow[$e]?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                          <?php $flow = explode(";", $items[0]['flow']) ?>
                            <?php for ($t = 0; $t < count($flow); $t++) {?>
                               <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                               <?php if($each_flow == $requisition_flow[$e] && explode(":", $flow[$t])[1] == 'pend') {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df;font-size: 12px;"></i>
                               <?php } ?> 
                            <?php } ?> 
                         </span>
                      </li>
                    </ul>
                  </div>
                  </div>
                </div>
              </div>
              <?php } ?> 
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Other Information</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <div style="width: 50%;margin-left: auto;margin-right: auto;">
                     <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">Received
                       
                         <span class="badge badge-pill badge_request" requisition_flow = """ category = "<?=$_SESSION['user']['category']?>" flow = "<?=$items[0]['flow']?>" attr_id = "<?=$e?>" id= "received" status = "received" item_id = "<?=$items[0]['id']?>" approval = "<?=$requisition_flow[$e]?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                               <?php if($items[0]['received'] == 'received') {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df; font-size: 12px;"></i>
                               <?php } ?> 
                            
                         </span>
                       </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Date received 
                        <span class="badge badge-pill badge_request" requisition_flow = "<?=$requisition_flow[$e]?>"" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$items[0]['flow']?>" attr_id = "<?=$e?>" id= "decline<?=$e?>" status = "" item_id = "<?=$items[0]['id']?>" approval = "<?=$requisition_flow[$e]?>" style="font-size: 15px;font-weight: 300; background-color: #fff;color:#73879C">
                            <?=$items[0]['received_date']?>
                         </span>
                      </li>
                       <li class="list-group-item d-flex justify-content-between align-items-center">Returned 
                       
                         <span class="badge badge-pill badge_request" requisition_flow = "" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$items[0]['flow']?>" attr_id = "<?=$e?>" id= "returned" status = "returned" item_id = "<?=$items[0]['id']?>" approval = "<?=$requisition_flow[$e]?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                               <?php if($items[0]['returned'] == 'returned') {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df;font-size: 12px;"></i>
                               <?php } ?> 
                            
                         </span>
                       </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Return date
                        <span class="badge badge-pill badge_request" requisition_flow = "<?=$requisition_flow[$e]?>"" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$items[0]['flow']?>" attr_id = "<?=$e?>" id= "pend<?=$e?>" status = "" item_id = "<?=$items[0]['id']?>" approval = "<?=$requisition_flow[$e]?>" style="font-size: 15px;font-weight: 300; background-color: #fff;color:#73879C">
                           <?=$items[0]['returned_date']?>
                         </span>
                      </li>
                    </ul>
                  </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                    <button type="submit" id = 'submit_btn' class="btn btn-success">Update</button>
              </div>   
        </div>
</div>
</div>
<?php include "footer.php"?>
        
