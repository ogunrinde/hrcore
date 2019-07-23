<?php 
include 'connection.php';
 session_start();
 $msg = '';
 $personal_information = [];
//get user data
$query = "SELECT * FROM personal_information WHERE admin_id = '".$_SESSION['user']['admin_id']."' AND staff_id = '".$_SESSION['user']['id']."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
   while($row = mysqli_fetch_assoc($result)) {
        $personal_information[] = $row;
   }
}

?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Personal Information</h3>
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
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">UPDATE INFORMATION</a></li>
            <li><a data-toggle="tab" href="#menu2">VIEW</a></li>
          </ul>
        
          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
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
                              <h2><small>Personal Information</small></h2>
                              <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                              <br />
                              <form action="process_personal_information.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
          
                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Surname <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="surname" value="<?=isset($personal_information[0]['surname']) ? $personal_information[0]['surname'] : '' ?>" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                  </div>
                                </div>
                                <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span>*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <input id="text" name="firstname"  value="<?=isset($personal_information[0]['firstname']) ? $personal_information[0]['firstname'] : '' ?>" class="form-control col-md-7 col-xs-12" type="text">
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Middle Name <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <input id="text" name="middlename"  value="<?=isset($personal_information[0]['middlename']) ? $personal_information[0]['middlename'] : '' ?>" class="form-control col-md-7 col-xs-12" type="text">
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Gender <span class="">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select name="gender" class="form-control col-md-7 col-xs-12" id="">
                                                        <option value="<?=isset($personal_information[0]['gender']) ? $personal_information[0]['gender'] : '' ?>"><?=isset($personal_information[0]['gender']) ? $personal_information[0]['gender'] : '' ?></option>
                                                        <option value="Male">Male</option> 
                                                        <option value="Female">Female</option>  
                                                </select>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dob">Date of Birth <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <input id="text" name="dob" value="<?=isset($personal_information[0]['DOB']) ? $personal_information[0]['DOB'] : '' ?>" class="form-control col-md-7 col-xs-12" type="date">
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="town">Town <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input id="text" name="town"  value="<?=isset($personal_information[0]['town']) ? $personal_information[0]['town'] : '' ?>" class="date-picker form-control col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state">State <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input id="text" name="state"  value="<?=isset($personal_information[0]['state']) ? $personal_information[0]['state'] : '' ?>" class="form-control col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="country">Country <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <input id="text" name="country"  value="<?=isset($personal_information[0]['country']) ? $personal_information[0]['country'] : '' ?>" class="form-control col-md-7 col-xs-12" type="text">
                                        </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="button">Cancel</button>
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                  </div>
                                </div>
          
                              </form>
                            </div>
                          </div>
                        </div>
                </div>
            </div>
            <div id="menu2" class="tab-pane fade">
                    <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                  <div class="x_panel">
                                    <div class="x_title">
                                      <h2>Personal Information<small></small></h2>
                                      <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                      <br />
                                      <div class="row">
                                            <!--h2 class="text-danger">Approve User</h2-->
                                            
                                            
                                            <table class="table table-striped">
                                                    <thead>
                                                        <tr >
                                                            <td>Surname</td>
                                                            <td><?=isset($personal_information[0]['surname']) ? $personal_information[0]['surname'] : ''?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">First Name</td>
                                                            <td><?=isset($personal_information[0]['firstname']) ? $personal_information[0]['firstname'] : '' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Middle Name</td>
                                                            <td><?=isset($personal_information[0]['middlename']) ? $personal_information[0]['middlename'] : '' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Gender</td>
                                                            <td><?=isset($personal_information[0]['gender']) ? $personal_information[0]['gender'] : ''?></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td class="">Date of Birth</td>
                                                            <td><?=isset($personal_information[0]['DOB']) ? $personal_information[0]['DOB'] : ''?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Town</td>
                                                            <td><?=isset($personal_information[0]['town']) ? $personal_information[0]['town'] : ''?></td>
                                                        </tr>
                                                        <tr>
                                                                <td class="">State</td>
                                                                <td><?=isset($personal_information[0]['state']) ? $personal_information[0]['state'] : ''?></td>
                                                        </tr>
                                                        <tr>
                                                                <td class="">Country</td>
                                                                <td><?=isset($personal_information[0]['country']) ? $personal_information[0]['country'] : ''?></td>
                                                        </tr>
                                                    </thead>
                                    
                                                </table>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                        </div>
            </div>
          </div>
        </div>
</div>
</div>
<?php include "footer.php"?>
        
