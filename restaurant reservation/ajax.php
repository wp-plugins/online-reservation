<?php

	/*
		TABLE OF CONTENTS
		========================
		1.	RESTO BOOKING AJAX SUBMIT
		1.	POST DATA
		2. 	GENERAL VARIABLE
		2.	RETRIEVE DATABASE DATA
		3.	POST DATA
		4.	PREVENT CODE INJECTION 
		5.	VALIDATION AND SANITAZATION
		6.	SAVING PROCESS
	*/
	

	
	/*#################################################################
		1.	RESTO BOOKING AJAX SUBMIT
			IS TRIGGERED ON , restaurant-script.js
			postData['action'] 		= 'resto-booking-ajax-submit';
	#################################################################*/	
	add_action( 'wp_ajax_nopriv_resto-booking-ajax-submit', 'olr_resto_booking_ajax' );
	add_action( 'wp_ajax_resto-booking-ajax-submit', 'olr_resto_booking_ajax' );
		 
	function olr_resto_booking_ajax() {
		
		
		/*########################################
			1.	POST DATA
		########################################*/	
		$plugin_url = $_POST['plugin_url'];
		$Options 	= $_POST['options'];
	
	
	
		/*########################################
			2. 	GENERAL VARIABLE
		########################################*/	
		$pluginUrl 			= $plugin_url . '/online-reservation';
		$olr['trueImg'] 	= $pluginUrl . '/images/true.gif';
		$olr['post_type'] 	= 'olr_restaurant';
		$olr['meta_key'] 	= 'olr_custom_column';
		
		
		
		/*########################################
			2.	RETRIEVE DATABASE DATA
		########################################*/	
		$options = $Options;	
		
	
		/*########################################
			3.	POST DATA
				1.	NONCE ( FORM KEY ) 
				1.	PERSONAL INFORMATION
				2.	BOOKING TABLE INFORMATION
		########################################*/	
		
			/*========================================
				 1.	NONCE ( FORM KEY ) , PREVENT XSS
			========================================*/
			$nonce 			= $_POST['restaurant_nonce'];	
			
			/*=====================================
				 1.	PERSONAL INFORMATION
			=====================================*/
			$name 			= $_POST['olr_name'];	
			$email 			= $_POST['olr_email'];	
			$phone			= $_POST["olr_phone"];
			$message		= $_POST["olr_message"];
			
			/*=====================================
				 2.	BOOKING TABLE INFORMATION
			=====================================*/
			$type_of_table = '';
			if( 	isset($_POST["olr_type_of_table"]) 
				||	$_POST["olr_type_of_table"] != ''){
				$type_of_table	= $_POST["olr_type_of_table"];
			}
			$table			= $_POST["olr_table"];
			$persons 		= $_POST["olr_persons"];
			$lunch 			= $_POST["olr_lunch"];
			$date			= $_POST["olr_date"];
			$time 			= $_POST["olr_time"];
		
		
		
		/*########################################
			4.	PREVENT CODE INJECTION 
		########################################*/
		$name 			= strip_tags($name);
		$email 			= strip_tags($email);
		$phone 			= strip_tags($phone);
		$message 		= strip_tags($message);
		$table			= strip_tags($table);
		$persons		= strip_tags($persons);
		$lunch 			= strip_tags($lunch);
		$date			= strip_tags($date);
		$time			= strip_tags($time);
	
	
	
		/*########################################
			5.	VALIDATION AND SANITAZATION
		########################################*/
			
			
		/*########################################
			6.	SAVING PROCESS
				1.	FORM VERIFICATION
				2.	SAVING DATA TO DATABASE
				3.	SENDING EMAIL
		########################################*/
					
					$saving_database 	= true;
					$send_email			= false;		
						// $emailBot = new Email; // HOSTGATOR CAN'T USED THIS CLASS
					
					/*=====================================
						1.	FORM VERIFICATION
					=====================================*/
					if ( empty($_POST) || !wp_verify_nonce($nonce,'restaurant_form_verify') ){
						print 'Sorry, your form is not valid.';
						exit;
					
					}else{
					
						/*=====================================
							2.	SAVING DATA TO DATABASE
						=====================================*/
						if( $saving_database ) {
							
							$post = array(
											'post_type'		=> $olr['post_type'],
											'post_title'	=> wp_strip_all_tags($name),
											'post_content'	=> $message
										);
							
							$post_id = wp_insert_post( $post);
							
							$meta = array(
										'Phone' 			=> wp_strip_all_tags($phone),
										'Email' 			=> wp_strip_all_tags($email),
										'Type of Tables'	=> $type_of_table,
										'Tables' 			=> $table,
										'Persons' 			=> wp_strip_all_tags($persons),
										'Lunch / Dinner' 	=> $lunch,
										'Booking Date' 		=> $date,
										'Booking Time' 		=> $time
									);
		
							$success = update_post_meta($post_id, $olr['meta_key'], $meta);
							
							if( $success ){
								
								$success_message = 'Booking Success';
								if( isset($options['success_message']) && $options['success_message'] != '' ){
									$success_message = $options['success_message']; 
								}
	
								echo $success_message;	
							}
		
							
						} // if( $saving_database ) {
	
						
						/*=====================================
							 3.	SENDING EMAIL
						=====================================*/
						if( $send_email	) {
							
							$recipient = get_theme_mod( 'contact_recepient_email_address');
							$from = $name .'<'.$email .'>';
							$subject = $subject;
							
							/*$messages .= " From : " . $name .'<br>'; // HOSTGATOR NOT ALLOWED  ( : )
							$messages = " Email : " . $email .'<br>';
							$messages .= " IP : " . $Visitor_IpAddress ."<br>";
							$messages .= " Telephone : " . $telephone ."<br>";
							$messages .= " Website : " . $website_url ."<br><br>";
							$messages .= $message;*/
							
							$messages  = "From ( " . $name ." )\n";
							$messages .= "Subject ( " . $subject ." )\n";
							$messages .= "Email ( " . $email ." )\n";
							$messages .= "ip ( " . $Visitor_IpAddress ." )\n";
							$messages .= "Telephone ( " . $telephone ." )\n";
							$messages .= "Website ( " . $website_url ." )\n\n";
							$messages .= $message;
							
							
							if( $_SERVER['HTTP_HOST'] != 'localhost' ){
								//$result  = $emailBot->sendEmail($recipient, "testsub from testmailer", $subject, $messages);
								$result  = mail($recipient, $from, $subject, $messages);
							}
							if( $result){
								echo '<span id="contactSuccessImg">'.get_theme_mod('contact_sucess_msg').'</span>';
							}else{
								echo '<span id="contactFailedImg">'.get_theme_mod('failed_sucess_msg').'</span><br>';
							}
							
						}	// if( $send_email	) {
					
					} // if ( empty($_POST) || !wp_verify_nonce($nonce,'restaurant_form_verify') ){	
	

		// IMPORTANT: don't forget to "exit"
		exit;
	
	
	} // function myajax_submit() {
	
	
?>