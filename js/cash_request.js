$(function(){
  let status;
  let cash_id;
  let flow;
  let approval_details;
  let leave_flow;
  $('.badge_cash').on("click", function(e){
    e.preventDefault();
    let _id;
    let approval;
    let s;
    let f;
    let all_flow = [];
    let to_continue = false;
    let category = $("#"+this.id+"").attr('category');
    cash_flow = $("#"+this.id+"").attr('cash_flow');
    let email = $("#"+this.id+"").attr('email');
    //alert(email);
    full_cash_flow = $("#"+this.id+"").attr('full_cash_flow');
    //alert(full_cash_flow);
    all_flow = full_cash_flow.split(";");
    for(let r = 0; r < all_flow.length; r++){
      //alert(all_flow);
      let each_flow = all_flow[r].split(":")[0];
      let this_email = all_flow[r].split(":")[1];
      if(each_flow.toLowerCase() == cash_flow.toLowerCase() && email == this_email){
        //alert(this_email);
        to_continue = true;
      }
    }
    if(to_continue == false) return false;
    //alert("am here");
    s = $("#"+this.id+"").attr('status');
    let val = $("#"+this.id+"").children().length;
    if(val == 0){
      approval = $("#"+this.id+"").attr('approval');
      _id = $("#"+this.id+"").attr('cash_id');
      f =  $("#"+this.id+"").attr('flow');
      //alert(f);
      let attr_id = $("#"+this.id+"").attr('attr_id');
      $("#approve"+attr_id+"").find("i").remove();
      $("#decline"+attr_id+"").find("i").remove();
      $("#pend"+attr_id+"").find("i").remove();
      $("#"+this.id+"").append('<i class="fas fa-check" style="padding: 0px;color: #4e73df; font-size:14px;"></i>');
      cash_id =_id;
      //alert(cash_id);
      approval_details = approval;
      status = s;
      flow = f;
    }else {
      $("#"+this.id+"").find("i").remove();
      status = '';
      cash_id = '';
      approval_details = '';
      flow = '';
    }
  });
      $('#submit_btn_cash').on('click', function(e){
    e.preventDefault();
    //alert(cash_id); return false;
    //alert(leave_id);
    //alert(approval_details);
    //alert(status);
    //alert(flow);
    //alert(status);
    if(cash_id == ''){
      Swal.fire({
        type: 'Notice',
        title: 'Empty',
        text: 'Please select an action',
        footer: 'Thank you'
      });
      return false;
    } 
    
    window.location.href = "/outsourcing/process_cash_approvals_remark.php/?flow_by="+btoa(cash_flow)+"&flow="+btoa(flow)+"&status="+btoa(status)+"&cash_id="+btoa(cash_id)+"&approval_details="+btoa(approval_details)+"";
  });
})
