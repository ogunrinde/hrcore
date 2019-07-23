$(function(){
	let current = 0;
	let remark = [];
    let remark_meaning = [];
	let justification = [];
    let is_created = false;
    let appraisal_data_array = [];
	$('.getdata').on('click', function(e){
    let app = $("#"+this.id+"").attr('appraisal_id');
    var url = "/outsourcing/get_appraisal_for_staff.php?appraisal_id="+btoa(app);
    window.location.href = url; 
    });
    $('.getappraisal').on('click', function(e){
    let app = $("#"+this.id+"").attr('appraisal_id');
    var url = "/outsourcing/get_appraisal_for_view.php?appraisal_id="+btoa(app);
    window.location.href = url; 
    });
    $('.allappraisal').on('click', function(e){
    let app = $("#"+this.id+"").attr('appraisal_id');
    let staff_id = $("#"+this.id+"").attr('staff_id');
    var url = "/outsourcing/get_appraisal_for_allstaff.php?appraisal_id="+btoa(app)+"&staff_id="+btoa(staff_id);
    window.location.href = url; 
    });
    $("#next").on('click',function(e){
    	let appraisal_name_array = [];
    	let appraisal_words_array = [];
    	let total_question = $(this).attr('total_question');
    	let appraisal_name = $(this).attr('appraisal_name');
    	let appraisal_words = $(this).attr('appraisal_words');
    	let category =  $(this).attr('category');
    	//alert(appraisal_name);
    	appraisal_name_array = appraisal_name.split(";");
    	//alert(appraisal_name_array);
    	appraisal_words_array = appraisal_words.split(";");
    	//alert(appraisal_name_array);
    	//alert(appraisal_data_array.length);
    	if($('#remark').val() == "") {
    	    $("#err_msg_remark").text('Please fill this input field');
    	    return false;
    	}
    	if($('#justification').val() == "") {
    	    $("#err_msg_just").text('Please fill this input field');
    	    return false;
    	}
    	//alert(current);
    	let next = current + 1;
    	let start = next * 4;
        remark[current] = $('#remark').val();
        justification[current] = $('#justification').val();
        //alert(next+"--"+appraisal_name_array.length);
        if(next < parseInt(total_question)){
        	current = next;
            $("#questionrow").slideUp('3000', function(){
                $("#questionrow").slideDown('2000', function(){
                    if(remark[next] != undefined) $("#remark").val(remark[next]);
                    else $("#remark").val('');
                    if(justification[next] != undefined) $("#justification").val(justification[next]);
                    else $("#justification").val('');
                    //alert(appraisal_name_array[next+3]+"--"+appraisal_words_array[next+3]);
                    $(this).html("<h5>Question "+(next+1)+"</h5><h5 style = 'text-align:justify'>"+appraisal_name_array[start]+"</h5>"
                         +"<p style = 'text-align:justify'>"+appraisal_words_array[start]+"</p>"
                         +"<h5 style = 'text-align:justify'>"+appraisal_name_array[start+1]+"</h5>"
                         +"<p style = 'text-align:justify'>"+appraisal_words_array[start+1]+"</p>"
                         +"<h5 style = 'text-align:justify'>"+appraisal_name_array[start+2]+"</h5>"
                         +"<p style = 'text-align:justify'>"+appraisal_words_array[start+2]+"</p>"
                         +"<h5 style = 'text-align:justify'>"+appraisal_name_array[start+3]+"</h5>"
                         +"<p style = 'text-align:justify'>"+appraisal_words_array[start+3]+"</p>");
                                 //<p>"+appraisal_data_array[next]+"</p>
                    $('#stage').html(""+(next + 1)+"/"+total_question);
                });
                if(next == parseInt(total_question) - 1 && is_created == false && category == 'staff'){
                    is_created = true;
                    $(".main_btn").append("<button type='button' class='btn btn-success' appraisal_name = '"+appraisal_name+"' appraisal_words = '"+appraisal_words+"' total_question = '"+total_question+"'  style='margin: 4px;' id='review'>Review</button>");
                }
            });
        }else if(next == parseInt(total_question) && is_created == false && category == 'staff'){
            is_created = true;
                    //$(".main_btn").append("<button type='button' class='btn btn-success' appraisal_name = '"+appraisal_name+"' appraisal_words = '"+appraisal_words+"'  style='margin: 4px;' id='review'>Review</button>");
        }

    });
    $("#previous").on('click',function(e){
    	let appraisal_name_array = [];
    	let total_question  = $(this).attr('total_question');
    	let appraisal_words_array = [];
    	let appraisal_name = $(this).attr('appraisal_name');
    	let appraisal_words = $(this).attr('appraisal_words');
    	appraisal_name_array = appraisal_name.split(";");
    	appraisal_words_array = appraisal_words.split(";");
    	let previous;
        remark[current] = $('#remark').val();
        justification[current] = $('#justification').val();
        if(current > 0){
        	previous = current - 1; 
        	current = previous;
        	let start = previous * 4;
            $("#questionrow").slideUp('3000', function(){
                $("#questionrow").slideDown('2000', function(){
                    //alert(remark[previous]);
                    if(remark[previous] != undefined) $("#remark").val(remark[previous]);
                    else $("#remark").val('');
                    if(justification[previous] != undefined) $("#justification").val(justification[previous]);
                    else $("#justification").val('');
                    $(this).html("<h5>Question "+(previous+1)+"</h5><h5 style = 'text-align:justify'>"+appraisal_name_array[start]+"</h5>"
                         +"<p style = 'text-align:justify'>"+appraisal_words_array[start]+"</p>"
                         +"<h5 style = 'text-align:justify'>"+appraisal_name_array[start+1]+"</h5>"
                         +"<p style = 'text-align:justify'>"+appraisal_words_array[start+1]+"</p>"
                         +"<h5 style = 'text-align:justify'>"+appraisal_name_array[start+2]+"</h5>"
                         +"<p style = 'text-align:justify'>"+appraisal_words_array[start+2]+"</p>"
                         +"<h5 style = 'text-align:justify'>"+appraisal_name_array[start+3]+"</h5>"
                         +"<p style = 'text-align:justify'>"+appraisal_words_array[start+3]+"</p>");
                    //$(this).html("<h5>Question "+(previous+1)+"</h5><p>"+appraisal_data_array[previous]+"</p>");
                    $('#stage').html(""+(previous + 1)+"/"+total_question);
                });

            });
        }

    });
     $("body").on("click", "#edit",  function(e){
        e.preventDefault();
        $("#edit").addClass('hide');
        $("#review_replies").slideUp('3000', function(){
            $("#all_reply").slideDown('3000', function(){

            });
        });
     });
     $("body").on("click", "#submit",  function(e){
        e.preventDefault();
        //alert("as");
        $("#all_remark").val(remark.join(";"));
        $("#all_justification").val(justification.join(";"));
        $("#submit_data").click();
     });
     $("body").on('click', "#review", function(e){
        //let appraisal_data_array = [];
        let appraisal_name_array = [];
    	let appraisal_words_array = [];
    	let total_question = $(this).attr('total_question');
    	let appraisal_name = $(this).attr('appraisal_name');
    	let appraisal_words = $(this).attr('appraisal_words');
        $("#edit").removeClass('hide');
        appraisal_name_array = appraisal_name.split(";");
        appraisal_words_array = appraisal_words.split(";");
        $("#next").trigger('click');
        $(".each_reply").html('');
        $("#all_reply").slideUp('3000', function(){
            $("#review_replies").slideDown('3000', function(){
                for (var i = 0; i < parseInt(total_question); i++) {
                    //alert(i);
                    $(".each_reply").append("<h5>Question "+(i+1)+"</h5><h5 style = 'text-align:justify'>"+appraisal_name_array[i]+"</h5>"
                         +"<p style = 'text-align:justify'>"+appraisal_words_array[i]+"</p>"
                         +"<h5 style = 'text-align:justify'>"+appraisal_name_array[i+1]+"</h5>"
                         +"<p style = 'text-align:justify'>"+appraisal_words_array[i+1]+"</p>"
                         +"<h5 style = 'text-align:justify'>"+appraisal_name_array[i+2]+"</h5>"
                         +"<p style = 'text-align:justify'>"+appraisal_words_array[i+2]+"</p>"
                         +"<h5 style = 'text-align:justify'>"+appraisal_name_array[i+3]+"</h5>"
                         +"<p style = 'text-align:justify'>"+appraisal_words_array[i+3]+"</p><h5 style = 'margin-top:10px;'>Remark</h5> <p>"+remark[i]+"</p><h5 style = 'margin-top:10px;'>justification</h5><p>"+justification[i]+"</p>");
                  //$(".each_reply").append("<h5>Question " +(i+1)+"</h5><p>"+appraisal_data_array[i]+"</p><h6 style = 'margin-top:10px;'>Remark "+remark[i]+"</h6><h6 style = 'margin-top:10px;'>justification</h6><h6>"+justification[i]+"</h6>");  
                }
                $(".each_reply").append("<div class='btn-group main_btn' role='group' aria-label='Basic example' style='margin-top: 10px;'><button type='button' class='btn btn-warning' id = 'edit'>Edit</button><button type='button' class='btn btn-success' id = 'submit'>Submit</button></div>");
            })
        })
     });
     $("#uploadfilled").click(function(e){
        e.preventDefault();
        $("#filledApp").trigger("click");
     });
     $("#filledApp").change(function(e){
        e.preventDefault();
        //alert("ass");
        $("#submitApp").trigger('click');
     });
     $(".textarea").on("focusout", function(e){
        e.preventDefault();
        //alert(this.id);
        let appraisal_id = $("#"+this.id+"").attr('appraisal_id');
        let staff_id = $("#"+this.id+"").attr('staff_id');
            $("#staff_id").val(staff_id);
            $("#appraisal_id").val(appraisal_id);
            $("#comment").val($("#"+this.id+"").val());
            //alert($("#"+this.id+"").val());
        //alert(staff_id+"----------"+appraisal_id);

     });
     /*$("#add_comment").on("click", function(e){
        e.preventDefault();
        let appraisal_flow = [];
        appraisal_flow = $(this).attr("appraisal_flow").split(";");
        let current_user_email = $(this).attr("current_user_email");
        alert(current_user_email);
        for(let r = 0; r < appraisal_flow.length; r++){
            let approval_email = $("#textarea"+r+"").attr('approval_email');
            if(current_user_email == approval_email){
                $("#approval_email").val(approval_email);
                $("#comment").val($("#textarea"+r+"").val());
                //$("")
                //alert($("#comment").val());
            }
                
        }

     })*/

});
