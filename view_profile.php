<?php 
include 'connection.php';
 session_start();
 $msg = '';
 $personal_information = [];
 $qualification = [];
 $workexperience = [];
 $certifications = [];
$_id = $_SESSION['staff_id']; 
//echo $_SESSION['user']['admin_id'];
$query = "SELECT * FROM personal_information WHERE admin_id = '".$_SESSION['user']['id']."' AND staff_id = '".$_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
   while($row = mysqli_fetch_assoc($result)) {
        $personal_information[] = $row;
   }
}
$query_qual = "SELECT * FROM qualifications WHERE admin_id = '".$_SESSION['user']['id']."' AND staff_id = '".$_id."'";
$result_qual = mysqli_query($conn, $query_qual);
if(mysqli_num_rows($result) > 0){
   while($row = mysqli_fetch_assoc($result_qual)) {
        $qualification[] = $row;
   }
}
$query_exp = "SELECT * FROM workexperience WHERE admin_id = '".$_SESSION['user']['id']."' AND staff_id = '".$_id."'";
$result_exp = mysqli_query($conn, $query_exp);
if(mysqli_num_rows($result) > 0){
   while($row = mysqli_fetch_assoc($result_exp)) {
        $workexperience[] = $row;
   }
}
$query_cert = "SELECT * FROM certifications WHERE admin_id = '".$_SESSION['user']['id']."' AND staff_id = '".$_id."'";
$result_cert = mysqli_query($conn, $query_cert);
if(mysqli_num_rows($result) > 0){
   while($row = mysqli_fetch_assoc($result_cert)) {
        $certifications[] = $row;
   }
}
?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Employee Information</h3>
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
            <li class="active"><a data-toggle="tab" href="#home">Personal Information</a></li>
            <li><a data-toggle="tab" href="#menu2">Qualifications</a></li>
            <li><a data-toggle="tab" href="#menu3">Work Experience</a></li>
            <li><a data-toggle="tab" href="#menu4">Professional Certifications</a></li>
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
                                      <h2>Personal Information<small></small></h2>
                                      <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                          <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Settings 1</a>
                                            </li>
                                            <li><a href="#">Settings 2</a>
                                            </li>
                                          </ul>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                      </ul>
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
                                                            <td><?=$personal_information[0]['surname']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">First Name</td>
                                                            <td><?=$personal_information[0]['firstname']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Middle Name</td>
                                                            <td><?=$personal_information[0]['middlename']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Gender</td>
                                                            <td><?=$personal_information[0]['gender']?></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td class="">Date of Birth</td>
                                                            <td><?=$personal_information[0]['DOB']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Town</td>
                                                            <td><?=$personal_information[0]['town']?></td>
                                                        </tr>
                                                        <tr>
                                                                <td class="">State</td>
                                                                <td><?=$personal_information[0]['state']?></td>
                                                        </tr>
                                                        <tr>
                                                                <td class="">Country</td>
                                                                <td><?=$personal_information[0]['country']?></td>
                                                        </tr>
                                                    </thead>
                                    
                                                </table>
                                        </div>
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
                    <h2>Qualifications</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($qualification) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title">Qualification</th>
                            <th class="column-title">Grade </th>
                            <th class="column-title">Institution </th>
                            <th class="column-title">Course of Study </th>
                            <th class="column-title">Specialization </th>
                            <th class="column-title">Date Obtained </th>
                            <th class="column-title">Document</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($qualification); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$qualification[$h]['qualification_name']?></td>
                            <td class=" "><?=$qualification[$h]['grade']?></td>
                            <td class=" "><?=$qualification[$h]['institution']?></td>
                            <td class=" "><?=$qualification[$h]['course_of_study']?></td>
                            <td class=" "><?=$qualification[$h]['specialization']?></td>
                            <td class=" "><?=$qualification[$h]['date_obtained']?></td>
                            <td class=" "><a href="downloadfile.php/?to=xxx&filename=<?=$qualification[$h]['document']?>" class="btn btn-sm btn-success">Download</a></td>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php } else { ?>
                       You have no added any qualification
                    <?php } ?>
                  </div>
                </div>
                </div> 
            </div>
            </div>
            <div id="menu3" class="tab-pane fade">
             <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Experience</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($workexperience) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title">Place of Work</th>
                            <th class="column-title">From (Date) </th>
                            <th class="column-title">To (Date) </th>
                            <th class="column-title">Town </th>
                            <th class="column-title">Address </th>
                            <th class="column-title">Position</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($workexperience); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$workexperience[$h]['company_name']?></td>
                            <td class=" "><?=$workexperience[$h]['work_from']?></td>
                            <td class=" "><?=$workexperience[$h]['work_to']?></td>
                            <td class=" "><?=$workexperience[$h]['town']?></td>
                            <td class=" "><?=$workexperience[$h]['address']?></td>
                            <td class=" "><?=$workexperience[$h]['position']?></td>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php } else { ?>
                       You have not added any work experience
                    <?php } ?>
                  </div>
                </div>
            </div>    
            </div>
            </div>
            <div id="menu4" class="tab-pane fade">
             <div class="row">
                 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Professional Certifications</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <?php if(count($certifications) > 0 ){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">S/N</th>
                            <th class="column-title">Name</th>
                            <th class="column-title">Date Certified </th>
                            <th class="column-title">Document</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php for ($h = 0; $h < count($certifications); $h++) {?>
                          <tr class="pointer">
                            <td class="a-center ">
                              <?=$h + 1?>
                            </td>
                            <td class=""><?=$certifications[$h]['certification_name']?></td>
                            <td class=" "><?=$certifications[$h]['date_cert']?></td>
                            <td class=" "><a href="downloadfile.php/?to=xxx&filename=<?=$certifications[$h]['document']?>" class="btn btn-sm btn-success">Download</a></td>
                           <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php } else { ?>
                       You have not added any professional Certification
                    <?php } ?>
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
        
