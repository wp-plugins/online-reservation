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
		1.	SCHEDULE ( SECTION )
		2.  WORKING TIME ( SECTION )
		3.	ALL FIELD
##############################################*/	

			add_action('admin_init', 'olr_restaurant_schedule_section');
			function olr_restaurant_schedule_section() {
				
				//= GENERAL VARIABLE == 
				$parent_page 	= 'resto_schedule_setting';
				$parent_section = 'resto_schedule_section';
				
				
				// = Check if the sandbox_theme_display_options is exist on database
				if( false == get_option( 'resto_schedule_section' ) ) {	
					add_option( 'resto_schedule_section' );
				} // end if
				
				/*================================
					1.	SCHEDULE ( SECTION )
				================================*/
				add_settings_section(
					$parent_section,		// $unique ID
					'',						// $Page Title
					'olr_schedule_section',	// $function_callback
					$parent_page					// $Parent Page
				);
				
				/*================================
					2.  WORKING TIME ( SECTION )
				================================*/
				add_settings_section(
					$parent_section,		// $unique ID
					'',						// $Page Title
					'olr_working_time_title',	// $function_callback
					$parent_page					// $Parent Page
				);
				
				/*================================
					3.	ALL FIELD
						1.  WORKING TIME ( SECTION )
						1.	OPEN TIME MONDAY
						2.	CLOSE TIME MONDAY
						3.	OPEN TIME TUESDAY
						4.	CLOSE TIME TUESDAY
						5.	OPEN TIME WEDNESDAY
						6.	CLOSE TIME WEDNESDAY
						7.	OPEN TIME THURSDAY
						8.	CLOSE TIME THURSDAY
						9.	OPEN TIME FRIDAY
						10.	CLOSE TIME FRIDAY
						11.	OPEN TIME SATURDAY
						12.	CLOSE TIME SATURDAY
						13.	OPEN TIME SUNDAY
						14.	CLOSE TIME SUNDAY
						15.	TIME STEP
						16.	EARLY BOOKINGS
				================================*/
				$fields = array(
							   	// array ( $id , $title , $args )
                                array('open_time_monday','Monday', array('open_time_monday') ), // 1.	OPEN TIME MONDAY
								array('close_time_monday','', array('close_time_monday') ),
								array('open_time_tuesday','Tuesday', array('open_time_tuesday') ), // 3.	OPEN TIME TUESDAY
								array('close_time_tuesday','', array('close_time_tuesday') ),
								array('open_time_wednesday','Wednesday', array('open_time_wednesday') ),// 5.	OPEN TIME WEDNESDAY
								array('close_time_wednesday','', array('close_time_wednesday') ),
								array('open_time_thursday','Thursday', array('open_time_thursday') ),//	7.	OPEN TIME THURSDAY
								array('close_time_thursday','', array('close_time_thursday') ),
								array('open_time_friday','Friday', array('open_time_friday') ),//	9.	OPEN TIME FRIDAY
								array('close_time_friday','', array('close_time_friday') ),
								array('open_time_saturday','Saturday', array('open_time_saturday') ),//	11.	OPEN TIME SATURDAY
								array('close_time_saturday','', array('close_time_saturday') ),
								array('open_time_sunday','Sunday', array('open_time_sunday') ),// 13.	OPEN TIME SUNDAY	
								array('close_time_sunday','', array('close_time_sunday') ),
								array('time_interval','Time Interval', array('time_interval') ), //	15.	TIME STEP
								array('early_bookings','Early Bookings', array('early_bookings') ), //	16.	EARLY BOOKINGS
								array('late_bookings','Late Bookings', array('late_bookings') ) //	16.	EARLY BOOKINGS
								
                         	);
				
				
				foreach( $fields as $field ){
					add_settings_field(	
						$field[0],						// $unique ID
						$field[1],							// $field title
						'olr_schedule_field',	// $function_callback	
						$parent_page,			// $Parent page
						$parent_section,		// $Parent section
						$field[2]
					);
					
				}

				
				//3. Finally, we register the fields with WordPress
				register_setting(
					$parent_page,	// $option_group	
					$parent_page,		// $option_name	
					'olr_schedule_validation'
				);
				
				
			} // end sandbox_initialize_theme_options


