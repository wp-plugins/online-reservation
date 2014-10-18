<?php

/*
	TABLE OF CONTENTS
	========================
	1. 	ADMIN PAGES
	2.	RESTAURANT RESERVATION POST TYPE
	3.	STYLE AND SCRIPT 
	4.	SETTING SUB MENU
*/

/*#########################################################
	1. 	ADMIN PAGES
#########################################################*/
global $all_bookings_page;
global $resto_setting_page;
global $resto_general_setting_page;
global $resto_schedule_setting_page;
global $resto_table_setting_page;
global $options_page;


/*#########################################################
	2.	RESTAURANT RESERVATION POST TYPE
		1.	REGISTER NEW POST STATUS
		1.	ADDING VALUE TO CUSTOM COLUMN
		2.	CUSTOMIZE ALL COLUMNS
		3.	SORT COLUMNS
		4.	DISABLE ADD NEW 
		5.	CUSTOM BULK ACTION
		6.	REMOVE HYPERLINK TO EDIT POST IN EDIT.PHP
#########################################################*/

		function olr_restaurant_post_type_registration(){
			
			
			$args = array(
				'labels'  => array(
						'name'                => _x('Restaurant Reservation', 'olr_restaurant' ,PLUGIN_NAME),
						'menu_name'           => _x('Restaurant Reservation', 'olr_restaurant',PLUGIN_NAME),
						'singular_name'       => _x('Restaurant Reservation', 'olr_restaurant',PLUGIN_NAME),
						//'add_new' 			  => _x('Add New Bookings', 'olr_restaurant',PLUGIN_NAME),
						'add_new_item' 		  => _x('Add New item', 'olr_restaurant',PLUGIN_NAME),
						'all_items' 		  => _x('All Bookings', 'olr_restaurant',PLUGIN_NAME),
						'edit_item'           => _x('Edit Online Reservation', 'olr_restaurant',PLUGIN_NAME),
						'new_item'            => _x('New Online Reservation', 'olr_restaurant',PLUGIN_NAME),
						'view_item'           => _x('View Online Reservation','olr_restaurant',PLUGIN_NAME),
						'items_archive'       => _x('Online Reservation Archive', 'olr_restaurant',PLUGIN_NAME),
						'search_items'        => _x('Search Online Reservation', 'olr_restaurant',PLUGIN_NAME),
						'not_found'           => _x('No Online Reservation found.', 'olr_restaurant',PLUGIN_NAME),
						'not_found_in_trash'  => _x('No Online Reservation found in trash.', 'olr_restaurant',PLUGIN_NAME)
						),
				//'supports'      => array( 'title', 'editor', 'revisions' ,'thumbnail',PLUGIN_NAME),
				'supports'      	=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
				//'show_in_menu'  => 'admin.php?page=simple_Gmap_content',
				'public'        	=> true,
				'show_in_nav_menus'	=> true
			);
			register_post_type( 'olr_restaurant', $args );  
		}
		
		add_action( 'init', 'olr_restaurant_post_type_registration' );
	
	
	/*=========================================
		1.	REGISTER NEW POST STATUS
	=========================================*/
	if( $all_bookings_page ){
	
		function olr_new_post_status(){
	
			register_post_status( 'confirmed', array(
				//'label'                     => _x( 'Confirmed', 'post' ),
				'label'                     => 'Confirmed',
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Confirmed <span class="count">(%s)</span>', 'Confirmed <span class="count">(%s)</span>' ),
			) );
			
			register_post_status( 'closed', array(
				//'label'                     => _x( 'Confirmed', 'post' ),
				'label'                     => 'Closed',
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Closed <span class="count">(%s)</span>', 'Closed <span class="count">(%s)</span>' ),
			) );
			
			register_post_status( 'waiting-confirmation', array(
				//'label'                     => _x( 'Confirmed', 'post' ),
				'label'                     => 'Waiting Confirmation',
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Waiting Confirmation <span class="count">(%s)</span>', 'Waiting Confirmation <span class="count">(%s)</span>' ),
			) );
			
			
		}
		add_action( 'init', 'olr_new_post_status' );
	}
	
	/*=========================================
		1.	ADDING VALUE TO CUSTOM COLUMN
			1.	PHONE
			2.	EMAIL
			3.	EDITOR
			4.	TABLES
			5.	PERSONS
			6.	LUNCH / DINNER
			7.	BOOKING DATE
			8.	BOOKING TIME
			9.	STATUS
	=========================================*/
	if( $all_bookings_page ){
	
		add_action('manage_olr_restaurant_posts_custom_column', 'olr_custom_column_date', 10, 2);
		function olr_custom_column_date($column_name, $id){
			
			$meta_key = 'olr_custom_column';
			/*echo "<pre>";
			print_r( get_post_meta($id, 'olr_custom_column', true) );
			echo "</pre>";*/
			$column = get_post_meta($id, $meta_key, true);

			if($column_name == 'Phone'){
				echo $column['Phone'];
			}
			if($column_name == 'Email'){
				echo $column['Email'];
			}
			if($column_name == 'editor'){
				echo nl2br( get_post_field( 'post_content', $id) );
			}
			if($column_name == 'Type of Tables'){
				echo $column['Type of Tables'];
			}
			if($column_name == 'Tables'){
				echo $column['Tables'];
			}
			if($column_name == 'Persons'){
				echo $column['Persons'];	
			}
			if($column_name == 'Lunch / Dinner'){
				echo $column['Lunch / Dinner'];
			}
			if($column_name == 'Booking Date'){
				echo $column['Booking Date'];
			}
			if($column_name == 'Booking Time'){
				echo $column['Booking Time'];
			}
			
			if($column_name == 'Confirmation Key'){
				echo $column['Confirmation Key'];
			}
			if($column_name == 'status'){
				$status = get_post_status ( $id );
				if( $status == 'draft' ){
					echo 'Waiting Confirmation';	
				}else{
					echo $status;
				}	
			}
		}   // function olr_custom_column_date($column_name, $id){
	
	} // if( $all_bookings_page ){
		

	/*========================================================
		2.	CREATE NEW COLUMN AND CUSTOMIZE ALL COLUMNS
	========================================================*/
	if( $all_bookings_page ){
		add_filter( 'manage_edit-olr_restaurant_columns', 'olr_customize_default_columns' ) ;
		
		function olr_customize_default_columns( $columns ) {
			
			$all_settings = get_option('olr_all_restaurant_setting');
			$resto_confirmation_key = $all_settings['resto_email']['confirmation_key'];
			
			
			$columns = array(
				'cb' 			=> '<input type="checkbox" />', // DEFAULT COLUMNS
				'date' 			=> __( 'Date',PLUGIN_NAME), // DEFAULT COLUMNS
				'title' 		=> __( 'Name',PLUGIN_NAME), // DEFAULT COLUMNS
				'Phone' 		=> __( 'Phone',PLUGIN_NAME), // NEW COLUMNS
				'Email' 		=> __( 'Email',PLUGIN_NAME), // NEW COLUMNS
				'editor' 		=> __( 'Message',PLUGIN_NAME), // DEFAULT COLUMNS
				'Type of Tables' => __( 'Type of Tables',PLUGIN_NAME), // NEW COLUMNS
				'Tables' 		=> __( 'Tables',PLUGIN_NAME), // NEW COLUMNS
				'Persons' 		=> __( 'Persons',PLUGIN_NAME), // NEW COLUMNS
				'Lunch / Dinner' => __( 'Lunch / Dinner',PLUGIN_NAME), // NEW COLUMNS
				'Booking Date' 	=> __( 'Booking Date',PLUGIN_NAME), // NEW COLUMNS
				'Booking Time' 	=> __( 'Booking Time',PLUGIN_NAME) // NEW COLUMNS
			);
		
			if( 	isset( $resto_confirmation_key )
			   	&&  $resto_confirmation_key 
			){
				$columns['Confirmation Key'] = __( 'Confirmation Key'); // NEW COLUMNS
			}
			$columns['status'] = __( 'Status'); // DEFAULT COLUMNS
		
		
			return $columns;
		}
	} // if( $all_bookings_page ){
			
	/*=========================================
		3.	SORT COLUMNS
	=========================================*/
	if( $all_bookings_page ){	
		add_filter( 'manage_edit-olr_restaurant_sortable_columns', 'olr_sort_columns' ); 
		
		function olr_sort_columns( $columns ) {
			return array(
				'date' 			=> __( 'Date',PLUGIN_NAME), // DEFAULT COLUMNS
				'title' 		=> __( 'Name',PLUGIN_NAME), // DEFAULT COLUMNS
				'Booking Date' 	=> __( 'Booking Date',PLUGIN_NAME) // NEW COLUMNS
		  	);
		}
	} // if( $all_bookings_page ){
	
	/*=========================================
		4.	DISABLE ADD NEW 
	=========================================*/
		function hide_add_new_custom_type()
		{
			if ( is_admin()) {
				global $submenu;
				unset($submenu['edit.php?post_type=olr_restaurant'][10]);
				
				//= on, 2.	STYLE
				/*if ($_GET['post_type'] == 'olr_restaurant') {
					$css_data .= ".add-new-h2{display: none !important;}";
				}
				wp_add_inline_style( 'olr-admin-resto-style', $css_data );*/
			}
		}
		add_action('admin_menu', 'hide_add_new_custom_type');
	
	
	/*=========================================
		5.	CUSTOM BULK ACTION
			1.	REMOVE ITEMS
			2.	ADD ITEMS
			3.	PROCESS THE BULK ACTION
			4.	ADMIN NOTIFY THE BULK RESULTS
	=========================================*/
	if( $all_bookings_page ){		
		/*=========================================
			1.	REMOVE ITEMS
		=========================================*/
		function my_custom_bulk_actions($actions){
		   	unset( $actions['edit'] );
			return $actions;
		}
		add_filter('bulk_actions-edit-olr_restaurant','my_custom_bulk_actions');
	
	
		/*=========================================
			2.	ADD ITEMS
		=========================================*/
	
		add_action('admin_footer-edit.php', 'custom_bulk_admin_footer');
	 
		function custom_bulk_admin_footer() {
		 
			global $post_type;
		 
			if($post_type == 'olr_restaurant') {
			?>
				<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('<option>').val('confirmed').text('<?php _e('Confirmed')?>').appendTo("select[name='action']");
					jQuery('<option>').val('confirmed').text('<?php _e('Confirmed')?>').appendTo("select[name='action2']");
					jQuery('<option>').val('closed').text('<?php _e('Closed')?>').appendTo("select[name='action']");
					jQuery('<option>').val('closed').text('<?php _e('Closed')?>').appendTo("select[name='action2']");
				});
				</script>
			<?php
			}
		} // function custom_bulk_admin_footer() {
		
		
		/*=========================================
			3.	PROCESS THE BULK ACTION 
				1.	CHECK POST TYPE
				2.	CHECK ACTION
				3. 	SECURITY CHECK
				4.	CHECK POST ID ( IF ANY POST IS SELECTED )
				5.	UPDATE POST DATA
				6.	REDIRECT URL 
		=========================================*/
		add_action('load-edit.php', 'mark_full_bulk_action_events');
		function mark_full_bulk_action_events()
		{ 
		 
		 	global $typenow;
		 	$post_type = $typenow;
		 	
			//= 1.	CHECK POST TYPE
			if($post_type == 'olr_restaurant') {
			
				//= 2.	CHECK ACTION
				$wp_list_table = _get_list_table('WP_Posts_List_Table');
				$action = $wp_list_table->current_action();
				
				if(		$action == 'confirmed'
					||	$action == 'closed'	) {
					 
				}else{
					return;
				}
				 
				//= 3. 	security check
				//check_admin_referer('bulk-posts');
				
				
				//= 4.	CHECK POST ID ( IF ANY POST IS SELECTED )
				if(empty($_REQUEST['post'])) return;
				
				//= 5.	UPDATE POST DATA
				if(isset($_REQUEST['post']) ){
			 		$post_ids = array_map('intval', $_REQUEST['post']);
					
					foreach( $post_ids  as $id ){
						$my_post = array(
							'ID'       		=> $id,
							'post_status'	=> $action
						);
						wp_update_post( $my_post );
					}
	
			 	}
				
				//= 6.	REDIRECT URL 
				$sendback = remove_query_arg( array('post_status'), wp_get_referer() );
				
				
				if ( ! $sendback )
				$sendback = admin_url( "edit.php?post_type=$post_type" );
				$pagenum = $wp_list_table->get_pagenum();
			 	$sendback = add_query_arg( 'paged', $pagenum, $sendback );
				
				$selected = 0;
				foreach( $post_ids  as $id ){
					$selected++;
					$sendback = add_query_arg( array(
													 'selected' => $selected, 
													 'actions' 	=> $action,
													 'ids' 		=> join(',', $post_ids)), $sendback );						
				}

				wp_redirect($sendback);
				exit();
				
			} // if($post_type == 'olr_restaurant') {
			
			
			
		 
		} // function mark_full_bulk_action_events()
		
		
		/*=========================================
			4.	ADMIN NOTIFY THE BULK RESULTS
		=========================================*/
		add_action('admin_notices', 'mark_full_bulk_admin_notices_events');
		function mark_full_bulk_admin_notices_events() {
		 	
		 	global $post_type, $pagenow;
		
			if( 	$pagenow == 'edit.php' 
					&& $post_type == 'olr_restaurant'
					&&	isset($_REQUEST['selected']) 
					&& 	(int) $_REQUEST['selected'] )
			{
			 	$actions = '';
				if( isset( $_REQUEST['actions'] ) ){
					$actions = $_REQUEST['actions'];	
				}
				
				$message = sprintf( _n( 'Post selected ', '%s posts selected ', $_REQUEST['selected'] ), number_format_i18n( $_REQUEST['selected'] ) );
		 		echo '<div class="updated"><p>'.$message.': '.$_REQUEST['ids'].' are being '. $actions .'</p></div>';
		 	}
		 
		}
		
	} // if( $all_bookings_page ){
	
	/*==============================================================
		6.	REMOVE HYPERLINK TO EDIT POST IN EDIT.PHP
	==============================================================*/
	if( $all_bookings_page ){
		// $('table.wp-list-table a.row-title').contents().unwrap(); , put on , admin-resto-script.js
		add_filter( 'post_row_actions', 'remove_row_actions', 10, 1 );
		function remove_row_actions( $actions )
		{
			if( get_post_type() == 'olr_restaurant' )
				unset( $actions['edit'] );
				unset( $actions['view'] );
				unset( $actions['trash'] );
				unset( $actions['inline hide-if-no-js'] );
			return $actions;
		}
	} // if( $all_bookings_page ){	
		
		

