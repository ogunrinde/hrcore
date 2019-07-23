$(function(){
   $('#showfile').on('click', function(e){
     $('#loadimg').trigger('click');
    });
});
function validateEmail(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
}
function show_msg(input){
   Swal.fire(
      'Oops',
      ''+input+' not an email',
      ''
    )
}
$('#staff_btn').on('click',function(e){
    e.preventDefault();
    let approvals = [];
    let l_approvals = [];
    let r_approvals = [];
    let c_approvals = [];
    let appraisal_approvals = [];
    let request_approvals = [];
    let cash_approvals = [];
    let leave_approvals = [];
    let req_approvals = [];
    let leave_approvals_names = [];
    let l_approvals_name = [];
    let leave_approvals_phone = [];
    let l_approvals_phone = [];
    
    let pm_name = $("#pm_name").val();
    let pm_number = $("#pm_number").val();
    let pm_email = $("#pm_email").val();
    //name
    let lManager_name = $("#lManager_name").val();
    let bManager_name = $("#bManager_name").val();
    let rManager_name = $("#rManager_name").val();

    //phone
    let lManager_phone = $("#lManager_phone").val();
    let bManager_phone = $("#bManager_phone").val();
    let rManager_phone = $("#rManager_phone").val();

    let leave_lmanager = $("#leave_lManager").val();
    let leave_bmanager = $("#leave_bManager").val();
    let leave_rmanager = $("#leave_rManager").val();
    let appraisal_lmanager = $("#appraisal_lManager").val();
    let appraisal_bmanager = $("#appraisal_bManager").val();
    let appraisal_rmanager = $("#appraisal_rManager").val();
    let req_lmanager = $("#req_lManager").val();
    let req_bmanager = $("#req_bManager").val();
    let req_rmanager = $("#req_rManager").val();
    let cash_lmanager = $("#cash_lManager").val();
    let cash_bmanager = $("#cash_bManager").val();
    let cash_rmanager = $("#cash_rManager").val();
    let admin_id = $("#admin_id").val();
    let email = $("#email").val();
    
    let religion = $("#religion").val();
    let sname = $("#sname").val();
    let town = $("#town").val();
    let lga = $("#lga").val();
    let sorigin = $("#sorigin").val();
    let sresidence =  $("#sresidence").val();
    let children = $("#children").val();
    let kname = $("#kname").val();
    let kphnumber = $("#kphnumber").val();
    let kaddress = $("#kaddress").val();
    let kdob = $("#kdob").val();
    let kgender = $("#kgender").val();
    let relationship_kin = $("#relationship_kin").val();
    let email_kin = $("#email_kin").val();
    let kin_is_beneficiary = $("#kin_is_beneficiary").val();
    let kin_is_dependent = $("#kin_is_dependent").val();
    let degree = $("#degree").val();
    let nysc_cert = $("#nysc_cert").val();
    let sgrade = $("#sgrade").val();
    let scourse_of_study = $("#scourse_of_study").val();
    let sinstitution = $("#sinstitution").val();
    let sdegree = $("#sdegree").val();
    let tgrade = $("#tgrade").val();
    let tcourse_of_study = $("#tcourse_of_study").val();
    let tinstitution = $("#tinstitution").val();
    let tdegree = $("#tdegree").val();
    
    let award_year_one = $("#award_year_one").val();
    let award_body_one = $("#award_body_one").val();
    let professional_qualification_one = $("#professional_qualification_one").val();
    
    let award_year_two = $("#award_year_two").val();
    let award_body_two = $("#award_body_two").val();
    let professional_qualification_two = $("#professional_qualification_two").val();
    
    let award_year_three = $("#award_year_three").val();
    let award_body_three = $("#award_body_three").val();
    let professional_qualification_three = $("#professional_qualification_three").val();
    if($("#admin_id").val() == "") {
        Swal.fire({
         type: 'Notify',
         title: 'Oops...',
         text: 'Kindly select your Managing Company'
      });
        return false;
    }
    if(validateEmail(email) == false) { 
         Swal.fire({
         type: 'Error',
         title: 'Oops...',
         text: 'Kindly input valid email'
         });
        return false; 
        
    }
    let confirm_email = validateEmail(leave_lmanager);
    if(confirm_email == false && leave_lmanager != ""){ show_msg(leave_lmanager); return false;} 
    confirm_email = validateEmail(leave_bmanager);
    if(confirm_email == false && leave_bmanager != ""){ show_msg(leave_bmanager); return false;}
    confirm_email = validateEmail(leave_rmanager);
    if(confirm_email == false && leave_rmanager != ""){ show_msg(leave_rmanager); return false;}

    /*confirm_email = validateEmail(appraisal_lmanager);
    if(confirm_email == false && appraisal_lmanager != ""){ show_msg(appraisal_lmanager); return false;}
    confirm_email = validateEmail(appraisal_bmanager);
    if(confirm_email == false && appraisal_bmanager != ""){ show_msg(appraisal_bmanager); return false;}
    confirm_email = validateEmail(appraisal_rmanager);
    if(confirm_email == false && appraisal_rmanager != ""){ show_msg(appraisal_rmanager); return false;}

    confirm_email = validateEmail(req_lmanager);
    if(confirm_email == false && req_lmanager != "") { show_msg(req_lmanager); return false; }
    confirm_email = validateEmail(req_bmanager);
    if(confirm_email == false && req_bmanager != "") { show_msg(req_bmanager); return false;}
    confirm_email = validateEmail(req_rmanager);
    if(confirm_email == false && req_rmanager != "") { show_msg(req_rmanager); return false; }

    confirm_email = validateEmail(cash_lmanager);
    if(confirm_email == false && cash_lmanager != "") { show_msg(cash_lmanager); return false; }
    confirm_email = validateEmail(cash_bmanager);
    if(confirm_email == false && cash_bmanager != "") { show_msg(cash_bmanager); return false; }
    confirm_email = validateEmail(cash_rmanager);
    if(confirm_email == false && cash_rmanager != "") { show_msg(cash_rmanager); return false; }*/

    //name
    if(leave_lmanager != "") leave_approvals_names.push("Line Manager:"+lManager_name);
    if(leave_bmanager != "") leave_approvals_names.push("Branch Manager:"+bManager_name);
    if(leave_rmanager != "") leave_approvals_names.push("Regional Manager:"+rManager_name);

    //phone 
    if(leave_lmanager != "") leave_approvals_phone.push("Line Manager:"+lManager_phone);
    if(leave_bmanager != "") leave_approvals_phone.push("Branch Manager:"+bManager_phone);
    if(leave_rmanager != "") leave_approvals_phone.push("Regional Manager:"+rManager_phone);

    if(leave_lmanager != "") leave_approvals.push("Line Manager:"+leave_lmanager);
    if(leave_bmanager != "") leave_approvals.push("Branch Manager:"+leave_bmanager);
    if(leave_rmanager != "") leave_approvals.push("Regional Manager:"+leave_rmanager);
    /*if(appraisal_lmanager != "") appraisal_approvals.push("Line Manager:"+appraisal_lmanager);
    if(appraisal_bmanager != "") appraisal_approvals.push("Branch Manager:"+appraisal_bmanager);
    if(appraisal_rmanager != "") appraisal_approvals.push("Regional Manager:"+appraisal_rmanager);
    if(req_lmanager != "") req_approvals.push("Line Manager:"+req_lmanager);
    if(req_bmanager != "") req_approvals.push("Branch Manager:"+req_bmanager);
    if(req_rmanager != "") req_approvals.push("Regional Manager:"+req_rmanager);
    if(cash_lmanager != "") cash_approvals.push("Line Manager:"+cash_lmanager);
    if(cash_bmanager != "") cash_approvals.push("Branch Manager:"+cash_bmanager);
    if(cash_rmanager != "") cash_approvals.push("Regional Manager:"+cash_rmanager);
    app_approvals = appraisal_approvals.join(";");
    l_approvals = leave_approvals.join(";");
    r_approvals = req_approvals.join(";"); 
    c_approvals = cash_approvals.join(";");*/
    
    //EMAIL
    l_approvals = leave_approvals.join(";");
    //name
    l_approvals_name = leave_approvals_names.join(";");
    //phone
    l_approvals_phone = leave_approvals_phone.join(";");
    
    let department = $("#department").val();
    let branch = $("#branch").val();
    let user_company = $("#user_company").val();
    let address = $("#address").val();
    let gender = $("#gender").val();
    let marital_status = $("#marital_status").val();
    let nationality = $("#nationality").val();
    let institution = $("#institution").val();
    let course_of_study = $("#course_of_study").val();
    let date_of_employment = $("#date_of_employment").val();
    let dob = $("#dob").val();
    let grade = $("#grade").val();
    let confirmed = $("#confirmed").val();
    //$(".loading").fadeOut('fast');
    $(".loading").fadeIn('fast');
    //setTimeout(function(){ $(".loading").fadeOut('slow'); }, 5000);
    let formdata =  new FormData();
    formdata.append('email',email);
    formdata.append('on_hmo', $('#on_hmo').val());
    formdata.append('hmo', $('#hmo').val());
    formdata.append('hmo_number', $('#hmo_number').val());
    formdata.append('hmo_plan', $('#hmo_plan').val());
    formdata.append('hmo_hospital', $('#hmo_hospital').val());
    formdata.append('hmo_remarks', $('#hmo_remarks').val());
    formdata.append('hmo_status', $('#hmo_status').val());

    formdata.append('pension_number', $('#pension_number').val());
    formdata.append('pension', $('#pension').val());


    formdata.append('religion',religion);
    formdata.append('sname',sname);
    formdata.append('town',town);
    formdata.append('lga',lga);
    formdata.append('sorigin',sorigin);
    formdata.append('sresidence',sresidence);
    formdata.append('children',children);
    formdata.append('kname',kname);
    formdata.append('kphnumber',kphnumber);
    formdata.append('kaddress',kaddress);
    formdata.append('kdob',kdob);
    formdata.append('kgender',kgender);
    formdata.append('relationship_kin',relationship_kin);
    formdata.append('email_kin',email_kin);
    
     formdata.append('kin_is_beneficiary',kin_is_beneficiary);
    formdata.append('kin_is_dependent',kin_is_dependent);
    formdata.append('nysc_cert',nysc_cert);
    formdata.append('degree',degree);
    formdata.append('sgrade',sgrade);
    formdata.append('scourse_of_study',scourse_of_study);
    //formdata.append('sresidence',sresidence);
    formdata.append('sinstitution',sinstitution);
    formdata.append('sdegree',sdegree);
    formdata.append('tgrade',tgrade);
    formdata.append('tcourse_of_study',tcourse_of_study);
    formdata.append('tinstitution',tinstitution);
    formdata.append('tdegree',tdegree);
    
    formdata.append('award_year_one',award_year_one);
    formdata.append('award_body_one',award_body_one);
    formdata.append('professional_qualification_one',professional_qualification_one);
    formdata.append('award_year_two',award_year_two);
    formdata.append('award_body_two',award_body_two);
    formdata.append('professional_qualification_two',professional_qualification_two);
    formdata.append('award_year_three',award_year_three);
    formdata.append('award_body_three',award_body_three);
    formdata.append('professional_qualification_three',professional_qualification_three);
    
    
    
    
    
    
    formdata.append('department',department);
    formdata.append('branch',branch);
    formdata.append('employee_ID',$("#employee_ID").val());
    formdata.append('phone_number',$("#phone_number").val());
    formdata.append('name', $("#name").val());
    formdata.append('fname', $("#fname").val());
    formdata.append('mname', $("#mname").val());
    formdata.append('role',$("#role").val());
    formdata.append('position', $('#position').val());
    formdata.append('submit','true');
    formdata.append('all_leave_approvals_phone',l_approvals_phone);
    formdata.append('all_leave_approvals_name',l_approvals_name);
    formdata.append('all_leave_approvals',l_approvals);
    formdata.append('all_appraisal_approvals',l_approvals);
    formdata.append('all_requisition_approvals', l_approvals);
    formdata.append('all_cash_approvals', l_approvals);
    formdata.append('admin_id', admin_id);
    formdata.append('user_company',user_company);
    formdata.append('address',address);
    formdata.append('gender',gender);
    formdata.append('marital_status',marital_status);
    formdata.append('nationality',nationality);
    formdata.append('institution',institution);
    formdata.append('course_of_study',course_of_study);
    formdata.append('date_of_employment',date_of_employment);
    formdata.append("confirmed", confirmed);
    formdata.append("dob",dob);
    formdata.append("grade",grade);
    if ($('input[type=file]')[0].files && $('input[type=file]')[0].files[0]) {
      formdata.append('image',$('input[type=file]')[0].files[0]);
     }
    formdata.append("pm_name", pm_name);
    formdata.append("pm_email",pm_email);
    formdata.append("pm_number",pm_number);
    //alert(pm_email);
    $(".loading").html('<p>Processing Request</p>').fadeIn('fast');
    
    $.ajax({
        type: 'POST',
        url : 'process_staff_data.php',
        data: formdata,
        processData:false,
        contentType:false,
        success:function(data){
           
          //alert(data);
          if(data == true) {
                    Swal.fire({
                      position: 'top-end',
                      type: 'success',
                      title: 'Employee Information is Saved',
                      showConfirmButton: false,
                      timer: 2500
                    });
                $(".loading").html('<p>Data Saved Successfully</p>').fadeIn('fast').fadeOut('4500');       
                setInterval(function(){ window.location.href = '/outsourcing/staff_settings.php'; }, 4500);    
                      
           }else{
                    window.location.href = '/outsourcing/staff_settings.php';
         }
        }
    })
    //alert(all_appraisal_approvals);
    //alert(all_leave_approvals);
})
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