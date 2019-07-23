<?php 
include 'connection.php';
session_start();
$appraisal = [];
$apraisal_flow = [];
$created_appraisal = [];
$is_filled = false;
if(!isset($_SESSION['appraisal_id']) && $_SESSION['appraisal_id'] == '') header("Location: appraisals.php");
  $query = "SELECT * FROM appraisal INNER JOIN appraisal_replies ON (appraisal_replies.appraisal_id = appraisal.id) WHERE appraisal_replies.appraisal_id = '".$_SESSION['appraisal_id']."' AND appraisal_replies.staff_id = '".$_SESSION['staff_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $appraisal[] = $row;
      }
  }
  if($appraisal[0]['appraisal_data'] != '') {
      $kpi = [];
      $break_questions = [];
      $remark = explode(";",$appraisal[0]['staff_remarks']);
      $justification = explode(";",$appraisal[0]['staff_justifications']);
      $break_questions = explode('%%%%', $appraisal[0]['appraisal_data']);
     //print_r(count($break_questions));
      for($r = 0; $r < count($break_questions); $r++){
           //print_r($break_questions[$r]);
           $kpi = explode(';;;',$break_questions[$r]);
          for($t = 0; $t < count($kpi); $t++){
              $kpi_name[] = explode('@@@',$kpi[$t])[0];
              $kpi_words[] = explode('@@@',$kpi[$t])[1];
              
          }
         
      }
      //print_r($remark);
      //print_r($kpi_words);
    }
