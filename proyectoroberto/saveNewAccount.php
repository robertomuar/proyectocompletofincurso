<?php

require "app/model/mod003_logica.php";

if (isset($_POST["nombrecliente"], $_POST["email"], $_POST["password"])) {
    $nameUser = $_POST["nombrecliente"];
    $emailUser = $_POST["email"];
    $passwordUser = $_POST["password"];
    $calle = isset($_POST["calle"]) ? $_POST["calle"] : "";
    $avenida = isset($_POST["avenida"]) ? $_POST["avenida"] : "";
    $portal = isset($_POST["portal"]) ? $_POST["portal"] : "";
    $piso = isset($_POST["piso"]) ? $_POST["piso"] : "";
    $codigo_postal = isset($_POST["codigo_postal"]) ? $_POST["codigo_postal"] : "";
    $localidad = isset($_POST["localidad"]) ? $_POST["localidad"] : "";
    $direction = "$calle, $avenida, $portal, $piso, $codigo_postal, $localidad";
    $surname = isset($_POST["apellidocliente"]) ? $_POST["apellidocliente"] : "";
    $insertResult = mod003_newAccount($nameUser, $emailUser, $passwordUser, $direction, $surname);

    if ($insertResult && isset($insertResult['error'])) {
        $message = "Error al insertar el registro: " . $insertResult['error'];
    } else {
        $message = "Registro insertado correctamente";
    }
} else {
    $message = "Algo va mal";
}

require "public/vista/vista_saveNewAccount.php";
