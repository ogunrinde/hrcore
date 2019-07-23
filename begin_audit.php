<?php 
include 'connection.php';
session_start();
$kss = [];
$admin_id = '';
$users = [];
$company = [];
$user_company = [];
//print_r($_SESSION['user']);
 if(!isset($_SESSION['user']['id'])) header("Location: login.php");
 if($_SESSION['user']['category'] === 'staff') $admin_id = $_SESSION['user']['admin_id'];
 else if ($_SESSION['user']['category'] === 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT kss.information,users.name,users.employee_ID FROM kss INNER JOIN users ON kss.staff_id = users.id WHERE kss.admin_id = '".$admin_id."'ORDER BY kss.id LIMIT 1";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $kss[] = $row;
      }
  }
  $query = "SELECT * FROM users WHERE admin_id = '".$_SESSION['user']['admin_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
      }
  }
  /*$query = "SELECT * FROM company WHERE admin_id = '".$admin_id."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $company[] = $row;
      }
      if(count($company) > 0){
        if($company[0]['user_company'] != ""){
          $user_company = explode(";", $company[0]['user_company']);
        }
      }
  }*/
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
  //print_r($_SESSION['user']);
  //print_r($user_company);
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
                <h3>STAFF AUDIT</h3>
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
               <?php if(isset($_SESSION['msg']) && $_SESSION['msg'] != '') {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>   
              <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Begin Audit</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form action="process_staff_audit.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
        
                             <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Audit Month <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="month" class="form-control">
                                         <option value=""></option>
                                         <option value="JAN">JAN</option>
                                         <option value="FEB">FEB</option>
                                         <option value="MAR">MAR</option>
                                         <option value="APR">APR</option>
                                         <option value="MAY">MAY</option>
                                         <option value="JUN">JUN</option>
                                         <option value="JUL">JUL</option>
                                         <option value="AUG">AUG</option>
                                         <option value="SEP">SEPT</option>
                                         <option value="OCT">OCT</option>
                                         <option value="NOV">NOV</option>
                                         <option value="DEC">DEC</option>
                                       </select>
                                </div>
                              </div>
                              <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Audit year <span class="required">*</span>
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
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Company <span class="required">*</span>
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
              <div class="col-md-4 col-sm-12 col-xs-12">
                  <div class="x_panel">
                  <div class="x_title">
                    <h2>KSS shared by (<span style="font-size: 13px;"><?=isset($kss[0]['name']) ? $kss[0]['name'] : ''?></span>)</h2>
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
        
