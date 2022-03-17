<?php

	global $product_object;
?>

	<div id='coffcaja_type_product_options' class='panel woocommerce_options_panel hidden'>

		        <div class='options_group'>
		        
		        <?php
			        woocommerce_wp_text_input(
			          array(
			            'id'          => '_coffcaja_price',
			            'label'       => __( 'Precio Caja', 'your_textdomain' ),
			            // 'description' => __( 'Precio de la caja total.', 'woocommerce' ),
			            'value'       => $product_object->get_meta( '_coffcaja_price', true ),
			            'default'     => '',
			            'class'	      => 'price',		
			            'placeholder' => '&euro;',
			        ));
		       
			        woocommerce_wp_text_input(
			          array(
			            'id'          => '_coffcaja_limite',
			            'label'       => __( 'Limite diario', 'your_textdomain' ),
			            'description' => __( 'Limite de venta diario.', 'woocommerce' ),
			            'value'       => $product_object->get_meta( '_coffcaja_limite', true ),
			            'default'     => '',
			            'class'	      => 'price' 
			        ));

					woocommerce_wp_text_input(
						array(
						  'id'          => '_coffcaja_fecha_limite',
						  'label'       => __( 'Fecha limite de venta', 'your_textdomain' ),
						  'type' => "date",
						  'value'       => $product_object->get_meta( '_coffcaja_fecha_limite', true ),
						  'default'     => '',
						   
					  ));
		        ?>

		        </div>
				
				

		         <div class="coffing-toolbar toolbar-top row">
		         	 <div class="col-6 select-btn">
						<select class="select" id="select_product_coffing">
								<option selected value> -- Seleccionar Productos</option>
								<?php
									$coffingProductos =	coffing::get_product_coffing();
									if ($coffingProductos->posts):
										foreach($coffingProductos->posts as $cofpro){
											
											echo "<option value='{$cofpro->ID}'>{$cofpro->post_title}</option>";
										}
									endif;
								?>
						</select> 
						<button class="btn-action" type="button" onclick="fn.add_product_caja('#select_product_coffing' , this )">Agregar Producto </button>
					  </div>	
					  
					  <div class="col-6 select-btn">
						<select class="select" id="select_extras_coffing">
								<option selected value> -- Seleccionar Extras</option>
								<?php
									$coffingProductos =	coffing::get_product_coffing(['coffextra']);
									if ($coffingProductos->posts):
										foreach($coffingProductos->posts as $cofpro){
											
											echo "<option value='{$cofpro->ID}'>{$cofpro->post_title}</option>";
										}
									endif;
								?>
						</select> 
						<button class="btn-action" type="button" onclick="fn.add_product_caja('#select_extras_coffing' , this )">Agregar Extra </button>
					  </div>				   

		         </div>
				 
					<div class="coffing-notice notice-warning">
							Todos los productos agregados aqui <b>NO</b> tendrán valor adicional sin importar que sea un <b>Extra</b>.			
					</div>

			        <div class="coffing-table" id="table-incluye-caja">
			        		<ul class="table sortable">
			        				<li class="cap li-state-disabled">
			        					<div class="grid col-620 title-product"><b>PRODUCTOS INCLUIDOS</b></div>
			        					<div class="grid col-320"><b>CANTIDAD</b></div>
			        					<div class="clear"></div>
			        				</li>
			        		
							<?php
									$incluye = $product_object->get_meta( '_product_include_coffing', true );
									if ($incluye){
										$incluye = json_decode($incluye, true);
									 	foreach($incluye as $producid=>$cantidad){
											get_template_coffing( COFCO_PLUGIN_ADMIN.'pages/admin-product-row.php' , ['product_id'=>$producid ,'cantidad'=>$cantidad] );
										}

										echo "<script>fn.apply_plugins()</script>";
									}
									 
							?>
							</ul>
			         
			        </div>
				 

	<!-- #coffcaja_type_product_options !-->		        
  </div>
