<?php
require "mod003_logica.php";

function mod004_getProductsPag($currentPage, $numRegistryByPage, $idBrand)
{
	$arDetailProducts = mod002_getDetailBrand($idBrand);
	$startIndex = ($currentPage - 1) * $numRegistryByPage;
	$listProducts = "";

	if ($arDetailProducts["status"]["codError"] === "000") {
		$listProducts .= "<table class='product-table' border='1'><thead><tr><th>Nombre Producto</th><th>Precio</th><th>Categoria</th></tr></thead><tbody>";

		foreach (array_slice($arDetailProducts["data"], $startIndex, $numRegistryByPage) as $product) {
			$listProducts .= "<tr>";
			$listProducts .= "<td class='product'><a data-idproduct={$product["idProduct"]}>{$product["nameProduct"]}</a></td>";
			$listProducts .= "<td class='product'>{$product["prize"]}€</td>";
			$listProducts .= "<td class='product'>{$product["categoryName"]}</td>";
			$listProducts .= "</tr>";
		}
		$listProducts .= "</tbody></table>";
	} else {
		$listProducts = "<p>No hay productos asociados a esta marca en este momento.</p>";
	}

	return $listProducts;
}

function mod004_setLayerPagination($currentPage, $numRegistryByPage, $totalPages, $idBrand)
{
	$layerPag = "";
	$maxVisiblePages = 3;
	$startPage = max(1, min($currentPage - floor($maxVisiblePages / 2), $totalPages - $maxVisiblePages + 1));
	$endPage = min($startPage + $maxVisiblePages - 1, $totalPages);

	$layerPag .= "<div class='pagination'>";
	if ($currentPage > 1) {
		$layerPag .= "<a href='detailBrand.php?idbrand={$idBrand}&currentPage=1' title='Ir a la primera página' class='pagination-link'>&lt;&lt;</a>";
	} else {
		$layerPag .= "<a href='javascript:void(0)' title='Ir a la primera página' class='pagination-link hidden-button'>&lt;&lt;</a>";
	}
	if ($currentPage > 1) {
		$prevPage = $currentPage - 1;
		$layerPag .= "<a href='detailBrand.php?idbrand={$idBrand}&currentPage={$prevPage}' title='Ir a la anterior página' class='pagination-link'>&lt;</a>";
	} else {
		$layerPag .= "<a href='javascript:void(0)' title='Ir a la anterior página' class='pagination-link hidden-button'>&lt;</a>";
	}

	if ($startPage > 1) {
		$layerPag .= "<span class='pagination-ellipsis visible-ellipsis'>...</span>";
	} else {
		$layerPag .= "<span class='pagination-ellipsis hidden-ellipsis'>...</span>";
	}

	for ($i = $startPage; $i <= $endPage; $i++) {
		$class = ($currentPage == $i) ? 'active' : '';
		if ($currentPage == $i) {
			$layerPag .= "<span class='pagination-link {$class}'>{$i}</span>";
		} else {
			$layerPag .= "<a href='detailBrand.php?idbrand={$idBrand}&currentPage={$i}' class='pagination-link {$class}'>{$i}</a>";
		}
	}

	if ($endPage < $totalPages) {
		$layerPag .= "<span class='pagination-ellipsis visible-ellipsis'>...</span>";
	} else {
		$layerPag .= "<span class='pagination-ellipsis hidden-ellipsis'>...</span>";
	}

	if ($currentPage < $totalPages) {
		$nextPage = $currentPage + 1;
		$layerPag .= "<a href='detailBrand.php?idbrand={$idBrand}&currentPage={$nextPage}' title='Ir a la siguiente página' class='pagination-link'>&gt;</a>";
	} else {
		$layerPag .= "<a href='javascript:void(0)' title='Ir a la siguiente página' class='pagination-link hidden-button'>&gt;</a>";
	}

	if ($currentPage < $totalPages) {
		$layerPag .= "<a href='detailBrand.php?idbrand={$idBrand}&currentPage={$totalPages}' title='Ir a la última página' class='pagination-link'>&gt;&gt;</a>";
	} else {
		$layerPag .= "<a href='javascript:void(0)' title='Ir a la última página' class='pagination-link hidden-button'>&gt;&gt;</a>";
	}

	$layerPag .= "</div>";

	return $layerPag;
}

function mod004_getDetailProduct($productoId)
{
	$arDataProduct = mod003_getDetailProduct($productoId);


	if ($arDataProduct["status"]["codError"] === "000") {

		$listProduct = "<h1>{$arDataProduct["data"][0]["nameProduct"]}</h1>";
		$listProduct .= "<p>{$arDataProduct["data"][0]["description"]}</p>";
		$listProduct .= "<div class='product-images'>";

		foreach ($arDataProduct["data"] as $product) {
			$listProduct .= "<div class='image-container-inline'>";
			$listProduct .= "<img src='public/media/images/{$product["nameImg"]}' alt='{$product["nameProduct"]}'>";
			$listProduct .= "</div>";
		}
		$listProduct .= "</div>";
		return $listProduct;
	} else {
		return "<p>No se pudieron obtener los detalles del producto.</p>";
	}
}

function mod004_getDetailClient($clientId)
{
    $arDetailPerClient = mod003_getDetailClient($clientId);

    if ($arDetailPerClient) {
      
        if (isset($arDetailPerClient["status"]["codError"]) && $arDetailPerClient["status"]["codError"] === "000") {

            $listClient = "<h1>{$arDetailPerClient["data"][0]["nameClient"]}</h1>";
            $listClient .= "<p>{$arDetailPerClient["data"][0]["surnameClient"]}</p>";
            $listClient .= "<p>{$arDetailPerClient["data"][0]["address"]}</p>";
            $listClient .= "<p>{$arDetailPerClient["data"][0]["email"]}</p>";
            $listClient .= "</div>";
            return $listClient;
        } else {

            return "Error: No se pudieron obtener los detalles del cliente.";
        }
    } else {

        return "Error: No se encontraron detalles para el cliente con el ID proporcionado.";
    }
}
