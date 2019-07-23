<?php 
include 'connection.php';
session_start();
$data_branch = [];
$admin_id;
if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
else if($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
$query = "SELECT * FROM branches WHERE admin_id = '".$admin_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $data_branch[] = $row;
  }
}
?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Add Department</h3>
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
                      <h2>Item<small>add new Item</small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form action="process_adddept.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
  
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Department Name <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="text" name="name" class="form-control col-md-7 col-xs-12" required="required" type="text" value = "<?=isset($_SESSION['department']) ? $_SESSION['department'][0]['dept']: ''?>">
                          </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Branch Name<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="branch_id" class="form-control">
                                      <option value = "<?=isset($_SESSION['department']) ? $_SESSION['department'][0]['id']: ''?>"><?=isset($_SESSION['department']) ? $_SESSION['department'][0]['name']: ''?></option>
                                      <?php for ($d = 0; $d < count($data_branch);$d++) {?>
                                      <option value="<?=$data_branch[$d]['id']?>"><?=$data_branch[$d]['name']?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group" style="display: none;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Department ID<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="text" name="dept_id" class="form-control col-md-7 col-xs-12"  type="text"><?=isset($_SESSION['department']) ? $_SESSION['department'][0]['id']: ''?></textarea>
                                </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="button">Cancel</button>
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <button type="submit" name="<?= isset($_SESSION['department']) ? 'update' : 'submit'?>" class="btn btn-success"><?= isset($_SESSION['department']) ? 'Update' : 'Submit'?></button>
                          </div>
                        </div>
  
                      </form>
                    </div>
                  </div>
                </div>
        </div>
</div>
</div>
<?php unset($_SESSION['department'])?>
<?php include "footer.php"?>
        
