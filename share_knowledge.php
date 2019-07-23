<?php 
include 'connection.php';
session_start();
$kss = [];
$admin_id;
 if(!isset($_SESSION['user']['id'])) header("Location: login.php");
 if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
 else if ($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT kss.information,users.name,users.employee_ID FROM kss INNER JOIN users ON kss.staff_id = users.id WHERE kss.admin_id = '".$admin_id."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $kss[] = $row;
      }
  }

  //print_r($kss);
?>
<?php include "header.php"?>
<script src="https://cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>SHARE KNOWLEDGE</h3>
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
                    <h2>SHARE INFORMATION</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form action="process_share_knowledge.php" method="POST">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <textarea type="text" id="role" value="" style="margin-bottom: 10px;" name = "editor1" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <button class="btn btn-primary" type="submit" name = "submit">Share</button>
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
                    <?php }else { ?>
                      <p style="text-align: justify;">No Information shared</p>
                    <?php } ?>  
                  </div>
                </div>
              </div>
            </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
<?php include "footer.php"?>
<script type="text/javascript" src="js/appraisal.js"></script>
<script>
  CKEDITOR.replace( 'editor1' );
</script>
        
