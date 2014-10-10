<?php 
/*
	TABLE OF CONTENTS
	========================
	1. 	GROUPING ALL SETTING VALUE
	2.  OUTPUT TIME LIST
	3.	RESTAURANT RESERVATION CONTENT

*/
	/*=====================================================
		1. 	GROUPING ALL SETTING VALUE
	=====================================================*/
	function olr_grouping_all_setting_value($section,$new_key,$new_value){
		
		$option_name = 'olr_all_restaurant_setting';
		
		$all_restaurant_setting =  get_option($option_name);
		
		$all_restaurant_setting[$section][$new_key] = $new_value;
		
		update_option($option_name,$all_restaurant_setting);

	}
	
	
	/*=====================================================
		2. 	DELETE SPECIFIC SETTING VALUE
	=====================================================*/
	function olr_delete_specific_setting_value($section){
		
		$option_name = 'olr_all_restaurant_setting';
		
		$all_restaurant_setting =  get_option($option_name);
		
		if( $all_restaurant_setting != '' ){
			unset( $all_restaurant_setting[$section] );
		}
		update_option($option_name,$all_restaurant_setting);

	}
	
	
	
	/*=====================================================
		2.  OUTPUT TIME LIST
	=====================================================*/
	function olr_output_time_list( $options , $now = '' ){
		
		$current_day		= strtolower( date("D") );
		
		if( $current_day == 'mon' ){
			$open_time 		= $options['resto_schedule']['open_time_monday'];
			$close_time 	= $options['resto_schedule']['close_time_monday'];
		}
		if( $current_day == 'tue' ){
			$open_time 		= $options['resto_schedule']['open_time_tuesday'];
			$close_time 	= $options['resto_schedule']['close_time_tuesday'];
		}
		if( $current_day == 'wed' ){
			$open_time 		= $options['resto_schedule']['open_time_wednesday'];
			$close_time 	= $options['resto_schedule']['close_time_wednesday'];
		}
		if( $current_day == 'thu' ){
			$open_time 		= $options['resto_schedule']['open_time_thursday'];
			$close_time 	= $options['resto_schedule']['close_time_thursday'];
		}
		if( $current_day == 'fri' ){
			$open_time 		= $options['resto_schedule']['open_time_friday'];
			$close_time 	= $options['resto_schedule']['close_time_friday'];
		}
		if( $current_day == 'sat' ){
			$open_time 		= $options['resto_schedule']['open_time_saturday'];
			$close_time 	= $options['resto_schedule']['close_time_saturday'];
		}
		if( $current_day == 'sun' ){
			$open_time 		= $options['resto_schedule']['open_time_sunday'];
			$close_time 	= $options['resto_schedule']['close_time_sunday'];
		}
		
		$time_interval = 30;
		if(  $options['resto_schedule']['time_interval'] != '' ){ 
			$time_interval = $options['resto_schedule']['time_interval'];
		}
		
		$open_times = preg_match('/([0-9]+):([0-9]+)|([0-9]+)/',$open_time, $open_match);
		$close_times = preg_match('/([0-9]+):([0-9]+)|([0-9]+)/',$close_time, $close_match);
		
		
		$open_hours = $open_match[1] - 0;
		$open_minutes = $open_match[2] - 0;
		
		$close_hours = $close_match[1] - 0;
		$close_minutes = $close_match[2] - 0;
		
		$start_minutes = ( $open_hours * 60 ) + $open_minutes;
		$end_minutes = ( $close_hours * 60 ) + $close_minutes;
		
		
		$output .= '<option selected="selected" val=""></option>';
		//$output = '<option value>'.$open_time.'</option>';
		for( $x = $start_minutes; $x < $end_minutes ;$x = $x + $time_interval ){
			$minutes = $x % 60 ;
			if( $minutes == 0 ){
				$minutes = '00';
			}else if( strlen($minutes) == 1 ){
				$minutes = '0' . $minutes;
			}
			
			$hour = ( $x - $minutes ) / 60;
			if( strlen( $hour ) == 1 ){
				$hour = '0' . $hour;
			} 
			
			$output .= '<option val="'.$hour . ":" . $minutes.'">'.$hour . ":" . $minutes.'</option>'; 
	
		}
		$output .= '<option val="'.$hour . ":" . $minutes.'">'.$close_time.'</option>';
		return $output;
	}
	
	
	/*=====================================================
		3.	RESTAURANT RESERVATION CONTENT
	=====================================================*/
	function restaurant_reservation_content( $options ){
		
		$out = '';
		
		$out .='<div class="olr_restaurant_wrapper">';
		$out .='
        <form id="olr_restaurant_form" action="'.$_SERVER['PHP_SELF'].'" method="post">'.
        wp_nonce_field("restaurant_form_verify","restaurant_nonce_id")
		.'<h2>Personal Information</h2>
		<hr/>
		<p>
            <span class="olr_label"><label for="">Name</label></span> 
            <input type="text" name="olr_name" id="olr_name" value="" /> <span class="olr_required">*</span>
        </p>
        <p>
            <span class="olr_label"><label for="">Email Address</label></span> 
            <input type="text" name="olr_email" id="olr_email" value="" /> <span class="olr_required">*</span>
        </p>
        <p>
            <span class="olr_label"><label for="">Phone</label></span> 
            <input type="text" name="olr_phone" id="olr_phone" value="" /> <span class="olr_required">*</span>
        </p>
		<p>
        	<span class="olr_label"><label for="">Message</label></span>
 			<textarea rows="10" cols="30" name="olr_message" id="olr_message"></textarea>
        </p>
		<br/>
		
		<h2>Booking Table</h2>
		<hr/>';
		
		
		if( $options['resto_table']['table_size'] == 'many' ):
		
		$out .='<p>
				<span class="olr_label"><label for="">Type of Table</label></span>
				<select name="olr_type_of_table" id="olr_type_of_table">';	
				$many_table_type = explode(',',str_replace(' ','',$options['resto_table']['many_type_of_table']) );
				if( $many_table_type != '' ){
					
					$first_table = '';
					foreach( $many_table_type as $val){
						$table_type = preg_match('/(.+)(\()([0-9]+)(\))/', $val, $match_table);
						if( $first_table == ''){
							$first_table = 	$match_table['1'];	
						}
						$out .='<option value="'.$match_table['1'].'" >'.$match_table['1'].' ( '.$match_table['3'] .' person ) </option>';
											
					} // foreach( $many_table_type as $val){
					
				} // if( $many_table_type != '' ){
		
		$out .='</select>
		</p>';
		endif;
		
		
		if( $options['resto_table']['table_size'] == 'one' ){
			$total_table = $options['resto_table']['one_total_table'];
		}else{
			$total_table = $options['resto_table'][$first_table . '_table'];
		}
		
		
		$out .='<p>
			<span class="olr_label"><label for="">Table</label></span>
            <select name="olr_table" id="olr_table">
                <option value="1" selected="selected">1</option>';
                for( $x = 2; $x <= $total_table; $x++ ): 
				$out .='<option value="'.$x.'" >'.$x.'</option>';
				endfor;
		$out .='</select>
        </p>
        
        <p>
            <span class="olr_label"><label for="">Persons</label></span> 
            <input type="text" name="olr_persons" id="olr_persons" value="" /> <span class="olr_required">*</span>
        </p>
        <p>
        	<span class="olr_label"><label for="">Lunch / Dinner</label></span>
            <select name="olr_lunch" id="olr_lunch">
            	<option value="" selected="selected"></option>
                <option value="lunch">Lunch</option>
                <option value="dinner">Dinner</option>
            </select>
        </p>
        <div class="olr_date_section">
        	<span class="olr_label"><label for="">Date</label></span> 
            <div class="olr_date_wrap">
				<input name="olr_date" id="olr_date" type="text" value="" /> <span class="olr_required">*</span>
 			</div>	       
		</div>
        <div class="olr_time_section">
        	<span class="olr_label"><label for="">Time</label></span>
			<div class="olr_time_wrap">
				<select name="olr_time" id="olr_time">
					<option value="" selected="selected"></option>';
					$out .= olr_output_time_list ( $options );         
				$out .='</select> <span class="olr_required">*</span>
			</div>	
        </div><br/>';
		
		if( $options['resto_captcha']['enable_captcha'] ){
			if( $options['resto_captcha']['public_key'] != '' ){
				$out .='<script type="text/javascript">
							var RecaptchaOptions = {
								theme : "'.$options['resto_captcha']['captcha_theme'].'"
							};
			 			</script>
						<script type="text/javascript"
							src="http://www.google.com/recaptcha/api/challenge?k='.$options['resto_captcha']['public_key'].'">
						</script>
						<p class="olr_captcha_response_error"></p>
						';
			}
		}
		
$out .='<br/>
			<span class="olr_requireds">*</span><span> Required fields </span> 
        <br/>
		
		<p>
 			<input type="submit" value="Booking" id="olr_restaurant_booking_button" name="olr_restaurant_booking_button">
        </p>
        </form>';
		$out .='<div id="olr_restaurant_response"></div>';
		$out .='<div style="clear:both"></div>';
		$out .='</div>';
		
		return $out;
	}
	

?>