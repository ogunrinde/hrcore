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
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Gentelella Alela! | </title>

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
                    <h3>Admin Settings</h3>
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
                <div class="row" style="width:60%;margin-left:auto;margin-right:auto;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <ul class ="flow app_flow">
                        <li class=""><a href="#">Company Details </a></li>
                        <li><a class="" style="background-color: #003D66">Add Branch </a></li>
                        <li><a class="">Add Department </a></li>
                        <li><a class="">Appraisal Approval </a></li>
                        <li><a class="">Leave Approval </a></li>
                      </ul>
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Branch</h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                          <br />
                          <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                            <ul class="list-group" id = 'listbranch'>
                            </ul> 
                           <div class="form-group" style="margin-top:20px;">  
                            <div class="col-md-12 col-sm-12 col-xs-12 text-center form_center">
                                <input type="text" id="branch" name="branch" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                           </div>
                            <div class="form-group btn_center" style="margin-top:20px;">
                              <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                                <button class="btn btn-primary" id = 'add_branch' type="button">Add Branch</button>
                              </div>
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
