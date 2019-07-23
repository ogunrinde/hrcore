<?php 
include 'connection.php';
session_start();
$data_cash = [];
if(!isset($_SESSION['user']['id'])) header("Location: login.php");
if($_SESSION['user']['category'] == 'admin'){
$query = "SELECT users.name, users.department,cash_request.staff_id,cash_request.admin_id,cash_request.purpose,cash_request.justification, cash_request.date_created, cash_request.amount,cash_request.id FROM cash_request INNER JOIN users ON users.id = cash_request.staff_id WHERE cash_request.admin_id = '".$_SESSION['user']['id']."' ORDER BY cash_request.id DESC";
 }else{
  $query = "SELECT users.name, users.department,cash_request.staff_id,cash_request.admin_id,cash_request.purpose,cash_request.justification, cash_request.date_created, cash_request.amount,cash_request.id FROM cash_request INNER JOIN users ON users.id = cash_request.staff_id WHERE cash_request.admin_id = '".$_SESSION['user']['admin_id']."' ORDER BY cash_request.id DESC";
 }
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data_cash[] = $row;
      }
  }
   //print_r($data_cash);
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
            <h3>Requested Cash</h3>
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
            <?php if(count($data_cash) > 0) {?>      
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Requested Cash</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                  
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N </th>
                            <th class="column-title">Name </th>
                            <th class="column-title">Department </th>
                            <th class="column-title">Purpose </th>
                            <th class="column-title">Amount </th>
                            <th class="column-title">Request Date </th>
                            <th class="column-title">More </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($data_cash); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$data_cash[$h]['name']?></td>
                            <td class=" "><?=$data_cash[$h]['department']?></td>
                            <td class=" "><?=$data_cash[$h]['purpose']?></td>
                            <td class=" "><?=$data_cash[$h]['amount']?></td>
                            <td class=" "><?=$data_cash[$h]['date_created']?></td>
                            <th class="column-title"><a href="process_request_cash_details.php/?cash_id=<?=base64_encode($data_cash[$h]['id'])?>&staff_id=<?=base64_encode($data_cash[$h]['staff_id'])?>" class="btn btn-sm btn-success">Details</a> </th>
                          </tr>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php if(count($data_cash) == 0 ){ ?>
                       No request made
                    <?php } ?>
                  </div>
                </div>
            </div> 
            <?php } ?> 
            <?php if(count($data_cash) == 0) { ?>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Requested Cash</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <?php if(count($data_cash) == 0 ){ ?>
                       No request made
                    <?php } ?>
                  </div>
                </div>
            </div> 
            <?php } ?>    
        </div>
</div>
</div>
<?php include "footer.php"?>
        
