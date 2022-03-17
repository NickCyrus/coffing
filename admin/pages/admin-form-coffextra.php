<?php
	global $product_object;
?>

	<div id='coffextra_type_product_options' class='panel woocommerce_options_panel hidden'>

		        <div class='options_group'>
		        
                    <?php
                        woocommerce_wp_text_input(
                        array(
                            'id'          => '_coffextra_price',
                            'label'       => __( 'Precio Extra', 'your_textdomain' ),
                            'value'       => $product_object->get_meta( '_coffextra_price', true ),
                            'default'     => '',
                            'class'	      => 'price',		
                            'placeholder' => '&euro;',
                        ));
                    ?>

		        </div>
	<!-- #coffextra_type_product_options !-->		        
  </div>
