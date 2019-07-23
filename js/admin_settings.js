$(function(){
	let companies = [];
	let department = [];
	let appraisalflow = [];
	let leaveflow = [];
	let cashflow = [];
	let priviledge = [];
	let isadded_forleave = false;
	let isadded = false;
	let isadded_company = false;
	let isadded_dept = false;
	let requisitionflow = [];
	let isadded_req = false;
	isadded_forcash = false;
	let is_leave_reset = 0;
	let is_req_reset = 0;
	let is_app_reset = 0;
	let is_cash_reset = 0;
	
	$("#add_company").on("click", function(e){
		e.preventDefault();
		let val = $('#companies').val();
		let d = $("#add_company").attr('companies');
		//alert(d);
        if(d != "") {
        	if(isadded_company == false){ companies = d.split(";"); isadded_company = true;}
        }
        //alert(branch);
		if(val == '') return false;
		companies.push(val);
		$("#all_company").val(companies.join(";"));
		//alert(companies);
		$('#listcompanies').append("<li class='list-group-item'>"+val+"</li>");
		$('#companies').val('');
	});
	$("#add_dept").on("click", function(e){
		e.preventDefault();
		let val = $('#dept').val();
		let d = $("#add_dept").attr('dept');
        if(d != "") {
        	if(isadded_dept == false){ department = d.split(";"); isadded_dept = true;}
        }
        //alert(department);
		if(val == '') return false;
		department.push(val);
		$('#listdept').append("<li class='list-group-item'>"+val+"</li>");
		$('#dept').val('');
	});
	$("#appraisal_aprroval").on('click', function(e){
       e.preventDefault();
       let appraisal = $("#appraisal_aprroval").attr('appraisal_flow');
       if(appraisal != "") {
       	if(isadded == false){ appraisalflow = appraisal.split(";"); isadded = true;}
       }
       //alert(appraisalflow);
       let val = $('#approval').val();
       if(val == "") return false;
       appraisalflow.push(val.trim());
       //alert(appraisalflow);
       $(".app_flow").append("<li><a class=''><span style='margin-left:2px;margin-right:7px;'>&#x27F6;</span>"+val+" </a></li>");
       $('#approval').val('');
	});
	$("#reset_approval").on('click', function(e){
		e.preventDefault();
		appraisalflow = [];
		is_app_reset = 1;
		//$("#appraisal_flow").attr()
		$(".app_flow").empty();
		$(".app_flow").append("<li><a class='active'>Staff </a></li>");
	});
	$("#reset_leave_approval").on('click', function(e){
		e.preventDefault();
		leaveflow = [];
		is_leave_reset = 1;
		$(".leave_flow").empty();
		$(".leave_flow").append("<li><a class='active'>Staff </a></li>");
	});
	$("#leave_approval").on('click', function(e){
       e.preventDefault();
       let leave = $("#leave_approval").attr('leave_flow');
       if(leave != "") {
       	if(isadded_forleave == false){ leaveflow = leave.split(";"); isadded_forleave = true;}
       };
       //alert(leaveflow);
       let val = $('#leave_level').val();
       if(val == "") return false;
       leaveflow.push(val.trim());
       $(".leave_flow").append("<li><a class=''><span style='margin-left:2px;margin-right:7px;'>&#x27F6;</span>"+val+" </a></li>");
       $('#leave_level').val('');
	});
	$("#cash_approval").on('click', function(e){
       e.preventDefault();
       let cash = $("#cash_approval").attr('cash_flow');
       if(cash != "") {
       	if(isadded_forcash == false){ cashflow = cash.split(";"); isadded_forcash = true;}
       };
       //alert(leaveflow);
       let val = $('#cash_level').val();
       if(val == "") return false;
       cashflow.push(val.trim());
       $(".c_flow").append("<li><a class=''><span style='margin-left:2px;margin-right:7px;'>&#x27F6;</span>"+val+" </a></li>");
       $('#cash_level').val('');
       //alert(cashflow);
	});
	$("#reset_cash").on('click', function(e){
		e.preventDefault();
		cashflow = [];
		is_cash_reset = 1;
		$(".c_flow").empty();
		$(".c_flow").append("<li><a class='active'>Staff </a></li>");
	});
	$("#requistion_approval").on('click', function(e){
       e.preventDefault();
       let requistion = $("#requistion_approval").attr('requisition_flow');
       //alert(requistion);
       if(requistion != "") {
       	if(isadded_req == false){ requisitionflow = requistion.split(";"); isadded_req = true;}
       }
       //alert(appraisalflow);
       let val = $('#requisition_level').val();
       if(val == "") return false;
       requisitionflow.push(val.trim());
       //alert(appraisalflow);
       $(".req_flow").append("<li><a class=''><span style='margin-left:2px;margin-right:7px;'>&#x27F6;</span>"+val+" </a></li>");
       $('#requisition_level').val('');
	});
	$("#reset_req").on('click', function(e){
		e.preventDefault();
		requisitionflow = [];
		is_req_reset = 1;
		$(".req_flow").empty();
		$(".req_flow").append("<li><a class='active'>Staff </a></li>");
	});
	$('#submit_btn').on('click', function(e){
		e.preventDefault();
		let company_name =  $("#company_name").val();
		let address =  $('#address').val();
		let file = document.getElementById('loadfile').files[0];
		//if(companies.length == 0) $("#add_company").trigger("click");
		let companies = $("#all_company").val();
		let data = {
			company_name: company_name,
			address: address
		};
		if(address == "" || company_name == ""){
			Swal.fire({
			  type: 'error',
			  title: 'Empty',
			  text: 'Please complete the form!',
			  footer: 'Thank you'
			});
			return false;
		}
		let formdata = new FormData();
		formdata.append('company_name',company_name);
		formdata.append('address',address);
		formdata.append('user_company',companies);
		formdata.append('submit', 'true');
		if(file) formdata.append('image', file);
		//alert('as');
		$.ajax({
			type : 'post',
			url: 'process_admin_data.php',
			data: formdata,
			processData:false,
			contentType:false,
			success:function(data){
				//alert(data);
				//console.log(data);
				if(data == true){
					Swal.fire({
					  position: 'top-end',
					  type: 'success',
					  title: 'Your update is Noted',
					  showConfirmButton: false,
					  timer: 1500
					});
					window.location.href = '/outsourcing/dashboard.php';
				}else{
					window.location.href = '/outsourcing/admin_settings.php';
				}
			}

		})

	});
	/*$('#submit_btn').on('click', function(e){
		e.preventDefault();
		//alert(appraisalflow);
		if(requisitionflow.length == 0 && is_req_reset == 0) $("#requistion_approval").trigger("click");
		if(leaveflow.length == 0 && is_leave_reset == 0) $("#leave_approval").trigger("click");
		if(cashflow.length == 0 && is_cash_reset == 0) $("#cash_approval").trigger("click");
		if(appraisalflow.length == 0 && is_app_reset == 0) $("#appraisal_aprroval").trigger("click");
		if(branch.length == 0) $("#add_branch").trigger("click");
		if(department.length == 0) $("#add_dept").trigger("click");
		let company_name =  $("#company_name").val();
		let address =  $('#address').val();
		let file = document.getElementById('loadfile').files[0];
		let data = {
			cashflow : cashflow.length > 0 ? cashflow.join(";") : "",
			leaveflow : leaveflow.length > 0 ? leaveflow.join(";") : "",
			appraisalflow : appraisalflow.length > 0 ? appraisalflow.join(";") : "", 
			requisitionflow : requisitionflow.length > 0 ? requisitionflow.join(";") : "",
			company_name: company_name,
			branch: branch.length > 0 ? branch.join(";") : "",
			department:department.length > 0 ? department.join(";") : "",
			address: address
		};
		if(data['requistionflow'] == '' && data['leaveflow'] == '' && data['appraisalflow'] == '' && data['company_name'] == '' && data['branch'] == '' && department == "" && address == ""){
			Swal.fire({
			  type: 'error',
			  title: 'Empty',
			  text: 'Please complete the form!',
			  footer: 'Thank you'
			});
			return false;
		}
		let formdata = new FormData();
		formdata.append('leaveflow', data.leaveflow);
		formdata.append('cashflow', data.cashflow);
		formdata.append('appraisalflow', data.appraisalflow);
		formdata.append('requisitionflow', data.requisitionflow);
		formdata.append('company_name',company_name);
		formdata.append('branch', data.branch);
		formdata.append('department',data.department);
		formdata.append('address',address);
		formdata.append('submit', 'true');
		if(file) formdata.append('image', file);
		//alert('as');
		$.ajax({
			type : 'post',
			url: 'process_admin_data.php',
			data: formdata,
			processData:false,
			contentType:false,
			success:function(data){
				//alert(data);
				//console.log(data);
				if(data == true){
					Swal.fire({
					  position: 'top-end',
					  type: 'success',
					  title: 'Your update is Noted',
					  showConfirmButton: false,
					  timer: 1500
					});
					window.location.href = '/outsourcing/dashboard.php';
				}else{
					window.location.href = '/outsourcing/admin_settings.php';
				}
			}

		})

	});*/
	$('#openfile').on('click', function(e){
		$('#loadfile').trigger('click');
	});
});
	 function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        $('.uploadimg')
            .attr('src', e.target.result)
            .width(100)
            .height(100);
      };
      reader.readAsDataURL(input.files[0]);
     }
    }