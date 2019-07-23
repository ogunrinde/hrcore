<?php 
include 'connection.php';
session_start();
$items = [];
$user = [];
$company = [];
$requisition_flow = [];
if(!isset($_SESSION['item_id']) && $_SESSION['item_id'] != '') header("Location: requesteditems.php");

  $query = "SELECT * FROM requesteditem WHERE id = '".$_SESSION['item_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
      }
  }
  if($_SESSION['user']['category'] == 'admin'){
      $sql = "SELECT * FROM users WHERE id = '".$items[0]['staff_id']."'";
      $res = mysqli_query($conn, $sql);
      if(mysqli_num_rows($res)> 0){
          while($row = mysqli_fetch_assoc($res)) {
            $user[] = $row;
          }
      }
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
  //print_r($user);
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
              <div class="col-md-7 col-sm-12 col-xs-12">
              <?php for($e = 0; $e < count($requisition_flow); $e++) {?>
              
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?=$requisition_flow[$e]?></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <div style="width: 100%;margin-left: auto;margin-right: auto;">
                     <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">Approve
                       
                         <span class="badge badge-pill badge_request" requisition_flow = "<?=$requisition_flow[$e]?>"" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$items[0]['flow']?>" attr_id = "<?=$e?>" id= "approve<?=$e?>" status = "approved" item_id = "<?=$items[0]['id']?>" approval = "<?=$requisition_flow[$e]?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
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
                        <span class="badge badge-pill badge_request" requisition_flow = "<?=$requisition_flow[$e]?>"" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$items[0]['flow']?>" attr_id = "<?=$e?>" id= "decline<?=$e?>" status = "Decline" item_id = "<?=$items[0]['id']?>" approval = "<?=$requisition_flow[$e]?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
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
                        <span class="badge badge-pill badge_request" requisition_flow = "<?=$requisition_flow[$e]?>"" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$items[0]['flow']?>" attr_id = "<?=$e?>" id= "pend<?=$e?>" status = "pend" item_id = "<?=$items[0]['id']?>" approval = "<?=$requisition_flow[$e]?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
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
                
              <?php } ?> 
              <div class="x_panel">
                  <div class="x_title">
                    <h2>Other Information</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <div style="width: 100%;margin-left: auto;margin-right: auto;">
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
              <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>New Request</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <?php if(count($items) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <!--thead>
                          <tr class="headings">
                            <th class="column-title text-center">S/N</th>
                            <th class="column-title text-center">Name</th>
                            <th class="column-title text-center">Employee ID </th>
                            <th class="column-title text-center">Branch</th>
                            <th class="column-title text-center">Department</th>
                          </tr>
                        </thead-->

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
                           <td style="width: 60%">Item Name</td>
                           <td style="width: 40%"><?=$items[0]['item']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Justification</td>
                           <td style="width: 40%"><?=$items[0]['justification']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Quantity</td>
                           <td style="width: 40%"><?=$items[0]['quantity']?></td>
                         </tr>
                          <tr>
                           <td style="width: 60%">Request Date</td>
                           <td style="width: 40%"><?=$items[0]['date_created']?></td>
                         </tr>
                      </table>
                    </div>
                    <?php } ?>
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
        
