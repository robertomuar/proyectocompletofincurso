<?php
session_start();
require "../model/mod004_presentacion.php";


$dataRequest = trim(file_get_contents("php://input"));
$arDataRequest = json_decode($dataRequest, true);

switch ($arDataRequest["action"]) {
    case "getAllBrands":
        $detailBrand = mod003_getAllBrands();
        echo json_encode($detailBrand);
        break;
    case "getAllClient":
        $detailClient = mod003_getAllClient();
        echo json_encode($detailClient);
        break;
    case "getAllOrder":
        $detailOrder = mod003_getAllOrders();
        echo json_encode($detailOrder);
        break;
    case "setSearch":
        if (isset($arDataRequest["search"])) {
            $search = $arDataRequest["search"];
            $dataSearch = mod003_search($search);
            echo json_encode($dataSearch);
        } else {
            echo json_encode(false);
        }
        break;
        case "getDetailProduct":
            if(isset($arDataRequest['idProduct'], $arDataRequest['nomproducto'], $arDataRequest['nameImg'], $arDataRequest['description'])) {
                $productoId = $arDataRequest['idProduct'];
                $nombreProducto = $arDataRequest['nomproducto'];
                $nameImg = $arDataRequest['nameImg'];
                $descripcion = $arDataRequest['description'];
                $result = mod004_getDetailProduct($productoId);
                echo json_encode($result);
            } else {
                echo json_encode(["error" => "Variables indefinidas en la solicitud"]);
            }
            break;
        case "getDetailClient":
            if (isset($arDataRequest['idClient'])) {
                $clientId = $arDataRequest['idClient'];
                $clientDetails = mod003_getDetailClient( $clientId); 
                echo json_encode($clientDetails);
            } else {
                echo json_encode(["error" => "No se proporcionó el ID del cliente"]);
            }
            break;
        
        
}
