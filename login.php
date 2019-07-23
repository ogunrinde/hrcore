<?php
  session_start();
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

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>
 <style type="text/css">
  .overlay{
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background-color: #000;
    opacity: 0.4;
  }
  .login_user{
    position: absolute;
    z-index: 3;
    top:13%;
    width: 60%;
    left: 20%;
    right: 20%;
  }
  .for_login{
      width:80%;margin-left:auto;margin-right:auto;
  }
  html, body {
    background-image: url("images/efp-header.jpg") !important;
     background-repeat: no-repeat;
     background-position: center;
     background-size: cover;
    height: 100%;
  }
  @media only screen and (max-width: 768px) {
   .for_login{
      width:98%;margin-left:auto;margin-right:auto;
  } 
  .login_user{
    position: absolute;
    z-index: 3;
    top:13%;
    width: 98%;
    left: 1%;
    right: 1%;
  }
 }
 </style>
  <body class="nav-md">
    <div class="overlay"></div>
    <div class="container body" style="background-color: #fff;overflow-x:hidden;">
      <div class="">
        <div class="sign_in" role="main" style="">
            <div class="login_user">
                <div class="clearfix"></div>
                <div class="row for_login" style="">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>SIGN IN</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                        <div class="text-center" style="margin-bottom: 15px;"><a href ="index.php"><img class="logo-alt" src="asset/img/hr.png" alt="logo" style="width: 100px;height: 50px;"></a></div>
                         <?php if(isset($_SESSION['msg'])) {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                        <?php } ?>
                        <form action = "login_user.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Username <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="email" name = "email" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="password" id="password" name="password" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="ln_solid"></div>
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                            <p>Forgot Password? <a class="btn btn-primary" href="forget_password">Click Here</a></p>
                            
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
          </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendor/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendor/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendor/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../vendor/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../vendor/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendor/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendor/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendor/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../vendor/vendors/Flot/jquery.flot.js"></script>
    <script src="../vendor/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendor/vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendor/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendor/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendor/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendor/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendor/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendor/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../vendor/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendor/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendor/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendor/vendors/moment/min/moment.min.js"></script>
    <script src="../vendor/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="/build/js/custom.min.js"></script>
	
  </body>
</html>
