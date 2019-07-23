<?php 
include 'connection.php';
session_start();
$kss = [];
$admin_id;
$users = [];
$show_month = "";
$show_year = "";
$ID = "";
$audited = 'false';
$audit_begin = 'false';
 if(!isset($_SESSION['user']['id'])) header("Location: login.php");
 if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
 else if ($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT kss.information,users.name,users.employee_ID FROM kss INNER JOIN users ON kss.staff_id = users.id WHERE kss.admin_id = '".$admin_id."'ORDER BY kss.id LIMIT 1";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $kss[] = $row;
      }
  }
  //print_r($_SESSION['user']);
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
                <h3>CASH REQUEST</h3>
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
               <?php if(isset($_SESSION['msg']) && $_SESSION['user']['category'] = 'staff') {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>   
              <?php if(isset($_SESSION['user']) && $_SESSION['user']['cash_flow'] == '') {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            You can not request for cash, because you don't have approvals. Kindly add cash approvals on the setting page
                        </div>
              <?php } ?>              
              <div class="col-md-8 col-sm-12 col-xs-12">
                 <div class="x_panel">
                    <div class="x_title">
                      <h2>Cash Request<small></small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form action="process_cash_request.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
  
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Purpose <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="text" name="purpose" class="form-control col-md-7 col-xs-12" required="required" type="text">
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Amount<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="number" name="amount" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                        </div>
                        <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Upload document
                                      </label>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                          <input type="file" name ="attach_document" class="custom-file-input" id="">
                                      </div>                                
                              </div>
                        <div class="ln_solid"></div>
                        <?php if(isset($_SESSION['user']) && $_SESSION['user']['cash_flow'] != '') {?>
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
              <div class="col-md-4 col-sm-12 col-xs-12">
                  <div class="x_panel">
                  <div class="x_title">
                    <h2>KSS shared by (<span style="font-size: 13px;"><?=isset($kss[0]['name']) ? $kss[0]['name'] :''?></span>)</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php if(count($kss) > 0) {?>
                    <p style="text-align: justify;"><?=$kss[0]['information']?></p>
                    <?php } else { ?>
                      <p style="text-align: justify;">No Information shared</p>
                    <?php } ?> 
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
        
