<?php 
include 'connection.php';
session_start();
$appraisal = [];
$apraisal_flow = [];
$is_filled = true;
$assigned = [];
//print_r($_SESSION['user']);
 if(!isset($_SESSION['appraisal_id']) && $_SESSION['appraisal_id'] == '') header("Location: appraisals.php");

  $query =  "SELECT * FROM appraisal INNER JOIN appraisal_replies ON (appraisal_replies.appraisal_id = appraisal.id AND appraisal_replies.staff_id = '".$_SESSION['user']['id']."') WHERE appraisal_replies.appraisal_id = '".$_SESSION['appraisal_id']."' AND appraisal_replies.staff_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $appraisal[] = $row;
        $assigned = explode("@@@", $row['assigned_range']);
      }
  }
  if(!isset($_SESSION['is_just_filled'])){
    $rep_query = "SELECT * FROM appraisal_replies WHERE appraisal_id = '".$_SESSION['appraisal_id']."'";
    $rep_result = mysqli_query($conn, $rep_query);
    if(mysqli_num_rows($rep_result)> 0){
        $_SESSION['msg'] = "You have already completed this appraisal";
        $is_filled = true;
    }
  }
  
    if($appraisal[0]['appraisal_data'] != '') {
      $kpi = [];
      $break_questions = [];
      $lremarks = [];
      $ljustifications = [];
      $remarks = explode(";",$appraisal[0]['staff_remarks']);
      $justifications = explode(";",$appraisal[0]['staff_justifications']);
      $break_questions = explode('%%%%', $appraisal[0]['appraisal_data']);
      if($appraisal[0]['lManager_remarks'] != "") $lremarks = explode(";",$appraisal[0]['lManager_remarks']);
      if($appraisal[0]['lManager_justification'] != "") $ljustifications = explode(";",$appraisal[0]['lManager_justification']);
     //print_r(count($break_questions));
      for($r = 0; $r < count($break_questions); $r++){
           //print_r($break_questions[$r]);
           $kpi = explode(';;;',$break_questions[$r]);
          for($t = 0; $t < count($kpi); $t++){
              $kpi_name[] = explode('@@@',$kpi[$t])[0];
              $kpi_words[] = explode('@@@',$kpi[$t])[1];
              
          }
         
      }
      //print_r($remarks);
      //print_r($kpi_words);
    }
   unset($_SESSION['is_just_filled']);
  //print_r($appraisal);
