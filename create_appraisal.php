<?php 
include 'connection.php';
session_start();
$deptment = [];
$user_company = [];
$data = [];
 if(!isset($_SESSION['user']['id'])) header("Location: login.php");
 if($_SESSION['user']['category'] == 'staff') header("Location: dashboard.php");
  $query = "SELECT * FROM company WHERE admin_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        if($row['department'] != '') $deptment = explode(";",$row['department']);
      }
  }
  $query = "SELECT * from company WHERE company_name = 'Icsoutsourcing'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
        if($data[0]['user_company'] != ""){
          $user_company = explode(";",$data[0]['user_company']);
        }
      }
  }
  //print_r($data);
?>
<?php include "header.php"?>
<!--link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css"-->
<style type="text/css">
  .w3-content, .w3-auto {
    margin-left: auto;
    margin-right: auto;
  }
  .w3-light-grey, .w3-hover-light-grey:hover, .w3-light-gray, .w3-hover-light-gray:hover {
    color: #000!important;
    background-color: #f1f1f1!important;
  }
  .w3-red, .w3-hover-red:hover {
    color: #fff!important;
    background-color: #f44336!important;
  }
  .w3-btn, .w3-button {
    border: none;
    display: inline-block;
    padding: 8px 16px;
    vertical-align: middle;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    background-color: inherit;
    text-align: center;
    cursor: pointer;
    white-space: nowrap;
 }
 .w3-center {
    text-align: center!important;
 }
