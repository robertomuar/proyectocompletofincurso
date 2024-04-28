<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RapidHardware</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <script src="public/js/script.js"></script>
    <script src="public/js/overlay.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="public/media/images/logos/logoempresa.png" alt="Logo de la empresa">
        </div>
        <div class="centered-text">
            <h1>RapidHardware</h1>
        </div>
        <nav>
            <ul>
                <li><a href='#' onclick='openLoginOverlay()'>Iniciar Sesión</a></li>
                <li><a href='public/vista/vista_formNewAccount.php'>Crear Usuario</a></li>
            </ul>
        </nav>
    </header>

    <div class="overlay" id="loginOverlay">
    <div class="overlay-content">
        <h2>Iniciar Sesión</h2>
        <p id="loginError" style="display: none; color: red;"></p>
            <form action="login.php" method="POST" id="loginForm">
                <div>
                    <label for="email">Correo electrónico:</label>
                    <input id="email" name="email">
                </div>
                <div>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password">
                </div>
                <button type="submit">Iniciar Sesión</button>
                <button onclick="closeLoginOverlay()">Cerrar</button>
            </form>
        </div>
    </div>

    <div class="slider-container">
        <div class="slider">
            <div class="slide">
                <img src="public/media/images/imagenesmain/imagen1.jpg" alt="Imagen 1" class="custom-slide-img">
                <div class="slide-text">
                    <h2>Tecnología</h2>
                    <p>Nuestros Racks más modernos son tecnología punta<br>
                            tecnología punta con mas mil clientes que estan <br>
                            más que satisfechos por la calidad y rapidez.</p>
                </div>
            </div>
            <div class="slide">
                <img src="public/media/images/imagenesmain/imagen2.jpg" alt="Imagen 2" class="custom-slide-img">
                <div class="slide-text">
                    <h2>Rapidez</h2>
                    <p>Nuestros Racks más modernos son tecnología punta<br>
                            tecnología punta con mas mil clientes que estan <br>
                            más que satisfechos por la calidad y rapidez.</p>
                </div>
            </div>
            <div class="slide">
                <img src="public/media/images/imagenesmain/imagen3.jpg" alt="Imagen 3" class="custom-slide-img">
                <div class="slide-text">
                    <h2>Productividad</h2>
                    <div>
                        <p>Nuestros Racks más modernos son tecnología punta<br>
                            tecnología punta con mas mil clientes que estan <br>
                            más que satisfechos por la calidad y rapidez.</p>
                    </div>
                </div>

            </div>
            <div class="slide">
                <img src="public/media/images/imagenesmain/imagen4.jpg" alt="Imagen 4" class="custom-slide-img">
                <div class="slide-text">
                    <h2>Calidad</h2>
                    <p>Nuestros Racks más modernos son tecnología punta<br>
                            tecnología punta con mas mil clientes que estan <br>
                            más que satisfechos por la calidad y rapidez.</p>
                </div>
            </div>
        </div>
    </div>

    <button class="prev">&#10094;</button>
    <button class="next">&#10095;</button>

</body>
<footer>
    <div class="info-text">
        <p>&copy; 2024 RapidHardware. Todos los derechos reservados.</p>
    </div>
    <div class="contact-info">
        <p>Dirección: Calle Ejemplo, Ciudad, País</p>
        <p>Teléfono: 123-456-789</p>
        <p>Correo electrónico: info@RapidHardware.com</p>
    </div>
</footer>
<script>
    function submitLoginForm() {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "login.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.error) {
                    // Si hay un error, muestra el mensaje de error en el overlay
                    document.getElementById("loginError").innerText = response.error;
                    document.getElementById("loginError").style.display = "block";
                } else {
                    // Si el inicio de sesión es exitoso, redirige a main.php
                    window.location.href = "main.php";
                }
            }
        };
        xhr.send("email=" + email + "&password=" + password);
    }
</script>

</html>