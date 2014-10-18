<?php 
/**
 * Plugin Name: Online Reservation
 * Plugin URI: http://solweder.com/
 * Description: Allow you to manage and receive your business reservation online
 * Version: 1.5.1
 * Author: Wahsidin Tjandra
 * Author URI: http://solweder.com/about-me/
 * License:     GNU General Public License v2.0 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 3.6
 * Tested up to: 4.0
 *
 * 
 * 
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

  	
/*
	TABLE OF CONTENTS
	========================
	1. 	CONSTANT
	2. 	GLOBAL VARIABLES
	3.	LOCALIZATION ( TRANSLATION )
	4.	HELPER FUNCTIONS
	5.	PAGES
	6.	RESTAURANT RESERVATION

*/



/*############################################
	1. 	CONSTANT
############################################*/
if ( !defined( 'OLR_FOLDER' ) ){
	define( 'OLR_FOLDER', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'OLR_PATH' ) ){
	define( 'OLR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'OLR_BASENAME' ) ){
	define( 'OLR_BASENAME', plugin_basename( __FILE__ ) );
}
if ( !defined( 'PLUGIN_NAME' ) ){
	define( 'PLUGIN_NAME', 'online-reservation' );
}



/*############################################
	2. 	GLOBAL VARIABLES
############################################*/
$olr_prefix 	= 'olr_'; // olr ( online reservation )


/*############################################
	3.	LOCALIZATION ( TRANSLATION )
############################################*/
load_plugin_textdomain( PLUGIN_NAME, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );



/*############################################
	4.	HELPER FUNCTIONS
############################################*/
require_once('helper/helper_functions.php');


/*############################################
	5.	PAGES
		1.	RESTAURANT ADMIN PAGES
############################################*/
	/*=================================
		1.	RESTAURANT ADMIN PAGES
	=================================*/
	global $olr_admin_page;
	global $all_bookings_page;
	global $resto_setting_page;
	global $resto_general_setting_page;
	global $resto_schedule_setting_page;
	global $resto_table_setting_page;
	global $resto_email_setting_page;
	global $options_page;
	
require_once('check-admin-page.php');

/*############################################
	6.	RESTAURANT RESERVATION
		1.	ADMIN
		2.	SHORTCODE
		3.	WIDGET
############################################*/

/*==========================================
	1.	ADMIN
==========================================*/
if( $olr_admin_page ){
	require_once('restaurant reservation/admin/admin.php');
}

/*==========================================
	2.	SHORTCODE
==========================================*/
require_once('restaurant reservation/ajax-request/ajax.php');

if( 	!$olr_admin_page 
   	&& 	!$_GET['confirmation_key']
){
	require_once('restaurant reservation/display-shortcode.php');
}
if( 	!$olr_admin_page 
  	&& 	$_GET['confirmation_key']
){	
	require_once('restaurant reservation/display-shortcode-reservation-confirmed.php');	
}


/*==========================================
	3.	WIDGET
==========================================*/
require_once('restaurant reservation/display-widget.php');


?>