<?php

require "mod001_kernel.php";

function mod002_executeQuery($strSQL, $arAttributes)
{
	$link = mod001_conectoBD();

	// Ejecuta la query almacenada en $strSQL y la información lo mete en $result.
	if ($result = $link->query($strSQL)) {
		if ($result->num_rows !== 0) {
			$arRetorno["status"]["codError"] = "000"; // Con datos.
			$arRetorno["status"]["numRows"] = $result->num_rows;

			$i = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				foreach ($arAttributes as $element) {
					if (isset($element[2])) {
						if ($element[2] === "bool") {
							$arRetorno["data"][$i][$element[1]] = (bool)$row[$element[0]];
						} else if ($element[2] === "int") {
							if ($row[$element[0]] !== null) {
								$arRetorno["data"][$i][$element[1]] = intval($row[$element[0]]);
							} else {
								$arRetorno["data"][$i][$element[1]] = null;
							}
						}
					} else {
						$arRetorno["data"][$i][$element[1]] = $row[$element[0]];
					}
				}

				$i++;
			}
		} else {
			$arRetorno["status"]["codError"]    = "001"; // Sin datos.
			$arRetorno["status"]["strSQL"]      = $strSQL;
		}
	} else {
		$arRetorno["status"]["codError"]        = "002"; // Error Query.
		$arRetorno["status"]["strSQL"]          = $strSQL;
	}

	mod001_desconectoBD($link);

	return $arRetorno;
}

function mod002_writeQuery($strSQL, $messagesReturn = null)
{
	if ($messagesReturn === null) {
		$messagesReturn = [
			"000"   => "Inserción/actualización correctamente realizada.",
			"001"   => "Inserción/actualización no ha producido cambios.",
			"002"   => "Error grave en la inserción/actualización."
		];
	}
	$link = mod001_conectoBD();
	if ($result = $link->query($strSQL)) {
		if ($link->affected_rows > 0) {
			$dataReturn["status"]["codError"] = "000"; // Con datos.
			$dataReturn["status"]["affected_rows"] = $link->affected_rows;
		} else {
			$dataReturn["status"]["codError"]   = "001"; // Sin datos.
			$dataReturn["status"]["strSQL"]     = $strSQL; // Error en la query.
		}
	} else {
		$dataReturn["status"]["codError"]       = "002"; // Error en la query.
		$dataReturn["status"]["strSQL"]         = $strSQL; // Error en la query.
	}

	$dataReturn["status"]["messageError"] = $messagesReturn[$dataReturn["status"]["codError"]];
	mod001_desconectoBD($link);

	return $dataReturn;
}

function mod002_getAllBrands()
{
	$strSQL = "SELECT m.idmarca, m.nommarca, m.idlogo, l.nomlogo
		FROM marcas m
		INNER JOIN logos l 
		ON m.idlogo = l.idlogo";

	$arAttributes = [
		["idmarca",    	"idBrand",	"int"],
		["nommarca",  		"nameBrand"],
		["idlogo",		"idLogo"],
		["nomlogo",   	"nameLogo"]
	];

	return mod002_executeQuery($strSQL, $arAttributes);
}

function mod002_getAllClient()
{
	$strSQL = "SELECT idcliente, nombrecliente, apellidocliente
				FROM clientes";

	$arAttributes = [
		["idcliente",    	"idClient",	"int"],
		["nombrecliente",  		"nameClient"],
		["apellidocliente",		"surnameClient"]

	];

	return mod002_executeQuery($strSQL, $arAttributes);
}

function mod002_getAllOrders()
{
	$strSQL = "SELECT c.idcliente, c.nombrecliente, c.apellidocliente, p.idpedido
				FROM clientes c
				INNER JOIN pedidos p 
				ON c.idcliente = p.idcliente";

	$arAttributes = [
		["idcliente", "idClient", "int"],
		["nombrecliente", "nameClient"],
		["apellidocliente", "surnameClient"],
		["idpedido", "idOrder", "int"]
	];

	return mod002_executeQuery($strSQL, $arAttributes);
}

function mod002_newAccount($uniqUserId, $nameUser, $emailUser, $salt, $hash, $direction, $surname)
{
	$strSQL = "INSERT INTO `clientes` (
			`idcliente`, 
			`uniquserid`,
			`nombrecliente`,
			`email`, 
			`salt`,
			`password`,
			`direccion`,
			`apellidocliente`
		) 
		VALUES ( 
			null, 
			'$uniqUserId',
			'$nameUser', 
			'$emailUser',
			'$salt',
			'$hash',
			'$direction',
			'$surname'
		)";

	return mod002_writeQuery($strSQL, [
		"000" => "Inserción de cuenta exitosa",
		"001" => "La inserción de cuenta no produjo cambios",
		"002" => "Error al insertar la cuenta en la base de datos"
	]);
}

function mod002_login($emailUser, $passwordUser)
{
	// Utilizamos una consulta preparada para evitar la inyección de SQL
	$strSQL = "SELECT * 
                        FROM `clientes` 
                        WHERE `email` = ? 
                        AND `password` = ?";

	$arAttributes = [
		["email", "email"],
		["password", "password"]
	];

	// Pasamos los valores como parámetros para la consulta preparada
	$paramValues = [$emailUser, $passwordUser];

	return mod002_executeQuery($strSQL, $arAttributes, $paramValues);
}

