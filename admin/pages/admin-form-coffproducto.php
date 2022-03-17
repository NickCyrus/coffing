<?php

	global $product_object;
?>

	<div id='coffproducto_type_product_options' class='panel woocommerce_options_panel hidden'>

		        <div class='options_group'>
		        
		        <?php
			        woocommerce_wp_text_input(
			          array(
			            'id'          => '_coffproducto_price',
			            'label'       => __( 'Precio Caja', 'your_textdomain' ),
			            'value'       => $product_object->get_meta( '_coffproducto_price', true ),
			            'default'     => '',
			            'class'	      => 'price',		
			            'placeholder' => '&euro;',
			        ));
		        ?>

		        </div>
				 

			        <div class="coffing-table" id="table-incluye-caja">
			        		<ul class="table sortable">
			        				<li class="cap li-state-disabled">
			        					<div class="grid col-620 title-product"><b>VARIANTE</b></div>
			        					<div class="grid col-320"><b>PRECIO</b></div>
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
