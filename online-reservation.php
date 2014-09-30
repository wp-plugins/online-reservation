<?php /*
Plugin Name: Online Reservation
Plugin URI: http://solweder.com/
Description: allow you to manage and receive your business reservation online
Author: Wahsidin Tjandra
Author URI: http://solweder.com/about/
Version: 1.0
Donate link: 
Tags: 

 
Copyright 2010  solweder.com  (email : wahtjan@yahoo.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/
  	
	
/*
	TABLE OF CONTENTS
	========================
	1. 	GLOBAL VARIABLES
	2.	HELPER FUNCTIONS
	3.	RESTAURANT RESERVATION

*/

/*############################################
	1. 	GLOBAL VARIABLES
############################################*/
$olr_prefix 	= 'olr_'; // olr ( online reservation )
$plugin_folder 	= plugins_url() . '/online-reservation';


/*############################################
	2.	HELPER FUNCTIONS
############################################*/
require_once('helper/helper_functions.php');


/*############################################
	3.	RESTAURANT RESERVATION
		1.	ADMIN
		2.	SHORTCODE
		3.	WIDGET
############################################*/

/*==========================================
	1.	ADMIN
==========================================*/
if( is_admin() ){
	require_once('restaurant reservation/admin/admin.php');
}

/*==========================================
	2.	SHORTCODE
==========================================*/
require_once('restaurant reservation/ajax.php');	
if( !is_admin() ){
	require_once('restaurant reservation/display-shortcode.php');
}

/*==========================================
	3.	WIDGET
==========================================*/
require_once('restaurant reservation/display-widget.php');


?>