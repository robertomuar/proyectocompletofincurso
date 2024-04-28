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
    <link rel="stylesheet" href="public/css/productos.css">
    <script src="public/js/detailProduct.js"></script>

<body>
    <header>
        <div class="logo">
            <a href="main1.php"><img src="public/media/images/logos/logoempresa.png" alt="Logo"></a>
        </div>
        <nav>
            <ul>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>Listado de Productos</h1>
            <form method="GET" action="detailBrand.php">
                <label for="numRecords">Registros por página:</label>
                <select id="numRecords" name="numRecords">
                    <option value="1" <?php if ($numRegistryByPage == 1) echo 'selected'; ?>>1</option>
                    <option value="2" <?php if ($numRegistryByPage == 2) echo 'selected'; ?>>2</option>
                    <option value="3" <?php if ($numRegistryByPage == 3) echo 'selected'; ?>>3</option>
                    <option value="4" <?php if ($numRegistryByPage == 4) echo 'selected'; ?>>4</option>
                </select>
                <input type="hidden" name="idbrand" value="<?php echo $idBrand; ?>">
                <input type="submit" value="Actualizar">
            </form>

            <div class="product-list">
                <?php echo is_array($listProducts) ? implode("", $listProducts) : $listProducts; ?>
            </div>
            <div class="container" id="container">
            </div>
            <div class="pagination-container">
                <?php echo $layerPaginationProduct; ?>
            </div>
        </div>
    </main>
    <footer>
        <p>Pies de página</p>
    </footer>
</body>

</html>