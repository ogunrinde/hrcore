$(function(){
  let status;
  let item_id;
  let flow;
  let approval_details;
  let requisition_flow;
function userupdate(){

}  
$('.badge_request').on("click", function(e){
    e.preventDefault();
    let _id;
    let approval;
    let s;
    let f;
    let all_flow = [];
    let to_continue = false;
    let category = $("#"+this.id+"").attr('category');
    requisition_flow = $("#"+this.id+"").attr('requisition_flow');
    let email = $("#"+this.id+"").attr('email');
    //alert(requisition_flow);
    full_requisition_flow = $("#"+this.id+"").attr('full_requisition_flow');
    all_flow = full_requisition_flow.split(";");
    for(let r = 0; r < all_flow.length; r++){
      let each_flow = all_flow[r].split(":")[0];
      let this_email = all_flow[r].split(":")[1];
      if(each_flow.toLowerCase() == requisition_flow.toLowerCase() && email == this_email){
        to_continue = true;
      }
    }
    if(to_continue == false) return false;
    s = $("#"+this.id+"").attr('status');
    let val = $("#"+this.id+"").children().length;
    if(val == 0){
      approval = $("#"+this.id+"").attr('approval');
      _id = $("#"+this.id+"").attr('item_id');
      f =  $("#"+this.id+"").attr('flow');
      //alert(f);
      let attr_id = $("#"+this.id+"").attr('attr_id');
      $("#approve"+attr_id+"").find("i").remove();
      $("#decline"+attr_id+"").find("i").remove();
      $("#pend"+attr_id+"").find("i").remove();
      $("#"+this.id+"").append('<i class="fas fa-check" style="padding: 0px;color: #4e73df; font-size:14px;"></i>');
      item_id =_id;
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
  });
    $('#submit_btn').on('click', function(e){
    e.preventDefault();
    //alert(status);
    if(item_id == ''){
      Swal.fire({
        type: 'Notice',
        title: 'Empty',
        text: 'Please select an action',
        footer: 'Thank you'
      });
      return false;
    } 
    window.location.href = "/outsourcing/process_requisition_approvals_remark.php/?flow_by="+btoa(requisition_flow)+"&flow="+btoa(flow)+"&status="+btoa(status)+"&item_id="+btoa(item_id)+"&approval_details="+btoa(approval_details)+"";
  });
});