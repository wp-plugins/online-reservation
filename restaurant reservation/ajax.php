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
		global	$name;
		global	$email; 			
		global	$phone; 			
		global	$message; 		
		global	$table;			
		global	$persons;		
		global	$lunch; 			
		global	$date;			
		global 	$time;		
		global 	$recipient;
		global 	$from;
		global  $subject;
		global  $messages;
		global  $email_header_image;
		global 	$email_icon_exist;
		global  $email_facebook;
		global  $email_twitter;
		global  $email_google;
		global  $email_linkedin;
		global  $email_pinterest;
		global  $email_youtube;
		global  $email_template;
		
	
		
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
				1. 	VARIABLE
				2.	FORM VERIFICATION
				3.	SAVING DATA TO DATABASE
				4.	SEND EMAIL TO OWNER
				5.	SEND EMAIL TO CUSTOMER
		########################################*/
					
					/*=====================================
						1. 	VARIABLE
					=====================================*/	
					
					$saving_database 			= true;
					$send_email_to_owner		= false;
					if( $options['email_to_owner'] ){
						$send_email_to_owner = true;
					}
					
					$send_email_to_customer		= false;
					if( $options['email_to_customer'] ){
						$send_email_to_customer	 = true;
					}
					
					
						// $emailBot = new Email; // HOSTGATOR CAN'T USED THIS CLASS
					
					/*=====================================
						2.	FORM VERIFICATION
					=====================================*/
					if ( empty($_POST) || !wp_verify_nonce($nonce,'restaurant_form_verify') ){
						print 'Sorry, your form is not valid.';
						exit;
					
					}else{
					
						/*=====================================
							3.	SAVING DATA TO DATABASE
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
	
					
						

						$email_from = strip_tags( $options['email_from'] );
						$email_icon_exist = false;
						
						if( $options['email_header_image'] != '' ){
							$email_header_image = $options['email_header_image'];
							$email_icon_exist = true;
						}
						if( $options['email_facebook'] != '' ){
							$email_header_image = $options['email_facebook'];
							$email_icon_exist = true;
						}
						if( $options['email_twitter'] != '' ){
							$email_header_image = $options['email_twitter'];
							$email_icon_exist = true;
						}
						if( $options['email_google'] != '' ){
							$email_header_image = $options['email_google'];
							$email_icon_exist = true;
						}
						if( $options['email_linkedin'] != '' ){
							$email_header_image = $options['email_linkedin'];
							$email_icon_exist = true;
						}
						if( $options['email_pinterest'] != '' ){
							$email_header_image = $options['email_pinterest'];
							$email_icon_exist = true;
						}
						if( $options['email_youtube'] != '' ){
							$email_header_image = $options['email_youtube'];
							$email_icon_exist = true;
						}
						
				
						
						/*=====================================
							4.	SEND EMAIL TO OWNER
						=====================================*/
						if( $send_email_to_owner ) {
							
							$owner_email 			= strip_tags( $options['owner_email'] );
							$owner_email_subject 	= strip_tags( $options['owner_email_subject'] );
							
							
							if( $owner_email != ''){
							
								$recipient = $owner_email;
								$from = $email_from;
								$subject = $owner_email_subject;
								
								require_once('email-template.php');
								
								$messages = $email_template;
								
								echo $messages;
								
								if( $_SERVER['HTTP_HOST'] != 'localhost' ){
									$result  = mail($recipient, $from, $subject, $messages);
								}
								if( $result){
									echo '<span id="contactSuccessImg"></span>';
								}else{
									echo '<span id="contactFailedImg"></span><br>';
								}
							
							} // if( $owner_email != ''){
								
						}	// if( $send_email_to_owner ) {		
								
								
		
								
						/*=====================================
							5.	SEND EMAIL TO CUSTOMER
						=====================================*/
						if( $send_email_to_customer ) {
							
							
							$customer_email 			= $email;
							$customer_email_subject 	= strip_tags( $options['customer_email_subject'] );
			
							if( $owner_email != ''){
							
								$recipient = $customer_email;
								$from = $email_from;
								$subject = $customer_email_subject;
								
								$messages  = "From ( " . $from ." )\n";
								$messages .= "Subject ( " . $subject ." )\n";
								$messages .= "Type of Table ( " . $type_of_table ." )\n";
								$messages .= "Table ( " . $table ." )\n";
								$messages .= "Persons ( " . $persons ." )\n";
								$messages .= "Date ( " . $date ." )\n";
								$messages .= "Time ( " . $time ." )\n";
								$messages .= $message;
								
								
								if( $_SERVER['HTTP_HOST'] != 'localhost' ){
									$result  = mail($recipient, $from, $subject, $messages);
								}
								if( $result){
									echo '<span id="contactSuccessImg"></span>';
								}else{
									echo '<span id="contactFailedImg"></span><br>';
								}
							
							} // if( $owner_email != ''){	
							
							
						}	// if( $send_email_to_owner ) {
					
					} // if ( empty($_POST) || !wp_verify_nonce($nonce,'restaurant_form_verify') ){	
	

		// IMPORTANT: don't forget to "exit"
		exit;
	
	
	} // function myajax_submit() {
	
	
?>