<?php

/*
	TABLE OF CONTENTS
	========================
	1.	RESTAURANT ADMIN PAGES
*/
	
	
	/*=================================
		1.	RESTAURANT ADMIN PAGES
			1. 	VARIABLE 
			2.	CHECK CURRENT PAGE
	=================================*/
		
		/*===========================
			1. 	VARIABLE 
		===========================*/
		$all_bookings_page	= false;
		$resto_setting_page	= false;
		$resto_general_setting_page	= false;
		$resto_schedule_setting_page = false;
		$resto_table_setting_page = false;
		$resto_email_setting_page = false;
		$options_page = false; // ACCESS THIS PAGE ON SETTING SAVED PROCESS
		
		/*===========================
			2.	CHECK CURRENT PAGE
		===========================*/
		$post_type = $_GET['post_type'];
		$setting_page = $_GET['page'];
		$setting_tab = $_GET['tab'];
		
		if( 	is_admin() 
			&&	$pagenow == 'edit.php' 
			&& 	$post_type == 'olr_restaurant'
			&& 	$setting_page == ''
			){
			$all_bookings_page	= true;
		}
		
		if( 	is_admin() 
			&&	$pagenow == 'edit.php' 
			&& 	$post_type == 'olr_restaurant'
			&& 	$setting_page == 'olr_restaurant_setting'
			){
			$resto_setting_page	= true;
		}
		
		if( 	is_admin() 
			&&	$pagenow == 'edit.php' 
			&& 	$post_type == 'olr_restaurant'
			&& 	$setting_page == 'olr_restaurant_setting'
			&& 	$setting_tab == 'resto_general_setting'
			){
			$resto_general_setting_page	= true;
		}
		
		if( 	is_admin() 
			&&	$pagenow == 'edit.php' 
			&& 	$post_type == 'olr_restaurant'
			&& 	$setting_page == 'olr_restaurant_setting'
			&& 	$setting_tab == 'resto_schedule_setting'
			){
			$resto_schedule_setting_page = true;
		}
		
		if( 	is_admin() 
			&&	$pagenow == 'edit.php' 
			&& 	$post_type == 'olr_restaurant'
			&& 	$setting_page == 'olr_restaurant_setting'
			&& 	$setting_tab == 'resto_table_setting'
			){
			$resto_table_setting_page = true;
		}
		
		if( 	is_admin() 
			&&	$pagenow == 'edit.php' 
			&& 	$post_type == 'olr_restaurant'
			&& 	$setting_page == 'olr_restaurant_setting'
			&& 	$setting_tab == 'resto_email_setting'
			){
			$resto_email_setting_page = true;
		}
		
		
		if( 	is_admin() 
			&&	$pagenow == 'options.php' 
			){
			$options_page = true;
		}
			
		
?>