//print_r($appraisal);
?>
<?php include "header.php"?>
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Appraisal</h3>
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
              <div class="col-md-8 col-sm-12 col-xs-12">
                <?php for($t = 0; $t < count($appraisal); $t++) {?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Appraisal (<?=$appraisal[$t]['period']?>) <?=$appraisal[$t]['year']?></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                        <?php if($appraisal[$t]['document'] != '') { ?>
                        <div style="text-align: center;">
                            <div class="btn-group" role="group" aria-label="Basic example">
                              <a href="downloadfile.php/?to=view_appraisal&filename=<?=$appraisal[$t]['document']?>" class="btn btn-primary">Download Appraisal</a>
                               <a style="color:#fff;" id = 'uploadfilled' class="btn btn-info">Upload Filled Appraisal</a>
                               <a href="downloadfile.php/?to=view_appraisal&filename=<?=$appraisal[$t]['document_uploaded_by_staff']?>" style="color:#fff;" id = 'uploadfilled' class="btn btn-primary">Download Filled Appraisal</a>
                            </div>
                            <div style="text-align: left;">
                              <?php if ($appraisal[0]['comments_flow'] != "") {?>
                              <?php $appraisal_flow = explode(";",$_SESSION['user']['appraisal_flow']) ?>
                              <form action="process_approval_comments.php" method="POST" process_approvals_comment.php >  
                              <?php $comment_flow = explode(";", $appraisal[$t]['comments_flow']); ?>   
                              <?php for ($r = 0; $r < count($comment_flow); $r++) {?>  
                              <?php $this_comment_flow = explode(":", $comment_flow[$r]); ?>
                              <div class="form-group" style="margin-top: 15px;"> 
                                <label style="text-transform: capitalize;" for="<?=$comment_flow[$r]?>"><?=$this_comment_flow[0]?>'s Comment</label> 
                               <?php if(strtolower($this_comment_flow[0]) == strtolower($_SESSION['user']['position'])) {?>
                                <?php if (count($this_comment_flow) > 1) { ?>
                                  <textarea class="form-control textarea"  id = "textarea<?=$r?>"  appraisal_id = "<?=$appraisal[$t]['appraisal_id']?>" staff_id = "<?=$appraisal[$t]['staff_id']?>" name=""><?=filter_var($this_comment_flow[1], FILTER_VALIDATE_EMAIL) ? '' : $this_comment_flow[1] ?></textarea>
                                <?php } ?>
                                
                              <?php }else { ?>

                                <?php if (count($this_comment_flow) > 1) { ?>
                                  <textarea class="form-control textarea" disabled="true"><?=filter_var($this_comment_flow[1], FILTER_VALIDATE_EMAIL) ? '' : $this_comment_flow[1] ?></textarea>
                                <?php } ?>
                              <?php } ?>  
                              </div> 
                             
                               <?php }?> 
                              <input type="text" name="appraisal_id" id = "appraisal_id" style="display: none;">
                              <input type="text" name="staff_id" id = "staff_id" style="display: none;">
                              <textarea id = "comment" name = "comment" style="display: none;"></textarea>
                              <div class="form-group">
                                <button type="submit" class="btn btn-primary" name = "submit" style="">Add Comment</button>
                              </div> 
                              </form> 
                              <?php } ?>
                            </div>
                        </div>
                        <?php }else if($appraisal[$t]['document_name'] == 'input Question' && $appraisal[$t]['staff_remarks'] != '') {?>
                           <div class="row" id = "all_reply">
                             <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 each_questions">
                               <div style="text-align: center;">
                                  <div style="width: 40px;height: 40px;border-radius: 20px;border: 1px solid #5A738E;margin-left: auto;margin-right: auto;color: #5A738E;"><span id = 'stage' style="position: relative;top:10px;">1/<?=count($remark)?></span></div>
                               </div>
                               <div style="text-align: justify;">
                                  <?php $appraisal_data = explode(";",$appraisal[$t]['appraisal_data'])?>
                                   <?php $remark = explode(";",$appraisal[$t]['staff_remarks'])?>
                                   <?php $lmanager_remark = explode(";",$appraisal[$t]['lManager_remarks'])?>
                                   <?php $lmanager_justification = explode(";",$appraisal[$t]['lManager_justification'])?>
                                   <?php $justification = explode(";",$appraisal[$t]['staff_justifications'])?>
                                   <?php for ($e = 0; $e < count($remark); $e++) {?>
                                   <div>
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
                                      <h5 style = 'margin-top:10px;'>Remark</h5><p> <?=$remark[$e]?></p>
                                      <h5 style = 'margin-top:10px;'>Justification</h5>
                                      <p><?=$justification[$e]?></p>    
                                   </div>
                                   <div class="form-group">
                                      <label for="remark">Line Manager's Remark</label>
                                      <select name = 'remark' this_question = '<?=$e?>' total_question = '<?=count($remark)?>' id = "lmanager_remark<?=$e?>" class="form-control lmanager_remark" value = "<?=$lmanager_remark[$e]?>">
                                        <option value = "<?=$lmanager_remark[$e]?>"><?=$lmanager_remark[$e]?></option>
                                        <option value = "1">1</option>
                                        <option value = "2">2</option>
                                        <option value = "3">3</option>
                                        <option value = "4">4</option>
                                        <option value = "5">5</option>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="remark">Line Manager Justification</label>
                                      <textarea class="form-control lmanager_justification" total_question = '<?=count($remark)?>' this_question = '<?=$e?>' rows="3" id = "lmanager_justification<?=$e?>" name="justification" value = ""><?=$lmanager_justification[$e]?></textarea>
                                   </div>
                                   <?php } ?>
                               </div>
                               <div style="text-align: left;">
                              <?php if ($appraisal[0]['comments_flow'] != "") {?>
                              <?php $appraisal_flow = explode(";",$_SESSION['user']['appraisal_flow']) ?>
                              <form action="process_approval_comments.php" method="POST" process_approvals_comment.php >  
                              <?php $comment_flow = explode(";", $appraisal[$t]['comments_flow']); ?>  
                              <?php for ($r = 0; $r < count($comment_flow); $r++) {?>  
                              <?php $this_comment_flow = explode(":", $comment_flow[$r]); ?>
                              <hr style = 'margin-top:30px;'/>
                              <div class="form-group" style="margin-top: 15px;"> 
                                <label style="text-transform: capitalize;" for="<?=$comment_flow[$r]?>"><?=$this_comment_flow[0]?>'s Comment</label>
                                
                               <?php if(strtolower($this_comment_flow[0]) == strtolower($_SESSION['user']['position'])) {?> 
                               <?php if (count($this_comment_flow) > 1) { ?>
                                  <textarea class="form-control textarea"  id = "textarea<?=$r?>"  appraisal_id = "<?=$appraisal[$t]['appraisal_id']?>" staff_id = "<?=$appraisal[$t]['staff_id']?>"  name=""><?=filter_var($this_comment_flow[1], FILTER_VALIDATE_EMAIL) ? '' : $this_comment_flow[1] ?></textarea>
                                <?php } ?> 
                              <?php }else { ?>
                                 <textarea class="form-control textarea" disabled="true"><?=filter_var($this_comment_flow[1], FILTER_VALIDATE_EMAIL) ? '' : $this_comment_flow[1] ?></textarea>
                              <?php } ?>  
                              </div> 
                               <?php }?> 
                              <input type="text" name="appraisal_id" id = "appraisal_id" value = "<?=$appraisal[0]['appraisal_id']?>" style="display: none;">
                              <input type="text" name="staff_id" value = "<?=$appraisal[0]['staff_id']?>" id = "staff_id" style="display: none;">
                              <textarea id = "all_lmanager_remarks" name = "all_lmanager_remarks" style="display: none;"></textarea>
                              <textarea id = "all_lmanager_justification" name = "all_lmanager_justification" style="display: none;"></textarea>
                              <textarea id = "comment" name = "comment" value = "no comment" style="display: none;"></textarea>
                              <div class="form-group">
                                <button type="submit" class="btn btn-primary" name = "submit" style="">Add Comment</button>
                              </div> 
                              </form> 
                              <?php } ?>
                            </div>
                        </div>
                        </div>
                        <?php } ?>  
                  </div>
                </div>
              <?php } ?>
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
                          <td>Excellence </td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>Very Good </td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>Good </td>
                        </tr>
                        <tr>
                          <th scope="row">4</th>
                          <td>Average </td>
                        </tr>
                        <tr>
                          <th scope="row">5</th>
                          <td>Bad </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Approvals<small></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-striped">
                      <tbody>
                        <?php if ($_SESSION['user']['appraisal_flow'] != "") {?>
                        <?php $appraisal_flow = explode(";",$_SESSION['user']['appraisal_flow']) ?>
                        <?php for ($r = 0; $r < count($appraisal_flow); $r++) {?>
                        <tr>
                          <th scope="row"><?=explode(":", $appraisal_flow[$r])[0]?></th>
                          <td><?=explode(":", $appraisal_flow[$r])[1]?></td>
                        </tr>
                       <?php } }?>
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
<script type="text/javascript">
    $(function(){
        let lmanager_remark = [];
        let lmanager_justification = [];
        let total_question = <?php echo count($remark)?>;
        let remarked = 1;
        //alert(total_question);
         for(let n = 0; n < parseInt(total_question);n++){
            lmanager_remark[n] =  '0';  
            //if($("#lmanager_remark"+n+"").val())remarked = remarked + 1;
            //alert(lmanager_remark);
         }
         $("#all_lmanager_remarks").val(lmanager_remark.join(";"));
        for(let n = 0; n < parseInt(total_question);n++){
            lmanager_justification[n] =  'No Justification';  
        }
        $("#all_lmanager_justification").val(lmanager_justification.join(";"));
        $(".lmanager_remark").on('change', function(e){
            e.preventDefault();
            let question = $("#"+this.id+"").attr('this_question');
            let total_question =  $("#"+this.id+"").attr('total_question');
            let  value = $("#"+this.id+"").val();
            lmanager_remark[question] = value;
            //lmanager_remark = remark(lmanager_remark);
            for(let n = 0; n < parseInt(total_question);n++){
                lmanager_remark[n] =  $("#lmanager_remark"+n+"").val();  
            }
            $("#all_lmanager_remarks").val(lmanager_remark.join(";"));
            //alert(lmanager_remark.join(";"));
        });
        $(".lmanager_justification").on('focusout', function(e){
            e.preventDefault();
            let question = $("#"+this.id+"").attr('this_question');
            let total_question =  $("#"+this.id+"").attr('total_question');
            let  value = $("#"+this.id+"").val();
            lmanager_justification[question] = value;
            for(let n = 0; n < parseInt(total_question);n++){
                lmanager_justification[n] =  $("#lmanager_justification"+n+"").val();  
                //alert($("#lmanager_justification"+n+"").val());
            }
            //lmanager_justification = justification(lmanager_justification);
            $("#all_lmanager_justification").val(lmanager_justification.join(";"));
            //alert(lmanager_justification);
            //lmanager_justification = remark(lmanager_remark);
            //alert(lmanager_justification);
        });
    })
</script>
        
