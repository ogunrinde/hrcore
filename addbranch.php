<?php 
include 'connection.php';
session_start();
$dept = [];
if(!isset($_SESSION['user']['id']) || $_SESSION['user']['id'] == '') header("Location: /outsourcing/login.php");
$admin_id = $_SESSION['user']['id'];
if(isset($_POST['submit'])){
  $subbranch = mysqli_real_escape_string($conn, $_POST['branch']);
  $subbranchname = mysqli_real_escape_string($conn, $_POST['subbranchname']);
  $subbranchaddress = mysqli_real_escape_string($conn, $_POST['subbranchaddress']);
  $subbranchemail = mysqli_real_escape_string($conn, $_POST['subbranchemail']);
  $subbranchphone = mysqli_real_escape_string($conn, $_POST['subbranchphone']);

  $sql = "INSERT INTO branches (branch_name,name, phone_number, email, address, date_created, admin_id, insert_by,sub_branch)
  VALUES ('".$subbranch."','".$subbranchname."', '".$subbranchphone."', '".$subbranchemail."','".$subbranchaddress."','".date('Y-m-d')."', '".$admin_id."','".$_SESSION['user']['id']."','1')";
  if (mysqli_query($conn,$sql ) === TRUE) {
      $_SESSION['msg'] = "New sub branch added";
      //header("Location: /outsourcing/branch.php");
  } else {
      //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
     $_SESSION['msg'] = "Error updating data, kindly try again later";
     //header("Location: /outsourcing/addbranch.php");
  }
}

$query = "SELECT * from branches WHERE admin_id = '".$admin_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)> 0){
  while($row = mysqli_fetch_assoc($result)) {
    $branches[] = $row;
  }
}
?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Add Branch</h3>
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
                        <div class="alert alert-primary" style="color:#fff;background-color: #007bff;font-size: 14px;" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Add Branch<small></small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li>
                          <button type="submit" id=""
                                name='export' value=""
                                class="btn btn-info" data-toggle="modal" data-target="#subModal">Add Sub Branch</button>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form action="process_addbranch.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
  
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Branch Name <span class="required">*</span>
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
                                    <input id="text" name="email" class="form-control col-md-7 col-xs-12" required="required" type="email" value = "<?=isset($_SESSION['branch']) ? $_SESSION['branch'][0]['email']: ''?>">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="text" name="address" class="form-control col-md-7 col-xs-12" required="required" type="text"><?=isset($_SESSION['branch']) ? $_SESSION['branch'][0]['address']: ''?></textarea>
                                </div>
                        </div>
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
<div class="modal fade" id="subModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Sub branch</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action = 'addbranch.php' method = 'POST'>
              <div class="form-group">
                <label for="exampleInputEmail1">Branch</label>
                <select class="form-control" name='branch'>
                     <option value = ''></option>
                     <?php for ($r = 0; $r < count($branches); $r++) { ?>
                        <option value ='<?=$branches[$r]['id']?>'><?=$branches[$r]['name']?></option>
                     <?php  } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Sub Branch Name</label>
                <input type="text" name="subbranchname" class="form-control">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Sub Branch Address</label>
                <input type="text" name="subbranchaddress" class="form-control">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Sub Branch Email</label>
                <input type="email" name="subbranchemail" class="form-control">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Sub Branch Phone Number</label>
                <input type="number" name="subbranchphone" class="form-control">
              </div>

              
              <div class="modal-footer">
                <button type="submit" name ='submit' class="btn btn-primary">Create</button>
              </div>
            </form>
      </div>
      
    </div>
  </div>
</div>
<?php unset($_SESSION['branch'])?>
<?php include "footer.php"?>
        
