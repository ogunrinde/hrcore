<?php 
include 'connection.php';
session_start();
$data_item = [];
  if($_SESSION['user']['category'] == 'admin'){
    $query = "SELECT * FROM items WHERE admin_id = '".$_SESSION['user']['id']."'";
  }else {
    $query = "SELECT * FROM items WHERE admin_id = '".$_SESSION['user']['admin_id']."'";
  }
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data_item[] = $row;
      }
  }
  //print_r($data);
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
            <h3>Inventories</h3>
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
                    <h2>Inventories</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N </th>
                            <th class="column-title">Item Name </th>
                            <th class="column-title">Item Catgeory </th>
                            <th class="column-title">Quantity </th>
                            <th class="column-title">Cost </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($data_item); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$data_item[$h]['item_name']?></td>
                            <td class=" "><?=$data_item[$h]['item_category']?></td>
                            <td class=" "><?=$data_item[$h]['item_quantity']?></td>
                            <td class=" "><?=$data_item[$h]['item_cost']?></td>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
              
            
                  </div>
                </div>
              </div>      
        </div>
</div>
</div>
<?php include "footer.php"?>
        
