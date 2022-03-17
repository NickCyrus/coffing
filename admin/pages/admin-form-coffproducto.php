<?php

	global $product_object;
?>

	<div id='coffproducto_type_product_options' class='panel woocommerce_options_panel hidden'>

		      
		        
				
				<?php
			        woocommerce_wp_text_input(
			          array(
			            'id'          => '_coffproducto_name',
			            'label'       => __( 'Nombre de la variante', 'your_textdomain' ),
			            'value'       => '',
			            'default'     => '',
			            'class'	      => '',		
			            'placeholder' => '',
					
			        ));
		        ?>
		        <?php
			        woocommerce_wp_text_input(
			          array(
			            'id'          => '_coffproducto_price',
			            'label'       => __( 'Precio variante', 'your_textdomain' ),
			            'value'       => $product_object->get_meta( '_coffproducto_price', true ),
			            'default'     => '',
			            'class'	      => 'price',		
			            'placeholder' => '&euro;',
						
			        ));
		        ?>

				 		
					<div class="coffing-label-input">Imagen de la variante</div>
					<div class="coffing-input">
							<div class="coffing-img-thumb hand" onclick="fn.openMedia(this , 
							{ 
								title : 'Imagen de producto variable' , 
								setImage : '#coffing-img-thumb-src',
								setId   : '#coffing-img-thumb-id' 
							})">
								<img id="coffing-img-thumb-src" style="display: none;"  />
								<input type="hidden" id="coffing-img-thumb-id" />
							</div>
					</div>

					  
				 
							<div class="clear"></div>
			 

			<div class="row">
					<div class="col-4">
						<button type="button" class="button tagadd" onclick="fn.add_product_variante( this )">Añadir variante de producto</button>
					</div>
				</div>
				 

			        <div class="coffing-table" id="table-variacion-caja">
			        		<ul class="table sortable">
			        				<li class="cap li-state-disabled">
			        					<div class="grid col-620 title-product"><b>VARIANTE</b></div>
			        					<div class="grid col-320"><b>PRECIO</b></div>
			        					<div class="clear"></div>
			        				</li>
			        		
							<?php
									$variations = $product_object->get_meta( '_coffvariation_product', true );
									if ($variations){
										$variations = json_decode($variations, true);
										foreach($variations as $variation){
										 
											get_template_coffing( COFCO_PLUGIN_ADMIN.'pages/admin-product-variation-row.php' , $variation );
										}
										 

										echo "<script>fn.apply_plugins()</script>";
									}
									 
							?>
							</ul>
			         
			        </div>
				 

	<!-- #coffcaja_type_product_options !-->		        
  </div>
