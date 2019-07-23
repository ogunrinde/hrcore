$(function(){
  let status;
  let leave_id;
  let flow;
  let approval_details;
  let leave_flow;
  let remark = "";
  //alert("aaa");
  $('.remark').on('keyup', function(e){
      //alert('aa');
      let this_leave_flow = $("#"+this.id+"").attr('leave_flow');
      let this_full_leave_flow = $("#"+this.id+"").attr('full_leave_flow');
      let this_all_flow = this_full_leave_flow.split(";");
      let email  = $("#"+this.id+"").attr('email');
      for(let r = 0; r < this_all_flow.length; r++){
      let each_flow = this_all_flow[r].split(":")[0];
      let this_email = this_all_flow[r].split(":")[1];
      //alert(each_flow);
      if(each_flow.toLowerCase() == this_leave_flow.toLowerCase() && email == this_email){
        //to_continue = true;
        remark = $("#"+this.id+"").val();
      }
    }
    //alert(remark);
  })
  $('.badge_leave').on("click", function(e){
    e.preventDefault();
    let _id;
    let approval;
    let s;
    let f;
    let all_flow = [];
    let to_continue = false;
    let category = $("#"+this.id+"").attr('category');
    leave_flow = $("#"+this.id+"").attr('leave_flow');
    let email = $("#"+this.id+"").attr('email');
    //alert(requisition_flow);
   
    full_leave_flow = $("#"+this.id+"").attr('full_leave_flow');
    //alert(leave_flow);
    //alert(full_leave_flow);
    all_flow = full_leave_flow.split(";");
    
    //if($(''))
    for(let r = 0; r < all_flow.length; r++){
      let each_flow = all_flow[r].split(":")[0];
      let this_email = all_flow[r].split(":")[1].trim();
      //alert(each_flow);
      if(each_flow.toLowerCase() == leave_flow.toLowerCase() && email.toLowerCase() == this_email.toLowerCase()){
        to_continue = true;
      }
    }
    //return false;
    if(to_continue == false) return false;
    
    s = $("#"+this.id+"").attr('status');
    let val = $("#"+this.id+"").children().length;
    if(val == 0){
      approval = $("#"+this.id+"").attr('approval');
      _id = $("#"+this.id+"").attr('leave_id');
      f =  $("#"+this.id+"").attr('flow');
      //alert(f);
      let attr_id = $("#"+this.id+"").attr('attr_id');
      $("#approve"+attr_id+"").find("i").remove();
      $("#decline"+attr_id+"").find("i").remove();
      $("#pend"+attr_id+"").find("i").remove();
      $("#"+this.id+"").append('<i class="fas fa-check" style="padding: 0px;color: #4e73df; font-size:14px;"></i>');
      leave_id =_id;
      approval_details = approval;
      status = s;
      flow = f;
    }else {
      $("#"+this.id+"").find("i").remove();
      status = '';
      leave_id = '';
      approval_details = '';
      flow = '';
    }
  });
  /*$('.badge_leave').on("click", function(e){
    e.preventDefault();
    let _id;
    let approval;
    let s;
    let f;
    let category = $("#"+this.id+"").attr('category');
    leave_flow = $("#"+this.id+"").attr('leave_flow');
    s = $("#"+this.id+"").attr('status');
    if(category == 'staff') return false;
    if(category == 'admin') return false;
    if(leave_flow != category) return false;
    let val = $("#"+this.id+"").children().length;
    if(val == 0){
      approval = $("#"+this.id+"").attr('approval');
      _id = $("#"+this.id+"").attr('leave_id');
      f =  $("#"+this.id+"").attr('flow');
      let attr_id = $("#"+this.id+"").attr('attr_id');
      $("#approve"+attr_id+"").find("i").remove();
      $("#decline"+attr_id+"").find("i").remove();
      $("#pend"+attr_id+"").find("i").remove();
      $("#"+this.id+"").append('<i class="fas fa-check" style="padding: 0px;color: #4e73df; font-size:14px;"></i>');
      leave_id =_id;
      approval_details = approval;
      status = s;
      flow = f;
    }else {
      $("#"+this.id+"").find("i").remove();
      status = '';
      item_id = '';
      approval_details = '';
      flow = '';
    }
  });*/
      $('.submit_btn_leave').on('click', function(e){
    e.preventDefault();
    //alert(leave_id);
    //alert(approval_details);
    //alert(status);
    //alert(flow);
    //alert(status);
    if(leave_id == ''){
      Swal.fire({
        type: 'Notice',
        title: 'Empty',
        text: 'Please select an action',
        footer: 'Thank you'
      });
      return false;
    } 
    window.location.href = "/outsourcing/process_leave_approvals_remark.php/?flow_by="+btoa(leave_flow)+"&flow="+btoa(flow)+"&status="+btoa(status)+"&leave_id="+btoa(leave_id)+"&approval_details="+btoa(approval_details)+"&remark="+btoa(remark)+"";
  });
})