/*##############################################
	2.	SECTION AND FIELD CALLBACK
		1.	SCHEDULE SECTION
		2.	WORKING TIME SECTION
		3.	FIELD
##############################################*/

	/*=========================================
		1.	SCHEDULE SECTION
	=========================================*/
	function olr_schedule_section($args){
		
	}
	function olr_working_time_title(){
		?>
        	<h2 class="section_title">Working Time</h2>
            <hr/>
        <?php 
		
	}
	
	/*=========================================
		3.	FIELD
			1.	WORKING TIME
			2.	TIME INTERVAL
			3.	EARLY BOOKINGS
			4.	LATE BOOKINGS
	=========================================*/
	function olr_schedule_field($args){
		
		$options = get_option('resto_schedule_setting');
		
		olr_delete_specific_setting_value('resto_schedule');
			
		if( $options != '' ){
			foreach( $options as $key => $val ){
				olr_grouping_all_setting_value('resto_schedule',$key,$val);
			}
		}
		
		/*=========================================
			1.	WORKING TIME
		=========================================*/
		if( 	$args[0] == 'open_time_monday' 
			||	$args[0] == 'open_time_tuesday' 
			||	$args[0] == 'open_time_wednesday' 
			||	$args[0] == 'open_time_thursday' 
			||	$args[0] == 'open_time_friday' 
			||	$args[0] == 'open_time_saturday' 
			||	$args[0] == 'open_time_sunday' 
		   ){
			$options = get_option( 'resto_schedule_setting' );
			//olr_grouping_all_setting_value('start_open',$options['start_open']);
			if( $options[ $args[0] ] == '' ){
				$options[ $args[0] ] = '08:00';
			}
			
			echo '<p style="float:left; margin-right: 10px; "> Open Time </p>';
			echo '<input type="text" id="'.$args[0].'" name="resto_schedule_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
			echo '<p style="clear:both; "></p>';
		}
		
		if( 	$args[0] == 'close_time_monday' 
			||	$args[0] == 'close_time_tuesday' 
			||	$args[0] == 'close_time_wednesday' 
			||	$args[0] == 'close_time_thursday' 
			||	$args[0] == 'close_time_friday' 
			||	$args[0] == 'close_time_saturday' 
			||	$args[0] == 'close_time_sunday' 
		   ){
			if( $options[ $args[0] ] == '' ){
				$options[ $args[0] ] = '23:00';
			}
			echo '<p style="float:left; margin-right: 10px; "> Close Time </p>';
			echo '<input type="text" id="'.$args[0].'" name="resto_schedule_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
			echo '<p style="clear:both; "></p>';
		}
		
		/*=========================================
			2.	TIME INTERVAL
		=========================================*/
		if( $args[0] == 'time_interval' ){
			
			
			if( $options[$args[0]] == '' ){
				$options[$args[0]] = '30';
			}
			
			echo '<input type="text" id="'.$args[0].'" name="resto_schedule_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
			echo '<p><strong>Note : </strong> the range between hours , if you set 30 , then it would be (  01.30 , 02.00 , 02.30  )</p>';
		}
		
		/*=========================================
			3.	EARLY BOOKINGS
		=========================================*/
		if( $args[0] == 'early_bookings' ){
			?>
            	<select name="resto_schedule_setting[<?php echo $args[0]?>]" id="<?php echo $args[0] ?>">
                    <option value="anytime" <?php selected( $options[$args[0]], 'anytime' ); ?>>Anytime</option>
                    <option value="1 day" <?php selected( $options[$args[0]], '1 day' ); ?>>1 day in advance</option>
                    <option value="1 week" <?php selected( $options[$args[0]], '1 week' ); ?>>1 week in advance</option>
                    <option value="2 week" <?php selected( $options[$args[0]], '2 week' ); ?>>2 weeks in advance</option>
                    <option value="3 week" <?php selected( $$options[$args[0]], '3 week' ); ?>>3 weeks in advance</option>
                    <option value="1 month" <?php selected( $options[$args[0]], '1 month' ); ?>>1 month in advance</option>
                    <option value="2 month" <?php selected( $options[$args[0]], '2 month' ); ?>>2 months in advance</option>
                    <option value="3 month" <?php selected( $options[$args[0]], '3 month' ); ?>>3 months in advance</option>
                </select>
            <?php 
			echo '<p><strong>Note : </strong> set early booking your customer can make</p>';
		}
		
		
		/*=========================================
			4.	LATE BOOKINGS
		=========================================*/
		if( $args[0] == 'late_bookings' ){
			
			?>
            	<select name="resto_schedule_setting[<?php echo $args[0]?>]" id="<?php echo $args[0] ?>">
                    <option value="anytime" <?php selected( $options[$args[0]], 'anytime' ); ?>>last minute in advance</option>
                    <option value="15 minutes" <?php selected( $options[$args[0]], '15 minutes' ); ?>>15 minutes in advance</option>
                    <option value="30 minutes" <?php selected( $options[$args[0]], '30 minutes' ); ?>>30 minutes in advance</option>
                    <option value="45 minutes" <?php selected( $options[$args[0]], '45 minutes' ); ?>>45 minutes in advance</option>
                    <option value="1 hour" <?php selected( $options[$args[0]], '1 hour' ); ?>>1 hour in advance</option>
                    <option value="3 hour" <?php selected( $options[$args[0]], '3 hour' ); ?>>3 hours in advance</option>
                    <option value="6 hour" <?php selected( $options[$args[0]], '6 hour' ); ?>>6 hours in advance</option>
                    <option value="9 hour" <?php selected( $options[$args[0]], '9 hour' ); ?>>9 hours in advance</option>
                    <option value="12 hour" <?php selected( $options[$args[0]], '12 hous' ); ?>>12 hours in advance</option>
                    <option value="18 hour" <?php selected( $options[$args[0]], '18 hour' ); ?>>18 hours in advance</option>
                    <option value="23 hour" <?php selected( $options[$args[0]], '23 hour' ); ?>>23 hours in advance</option>
                </select>
            <?php 
			echo '<p><strong>Note : </strong> set late booking your customer can make</p>';
		}
		
		
	}
	
	
/*##############################################
	3.	VALIDATION AND SANITIZATION	
##############################################*/		
	
	function olr_schedule_validation( $input ){
		
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
		return apply_filters( 'olr_schedule_validation', $output, $input );
		
	}
		
		

?>