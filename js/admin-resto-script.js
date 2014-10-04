jQuery(document).ready(function($){ 
	
	/*
		TABLE OF CONTENTS
		========================
		1.	init ( INITIALIZE )
			1. 	GLOBAL VARIABLES
			2.	DATE PICKER
			3.	RESTAURANT BOOKING FORM
	*/

	var Olr_admin_resto = {
		init : function() {
			
			$('table.wp-list-table a.row-title').contents().unwrap();
			$('.view-switch').css('display','none');
		}			
	}
	
	//initialize Archieve
	Olr_admin_resto.init();
	
});