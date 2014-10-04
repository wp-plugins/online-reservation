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
		1.	GENERAL , OWNER AND CUSTOMER ( SECTION )
		2.	GENERAL FIELD
		3.	OWNER FIELD
		4.	CUSTOMER FIELD
##############################################*/	

			add_action('admin_init', 'olr_restaurant_email_section');
			function olr_restaurant_email_section() {
				
				//= GENERAL VARIABLE == 
				$parent_page 	= 'resto_email_setting';
				$general_section = 'resto_email_general_section';
				$owner_section = 'resto_email_owner_section';
				$customer_section =	'resto_email_customer_section';
				
				
				// = Check if the sandbox_theme_display_options is exist on database
				if( false == get_option( 'resto_email_general_section' ) ) {	
					add_option( 'resto_email_general_section' );
				} // end if
				if( false == get_option( 'resto_email_owner_section' ) ) {	
					add_option( 'resto_email_owner_section' );
				} // end if
				if( false == get_option( 'resto_email_customer_section' ) ) {	
					add_option( 'resto_email_customer_section' );
				} // end if
				
				
				/*=========================================
					1.	OWNER AND CUSTOMER ( SECTION )
				=========================================*/
				add_settings_section(
					$general_section,		// $unique ID
					'',						// $Page Title
					'olr_general_email_section',	// $function_callback
					$parent_page					// $Parent Page
				);
				add_settings_section(
					$owner_section,		// $unique ID
					'',						// $Page Title
					'olr_owner_email_section',	// $function_callback
					$parent_page					// $Parent Page
				);
				add_settings_section(
					$customer_section,		// $unique ID
					'',						// $Page Title
					'olr_customer_email_section',	// $function_callback
					$parent_page					// $Parent Page
				);
				
				
				/*=======================================
					2.	GENERAL FIELD
						1.	FROM ( YOUR STORE NAME )
				=======================================*/
				$fields_owner = array(
									// array ( $id , $title , $args )
									array('email_from','From ( Your Store Name )', array('email_from') ) // 1.	FROM ( YOUR STORE NAME )
                         		);
				
				foreach( $fields_owner as $field ){
					add_settings_field(	
						$field[0],						// $unique ID
						$field[1],							// $field title
						'olr_email_field',	// $function_callback	
						$parent_page,			// $Parent page
						$general_section,		// $Parent section
						$field[2]
					);
					
				}
				
				
				
				
				
				
				
				
				

				/*=======================================
					3.	OWNER FIELD
						1.	SEND EMAIL TO OWNER
						2.	OWNER EMAIL
						3.	OWNER EMAIL SUBJECT
				=======================================*/
				$fields_owner = array(
									// array ( $id , $title , $args )
									array('email_to_owner','Send Email To Owner', array('email_to_owner') ), // 1.	SEND EMAIL TO OWNER
									array('owner_email','Owner Email', array('owner_email') ), // 2.	OWNER EMAIL
									array('owner_email_subject','Email Subject', array('owner_email_subject') ) // 3.	OWNER EMAIL SUBJECT
                         		);
				
				foreach( $fields_owner as $field ){
					add_settings_field(	
						$field[0],						// $unique ID
						$field[1],							// $field title
						'olr_email_field',	// $function_callback	
						$parent_page,			// $Parent page
						$owner_section,		// $Parent section
						$field[2]
					);
					
				}
				
				
				
				/*=======================================
					4.	CUSTOMER FIELD
						1.	SEND EMAIL TO CUSTOMER
						2.	CUSTOMER EMAIL SUBJECT
				=======================================*/
				$fields_customer = array(
									// array ( $id , $title , $args )
									array('email_to_customer','Send Email To Customer', array('email_to_customer') ), // 1.	SEND EMAIL TO CUSTOMER
									array('customer_email_subject','Email Subject', array('customer_email_subject') ), // 2.	CUSTOMER EMAIL SUBJECT
								
								
                         		);
				
				foreach( $fields_customer as $field ){
					add_settings_field(	
						$field[0],						// $unique ID
						$field[1],							// $field title
						'olr_email_field',	// $function_callback	
						$parent_page,			// $Parent page
						$customer_section,		// $Parent section
						$field[2]
					);
					
				}
				
				
				
				
				

				
				//3. Finally, we register the fields with WordPress
				register_setting(
					$parent_page,	// $option_group	
					$parent_page,		// $option_name	
					'olr_email_validation'
				);
				
				
			} // function olr_restaurant_table_section() {


