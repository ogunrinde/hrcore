<?php 
include 'connection.php';
 session_start();
 $msg = '';
 $data = [];
 $user = [];
 $to_remark = [];
 $appraisal_approval_details = [];
 $appraisal = [];
 $to_show_appraisal = [];
 $query = "SELECT * FROM users WHERE admin_id = '".$_SESSION['user']['admin_id']."'";
 $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) > 0){
     while($row = mysqli_fetch_assoc($result)) {
          $user[] = $row;
     }
  }
 //print_r($_SESSION['user']['id']); 
 if($_SESSION['user']['category'] == 'admin'){
     $user = [];
  $query = "SELECT * FROM users WHERE admin_id = '".$_SESSION['user']['id']."'";
 $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) > 0){
     while($row = mysqli_fetch_assoc($result)) {
          $user[] = $row;
     }
  }       
     
     
  $query = "SELECT * FROM appraisal_replies INNER JOIN appraisal ON appraisal.id = appraisal_replies.appraisal_id WHERE appraisal.admin_id = '".$_SESSION['user']['id']."'";
  $app_result = mysqli_query($conn, $query);
  if(mysqli_num_rows($app_result) > 0){
     while($row = mysqli_fetch_assoc($app_result)) {
          $appraisal[] = $row;
     }
  }
 }else{
  $query = "SELECT * FROM appraisal_replies INNER JOIN appraisal ON appraisal.id = appraisal_replies.appraisal_id WHERE appraisal.admin_id = '".$_SESSION['user']['admin_id']."'";
  $app_result = mysqli_query($conn, $query);
  if(mysqli_num_rows($app_result) > 0){
     while($row = mysqli_fetch_assoc($app_result)) {
          $appraisal[] = $row;
     }
  }
 }

  //print_r($user);
if($_SESSION['user']['category'] == 'admin'){
   for ($i=0; $i < count($user); $i++) {     
    foreach ($appraisal as $value) {
      if($value['staff_id'] == $user[$i]['id']){
        $to_remark[]  = $user[$i];
        $to_show_appraisal[] = $value;
      }
    }
   }
}else { 
for ($i=0; $i < count($user); $i++) { 
  if($user[$i]['appraisal_flow'] != ''){
    //echo $user[$i]['appraisal_flow'];
  $appraisal_approval_details = explode(";", $user[$i]['appraisal_flow']);
  if(count($appraisal_approval_details) > 0){
    for($r = 0; $r < count($appraisal_approval_details); $r++){
      $email = explode(":", $appraisal_approval_details[$r])[1];//email of approval
      //echo $email."<br>";
      if($email == $_SESSION['user']['email']){
        foreach ($appraisal as $value) {
          if($value['staff_id'] == $user[$i]['id']){
            $to_remark[]  = $user[$i];
            $to_show_appraisal[] = $value;
          }
        }
      }
    }
    
    
  }
 }
}
}
//print_r($to_show_appraisal);
?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Appraisal</h3>
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
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Appraisal to Remark</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($to_show_appraisal) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title text-center">Name</th>
                            <th class="column-title text-center">Department </th>
                            <th class="column-title text-center">Role </th>
                            <th class="column-title text-center">Appraisal period </th>
                            <th class="column-title text-center">More </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($to_show_appraisal); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class="text-center"><?=$to_remark[$h]['name']?></td>
                            <td class="text-center"><?=$to_remark[$h]['department']?></td>
                            <td class="text-center"><?=$to_remark[$h]['role']?></td>
                            <td class="text-center"><?=$to_show_appraisal[$h]['period']?></td>
                            <td class="text-center"><a href="get_this_staff_appraisal.php/?appraisal_id=<?=base64_encode($to_show_appraisal[$h]['appraisal_id'])?>&staff_id=<?=base64_encode($to_show_appraisal[$h]['staff_id'])?>" class="btn btn-sm btn-success">View</a></td>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php } else { ?>
                       You have no appraisal to remark
                    <?php } ?>
                  </div>
                </div>
            </div> 
        </div>
</div>
</div>
<?php include "footer.php"?>
<script type="text/javascript">
    $('.upload_qual_file').on('click', function(e){
     $('#qual_file').trigger('click');
    });
    function readURL(input) {
      if (input.files && input.files[0]) {
        $('#doc').text('1 doc added-'+input.files[0].name);
        $('.upload_qual_file')
            .attr('src', 'images/document.png')
            .width(100)
            .height(100);
      }
    }
</script>

        
