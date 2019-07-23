<?php 
include 'connection.php';
session_start();
$data_branch = [];
$admin_id;
$all_branch = [];
if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
$query = "SELECT * FROM branches WHERE admin_id = '".$admin_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
      $all_branch[] = $row;
    if($row['branch_id'] == '')
       $data_branch[] = $row;
  }
}
?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Manage Branch</h3>
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
                    <h2>Branch</h2>
                    <ul class="nav navbar-right panel_toolbox">
                       <?php if($_SESSION['user']['category'] == 'admin') {?>
                        <li><a href ="addbranch.php" class="btn btn-success btn-sm" style="color: #fff;">Add Branch</a></li>
                      
                      <li>
                      <form action="process_file.php" method="post">
                            <input type="text" name="which" value = "branch" style="display: none;">
                            <button type="submit" id="btnExport"
                                name='export' value="Export to Excel"
                                class="btn btn-info">Export to Excel</button>
                        </form>
                      </li>
                      <?php  } ?>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($data_branch) > 0) {?>  
                    <div class="table-responsive">
                      
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title text-center">S/N </th>
                            <th class="column-title text-center">Branch Name </th>
                            <th class="column-title text-center">Address </th>
                            <th class="column-title text-center">Phone Number </th>
                            <th class="column-title text-center">Email </th>
                            <th class="column-title text-center">Option </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php if(count($data_branch) > 0) {?>
                          <?php for ($h = 0; $h < count($data_branch); $h++) {?>
                            
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class="text-center"><?=$data_branch[$h]['name']?></td>
                            <td class="text-center"><?=$data_branch[$h]['address']?></td>
                            <td class="text-center"><?=$data_branch[$h]['phone_number']?></td>
                            <td class="text-center"><?=$data_branch[$h]['email']?></td>
                            <td class="text-center">
                              <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-warning btn-sm" href="editbranch.php/?id=<?=base64_encode($data_branch[$h]['id'])?>">Edit</a>
                                <button class="btn btn-primary btn-sm show_id" attr_id = "<?=$data_branch[$h]['id']?>"  id ='show_id<?=$h?>' data-toggle="modal" data-target="#subModal">view sub branch</button>
                              </div>
                            </td>
                          </tr>
                          <?php } } ?>
                        </tbody>
                      </table>
                    </div>
                  <?php }else { ?>
                    <p>No branch added</p>
                  <?php } ?> 
                  </div>
                </div>
              </div>    
             
        </div>
</div>
</div>
<div class="modal fade" id="subModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Sub Branch</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <table class="table table-striped jambo_table bulk_action">
            <thead>
              <tr class="headings">
                <!--th class="column-title text-center">S/N </th-->
                <th class="column-title text-center">Branch Name </th>
                <th class="column-title text-center">Address </th>
                <th class="column-title text-center">Phone Number </th>
                <th class="column-title text-center">Email </th>
              </tr>
            </thead>

            <tbody class="listsubbranch">
              
            </tbody>
          </table>
      </div>
      
    </div>
  </div>
</div>
<?php include "footer.php"?>

<script type="text/javascript">
   $(function(){
     $('.show_id').on('click', function(e){
       e.preventDefault();
       //alert('aa');
       $('.listsubbranch').html('');
       let branchid = $('#'+this.id+'').attr('attr_id');
       let data = <?php echo json_encode($all_branch); ?>;
       //alert(data.length);
       let a = 1;
       for(let r = 0; r < data.length; r++){
        //alert(data[0]['id']);
         if(branchid == data[r]['branch_id']){
          //alert('as');
            a++;
            $('.listsubbranch').append("<tr><td class='text-center'>"+data[r]['name']+"</td><td class='text-center'>"+data[r]['address']+"</td><td class='text-center'>"+data[r]['phone_number']+"</td><td class='text-center'>"+data[r]['email']+"</td></tr>");
         }
       }
       //console.log(data);
     })
   })
</script>
        
