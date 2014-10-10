<?php
/*
	TABLE OF CONTENTS ( SCHEDULE TAB )
	=======================================
	1.	REGISTER SECTION AND FIELD
	2.	SECTION AND FIELD CALLBACK
	3.	VALIDATION AND SANITIZATION
*/

/*##############################################
	1.	REGISTER SECTION AND FIELD
		1.	CAPTCHA ( SECTION )
		2.	ALL FIELD
##############################################*/

			add_action('admin_init', 'olr_restaurant_captcha_section');
			function olr_restaurant_captcha_section() {
				
				//= GENERAL VARIABLE == 
				$parent_page 	= 'resto_captcha_setting';
				$parent_section = 'resto_captcha_section';
				
				
				// = Check if the sandbox_theme_display_options is exist on database
				if( false == get_option( 'resto_captcha_section' ) ) {	
					add_option( 'resto_captcha_section' );
				} 
				
				
				//= 1.	CAPTCHA ( SECTION )
				add_settings_section(
					$parent_section,		// $unique ID
					'',						// $Page Title
					'olr_resto_captcha_section',	// $function_callback
					$parent_page					// $Parent Page
				);
				
				
				/*=============================================
					2.	ALL FIELD
						1.	ENABLE GOOGLE RECAPTCHA
						2.	PUBLIC KEY
						3.	PRIVATE KEY
						4.	THEME
						5.	CAPTCHA ERROR MESSAGE
				=============================================*/
				$fields_owner = array(
									// array ( $id , $title , $args )
									array('enable_captcha','Enable Google Recaptcha', array('enable_captcha') ), // 1.	ENABLE GOOGLE RECAPTCHA
									array('public_key','Public Key', array('public_key') ), // 2.	PUBLIC KEY
									array('private_key','Private Key', array('private_key') ), // 3.	PRIVATE KEY
									array('captcha_theme','Theme', array('captcha_theme') ), // 4.	THEME
									array('captcha_error_message','Captcha Error Message', array('captcha_error_message') ), // 5.	CAPTCHA ERROR MESSAGE
									
								);
				
				foreach( $fields_owner as $field ){
					add_settings_field(	
						$field[0],						// $unique ID
						$field[1],							// $field title
						'olr_captcha_field',	// $function_callback	
						$parent_page,			// $Parent page
						$parent_section,		// $Parent section
						$field[2]
					);
					
				}
				
				//3. Finally, we register the fields with WordPress
				register_setting(
					$parent_page,	// $option_group	
					$parent_page,		// $option_name	
					'olr_captcha_validation'
				);
				
				
			} // function olr_restaurant_table_section() {


/*##############################################
	2.	SECTION AND FIELD CALLBACK
		1.	CAPTCHA ( SECTION )
		2.	ALL FIELD
##############################################*/

	/*=========================================
		1.	GENERAL SECTION 
	=========================================*/
	function olr_resto_captcha_section($args){
		echo '<p>You must <a href="https://www.google.com/recaptcha/admin#whyrecaptcha">Signup</a> , to get Public and Private Key</p>';
		echo '<p><strong>Steps</strong></p>';
		echo '<p> 1. Sign Up </p>';
		echo '<p> 2. On My Account Tab , enter your site Domain , click create </p>';
		echo '<p> 3. Click on your domain , you will see public and private key </p>';
		echo '<hr />';
		
	}
	
	/*=========================================
		2.	ALL FIELD
			1.	ENABLE GOOGLE RECAPTCHA
			2.	PUBLIC KEY
			3.	PRIVATE KEY
			4.	THEME
	=========================================*/
	function olr_captcha_field($args){
		
		$options = get_option( 'resto_captcha_setting' );
		
		olr_delete_specific_setting_value('resto_captcha');
			
		if( $options != '' ){
			foreach( $options as $key => $val ){
				olr_grouping_all_setting_value('resto_captcha',$key,$val);
			}
		}		
	
		/*=========================================
			1.	ENABLE GOOGLE RECAPTCHA
		=========================================*/
		if( $args[0] == 'enable_captcha' ){
			echo '<input type="checkbox" id="'.$args[0].'" name="resto_captcha_setting['.$args[0].']" value="1" '.checked(1, $options[$args[0]], false) .' />';
		}
		
	
		/*=========================================
			2.	PUBLIC KEY
		=========================================*/
		if( $args[0] == 'public_key' ){
			echo '<input type="text" class="captcha_public_key" id="'.$args[0].'" name="resto_captcha_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		/*=========================================
			3.	PRIVATE KEY
		=========================================*/
		if( $args[0] == 'private_key' ){
			echo '<input type="text" class="captcha_private_key" id="'.$args[0].'" name="resto_captcha_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		/*=========================================
			4.	THEME
		=========================================*/
		if( $args[0] == 'captcha_theme' ){
			?>
            	<select name="resto_captcha_setting[<?php echo $args[0]?>]" id="<?php echo $args[0] ?>">
                    <option value="red" <?php selected( $options[$args[0]], 'anytime' ); ?>>Red</option>
                    <option value="white" <?php selected( $options[$args[0]], '1 day' ); ?>>White</option>
                    <option value="blackglass" <?php selected( $options[$args[0]], '1 week' ); ?>>Black Glass</option>
                    <option value="clean" <?php selected( $options[$args[0]], '2 week' ); ?>>Clean</option>
               
                </select>
            <?php 
		}
		
		/*=========================================
			5.	CAPTCHA ERROR MESSAGE
		=========================================*/
		if( $args[0] == 'captcha_error_message' ){
			echo '<textarea id="'.$args[0].'" name="resto_captcha_setting['.$args[0].']" rows="5" cols="50">' . 
				$options[$args[0]] . '</textarea>';
		}
		
		
		

		
	} // function olr_email_field($args){
	
	
/*##############################################
	3.	VALIDATION AND SANITIZATION	
##############################################*/		
	
	function olr_captcha_validation( $input ){
		
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
		return apply_filters( 'olr_captcha_validation', $output, $input );
		
	}
		
?>