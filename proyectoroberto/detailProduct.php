<?php
require "app/model/mod004_presentacion.php";

	if ( isset( $_GET[ "idproduct" ] ) ) {
		$detailProduct = $_GET[ "idproduct" ];
	
		$detailProduct = mod004_getDetailProduct($idProduct, $nomproduct, $description, $image);

        include "public/vista/vista_detailBrand.php";
	} else {
		echo "La cadena idClient NO está en una URL";
	}
	
