<?php 
 include "connection.php";
 session_start();
 if(!isset($_SESSION['appraisal_id']) || !isset($_SESSION['staff_id'])) header("Location: staff_filled_appraisal.php");
 $query = "SELECT * FROM appraisal INNER JOIN appraisal_replies ON appraisal_replies.appraisal_id = appraisal.id INNER JOIN users ON users.id = appraisal_replies.staff_id WHERE appraisal_replies.staff_id = '".$_SESSION['staff_id']."' AND appraisal_replies.appraisal_id = '".$_SESSION['appraisal_id']."'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)) {
        $appraisal[] = $row;
      }
  }
  //print_r($appraisal);
?>
<?php include "header.php"?>
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Monitor Appraisal</h3>
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
                            </div>
                            <div style="text-align: left;">
                              <form action="process_approval_comments.php" method="POST" process_approvals_comment.php >  
                              <?php $comment_flow = explode(";", $appraisal[$t]['comments_flow']); ?>  
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
                            </div>
                        </div>
                        <?php }else if($appraisal[$t]['document_name'] == 'input Question' && $appraisal[$t]['staff_remarks'] != '') {?>
                           <div class="row" id = "all_reply">
                             <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 each_questions">
                               <div style="text-align: center;">
                                  <div style="width: 40px;height: 40px;border-radius: 20px;border: 1px solid #5A738E;margin-left: auto;margin-right: auto;color: #5A738E;"><span id = 'stage' style="position: relative;top:10px;"><?=count(explode(";",$appraisal[$t]['appraisal_data']))?></span></div>
                               </div>
                               <div style="text-align: justify;">
                                  <?php $appraisal_data = explode(";",$appraisal[$t]['appraisal_data'])?>
                                   <?php $remark = explode(";",$appraisal[$t]['staff_remarks'])?>
                                   <?php $justification = explode(";",$appraisal[$t]['staff_justifications'])?>
                                   <?php for ($r = 0; $r < count($appraisal_data); $r++) {?>
                                   <div>
                                      <h5>Question <?=($r+1)?></h5><p><?=$appraisal_data[$r]?></p>
                                      <h5 style = 'margin-top:10px;'>Remark</h5><p> <?=$remark[$r]?></p>
                                      <h5 style = 'margin-top:10px;'>Justification</h5>
                                      <p><?=$justification[$r]?></p>    
                                   </div>
                                   <?php } ?>
                               </div>
                               <div style="text-align: left;">
                              <form action="process_approval_comments.php" method="POST" process_approvals_comment.php >  
                              <?php $comment_flow = explode(";", $appraisal[$t]['comments_flow']); ?>  
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
                        <?php if ($appraisal[0]['appraisal_flow'] != "") {?>
                        <?php $appraisal_flow = explode(";",$appraisal[0]['appraisal_flow']) ?>
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
        
