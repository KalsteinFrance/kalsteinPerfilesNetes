<div id='c-panel08' style='display: none;'>

	<?php
		$banner_img = 'Header-usuario-IMG.png';
		$banner_text = "Catálogos";
		include 'banner.php';
	?>

	<style>
		#category {
			padding: 12px 20px;
			display: inline-block;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
		}

		#searchreport {
			padding: 12px 20px;
			display: inline-block;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box; 
		}

		#catalogo {
			display: grid;
			grid-gap: 20px;
			place-items: center;
		}

		.g-4, .gy-4 {
			--bs-gutter-y: 2rem;
			--bs-gutter-x: -4.5rem;
		}
	</style>

	<div class="row mx-4 mb-4">
		<div class="category-select col-12 col-md-6 d-flex align-items-center px-0">
			<i class="fa-solid fa-filter mx-3"></i>
			<select id="category" style="padding-left: 10px;"></select>
		</div>

		<div class="search col-12 col-md-6 d-flex align-items-center px-0">
			<i class="fas fa-search mx-3"></i>
			<input type="text" placeholder="Buscar un catalogo" id="searchreport" style="padding-left: 10px; height: 100%" class='mb-0'>
		</div>
	</div>
	<div id="catalogo"></div>
</div>