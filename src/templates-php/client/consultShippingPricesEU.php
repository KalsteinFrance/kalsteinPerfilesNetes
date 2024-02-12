<div id='c-panel09' class='col-sm-12' style='height: auto;<?php echo isset($_GET['userToConsultPriceShipping']) && isset($_GET['countryToConsultPriceShipping']) ? 'display: block' : 'display: none' ?>'>
	<?php
		require __DIR__. '/../../../php/conexion.php';
		$banner_img = 'Header-consultar-precios.jpg';
		$banner_text = "Consulte los gastos de envío";
		include 'banner.php';

		$userProduct = $_GET['userToConsultPriceShipping'];
		$country = $_GET['countryToConsultPriceShipping'];
		$idCotizacion = $_GET['idCotizacion'];
		$consultCountry = "SELECT * FROM wp_paises WHERE iso = '$country'";
		$resultConsultCountry = $conexion->query($consultCountry);
		$rowConsultCountry = mysqli_fetch_array($resultConsultCountry);
		$nameCountry = $rowConsultCountry['en'];
		$consultQuo = "SELECT * FROM wp_cotizacion WHERE cotizacion_id = '$idCotizacion'";
		$resultConsultQuo = $conexion->query($consultQuo);
		$rowConsultQuo = mysqli_fetch_array($resultConsultQuo);
		$zipcode = $rowConsultQuo['cotizacion_zipcode'];
	?>

	<div class='row'>
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
			<div class="mb-3">
				<label for="inputShippingCost-subject" class="form-label">Asunto</label>				
				<input type="hidden" id="userShippingCost01" value='<?php echo $userProduct?>'>
				<input type="text" class="form-control" id="inputShippingCost-subject" placeholder="name@example.com" readonly="" value="Shipping cost inquiry to <?php echo $nameCountry;?>">
			</div>
			<div class="mb-3">
				<label for="inputShippingCost-subject" class="form-label">Dirección *</label>
				<input type="text" class="form-control" id="inputShippingCost-address" placeholder="2 rue Jean Lantier">
			</div>
			<div class="mb-3">
				<label for="inputShippingCost-subject" class="form-label">Código postal *</label>
				<input type="number" class="form-control" id="inputShippingCost-zipcode" placeholder="75001">
			</div>
			<div class="mb-3">
				<label for="inputShippingCost-textarea" class="form-label">Información adicional (opcional)</label>
				<textarea class="form-control" id="inputShippingCost-textarea" rows="3"></textarea>
			</div>
			<div class='mb3'>
				<button class='btn btn-primary' style='width: 100%; height: 4rem; color: #fff; text-align: center !important; background-color: #213280;' id='btnShippingCost-send'><span style='text-align: center; width: 100%;'>Envíar</span></button>
			</div>
		</div>
		<div class="col-sm-3"></div>
	</div> 
</div>
