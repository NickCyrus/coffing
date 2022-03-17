<?php

	/*
	 * CLASS CONTROLLER COFFING
	*/


	class coffing{

			var $slug = 'cofco';
			var $slugsProduct = ['coffcaja','coffproducto','coffextra'];

			public function __construct(){

				add_action( 'woocommerce_loaded', array( $this, 'checkRequeriment' ) );
					 
			}

			public function checkRequeriment(){
					
					if ( ! function_exists( 'is_plugin_active' ) ){
        				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    				}

					if (!is_plugin_active( 'woocommerce/woocommerce.php' ) ){
						add_action( 'admin_notices', 'woo_not_install' );
					}


					require_once COFCO_PLUGIN.'/include/class-wc-product-coffing.php';

					register_activation_hook( __FILE__, array( $this, 'set_product_type' ) );

					/***************** OPTIONS CAJA ************************/

						add_filter( 'product_type_selector', array( $this, 'add_type_coffing_caja' ) );
						add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_coffcaja_product_tab' ), 50 );
	        			add_action( 'woocommerce_product_data_panels', array( $this, 'add_coffcaja_product_tab_content' ) );
	        			add_action( 'woocommerce_process_product_meta_coffcaja', array( $this, 'save_coffcaja_settings' ) );
						add_action( 'woocommerce_process_product_meta_coffproducto', array( $this, 'save_coffproducto_settings' ) );
						add_action( 'woocommerce_process_product_meta_coffextra', array( $this, 'save_coffextra_settings' ) );
						
						add_action( 'wp_ajax_ajax_coffing', array( $this, 'ajax_coffing' ) );
						add_action( 'wp_ajax_nopriv_ajax_coffing' , array( $this, 'ajax_coffing' ));


					/*********************************************************/


					add_action('admin_menu',[ $this, 'setMenuOptions' ] , 20);

					add_action('init',[ $this, 'registerCssAndJs' ] , 20);
					add_action('admin_head', [ $this, 'registerCssAndJsInHead' ] , 20 );

					/*
						if (!$this->getopc('conffi_config')){
							add_action( 'admin_notices', 'coffig_not_conffig' );
						}
					*/

			}

			public function registerCssAndJsInHead()
			{
					echo '<script type="text/javascript"> var COFCOURLADMIN = "'.COFCO_PLUGIN_ADMIN_URL.'";</script>';
			}

			public function registerCssAndJs()
			{

					$css = [
							'https://fonts.googleapis.com/css2?family=Hubballi&display=swap',
								
							COFCO_PLUGIN_ADMIN_URL.'asset/css/simple-grid.css',
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
							COFCO_PLUGIN_ADMIN_URL.'asset/js/plugins/jQuery.numeric.js',
							COFCO_PLUGIN_ADMIN_URL.'asset/js/coffing-functions.js',
							COFCO_PLUGIN_ADMIN_URL.'asset/js/coffing.js',

							COFCO_PLUGIN_PUBLIC_URL.'asset/js/coffing.js'
						   ];

					 
					foreach ($js as $item) {
						$ver  = rand();
						wp_enqueue_script( $this->slug.str_replace('.','-',basename($item)), $item, '', $ver );

						
					}

					wp_localize_script( $this->slug.str_replace('.','-',basename($item)), 'ajax_coffing',
							array(
							        'url'    => admin_url( 'admin-ajax.php' ),
							        'nonce'  => wp_create_nonce( 'my-ajax-nonce' ),
							        'action' => 'ajax_coffing'
    						  )
						);

					 


			}

			static public function getopc($value){
				return get_option($value);
			}

			static public function setopc($key , $value){
				return update_option( $key , $value);
			}

			static public function addopc($key , $value){
				return add_option( $key , $value);
			}

			public function setMenuOptions(){

					 
						add_menu_page('Coffing Control',
									  'Coffing Control', 
									  'manage_options', 
									  $this->slug,
									  [$this, 'coffing_welcome'],
									  COFCO_PLUGIN_ADMIN_URL.'images/icon-2x32.png'
									);

						add_submenu_page($this->slug, 'Configuración',  'Configuración',  'manage_options', 'coffing_config', [$this, 'coffing_config']);
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
			function coffing_config(){  $this->coffing_action('coffing_config'); }
			
			
			static public function coffing_action($action){

				$page = $action;
				$_REQUEST['action'] =  $action;
				echo '<style type="text/css">#wpwrap{ background: #FFF !important; }</style>';

				if (file_exists( COFCO_PLUGIN_ADMIN."pages/{$page}.php")){
					include(COFCO_PLUGIN_ADMIN."pages/{$page}.php");
				}else{
					echo "<h1>Upsss!!, opcion no valida</h1>";
				}
			}

			static public  function redirec($opc){

					switch ($opc) {
						case 'config':
								self::coffing_action('config');
						break;
						default:
							// code...
						break;
					}

			}

			static public function getCategoryProduct($args = array())
			{

				$default =  ['number'=>'','orderby'=>'name','order'=>'ASC', 'hide_empty'=>true, 'ids'=>''];
				
				$args = array_merge($args , $default);
 
				extract($args , EXTR_SKIP);

				$args = array(
				    'taxonomy'   => "product_cat",
				    'number'     => $number,
				    'orderby'    => $orderby,
				    'order'      => $order,
				    'hide_empty' => $hide_empty,
				    'include'    => $ids
				);
				
				return get_terms($args);


			}

			static public function getCategoryProductSelec($select = '')
			{
					$cats  = self::getCategoryProduct();
				 
					$option = '';
					            
					if ($cats){
						foreach($cats as $cat){
							$option .= "<option value='{$cat->term_id}' data-parent='{$cat->parent}' data-count='{$cat->count}'>{$cat->name}</option>"; 
						}
					}
					 
					return $option;
			}


			function add_type_coffing_caja( $types ) {
				$types['coffcaja']     = __( 'Coffing Cajas', 'yourtextdomain' );
				$types['coffproducto'] = __( 'Coffing Producto', 'yourtextdomain' );
				$types['coffextra']    = __( 'Coffing Producto Extra', 'yourtextdomain' );
			    return $types;
			}

			public function set_product_type() {
		        
			 	foreach($this->slugsProduct as $slug){
					if ( ! get_term_by( 'slug', $slug, 'product_type' ) ) {
						wp_insert_term( $slug, 'product_type' );
			 		}
				}

			}

		    public function add_coffcaja_product_tab( $tabs ) {


			      $tabs['coffcaja_type'] = array(
													'label'    => __( 'Opciones de Caja', 'your_textdomain' ),
													'target' => 'coffcaja_type_product_options',
													'class'  => 'show_if_coffcaja',
													'priority'=>5
											     );
			       $tabs['coffproducto_type'] = array(
													'label'    => __( 'Opciones de Producto', 'your_textdomain' ),
													'target' => 'coffproducto_type_product_options',
													'class'  => 'show_if_coffproducto',
													'priority'=>5
											     );

					$tabs['coffextra_type'] = array(
													'label'    => __( 'Opciones de Extra', 'your_textdomain' ),
													'target' => 'coffextra_type_product_options',
													'class'  => 'show_if_coffextra',
													'priority'=>5
											     );  								 
			        
			      return $tabs;

			    }
			    
		    /**
		     * Add Content to Product Tab
		     */

		    public function add_coffcaja_product_tab_content() {
		       	include(COFCO_PLUGIN_ADMIN."pages/admin-form-coffcaja.php");
				include(COFCO_PLUGIN_ADMIN."pages/admin-form-coffproducto.php");
				include(COFCO_PLUGIN_ADMIN."pages/admin-form-coffextra.php");  
		    }  

			public function save_coffextra_settings( $post_id ) {
				$price = isset( $_POST['_coffextra_price'] ) ? sanitize_text_field( $_POST['_coffextra_price'] ) : '';
				update_post_meta( $post_id, '_coffextra_price', $price );
				update_post_meta( $post_id, '_price', $price);
				update_post_meta( $post_id, '_regular_price', $price);
			} 

			public function save_coffproducto_settings( $post_id ) {
				$price = isset( $_POST['_coffproducto_price'] ) ? sanitize_text_field( $_POST['_coffproducto_price'] ) : '';
				update_post_meta( $post_id, '_coffproducto_price', $price );
				update_post_meta( $post_id, '_price', $price);
				update_post_meta( $post_id, '_regular_price', $price);

			  /***************** Productos incluidos **********************/
			  /*	
				$incluye  = isset( $_POST['_product_include'] ) ? $_POST['_product_include']  : '';
				
				if ($incluye){
					foreach($incluye as $producto){
						$listaProductoIncluye[$producto] = $_POST["_cantidad_product"][$producto];
					}

					if ($listaProductoIncluye){
						update_post_meta( $post_id, '_product_include_coffing', wp_json_encode($listaProductoIncluye) );	 
					}
				}
			  
			   */
			
		  }

			public function save_coffcaja_settings( $post_id ) {
      			$price = isset( $_POST['_coffcaja_price'] ) ? sanitize_text_field( $_POST['_coffcaja_price'] ) : '';
      			update_post_meta( $post_id, '_coffcaja_price', $price );
      			update_post_meta( $post_id, '_price', $price);
      			update_post_meta( $post_id, '_regular_price', $price);

				/***************** Productos incluidos **********************/

				$incluye  = isset( $_POST['_product_include'] ) ? $_POST['_product_include']  : '';
				 
				if ($incluye){
					foreach($incluye as $producto){
						$listaProductoIncluye[$producto] = $_POST["_cantidad_product"][$producto];
					}

					if ($listaProductoIncluye){
						update_post_meta( $post_id, '_product_include_coffing', wp_json_encode($listaProductoIncluye) );	 
					}
				}
			 
    		}

    		static public function get_product_coffing($type = ['coffproducto'])
    		{
    			 $args = array(
						        'post_type'      => 'product',
						        'posts_per_page' => -1,
						        'product_type'   => $type,
						        'orderby'		 => 'post_title',
						        'order'			 => 'ASC'	
			    			  );

			    return new WP_Query( $args );
    		}



    		public function ajax_coffing()
    		{

    			$case  = $_POST['opc'];
    			switch($case){
    				case 'add_product_coffing':
    					get_template_coffing( COFCO_PLUGIN_ADMIN.'pages/admin-product-row.php' , $_POST);
    				break;
    				default:
    					pre($_REQUEST);	
    				break;
    			}
    			
    			exit();
    		}


	/* End class */

	}


?>