/*##############################################################
	3.	STYLE AND SCRIPT 
		1.	ENQUEQE STYLE
		2.	ENQUEQE SCRIPT 
		3.	REMOVE ADD NEW FEATURES ( CUSTOM POST TYPE )
##############################################################*/
if( 	$all_bookings_page
	||	$resto_setting_page
){

			//=	1.	ENQUEQE STYLE
			wp_enqueue_style(
				'olr-admin-resto-style',	// $handle (id)	
				OLR_FOLDER .'css/admin-resto-style.css', // $sr
				false, 	// $dependencies
				false
			); 
			
			//=	2.	ENQUEQE SCRIPT
			wp_enqueue_script(
                'olr-admin-resto-script',	// $handle (id)	
                OLR_FOLDER . 'js/admin-resto-script.js', // $src
                array( 'jquery' ), 	// $dependencies
				false,	// $version
				false 	// in footer
            );  
			
			//= 3.	REMOVE ADD NEW FEATURES ( CUSTOM POST TYPE )
			$css_data =	"
						.add-new-h2{display: none !important;}
						.column-editor{width: 150px;}
						";
			wp_add_inline_style( 'olr-admin-resto-style', $css_data );
		
} // if( $all_bookings_page ){


/*##############################################
	4.	SETTING SUB MENU
		1.	MENU LINK 
		2.	MENU DISPLAY
		3.	SECTION ( TAB )
##############################################*/
				
	/*=========================================
		1.	MENU LINK 
	=========================================*/
			add_action('admin_menu', 'olr_restaurant_sub_menu');
			function olr_restaurant_sub_menu() {
				
				//$iconUrl = get_template_directory_uri() . '\theme-options\images\menu-icon.png';
				add_submenu_page(
					'edit.php?post_type=olr_restaurant',				// $parent_slug ( custom post type )
					__('Settings',PLUGIN_NAME),				// $page_title
					__('Settings',PLUGIN_NAME),			// $menu_title
					'administrator',		// $capability (which user can see)
					'olr_restaurant_setting',		// $menu_slug (The unique ID )
					'olr_restaurant_setting_display'	// $function
					//$iconUrl, 			// icon 16 x 16 pixels for best results.
				);
				
		
			} // end sandbox_create_menu_page
		
		
	/*=========================================
		2.	MENU DISPLAY
	=========================================*/
			function olr_restaurant_setting_display(){
			?>
			<!-- Create a header in the default WordPress 'wrap' container -->
			<div class="olr_menu_wrapper">
		
				<!-- Add the icon to the page -->
				<!--<div id="icon-themes" class="icon32"></div>-->
				<h2><?php _e('Restaurant Reservation Setting',PLUGIN_NAME)?></h2>
		
				<!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
				<?php settings_errors(); ?>
				
                	<?php
						if( isset( $_GET[ 'tab' ] ) ) {
							$active_tab = $_GET[ 'tab' ];
						} // end if
					?>
			
                
                <h2 class="nav-tab-wrapper">
              		<a href="?post_type=olr_restaurant&page=olr_restaurant_setting&tab=resto_general_setting" class="nav-tab <?php echo $active_tab == 'resto_general_setting' ? 'nav-tab-active' : ''; ?>">
                            <?php _e('General',PLUGIN_NAME); ?></a>
              		<a href="?post_type=olr_restaurant&page=olr_restaurant_setting&tab=resto_schedule_setting" class="nav-tab <?php echo $active_tab == 'resto_schedule_setting' ? 'nav-tab-active' : ''; ?>">
                            <?php _e('Schedule',PLUGIN_NAME); ?></a>
                   	<a href="?post_type=olr_restaurant&page=olr_restaurant_setting&tab=resto_table_setting" class="nav-tab <?php echo $active_tab == 'resto_table_setting' ? 'nav-tab-active' : ''; ?>">
                            <?php _e('Table',PLUGIN_NAME); ?></a> 
                   	<a href="?post_type=olr_restaurant&page=olr_restaurant_setting&tab=resto_email_setting" class="nav-tab <?php echo $active_tab == 'resto_email_setting' ? 'nav-tab-active' : ''; ?>">
                            <?php _e('Email',PLUGIN_NAME); ?></a>  
                   	<a href="?post_type=olr_restaurant&page=olr_restaurant_setting&tab=resto_captcha_setting" class="nav-tab <?php echo $active_tab == 'resto_captcha_setting' ? 'nav-tab-active' : ''; ?>">
                            <?php _e('Captcha',PLUGIN_NAME); ?></a>                                  
          		</h2>
                
                
                
				<!-- Create the form that will be used to render our options -->
				<form method="post" action="options.php">
					
					<?php
					/*settings_fields( 'resto_general_setting' );
						do_settings_sections( 'resto_general_setting' );*/
					
					if( $active_tab == 'resto_general_setting' ) {
						
						settings_fields( 'resto_general_setting' );
						do_settings_sections( 'resto_general_setting' );
					
					} else if ( $active_tab == 'resto_schedule_setting' )  {
						
						settings_fields( 'resto_schedule_setting' );
						do_settings_sections( 'resto_schedule_setting' );
					
					} else if ( $active_tab == 'resto_table_setting' )  {
						
						settings_fields( 'resto_table_setting' );
						do_settings_sections( 'resto_table_setting' );
					
					} else if ( $active_tab == 'resto_email_setting' )  {
					
						settings_fields( 'resto_email_setting' );
						do_settings_sections( 'resto_email_setting' );
					
					} else { 
					
						settings_fields( 'resto_captcha_setting' );
						do_settings_sections( 'resto_captcha_setting' );
					
					} // end if/else
					
					submit_button();
					?>
				</form>
		
			</div><!-- /.olr_menu_wrapper -->
			<?php
			}


	/*=========================================
		3.	SECTION ( TAB )
			1.	GENERAL
			2. 	SCHEDULE
			3.	TABLE
			4.	EMAIL
	=========================================*/
		
		/*=========================================
			1.	 GENERAL
		=========================================*/
		if( 	$resto_setting_page
			||	$options_page
		){	
			require_once('general.php');
		}
		
		
		/*=========================================
			2. 	SCHEDULE
		=========================================*/	
		if( 	$resto_schedule_setting_page
			||	$options_page
		){
			require_once('schedule.php');
		}	
		

		/*=========================================
			3.	TABLE
		=========================================*/	
		if( 	$resto_table_setting_page
		   	||	$options_page
		){
			require_once('table.php');
		}
		
		/*=========================================
			4.	EMAIL
		=========================================*/	
		if( 	$resto_email_setting_page 
		   	||	$options_page
		){
			require_once('email.php');
		}
		
		
		/*=========================================
			5.	CAPTCHA
		=========================================*/	
		if( 	$resto_setting_page
		   	||	$options_page
		 	&&	!$resto_general_setting_page 
			&&	!$resto_schedule_setting_page
			&&	!$resto_table_setting_page
			&&	!$resto_email_setting_page
		){
			require_once('captcha.php');
		}
		
		
?>