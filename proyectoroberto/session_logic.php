<?php
session_start(); 

if (isset($_SESSION["nombrecliente"])) {

    $nameUser = $_SESSION["nombrecliente"];
} else {
    $nameUser = null;
}
?>
