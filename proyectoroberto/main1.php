<?php
	require "app/model/mod004_presentacion.php";

	$layerBrands = mod003_getAllBrands();
	$layerClient = mod003_getAllClient();
	
	require "public/vista/vista_main1.php";
?>
