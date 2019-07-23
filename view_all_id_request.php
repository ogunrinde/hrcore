<?php 
include 'connection.php';
session_start();
$msg = '';
$id_request = [];
$kss = [];
if(!isset($_SESSION['user']['id'])) header("Location: login.php");
if($_SESSION['user']['category'] == 'staff' && $_SESSION['user']['id-card_permission'] == '1') $admin_id = $_SESSION['user']['admin_id'];
else if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
else header("Location: dashboard.php");
  if(isset($_POST['decline'])){
      $id = $_POST['request_id'];
       $sql = "UPDATE id_card SET status = 'Declined'  WHERE IID = '".$id."'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = 'Request Declined';
        } else {
          //echo "Error updating record: " . mysqli_error($conn);
        }
  }
  
$query = "SELECT users.name,users.fname,users.mname,users.email, users.employee_ID,id_card.signature,users.profile_image,id_card.status,id_card.date_created,id_card.staff_id,id_card.IID as request_id FROM id_card RIGHT JOIN users ON users.id = id_card.staff_id WHERE (id_card.admin_id = '".$_SESSION['user']['id']."' AND users.id = id_card.staff_id AND users.active = '1' AND id_card.status = 'pending') ORDER BY id_card.IID DESC";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
   while($row = mysqli_fetch_assoc($result)) {
       //echo $row['date_created'].'<br>';
       if((float)strtotime($row['date_created']) > (float)strtotime('2019-06-18'))
        $id_request[] = $row;
   }
}
//print_r($id_request);
 if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
 else if ($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT kss.information,users.name,users.fname,users.mname,users.employee_ID FROM kss INNER JOIN users ON kss.staff_id = users.id WHERE kss.admin_id = '".$admin_id."'ORDER BY kss.id LIMIT 1";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $kss[] = $row;
      }
  }
  if(isset($_POST['pending'])){
    $id_request = [];
    $query = "SELECT users.name,users.fname,users.mname,users.email, users.employee_ID,id_card.signature,users.profile_image,id_card.status,id_card.date_created,id_card.staff_id,id_card.IID as request_id FROM id_card LEFT JOIN users ON users.id = id_card.staff_id WHERE (id_card.admin_id = '".$_SESSION['user']['id']."' AND users.id = id_card.staff_id AND users.active = '1' AND id_card.status = 'pending') ORDER BY id_card.IID DESC";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
       while($row = mysqli_fetch_assoc($result)) {
         if((float)strtotime($row['date_created']) > (float)strtotime('2019-06-18'))  
            $id_request[] = $row;
       }
    }
   //print_r($leaves);
 }

 if(isset($_POST['treated'])){
  $id_request = [];
    $query = "SELECT users.name,users.fname,users.mname,users.email, users.employee_ID,id_card.signature,users.profile_image,id_card.status,id_card.date_created,id_card.staff_id,id_card.IID as request_id FROM id_card LEFT JOIN users ON users.id = id_card.staff_id WHERE (id_card.admin_id = '".$_SESSION['user']['id']."' AND users.id = id_card.staff_id AND users.active = '1' AND id_card.status = 'Approved') ORDER BY id_card.IID DESC";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
       while($row = mysqli_fetch_assoc($result)) {
          if((float)strtotime($row['date_created']) > (float)strtotime('2019-06-18')) 
            $id_request[] = $row;
       }
    }

}
if(isset($_POST['decline'])){
  $id_request = [];
    $query = "SELECT users.name,users.fname,users.mname,users.email, users.employee_ID,id_card.signature,users.profile_image,id_card.status,id_card.date_created,id_card.staff_id,id_card.IID as request_id FROM id_card LEFT JOIN users ON users.id = id_card.staff_id WHERE (id_card.admin_id = '".$_SESSION['user']['id']."' AND users.id = id_card.staff_id AND users.active = '1' AND id_card.status = 'Decline') ORDER BY id_card.IID DESC";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
       while($row = mysqli_fetch_assoc($result)) {
           if((float)strtotime($row['date_created']) > (float)strtotime('2019-06-18'))
            $id_request[] = $row;
       }
    }

}
if(isset($_POST['copydata'])){
  $approvedData = [];    
  if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
    if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
    //print_r($admin_id);
    $query = "SELECT users.name,users.fname,users.mname,users.email,users.branch, users.employee_ID,id_card.signature,users.profile_image,id_card.status,id_card.date_created,id_card.staff_id,id_card.IID as request_id FROM id_card LEFT JOIN users ON users.id = id_card.staff_id WHERE (id_card.admin_id = '".$_SESSION['user']['id']."' AND users.id = id_card.staff_id AND users.active = '1' AND id_card.status = 'Approved') ORDER BY id_card.IID DESC";
    $productResult = mysqli_query($conn, $query);
    //print_r($productResult);
    if(mysqli_num_rows($productResult)> 0){
      foreach ($productResult as $row) {
         if((float)strtotime($row['date_created']) > (float)strtotime('2019-06-18'))  
           $approvedData[] = $row;  
      }
    }else {}
    //print_r($approvedData);
    //echo "document/signature/".$approvedData[0]['signature']."";
}
for($y = 0; $y < count($approvedData); $y++){
    if(file_exists("document/signature/".$approvedData[$y]['signature']."")){
 	   copy("document/signature/".$approvedData[$y]['signature']."", "idcardsignature/".$approvedData[$y]['signature']."");
    }
    if(file_exists("images/".$approvedData[$y]['profile_image']."")){
 	   copy("images/".$approvedData[$y]['profile_image']."", "idcardimage/".$approvedData[$y]['profile_image']."");
    }
}
if(isset($_POST['exportcard'])){
  if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
    if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
    //print_r($admin_id);
    $query = "SELECT users.name,users.fname,users.mname,users.email,users.branch, users.employee_ID,id_card.signature,users.profile_image,id_card.status,id_card.date_created,id_card.staff_id,id_card.IID as request_id FROM id_card LEFT JOIN users ON users.id = id_card.staff_id WHERE (id_card.admin_id = '".$_SESSION['user']['id']."' AND users.id = id_card.staff_id AND users.active = '1' AND id_card.status = 'Approved') ORDER BY id_card.IID DESC";
    $productResult = mysqli_query($conn, $query);
    $filename = "Export_excel_directory.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    if(mysqli_num_rows($productResult)> 0){
      foreach ($productResult as $row) {
         if((float)strtotime($row['date_created']) > (float)strtotime('2019-06-18')){  
        if (! $isPrintHeader) {
            echo implode("\t", array_keys($row)) . "\n";
            $isPrintHeader = true;
        }
        echo implode("\t", array_values($row)) . "\n";
       }  
      }
    }else {}
}
  if(isset($_POST['search'])){
      //return false;
  $id_request = [];
    $search = mysqli_real_escape_string($conn, $_POST['find']);
    $query = "SELECT users.name,users.fname,users.mname,users.profile_image,id_card.signature, users.employee_ID,id_card.signature,id_card.status,id_card.date_created,id_card.staff_id,id_card.IID as request_id FROM id_card INNER JOIN users ON users.id = id_card.staff_id WHERE users.employee_ID = '".$search."' ORDER BY id_card.IID DESC";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
       while($row = mysqli_fetch_assoc($result)) {
            $id_request[] = $row;
       }
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
                <h3>ID Card Request</h3>
              </div>

              <div class="title_right">
                <div class="col-md-8 col-sm-7 col-xs-12 form-group pull-right top_search">
                  <form method="POST" action="view_all_id_request.php">
                    <div class="input-group">
                      <input type="text" class="form-control" name = "find" placeholder="Search by ID or Company">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="submit" name="search">Go!</button>
                      </span>
                    </div>
                  </form>
                  <form method="POST" action="view_all_id_request.php">
                  <div class="btn-group" role="group" aria-label="Basic example">

                    <button type="submit" name = "decline" class="btn btn-success" style=background-color:'#73879C'>Declined</button>
                    <button type="submit" name = "treated" class="btn btn-warning">Approved</button>
                    <button type="submit" name="pending" class="btn btn-primary" style=background-color:'#73879C'>Pending</button>
                    <button type="submit" id="btnExport"
                                name='exportcard' value="Export to Excel"
                                class="btn btn-info">Export to Excel</button>
                    <button type="submit" id=""
                                name='copydata' value="Export to Excel"
                                class="btn btn-info" style='display:none'>Copy Data</button>            
                  </div>
                </form>
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
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>View Status</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php if(count($id_request) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title text-center">S/N</th>
                            <!--th class="column-title text-center">Staff ID(IID)</th-->
                            <th class="column-title text-center">Name</th>
                            <th class="column-title text-center">First Name</th>
                            <!--th class="column-title text-center">Middle Name</th-->
                            <th class="column-title text-center">Passport </th>
                            <th class="column-title text-center">Signature </th>
                            <!--th class="column-title text-center">Signature </th-->
                            <th class="column-title text-center">Employee ID </th>
                            
                            <th class="column-title text-center">Status</th>
                            <th class="column-title text-center">More</th>
                            <th class="column-title text-center">Approve</th>
                            <th class="column-title text-center">Decline</th>
                            <th class="column-title text-center">Delete</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($id_request); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center text-center">
                              <?=$h + 1?>
                            </td>
                            <!--td class="a-center text-center">
                              <?=$id_request[$h]['staff_id']?>(<?=$id_request[$h]['request_id']?>)
                            </td-->
                            <td class="text-center"><?=$id_request[$h]['name']?></td>
                            <td class="text-center"><?=$id_request[$h]['fname']?></td>
                            <!--td class="text-center"><?=$id_request[$h]['mname']?></td-->
                            
                            <td class="text-center"><img src = "images/<?=$id_request[$h]['profile_image']?>" style = "width: 60px;height:40px;"></td>
                            <td class="text-center"><img src = "document/signature/<?=$id_request[$h]['signature']?>" style = "width: 60px;height:40px;"><?=$id_request[$h]['signature']?></td>
                            <!--td class="text-center"><?=$id_request[$h]['signature']?> <?=$id_request[$h]['staff_id']?></td-->
                            <td class="text-center"><?=$id_request[$h]['employee_ID']?></td>
                            <td class="text-center"><?=$id_request[$h]['status']?></td>
                            <td class="text-center">
                              <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="see_more_information_on_idrequest.php/?staff_id=<?=base64_encode($id_request[$h]['staff_id'])?>&request_id=<?=base64_encode($id_request[$h]['request_id'])?>" class="btn btn-warning btn-sm">Details</a>
                              </div>
                            </td>
                            <td class="text-center">
                              <div class="btn-group" role="group" aria-label="Basic example">
                                     <form action = 'process_id_request.php' method ='POST'>
                                         <input style='display:none;' name = 'name' value = '<?=$id_request[$h]['name']?>'/>
                                         <input style='display:none;' name = 'email' value = '<?=$id_request[$h]['email']?>'/>
                                         <input style='display:none;' name = 'request_id' value = '<?=$id_request[$h]['request_id']?>'/> 
                                         <button type ='submit' name='approved' class = 'btn btn-sm btn-success'>Approve</button>
                                     </form>
                                
                              </div>
                            </td>
                            
                            <td class="text-center">
                              <div class="btn-group" role="group" aria-label="Basic example">
                                     <a class="btn btn-info btn-sm comment" id ="comment<?=$id_request[$h]['request_id']?>" name = "<?=$id_request[$h]['name']?>" email ="<?=$id_request[$h]['email']?>" request_id = "<?=$id_request[$h]['request_id']?>" signature = "<?=$id_request[$h]['signature']?>" data-toggle="modal" data-target="#myComment">Decline</a>
                                
                              </div>
                            </td>
                            <td class="text-center">
                              <div class="btn-group" role="group" aria-label="Basic example">
                                     <form action = 'process_id_request.php' method ='POST'>
                                         <input style='display:none' name = 'request_id' value = '<?=$id_request[$h]['request_id']?>'/>
                                         <input style='display:none' name = 'signature' value = '<?=$id_request[$h]['signature']?>'/>
                                         <button type ='submit' name='delete' class = 'btn btn-sm btn-danger'>Delete</button>
                                     </form>
                                
                              </div>
                            </td>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php } else { ?>
                       You have pending request
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
              <input type="text" value ='Decline' name="remark" class="form-control" />
              <!--select name="remark" class="form-control">
                <option value=""></option>
                <option value="Approved">Approved</option>
                <option value="Decline">Decline</option>
                <option value="Pending">Pending</option>
              </select-->
           </div>
           <div class="form-group">
            <label>Comment</label>
           <textarea class="form-control" rows="4" id ="save_comment" name = "comment" style="margin-bottom: 10px;"></textarea>
           </div>
           <input type="text" name="id_card_request_id" id = "request_id" style="display:none" />
           <input type="text" name="signature" id = "signature" style="display:none" />
           <input type="text" name="name" id = "name" style="display:none" />
           <input type="text" name="email" id = "email" style="display:none" />
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
      $("#email").val($("#"+this.id+"").attr("email"));
      $("#name").val($("#"+this.id+"").attr("name"));
      $("#signature").val($("#"+this.id+"").attr("signature"));
      //$("#save_comment").val(comment);
    });
  })
</script>

        
