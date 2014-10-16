<?php

	/*
		TABLE OF CONTENTS
		========================
		1.	RESTO BOOKING AJAX SUBMIT
			1.	POST DATA
			2. 	GENERAL VARIABLE
			3.	FORM VERIFICATION
			4.	GOOGLE RECAPTCHA VERIFICATION
			5.	PREVENT CODE INJECTION 
			6.	VALIDATION AND SANITAZATION
			7.	SAVING PROCESS
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
				1.	PLUGIN URL
				2.	PLUGIN OPTIONS
				3.	PERSONAL INFORMATION
				4.	BOOKING TABLE INFORMATION
		########################################*/	
		global	$name;
		global	$email; 			
		global	$phone; 			
		global	$message; 		
		global	$table;	
		global 	$type_of_table;
		global	$persons;		
		global	$lunch; 			
		global	$date;			
		global 	$time;		
		global 	$recipient;
		global 	$from;
		global  $subject;
		global  $messages;
		global  $restaurant_name;
		global  $restaurant_address;
		global  $restaurant_city;
		global  $restaurant_state;
		global  $restaurant_zipcode;
		global  $restaurant_address;
		global  $restaurant_phone;
		global  $restaurant_fax;
		global  $restaurant_email;
		global  $restaurant_website;
		global  $restaurant_logo;
		global  $restaurant_image;
		global  $restaurant_offer_link;
		global  $restaurant_reservation_link;
		global  $restaurant_information;
		global  $restaurant_policies;
		global  $restaurant_facebook;
		global  $restaurant_twitter;
		global  $restaurant_google;
		global  $restaurant_linkedin;
		global  $restaurant_pinterest;
		global  $restaurant_youtube;
		global  $restaurant_footer;
		global  $email_template;
		global 	$text_email;
		global 	$confirmation_link;

		
		$plugin_url = $_POST['plugin_url'];	// 1.	PLUGIN URL
		$options 	= $_POST['options']; // 2.	PLUGIN OPTIONS
		
		
			/*=====================================
				 3.	PERSONAL INFORMATION
			=====================================*/
			$name 			= $_POST['olr_name'];	
			$email 			= $_POST['olr_email'];	
			$phone			= $_POST["olr_phone"];
			$message		= $_POST["olr_message"];
			
			/*=====================================
				 4.	BOOKING TABLE INFORMATION
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
			2. 	GENERAL VARIABLE
		########################################*/	
		$pluginUrl 			= $plugin_url . '/online-reservation';
		$olr['trueImg'] 	= $pluginUrl . '/images/true.gif';
		$olr['post_type'] 	= 'olr_restaurant';
		$olr['meta_key'] 	= 'olr_custom_column';
		
			
		
		/*#################################################
			3.	FORM VERIFICATION
				1.	NONCE ( FORM KEY ) , PREVENT XSS
		#################################################*/
		$nonce 	= $_POST['restaurant_nonce'];	
		if ( 	empty($_POST) 
			|| 	!wp_verify_nonce($nonce,'restaurant_form_verify') 
		){
			echo 'Sorry, your form is not valid.';
			exit;
					
		}
		
		/*#################################################
			4.	GOOGLE RECAPTCHA VERIFICATION
		#################################################*/
		if ( 	isset( $options['resto_captcha']['enable_captcha'] ) 
			&&	$options['resto_captcha']['enable_captcha']
		){
			if( $_SERVER['HTTP_HOST'] == 'localhost' ){
				require_once( str_replace('restaurant reservation','',dirname(__FILE__)) . 'helper\recaptchalib.php');
			}else{
				require_once( str_replace('restaurant reservation','',dirname(__FILE__)) . 'helper/recaptchalib.php');
			}
			
			
			
			$resp = recaptcha_check_answer(
				$options['resto_captcha']['private_key'],
				$_SERVER["REMOTE_ADDR"],
				$_POST["recaptcha_challenge_field"],
				$_POST["recaptcha_response_field"]
			);
			
			
			if (!$resp->is_valid) {
				// What happens when the CAPTCHA was entered incorrectly
				$captcha_error_message = "The reCAPTCHA wasn't entered correctly. try it again.";
			
				if( $options['resto_captcha']['captcha_error_message'] != '' ){
					$captcha_error_message = $options['resto_captcha']['captcha_error_message'];
				}
				$captcha_response = $captcha_error_message .
									"<br/>(reCAPTCHA said: " . $resp->error . ")"; // ONLY FOR DEVELOPMENT 
				echo $captcha_response;
				
				exit;						
										
			}
		} // if ( 	isset($Options['enable_captcha']) 
			

		
		/*########################################
			5.	PREVENT CODE INJECTION 
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
			6.	VALIDATION AND SANITAZATION
		########################################*/
			
			
		/*########################################
			7.	SAVING PROCESS
				1. 	VARIABLE
				2.	FORM VERIFICATION
				3.	CREATE CONFIRMATION KEY
				4.	SAVING DATA TO DATABASE
				5.	SEND EMAIL TO OWNER
				6.	SEND EMAIL TO CUSTOMER
		########################################*/
					
					/*=====================================
						1. 	VARIABLE
					=====================================*/	
					
					$saving_database 			= true;
					$send_email_to_owner		= false;
					if( $options['resto_email']['email_to_owner'] ){
						$send_email_to_owner = true;
					}
					
					$send_email_to_customer		= false;
					if( $options['resto_email']['email_to_customer'] ){
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
							3.	CREATE CONFIRMATION KEY
						=====================================*/
						$confirm_code = md5(uniqid(rand())); 
						$string1 = substr($confirm_code,0,3);
						$string2 = substr($confirm_code,8,11);
						$string3 = substr($confirm_code,5,7);
						$string4 = substr($confirm_code,12,13);
						$string5 = substr($confirm_code,8,11);
						$confirmation_key = $string1.$string2.$string3.$string4.$string5;
						
		
						/*=====================================
							4.	SAVING DATA TO DATABASE
						=====================================*/
						if( $saving_database ) {
							
							$post = array(
											'post_type'		=> $olr['post_type'],
											'post_title'	=> wp_strip_all_tags($name),
											'post_content'	=> $message,
											'post_status'	=> 'waiting-confirmation'
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
										'Booking Time' 		=> $time,
										'Confirmation Key' 	=> $confirmation_key
									);
		
							$success = update_post_meta($post_id, $olr['meta_key'], $meta);
							
							if( $success ){
								
								$success_message = 'Booking Success';
								if( 	isset($options['resto_general']['success_message']) 
									&& 	$options['resto_general']['success_message'] != '' ){
									$success_message = $options['resto_general']['success_message']; 
								}
								
								$confirmation_link = 	$options['resto_thank_you_page']['url'] 
															.'&confirmation_key=' .$confirmation_key
															.'&id=' .$post_id; 
								
								
								echo $success_message;	
								echo "<br />";
								echo "A Confirmation Email has Been Sent to Your Email, 
										Please Click on the Confirmation Link to complete your reservation process";	

							}
		
							
						} // if( $saving_database ) {
	
		
						$email_from = strip_tags( $options['resto_email']['email_from'] );
						$restaurant_icon_exist = false;
						
	
						if( $options['resto_email']['restaurant_name'] != '' ){
							$restaurant_name = $options['resto_email']['restaurant_name'];
						}
						if( $options['resto_email']['restaurant_address'] != '' ){
							$restaurant_address = $options['resto_email']['restaurant_address'];
						}
						if( $options['resto_email']['restaurant_phone'] != '' ){
							$restaurant_phone = $options['resto_email']['restaurant_phone'];
						}
						if( $options['resto_email']['restaurant_fax'] != '' ){
							$restaurant_fax = $options['resto_email']['restaurant_fax'];
						}
						if( $options['resto_email']['restaurant_email'] != '' ){
							$restaurant_email = $options['resto_email']['restaurant_email'];
						}
						if( $options['resto_email']['restaurant_website'] != '' ){
							$restaurant_website = $options['resto_email']['restaurant_website'];
						}
						
						if( $options['resto_email']['restaurant_logo'] != '' ){
							$restaurant_logo = $options['resto_email']['restaurant_logo'];
						}
						if( $options['resto_email']['restaurant_image'] != '' ){
							$restaurant_image = $options['resto_email']['restaurant_image'];
						}
						if( $options['resto_email']['restaurant_offer_link'] != '' ){
							$restaurant_offer_link = $options['resto_email']['restaurant_offer_link'];
						}
						if( $options['resto_email']['restaurant_reservation_link'] != '' ){
							$restaurant_reservation_link = $options['resto_email']['restaurant_reservation_link'];
						}
						if( $options['resto_email']['restaurant_information'] != '' ){
							$restaurant_information = $options['resto_email']['restaurant_information'];
						}
						if( $options['resto_email']['restaurant_policies'] != '' ){
							$restaurant_policies = $options['resto_email']['restaurant_policies'];
						}
						if( $options['resto_email']['restaurant_facebook'] != '' ){
							$restaurant_facebook = $options['resto_email']['restaurant_facebook'];
							$restaurant_icon_exist = true;
						}
						if( $options['resto_email']['restaurant_twitter'] != '' ){
							$restaurant_twitter = $options['resto_email']['restaurant_twitter'];
							$restaurant_icon_exist = true;
						}
						if( $options['resto_email']['restaurant_google'] != '' ){
							$restaurant_google = $options['resto_email']['restaurant_google'];
							$restaurant_icon_exist = true;
						}
						if( $options['resto_email']['restaurant_linkedin'] != '' ){
							$restaurant_linkedin = $options['resto_email']['restaurant_linkedin'];
							$restaurant_icon_exist = true;
						}
						if( $options['resto_email']['restaurant_pinterest'] != '' ){
							$restaurant_pinterest = $options['resto_email']['restaurant_pinterest'];
							$restaurant_icon_exist = true;
						}
						if( $options['resto_email']['restaurant_youtube'] != '' ){
							$restaurant_youtube = $options['resto_email']['restaurant_youtube'];
							$restaurant_icon_exist = true;
						}
						if( $options['resto_email']['restaurant_footer'] != '' ){
							$restaurant_footer = $options['resto_email']['restaurant_footer'];
						}
						
						
						
						
						/*=====================================
							5.	SEND EMAIL TO OWNER
						=====================================*/
						//= CREATE BOUNDARY 
						$boundary = uniqid('np');
						
						if( $send_email_to_owner ) {
							
							$owner_email 			= strip_tags( $options['resto_email']['owner_email'] );
							$owner_email_subject 	= strip_tags( $options['resto_email']['owner_email_subject'] );
							
							
							if( $owner_email != '' ){
								
								//= 1.	RECIPIENT
								$recipient = $owner_email;
								
								//= 2.	SUBJECT
								$subject = $owner_email_subject;
								
								/*================================================
									3.	MESSAGE
										1.	PLAIN TEXT
										2.	HTML
								================================================*/
									require_once('email-content.php');
									
									//= 1.	PLAIN TEXT
									$messages = "\r\n\r\n--" . $boundary . "\r\n";
									$messages .= "Content-type: text/plain;charset=utf-8\r\n\r\n";
									$messages .= $text_email;
									
									
									//= 2.	HTML
									$messages .= "\r\n\r\n--" . $boundary . "\r\n";
									$messages .= "Content-type: text/html;charset=utf-8\r\n\r\n";
									$messages .= $email_template;
									$messages .= "\r\n\r\n--" . $boundary . "--";
								
								$messages = $email_template;
								
								//= 4.	HEADERS
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "From: ".$restaurant_name." \r\n";
								$headers .= "To: ".$name." \r\n";
								//$headers .= "To: ".$email." \r\n";
								//$headers .= "Content-type: text/html;charset=UTF-8" . "\r\n"; // FOR HTML
								$headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n"; // FOR SENDING TEXT AND HTML
								
								if( $_SERVER['HTTP_HOST'] != 'localhost' ){
									$result  = mail($recipient,$subject, $messages,$headers);
								}
								
							} // if( $owner_email != ''){
								
						}	// if( $send_email_to_owner ) {		
								
								
		
								
						/*=====================================
							6.	SEND EMAIL TO CUSTOMER
								1.	RECIPIENT
								2.	SUBJECT
								3.	MESSAGE
								4.	HEADERS
						=====================================*/
						if( $send_email_to_customer ) {
							
							
							$customer_email 			= $email;
							$customer_email_subject 	= strip_tags( $options['resto_email']['customer_email_subject'] );
			
							if( $customer_email != '' ){
								
								//= 1.	RECIPIENT
								$recipient = $customer_email;
								
								//= 2.	SUBJECT
								$subject = $customer_email_subject;
								
							
								/*================================================
									3.	MESSAGE
										1.	PLAIN TEXT
										2.	HTML
								================================================*/
									require_once('email-content.php');
									
									//= 1.	PLAIN TEXT
									$messages = "\r\n\r\n--" . $boundary . "\r\n";
									$messages .= "Content-type: text/plain;charset=utf-8\r\n\r\n";
									$messages .= $text_email;
									
									
									//= 2.	HTML
									$messages .= "\r\n\r\n--" . $boundary . "\r\n";
									$messages .= "Content-type: text/html;charset=utf-8\r\n\r\n";
									$messages .= $email_template;
									$messages .= "\r\n\r\n--" . $boundary . "--";
									
									
							
								
								//= 4.	HEADERS
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "From: ".$restaurant_name." \r\n";
								$headers .= "To: ".$name." \r\n";
								//$headers .= "To: ".$email." \r\n";
								//$headers .= "Content-type: text/html;charset=UTF-8" . "\r\n"; // FOR HTML
								$headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n"; // FOR SENDING TEXT AND HTML
								
								if( $_SERVER['HTTP_HOST'] != 'localhost' ){
									$result  = mail($recipient,$subject, $messages,$headers);
								}
								
							
							} // if( $customer_email != ''){
							
							
						}	// if( $send_email_to_customer ) {
					
					} // if ( empty($_POST) || !wp_verify_nonce($nonce,'restaurant_form_verify') ){	
	

		// IMPORTANT: don't forget to "exit"
		exit;
	
	
	} // function myajax_submit() {
	
	
?>