</style>
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Create Appraisal</h3>
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
         <?php if(isset($_SESSION['msg'])) {?>
                        <div class="alert alert-primary" style="background-color: #d1ecf1;" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Upload Document</a></li>
            <li><a data-toggle="tab" href="#menu2">Input Questions</a></li>
          </ul>
        
          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="row">
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Create Appraisal<small>upload appraisal</small></h2>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <br />
                            <form action="process_create_appraisal.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
        
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Appraisal Period <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" name="period" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                              </div>
                              <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Appraisal year <span class="required">*</span>
                                      </label>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                       <select name="year" class="form-control">
                                         <option value=""></option>
                                         <option value="2019">2019</option>
                                         <option value="2020">2020</option>
                                         <option value="2021">2021</option>
                                         <option value="2022">2022</option>
                                         <option value="2023">2023</option>
                                         <option value="2024">2024</option>

                                       </select>
                                      </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="admin_email">Company Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="user_company" class="form-control" id = "user_company">
                                   <option value=""></option>
                                  <?php for($r = 0; $r < count($user_company); $r++){?>
                                    <option value = "<?=isset($user_company[$r]) ? $user_company[$r] : '';?>"> <?=isset($user_company[$r]) ? $user_company[$r] : ''?></option>
                                  <?php } ?>
                                </select>
                                </div>
                              </div>
                              <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Upload document <span class="required">*</span>
                                      </label>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                          <input type="file" name ="document" class="custom-file-input" id="appraisal_file">
                                          <!--div id = "upload_appraisal"><img style="width: 40px;height: 40px;" class="uploadimg" src="images/doc.png" alt=""></div>
                                          <input type="file" name="document" id="appraisal_file" style="display: none;"-->
                                      </div>                                
                              </div>
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <!--button class="btn btn-primary" type="button">Cancel</button>
                                  <button class="btn btn-primary" type="reset">Reset</button-->
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
                        <h2>Input Questions</h2>
                        <div class="clearfix"></div>
                      </div>

                      <div class="x_content">
                        <br />
                         
                        <div class="question_page">   
                          <div class="row">
                            <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 all_questions"> 
                            </div>
                          </div>  
                          <div class="row">
                            <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2"> 
                            <div class = 'form-group' style = 'margin-top:5px;'>
                                <label>KPI Perspective</label>
                                <input type = 'text' id = 'perspective' class='form-control'/>
                                <small class='text-danger' id ='pers'></small>
                            </div>
                            <div class = 'form-group' style = 'margin-top:5px;'>
                                <label>Key Result Area</label>
                                <textarea id="area_question" name = "" class="form-control question" placeholder="Question" rows="3" cols="80"></textarea>
                                <small class='text-danger' id ='area'></small>
                            </div>
                            <div class = 'form-group' style = 'margin-top:5px;'>
                                <label>KPI Description</label>
                                <textarea id="desc_question" name = "" class="form-control question" placeholder="Question" rows="3" cols="80"></textarea>
                                <small class='text-danger' id ='desc'></small>
                            </div>
                            <div class = 'form-group' style = 'margin-top:5px;'>
                                <label>KPI Parameter</label>
                                <textarea id="param_question" name = "" class="form-control question" placeholder="Question" rows="3" cols="80"></textarea>
                                <small class='text-danger' id ='param'></small>
                            </div>
                            
                            <div class = 'form-group' style = 'margin-top:5px;'>
                                <label>Weight</label>
                                <input id="weight" name = "" class="form-control " placeholder="""/>
                                <small class='text-danger' id ='addweight'></small>
                            </div>
                             
                                                
                            </div>
                          </div>
                        </div>
                        <div class="show_questions hide">
                          <div class="row">
                             <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 edit_this_question">
                                <div class = 'form-group' style = 'margin-top:5px;'>
                                    <label>KPI Perspective</label>
                                    <input type = 'text' id = 'edit_perspective' class='form-control'/>
                                    <small class='text-danger' id ='edit_pers'></small>
                                </div>
                                <div class = 'form-group' style = 'margin-top:5px;'>
                                    <label>Key Result Area</label>
                                    <textarea id="edit_area_question" name = "" class="form-control question" placeholder="Question" rows="3" cols="80"></textarea>
                                    <small class='text-danger' id ='edit_area'></small>
                                </div>
                                <div class = 'form-group' style = 'margin-top:5px;'>
                                    <label>KPI Description</label>
                                    <textarea id="edit_desc_question" name = "" class="form-control question" placeholder="Question" rows="3" cols="80"></textarea>
                                    <small class='text-danger' id ='edit_desc'></small>
                                </div>
                                <div class = 'form-group' style = 'margin-top:5px;'>
                                    <label>KPI Parameter</label>
                                    <textarea id="edit_param_question" name = "" class="form-control question" placeholder="Question" rows="3" cols="80"></textarea>
                                    <small class='text-danger' id ='edit_param'></small>
                                </div>
                                <div class = 'form-group' style = 'margin-top:5px;'>
                                <label>Weight</label>
                                <input id="edit_weight" name = "" class="form-control " placeholder="""/>
                                <small class='text-danger' id ='editweight'></small>
                            </div>
                                <a href = '' id = 'save_edit' class ='btn btn-primary'>Save Change</a>
                             </div>
                             <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2  each_questions">
                             
                             </div>
                              <!--div style="text-align: center;">
                                  <a href="#" id = "editdoc" class="btn btn-warning">Edit</a>
                              </div-->
                          </div>
                          <div class="row">
                             <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">

                                <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                  
                                  
                                </ul>
                              </nav>   
                             </div>
                          </div>
                        </div>
                        <div class="process_form hide">
                        <div class="row">
                          <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
                            <form action="process_create_appraisal_via_input.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
        
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Appraisal Period <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="" name="app_period" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea style="display: none;" name = "appraisal_data" id = "appraisal_data"></textarea>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea style="display: none;" name = "weight_data" id = "weight_data"></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Appraisal year <span class="required">*</span>
                                      </label>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                       <select name="app_year" class="form-control">
                                         <option value=""></option>
                                         <option value="2019">2019</option>
                                         <option value="2020">2020</option>
                                         <option value="2021">2021</option>
                                         <option value="2022">2022</option>
                                         <option value="2023">2023</option>
                                         <option value="2024">2024</option>
                                         <option value="2025">2025</option>
                                         <option value="2026">2026</option>
                                         <option value="2027">2027</option>
                                         <option value="2028">2028</option>
                                         <option value="2029">2029</option>
                                         <option value="2030">2030</option>
                                       </select>
                                      </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="admin_email">Company Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="user_company" class="form-control" id = "user_company">
                                   <option value=""></option>
                                  <?php for($r = 0; $r < count($user_company); $r++){?>
                                    <option value = "<?=isset($user_company[$r]) ? $user_company[$r] : '';?>"> <?=isset($user_company[$r]) ? $user_company[$r] : ''?></option>
                                  <?php } ?>
                                </select>
                                </div>
                              </div>
                              <textarea style="display:none;" name = "range" id ="range">
                                  
                              </textarea>
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    
                                  <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                </div>
                              </div>
        
                            </form>
                          </div>
                        </div>
                        </div>
                        <div class="process_assign_param hide">
                        <div class="row">
                          <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
                            <form action="" method="" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
        
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Score Range of 1
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="assign_one" name="assign_one" placeholder='Assign range to 1' class="form-control col-md-7 col-xs-12" type="text">
                                    <small id ="one" class="text-danger"></small>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Score Range of 2
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="assign_two" name="assign_two" placeholder='Assign range to 2 ((40 to 55))' class="form-control col-md-7 col-xs-12" type="text">
                                    <small id ="two" class="text-danger"></small>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Score Range of 3
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="assign_three" name="assign_three" placeholder='Assign range to 3 (56 to 75)' class="form-control col-md-7 col-xs-12" type="text">
                                    <small id ="three" class="text-danger"></small>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Score Range of 4
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="assign_four" name="assign_four" placeholder='Assign range to 4 (76 to 95)' class="form-control col-md-7 col-xs-12" type="text">
                                    <small id ="four" class="text-danger"></small>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Score Range of 5
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="assign_five" name="assign_five" placeholder='Assign range to 5 (96 to 100)' class="form-control col-md-7 col-xs-12" type="text">
                                    <small id ="five" class="text-danger"></small>
                                </div>
                              </div>
                           
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <div class="btn-group" role="group" aria-label="Basic example" style="margin-top: 10px;">
                                         <button type="button" class="btn btn-primary" style="" id="back_to">Back</button>
                                        <button type="button" id ='assigned' name="" class="btn btn-success">Continue</button>
                                    </div> 
                                  
                                </div>
                              </div>
        
                            </form>
                          </div>
                        </div>
                        </div>
                        <div class="row" id = 'link_to_question'>
                           <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
                             <div class="btn-group" role="group" aria-label="Basic example" style="margin-top: 10px;">
                              <button type="button" class="btn btn-primary" style="margin: 4px;" id="add_question">Add Question</button>
                              <button type="button" class="btn btn-success hide" style="margin: 4px;" id="main_question_page">Question</button>
                              <button type="button" class="btn btn-info" style="margin: 4px;" id="review">Review Questions</button>
                              <button type="button" class="btn btn-warning" style="margin: 4px;" id = 'continue'>Continue</button>
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
</div>
</div>
<?php include "footer.php"?>

        
