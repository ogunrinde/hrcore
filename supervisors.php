<?php 
include 'connection.php';
session_start();
$data_branch = [];
$admin_id;
$users = [];
if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
$query = "SELECT * FROM branches WHERE admin_id = '".$admin_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $data_branch[] = $row;
  }
}

$query = "SELECT * FROM users WHERE admin_id = '".$admin_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
  }
}

?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Users</h3>
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
                        <li><a href ="branch.php" class="btn btn-primary btn-sm" style="color: #fff;">Add Branch</a>
                      </li>
                      <li><a href ="addsupervisors.php" class="btn btn-success btn-sm" style="color: #fff;">Add User</a>
                      </li>
                      <li>
                      <form action="process_file.php" method="post">
                            <input type="text" name="which" value = "branch" style="display: none;">
                            <button type="submit" id="btnExport"
                                name='export' value="Export to Excel"
                                class="btn btn-info">Export to Excel</button>
                        </form>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($users) > 0) {?>  
                    <div class="table-responsive">
                      
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title text-center">S/N </th>
                            <th class="column-title text-center">Name </th>
                            <th class="column-title text-center">Branch</th>
                            <th class="column-title text-center">Address </th>
                            <th class="column-title text-center">Phone Number </th>
                            <th class="column-title text-center">Email </th>
                            <th class="column-title text-center">Option </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php if(count($users) > 0) {?>
                          <?php for ($h = 0; $h < count($users); $h++) {?>
                            
                          <tr class="pointer">
                            <td class="a-center text-center">
                              <?=$h + 1?>
                            </td>
                            <td class="text-center"><?=$users[$h]['name']?></td>
                            <td class="text-center"><?=$users[$h]['branch']?></td>
                            <td class="text-center"><?=$users[$h]['address']?></td>
                            <td class="text-center"><?=$users[$h]['phone_number']?></td>
                            <td class="text-center"><?=$users[$h]['email']?></td>
                            <td class="text-center">
                              <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-warning btn-sm" href="editbranch.php/?id=<?=base64_encode($users[$h]['id'])?>">Edit</a>
                                <button class="btn btn-primary btn-sm">View Staff</button>
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
<?php include "footer.php"?>
        
