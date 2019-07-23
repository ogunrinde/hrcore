<?php 
include 'connection.php';
session_start();
$appraisal = [];
  if(!isset($_SESSION['user']['id'])) header("Location: login.php");
  if($_SESSION['user']['category'] == 'staff'){
    $query = "SELECT * FROM appraisal WHERE user_company = '".$_SESSION['user']['user_company']."' AND admin_id = '".$_SESSION['user']['admin_id']."'";
  }else {
    $query = "SELECT * FROM appraisal WHERE admin_id = '".$_SESSION['user']['id']."'";
  }
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $appraisal[] = $row;
      }
  }
  //print_r($_SESSION['user']);
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
                      <h2>Appraisals<small>uploaded appraisal</small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <ul class="list-group">
                        <?php for($i=0; $i < count($appraisal); $i++) { ?> 
                        <?php if($appraisal[$i]['document'] != '') {?>
                        <li class="list-group-item d-flex justify-content-between align-items-center getappraisal" id = "getdata<?=$i?>" appraisal_id = "<?=$appraisal[$i]['id']?>" style ="cursor: pointer;">
                            <span><i class="fa fa-file" style="margin-right: 7px;"></i><?= $appraisal[$i]['period'] ?> (<?= $appraisal[$i]['year'] ?>)</span>
                            <span class="badge badge-primary badge-pill" style="text-transform: uppercase;font-size: 15px;border-radius: 2px;background-color: #1ABB9C"><?=$appraisal[$i]['user_company']?></span>
                        </li>
                        <?php }else { ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center getappraisal" id = "getdata<?=$i?>" appraisal_id = "<?=$appraisal[$i]['id']?>" style ="cursor: pointer;">
                            <span><i  class="fas fa-pen" style="margin-right: 7px;"></i><?= $appraisal[$i]['period'] ?> (<?= $appraisal[$i]['year'] ?>)</span>
                            <span class="badge badge-primary badge-pill" style="text-transform: uppercase;font-size: 15px;border-radius: 2px;background-color: #1ABB9C"><?=$appraisal[$i]['user_company']?></span>
                        </li>  
                        <?php } ?>  
                        <?php } ?>
                        <?php if(count($appraisal) == 0) {?>
                          No appraisal created yet
                        <?php } ?>  
                      </ul>
                    </div>
                  </div>
                </div>
        </div>
</div>
</div>
<?php include "footer.php"?>
<script type="text/javascript" src="js/appraisal.js"></script>
        
