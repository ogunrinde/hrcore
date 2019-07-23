$(function(){
  $(".leave_request").on("click", function(e){
     let leave_id = $("#"+this.id+"").attr("leave_id");
     window.location.href = "/outsourcing/see_leave_request.php/?leave_id="+btoa(leave_id);
  });
});