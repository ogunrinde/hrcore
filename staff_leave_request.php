<?php 
include 'connection.php';
session_start();
$dept = [];
$leave_type = [];
//print_r($_SESSION['user']);
  if(!isset($_SESSION['user']['id'])) header("Location: login.php");
  $query = "SELECT * FROM company WHERE admin_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $dept = explode(";",$row['department']);
      }
  }
  $query = "SELECT * FROM leave_type WHERE company = '".$_SESSION['user']['user_company']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $leave_type[] = $row;
      }
  }
  //print_r($leave_type);
   $msg = '';
if($_SESSION['user']['email'] == '') $msg .= '<p>Email Address, '; 
if($_SESSION['user']['gender'] == '') $msg .= 'Gender, '; 
if($_SESSION['user']['phone_number'] == '') $msg .= 'Phone Number,';
if($_SESSION['user']['branch'] == '') $msg .= ' Branch, ';
if(strtolower($_SESSION['user']['branch']) == 'not updated') $msg .= ' Branch, ';
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
if($_SESSION['user']['leave_flow'] == '') $msg .= 'Manager Details' ;
if($_SESSION['user']['leave_flow'] != ''){
    $manager_count = explode(';',$_SESSION['user']['leave_flow']);
    if(count($manager_count) < 2) $msg .= 'Two Approvals are required';
}
?>
<?php include "header.php"?>
 <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css" rel="stylesheet" type="text/css">
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
            <h3>Leave Request</h3>
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
                        <h4>The following information are required before you can request for leave:</h4> <b><?=$msg?></b> <a href = 'staff_settings.php' style='margin-top:10px;' class = "btn btn-info">Click here to Update</a>
                        <p> </p>
                </div>
                <?php  } ?>
                <div class="alert alert-primary msgtouser hide" style="background-color: #007bff;font-size:16px;color:#fff;" role="alert" >
                        <?=$_SESSION['msg']?>
                </div>
                <?php if($_SESSION['user']['gender'] == '' && $msg == '') {?>
                    <div class="alert alert-primary" style="background-color: #007bff;font-size:16px;color:#fff" role="alert" >
                         To apply for maternity leave, kindly update your employment record and specify your Gender. 
                </div>
                <?php  } ?>
                <?php if(isset($_SESSION['msg'])) {?>
                    <div class="alert alert-primary" style="background-color: #007bff;font-size:16px;color:#fff;" role="alert">
                        <?=$_SESSION['msg']?>
                    </div>
                <?php unset($_SESSION['msg']); ?>
                <?php } ?>
                <?php if(isset($_SESSION['user']) && $_SESSION['user']['leave_flow'] == '') {?>
                        <div class="alert alert-primary" style="background-color: #007bff;font-size:16px;color:#fff" role="alert">
                            You can not process leave request, because you don't have approvals. Kindly add leave approvals on the setting page
                        </div>
                  <?php } ?>     
                <div class="col-md-8 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Leave Application<small>Complete the form below</small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form action="process_leave_request.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
  
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_type">Leave Type <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="leave_type" class="form-control col-md-7 col-xs-12">
                              <option value=""></option>
                               <?php if(count($leave_type) > 0){ ?>
                                <?php for($r = 0; $r < count($leave_type);$r++){ ?>
                                <?php if($leave_type[$r]['leave_kind'] != 'Maternity' ) {?>
                                <option value="<?=$leave_type[$r]['leave_kind']?>"><?=$leave_type[$r]['leave_kind']?></option>
                                <?php  } ?>
                               <?php if($_SESSION['user']['gender'] == 'Female' &&  $leave_type[$r]['leave_kind'] == 'Maternity') {?>
                               <option value="Maternity">Maternity</option>
                               <?php  } ?>
                               <?php  } }else { ?>
                                <option value="Sick">Sick</option>
                               <option value="Annual">Annual</option>
                               <option value="Casual">Casual</option>
                               <option value="Compassionate">Compassionate</option>
                               <?php if($_SESSION['user']['gender'] == 'Female') {?>
                               <option value="Maternity">Maternity</option>
                               <?php  } ?>
                               
                               <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Start Date <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="date" id="start_date" name="start_date" required="required" value = "<?=date('Y-m-d')?>" class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="end_date" class="control-label col-md-3 col-sm-3 col-xs-12">End Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="end_date" class="form-control col-md-7 col-xs-12" type="date" required="required" value = "<?=date('Y-m-d')?>" name="end_date">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="leave_days" class="control-label col-md-3 col-sm-3 col-xs-12">Leave Days</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="leave_day" class="form-control col-md-7 col-xs-12" type="number" readonly = 'true' name="leave_day">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="resumption_date" class="control-label col-md-3 col-sm-3 col-xs-12">Resumption Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <p class="form-control col-md-7 col-xs-12" id="resumptionDate"></p>
                            
                          </div>
                        </div>
                        <div class="form-group">
                                <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Justification</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="" class="form-control col-md-7 col-xs-12" type="text" name="justification">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Reliever Required</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select name="reliever_required" class="form-control col-md-7 col-xs-12">
                                    <option value=""></option>
                                     <option value="Yes">Yes</option>
                                     <option value="No">No</option>
                                  </select>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Reliever Source</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select name="reliever_source" class="form-control col-md-7 col-xs-12">
                                    <option value = "">
                                        
                                     </option>
                                     <option value = "ICS">
                                        ICS
                                     </option>
                                     <option value = "Internally Outsourced">
                                        Internally Outsourced
                                     </option>
                                  </select>
                                  
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Reliever Name</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="" class="form-control col-md-7 col-xs-12" type="text" name="reliever_name">
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Reliever Email</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="" class="form-control col-md-7 col-xs-12" type="email" name="reliever_email">
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Reliever Phone</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="reliever_phone">
                                </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                          </div>
                        </div>
  
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Leave Type</h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <div class="table-responsive">
                      
                      <table class="table table-striped">
                      <tbody>
                        <?php for ($r = 0; $r < count($leave_type); $r++) { ?>
                        <tr>
                             <td scope="row"><?=$leave_type[$r]['leave_kind']?></td>
                             <td><?=$leave_type[$r]['days']?> </td>
                        </tr>
                       <?php  } ?>
                      </tbody>
                    </table>
                    </div>
                    </div>
                  </div>
                </div>
        </div>
</div>
</div>
<?php include "footer.php"?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
<script type="text/javascript">
  //getDaysMinusWeekend(startDay, startMonth, startYear, endDay, endMonth, endYear);
   function getDaysMinusWeekend (start_date,end_date) {
    let counter = 0;
    var start_date = new Date(start_date);
    var end_date = new Date(end_date);
    //alert(start_date);
      while(start_date.getTime() <= end_date.getTime()) {
        if(start_date.getDay()<6 && start_date.getDay() > 0) {
          //console.log(start_date.getDay());
            counter++;
        }
        start_date.setDate(start_date.getDate()+1);
      }
       $("#leave_day").val(counter);
       if(counter == 0){
           Swal.fire({
              type: 'Error',
              title: 'Oops...',
              text: 'Kindly select the appropriate start Date and End Date',
              footer: 'Please ensure that Saturday and Sunday are not selected as start Date or End Date'
            });
       }
       return counter;
   }
   function resumptionDate(end_date) {
    let counter = 0;
    let resumptionDate = '';
    var end_date = new Date(end_date);
    end_date.setDate(end_date.getDate()+1);
    console.log(end_date);
      while(counter == 0) {
        if(end_date.getDay()<6 && end_date.getDay() > 0) {
          console.log(end_date.getDay());
            counter++;
            console.log(counter);
        }
        
        if(counter == 0) end_date.setDate(end_date.getDate()+1);
      }
      $("#resumptionDate").text(end_date.toString().slice(0, 15));
      // return counter;
   }
   $(function(){
        $('#start_date').focusout(function(e){
          let start_date = $('#start_date').val();
          let end_date = $('#end_date').val();
          if(start_date == '') return false;
          if(end_date == '') return false;
          start_date = new Date(start_date);
          var today = new Date();
          var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
          //alert('aaa');
          date = new Date(date);
          //alert(date.getTime()+"----"+start_date.getTime());
          if(Number(date.getTime()) > Number(start_date.getTime())){
              Swal.fire({
              type: 'Error',
              title: 'Oops...',
              text: 'Kindly select an appropriate start Date'
            });
            $(".msgtouser").addClass('hide').html('');
            $(".msgtouser").removeClass('hide').append('<p>Kindly select an appropriate start Date (Date started has Past)</p>');
            //return false;
          }
          if(start_date.getDay() == 0 || start_date.getDay() == 6){
              Swal.fire({
              type: 'Error',
              title: 'Oops...',
              text: 'Start Date cannot be Saturday or Sunday'
            });
            $(".msgtouser").addClass('hide').html('');
            $(".msgtouser").removeClass('hide').append('<p>Start Date cannot be Saturday or Sunday</p>');
            //return false;
          }
          $(".msgtouser").addClass('hide').html('');
          getDaysMinusWeekend(start_date,end_date);
          resumptionDate(end_date);
          //$("#leave_day").val(days);
        });
        $('#end_date').focusout(function(e){
          //alert("ass");
          let start_date = $('#start_date').val();
          let end_date = $('#end_date').val();
          if(start_date == '') return false;
          if(end_date == '') return false;
          //alert(start_date);
          //getDaysMinusWeekend(start_date,end_date);
          //resumptionDate(end_date);
          ////alert(end_date.getDay());
          end_date = new Date(end_date);
          //alert(end_date.getDay());
          if(end_date.getDay() == 0 || end_date.getDay() == 6){
              Swal.fire({
              type: 'Error',
              title: 'Oops...',
              text: 'End Date cannot be Saturday or Sunday'
            });
             $(".msgtouser").addClass('hide').html('');
             $(".msgtouser").removeClass('hide').append('<p>End Date cannot be Saturday or Sunday</p>');
            //return false;
          }
           $(".msgtouser").addClass('hide').html('');
           getDaysMinusWeekend(start_date,end_date);
           resumptionDate(end_date);
          //$("#leave_day").val(days);
        });
   });
</script>

        
