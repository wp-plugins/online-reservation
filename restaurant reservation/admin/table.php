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
		1.	TABLE ( SECTION )
		2.	ALL FIELD
##############################################*/	

			add_action('admin_init', 'olr_restaurant_table_section');
			function olr_restaurant_table_section() {
				
				//= GENERAL VARIABLE == 
				$parent_page 	= 'resto_table_setting';
				$parent_section = 'resto_table_section';
				
				
				// = Check if the sandbox_theme_display_options is exist on database
				if( false == get_option( 'resto_table_section' ) ) {	
					add_option( 'resto_table_section' );
				} // end if
				
				/*================================
					1.	TABLE ( SECTION )
				================================*/
				add_settings_section(
					$parent_section,		// $unique ID
					'',						// $Page Title
					'olr_table_section',	// $function_callback
					$parent_page					// $Parent Page
				);
				

				/*=======================================
					2.	ALL FIELD
						1.	TABLE SIZE
						2.	ONE ( SIZE ) TOTAL TABLE
						3.	ONE ( SIZE ) MAXIMUM PERSON PER TABLE 
						4.	MANY ( SIZE ) TYPE OF TABLE 
						5.	MANY TOTAL TABLE 
						6.	AUTO CHECK AVAILABLE TABLE
				=======================================*/
				$fields = array(
								// array ( $id , $title , $args )
								array('table_size',__('Table Size',PLUGIN_NAME), array('table_size') ), // 1.	TABLE SIZE
								array('one_total_table',__('One',PLUGIN_NAME), array('one_total_table') ), // 2.	ONE ( SIZE ) TOTAL TABLE
								array('one_max_person_per_table','', array('one_max_person_per_table') ), // 3.	ONE ( SIZE ) MAXIMUM PERSON PER TABLE
								array('many_type_of_table',__('Many',PLUGIN_NAME), array('many_type_of_table') ), // 4.	MANY ( SIZE ) TYPE OF TABLE 
                         	);
				
						
						/*=======================================
							5.	MANY TOTAL TABLE 
						=======================================*/
						$options = get_option( 'resto_table_setting' );
						
						if( $options['many_type_of_table'] != '' ){
							$many_table_type = explode(',',str_replace(' ','',$options['many_type_of_table']) );
							global $many_table_id;
							if( $many_table_type != '' ){
						
								foreach( $many_table_type as $val){
									$table_type = preg_match('/(.+)(\()([0-9]+)(\))/', $val, $match_table);
									/*echo "<pre>";
										print_r( $match_table );
									
									echo "</pre>";*/
									
									
									if( count($match_table) > 0 ){
										$many_table_id[] = $match_table['1'] . '_table';
										$new_fields = array($match_table['1'] . '_table','',array($match_table['1'] . '_table') );
										array_push ($fields, $new_fields);
									}
								
								} // foreach( $many_table_type as $val){
							
							} // if( $many_table_type != '' ){
						
						} // if( $options['many_type_of_table'] != '' ){
				
				
				foreach( $fields as $field ){
					add_settings_field(	
						$field[0],						// $unique ID
						$field[1],							// $field title
						'olr_table_field',	// $function_callback	
						$parent_page,			// $Parent page
						$parent_section,		// $Parent section
						$field[2]
					);
					
				}

				
				//3. Finally, we register the fields with WordPress
				register_setting(
					$parent_page,	// $option_group	
					$parent_page,		// $option_name	
					'olr_table_validation'
				);
				
				
			} // function olr_restaurant_table_section() {


