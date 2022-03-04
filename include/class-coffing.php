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

					add_action('init',[ $this, 'registerCssAndJs' ] , 20);
					add_action('admin_head', [ $this, 'registerCssAndJsInHead' ] , 20 );

			}

			public function registerCssAndJsInHead()
			{
					echo '<script type="text/javascript"> var COFCOURLADMIN = "'.COFCO_PLUGIN_ADMIN_URL.'";</script>';
			}

			public function registerCssAndJs()
			{

					$css = [
							'https://fonts.googleapis.com/css2?family=Hubballi&display=swap',

							COFCO_PLUGIN_ADMIN_URL.'asset/js/plugins/sweetalert2/sweetalert2.min.css',
							COFCO_PLUGIN_ADMIN_URL.'asset/css/coffing.css',

							COFCO_PLUGIN_PUBLIC_URL.'asset/css/coffing.css'
						   ];

					foreach ($css as $item) {
						$ver  = rand();
						wp_enqueue_style( $this->slug.str_replace('.','-',basename($item)), $item, '', $ver, 'all'  );
					}

					$js = [
							COFCO_PLUGIN_ADMIN_URL.'asset/js/plugins/sweetalert2/sweetalert2.all.min.js',
							COFCO_PLUGIN_ADMIN_URL.'asset/js/coffing-functions.js',
							COFCO_PLUGIN_ADMIN_URL.'asset/js/coffing.js',

							COFCO_PLUGIN_PUBLIC_URL.'asset/js/coffing.js'
						   ];

					 
					foreach ($js as $item) {
						$ver  = rand();
						wp_enqueue_script( $this->slug.str_replace('.','-',basename($item)), $item, '', $ver );
					}




			}

			public function setMenuOptions(){

					 
						add_menu_page('Coffing Control',
									  'Coffing Control', 
									  'manage_options', 
									  $this->slug,
									  [$this, 'coffing_welcome'],
									  COFCO_PLUGIN_ADMIN_URL.'images/icon-2x32.png'
									);

						add_submenu_page($this->slug, 'Pedidos',  'Pedidos',  'manage_options', 'coffing_pedidos', [$this, 'coffing_pedidos']);
						add_submenu_page($this->slug, 'Cajas',  'Cajas',  'manage_options', 'coffing_cajas', [$this, 'coffing_cajas']);
						add_submenu_page($this->slug, 'Productos',  'Productos',  'manage_options', 'coffing_productos', [$this, 'coffing_productos']);
						add_submenu_page($this->slug, 'Franjas horarias',  'Franjas horarias',  'manage_options', 'coffing_franjas', [$this, 'coffing_franjas']);


			}

			function coffing_welcome(){
				echo '<style type="text/css">#wpwrap{ background: #FFF !important; }</style>';
				include(COFCO_PLUGIN_ADMIN.'pages/welcome.php');
			}

			function coffing_pedidos(){  $this->coffing_action('coffing_pedidos'); }
			function coffing_cajas(){  $this->coffing_action('coffing_cajas'); }
			function coffing_productos(){  $this->coffing_action('coffing_productos'); }
			function coffing_franjas(){  $this->coffing_action('coffing_franjas'); }

			
			function coffing_action($action){

				$page = $action;
				$_REQUEST['action'] =  $action;
				echo '<style type="text/css">#wpwrap{ background: #FFF !important; }</style>';

				if (file_exists( COFCO_PLUGIN_ADMIN."pages/{$page}.php")){
					include(COFCO_PLUGIN_ADMIN."pages/{$page}.php");
				}else{
					echo "<h1>Upsss!!, opcion no valida</h1>";
				}
			}

	 /* End class */

	}


?>
