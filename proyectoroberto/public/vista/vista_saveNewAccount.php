<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>New Account</title>
    <link rel="stylesheet" href="def_principal.css">
    <link rel="stylesheet" href="/proyecto1/public/css/overlay.css">
    <meta http-equiv="refresh" content="3;url=main.php">
</head>
<body>

<header>
        <div class="logo">
            <img src="public/media/images/logos/logoempresa.png" alt="Logo de la empresa">
        </div>
        <div class="centered-text">
            <h1>RapidHardware</h1>
        </div>
<main>
    <div class='wrapper'>
        <?php
        if(isset($message)) {
            if ($message === "Registro insertado correctamente") {
                echo "<p>¡Registro insertado correctamente!</p>";
            } else {
                echo "<p>$message</p>";
            }
        }
        ?>
    </div>
    <div>
        <p><?php echo $message; ?></p>
        <p>Redireccionando a main.php en 3 segundos...</p>
    </div>
</main>
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
