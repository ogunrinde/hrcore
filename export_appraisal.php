<?php 
include 'connection.php';
session_start();
$deptment = [];
$user_company = [];
$data = [];
 if(!isset($_SESSION['user']['id'])) header("Location: login.php");
 if($_SESSION['user']['category'] == 'staff') header("Location: dashboard.php");
  $query = "SELECT * FROM company WHERE admin_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        if($row['department'] != '') $deptment = explode(";",$row['department']);
      }
  }
  $query = "SELECT * from company WHERE company_name = 'Icsoutsourcing'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
        if($data[0]['user_company'] != ""){
          $user_company = explode(";",$data[0]['user_company']);
        }
      }
  }
  //print_r($data);
?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Appraisals</h3>
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
            <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Export Appraisals<small></small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form action="process_create_appraisal.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
        
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Appraisal Period <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="period" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                              </div>
                              <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Appraisal year <span class="required">*</span>
                                      </label>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                       <select name="year" class="form-control">
                                         <option value=""></option>
                                         <option value="2019">2019</option>
                                         <option value="2020">2020</option>
                                         <option value="2021">2021</option>
                                         <option value="2022">2022</option>
                                         <option value="2023">2023</option>
                                         <option value="2024">2024</option>

                                       </select>
                                      </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="admin_email">Company Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="user_company" class="form-control" id = "user_company">
                                   <option value=""></option>
                                  <?php for($r = 0; $r < count($user_company); $r++){?>
                                    <option value = "<?=isset($user_company[$r]) ? $user_company[$r] : '';?>"> <?=isset($user_company[$r]) ? $user_company[$r] : ''?></option>
                                  <?php } ?>
                                </select>
                                </div>
                              </div>
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <!--button class="btn btn-primary" type="button">Cancel</button>
                                  <button class="btn btn-primary" type="reset">Reset</button-->
                                  <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                </div>
                              </div>
        
                            </form>
                    </div>
                  </div>
                </div>
        </div>
</div>
</div>
<?php include "footer.php"?>
<script type="text/javascript" src="js/appraisal.js"></script>
        
