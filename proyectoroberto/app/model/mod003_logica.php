<?php

require "mod002_accesoadatos.php";

function mod003_getAllBrands()
{
	$arDataBrands = mod002_getAllBrands();

	if ($arDataBrands["status"]["codError"] === "001") {
		$arDataBrands["data"][0]["idBrand"] 	= "No se que ha pasado";
		$arDataBrands["data"][0]["nameBrand"] 	= "";
		$arDataBrands["data"][0]["idLogo"] 	= "";
		$arDataBrands["data"][0]["nameLogo"]	= "";
	}


	return $arDataBrands;
}

function mod003_getAllClient()
{
	$arDataBrands = mod002_getAllClient();

	if ($arDataBrands["status"]["codError"] === "001") {
		$arDataBrands["data"][0]["idClient"] 		= "No se que ha pasado";
		$arDataBrands["data"][0]["nameClient"] 		= "";
		$arDataBrands["data"][0]["surnameClient"] 	= "";
	}

	return $arDataBrands;
}

function mod003_getAllOrders()
{
	$arDataBrands = mod002_getAllOrders();

	if ($arDataBrands["status"]["codError"] === "001") {
		$arDataBrands["data"][0]["idClient"] 		= "No se que ha pasado";
		$arDataBrands["data"][0]["nameClient"] 		= "";
		$arDataBrands["data"][0]["surnameClient"] 	= "";
		$arDataBrands["data"][0]["idOrder"] 		= "";
	}

	return $arDataBrands;
}

function mod003_newAccount($nameUser, $emailUser, $passwordUser, $direction, $surname)
{
	$uniqUserId = uniqid();
	$salt = random_bytes(16);
	$saltPassword = $salt . $passwordUser;
	$hash = password_hash($saltPassword, PASSWORD_BCRYPT, ["cost" => 12]);
	$insertResult = mod002_newAccount($uniqUserId, $nameUser, $emailUser, $salt, $hash, $direction, $surname);

	if ($insertResult === "Registro insertado correctamente") {
		header("Location: main.php");
		exit;
	} else {
		if (is_array($insertResult)) {
			return "Error al insertar el registro: " . implode(", ", $insertResult);
		} else {
			return $insertResult;
		}
	}
}

function mod003_login($emailUser, $passwordUser)
{
    $dataUser = mod002_getDataUser($emailUser);

    if ($dataUser["status"]["codError"] === "000") {
        $saltPassword = $dataUser["data"][0]["salt"] . $passwordUser;
        if (password_verify($saltPassword, $dataUser["data"][0]["password"])) {
            $_SESSION["idcliente"] = $dataUser["data"][0]["uniquserid"];
            $_SESSION["nombrecliente"] = $dataUser["data"][0]["username"];
            return true; // Indica inicio de sesión exitoso
        } else {
            return false; // Indica error de contraseña
        }
    } else {
        return false; // Indica otro tipo de error, por ejemplo, usuario no encontrado
    }
}

function mod003_search($search)
{
	$dataSearchClients = mod002_getSomeClients($search);
	$dataSearchOrders = mod002_getSomeOrders($search);
	$dataSearch = array(
		"status" => array(
			"codError" => "",
			"num_rows" => 0
		),
		"data" => array()
	);

	if ($dataSearchClients["status"]["codError"] === "000" && $dataSearchOrders["status"]["codError"] === "000") {
		foreach ($dataSearchClients["data"] as $client) {
			$clientWithOrders = $client;
			$clientWithOrders["orders"] = array();
			foreach ($dataSearchOrders["data"] as $order) {
				if ($order["idClient"] === $client["idClient"]) {
					$clientWithOrders["orders"][] = $order["idOrder"];
				}
			}
			$dataSearch["data"][] = $clientWithOrders;
		}
		$dataSearch["status"]["codError"] = "000";
		$dataSearch["status"]["num_rows"] = count($dataSearch["data"]);
	} elseif ($dataSearchClients["status"]["codError"] === "000") {
		$dataSearch = $dataSearchClients;
	} else {
		$dataSearch = $dataSearchOrders;
	}

	return $dataSearch;
}

function mod003_countProductsByBrand($numRegistryByPage, $idBrand)
{
	$arDetailProducts = mod002_getDetailBrand($idBrand);
	$numTotalRegistry = count($arDetailProducts["data"]);
	$totalPages = ceil($numTotalRegistry / $numRegistryByPage);

	return $totalPages;
}

function mod003_getProductsPag($currentPage, $numRegistryByPage, $idBrand)
{
	$initialRegistry = ($currentPage - 1) * $numRegistryByPage;
	$dataPlayerPag = mod002_getProductsPag($initialRegistry, $numRegistryByPage, $idBrand);
	return $dataPlayerPag;
}

function mod003_getDetailProduct($clientesId)
{
	$arDetailPerProduct = mod002_getDetailProduct($clientesId);

	return $arDetailPerProduct;
}

function mod003_getDetailClient($clientId)
{
    $clientDetails = mod002_getDetailClient($clientId);
	if ($clientDetails["status"]["codError"] === "000"){
		return $clientDetails["data"][0];
	}
   
}
