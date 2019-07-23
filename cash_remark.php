<?php 
include 'connection.php';
session_start();
$cash = [];
$user = [];
$company = [];
$cash_flow = [];
$full_cash_flow;
$approvals = 0;
$num_of_approved = 0;
//echo $_SESSION['requestitem_id'];
if(!isset($_SESSION['cash_id']) && $_SESSION['cash_id'] != '') header("Location: cash_request.php");

  $query = "SELECT * FROM cash_request WHERE id = '".$_SESSION['cash_id']."' ORDER BY id DESC";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $cash[] = $row;
      }
  }
  $sql = "SELECT * FROM users WHERE id = '".$_SESSION['staff_id']."'";
  $res = mysqli_query($conn, $sql);
      if(mysqli_num_rows($res)> 0){
          while($row = mysqli_fetch_assoc($res)) {
            $user[] = $row;
          }
          $full_cash_flow = $user[0]['cash_flow'];
          
  }
  if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  else $admin_id = $_SESSION['user']['admin_id'];
  $Req_sql = "SELECT * FROM company WHERE admin_id = '".$admin_id."'";
      $res = mysqli_query($conn, $Req_sql);
      if(mysqli_num_rows($res)> 0){
          while($row = mysqli_fetch_assoc($res)) {
            $company[] = $row;
          }
          $cash_flow = explode(";",$company[0]['cash_flow']);
      }
   if($cash[0]['flow'] != ''){
    $flow = explode(";",$cash[0]['flow']);
    for($r = 0; $r < count($flow); $r++){
      $approvals++;
      if($flow[$r] != ""){
        $eachflow = explode(":",$flow[$r]);
        if(count($eachflow) > 1){
          //echo $eachflow[1]."<br>";
          if($eachflow[1] == 'approved') $num_of_approved++;
        }
      }
    }
  }    
  //print_r($items);
?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Cash Request</h3>
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
              <?php for($e = 0; $e < count($cash_flow); $e++) {?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?=$cash_flow[$e]?></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <div style="width: 100%;margin-left: auto;margin-right: auto;">
                     <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">Approve
                         <span class="badge badge-pill badge_cash" full_cash_flow = "<?=$user[0]['cash_flow']?>" email = "<?=$_SESSION['user']['email']?>" cash_flow = "<?=$cash_flow[$e]?>"" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$cash[0]['flow']?>" attr_id = "<?=$e?>" id= "approve<?=$e?>" status = "approved" cash_id = "<?=$cash[0]['id']?>" approval = "<?=$cash_flow[$e]?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                            <?php $flow = explode(";", $cash[0]['flow']) ?>

                            <?php for ($t = 0; $t < count($flow); $t++) {?>
                               <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                               <?php if($each_flow == $cash_flow[$e] && explode(":", $flow[$t])[1] == 'approved') {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df;font-size: 12px;"></i>
                               <?php } ?> 
                            <?php } ?>  
                            
                         </span>
                       </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Decline 
                        <span class="badge badge-pill badge_cash" full_cash_flow = "<?=$user[0]['cash_flow']?>" email = "<?=$_SESSION['user']['email']?>" cash_flow = "<?=$cash_flow[$e]?>"" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$cash[0]['flow']?>" attr_id = "<?=$e?>" id= "decline<?=$e?>" status = "decline" cash_id = "<?=$cash[0]['id']?>" approval = "<?=$cash_flow[$e]?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                          <?php $flow = explode(";", $cash[0]['flow']) ?>
                            <?php for ($t = 0; $t < count($flow); $t++) {?>
                               <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                               <?php if($each_flow == $cash_flow[$e] && explode(":", $flow[$t])[1] == 'decline') {?>
                                  <i class="fas fa-check" style="padding: 0px;color: #4e73df; font-size: 12px;"></i>
                               <?php } ?> 
                            <?php } ?> 
                         </span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Pending 
                        <span class="badge badge-pill badge_cash" full_cash_flow = "<?=$user[0]['cash_flow']?>" email = "<?=$_SESSION['user']['email']?>" cash_flow = "<?=$cash_flow[$e]?>"" category = "<?=$_SESSION['user']['category']?>" flow = "<?=$cash[0]['flow']?>" attr_id = "<?=$e?>" id= "pend<?=$e?>" status = "pend" cash_id = "<?=$cash[0]['id']?>" approval = "<?=$cash_flow[$e]?>" style="font-size: 15px;background-color: #fff;color:#73879C;width: 25px;height: 25px;border-radius: 14px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;">
                          <?php $flow = explode(";", $cash[0]['flow']) ?>
                            <?php for ($t = 0; $t < count($flow); $t++) {?>
                               <?php $each_flow = explode(":", $flow[$t])[0]; ?>
                               <?php if($each_flow == $cash_flow[$e] && explode(":", $flow[$t])[1] == 'pend') {?>
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
            </div>
            <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Request</h2>
                     <ul class="nav navbar-right panel_toolbox">
                      <?php if(count($cash) > 0) {?>
                      <?php if($cash[0]['document'] != '') {?>  
                      <li><a href ="downloadfile.php/?to=view&filename=<?=$cash[0]['document']?>" id=""
                                name='' value=""
                                class="btn btn-success" style = "color: #fff;">Download</a>
                      </li>
                      <?php } }?>
                      <?php if($num_of_approved == $approvals) {?>
                      <li>
                        <a style="color: #fff;" href = "process_print_cash_doc.php/?cash_id=<?=base64_encode($_SESSION['cash_id'])?>&filename=<?=base64_encode('cash_request_'.time())?>"
                            class="btn btn-info">Print</a>
                      </li>
                    <?php } ?>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <div style="width: 100%;margin-left: auto;margin-right: auto;">
                     <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">Request By
                       
                         <span class="badge badge-pill" style="font-size: 15px;font-weight: 300; background-color: #fff;color:#73879C"><?=$user[0]['name']?></span>
                       </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Employee ID: 
                        <span class="badge badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$user[0]['employee_ID']?></span>
                      </li>
                      <?php for ($y = 0; $y < count($cash); $y++) {?>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Purpose <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$cash[$y]['purpose']?></span></li>
                      <li class="list-group-item">Justification : <?=$cash[$y]['justification']?></li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Amount 
                        <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$cash[$y]['amount']?></span>
                      </li>
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                        Request Date 
                        <span class="badge badge-primary badge-pill" style="font-size: 15px;font-weight: 300;background-color: #fff;color:#73879C"><?=$cash[$y]['date_created']?></span>
                      </li>
                      <?php } ?>
                    </ul>
                  </div>
                  </div>
                </div>
            </div>
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                    <button type="submit" id = 'submit_btn_cash' class="btn btn-success">Update</button>
              </div>   
        </div>
</div>
</div>
<?php include "footer.php"?>
<script type="text/javascript" src="js/cash_request.js"></script>
        
