<?php 
include 'connection.php';
 session_start();
 $msg = '';
 $data = [];
 $show = false;
 $qualification = [];
// $_SESSION['user']['department'];
if($_SESSION['user']['category'] == 'staff'){
  $_id = $_SESSION['user']['id'];
  $query = "SELECT * FROM open_information_portal WHERE admin_id = '".$_SESSION['user']['admin_id']."' AND open_for = '".$_SESSION['user']['user_company']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) == 1){
    $row = mysqli_fetch_assoc($result);
     $data[] = $row;
     //print_r($data);
      if(strtotime(date('Y-m-d')) >= strtotime($data[0]['opening_date']) && strtotime($data[0]['closing_date']) > strtotime(date('Y-m-d'))){
        $show = true;
     }else {
        $show = false;
        $_SESSION['msg'] = 'You don\'t have permission to edit this document, wait still permission is granted by the admin';
     }
  }else {
    $show = false;         
    $_SESSION['msg'] = 'You don\'t have permission to edit this document, wait still permission is granted by the admin';
  }
}else if($_SESSION['user']['category'] == 'admin'){
  $_id = isset($_SESSION['staff_id_for_info']) ? $_SESSION['staff_id_for_info'] : '';
  $show = true;
}
//get user data
$query = "SELECT * FROM qualifications WHERE admin_id = '".$_SESSION['user']['admin_id']."' AND staff_id = '".$_id."'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
   while($row = mysqli_fetch_assoc($result)) {
        $qualification[] = $row;
   }
}

?>
<?php include "header.php"?>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Request Item</h3>
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
                    <h2>Qualifications</h2>
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
            <?php if($show == true) {?>  
             <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Add Qualifications<small></small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form action="process_qualification.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
  
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Qualification <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="text" name="qualification" class="form-control col-md-7 col-xs-12" required="required" type="text">
                          </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Grade <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                 <select name="grade" class="form-control">
                                   <option value=""></option>
                                   <option value="Distinction">Distinction</option>
                                   <option value="First Class">First Class</option>
                                   <option value="Second Class Upper">Second Class Upper</option>
                                   <option value="Second Class Lower">Second Class Lower</option>
                                   <option value="Third">Third Class</option>
                                   <option value="Pass">Pass</option>
                                 </select>
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Institution <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="text" name="institution" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Course of Study <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="text" name="course_of_study" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">specialization <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="text" name="specialization" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">date Obtained <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="text" name="date_obtained" class="form-control col-md-7 col-xs-12" required="required" type="date">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Upload document <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id = "upload_appraisal"><img style="width: 40px;height: 40px;" class="upload_qual_file" src="images/doc.png" alt=""></div>
                                    <span id = 'doc'></span>
                                    <input type="file" onchange="readURL(this)" name="file" id="qual_file" style="display: none;">
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
            <?php }?> 
        </div>
</div>
</div>
<?php include "footer.php"?>
<script type="text/javascript">
    $('.upload_qual_file').on('click', function(e){
     $('#qual_file').trigger('click');
    });
    function readURL(input) {
      if (input.files && input.files[0]) {
        $('#doc').text('1 doc added-'+input.files[0].name);
        $('.upload_qual_file')
            .attr('src', 'images/document.png')
            .width(100)
            .height(100);
      }
    }
</script>

        
