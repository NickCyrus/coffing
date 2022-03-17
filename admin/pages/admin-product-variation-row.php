<?php

    if (isset($field)) extract($field);
 
    $uniqid =  uniqid();
?>  
<li class="item">
	<div class="grid col-620">
		<?php $image_src =  wp_get_attachment_image( $image ,  [25,25]); ?>
		<?php if ($image_src): ?>
				<div class="coffproduct-image-row"><?php echo $image_src ?></div>
		<?php endif ?>

		<div class="coffproduct-name-row"> 
			 <?php echo $name ?></div>
		</div>

        <div class="grid col-320">
            <?php echo wc_price($price) ?> - <a class="hand" onclick="fn.removeThisElement(this, 'li')" data-question="Desea eliminar este variación <?php echo $name ?>"> Eliminar </a>
        </div>
	<div class="clear"></div>

    <input type="hidden" name="_coffing_variantion_product_id[]" value="<?php echo $uniqid ?>" />
    <input type="hidden" name="_coffing_variantion_product_name[<?php echo $uniqid ?>]" value="<?php echo $name ?>" />
    <input type="hidden" name="_coffing_variantion_product_price[<?php echo $uniqid ?>]" value="<?php echo $price ?>" />
    <input type="hidden" name="_coffing_variantion_product_image[<?php echo $uniqid ?>]" value="<?php echo $image ?>" />
 
</li>