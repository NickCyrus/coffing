<?php
 
	if (!$product_id) exit('');

	$product = wc_get_product( $product_id );

?>
<li class="item">
	<div class="grid col-620">
		<i class="fa"></i>
		<input type="hidden" class="_product_include" name="_product_include[]" value="<?php echo $product_id ?>" /><?php echo $product->name ?></div>
	<div class="grid col-320">
		<input class="on tc" name="_cantidad_product[<?php echo $product_id ?>]" value="0" required /> - <a class="hand" onclick="fn.removeThisElement(this, 'li')" data-question="Desea eliminar este producto <?php echo $product->name ?>"> Eliminar </a>
	</div>
	<div class="clear"></div>
</li>