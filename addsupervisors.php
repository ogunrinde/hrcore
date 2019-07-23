<?php 
include 'connection.php';
session_start();
$dept = [];
$branch_data = [];
if(!isset($_SESSION['user']['id'])) header('Location:login.php');
$admin_id = $_SESSION['user']['id'];
$query = "SELECT * FROM branches WHERE admin_id = '".$admin_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $branch_data[] = $row;
  }
}
//print_r($branch);
?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Add Supervisor</h3>
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
                        <div class="alert alert-primary" style="color:#fff;background-color: #007bff;" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      Add Supervisor
                      <ul class="nav navbar-right panel_toolbox">
                        <li>
                          <a class="btn btn-info" href="supervisors.php" style="color:#fff;">Supervisors</a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form action="process_addsupervisor.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
  
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for=""> Name <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="text" name="name" class="form-control col-md-7 col-xs-12" required="required" type="text" value = "<?=isset($_SESSION['branch']) ? $_SESSION['branch'][0]['name']: ''?>">
                          </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Phone Number<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="phone_number" class="form-control col-md-7 col-xs-12" required="required" type="text" value = "<?=isset($_SESSION['branch']) ? $_SESSION['branch'][0]['phone_number']: ''?>">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="email" name="email" class="form-control col-md-7 col-xs-12" required="required" type="email" value = "<?=isset($_SESSION['branch']) ? $_SESSION['branch'][0]['email']: ''?>">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="text" name="address" class="form-control col-md-7 col-xs-12" required="required" type="text"><?=isset($_SESSION['branch']) ? $_SESSION['branch'][0]['address']: ''?></textarea>
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Branch<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name = 'branch' class ='form-control col-md-7 col-xs-12'>
                                        <option value = ''></option>
                                        <?php for ($g = 0; $g < count($branch_data); $g++)  { ?>
                                        <option value = '<?=isset($branch_data[$g]['name']) ? $branch_data[$g]['name'].'%'.$branch_data[$g]['id'] : ''?>'><?=$branch_data[$g]['name']?></option>
                                        <?php } ?>
                                    </select>
                                    
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Role<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name = 'role' class ='form-control col-md-7 col-xs-12'>
                                        <option value = ''></option>
                                        <option value = 'supervisor'>Supervisor</option>
                                        <option value = 'NBC'>NBC staff</option>
                                    </select>
                                    
                                </div>
                        </div>
                        <!--div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Login Password<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="password" name="password" class="form-control col-md-7 col-xs-12" required="required" type="number">
                                </div>
                        </div-->
                        <div class="form-group" style="display: none;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Branch ID<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="text" name="branch_id" class="form-control col-md-7 col-xs-12"  type="text"><?=isset($_SESSION['branch']) ? $_SESSION['branch'][0]['id']: ''?></textarea>
                                </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" name="<?= isset($_SESSION['branch']) ? 'update' : 'submit'?>" class="btn btn-success"><?= isset($_SESSION['branch']) ? 'Update' : 'Submit'?></button>
                          </div>
                        </div>
  
                      </form>
                    </div>
                  </div>
                </div>
        </div>
</div>
</div>
<?php unset($_SESSION['branch'])?>
<?php include "footer.php"?>
        
