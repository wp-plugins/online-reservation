<?php

/*
	TABLE OF CONTENTS
	========================
	1.	RESTAURANT RESERVATION POST TYPE
	2.	STYLE AND SCRIPT 
	3.	SETTING SUB MENU
*/


/*#########################################################
	1.	RESTAURANT RESERVATION POST TYPE
		1.	REGISTER NEW POST STATUS
		1.	ADDING VALUE TO CUSTOM COLUMN
		2.	CUSTOMIZE ALL COLUMNS
		3.	SORT COLUMNS
		4.	DISABLE ADD NEW 
		5.	CUSTOM BULK ACTION
		6.	REMOVE HYPERLINK TO EDIT POST IN EDIT.PHP
#########################################################*/
		function olr_restaurant_post_type_registration(){
			
			global $themes_brand;
			
			$args = array(
				'labels'  => array(
						'name'                => _x('Restaurant Reservation', 'post type general name' ),
						'menu_name'           => _x('Restaurant Reservation', 'olr_restaurant_reservation'),
						'singular_name'       => _x('Restaurant Reservation', 'olr_restaurant_reservation'),
						//'add_new' 			  => _x('Add New Bookings', 'olr_restaurant_reservation'),
						'add_new_item' 		  => _x('Add New item', 'olr_restaurant_reservation'),
						'all_items' 		  => _x('All Bookings', 'olr_restaurant_reservation'),
						'edit_item'           => _x('Edit Online Reservation', 'olr_restaurant_reservation'),
						'new_item'            => _x('New Online Reservation', 'olr_restaurant_reservation'),
						'view_item'           => _x('View Online Reservation','olr_restaurant_reservation'),
						'items_archive'       => _x('Online Reservation Archive', 'olr_restaurant_reservation'),
						'search_items'        => _x('Search Online Reservation', 'olr_restaurant_reservation'),
						'not_found'           => _x('No Online Reservation found.', 'olr_restaurant_reservation'),
						'not_found_in_trash'  => _x('No Online Reservation found in trash.', 'olr_restaurant_reservation')
					  ),
				//'supports'      => array( 'title', 'editor', 'revisions' ,'thumbnail'),
				'supports'      	=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
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
		
		
	
	}
	add_action( 'init', 'olr_new_post_status' );
	
	

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
			if($column_name == 'status'){
				echo  get_post_status ( $id );
			}

		
			
		}   

	/*========================================================
		2.	CREATE NEW COLUMN AND CUSTOMIZE ALL COLUMNS
	========================================================*/
		add_filter( 'manage_edit-olr_restaurant_columns', 'olr_customize_default_columns' ) ;
		
		function olr_customize_default_columns( $columns ) {
		
			$columns = array(
				'cb' 			=> '<input type="checkbox" />', // DEFAULT COLUMNS
				'date' 			=> __( 'Date'), // DEFAULT COLUMNS
				'title' 		=> __( 'Name'), // DEFAULT COLUMNS
				'Phone' 		=> __( 'Phone'), // NEW COLUMNS
				'Email' 		=> __( 'Email'), // NEW COLUMNS
				'editor' 		=> __( 'Message'), // DEFAULT COLUMNS
				'Type of Tables' => __( 'Type of Tables'), // NEW COLUMNS
				'Tables' 		=> __( 'Tables'), // NEW COLUMNS
				'Persons' 		=> __( 'Persons'), // NEW COLUMNS
				'Lunch / Dinner' => __( 'Lunch / Dinner'), // NEW COLUMNS
				'Booking Date' 	=> __( 'Booking Date'), // NEW COLUMNS
				'Booking Time' 	=> __( 'Booking Time'), // NEW COLUMNS
				'status' 		=> __( 'Status') // DEFAULT COLUMNS
			);
		
			return $columns;
		}

			
	/*=========================================
		3.	SORT COLUMNS
	=========================================*/
		
		add_filter( 'manage_edit-olr_restaurant_sortable_columns', 'olr_sort_columns' ); 
		
		function olr_sort_columns( $columns ) {
			return array(
				'date' 			=> __( 'Date'), // DEFAULT COLUMNS
				'title' 		=> __( 'Name'), // DEFAULT COLUMNS
				'Booking Date' 	=> __( 'Booking Date') // NEW COLUMNS
		  	);
		}
	
	
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
	
	
	/*==============================================================
		6.	REMOVE HYPERLINK TO EDIT POST IN EDIT.PHP
	==============================================================*/
		// $('table.wp-list-table a.row-title').contents().unwrap(); , put on , admin-resto-script.js
	

/*##############################################################
	2.	STYLE AND SCRIPT 
		1.	ENQUEQE STYLE
		2.	ENQUEQE SCRIPT 
		3.	REMOVE ADD NEW FEATURES ( CUSTOM POST TYPE )
##############################################################*/
if( is_admin() ){
	
	if ($_GET['post_type'] == 'olr_restaurant') {		
			
			//=	1.	ENQUEQE STYLE
			wp_enqueue_style(
				'olr-admin-resto-style',	// $handle (id)	
				$plugin_folder .'/css/admin-resto-style.css', // $sr
				false, 	// $dependencies
				false
			); 
			
			//=	2.	ENQUEQE SCRIPT
			wp_enqueue_script(
                'olr-admin-resto-script',	// $handle (id)	
                $plugin_folder . '/js/admin-resto-script.js', // $src
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
	
	
	} // if ($_GET['post_type'] == 'olr_restaurant') {			
}

/*##############################################
	3.	SETTING SUB MENU
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
					__('Settings'),				// $page_title
					__('Settings'),			// $menu_title
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
				<h2>Restaurant Reservation Setting</h2>
		
				<!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
				<?php settings_errors(); ?>
				
                	<?php
						if( isset( $_GET[ 'tab' ] ) ) {
							$active_tab = $_GET[ 'tab' ];
						} // end if
					?>
				
                <h2 class="nav-tab-wrapper">
              		<a href="?post_type=olr_restaurant&page=olr_restaurant_setting&tab=resto_general_setting" class="nav-tab <?php echo $active_tab == 'resto_general_setting' ? 'nav-tab-active' : ''; ?>">
                            General</a>
              		<a href="?post_type=olr_restaurant&page=olr_restaurant_setting&tab=resto_schedule_setting" class="nav-tab <?php echo $active_tab == 'resto_schedule_setting' ? 'nav-tab-active' : ''; ?>">
                            Schedule</a>
                   	<a href="?post_type=olr_restaurant&page=olr_restaurant_setting&tab=resto_table_setting" class="nav-tab <?php echo $active_tab == 'resto_table_setting' ? 'nav-tab-active' : ''; ?>">
                            Table</a>         
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
					
					} else {
						
						settings_fields( 'resto_table_setting' );
						do_settings_sections( 'resto_table_setting' );
					
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
	=========================================*/

		/*=========================================
			1.	 GENERAL
		=========================================*/
			require_once('general.php');
			
		/*=========================================
			2. 	SCHEDULE
		=========================================*/	
			require_once('schedule.php');
		
		/*=========================================
			3.	TABLE
		=========================================*/	
			require_once('table.php');
?>