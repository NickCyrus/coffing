<?php

	/*
	 * CLASS CONTROLLER COFFING
	*/


	class coffing{

			var $slug = 'cofco';

			public function __construct(){
					$this->checkRequeriment();
					 
			}

			public function checkRequeriment(){
					
					if ( ! function_exists( 'is_plugin_active' ) ){
        				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    				}

					if (!is_plugin_active( 'woocommerce/woocommerce.php' ) ){
						add_action( 'admin_notices', 'woo_not_install' );
					}

					add_action('admin_menu',[ $this, 'setMenuOptions' ] , 20);

			}

			public function setMenuOptions(){

						/*

						add_menu_page(
        'My Page Title',
        'My Menu Title',
        'manage_options',
        'my-menu-slug',
        'render_my_menu_page',
        PLUGIN_DIR_URL . 'admin/img/my-menu-logo.png', // this is where I call my custom image.
        '26'
    );


							add_menu_page('My Custom Page', 'My Custom Page', 'manage_options', 'my-top-level-slug');
add_submenu_page( 'my-top-level-slug', 'My Custom Page', 'My Custom Page',
    'manage_options', 'my-top-level-slug');

						*/

						add_menu_page('Coffing Control',
									  'Coffing Control', 
									  'manage_options', 
									  $this->slug,
									  [$this, 'coffing_welcome'],
									  COFCO_PLUGIN_ADMIN_URL.'images/icon-2x32.png'
									);
			}

			function coffing_welcome(){
				echo "Welcomer Coffin Control";
			}
	
	 /* End class */

	}


?>
