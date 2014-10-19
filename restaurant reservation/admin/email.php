<?php
/*
	TABLE OF CONTENTS ( SCHEDULE TAB )
	=======================================
	1.	ENQUEQE MEDIA UPLOADER SCRIPT AND STYLE 
	2.	REGISTER SECTION AND FIELD
	3.	SECTION AND FIELD CALLBACK
	4.	VALIDATION AND SANITIZATION
	5. 	CREATE THANK YOU PAGE
*/ 

/*##################################################
	1.	ENQUEQE MEDIA UPLOADER SCRIPT AND STYLE 
##################################################*/
		function olr_resto_admin_media_scripts() {
			
			wp_enqueue_script('jquery');
		
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			wp_enqueue_script('media-upload');
			wp_enqueue_script(
				'logo-image-upload',	// $handle (id)	
				OLR_FOLDER . 'js/admin-resto-email.js', // $src
				array('jquery','media-upload','thickbox'),  	// $dependencies
				false,	// $version
				false 	// in footer
			);
		}
		add_action('admin_enqueue_scripts', 'olr_resto_admin_media_scripts'); 

		


/*##############################################
	2.	REGISTER SECTION AND FIELD
		1.	GENERAL, CONFIRMATION, OWNER AND CUSTOMER ( SECTION )
		2.	GENERAL FIELD
		3.	CONFIRMATION FIELD
		4.	OWNER FIELD
		5.	CUSTOMER FIELD
##############################################*/	

			add_action('admin_init', 'olr_restaurant_email_section');
			function olr_restaurant_email_section() {
				
				//= GENERAL VARIABLE == 
				$parent_page 	= 'resto_email_setting';
				$general_section = 'resto_email_general_section';
				$confirmation_section = 'resto_email_confirmation_section';
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
				
				
				/*================================================================
					1.	GENERAL, CONFIRMATION, OWNER AND CUSTOMER ( SECTION )
				================================================================*/
				add_settings_section(
					$general_section,		// $unique ID
					'',						// $Page Title
					'olr_general_email_section',	// $function_callback
					$parent_page					// $Parent Page
				);
				add_settings_section(
					$confirmation_section,	// $unique ID
					'',						// $Page Title
					'olr_confirmation_email_section',	// $function_callback
					$parent_page					// $Parent Page
				);
				add_settings_section(
					$owner_section,		// $unique ID
					'',					// $Page Title
					'olr_owner_email_section',	// $function_callback
					$parent_page					// $Parent Page
				);
				add_settings_section(
					$customer_section,		// $unique ID
					'',						// $Page Title
					'olr_customer_email_section',	// $function_callback
					$parent_page					// $Parent Page
				);
				
				
				/*=============================================
					2.	GENERAL FIELD
						1.	RESTURANT NAME
						2.	RESTAURANT ADDRESS
						3.	RESTAURANT CITY
						4.	RESTAURANT STATE
						5.	RESTAURANT ZIP CODE
						6.	RESTAURANT PHONE
						7.	RESTAURANT FAX
						8.	RESTAURANT EMAIL
						9.	RESTAURANT WEBSITE
						10.	RESTAURANT LOGO
						11.	RESTAURANT IMAGE
						12.	SPECIAL OFFER LINK
						13.	RESERVATION LINK
						14.	RESTAURANT MESSAGE
						14.	RESTAURANT INFORMATION
						15.	RESTAURANT POLICIES
						16.	FACEBOOK 
						17.	TWITTER
						18. GOOGLE
						19. LINKEDIN
						20.	PINTEREST
						21.	YOUTUBE
						22.	FOOTER CONTENT
				=============================================*/
				$fields_owner = array(
									// array ( $id , $title , $args )
									array('restaurant_name',__('Restaurant Name',PLUGIN_NAME), array('restaurant_name') ), // 1.	RESTURANT NAME
									array('restaurant_address',__('Restaurant Address',PLUGIN_NAME), array('restaurant_address') ), // 2.	RESTAURANT ADDRESS
									array('restaurant_city',__('Restaurant City',PLUGIN_NAME), array('restaurant_city') ), // 3.	RESTAURANT CITY
									array('restaurant_state',__('Restaurant State',PLUGIN_NAME), array('restaurant_state') ), // 4.	RESTAURANT STATE
									array('restaurant_zipcode',__('Restaurant Zip Code',PLUGIN_NAME), array('restaurant_zipcode') ), // 5.	RESTAURANT ZIP CODE
									array('restaurant_phone',__('Restaurant Phone',PLUGIN_NAME), array('restaurant_phone') ), // 6.	RESTAURANT PHONE
									array('restaurant_fax',__('Restaurant Fax',PLUGIN_NAME), array('restaurant_fax') ), // 7.	RESTAURANT FAX
									array('restaurant_email',__('Restaurant Email',PLUGIN_NAME), array('restaurant_email') ), // 8.	RESTAURANT EMAIL
									array('restaurant_website',__('Restaurant Website',PLUGIN_NAME), array('restaurant_website') ), // 9.	RESTAURANT WEBSITE
									array('restaurant_logo',__('Restaurant Logo',PLUGIN_NAME), array('restaurant_logo') ), // 10.	RESTAURANT LOGO
									array('restaurant_image',__('Restaurant Image',PLUGIN_NAME), array('restaurant_image') ), // 11.	RESTAURANT IMAGE
									array('restaurant_offer_link',__('Restaurant Special Offer Link',PLUGIN_NAME), array('restaurant_offer_link') ), // 12.	SPECIAL OFFER LINK
									array('restaurant_reservation_link',__('Restaurant Reservation Link',PLUGIN_NAME), array('restaurant_reservation_link') ), // 13.	RESERVATION LINK
									array('restaurant_message',__('Restaurant Message',PLUGIN_NAME), array('restaurant_message') ), // 14.	RESTAURANT MESSAGE
									array('restaurant_information',__('Restaurant Information',PLUGIN_NAME), array('restaurant_information') ), // 14.	RESTAURANT INFORMATION
									array('restaurant_policies',__('Restaurant Policies',PLUGIN_NAME), array('restaurant_policies') ), // 15.	RESTAURANT POLICIES
									array('restaurant_facebook',__('Facebook',PLUGIN_NAME), array('restaurant_facebook') ), // 16.	FACEBOOK 
									array('restaurant_twitter',__('Twitter',PLUGIN_NAME), array('restaurant_twitter') ), // 17.	TWITTER
									array('restaurant_google',__('Google',PLUGIN_NAME), array('restaurant_google') ), // 18. GOOGLE
									array('restaurant_linkedin',__('LinkeIn',PLUGIN_NAME), array('restaurant_linkedin') ), // 19. LINKEDIN
									array('restaurant_pinterest',__('Pinterest',PLUGIN_NAME), array('restaurant_pinterest') ), // 20.	PINTEREST
									array('restaurant_youtube',__('Youtube',PLUGIN_NAME), array('restaurant_youtube') ), // 21.	YOUTUBE
									array('restaurant_footer',__('Footer Content',PLUGIN_NAME), array('restaurant_footer') ) // 22.	FOOTER CONTENT
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
					3.	CONFIRMATION FIELD
						1.	ENABLE CONFIRMATION EMAIL 
						2.	DISPLAY CONFIRMATION KEY
						3.	CONFIRMATION SUCCESS MESSAGE
						4.	CONFIRMATION FAILED MESSAGE
				=======================================*/
				$fields_owner = array(
									// array ( $id , $title , $args )
									array('confirmation_email',__('Enable Confirmation Email',PLUGIN_NAME), array('confirmation_email') ), // 1.	ENABLE CONFIRMATION EMAIL 
									array('confirmation_key',__('Display Confirmation key ( on List of bookings )',PLUGIN_NAME), array('confirmation_key') ), // 2.	DISPLAY CONFIRMATION KEY
									array('confirmation_success_message',__('Confirmation Success Message',PLUGIN_NAME), array('confirmation_success_message') ), // 3.	CONFIRMATION SUCCESS MESSAGE
									array('confirmation_failed_message',__('Confirmation Success Message',PLUGIN_NAME), array('confirmation_failed_message') ) // 4.	CONFIRMATION FAILED MESSAGE
                         		);
				
				foreach( $fields_owner as $field ){
					add_settings_field(	
						$field[0],						// $unique ID
						$field[1],							// $field title
						'olr_email_field',	// $function_callback	
						$parent_page,			// $Parent page
						$confirmation_section,		// $Parent section
						$field[2]
					);
					
				}
				
				
				/*=======================================
					4.	OWNER FIELD
						1.	SEND EMAIL TO OWNER
						2.	OWNER EMAIL
						3.	OWNER EMAIL SUBJECT
				=======================================*/
				$fields_owner = array(
									// array ( $id , $title , $args )
									array('email_to_owner',__('Send Email To Owner',PLUGIN_NAME), array('email_to_owner') ), // 1.	SEND EMAIL TO OWNER
									array('owner_email',__('Owner Email',PLUGIN_NAME), array('owner_email') ), // 2.	OWNER EMAIL
									array('owner_email_subject',__('Email Subject',PLUGIN_NAME), array('owner_email_subject') ) // 3.	OWNER EMAIL SUBJECT
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
					5.	CUSTOMER FIELD
						1.	SEND EMAIL TO CUSTOMER
						2.	CUSTOMER EMAIL SUBJECT
				=======================================*/
				$fields_customer = array(
									// array ( $id , $title , $args )
									array('email_to_customer',__('Send Email To Customer',PLUGIN_NAME), array('email_to_customer') ), // 1.	SEND EMAIL TO CUSTOMER
									array('customer_email_subject',__('Email Subject',PLUGIN_NAME), array('customer_email_subject') ), // 2.	CUSTOMER EMAIL SUBJECT
								
								
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
	3.	SECTION AND FIELD CALLBACK
		1.	GENERAL SECTION 
		2.	CONFIRMATION SECTION 
		3.	OWNER SECTION
		4.	CUSTOMER SECTION
		5.	FIELD
##############################################*/

	//stripslashes(wp_filter_post_kses(addslashes($row["description"])));
	
	/*=========================================
		1.	GENERAL SECTION
	=========================================*/
	function olr_general_email_section($args){
		
		echo '<h3 class="setting_section_title">'.__('GENERAL',PLUGIN_NAME).'</h3><hr />';
		echo '
			  	<p>
					You can easier to add and style some content on your email template with below Editor 
			  	</p>
			  	<p>
					<span><strong>Field Content</strong><span>
					<span>
						<select name="email-editing-content" id="email-editing-content">
							<option value="restaurant_message">Restaurant Message</option>
							<option value="restaurant_information">Restaurant Information</option>
							<option value="restaurant_policies">Restaurant Policies</option>
							<option value="restaurant_footer">Footer Content</option>
						</select>
					</span>
					<span><input id="get-field-content" type="button" value="Get Content" /><span>
					<span><input id="save-field-content" type="button" value="Save Content" /><span>
				</p>';
		
		
		$settings = array();
		$content = '';
		$editor_id = 'mycustomeditor';
		wp_editor( $content, $editor_id, $settings );

		echo '<br /><hr />';
		
	}
	
	/*=========================================
		2.	CONFIRMATION SECTION 
	=========================================*/
	function olr_confirmation_email_section($args){
		echo '<h3 class="setting_section_title">'.__('Confirmation',PLUGIN_NAME).'</h3><hr />';
	}
	
	
	/*=========================================
		3.	OWNER SECTION
	=========================================*/
	function olr_owner_email_section($args){
		echo '<h3 class="setting_section_title">'.__('Restaurant Owner',PLUGIN_NAME).'</h3><hr />';
	}
	
	/*=========================================
		4.	CUSTOMER SECTION
	=========================================*/
	function olr_customer_email_section($args){
		echo '<br /><h3 class="setting_section_title">'.__('Customer',PLUGIN_NAME).'</h3><hr />';
	}

	/*=========================================
		5.	FIELD
			1.	GENERAL
				1.	RESTURANT NAME
				2.	RESTAURANT ADDRESS
				3.	RESTAURANT CITY
				4.	RESTAURANT STATE
				5.	RESTAURANT ZIP CODE
				6.	RESTAURANT PHONE
				7.	RESTAURANT FAX
				8.	RESTAURANT EMAIL
				9.	RESTAURANT WEBSITE
				10.	RESTAURANT LOGO
				11.	RESTAURANT IMAGE
				12.	SPECIAL OFFER LINK
				13.	RESERVATION LINK
				14.	RESTAURANT MESSAGE
				14.	RESTAURANT INFORMATION
				15.	RESTAURANT POLICIES
				16.	FACEBOOK 
				17.	TWITTER
				18. GOOGLE
				19. LINKEDIN
				20.	PINTEREST
				21.	YOUTUBE
				22.	FOOTER CONTENT
			
			2.	CONFIRMATION
				1.	ENABLE CONFIRMATION EMAIL 
				2.	DISPLAY CONFIRMATION KEY
				3.	CONFIRMATION SUCCESS MESSAGE
				4.	CONFIRMATION FAILED MESSAGE
			
			3.	OWNER
				1.	SEND EMAIL TO OWNER
				2.	OWNER EMAIL
				3.	OWNER EMAIL SUBJECT
	
			4.	CUSTOMER	
				1.	SEND EMAIL TO CUSTOMER
				2.	CUSTOMER EMAIL SUBJECT
	=========================================*/
	function olr_email_field($args){
		
		$options = get_option( 'resto_email_setting' );
		
		olr_delete_specific_setting_value('resto_email');
			
		if( $options != '' ){
			foreach( $options as $key => $val ){
				olr_grouping_all_setting_value('resto_email',$key,$val);
			}
		}		
	
		/*=========================================
			1.	RESTURANT NAME
		=========================================*/
		if( $args[0] == 'restaurant_name' ){
			echo '<input class="email-longer-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		
		/*=========================================
			2.	RESTAURANT ADDRESS
		=========================================*/
		if( $args[0] == 'restaurant_address' ){
			echo '<textarea id="'.$args[0].'" name="resto_email_setting['.$args[0].']" rows="5" cols="50">' . 
				$options[$args[0]] . '</textarea>';
		}
		
		/*=========================================
			3.	RESTAURANT CITY
		=========================================*/
		if( $args[0] == 'restaurant_city' ){
			echo '<input class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		/*=========================================
			4.	RESTAURANT STATE
		=========================================*/
		if( $args[0] == 'restaurant_state' ){
			echo '<input class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		/*=========================================
			5.	RESTAURANT ZIP CODE
		=========================================*/
		if( $args[0] == 'restaurant_zipcode' ){
			echo '<input class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
	
		
		/*=========================================
			6.	RESTAURANT PHONE
		=========================================*/
		if( $args[0] == 'restaurant_phone' ){
			echo '<input class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		
		/*=========================================
			7.	RESTAURANT FAX
		=========================================*/
		if( $args[0] == 'restaurant_fax' ){
			echo '<input class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		
		/*=========================================
			8.	RESTAURANT EMAIL
		=========================================*/
		if( $args[0] == 'restaurant_email' ){
			echo '<input class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		
		/*=========================================
			9.	RESTAURANT WEBSITE
		=========================================*/
		if( $args[0] == 'restaurant_website' ){
			echo '<input placeholder="www.yourwebsite.com" class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		
		/*=========================================
			10.	RESTAURANT LOGO
		=========================================*/
		if( $args[0] == 'restaurant_logo' ){
			echo '<input class="restaurant-image" type="hidden" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		
			echo '<img class="image-preview" id="restaurant-logo-image-preview" src="'.$options[$args[0]].'" alt="logo image"/>';
			echo '<input id="olr_upload_logo_button" type="button" value="'.__( 'Select Logo to Upload') .'" />';
			echo '<input id="olr_remove_logo_button" type="button" value="'.__( 'Remove Logo') .'" />';
		}
		
		
		/*=========================================
			11.	RESTAURANT IMAGE
		=========================================*/
		if( $args[0] == 'restaurant_image' ){
			echo '<input class="restaurant-image" type="hidden" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		
			echo '<img class="image-preview" id="restaurant-image-preview" src="'.$options[$args[0]].'" alt="restaurant image"/>';
			echo '<input id="olr_upload_image_button" type="button" value="'.__( 'Select Image to Upload') .'" />';
			echo '<input id="olr_remove_image_button" type="button" value="'.__( 'Remove Image') .'" />';
		}
		
		
		/*=========================================
			12.	SPECIAL OFFER LINK
		=========================================*/
		if( $args[0] == 'restaurant_offer_link' ){
			echo '<input placeholder="www.yourwebsite.com" class="email-longer-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		/*=========================================
			13.	RESERVATION LINK	
		=========================================*/
		if( $args[0] == 'restaurant_reservation_link' ){
			echo '<input placeholder="www.yourwebsite.com" class="email-longer-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		/*=========================================
			14.	RESTAURANT MESSAGE
		=========================================*/
		if( $args[0] == 'restaurant_message' ){
			echo '<textarea id="'.$args[0].'" name="resto_email_setting['.$args[0].']" rows="5" cols="50">' . 
				$options[$args[0]] . '</textarea>';
		}
		
		
		/*=========================================
			14.	RESTAURANT INFORMATIONS
		=========================================*/
		if( $args[0] == 'restaurant_information' ){
			echo '<textarea id="'.$args[0].'" name="resto_email_setting['.$args[0].']" rows="5" cols="50">' . 
				$options[$args[0]] . '</textarea>';
		}
		
		/*=========================================
			15.	RESTAURANT POLICIES
		=========================================*/
		if( $args[0] == 'restaurant_policies' ){
			echo '<textarea id="'.$args[0].'" name="resto_email_setting['.$args[0].']" rows="5" cols="50">' . 
				$options[$args[0]] . '</textarea>';
		}
		
		/*=========================================
			16.	FACEBOOK 
		=========================================*/
		if( $args[0] == 'restaurant_facebook' ){
			echo '<input class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		
		/*=========================================
			17.	TWITTER
		=========================================*/
		if( $args[0] == 'restaurant_twitter' ){
			echo '<input class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		/*=========================================
			18. GOOGLE
		=========================================*/
		if( $args[0] == 'restaurant_google' ){
			echo '<input class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		/*=========================================
			19. LINKEDIN
		=========================================*/
		if( $args[0] == 'restaurant_linkedin' ){
			echo '<input class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}	
		
		/*=========================================
			20.	PINTEREST
		=========================================*/
		if( $args[0] == 'restaurant_pinterest' ){
			echo '<input class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		/*=========================================
			21.	YOUTUBE
		=========================================*/
		if( $args[0] == 'restaurant_youtube' ){
			echo '<input class="email-medium-field" type="text" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		/*=========================================
			22.	FOOTER CONTENT
		=========================================*/
		if( $args[0] == 'restaurant_footer' ){
			echo '<textarea id="'.$args[0].'" name="resto_email_setting['.$args[0].']" rows="5" cols="50">' . 
				$options[$args[0]] . '</textarea>';
		}
		
		
		/*=========================================
			1.	ENABLE CONFIRMATION EMAIL 
		=========================================*/
		if( $args[0] == 'confirmation_email' ){
			echo '<input type="checkbox" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="1" '.checked(1, $options[$args[0]], false) .' />';
		}
		
		/*=========================================
			2.	DISPLAY CONFIRMATION KEY
		=========================================*/
		if( $args[0] == 'confirmation_key' ){
			echo '<input type="checkbox" id="'.$args[0].'" name="resto_email_setting['.$args[0].']" value="1" '.checked(1, $options[$args[0]], false) .' />';
		}
		
		/*=========================================
			3.	CONFIRMATION SUCCESS MESSAGE
		=========================================*/
		if( $args[0] == 'confirmation_success_message' ){
			echo '<textarea id="'.$args[0].'" name="resto_email_setting['.$args[0].']" rows="5" cols="50">' . 
				$options[$args[0]] . '</textarea>';
		}
		
		/*=========================================
			4.	CONFIRMATION FAILED MESSAGE
		=========================================*/
		if( $args[0] == 'confirmation_failed_message' ){
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
	4.	VALIDATION AND SANITIZATION	
##############################################*/		
	function olr_email_validation( $input ){
			
		update_option( 'validate_setting',$input);
		
	
		// Create our array for storing the validated options
		$output = array();
		
		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {
			
			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {
				
				if( 	$input['restaurant_policies']
					|| 	$input['restaurant_information']	
					|| 	$input['restaurant_footer']
				){
					$output[$key] = stripslashes(wp_filter_post_kses(addslashes($input[$key])));
					
				}else{
					// Strip all HTML and PHP tags and properly handle quoted strings
					//	strip_tags() , removing all HTML and PHP tags
					//	stripslashes() , will properly handle quotation marks around a string.
					$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
					
				}
			
			} // end if
			
		} // end foreach
		
		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'olr_email_validation', $output, $input );	
	}
	
	
/*##############################################
	5. 	CREATE THANK YOU PAGE
##############################################*/	

add_action( 'wp_loaded', 'olr_create_page');
function olr_create_page(){
	
	global $olr_resto_thank_you_page;
	
	//= CHECK IF PAGE IS EXIST 
	if( get_page_by_title('Thank You For Reservation') == '' ){
		
		$post_thank_you = array(
						'post_type'		=> 'page',
						'post_title'	=> 'Thank You For Reservation',
						'post_content'	=> '[reservation_confirmed]',
						'post_status'	=> 'publish'
						);
								
		$post_id = wp_insert_post( $post_thank_you );
		$olr_resto_thank_you_page = site_url() .'?page_id='. $post_id ;	 	
		
		olr_grouping_all_setting_value('resto_thank_you_page','url',$olr_resto_thank_you_page);
		
	}
}




?>