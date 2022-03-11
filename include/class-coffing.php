<?php

	/*
	 * CLASS CONTROLLER COFFING
	*/


	class coffing{

			var $slug = 'cofco';

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
					add_filter( 'product_type_selector', array( $this, 'add_type_coffing_caja' ) );
					register_activation_hook( __FILE__, array( $this, 'set_product_type' ) );
					add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_coffcaja_product_tab' ), 50 );
        			add_action( 'woocommerce_product_data_panels', array( $this, 'add_coffcaja_product_tab_content' ) );
					 
					add_action('admin_menu',[ $this, 'setMenuOptions' ] , 20);

					add_action('init',[ $this, 'registerCssAndJs' ] , 20);
					add_action('admin_head', [ $this, 'registerCssAndJsInHead' ] , 20 );

					if (!$this->getopc('conffi_config')){
						add_action( 'admin_notices', 'coffig_not_conffig' );
					}
					

			}

			public function registerCssAndJsInHead()
			{
					echo '<script type="text/javascript"> var COFCOURLADMIN = "'.COFCO_PLUGIN_ADMIN_URL.'";</script>';
			}

			public function registerCssAndJs()
			{

					$css = [
							'https://fonts.googleapis.com/css2?family=Hubballi&display=swap',
								
							// COFCO_PLUGIN_ADMIN_URL.'asset/css/bootstrap.min.css',
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
					/*
					[term_id] => 17
					            [name] => Tshirts
					            [slug] => tshirts
					            [term_group] => 0
					            [term_taxonomy_id] => 17
					            [taxonomy] => product_cat
					            [description] => 
					            [parent] => 16
					            [count] => 1
					            [filter] => raw
					*/ 
					
					$option = '';
					            
					if ($cats){
						foreach($cats as $cat){
							$option .= "<option value='{$cat->term_id}' data-parent='{$cat->parent}' data-count='{$cat->count}'>{$cat->name}</option>"; 
						}
					}
					 
					return $option;
			}


			function add_type_coffing_caja( $types ) {
				$types['coffcaja'] = __( 'Coffing Cajas', 'yourtextdomain' );
			    return $types;
			}

			public function set_product_type() {
		        if ( ! get_term_by( 'slug', 'coffcaja', 'product_type' ) ) {
			 			 wp_insert_term( 'coffcaja', 'product_type' );
		        }
		    }

		    public function add_coffcaja_product_tab( $tabs ) {

			      $tabs['coffcaja_type'] = array(
													'label'    => __( 'Opciones de Caja', 'your_textdomain' ),
													'target' => 'coffcaja_type_product_options',
													'class'  => 'show_if_coffcaja',
													'priority'=>5
											     );
			        
			        
			      return $tabs;
			    }
			    
		    /**
		     * Add Content to Product Tab
		     */

		    public function add_coffcaja_product_tab_content() {
		      global $product_object;
		      ?>
		      <div id='coffcaja_type_product_options' class='panel woocommerce_options_panel hidden'>

		        <div class='options_group'>
		        
		        <?php
			        woocommerce_wp_text_input(
			          array(
			            'id'          => '_coffcaja_price',
			            'label'       => __( 'Data', 'your_textdomain' ),
			            'value'       => $product_object->get_meta( '_coffcaja_price', true ),
			            'default'     => '',
			            'placeholder' => 'Enter data',
			        ));
		        ?>

		        </div>
		        <div class='options_group'>
								        	 <?php
								        woocommerce_wp_select( array( // Text Field type
						        'id'          => '_Stan[]',
						        'label'       => __( 'Stan', 'woocommerce' ),
						        'description' => __( 'Podaj stan plyty.', 'woocommerce' ),
						        'desc_tip'    => true,
						        'class'       => 'select2',
						        'options'     => array(
						            ''        => __( 'Select product condition', 'woocommerce' ),
						            'Nowa'    => __('Nowa', 'woocommerce' ),
						            'Uzywana' => __('Uzywana', 'woocommerce' ),
						        )
						    ) );
					?>
    			</div>
		      </div>
		      <?php
		    }  

			 /* End class */

	}


?>
