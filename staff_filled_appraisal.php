<?php 
include 'connection.php';
session_start();
$data = [];
if(!isset($_SESSION['appraisal_id']) && $_SESSION['appraisal_id'] == '') header("Location: appraisals.php");
   $query = "SELECT users.name, appraisal.period, appraisal.year, appraisal.id, appraisal_replies.staff_id FROM appraisal_replies INNER JOIN appraisal ON appraisal_replies.appraisal_id = appraisal.id AND appraisal.admin_id = appraisal_replies.admin_id INNER JOIN users ON users.id = appraisal_replies.staff_id";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
  }
  /*$query_all_appraisal = "SELECT * FROM appraisal WHERE admin_id = '".$_SESSION['user']['admin_id']."'";
  $get_result = mysqli_query($conn, $query_all_appraisal);
  if(mysqli_num_rows($get_result)> 0){
      while($row = mysqli_fetch_assoc($get_result)) {
        $created_appraisal[] = $row;
        if($row['document'] != ''){ $doc[] = $row['document'];}
        else if($row['appraisal_data'] != ''){ $app_data[] = $row['appraisal_data'];}
        $app_id = $row['id'];
      }
  }
  for ($f = 0; $f < count($appraisal); $f++){
    if(in_array(, haystack))
  } */
  //$comment_flow = explode(";", $appraisal);
  //$appraisal_data = explode(";", $appraisal[])
//print_r($appraisal));
?>
<?php include "header.php"?>
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Monitor Appraisal</h3>
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
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Appraisals</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N </th>
                            <th class="column-title text-center">Name </th>
                            <th class="column-title text-center">Appraisal Period </th>
                            <th class="column-title text-center">Year </th>
                            <th class="column-title text-center">More </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($data); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class="text-center"><?=$data[$h]['name']?></td>
                            <td class="text-center"><?=$data[$h]['period']?></td>
                            <td class="text-center"><?=$data[$h]['year']?></td>
                            <th class="column-title text-center"><a href="get_this_appraisal.php/?appraisal_id=<?=base64_encode($data[$h]['id'])?>&staff_id=<?=base64_encode($data[$h]['staff_id'])?>" class="btn btn-sm btn-success">Details</a> </th>
                          </tr>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>  
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Rating Summary<small></small></h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>Excellence </td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>Very Good </td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>Good </td>
                        </tr>
                        <tr>
                          <th scope="row">4</th>
                          <td>Average </td>
                        </tr>
                        <tr>
                          <th scope="row">5</th>
                          <td>Bad </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Approvals<small></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-striped">
                      <tbody>
                        <?php if ($_SESSION['user']['appraisal_flow'] != "") {?>
                        <?php $appraisal_flow = explode(";",$_SESSION['user']['appraisal_flow']) ?>
                        <?php for ($r = 0; $r < count($appraisal_flow); $r++) {?>
                        <tr>
                          <th scope="row"><?=explode(":", $appraisal_flow[$r])[0]?></th>
                          <td><?=explode(":", $appraisal_flow[$r])[1]?></td>
                        </tr>
                       <?php } }?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12">
                
              </div>
            </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
<?php include "footer.php"?>
<script type="text/javascript" src="js/appraisal.js"></script>
        
