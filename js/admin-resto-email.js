jQuery(document).ready(function($){ 
	
	/*
		TABLE OF CONTENTS
		========================
		1.	init ( INITIALIZE )
			1. 	GLOBAL VARIABLES
			2. 	DISPLAY LOGO PREVIEW 
			3. 	DISPLAY IMAGE PREVIEW
			4.	RESTAURANT EMAIL UPLOAD IMAGE
			5.	GET FIELD CONTENT
			
	*/
	var Olr_email = {
		init : function() {
			
			//= 1. 	GLOBAL VARIABLES
			
			//= 2. 	DISPLAY LOGO PREVIEW 
			if( !$('#restaurant-logo-image-preview').attr('src') ){
				$('#restaurant-logo-image-preview').css('display','none');
			}
			
			//= 3. 	DISPLAY IMAGE PREVIEW 
			if( !$('#restaurant-image-preview').attr('src') ){
				$('#restaurant-image-preview').css('display','none');
			}
			
			//= 4.	RESTAURANT EMAIL UPLOAD IMAGE
			this.upload_image();
			
			//= 5.	GET FIELD CONTENT
			this.get_field_content();
			
			//= 6.	SAVE FIELD CONTENT
			this.save_field_content();
			
			
			
		},
		
		
		upload_image:function() {
			
			$('#olr_upload_logo_button,#olr_upload_image_button').click(function() {
					
					parent = $(this).parent();
				
					tb_show(
						'Upload Image',	 // title or caption	
						'media-upload.php?type=image&TB_iframe=true',  // media_upload url	
						false // image group
					);
					
					
					// ============== original_send_to_editor = window.send_to_editor; => for not crashing with 
					//=================== default wordpress add media
					var original_send_to_editor = window.send_to_editor;
					
					window.send_to_editor = function(html) {
						//alert(html);
						//alert( html.search( '.pdf' ) );
						
						//=========================================
						// 1. Check Filetype (.png or .pdf or .zip)
						//=========================================
						if( html.search('.png') > 0  || html.search('.gif') > 0
							|| html.search('.jpg') > 0 ){
						
							// html returns a link like this:
							// <a href="{server_uploaded_image_url}"><img src="{server_uploaded_image_url}" alt="" title="" width="" height"" class="alignzone size-full wp-image-125" /></a>
							//1. get the image src inside html variable
							var image_url = $('img',html).attr('src');

							//2. Set image src
							parent.find('.restaurant-image').val(image_url);
			
							//3. Remove Thick Box
							tb_remove();
							
							//4. display preview image
							parent.find('.image-preview').css('display','block');
							parent.find('.image-preview').attr('src',image_url);
							
						}else{ // if is not image ( such as .zip)
							//do nothing...
						}
						
						window.send_to_editor = original_send_to_editor;
					} // END window.send_to_editor	============================
				
					
					//return false;
			}); // $('#olr_upload_logo_button').click(function() {
			
			
			$('#olr_remove_logo_button,#olr_remove_image_button').click(function() {
				
				//= 1. remove preview image
				$(this).parent().find('.image-preview').css('display','none');
				$(this).parent().find('.image-preview').attr('src','');
				
				//= 2. set restaurant logo
				$(this).parent().find('.restaurant-image').val('');
			
			}); // $('#olr_upload_logo_button').click(function() {
	
	
		}, // upload_image:function() {
		
		
		
		get_field_content:function() {	
			
			$('#get-field-content').click(function() {
				var content = $( '#'+$('#email-editing-content').val() ).val();
				tinyMCE.activeEditor.setContent(content);									   
			});
			
		}, // get_field_content:function() {	
				
					
		save_field_content:function() {	
			
			$('#save-field-content').click(function() {
				var content = tinymce.activeEditor.getContent(); 
				$( '#'+$('#email-editing-content').val() ).val(content);									   
			});
			
		} // save_field_content:function() {	
					
					
	} // var Olr_email = {
	
	
	//initialize Archieve
	Olr_email.init();
	
});