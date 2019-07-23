<?php 
include 'connection.php';
session_start();
$kss = [];
$msg = '';
if($_SESSION['user']['email'] == '') $msg .= '<p>Email Address, '; 
if($_SESSION['user']['gender'] == '') $msg .= 'Gender, '; 
if($_SESSION['user']['phone_number'] == '') $msg .= 'Phone Number,';
if($_SESSION['user']['branch'] == '') $msg .= ' Branch, ';
if($_SESSION['user']['name'] == '') $msg .= ' Surname, ';
if($_SESSION['user']['fname'] == '') $msg .= ' First Name, ';
if($_SESSION['user']['mname'] == '') $msg .= ' Middle Name, ';
if($_SESSION['user']['marital_status'] == '') $msg .= 'Marital Status, ';
if($_SESSION['user']['dob'] == '') $msg .= 'Date of Birth, ';
if($_SESSION['user']['department'] == '') $msg .= 'Department, ';
if($_SESSION['user']['role'] == '') $msg .= 'Role, ';
if($_SESSION['user']['lga'] == '') $msg .= 'Local Government Area, ';
if($_SESSION['user']['sorigin'] == '') $msg .= ' State of Origin, '; 
if($_SESSION['user']['address'] == '') $msg .= 'Address, ';
if($_SESSION['user']['cdate_of_employeement'] == '') $msg .= 'Date of Employment, ';

if($_SESSION['user']['leave_flow'] == '') $msg .= 'Leave Approvers';

if($_SESSION['user']['name'] == ''){
   $_SESSION['msg'] = "";
  $_SESSION['msg'] .= "<p>Name field is empty</p>";
}
if($_SESSION['user']['employee_ID'] == ''){
  $_SESSION['msg'] .= "<p>Employee ID field is empty</p>";
  $msg = "To update your profile, <a href = 'staff_settings.php'>click here</a>";
  $_SESSION['msg'] .= $msg;
}
 if(!isset($_SESSION['user']['id'])) header("Location: login.php");
 if($_SESSION['user']['category'] == 'staff') $admin_id = $_SESSION['user']['admin_id'];
 else if ($_SESSION['user']['category'] == 'admin') $admin_id = $_SESSION['user']['id'];
  $query = "SELECT kss.information,users.name,users.employee_ID FROM kss INNER JOIN users ON kss.staff_id = users.id WHERE kss.admin_id = '".$admin_id."'ORDER BY kss.id LIMIT 1";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $kss[] = $row;
      }
  }
