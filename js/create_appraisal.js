$(function(){
	let questions;
	let all_questions = [];
	let weight = [];
	let n = 0;
	$('#upload_appraisal').on('click', function(e){
		$('#appraisal_file').trigger('click');
	});
	$(".page_link").on('click', function(e){
      let curr = $("#"+this.id+"").attr("curr");
      question = $("#question").val();
	});
	$(".question").on('keydown', function(e) {
	  if (e.which == 13) {
	  	question = $("#question").val();
	    $("#add_question").trigger("click");
	  }
	});
    	
	$("#add_question").on("click", function(e){
		e.preventDefault();
		let perspective = $("#perspective").val();
		let area_question = $("#area_question").val();
		let desc_question = $("#desc_question").val();
		let param_question = $("#param_question").val();
		let question_weight = $('#weight').val();
		//var question = CKEDITOR.instances.question.getData();
		//alert(question);
		if(perspective == ''){
		    $("#pers").text('Field can not be Empty');
		    return false;
		}
		if(area_question == ''){
		    $("#area").text('Field can not be Empty');
		    return false;
		}
		if(desc_question == ''){
		    $("#desc").text('Field can not be Empty');
		    return false;
		}
		if(param_question == ''){
		    $("#param").text('Field can not be Empty');
		    return false;
		}
		if($("#weight").val() == ''){
		    $("#addweight").text('Field can not be Empty');
		    return false;
		}
		//if(question == '') return false;
		$(".all_questions").append("<h2>Question "+(all_questions.length + 1)+"</h2><div style = 'text-align:justify'><h5>KPI PERSPECTIVE</h5><p>"+perspective+"</p><h5>KPI RESULT AREA </h5><p>"+area_question+"</p><h5>KPI DESCRIPTION</h5><p>"+desc_question+"</p><h5>KPI PARAMETER</h5><p>"+param_question+"</p><h5>WEIGHT</h5><p>"+question_weight+"</p></div>");
		let question = "KPI PERSPECTIVE@@@"+perspective+";;;KPI RESULT AREA@@@"+area_question+";;;KPI DESCRIPTION@@@"+desc_question+";;;KPI PARAMETER@@@"+param_question+"";
		//let weight = 
	    //$(".all_questions").append("<h2>Question "+(all_questions.length + 1)+"</h2><div style = 'text-align:justify'>"+question+"</div>");
	   	all_questions.push(question);
	   	weight.push($("#weight").val());
	   	$("#perspective").val('');
		$("#area_question").val('');
		$("#desc_question").val('');
		$("#param_question").val('');
		$('#weight').val('');
	   	//CKEDITOR.instances.question.setData('<h6>KPI Perspective</h6><h6>Key Result Area</h6><h6>KPI Description</h6><h6>KPI Parameter</h6>');
	   	//$("#question").val('');
	});
	$("#back_to").on('click', function(e){
	    e.preventDefault();
	    $('#link_to_question').removeClass('hide');
	    $("#review").trigger('click');
	});
	$("#assigned").on('click', function(e){
	    e.preventDefault();
	    let one = $('#assign_one').val();
	    let two = $('#assign_two').val();
	    let three = $('#assign_three').val();
	    let four = $('#assign_four').val();
	    let five = $('#assign_five').val();
	    if(one == '' || two == '' || three == '' || four == '' || five == ''){
	        if(one == ''){
	            $('#one').text('Field is Empty');
	        }
	        if(two == ''){
	            $('#two').text('Field is Empty');
	            
	        }
	        if(three == ''){
	            $('#three').text('Field is Empty');
	        }
	        if(four == ''){
	            $('#four').text('Field is Empty');
	            
	        }
	        if(five == ''){
	            $('#five').text('Field is Empty');
	        }
	        return false;
	    }
	    let range = $("#assign_one").val()+"@@@"+$("#assign_two").val()+"@@@"+$("#assign_three").val()+"@@@"+$("#assign_four").val()+"@@@"+$("#assign_five").val();
	    $("#range").val(range);
	    $('.process_form').removeClass('hide');
	    $('#link_to_question').removeClass('hide');
	    $('.process_assign_param').addClass('hide');
	});
    $("body").on('click', "#continue", function(e){
      e.preventDefault();
      //alert("aa");
      let data = all_questions.join("%%%%");
      let allweight = weight.join("%%%%");
      $("#appraisal_data").val(data);
      $("#weight_data").val(allweight);
      $(".show_questions").addClass('hide');
      $('#link_to_question').addClass('hide');
      $('.process_assign_param').removeClass('hide');
      $('.process_form').addClass('hide');
      $('.question_page').addClass('hide');
      $("#add_question").addClass('hide');
      $('#main_question_page').removeClass('hide');
      $('.question_page, .show_questions').slideUp('4000', function(){
      })
	});
	$("body").on('click', "#main_question_page", function(e){
      e.preventDefault();
      $(".show_questions").addClass('hide');
      $('.process_form').addClass('hide');
      $('.process_assign_param').addClass('hide');
      $('.question_page').removeClass('hide');
      $("#add_question").removeClass('hide');
      $('.show_questions, .process_form').slideUp('4000', function(){
      	   $(".question_page").slideDown();
      	   //alert('aaa');
      })
	});
	 $('body').on('click', "#review", function(e){
		e.preventDefault();
		let break_questions = [];
		let n = 1;
		//if(all_questions.length == 0) return false;
		$(".show_questions").removeClass('hide');
		$('.process_form').addClass('hide');
		$('.process_assign_param').addClass('hide');
		$('#add_question').addClass('hide');
		$('#main_question_page').removeClass('hide');
		$("#editdoc").attr('curr','1');
		$('.pagination').html('');
		//$('.edit_this_question').slideUp('fast');
		$(".question_page").slideUp('4000',function(){
		    break_questions = all_questions[0].split(';;;');
		    //alert(break_questions);
		    let pers =break_questions[0].split('@@@')[1];
		    let area = break_questions[1].split('@@@')[1];
		    let desc = break_questions[2].split('@@@')[1];
		    let param = break_questions[3].split('@@@')[1];
		    $('#edit_perspective').val(pers);
		    $('#edit_area_question').val(area);
		    $('#edit_desc_question').val(desc);
		    $('#edit_param_question').val(param);
		    $('#edit_weight').val(weight[0]);
		    //alert(weight[0]);
		    $('#save_edit').attr('curr','0');
			//$(".edit_this_question").html('<h5>KPI PERSPECTIVE</h5><p>'+pers+'</p><h5>KEY RESULT AREA</h5><p>'+area+'</p><h5>KEY DESCRIPTION</h5><p>'+desc+'</p><h5>KEY PARAMETER</h5><p>'+param+'</p>');
			//$(".each_questions").html("<h5>Question 1</h5><p style = 'text-align:justify'>"+all_questions[0]+"</p>");
		    for (var i = 0; i < all_questions.length; i++) {
		     if(i == 0)
		    	$('.pagination').append("<li class='page-item page_link active'  id= 'link"+i+"' curr = '"+i+"'><a class='page-link' href='#'>"+(i+1)+"</a></li>");
			 else if(i <= 6){
			 	n = i;
		        $('.pagination').append("<li class='page-item page_link'  id= 'link"+i+"' curr = '"+i+"'><a class='page-link' href='#'>"+(i+1)+"</a></li>");			 	
			 }
		    }
		    if(all_questions.length > 6){
		    	$(".pagination").append("<li class='page-item show_more_link' curr = '"+n+"'><a class='page-link' href='#' aria-label='Next'>"
                             +"<span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span>"
                             +"</a></li>");
		    } 
		});
	});
	$('body').on('click', ".page_link", function(e){ 
	//$(".page_link").on("click", function(e){
		e.preventDefault();
		let break_questions = [];
		let curr = $("#"+this.id+"").attr("curr");
		//alert(curr);
		$("#editdoc").attr('curr',curr);
		$("#save_edit").attr('curr',curr);
		$(".each_questions").slideUp('2000', function(e){
			//$(".each_questions").html("<h5>Question "+(parseInt(curr) + 1)+"</h5><p style = 'text-align:justify'>"+all_questions[curr]+"</p>");
			break_questions = all_questions[curr].split(';;;');
		    let pers =break_questions[0].split('@@@')[1];
		    let area = break_questions[1].split('@@@')[1];
		    let desc = break_questions[2].split('@@@')[1];
		    let param = break_questions[3].split('@@@')[1];
		    $('#edit_perspective').val(pers);
		    $('#edit_area_question').val(area);
		    $('#edit_desc_question').val(desc);
		    $('#edit_param_question').val(param);
		    $("#edit_weight").val(weight[curr]);
			$('.edit_this_question').slideDown('2000', function(){
				//$(".each_questions").html("<h5>Question "+(parseInt(curr) + 1)+"</h5><p style = 'text-align:justify'>"+all_questions[curr]+"</p>");
				$(".page_link").removeClass("active");
				$("#link"+curr+"").addClass("active");
			});
		});
	});
	$('body').on('click', "#editdoc", function(e){
		e.preventDefault();
		let break_questions = [];
		let curr = $(this).attr('curr');
		//alert(curr);
		$(".each_questions").slideUp('2000', function(e){
		    $('.edit_this_question').slideDown('2000', function(e){
		        break_questions = all_questions[curr-1].split(';;;');
    		    let pers =break_questions[0].split('@@@')[1];
    		    let area = break_questions[1].split('@@@')[1];
    		    let desc = break_questions[2].split('@@@')[1];
    		    let param = break_questions[3].split('@@@')[1];
    		    $('#edit_perspective').val(pers);
    		    $('#edit_area_question').val(area);
    		    $('#edit_desc_question').val(desc);
    		    $('#edit_param_question').val(param);
    		    curr = parseInt(curr) - 1;
    		    $('#save_edit').attr('curr',curr);
		    });
			//$(".each_questions").html("<textarea class ='form-control' id = 'updated_doc' rows ='10'>"+all_questions[curr-1]+"</textarea><div style = 'margin-top: 10px;'><a href = '#' curr = '"+(curr-1)+"' id = 'save_edit' class ='btn btn-primary'>Save Change</a></div>");
		
		});
		
	});
	$('body').on('click', "#save_edit", function(e){
	   e.preventDefault(); 
      let curr = $(this).attr('curr');
      //alert(curr);
      //all_questions[curr] = $("#updated_doc").val(); 
        let perspective = $('#edit_perspective').val();
        let area_question =  $('#edit_area_question').val();
        let desc_question = $('#edit_desc_question').val();
        let param_question = $('#edit_param_question').val();
        $('#edit_param_question').val(param);
       let question = "KPI PERSPECTIVE@@@"+perspective+";;;KPI RESULT AREA@@@"+area_question+";;;KPI DESCRIPTION@@@"+desc_question+";;;KPI PARAMETER@@@"+param_question+"";
       all_questions[curr] = question;
      	//$('.edit_this_question').slideUp('4000'); 
        $(".edit_this_question").slideDown('2000', function(e){
                break_questions = all_questions[curr].split(';;;');
    		    let pers =break_questions[0].split('@@@')[1];
    		    let area = break_questions[1].split('@@@')[1];
    		    let desc = break_questions[2].split('@@@')[1];
    		    let param = break_questions[3].split('@@@')[1];
    		    
    		    //curr = parseInt(curr) - 1;
    		    $('#save_edit').attr('curr',curr);
    		    $('#edit_perspective').val(pers);
    		    $('#edit_area_question').val(area);
    		    $('#edit_desc_question').val(desc);
    		    $('#edit_param_question').val(param);
    		    $("#edit_weight").val(weight[curr]);
    		    $('.edit_this_question').slideUp('4000');
    			$('.edit_this_question').slideDown('2000', function(){
    				//$(".each_questions").html("<h5>Question "+(parseInt(curr) + 1)+"</h5><p style = 'text-align:justify'>"+all_questions[curr]+"</p>");
    				$(".page_link").removeClass("active");
    				$("#link"+curr+"").addClass("active");
    			});
    		    //$(".each_questions").html('<h5>KPI PERSPECTIVE</h5><p>'+pers+'</p><h5>KEY RESULT AREA</h5><p>'+area+'</p><h5>KEY DESCRIPTION</h5><p>'+desc+'</p><h5>KEY PARAMETER</h5><p>'+param+'</p>');
          
			//$(".each_questions").html("<h5>Question "+(parseInt(curr) + 1) +"</h5><p style = 'text-align:justify'>"+all_questions[curr]+"</p>");
			
		});
	});
	$('body').on('click', "#back_btn", function(e){ 
	//$(".show_more_link").on('click', function(e){
		let n = 0;
		let p = 0;
		e.preventDefault();
		let value = parseInt($("#back_btn").attr("start"));
		$(".pagination").html('');
		let _for_back;
		if((value - 6) > 0) _for_back = value - 6;
		else _for_back =  0;
		//alert(value);
		if(value > 0){
			$(".pagination").append("<li class='page-item' id = 'back_btn' start = '"+_for_back+"'><a class='page-link' href='#' aria-label='Previous'>"
                                +"<span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span>"
                                +"</a></li>");
		}
		for (var i = _for_back; i < all_questions.length; i++) {
			 if(p <= 6){
			 	n = i;
				$('.pagination').append("<li class='page-item page_link'  id= 'link"+i+"' curr = '"+i+"'><a class='page-link' href='#'>"+(i+1)+"</a></li>");
			 }
			 p++;
	    }
	    if(all_questions.length > n){
	    	$(".pagination").append("<li class='page-item show_more_link' curr = '"+n+"'><a class='page-link' href='#' aria-label='Next'>"
                             +"<span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span>"
                             +"</a></li>");
	    }

	})
	$('body').on('click', ".show_more_link", function(e){ 
	   //$(".show_more_link").on('click', function(e){
	   	//$(".show_more_link").
	   	let n = 0;
		let iter = 0;
		e.preventDefault();
		$("#back_btn").remove();
		$('.pagination').html('');
		let curr = parseInt($(this).attr('curr'));
		//alert(curr);
		let remain = all_questions.length - curr;
		if(remain > 6) iter = 6 + curr;
		else iter = remain + curr; 
		/*let _for_back;
		if((curr - 6) > 0) _for_back = curr - 6;
		else _for_back =  6 - curr;*/
		$(".pagination").append("<li class='page-item' id = 'back_btn' start = '"+curr+"'><a class='page-link' href='#' aria-label='Previous'>"
                                +"<span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span>"
                                +"</a></li>");
		//alert(iter);
		//$('.pagination').html('');
		for (var i = curr; i < iter; i++) {
			  n = i;
		      $('.pagination').append("<li class='page-item page_link'  id= 'link"+i+"' curr = '"+i+"'><a class='page-link' href='#'>"+(i+1)+"</a></li>");
	    }
	   if(remain > 6){
	 	$(".pagination").append("<li class='page-item show_more_link' curr = '"+n+"'><a class='page-link' href='#' aria-label='Next'>"
                             +"<span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span>"
                             +"</a></li>");
	    }

	})
})