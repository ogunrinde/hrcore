<?php 
include 'connection.php';
session_start();
$kss = [];
$admin_id;
$users = [];
 if(!isset($_SESSION['user']['id'])) header("Location: login.php");
 if($_SESSION['user']['category'] == 'staff') header("Location: dashboard.php");
 if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
 else if ($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT kss.information,users.name,users.employee_ID FROM kss INNER JOIN users ON kss.staff_id = users.id WHERE kss.admin_id = '".$admin_id."'ORDER BY kss.id LIMIT 1";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $kss[] = $row;
      }
  }
 if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
 else if ($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT * FROM users WHERE admin_id = '".$admin_id."' LIMIT 100";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
      }
  }
   if(isset($_POST['search'])){
      $users = [];
      $query = "SELECT * from users where employee_ID = '".trim($_POST['emp_ID'])."'";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
      }
    }
    //print_r($users);
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
                <h3>STAFF DIRECTORY</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <form method="POST" action="staff_directory.php">
                    <div class="input-group">
                      <input type="text" class="form-control" name = "emp_ID" placeholder="Search by ID">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="submit" name="search">Go!</button>
                      </span>
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
                    <h2>Staffs Information</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li>
                      <form action="process_file.php" method="post">
                            <input type="text" name="which" value = "directory" style="display: none;">
                            <button type="submit" id="btnExport"
                                name='export' value="Export to Excel"
                                class="btn btn-info">Export to Excel</button>
                        </form>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title">Name</th>
                            <th class="column-title">Employee ID </th>
                            <th class="column-title">Department</th>
                            <th class="column-title">Gender</th>
                            <th class="column-title">Password</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($users); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$users[$h]['fname']?> <?=$users[$h]['mname']?> <?=$users[$h]['name']?></td>
                            <td class=" "><?=$users[$h]['employee_ID']?></td>
                            <td class=" "><?=$users[$h]['department']?></td>
                            <td class=" "><?=$users[$h]['gender']?></td>
                            <td class=" "><?=$users[$h]['cpassword']?></td>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
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
        
