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
add_shortcode('online_restaurant_reservation','olr_shortcode_display');

function olr_shortcode_display($args){
	
		/*==============================================
			1.	GENERAL VARIABLE
		==============================================*/
		
		/*==============================================
			2. 	RETRIEVE OPTION DATA
		==============================================*/
		//$options = get_option( 'resto_schedule_setting' );
		$options = get_option( 'olr_all_restaurant_setting' );
		
		/*==============================================
			3.	ENQUEQE SCRIPT AND STYLE
		==============================================*/
		if( !is_admin() ) {
			
			if( !wp_script_is('jquery-ui-datepicker') ){
				wp_enqueue_script( 'jquery-ui-datepicker' );
			}
			wp_enqueue_style(
				'olr-date-picker-style',	// $handle (id)	
				OLR_FOLDER .'css/jquery.ui.datepicker.css', // $sr
				false, 	// $dependencies
				false,	// $version
				false 	// in footer
			); 
			wp_enqueue_style(
				'olr-front-style',	// $handle (id)	
				OLR_FOLDER .'css/restaurant-front-style.css', // $sr
				false, 	// $dependencies
				false,	// $version
				false 	// in footer
			);  
			wp_enqueue_script( 
				'olr-script',
				OLR_FOLDER . 'js/restaurant-script.js', // $src 
				array(), 
				false, 
				true 
			);
			
			$any_data_array 	= array( 
										'plugin_folder' 	=> OLR_FOLDER,
										'early_bookings' 	=> $options['resto_schedule']['early_bookings'],
										'late_bookings' 	=> $options['resto_schedule']['late_bookings'],
										'plugin_options' 	=> get_option('olr_all_restaurant_setting'),
										'ajaxurl'         	=> admin_url( 'admin-ajax.php' )
										
										);
			wp_localize_script( 'olr-script', 'data', $any_data_array );
			
		} 

		
		//======== NOT USED , BECAUSE THE SHORTCODE IS FILLED WITH ALL ATTRIBUTE ================
		extract(shortcode_atts(array(
			/*'img'		=> 'small',
			'des'		=> 'blue',*/
		), $atts));
		
		$out = '';
		$out = restaurant_reservation_content($options);
		return $out;
	
} // olr_shortcode_display

	

?>