/*##############################################
	2.	SECTION AND FIELD CALLBACK
		1.	GENERAL SECTION 
		2.	OWNER SECTION
		3.	CUSTOMER SECTION
		4.	FIELD
##############################################*/

	/*=========================================
		1.	GENERAL SECTION 
	=========================================*/
	function olr_general_email_section($args){
		echo '<h3 class="setting_section_title">GENERAL</h3><hr />';
	}
	
	
	/*=========================================
		2.	OWNER SECTION
	=========================================*/
	function olr_owner_email_section($args){
		echo '<h3 class="setting_section_title">Restaurant Owner</h3><hr />';
	}
	
	/*=========================================
		3.	CUSTOMER SECTION
	=========================================*/
	function olr_customer_email_section($args){
		echo '<br /><h3 class="setting_section_title">Customer</h3><hr />';
	}

	/*=========================================
		4.	FIELD
			1.	GENERAL
				1.	FROM ( YOUR STORE NAME )
	
			2.	OWNER
				1.	SEND EMAIL TO OWNER
				2.	OWNER EMAIL
				3.	OWNER EMAIL SUBJECT
	
			3.	CUSTOMER	
				1.	SEND EMAIL TO CUSTOMER
				2.	CUSTOMER EMAIL SUBJECT
	=========================================*/
	function olr_email_field($args){
		
		$options = get_option( 'resto_email_setting' );
		
		if( $options != '' ){
			foreach( $options as $key => $val ){
				olr_grouping_all_setting_value($key,$val);
			}
		}
		
		
		/*=========================================
			1.	FROM ( YOUR STORE NAME )
		=========================================*/
		if( $args[0] == 'email_from' ){
			echo '<textarea id="'.$args[0].'" name="resto_email_setting['.$args[0].']" rows="5" cols="50">' . 
				$options[$args[0]] . '</textarea>';
		}
		
	
		
		
		/*=========================================
			1.	SEND EMAIL TO OWNER
		=========================================*/
		if( $args[0] == 'email_to_owner' ){
			
			echo '<input type="checkbox" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="1" '.checked(1, $options[$args[0]], false) .' />';
		}
		
		/*=========================================
			2.	OWNER EMAIL
		=========================================*/
		if( $args[0] == 'owner_email' ){
			echo '<input type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		/*=========================================
			3.	OWNER EMAIL SUBJECT
		=========================================*/
		if( $args[0] == 'owner_email_subject' ){
			echo '<textarea id="'.$args[0].'" name="resto_email_setting['.$args[0].']" rows="5" cols="50">' . 
				$options[$args[0]] . '</textarea>';
		}
		
		
		

		/*=========================================
			1.	SEND EMAIL TO CUSTOMER
		=========================================*/
		if( $args[0] == 'email_to_customer' ){
			echo '<input type="checkbox" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="1" '.checked(1, $options[$args[0]], false) .' />';
		}
		/*=========================================
			2.	CUSTOMER EMAIL SUBJECT
		=========================================*/
		if( $args[0] == 'customer_email_subject' ){
			echo '<textarea id="'.$args[0].'" name="resto_email_setting['.$args[0].']" rows="5" cols="50">' . 
				$options[$args[0]] . '</textarea>';
		}

		
	}
	
	
/*##############################################
	3.	VALIDATION AND SANITIZATION	
##############################################*/		
	
	function olr_email_validation( $input ){
		
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
		return apply_filters( 'olr_email_validation', $output, $input );
		
	}
		
?>