<?php 
include 'connection.php';
session_start();
$data_item = [];
$items = [];
//print_r($_SESSION['user']);
  if($_SESSION['user']['category'] == 'admin')
    $query = "SELECT * FROM items WHERE id = '".$_SESSION['user']['id']."'";
  else if($_SESSION['user']['category'] == 'staff')
    $query = "SELECT * FROM items WHERE admin_id = '".$_SESSION['user']['admin_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
      }
  }
  //print_r($items);
  $q = "SELECT * FROM requesteditem WHERE staff_id = '".$_SESSION['user']['id']."' AND date_created = '".date('Y-m-d')."' ORDER BY id DESC";
   $res = mysqli_query($conn, $q);
   if(mysqli_num_rows($res) > 0){
   while($r = mysqli_fetch_assoc($res)) {
     $data_item[] = $r;
     }
     //print_r($data);
   }
  //print_r($data);
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
            <?php if(isset($_SESSION['user']) && $_SESSION['user']['requisition_flow'] == '') {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            You can not process requisition, because you don't have approvals. Kindly add requisition approval on the setting page
                        </div>
                  <?php } ?>        
            <?php if(count($data_item) > 0) {?>      
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>New Request</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   
                    <div class="table-responsive">
                      
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N </th>
                            <th class="column-title">Item Name </th>
                            <th class="column-title">Justification </th>
                            <th class="column-title">Quantity </th>
                            <th class="column-title">Cost </th>
                            <th class="column-title">Status</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php if(count($data_item) > 0) {?>
                          <?php for ($h = 0; $h < count($data_item); $h++) {?>
                            
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$data_item[$h]['item']?></td>
                            <td class=" "><?=$data_item[$h]['justification']?></td>
                            <td class=" "><?=$data_item[$h]['quantity']?></td>
                            <td class=" "><?=$data_item[$h]['cost']?></td>
                            <td class="" style="text-transform: capitalize;"><?=$data_item[$h]['status']?></i></td>
                            </td>
                          </tr>
                          <?php } } ?>
                        </tbody>
                      </table>
                    </div>
            
                  </div>
                </div>
              </div>    
            <?php } ?>  
            <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Item<small>request new items</small></h2>
                      
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form action="process_requesteditem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
  
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Item Name <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <select class="form-control col-md-7 col-xs-12" name="item_name">
                                <option value=""></option>
                                <?php for ($g = 0; $g < count($items); $g++) {?>
                                 <option value="<?=$items[$g]['item_name']?>"><?=$items[$g]['item_name']?></option>
                                <?php } ?>
                              </select>
                          </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Justification<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="justification" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Quantity<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="item_quantity" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cost<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="item_cost" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                        </div>
                        <?php if(isset($_SESSION['user']) && $_SESSION['user']['requisition_flow'] != '') {?>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                          </div>
                        </div>
                        <?php  } ?>
                      </form>
                    </div>
                  </div>
                </div>
        </div>
</div>
</div>
<?php include "footer.php"?>
        
