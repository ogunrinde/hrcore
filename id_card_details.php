<?php 
include 'connection.php';
session_start();
$msg = '';
$id_request = [];
if($_SESSION['user']['category'] != 'admin') header("Location: dashboard.php");
$query = "SELECT users.name,users.fname,users.mname, users.employee_ID,id_card.signature,id_card.status,id_card.date_created,id_card.staff_id,id_card.IID as request_id, id_card.remark,users.profile_image,users.branch,users.department, users.role, users.phone_number,id_card.justification, id_card.comment FROM id_card INNER JOIN users ON users.id = id_card.staff_id WHERE id_card.staff_id = '".$_SESSION['staff_id']."' ORDER BY id_card.IID DESC";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
   while($row = mysqli_fetch_assoc($result)) {
       if((float)strtotime($row['date_created']) > (float)strtotime('2019-06-20'))
        $id_request[] = $row;
   }
}
//print_r($id_request);
 if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
 else if ($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT kss.information,users.name,users.employee_ID FROM kss INNER JOIN users ON kss.staff_id = users.id WHERE kss.admin_id = '".$admin_id."'ORDER BY kss.id LIMIT 1";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $kss[] = $row;
      }
  }
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
                  <a href = 'view_all_id_request'><i class="fas fa-arrow-left" style = 'font-size:30px'></i></a>
                <h3>ID Card Request</h3>
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
              <div class="col-md-10 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><a href = 'view_all_id_request' class='btn btn-primary btn-sm'><i class="fas fa-arrow-left"></i> Back Button</a>Employee Details</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php if(count($id_request) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <!--thead>
                          <tr class="headings">
                            <th class="column-title text-center">S/N</th>
                            <th class="column-title text-center">Name</th>
                            <th class="column-title text-center">Employee ID </th>
                            <th class="column-title text-center">Branch</th>
                            <th class="column-title text-center">Department</th>
                          </tr>
                        </thead-->

                        <tbody>
                         <tr>
                           <td style="width: 60%">Name</td>
                           <td style="width: 40%"><?=$id_request[0]['name']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">First Name</td>
                           <td style="width: 40%"><?=$id_request[0]['fname']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Middle Name</td>
                           <td style="width: 40%"><?=$id_request[0]['mname']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Employee ID</td>
                           <td style="width: 40%"><?=$id_request[0]['employee_ID']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Branch</td>
                           <td style="width: 40%"><?=$id_request[0]['branch']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Department</td>
                           <td style="width: 40%"><?=$id_request[0]['department']?></td>
                         </tr>
                         <tr>
                           <td style="width: 60%">Role</td>
                           <td style="width: 40%"><?=$id_request[0]['role']?></td>
                         </tr>
                          <tr>
                           <td style="width: 60%">Phone Number</td>
                           <td style="width: 40%"><?=$id_request[0]['phone_number']?></td>
                         </tr>
                      </table>
                    </div>
                    <?php } ?>
                  </div>
                </div>
                 <div class="x_panel">
                  <div class="x_title">
                    <h2>ID Card Request History</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php if(count($id_request) > 0 ){ ?>
                     <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title text-center">S/N</th>
                            <th class="column-title text-center">Request Date</th>
                            <th class="column-title text-center">Status</th>
                            <th class="column-title text-center">Sig</th>
                            <th class="column-title text-center">Signature</th>
                            <th class="column-title text-center">Passport</th>
                            <th class="column-title text-center">Remark</th>
                            <th class="column-title text-center">Comment</th>
                            <th class="column-title text-center">View</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($id_request); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center text-center">
                              <?=$h + 1?>
                            </td>
                            <td class="text-center"><?=$id_request[$h]['date_created']?></td>
                            <td class="text-center"><?=$id_request[$h]['status']?></td>
                            <td class="text-center"><?=$id_request[$h]['signature']?></td>
                            <td class="text-center"><img src = "document/signature/<?=$id_request[$h]['signature']?>" style = "width: 60px;height:40px;"></td>
                            <td class="text-center"><img src = "images/<?=$id_request[$h]['profile_image']?>" style = "width: 60px;height:40px;"></td>
                            <td class="text-center"><?=$id_request[$h]['remark']?></td>
                            <td class="text-center" style="text-align: justify;word-wrap: break-word;"><?=$id_request[$h]['comment']?></td>
                            <?php if($id_request[$h]['comment'] == '') {?>
                            <td class="text-center">
                               <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-warning btn-sm comment" justification ="<?=$id_request[$h]['justification']?>" id = "comment<?=$h?>" comment = "<?=$id_request[$h]['comment']?>" request_id = "<?=$id_request[$h]['request_id']?>" data-toggle="modal" data-target="#myComment">Reply</button>
                              </div>
                            </td>
                          <?php }else { ?>
                            <td class="text-center">
                               <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-warning btn-sm comment" justification ="<?=$id_request[$h]['justification']?>" request_id = "<?=$id_request[$h]['request_id']?>" id = "comment<?=$h?>" comment = "<?=$id_request[$h]['comment']?>" data-toggle="modal" data-target="#myComment">Show Comment</button>
                              </div>
                            </td>
                           <?php } }?>
                        </tbody>
                      </table>
                    </div>
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
        <!-- Modal -->
<div id="myComment" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-success" >Add Comment</h4>
      </div>
      <div style="padding: 20px;">
        <h4>Justification</h4>
        <p style="text-align: justify;margin-top: 7px;margin-bottom: 5px" id ="justify"></p>
      </div>
      <div class="modal-body" style="padding: 20px;">
        <form action="process_id_request.php" method="POST">
           <div class="form-group">
              <label>Remark</label>
              <select name="remark" class="form-control">
                <option value=""></option>
                <option value="Approved">Aproved</option>
                <option value="Decline">Decline</option>
                <option value="Pending">Pending</option>
              </select>
           </div>
           <div class="form-group">
            <label>Comment</label>
           <textarea class="form-control" rows="4" id ="save_comment" name = "comment" style="margin-bottom: 10px;"></textarea>
           </div>
           <input type="text" name="id_card_request_id" id = "request_id" style="display: none;" />
           <button class="btn btn-warning btn-sm" name="submit" type="submit">Submit Comment</button>
        </form>
      </div>
    </div>

  </div>
</div>
<?php include "footer.php"?>
<script type="text/javascript" src="js/appraisal.js"></script>
<script type="text/javascript">
  $(function(){
    $(".comment").on('click', function(e){
      let comment = $("#"+this.id+"").attr("comment");
      let request_id = $("#"+this.id+"").attr("request_id");
      let justification = $("#"+this.id+"").attr("justification");
      $("#request_id").val(request_id);
      $("#justify").text(justification);
      $("#save_comment").val(comment);
    });
  })
</script>

        
