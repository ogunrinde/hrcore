<?php 
include 'connection.php';
session_start();
$data_dept = [];
$admin_id;
if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
$query = "SELECT departments.dept,branches.name,departments.id FROM departments INNER JOIN branches ON branches.id = departments.branch_id WHERE departments.admin_id = '".$admin_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $data_dept[] = $row;
  }
}
?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Manage Department</h3>
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
                    <h2>Department</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a href ="adddepartment.php" class="btn btn-success btn-sm" style="color: #fff;">Add Department</a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($data_dept) > 0) {?>
                    <div class="table-responsive">
                      
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title text-center">S/N </th>
                            <th class="column-title text-center">Department Name </th>
                            <th class="column-title text-center">Branch Name </th>
                            <th class="column-title text-center">Option </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php if(count($data_dept) > 0) {?>
                          <?php for ($h = 0; $h < count($data_dept); $h++) {?>
                            
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class="text-center"><?=$data_dept[$h]['dept']?></td>
                            <td class="text-center"><?=$data_dept[$h]['name']?></td>
                            <td class="text-center">
                              <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-warning btn-sm" href="editdepartment.php/?id=<?=base64_encode($data_dept[$h]['id'])?>">Edit</a>
                                <button class="btn btn-primary btn-sm">Delete</button>
                              </div>
                            </td>
                          </tr>
                          <?php } }?>
                        </tbody>
                      </table>
                    </div>
                  <?php  } else {?>
                    <p>No department added</p>
                  <?php  } ?>  
                  </div>
                </div>
              </div>    
        </div>
</div>
</div>
<?php include "footer.php"?>
        
