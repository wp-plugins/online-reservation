<?php

/*
	TABLE OF CONTENTS ( DISPLAY	ON FRONT END )
	==========================================
	1.	CEATING SHORTCODE
*/

/*==============================================
	1.	CEATING SHORTCODE
		1.	GENERAL VARIABLE
		2. 	RETRIEVE OPTION DATA
		3.	ENQUEQE SCRIPT AND STYLE
==============================================*/
add_shortcode('reservation_confirmed','olr_restaurant_reservation_confirmed');

function olr_restaurant_reservation_confirmed($args){
		
		$options = get_option( 'olr_all_restaurant_setting' );
		
		$post_id = $_GET['id'];
	
		$database_confirmation_key = get_post_meta( $post_id,'olr_custom_column');
		
		if( $database_confirmation_key[0]['Confirmation Key'] == $_GET['confirmation_key'] ){
			$my_post = array(
				  'ID'           => $post_id,
				  'post_status' => 'Confirmed'
			  );
		
			// Update the post into the database
		  	if( wp_update_post( $my_post ) ){
				$message = 'Confirmation Success';
				if( $options['resto_email']['confirmation_success_message'] != '' ){
					$message = $options['resto_email']['confirmation_success_message'];
				}
				$message;
				
			}else{
				$message = 'Confirmation Failed';
				if( $options['resto_email']['confirmation_failed_message'] != '' ){
					$message = $options['resto_email']['confirmation_failed_message'];
				}
				$message;
			}
			
			echo $message;
				
		}
		
		
	
} // olr_restaurant_reservation_confirmed

	

?>