<div class="cofco-wrap cofco">
	<h1 class="cap">Configuración Coffing Control</h1>


	<div class="row">
		<div class="col-md-4">
				<div class="cofco-card">
					<div class="cofco-card-header">
						CATEGORIA DE CAJAS
					</div>
					<div class="cofco-card-body">
						<select class="w100" name="coffing_cat_caja" id="coffing_cat_caja" required>
								<option selected > </option>
								<?php echo $GLOBALS['cofco']->getCategoryProductSelec() ?>
						</select>
						<p> <i>Selecione la categoria de productos que corresponde a las cajas</i> </p>
					</div>
				</div>

		</div>
	</div>

</div> 