<?php
/*
	TABLE OF CONTENTS ( GENERAL TAB )
	=======================================
	1.	REGISTER SECTION AND FIELD
	2.	SECTION AND FIELD CALLBACK
	3.	VALIDATION AND SANITIZATION
*/

/*##############################################
	1.	REGISTER SECTION AND FIELD
		1.	SCHEDULE ( SECTION )
		2.  WORKING TIME ( SECTION )
		3.	ALL FIELD
##############################################*/	

			add_action('admin_init', 'olr_restaurant_general_section');
			function olr_restaurant_general_section() {
				
				//= GENERAL VARIABLE == 
				$parent_page 	= 'resto_general_setting';
				$parent_section = 'resto_general_section';
				
				// = Check if the sandbox_theme_display_options is exist on database
				if( false == get_option( 'resto_general_section' ) ) {	
					add_option( 'resto_general_section' );
				} // end if
			
				// 1.  Register SECTION
				add_settings_section(
					$parent_section,				// $unique ID
					'',							// $Page Title
					'',	// $function_callback
					$parent_page				// $Parent Page
				);
			
				// 2.  SUCCESS MESSAGE FIELD
				add_settings_field(	
					'success_message',						// $unique ID
					__('Success Message',PLUGIN_NAME),							// $field title
					'success_message_callback',	// $function_callback	
					$parent_page,			// $Parent page
					$parent_section			// $Parent section
					
				);

				//3. Finally, we register the fields with WordPress
				register_setting(
					$parent_page,	// $option_group	
					$parent_page,		// $option_name
					'olr_general_validation'
				);
				
				
			} // end sandbox_initialize_theme_options



/*##############################################
	2.	SECTION AND FIELD CALLBACK
		1.	SCHEDULE SECTION
		2.	WORKING TIME SECTION
		3.	FIELD
##############################################*/
	
	/*=========================================
		1.	SUCCESS MESSAGE
	=========================================*/
		function success_message_callback() {
			
			$options = get_option( 'resto_general_setting' );
			
			olr_delete_specific_setting_value('resto_general');
			
			olr_grouping_all_setting_value('resto_general','success_message',$options['success_message']);
			
			// Render the output
			echo '<textarea id="textarea_example" name="resto_general_setting[success_message]" rows="5" cols="50">' . 
				$options[ 'success_message' ] . '</textarea>';
			
		}



/*##############################################
	3.	VALIDATION AND SANITIZATION	
##############################################*/		
	
	function olr_general_validation( $input ){
		
		// Create our array for storing the validated options
		$output = array();
		
		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {
			
			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {
			
				// Strip all HTML and PHP tags and properly handle quoted strings
				//	strip_tags() , removing all HTML and PHP tags
				//	stripslashes() , will properly handle quotation marks around a string.
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
				
			} // end if
			
		} // end foreach
		
		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'olr_general_validation', $output, $input );
		
	}
?>