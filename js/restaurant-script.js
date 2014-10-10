jQuery(document).ready(function($){ 
	
	/*
		TABLE OF CONTENTS
		========================
		1.	init ( INITIALIZE )
			1. 	GLOBAL VARIABLES
			2.	DATE PICKER
			3.	RESTAURANT BOOKING FORM	
	*/



	var Olr = {
		init : function() {
			
			//= 1. 	GLOBAL VARIABLES
			this.plugin_folder 	= data.plugin_folder,
			this.early_bookings = data.early_bookings, 
			this.late_bookings 	= data.late_bookings; 
			this.plugin_options = data.plugin_options; 
			this.ajaxurl		= data.ajaxurl; 
			
			
			//= 2.	DATE PICKER
			if( $('#olr_date').length > 0 ){
				$('#olr_date').datepicker({minDate: 0});
			}
			
			//= 3.	RESTAURANT BOOKING FORM
			this.restaurant_booking_form();
			
		},
		
		
		restaurant_booking_form:function() {
			
			/*
				TABLE OF CONTENTS
				========================
				1. 	GENERAL VARIABLE
				2.	VALIDATION 
				3.	CHECK LATE AND EARLY BOOKINGS
				4.	CHECK TOTAL TABLE
				5. 	BOOKING BUTTON ( ONCLICK )
			*/
					

			/*==================================
				1. 	GENERAL VARIABLE
			==================================*/
			var loading_img 			= this.plugin_folder + "/image/loading.gif";
			var check_date_url 			= this.plugin_folder + "/restaurant reservation/check-date.php";
			var check_total_table_url 	= this.plugin_folder + "/restaurant reservation/total_table.php";
			plugin_folder 				= this.plugin_folder;
			plugin_options				= this.plugin_options;
			ajaxurl						= this.ajaxurl;
			
			
			/*==================================
				2.	VALIDATION 
					1.	PERSONAL INFORMATION
						1.	NAME
						2.	EMAIL
						3.	PHONE
							
					2.	BOOKING TABLE INFORMATION
						2.	PERSONS
			==================================*/
				$("#olr_name,#olr_email,#olr_phone,#olr_persons").keyup(function(){
					var id = $(this).attr('id');
					
					
					//=	1.	CHECK FIELD NAME ===
					if(	id == 'olr_name' ){
			
						if( /^[A-Za-z]+$/.test( $(this).val() ) == false ){
							$(this).val($(this).val().substring(0,$(this).val().length-1));
						}
					}
				
					if(	id == 'olr_phone' ){
						if( /^[0-9-()+]{1,20}$/.test( $(this).val() ) == false ){
							$(this).val($(this).val().substring(0,$(this).val().length-1));
						}
					
					}
				
					if(	id == 'olr_persons' ){
						if( /[0-9]+$/.test( $(this).val() ) == false ){
							$(this).val($(this).val().substring(0,$(this).val().length-1));
						}
					
					}
				});
				
			
			//alert( this.plugin_folder );
			
			
			/*===========================================
				3.	CHECK LATE AND EARLY BOOKINGS
					1.	VARIABLE	
					2.	CHECK DATE
			===========================================*/
			$("#olr_date,#olr_time").change(function(){
					
					if( 	$("#olr_date").val() != '' 
						&& 	$("#olr_time").val() != '' ){
						
						
						//= 1.	VARIABLE ===
						var postData= {};
						postData['date'] 		= $("#olr_date").val();
						postData['time'] 		= $("#olr_time").val();
						postData['plugin_url'] 	= plugin_folder;
						postData['options'] 	= plugin_options;
						
						
						//= 2.	CHECK DATE == 
						$.post(check_date_url, postData, function(data) {
							
							if( data != '' ){
									
									//= SEARCH FOR ","
									if( data.search("}") > 0 ){
										
										var data = data.split("}");
										if( data.length > 0 ){
											for (var i = 0; i< data.length; i++) {
												if( i == 0 && data[i] != ''){
													//alert(data[i]);
													
													var display = data[i].split("<br/>");
													alert( 	display[0] + '\n\n' 
															+ display[1] + '\n\n' 
															+ display[2] + '\n\n' 
															+ display[3]
															);
												}
												
												if( i == 1  && data[i] != ''){
												//if( i == 2 && data[i] != ''){
													$('#olr_date').val('');	
													if( $('.date_error').length > 0 ){
														$('.date_error').remove();
													}
													$('.olr_date_wrap').append('<span class="date_error">'+data[i]+'<span>');	
													
												}else if( i == 1  && data[i] == '' ){
													if( $('.date_error').length > 0 ){
														$('.date_error').remove();
													}
												}
												
												if( i == 2  && data[i] != ''){
												//if( i == 2 && data[i] != ''){
													$('#olr_time').val('');
													if( $('.time_error').length > 0 ){
														$('.time_error').remove();
													}
													
													$('.olr_time_wrap').append('<span class="time_error">'+data[i]+'<span>');	
						
												}else if( i == 2  && data[i] == '' ){
													if( $('.time_error').length > 0 ){
														$('.time_error').remove();
													}
												}

											}
										}
									
									}else if( data.search("!") > 0 ){
										$('#olr_date').val('');
										alert(data);
										
									}else{
										alert(data);									}
									
								}else{
									if( $('.date_error').length > 0 ){
										$('.date_error').remove();
									}
									if( $('.time_error').length > 0 ){
										$('.time_error').remove();
									}
								
								}  // if( data != '' ){
							
							
							
						});
						
		
					} // if( 	$("#olr_time").val() != '' 
							   
			}); // $("#olr_date,#olr_time").change(function(){
			
			
			/*==================================
				4.	CHECK TOTAL TABLE
			==================================*/
			if($("#olr_type_of_table").length > 0 ){
				$("#olr_type_of_table").change(function(){
					
					var postData= {};
						postData['options'] 	= plugin_options;
						postData['table_name'] 	= $(this).val();
					
					$.post(check_total_table_url, postData, function(data) {
						$("#olr_table")
						.find('option')
						.remove()
						.end()
						.append(data);
					});										 
														 
				});
			}
			
			/*==================================
				5. 	BOOKING BUTTON ( ONCLICK )
					1.	VARIABLE
					2.	GOOGLE RECAPTCHA VARIABLE
					3.	NONCE 
					4.	VALIDATION 
					5. 	CHECK REQUIRED FIELDS
					6. 	COLLECT ALL POST DATA
					7. 	SUBMIT FORM
			==================================*/
			$("#olr_restaurant_booking_button").click(function(event){
						
				event.preventDefault();
				var error = false;
				var postData= {};
				var error_content = '';
				
				//= 1.	VARIABLE ===
				var postData= {};
					postData['plugin_url'] 	= plugin_folder;
					postData['options'] 	= plugin_options;
					postData['action'] 		= 'resto-booking-ajax-submit';
					
					
				//=	2.	GOOGLE RECAPTCHA VARIABLE
				if( $("#recaptcha_challenge_image").length > 0 ){
						postData['recaptcha_challenge_field'] 		= $("#recaptcha_challenge_field").val();
						postData['recaptcha_response_field'] 		= $("#recaptcha_response_field").val();
				}
				
					
				//= 3.	NONCE 
				postData['restaurant_nonce'] = $('#olr_restaurant_form').find('#restaurant_nonce_id').val()
				
				//= 4.	VALIDATION 
				if( /[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}/.test( $('#olr_email').val() ) == false ){
					error = true;
					error_content += 'Email is not Valid \n';
				}
					
				
				//= 5. 	CHECK REQUIRED FIELDS
				$('.olr_restaurant_wrapper').find('.olr_required').each(function(index){
					if( $(this).prev().val() == '' ){
						error = true;
					}
				});
				
				//= 6. 	COLLECT ALL POST DATA
				$('#olr_restaurant_form p').find(':text,select,textarea').each(function(index){
					postData[$(this).attr('id')] = $(this).val();																																		
				});
				$('#olr_restaurant_form div').find(':text,select,textarea').each(function(index){
					postData[$(this).attr('id')] = $(this).val();																																		
				});
				

				//=	7. 	SUBMIT FORM
				if( error ){
					
					error_content += 'All Required Fields must be filled or selected ';
					alert( error_content );
					
				}else{
					if( $('#theImg').length == 0 ){
						$('#olr_restaurant_response').prepend('<img id="theImg" src="'+loading_img+'" /><span>Please Wait...</span>');	
					}	
					
					$.post(ajaxurl,postData, function(data) {
						//alert( data );
						var captcha_error = false;
						
						if( $("#recaptcha_challenge_image").length > 0 ){
							Recaptcha.reload();
							var captcha_error_msg = data;
							if( captcha_error_msg.search(/reCAPTCHA said/i) > 0 ){
								var data = captcha_error_msg.split("<br/>");
								$('.olr_captcha_response_error').text(data[0]);
								$('#recaptcha_response_field').val('').focus();
								$('#olr_restaurant_response').html('');
								captcha_error = true;
							}else{
								$('.olr_captcha_response_error').text('');
							}
						}
						
						if( !captcha_error ){
							$('#olr_restaurant_response').html(data);
						}
					});				
				}
				
			}); // $("#olr_restaurant_booking_button").click(function(event){
			
			
	
		} // restaurant_booking_form:function() {
					
	}
	
	//initialize Archieve
	Olr.init();
	
});