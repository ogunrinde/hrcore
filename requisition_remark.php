<?php 
include 'connection.php';
 session_start();
 $msg = '';
 $data = [];
 $user = [];
 $to_remark = [];
 $requistion_approval_details = [];
 $requistion = [];
 $to_show_requisition = [];
 $as_commented = [];
 $query = "SELECT * FROM users WHERE admin_id = '".$_SESSION['user']['admin_id']."'";
 $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) > 0){
     while($row = mysqli_fetch_assoc($result)) {
          $user[] = $row;
     }
  }
 $query = "SELECT requesteditem.id as request_id,requesteditem.item,requesteditem.flow,requesteditem.justification,requesteditem.staff_id,users.id as user_id FROM requesteditem INNER JOIN users ON users.id = requesteditem.staff_id WHERE requesteditem.admin_id = '".$_SESSION['user']['admin_id']."'";
 $app_result = mysqli_query($conn, $query);
  if(mysqli_num_rows($app_result) > 0){
     while($row = mysqli_fetch_assoc($app_result)) {
          $requistion[] = $row;
     }
  }
  //print_r($user[0]['requisition_flow']);
for ($i=0; $i < count($user); $i++) { 
  if($user[$i]['requisition_flow'] != ''){
    //echo $user[$i]['appraisal_flow'];
  $requistion_approval_details = explode(";", $user[$i]['requisition_flow']);
  if(count($requistion_approval_details) > 0){
    for($r = 0; $r < count($requistion_approval_details); $r++){
      $email = explode(":", $requistion_approval_details[$r])[1];//email of approval
      //echo $email."<br>";
      if($email == $_SESSION['user']['email']){
        foreach ($requistion as $value) {
          if($value['staff_id'] == $user[$i]['id']){
            $to_remark[]  = $user[$i];
            $to_show_requisition[] = $value;
            $flows = $value['flow'] != '' ? explode(';',$value['flow']) : [];
            for($s = 0; $s < count($flows); $s++){
            $data = explode(":", $flows[$s]);
            if(count($data) > 0) $who = $data[0];
            $next_approval = explode(":", $flows[$s]);
            if(count($next_approval) > 1){
                //echo $next_approval[1];
                if (filter_var($next_approval[1], FILTER_VALIDATE_EMAIL)) {
                    $as_commented[] = '';
                }else { $as_commented[] = $next_approval[1]; }
              }
          }
          }
        }
      }
    }
    
    
  }
 }
}
//print_r($as_commented);
//print_r($requistion);
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
            <h3>Requisition Remark</h3>
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
                    <h2>Requisition to Remark</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($to_show_requisition) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title text-center">Name</th>
                            <th class="column-title text-center">Department </th>
                            <th class="column-title text-center">Role </th>
                            <th class="column-title text-center">Item Name </th>
                            
                            <th class="column-title text-center">More </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($to_show_requisition); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class="text-center"><?=$to_remark[$h]['name']?></td>
                            <td class="text-center"><?=$to_remark[$h]['department']?></td>
                            <td class="text-center"><?=$to_remark[$h]['role']?></td>
                            <td class="text-center"><?=$to_show_requisition[$h]['item']?></td>
                            
                            <td class="text-center"><a href="get_this_staff_requisition.php/?requestitem_id=<?=base64_encode($to_show_requisition[$h]['request_id'])?>&staff_id=<?=base64_encode($to_show_requisition[$h]['staff_id'])?>" class="btn btn-sm btn-success">View</a></td>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php } else { ?>
                       You have no requisition to approve
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

        