?>
<?php include "header.php"?>
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>ID Card Request</h3>
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
                <?php if($msg != '') {?>
                <div class="alert alert-primary" style="background-color: red;color:#fff;line-height:5px;" role="alert" >
                        <h4>The following information are required before you can request for ID Card:</h4> <b><?=$msg?></b> <a href = 'staff_settings.php' style='margin-top:7px;' class = "btn btn-info">Click here to Update</a>
                        <p> </p>
                </div>
                <?php  } ?>
                <?php if(isset($_SESSION['msg']) && $_SESSION['user']['category'] == 'staff') {?>
                        <div class="alert alert-primary" style="background-color: #007bff;font-size:16px;color:#fff" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                <?php } ?>
                <!--div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                    Kindly Confirm the your information carefully, as this will be captured in your ID Card.
                </div-->
                <?php if($_SESSION['user']['fname'] == '' || $_SESSION['user']['name'] == '' || $_SESSION['user']['branch'] == '' || $_SESSION['user']['profile_image'] == 'user_profile.png') {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            <?=$_SESSION['user']['fname'] == '' ? '<p>Your First Name is not Captured</p>':''?>
                            <?=$_SESSION['user']['name'] == '' ? '<p>Your Surname Name is not Captured</p>':''?>
                            <?=$_SESSION['user']['branch'] == '' ? '<p>Branch Address is not Captured</p>':''?>
                            <?=$_SESSION['user']['profile_image'] == 'user_profile.png' ? '<p>Passport is not Captured</p>':''?>
                            <p><a href ="staff_settings.php">Click on this link to update your information Click Here</a></p>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                <?php } ?>
              <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Request for ID Card</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form action="process_idcard_request.php" method="POST" enctype="multipart/form-data">
                     <input type="file" name="signature" onchange="readURL(this)" id = "signature" style="display: none;">
                     
                     <div class="form-group" >
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" style="margin-bottom: 10px;">
                              <label>First Name</label>    
                              <input class="form-control" disabled placeholder="first name" name="first name" value = "<?=isset($_SESSION['user']['fname']) ? $_SESSION['user']['fname'] : ''?>"/>
                            </div>
                    </div>
                    <div class="form-group" >
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" style="margin-bottom: 10px;">
                              <label>SurName</label>    
                              <input class="form-control" disabled value = "<?=isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : ''?>" placeholder="Surname" name="Sur name"/>
                            </div>
                    </div>
                    <div class="form-group" >
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" style="margin-bottom: 10px;">
                              <label>Branch</label>    
                              <input class="form-control" disabled value = "<?=isset($_SESSION['user']['branch']) ? $_SESSION['user']['branch'] : ''?>" placeholder="branch" name="Branch"/>
                            </div>
                    </div>
                    <div class="form-group" >
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" style="margin-bottom: 10px;">
                              <label>Company</label>    
                              <input class="form-control" disabled value = "<?=isset($_SESSION['user']['user_company']) ? $_SESSION['user']['user_company'] : ''?>" placeholder="company Name" name="Company Name"/>
                            </div>
                    </div>
                    <div class="form-group" >
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" style="margin-bottom: 10px;">
                              <label>Passport</label>   <hr style = 'margin-top:-5px;'/> 
                              <div class="text-center" style="margin-bottom: 20px;">
                                   <img class="" src="images/<?=$_SESSION['user']['profile_image']?>" alt="" style="width: 100px;height: 70px;">
                                   <a href ='staff_settings.php' class="btn btn-warning btn-sm">upload passport</a><span style ='color:red'> max of 2MB</span>
                                 </div>
                            </div>
                    </div>
                    <div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" style="margin-bottom: 10px;">
                              <label>Upload Signature</label> <button class="btn btn-warning btn-sm" type="button" id = "open_file">Browse Signature</button><span style ='color:red'> max of 2MB</span><hr style = 'margin-top:-5px;'/>
                        <div class="text-center" style="margin-bottom: 20px;">
                           <img class="uploadimg" src="images/signature.png" alt="" style="width: 100px;height: 40px;">
                         </div>
                         </div>
                    </div>
                     <div class="form-group" style = "display:none;">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" style="margin-bottom: 10px;">
                              <textarea class="form-control" placeholder="justification" value ="justification" name="justification"></textarea>
                            </div>
                    </div>
                     <div class="form-group" style="margin-top: 10px;">
                          <div class="col-md-8 col-sm-6 col-xs-12 col-md-offset-3">
                            
                            <button type="submit" name="submit" class="btn btn-success">Submit Request</button>
                          </div>
                     </div>
                   </form>
                  </div>
                </div>
              </div>
              <!--div class="col-md-4 col-sm-12 col-xs-12">
                  <div class="x_panel">
                  <div class="x_title">
                    <h2>KSS shared by (<span style="font-size: 13px;"><?=isset($kss[0]['name']) ? $kss[0]['name'] : 'None'?></span>)</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php if(count($kss) > 0) {?>
                    <p style="text-align: justify;"><?=$kss[0]['information']?></p>
                    <?php }else { ?>
                      <p style="text-align: justify;">No Information shared</p>
                    <?php } ?>  
                  </div>
                </div>
              </div-->
              <div class="col-md-4 col-sm-12 col-xs-12">
                
              </div>
            </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
<?php include "footer.php"?>
<script type="text/javascript" src="js/appraisal.js"></script>
<script type="text/javascript">
  function readURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        $('.uploadimg')
            .attr('src', e.target.result)
            .width(100)
            .height(100);
      };
      reader.readAsDataURL(input.files[0]);
     }
    }
  $(function(){
    $("#open_file").on("click", function(e){
      $("#signature").trigger("click");
    });
  })
</script>
        
