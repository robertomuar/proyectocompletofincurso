<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Nueva Cuenta</title>
    <link rel="stylesheet" href="/proyecto1/public/css/form.css">
    <script src="/proyecto1/public/js/newaccount.js"></script>
    <style>
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">
            <img src="/proyecto1/public/media/images/logos/logoempresa.png" alt="Logo de la empresa">
            </div>
            <div class="centered-text">
                <h1>Bienvenido al Slider de Imágenes</h1>
            </div>
        </header>

        <main>
            <form name="newaccount" method="POST" onsubmit="return isValidAccount();" action="/proyecto1/saveNewAccount.php">
                <div>
                    <div style="display: flex; justify-content: space-between;">
                        <div style="width: 48%;">
                            <label for="nombrecliente">Tu nombre</label>
                            <input id="nombrecliente" type="text" name="nombrecliente" placeholder="Escribe tu nombre" maxlength="20" />
                        </div>
                        <div style="width: 48%;">
                            <label for="apellidocliente">Tu apellido</label>
                            <input id="apellidocliente" type="text" name="apellidocliente" placeholder="Escribe tu apellido" />
                        </div>
                    </div>
                </div>
                <div>
                    <label for="email">Tu email</label>
                    <input id="email" type="text" name="email" placeholder="Escribe tu email" />
                </div>
                <div>
                    <label for="calle">Dirección</label>
                    <input id="calle" type="text" name="calle" placeholder="Escribe el nombre de la calle" />
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <div style="width: 48%;">
                        <label for="portal">Portal</label>
                        <input id="portal" type="text" name="portal" placeholder="Escribe el número del portal" />
                    </div>
                    <div style="width: 48%;">
                        <label for="piso">Piso</label>
                        <input id="piso" type="text" name="piso" placeholder="Escribe el número del piso" />
                    </div>
                </div>
                <div>
                    <label for="codigo_postal">Código Postal</label>
                    <input id="codigo_postal" type="text" name="codigo_postal" placeholder="Escribe el código postal" />
                </div>
                <div>
                    <label for="localidad">Localidad</label>
                    <input id="localidad" type="text" name="localidad" placeholder="Escribe la localidad" />
                </div>
                <div>
                    <label for="password">Tu contraseña</label>
                    <input id="password" type="password" name="password" placeholder="Escribe tu contraseña" />
                </div>
                <div>
                    <label for="repeatpassworduser">Repite contraseña</label>
                    <input id="repeatpassworduser" type="password" name="repeatpassworduser" placeholder="Repite tu contraseña" />
                </div>
                <input type="submit" value="Grabar" />
                <a href="/proyecto1/main.php" class="action-link" onclick="return confirm('¿Estás seguro que quieres salir sin guardar los cambios?')">Volver</a>
            </form>
            <div id="validationMessage"></div> <!-- Aquí se mostrará el mensaje de validación -->
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
    </div>
</body>

</html>
