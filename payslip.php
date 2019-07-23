<?php
include "connection.php";
session_start();
if(!isset($_SESSION['employee_payroll_data'])){
  header("Location: masterlist.php");
}
$month = ["JAN", "FEB", "MAR", "APR", "MAY", "JUNE", "JULY", "AUG","SEPT","OCT", "NOV", "DEC"];
$t = (int)date("m") - 1;
$this_month = $month[$t];
//print_r($_SESSION['employee'][0]['id']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Payslip</title>

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


    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>
  <style type="text/css">
    .flex{
      display: flex;
    }
    .flex > div{
      width: 50%;
    }
    tr{
      padding: 2px;
    }
    .table td, .table th{
      padding: 5px;
    }
  </style>
  <body>
      <div class="container">
        <div class="" style="width: 60%;margin-left: auto;margin-right: auto;">
        <div class="text-center" style="padding: 10px;"><img src="images/<?=$_SESSION['company']['image']?>" style="width: 60px;height: 60px;"></div>  
        <table class="table table-bordered">
          <thead>
            <tr style="width: 100%;">
              <th colspan="2" scope="col" style="">ICS OUTSOURCING LIMITED</th>
              <th colspan="3" scope="col" style="">PAYSLIP FOR <?=date('d')?> <?=$this_month?> <?=date('Y')?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">EMP. CODE:</th>
              <td><?=isset($_SESSION['employee'][0]['employee_ID']) ? $_SESSION['employee'][0]['employee_ID'] : ''?></td>
              <th>PAYMODE</th>
              <td colspan="2"><?=isset($_SESSION['company']['company_name']) ? $_SESSION['company']['company_name'] : ''?></td>
            </tr>
            <tr>
              <th scope="row">EMP.NAME</th>
              <td><?=isset($_SESSION['employee'][0]['first_name']) ? $_SESSION['employee'][0]['last_name']." ".$_SESSION['employee'][0]['first_name'] : ''?></td>
              <th>Grade</th>
              <td colspan="2">BANKING ASSOCIATE 3</td>
            </tr>
            <tr>
              <th scope="row">DEPARTMENT</th>
              <td colspan="2">SUPPORT</td>
              <th>CATEGORY</th>
              <td colspan="2">DEVELOPER</td>
            </tr>
            <tr>
              <th scope="row">LOCATION</th>
              <td colspan="2">OGUDU BRANCH</td>
              <th>POSITION</th>
              <td colspan="2">TELLER</td>
            </tr>
          </tbody>
        </table>
      <div class="flex">
        <div>
          <table class="table table-bordered">
            <tr style="width: 100%;">
              <th style="width: 300px;">ALLOWANCES/EARNING</th>
              <th colspan="2">NGN</th>
            </tr>
            <?php if(isset($_SESSION['employee_payroll_data'][0]['basic_salary']) && $_SESSION['employee_payroll_data'][0]['basic_salary'] != "") {?>
              <tr>
              <td>BASIC SALARY</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['basic_salary'])?></td>
              </tr>
          <?php } ?>
          <?php if(isset($_SESSION['employee_payroll_data'][0]['housing']) && $_SESSION['employee_payroll_data'][0]['housing'] != "") {?>
              <tr>
              <td>HOUSING</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['housing'])?></td>
              </tr>
          <?php } ?>
          <?php if(isset($_SESSION['employee_payroll_data'][0]['transport']) && $_SESSION['employee_payroll_data'][0]['transport'] != "") {?>
              <tr>
              <td>HOUSING</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['transport'])?></td>
              </tr>
          <?php } ?>
          <?php if(isset($_SESSION['employee_payroll_data'][0]['lunch']) && $_SESSION['employee_payroll_data'][0]['lunch'] != "") {?>
              <tr>
              <td>LUNCH</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['lunch'])?></td>
              </tr>
          <?php } ?>
          <?php if(isset($_SESSION['employee_payroll_data'][0]['utility']) && $_SESSION['employee_payroll_data'][0]['utility'] != "") {?>
              <tr>
              <td>UTILITY</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['utility'])?></td>
              </tr>
          <?php } ?>
          <?php if(isset($_SESSION['employee_payroll_data'][0]['education']) && $_SESSION['employee_payroll_data'][0]['education'] != "") {?>
              <tr>
              <td>EDUCATION</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['education'])?></td>
              </tr>
          <?php } ?>
          <?php if(isset($_SESSION['employee_payroll_data'][0]['entertainment']) && $_SESSION['employee_payroll_data'][0]['entertainment'] != "") {?>
              <tr>
              <td>ENTERTAINMENT</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['entertainment'])?></td>
              </tr>
          <?php } ?>
          <?php if(isset($_SESSION['employee_payroll_data'][0]['ITF']) && $_SESSION['employee_payroll_data'][0]['ITF'] != "") {?>
              <tr>
              <td>ITF</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['ITF'])?></td>
              </tr>
          <?php } ?>
          <?php if(isset($_SESSION['employee_payroll_data'][0]['furniture']) && $_SESSION['employee_payroll_data'][0]['furniture'] != "") {?>
              <tr>
              <td>FURNITURE</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['furniture'])?></td>
              </tr>
          <?php } ?>
          <?php if(isset($_SESSION['employee_payroll_data'][0]['q_allowance']) && $_SESSION['employee_payroll_data'][0]['q_allowance'] != "") {?>
              <tr>
              <td>QUARTERLY ALLOWANCE</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['q_allowance'])?></td>
              </tr>
          <?php } ?>
          <?php if(isset($_SESSION['employee_payroll_data'][0]['q_allowance']) && $_SESSION['employee_payroll_data'][0]['q_allowance'] != "") {?>
              <tr>
              <td>LEAVE</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['leave_bonus'])?></td>
              </tr>
          <?php } ?>
          <?php if(isset($_SESSION['employee_payroll_data'][0]['gross']) && $_SESSION['employee_payroll_data'][0]['gross'] != "") {?>
              <tr>
              <th>GROSS SALARY</th>
              <td colspan="2"><?=$_SESSION['employee_payroll_data'][0]['gross']?></td>
              <?php } ?>
              </tr>
          <?php if(isset($_SESSION['employee_payroll_data'][0]['NET']) && $_SESSION['employee_payroll_data'][0]['NET'] != "") {?>
              <tr>
              <th>NET SALARY</th>
              <td colspan="2"><?=$_SESSION['employee_payroll_data'][0]['NET']?></td>
              <?php } ?>
              </tr>    
              <tr>
              <th>REMARK</th>
              <td colspan="3"></td>
              </tr>
          </table>
        </div>
        <div>
          <table  class="table table-bordered">
              <tr>
              <th>DEDUCTIONS</th>
              <th colspan="2">NGN</th>
              </tr>
              <?php if(isset($_SESSION['employee_payroll_data'][0]['pension_company']) && $_SESSION['employee_payroll_data'][0]['pension_company'] != "") {?>
              <tr>
              <td>PENSION(EMPLOYER)</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['pension_company'])?></td>
              </tr>
             <?php } ?>
             <?php if(isset($_SESSION['employee_payroll_data'][0]['pension_earning']) && $_SESSION['employee_payroll_data'][0]['pension_earning'] != "") {?>
              <tr>
              <td>PENSION(EMPLOYEE)</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['tax'])?></td>
              </tr>
              <tr>
              <td>TAX</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['tax'])?></td>
              </tr>
             <?php } ?>
             <?php if(isset($_SESSION['employee_payroll_data'][0]['NTF']) && $_SESSION['employee_payroll_data'][0]['NTF'] != "") {?>
              <tr>
              <td>NTF</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['NTF'])?></td>
              </tr>
             <?php } ?>
             <?php if(isset($_SESSION['employee_payroll_data'][0]['ECA']) && $_SESSION['employee_payroll_data'][0]['ECA'] != "") {?>
              <tr>
              <td>ECA</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['ECA'])?></td>
              </tr>
             <?php } ?>
             <?php if(isset($_SESSION['employee_payroll_data'][0]['ITF']) && $_SESSION['employee_payroll_data'][0]['ITF'] != "") {?>
              <tr>
              <td>ITF</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['ITF'])?></td>
              </tr>
             <?php } ?>
             <?php if(isset($_SESSION['employee_payroll_data'][0]['GLI']) && $_SESSION['employee_payroll_data'][0]['GLI'] != "") {?>
              <tr>
              <td>GLI</td>
              <td colspan="2"><?=number_format($_SESSION['employee_payroll_data'][0]['GLI'])?></td>
              </tr>
             <?php } ?>
             <tr>
              <th>TOTAL DEDUCTION</th>
              <td colspan="2"></td>
              </tr>
          </table>
        </div>
      </div>
       <div>
          <div class="btn-group" role="group" aria-label="Basic example">
          <a class="btn btn-danger btn-sm" href="masterlist.php" style="color: #fff;padding: 10px 10px;">Return</a>
          <a class="btn btn-success btn-sm" id = "print_page" style="color: #fff;padding: 10px 10px;">Print Payslip</a>
          <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#show_moda" id="show_modal" style="color: #fff;padding: 10px 10px;">Send</a>
        </div>
       </div>
       </div>
      </div> 
      <div class="modal fade" id="show_moda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="border: none;">
              <h2 class="modal-title" id="exampleModalLabel">Send Payslip </h2>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" style="border: none;position: relative;">
              <form>
                 <div class="form-group">
                  <label class="" for="first-name">Recipient's Email
                  </label>
                      <input id="email" name="email" class="form-control col-md-7 col-xs-12" placeholder = "enter the recipient email" type="text">
                </div>

              </form>
            <p id="e_ID"><?=$_SESSION['employee'][0]['id']?></p>
            <div class="modal-footer" style="border: none;">
              <button type="button" class="btn btn-primary" id = "send_email_now" class="close" data-dismiss="modal" aria-label="Close">continue</button>
            </div>
          </div>
        </div>
      </div>
      <?php unset($_SESSION['employee']);?>
      <?php unset($_SESSION['other_info']);?> 
      <?php unset($_SESSION['company']);?>  
      <?php unset($_SESSION['employee_payroll_data']);?>
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
    <script type="text/javascript">
      $(function(e){
        $("#print_page").on("click", function(e){
          window.print();
        });
        $("#send_email_now").on("click", function(e){
          e.preventDefault();
          let email = $("#email").val();
          let eID = $("#e_ID").text().trim();
          if(email == '' || email == undefined) return;
          
          window.location.href = "/outsourcing/sendpayslip.php/?eID="+btoa(eID)+"&email="+btoa(email);
        })
      })
    </script>
  </body>
</html>     