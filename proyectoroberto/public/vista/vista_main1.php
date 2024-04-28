<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título de tu página</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <script src="public/js/detailbrand.js"></script>
    <script src="public/js/detailclient.js"></script>
    <script src="public/js/detailorder.js"></script>
    <script src="public/js/search.js"></script>

</head>

<body class="fondo">
    <header>
        <div class="logo">
            <img src="public/media/images/logos/logoempresa.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li id="clientesLink"><a href="#">Clientes</a></li>
                <li id="marcasLink"><a href="#">Marcas</a></li>
                <li><a href="#">Pedidos</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
        <div class="overlay" id="overlay">
            <div class="login-form">
                <h2>Iniciar sesión</h2>
                <input type="text" placeholder="Usuario">
                <input type="password" placeholder="Contraseña">
                <button onclick="closeOverlay()">Cerrar</button>
            </div>
        </div>
        <div class="buscar">
            <input type="text" id="search" placeholder="Buscar...">
            <div class="wrappersearch hiddend"></div>
        </div>
    </header>
    <div id="marcasDropdownContent" class="dropdown-content marcas-dropdown">
    </div>
    <div id="clientesDropdownContent" class="dropdown-content table-container">
    </div>
    <div id="clientDetailsOverlay" class='hiddenD'></div>
    <div id="orderDropdownContent" class="dropdown-content table-container">
    </div>
    <footer>
        <div class="info-text">
            <p>&copy; 2024 Nombre de la Empresa. Todos los derechos reservados.</p>
        </div>
        <div class="contact-info">
            <p>Dirección: Calle Ejemplo, Ciudad, País</p>
            <p>Teléfono: 123-456-789</p>
            <p>Correo electrónico: info@empresa.com</p>
        </div>
    </footer>
</body>

</html>