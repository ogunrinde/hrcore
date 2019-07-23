<?php 
include 'connection.php';
session_start();
$kss = [];
$admin_id;
 if(!isset($_SESSION['user']['id'])) header("Location: login.php");
 if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
 else if ($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT kss.information,users.name,users.employee_ID FROM kss INNER JOIN users ON kss.staff_id = users.id WHERE kss.admin_id = '".$admin_id."' ORDER BY kss.id DESC";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $kss[] = $row;
      }
  }
  //print_r($kss);
?>
<?php include "header.php"?>
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>KSS DASHBOARD</h3>
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
                <?php for ($r = 0;$r < count($kss); $r++) {?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Knowledge shared by (<?=$kss[$r]['name']?>)</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p style="text-align: justify;"><?=$kss[$r]['information']?></p>
                  </div>
                </div>
                <?php } ?> 
                <?php if(count($kss) == 0) {?>
                  <div class="x_panel">
                  <div class="x_title">
                    <h2>KSS</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p style="text-align: justify;">No Knowledge shared yet</p>
                  </div>
                </div>
                <?php  } ?> 
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
        