function mod002_getDataUser($emailUser)
{
	$strSQL = "SELECT `uniquserid`, `nombrecliente`, `salt`, `password`
                        FROM `clientes`
                        WHERE `email` = '$emailUser'";

	$arAttributes = [
		["uniquserid", "uniquserid"],
		["nombrecliente", "username"],
		["salt", "salt"],
		["password", "password"]
	];

	return mod002_executeQuery($strSQL, $arAttributes, [$emailUser]);
}

function mod002_getSomeClients($search)
{
	$strSQL = "SELECT `idcliente`, `nombrecliente`, `apellidocliente`
	FROM 	`clientes`
	WHERE 	`nombrecliente` 	LIKE '%$search%' 
	OR 		`apellidocliente`	LIKE '%$search%'";

	$arAttributes = [
		["idcliente",	"idClient",	"int"],
		["nombrecliente",   "nameClient"],
		["apellidocliente",	"surnameClient"]
	];

	return mod002_executeQuery($strSQL, $arAttributes);
}

function mod002_getSomeOrders($search)
{
	// Verificar si el término de búsqueda es un número de pedido
	if (is_numeric($search)) {
		// Si el término de búsqueda es un número, buscar por número de pedido
		$whereCondition = "p.idpedido = '$search'";
	} else {
		// Si el término de búsqueda no es un número, buscar por nombre o apellido del cliente
		$whereCondition = "c.nombrecliente LIKE '%$search%' OR c.apellidocliente LIKE '%$search%'";
	}

	$strSQL = "SELECT p.`idpedido`, p.`idcliente`, c.`nombrecliente`, c.`apellidocliente`
               FROM `pedidos` p
               JOIN `clientes` c ON p.`idcliente` = c.`idcliente`
               WHERE $whereCondition";

	$arAttributes = [
		["idpedido",    "idOrder",    "int"],
		["idcliente",    "idClient",    "int"],
		["nombrecliente",    "nameClient"],
		["apellidocliente",    "surnameClient"]
	];

	return mod002_executeQuery($strSQL, $arAttributes);
}

function mod002_countProductsByBrand()
{
	$strSQL = "SELECT idmarca, COUNT(idproducto) AS total_products
               FROM productos
              
               GROUP BY idmarca";

	$arAttributes = [
		["idmarca", "idBrand", "int"],
		["total_products", "totalProducts", "int"]
	];

	return mod002_executeQuery($strSQL, $arAttributes);
}

function mod002_getProductsPag($initialRegistry, $numRegistryByPage, $idBrand)
{
	$strSQL = "SELECT `idproducto`, `nomproducto`, `precioproducto`, `idmarca`
        FROM `productos`
        WHERE `idmarca` = $idBrand
        LIMIT $numRegistryByPage OFFSET $initialRegistry";

	$arAttributes = [
		["idproducto", "idProduct", "int"],
		["nomproducto", "nameProduct"],
		["precioproducto", "prize"],
		["idmarca", "idBrand", "int"]
	];

	return mod002_executeQuery($strSQL, $arAttributes);
}

function mod002_getDetailBrand($idBrand)
{
	$strSQL = "SELECT p.idproducto, p.nomproducto, p.precioproducto, p.idMarca, c.nomcategoria
                FROM productos p
                JOIN categorias c ON p.idCategoria = c.idCategoria
                WHERE p.idMarca = $idBrand;";

	$arAttributes = [
		["idproducto", "idProduct", "int"],
		["nomproducto", "nameProduct"],
		["precioproducto", "prize"],
		["idMarca", "idBrand", "int"],
		["nomcategoria", "categoryName"]
	];

	// Aquí puedes ejecutar la consulta SQL y procesar los resultados, utilizando $strSQL y $arAttributes según sea necesario

	return mod002_executeQuery($strSQL, $arAttributes);
}

function mod002_getDetailProduct($productoId)
{

	$strSQL = "SELECT p.idproducto, p.nomproducto, p.descripcion, i.nomimagen AS nombre_imagen
        FROM productos p
        LEFT JOIN imagenes i ON p.idproducto = i.idproducto
        WHERE p.idproducto = $productoId";

	$arAttributes = [
		["idproducto", "idProduct", "int"],
		["nomproducto", "nameProduct"],
		["descripcion", "description"],
		["nombre_imagen", "nameImg"]
	];

	return mod002_executeQuery($strSQL, $arAttributes);
}

function mod002_getDetailClient( $clientId)
{
	$strSQL = "SELECT idcliente, nombrecliente, apellidocliente, direccion, email
        FROM clientes
        WHERE idcliente = $clientId";

	$arAttributes = [
		["idcliente", "idClient", "int"],
		["nombrecliente", "nameClient"],
		["apellidocliente", "surnameClient"],
		["direccion", "address"],
		["email", "email"]
	];

	return mod002_executeQuery($strSQL, $arAttributes);
}
