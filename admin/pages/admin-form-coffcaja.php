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
		        ?>

		        </div>

		         <div class="coffing-toolbar toolbar-top">
		         	 
		         	  <select class="select" id="select_product_coffing">
		         	  		<option selected value> -- Seleccionar productos</option>
		         	  		<?php
		         	  			$coffingProductos =	coffing::get_product_coffing();
		         	  		 	if ($coffingProductos->posts):
		         	  				foreach($coffingProductos->posts as $cofpro){
		         	  					echo "<option value='{$cofpro->ID}'>{$cofpro->post_title}</option>";
		         	  				}
		         	  			endif;
		         	  		?>
				      </select> 
					  <button class="btn-action" type="button" onclick="fn.add_product_caja('#select_product_coffing')">Agregar producto </button>
		         </div>

		          
			        <div class="coffing-table" id="table-incluye-caja">
			        		<ul class="table">
			        				<li class="cap">
			        					<div class="grid col-620 title-product"><b>PRODUCTO INCLUIDO</b></div>
			        					<div class="grid col-320"><b>CANTIDAD</b></div>
			        					<div class="clear"></div>
			        				</li>

			        		</ul>
			         
			        </div>
				 

	<!-- #coffcaja_type_product_options !-->		        
  </div>
