<?php
/*
 * Autor: Napoleón Devesa Dalio
 * Asignatura: Comercio electrónico
 * Descripción: Categorías
 */
?>

<!DOCTYPE html>
<html>

<head>
    <title>Categoría de Productos</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css"> 
</head>

<body>
    <?php
    // Incluye el archivo de conexión a la base de datos
    include "includes/database.php";

    session_start();

    if (isset($_POST['agregar_al_carrito'])) {
        // Obtener el ID del producto que se agregará al carrito
        $product_id = $_POST['product_id'];

        // Comprobar si existe un carrito en la sesión o lo crea
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }

        // Agrega el producto al carrito
        if (!in_array($product_id, $_SESSION['carrito'])) {
            array_push($_SESSION['carrito'], $product_id);
        }
    }

    // Define la categoría por defecto (Frutos Secos)
    $categoria_id = 1;

    // Comprueba si se ha seleccionado una categoría
    if (isset($_GET['category']) && ($_GET['category'] == 2)) {
        $categoria_id = 2; // Cambia a la categoría de Frutas Congeladas si se ha seleccionado
    }

    // Realiza una consulta para obtener los productos de la categoría seleccionada
    $query = "SELECT id, nombre, descripcion, precio, imagen FROM productos WHERE categoria_id = $categoria_id";

    // Ejecuta la consulta
    $result = mysqli_query($conexion, $query);
    ?>

    <header>
        <img src="images/logo.png" alt="Logo de la Tienda" style="width: 200px;">
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="category.php?category=1">Frutos Secos</a></li>
                <li><a href="category.php?category=2">Frutas Congeladas</a></li>
                <li><a href="cart.php">Carrito de Compras</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="category">
            <h2><?php echo ($categoria_id == 1) ? "Frutos Secos" : "Frutas Congeladas"; ?></h2>
            <ul>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li class='product'>";
                        echo "<img src='" . $row['imagen'] . "' alt='" . $row['nombre'] . "' style='width: 150px;'>";
                        echo "<p><strong>Nombre:</strong> " . $row['nombre'] . "</p>";
                        echo "<p><strong>Descripción:</strong> " . $row['descripcion'] . "</p>";
                        echo "<p><strong>Precio:</strong> $" . number_format($row['precio'], 2) . "</p>";
                        echo "<form action='category.php' method='post'>";
                        echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                        echo "<input type='submit' name='agregar_al_carrito' value='Agregar al Carrito'>";
                        echo "</form>";
                        echo "</li>";
                    }
                } else {
                    echo "<p>No se encontraron productos en esta categoría.</p>";
                }
                ?>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mi Tienda UOC</p>
    </footer>
</body>

</html>