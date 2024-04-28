<?php
// login.php

session_start();

require_once "app/model/mod003_logica.php";

if(isset($_POST['email'],$_POST['password'])) {
    echo('Hola 1');
    $email = $_POST['email'];
    $password = $_POST['password'];
    $loginResult = mod003_login($email, $password);
    if ($loginResult === true) {
        echo('Hola 2');
        Header("location:main1.php");
    } else {
        Header("location:main.php");
    }
} else {
    Header("location:main.php");
}
