<?php 
 include "connection.php";
 session_start();
 $data = [];
 $users = [];
 $query = "SELECT * FROM company WHERE admin_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
  }
  $query = "SELECT * FROM users WHERE admin_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="icon" href="asset/img/hr.png" type="image/ico" />

    <title>HR CORE </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">



    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>

  <body class="nav-md">
    <div class="container body" style="background-color: #fff;overflow-x:hidden;">
      <div class="">
        <!-- top navigation -->
        <?php include 'top.php' ?>
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main" style="width:100%;margin-left:5px;">
            <div class="">
                <div class="page-title">
                  <div class="title_left">
                    <h3>Permission</h3>
                  </div>
    
                  <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                      <div class="input-group">
                        <!--input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button">Go!</button>
                        </span-->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                 <?php if(isset($_SESSION['msg'])) {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>
                <div class="row" style="">
                  <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                      <div class="x_panel">
                      <div class="x_title">
                        <h2>ID Request Processing</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                        <form action="process_permission.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Select Department <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <select class="form-control" name ="department">
                                <option value = ""></option>
                               <?php if(count($data) > 0) {?>
                                    <?php $dept = explode(";",$data[0]['department']) ?>
                                    <?php for ($r = 0; $r < count($dept); $r++){ ?>
                                      <?php if($dept[$r] != "") {?>
                                      <option value = "<?=$dept[$r]?>"><?=$dept[$r]?></option>
                                <?php } } }?> 
                                </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Select Staff <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <select class="form-control" name="staff">
                                <option value = ""></option>
                               <?php if(count($data) > 0) {?>
                                    <?php for ($r = 0; $r < count($users); $r++){ ?>
                                      <?php if($dept[$r] != "") {?>
                                      <option value = "<?=$users[$r]['email']?>"><?=$users[$r]['name']?> - <?=$users[$r]['department']?></option>
                                <?php } } }?> 
                                </select>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                            <button type="submit" name="id_request" class="btn btn-success">Submit</button>
                          </div>
                        </form>
                      </div>
                      </div>
                      <div class="x_panel">
                      <div class="x_title">
                        <h2>Upload Appraisal</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                        <form action="process_permission.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Select Department <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <select class="form-control" name ="department">
                                <option value = ""></option>
                               <?php if(count($data) > 0) {?>
                                    <?php $dept = explode(";",$data[0]['department']) ?>
                                    <?php for ($r = 0; $r < count($dept); $r++){ ?>
                                      <?php if($dept[$r] != "") {?>
                                      <option value = "<?=$dept[$r]?>"><?=$dept[$r]?></option>
                                <?php } } }?> 
                                </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Select Staff <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <select class="form-control" name="staff">
                                <option value = ""></option>
                               <?php if(count($data) > 0) {?>
                                    <?php for ($r = 0; $r < count($users); $r++){ ?>
                                      <?php if($dept[$r] != "") {?>
                                      <option value = "<?=$users[$r]['email']?>"><?=$users[$r]['name']?> - <?=$users[$r]['department']?></option>
                                <?php } } }?> 
                                </select>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                            <button type="submit" name="upload_appraisal" class="btn btn-success">Submit</button>
                          </div>
                        </form>
                      </div>
                      </div>
                      <div class="x_panel">
                      <div class="x_title">
                        <h2>Payroll</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                        <form action="process_permission.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Select Department <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <select class="form-control" name ="department">
                                <option value = ""></option>
                               <?php if(count($data) > 0) {?>
                                    <?php $dept = explode(";",$data[0]['department']) ?>
                                    <?php for ($r = 0; $r < count($dept); $r++){ ?>
                                      <?php if($dept[$r] != "") {?>
                                      <option value = "<?=$dept[$r]?>"><?=$dept[$r]?></option>
                                <?php } } }?> 
                                </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Select Staff <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <select class="form-control" name="staff">
                                <option value = ""></option>
                               <?php if(count($data) > 0) {?>
                                    <?php for ($r = 0; $r < count($users); $r++){ ?>
                                      <?php if($dept[$r] != "") {?>
                                      <option value = "<?=$users[$r]['email']?>"><?=$users[$r]['name']?> - <?=$users[$r]['department']?></option>
                                <?php } } }?> 
                                </select>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                            <button type="submit" name="payroll" class="btn btn-primary">Submit</button>
                          </div>
                        </form>
                      </div>
                      </div>
                      <div class="x_panel">
                      <div class="x_title">
                        <h2>Leave Management</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                        <form action="process_permission.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Select Department <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <select class="form-control" name ="department">
                                <option value = ""></option>
                               <?php if(count($data) > 0) {?>
                                    <?php $dept = explode(";",$data[0]['department']) ?>
                                    <?php for ($r = 0; $r < count($dept); $r++){ ?>
                                      <?php if($dept[$r] != "") {?>
                                      <option value = "<?=$dept[$r]?>"><?=$dept[$r]?></option>
                                <?php } } }?> 
                                </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Select Staff <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <select class="form-control" name="staff">
                                <option value = ""></option>
                               <?php if(count($data) > 0) {?>
                                    <?php for ($r = 0; $r < count($users); $r++){ ?>
                                      <?php if($dept[$r] != "") {?>
                                      <option value = "<?=$users[$r]['email']?>"><?=$users[$r]['name']?> - <?=$users[$r]['department']?></option>
                                <?php } } }?> 
                                </select>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                            <button type="submit" name="leave" class="btn btn-primary">Submit</button>
                          </div>
                        </form>
                      </div>
                      </div>
                      <div class="x_panel">
                      <div class="x_title">
                        <h2>Cash Request Processing</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                        <form action="process_permission.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Select Department <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <select class="form-control" name ="department">
                                <option value = ""></option>
                               <?php if(count($data) > 0) {?>
                                    <?php $dept = explode(";",$data[0]['department']) ?>
                                    <?php for ($r = 0; $r < count($dept); $r++){ ?>
                                      <?php if($dept[$r] != "") {?>
                                      <option value = "<?=$dept[$r]?>"><?=$dept[$r]?></option>
                                <?php } } }?> 
                                </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Select Staff <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <select class="form-control" name="staff">
                                <option value = ""></option>
                               <?php if(count($data) > 0) {?>
                                    <?php for ($r = 0; $r < count($users); $r++){ ?>
                                      <?php if($dept[$r] != "") {?>
                                      <option value = "<?=$users[$r]['email']?>"><?=$users[$r]['name']?> - <?=$users[$r]['department']?></option>
                                <?php } } }?> 
                                </select>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                            <button type="submit" name="cash_request" class="btn btn-primary">Submit</button>
                          </div>
                        </form>
                      </div>
                      </div>
                  </div>
                  <!--div class="col-md-4 col-sm-12 col-xs-12">
                     <div class="x_panel">
                        <div class="x_title">
                          <h2>Share Access </h2>
                          <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                              </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                          </ul>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                          <br />
                          <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <div>
                                   <select name = "user" class="form-control">
                                     <option value = "">share privilege</option>
                                   </select>
                                </div>
                              </div>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                 <h2 style="margin-top: 20px;">Share Based On Department</h2><hr>
                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <div>
                                   <ul class="list-group">
                                      <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Fleet
                                        <span class="badge  badge-pill" style="width: 25px;height: 25px;border: 1px solid #ccc;position: absolute;right: 0;margin-right: 20px;background-color: #fff;border-radius: 14px;">
                                          <i class="fas fa-check text-primary" color = ""></i>
                                      </span>
                                      </li>
                                    </ul>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                  </div-->
                </div>
                <div class="row" style="width:60%;margin-left:auto;margin-right:auto;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                     
                    </div>
                </div>
                <div class="row" style="width:60%;margin-left:auto;margin-right:auto;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                         
                        </div>
                    </div>
                <div class="row" style="width:60%;margin-left:auto;margin-right:auto;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                     
                    </div>
                </div>
                <div class="row" style="width:60%;margin-left:auto;margin-right:auto;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          
                        </div>
                </div>
                <div class="row" style="width:60%;margin-left:auto;margin-right:auto;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          
                        </div>
                </div>
                <div class="row" style="width:60%;margin-left:auto;margin-right:auto;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                     
                    </div>
                </div>
                 <div class="row" style="width:60%;margin-left:auto;margin-right:auto;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <!--div class="x_panel">
                        <div class="x_content">
                          <br />
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                            <button class="btn btn-primary" type="button">Cancel</button>
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <button type="submit" id = 'submit_btn' class="btn btn-success">Submit</button>
                          </div>
                        </div>
                      </div-->
                    </div>
                </div>
                </div>
          </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="vendors/Flot/jquery.flot.js"></script>
    <script src="vendors/Flot/jquery.flot.pie.js"></script>
    <script src="vendors/Flot/jquery.flot.time.js"></script>
    <script src="vendors/Flot/jquery.flot.stack.js"></script>
    <script src="vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="/build/js/custom.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="js/admin_settings.js"></script>
	
  </body>
</html>
