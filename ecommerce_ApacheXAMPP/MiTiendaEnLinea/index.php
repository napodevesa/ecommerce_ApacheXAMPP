<?php
/*
 * Autor: Napoleón Devesa Dalio
 * Asignatura: Comercio electrónico
 * Descripción: Index
 */
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tu Tienda en Línea</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <?php
    // Incluye el archivo de conexión a la base de datos
    include "includes/database.php";
    ?>

    <header>
        <h1>Mi Tienda UOC</h1>
        <img src="images/logo.png" alt="Logo de la Tienda" style="width: 200px;">
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="category.php?category=1">Frutos Secos</a></li>
                <li><a href="category.php?category=2">Fruta Congelada</a></li>
                <li><a href="cart.php">Carrito de Compras</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="featured-products">
            <h2>Productos Destacados</h2>
            <ul>
                <?php
                // Conectarse a la base de datos
                include "includes/database.php";

                // Consulta que realizamos para obtener los nombres y rutas de las imágenes de los productos
                $query = "SELECT id, nombre, imagen FROM productos LIMIT 5"; // LIMIT de 5 para mostrar solamente 5 productos

                // Ejecutar la consulta definida
                $result = mysqli_query($conexion, $query);

                // Comprueba si hay resultados
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li>";
                        echo "<a href='product.php?product_id=" . $row['id'] . "'>";
                        echo "<img src='" . $row['imagen'] . "' alt='" . $row['nombre'] . "' style='max-width: 170px;'>";
                        echo "<p>" . $row['nombre'] . "</p>";
                        echo "</a>";
                        echo "</li>";
                    }
                } else {
                    echo "<p>No se encontraron productos destacados.</p>";
                }

                // Cerrar la conexión a la base de datos 
                mysqli_close($conexion);
                ?>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mi Tienda UOC</p>
    </footer>
</body>

</html>