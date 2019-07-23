$(function(){
  $(".employee_info").on('click', function(e){
  	e.preventDefault();
  	let staff_id =  $("#"+this.id+"").attr('staff_id');
  	window.location.href = "/outsourcing/get_employee_profile.php/?staff_id="+btoa(staff_id);
  })
});