/*##############################################
	2.	SECTION AND FIELD CALLBACK
		1.	SCHEDULE SECTION
		2.	FIELD
##############################################*/

	/*=========================================
		1.	SCHEDULE SECTION
	=========================================*/
	function olr_table_section($args){
		
	}

	
	/*=========================================
		2.	FIELD
			1.	TABLE SIZE
			2.	ONE ( SIZE ) TOTAL TABLE
			3.	ONE ( SIZE ) MAXIMUM PERSON PER TABLE 
			4.	MANY ( SIZE ) TYPE OF TABLE 
			4.	TYPE OF TABLE
			5. 	DISPLAY TYPE OF TABLE
	=========================================*/
	function olr_table_field($args){
		
		$options = get_option( 'resto_table_setting' );
		
		olr_delete_specific_setting_value('resto_table');
			
		if( $options != '' ){
			foreach( $options as $key => $val ){
				olr_grouping_all_setting_value('resto_table',$key,$val);
			}
		}
		
		/*=========================================
			1.	TABLE SIZE
		=========================================*/
		if( $args[0] == 'table_size' ){
			
			if( $options[$args[0]] == '' ){
				$options[$args[0]] = 'one';	
			}
			
			
			echo '<input type="radio" id="'.$args[0].'" name="resto_table_setting['.$args[0].']" value="one" '.checked('one', $options[$args[0]], false) .' />';
			echo '<label for="resto_table_setting['.$args[0].']">'.__('One',PLUGIN_NAME).'</label>';	
			echo '<br/>';	
			echo '<input type="radio" id="'.$args[0].'" name="resto_table_setting['.$args[0].']" value="many" '.checked('many', $options[$args[0]], false) .' />';
			echo '<label for="resto_table_setting['.$args[0].']">'.__('Many',PLUGIN_NAME).'</label>';	
		}
		
		
		/*=========================================
			2.	ONE ( SIZE ) TOTAL TABLE
		=========================================*/
		if( $args[0] == 'one_total_table' ){
			
			echo '<p>Total Table</p>';
			echo '<input type="text" id="'.$args[0].'" name="resto_table_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		/*=================================================
			3.	ONE ( SIZE ) MAXIMUM PERSON PER TABLE
		=================================================*/
		if( $args[0] == 'one_max_person_per_table' ){
			echo '<p>Max Person Per Table</p>';
			echo '<input type="text" id="'.$args[0].'" name="resto_table_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
		}
		
		/*=================================================
			4.	MANY ( SIZE ) TYPE OF TABLE
		=================================================*/
		if( $args[0] == 'many_type_of_table' ){
			echo '<p>Type of Table</p>';
			echo '<textarea id="'.$args[0].'" name="resto_table_setting['.$args[0].']" rows="5" cols="50">' . 
				$options[$args[0]] . '</textarea>';
			echo '
					<p><strong>'.__('Format : ',PLUGIN_NAME).'</strong>'.__('tablename( maximum person per table )',PLUGIN_NAME).'</p>
					<p><strong>'.__('Examples',PLUGIN_NAME).'</strong></p>
					<span>'.__('smaller(4)',PLUGIN_NAME).' , </span>	
					<span>'.__('medium(8)',PLUGIN_NAME).' , </span>
					<span>'.__('larger(12)',PLUGIN_NAME).'</span>
					
				';
		}
		
		global $many_table_id;
		
		if( $many_table_id != '' ){
			foreach( $many_table_id as $many_args ){
				if( $args[0] == $many_args ){
					echo '<p>Total '.$args[0].'</p>';
					echo '<input type="text" id="'.$args[0].'" name="resto_table_setting['.$args[0].']" value="' . $options[$args[0]] . '" />';
				}
			}
		}
		
		
		
		/*=========================================
			3.	AUTO CHECK AVAILABLE TABLE
		=========================================*/
		if( $args[0] == 'auto_check_table' ){
			
			echo '<input type="checkbox" id="'.$args[0].'" name="resto_table_setting['.$args[0].']" value="1" '.checked(1, $options[$args[0]], false) .' />';
		}
		
		/*=========================================
			4.	TYPE OF TABLE
		=========================================*/
		if( $args[0] == 'type_of_table' ){
			
				
		}
		
		/*=========================================
			5. 	DISPLAY TYPE OF TABLE
		=========================================*/
		if( $args[0] == 'display_type_of_table' ){
			
			$checked = '';
			if( $options[$args[0]] == 1 ){
				$checked = 'checked="checked"';
			}
			echo '<input type="checkbox" id="'.$args[0].'" name="resto_table_setting['.$args[0].']" value="1" '.checked(1, $options[$args[0]], false) .' />';
		}
		
		
		
		
	}
	
	
/*##############################################
	3.	VALIDATION AND SANITIZATION	
##############################################*/		
	
	function olr_table_validation( $input ){
		
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
		return apply_filters( 'olr_table_validation', $output, $input );
		
	}
		
		

?>