$appraisal_flow = explode(";", $_SESSION['user']['appraisal_flow']);
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
                <h3>Complete Appraisal</h3>
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
               <?php if(isset($_SESSION['msg']) && $_SESSION['user']['category'] == 'staff') {?>
                        <div class="alert alert-primary" style="background-color: #007bff;font-size:16px;color:#fff" role="alert">
                            <?=$_SESSION['msg']?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                  <?php } ?>
                <?php if($_SESSION['user']['category'] == 'staff' && $_SESSION['user']['appraisal_flow'] == '' && $_SESSION['user']['position'] == '') {?>
                        <div class="alert alert-primary" style="background-color: #007bff;font-size:16px;color:#fff" role="alert">
                            You can not process appraisal, because you don't have approvals. Kindly add appraisal on the setting page
                        </div>
                  <?php } ?>   
              <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Appraisal (<?=$appraisal[0]['period']?>) <?=$appraisal[0]['year']?></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php if($appraisal[0]['document'] != '') {?>
                        <div style="text-align: center;">
                            <div class="btn-group" role="group" aria-label="Basic example">
                              <a href="downloadfile.php/?to=view_appraisal&filename=<?=$appraisal[0]['document']?>" class="btn btn-primary">Download Appraisal</a>
                               <a style="color:#fff;" id = 'uploadfilled' class="btn btn-info">Upload Filled Appraisal</a>
                            </div>
                            <?php if($_SESSION['user']['category'] == 'staff'){?>
                                <form action="process_staff_appraisal_doc.php" method="POST" enctype="multipart/form-data">
                                   <input type="file" name = 'appraisal' id = 'filledApp' style="display: none;">
                                   <input type="text" name = 'appraisal_id' id = '' value = '<?=$appraisal[0]['id']?>' style="display: none;">
                                   <input type="submit" class="btn btn-success" name = 'submit' id = 'submitApp' style="display: none;">
                                </form>
                               
                              <?php } ?>
                        </div>
                    <?php } else if($appraisal[0]['document_name'] == 'input Question') {?>
                        <div class="row" id = "all_reply">
                             <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 each_questions">
                               <div style="text-align: center;">
                                  <div style="width: 40px;height: 40px;border-radius: 20px;border: 1px solid #5A738E;margin-left: auto;margin-right: auto;color: #5A738E;"><span id = 'stage' style="position: relative;top:10px;">1/<?=count($break_questions)?></span></div>
                               </div>
                               <div id="questionrow" style="text-align: justify;">
                                <?php for($e = 0; $e < count($remarks); $e++){?>
                                 <?php $start = $e * 4;?>
                                 <h5>Question <?=$e+1?></h5>
                                 <h5 style = 'text-align:justify'><?=$kpi_name[$start]?></h5>
                                 <p style = 'text-align:justify'><?=$kpi_words[$start]?></p>
                                 
                                 <h5 style = 'text-align:justify'><?=$kpi_name[$start+1]?></h5>
                                 <p style = 'text-align:justify'><?=$kpi_words[$start+1]?></p>
                                 <h5 style = 'text-align:justify'><?=$kpi_name[$start+2]?></h5>
                                 <p style = 'text-align:justify'><?=$kpi_words[$start+2]?></p>
                                 <h5 style = 'text-align:justify'><?=$kpi_name[$start+3]?></h5>
                                 <p style = 'text-align:justify'><?=$kpi_words[$start+3]?></p>
                                <div class="form-group">
                                  <label for="remark">Remark</label>
                                  <input class = 'form-control' value ="<?=isset($remarks[$e])? $remarks[$e] : ''?>" />
                                 
                                </div>
                                <div class="form-group">
                                  <label for="remark">Justification</label>
                                  <textarea class="form-control" rows="3" id = "justification" value ="" name="justification"><?=isset($justifications[$e])? $justifications[$e] : ''?></textarea>
                                </div>
                                
                                <div class="form-group">
                                  <label for="remark">Line Manager's Remark</label>
                                  <input class = 'form-control' value ="<?=isset($lremarks[$e])? $lremarks[$e] : ''?>" />
                                 
                                </div>
                                <div class="form-group">
                                  <label for="remark">Line Manager's Justification</label>
                                  <textarea class="form-control" rows="3" id = "ljustification" value ="" name="ljustification"><?=isset($ljustifications[$e])? $ljustifications[$e] : ''?></textarea>
                                </div>
                                
                                <?php } ?>
                                </div>
                                <div style="text-align: left;">
                              <?php if ($_SESSION['user']['appraisal_flow'] != "") {?>
                              <?php $appraisal_flow = explode(";",$_SESSION['user']['appraisal_flow']) ?>
                              <form action="process_approval_comments.php" method="POST" process_approvals_comment.php >  
                              <?php $comment_flow = explode(";", $appraisal[0]['comments_flow']); ?>  
                              <?php for ($r = 0; $r < count($comment_flow); $r++) {?>  
                              <?php $this_comment_flow = explode(":", $comment_flow[$r]); ?>
                              <div class="form-group" style="margin-top: 15px;"> 
                                <label style="text-transform: capitalize;" for="<?=$comment_flow[$r]?>"><?=$this_comment_flow[0]?>'s Comment</label> 
                               
                                <textarea class="form-control textarea"  id = "textarea<?=$r?>"  appraisal_id = "<?=$appraisal[$t]['id']?>"  name=""><?=count($this_comment_flow) > 1 ? $this_comment_flow[1] : ''?></textarea>
                              </div> 
                               <?php }?> 
                              <input type="text" name="approval_email" id = "approval_email" style="display: none;">
                              <input type="text" name="appraisal_id" id = "appraisal_id" style="display: none;">
                              <input type="text" name="approval_title_role" id = "approval_title_role" style="display: none;">
                              <textarea id = "comment" name = "comment" style="display: none;"></textarea>
                              <div class="form-group">
                                <button type="submit" class="btn btn-primary" name = "submit" style="display: none;">Add Comment</button>
                              </div> 
                              </form> 
                              <?php } ?>
                            </div>
                        </div>
                        </div>
                        <div class="row" id = "review_replies">
                             <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 each_reply">
                               <div>
                                 
                               </div>
                             </div>
                        </div>
                        <form action="process_staff_appraisal.php" method="POST" style="display: none;">
                           <input type="text" name="appraisal_id" value="<?=$appraisal[0]['id']?>">
                           <textarea id = "all_remark" name = "all_remark"></textarea>
                           <textarea id = "all_justification" name="all_justification"></textarea>
                           <button type="submit" name="submit" id = "submit_data"></button>
                        </form>
                    <?php }  ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Rating Summary<small></small></h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td><?=$assigned[0]?> </td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td><?=$assigned[1]?>  </td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td><?=$assigned[2]?>  </td>
                        </tr>
                        <tr>
                          <th scope="row">4</th>
                          <td><?=$assigned[3]?>  </td>
                        </tr>
                        <tr>
                          <th scope="row">5</th>
                          <td><?=$assigned[4]?>  </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Approvals<small></small></h2>
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
                    <table class="table table-striped">
                      <tbody>
                        <?php for ($r = 0; $r < count($appraisal_flow); $r++) {?>
                        <tr>
                          <?php $p = explode(":", $appraisal_flow[$r])?>
                          <?php if(count($p) > 0) { ?>
                          <th scope="row"><?=$p[0]?></th>
                          <?php if(count($p) > 1) { ?>
                          <td><?=$p[1]?></td>
                          <?php } }?>
                        </tr>
                       <?php } ?>
                      </tbody>
                    </table>
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
        
