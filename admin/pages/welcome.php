<div class="cofco-wrap cofco">
		<h1 class="cap">Dashboard</h1>
		<?php

			   $args = array(
			        'post_type'      => 'product',
			        'posts_per_page' => 10,
			        'product_type'    => ['coffproducto']
			    );

			    $loop = new WP_Query( $args );

			   

			    while ( $loop->have_posts() ) : $loop->the_post();
			        global $product;
			        echo '<br /><a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail().' '.get_the_title().'</a>';
			    endwhile;

			    wp_reset_query();

		?>
</div>
<script type="text/javascript">
	$(function(){
	 	fn.welcome();
	})
</script>