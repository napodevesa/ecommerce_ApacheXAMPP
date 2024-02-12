<?php
/*
 * Autor: Napoleón Devesa Dalio
 * Asignatura: Comercio electrónico
 * Descripción: Carrito de compra
 */
?>

<!DOCTYPE html>
<html>

<head>
    <title>Carrito de Compras</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css"> 
</head>

<body>
    <?php
    // Se incluye el archivo de conexión a la base de datos
    include "includes/database.php";

    session_start();

    if (isset($_POST['agregar_al_carrito'])) {
        // Obtener el ID del producto que se agrega al carrito
        $product_id = $_POST['product_id'];

        // Comprobar si existe un carrito en la sesión o lo crea
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }

        // Agregar el producto al carrito
        if (!in_array($product_id, $_SESSION['carrito'])) {
            array_push($_SESSION['carrito'], $product_id);
        }
    }

    // Si se desea eliminar un producto del carrito
    if (isset($_GET['eliminar'])) {
        $product_id = $_GET['eliminar'];
        $key = array_search($product_id, $_SESSION['carrito']);
        if ($key !== false) {
            unset($_SESSION['carrito'][$key]);
        }
    }
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
        <section class="cart">
            <h2>Carrito de Compras</h2>
            <ul>
                <?php
                $total = 0;
                // Si el carrito está vacío
                if (empty($_SESSION['carrito'])) {
                    echo "<p>El carrito está vacío. Puedes agregar productos desde las páginas de categoría.</p>";
                } else {
                    foreach ($_SESSION['carrito'] as $product_id) {
                        // Realiza una consulta para obtener la información del producto
                        $query = "SELECT nombre, descripcion, precio, imagen FROM productos WHERE id = $product_id";
                        $result = mysqli_query($conexion, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<li class='product'>";
                            echo "<img src='" . $row['imagen'] . "' alt='" . $row['nombre'] . "' style='max-width: 100px;'>";
                            echo "<p><strong>Nombre:</strong> " . $row['nombre'] . "</p>";
                            echo "<p><strong>Descripción:</strong> " . $row['descripcion'] . "</p>";
                            echo "<p><strong>Precio:</strong> $" . number_format($row['precio'], 2) . "</p>";
                            echo "<a href='cart.php?eliminar=$product_id'>Eliminar del Carrito</a>";
                            echo "</li>";

                            $total += $row['precio']; // Suma el precio al total
                        }
                    }
                }
                ?>
            </ul>

            <?php
            // Muestra el precio total
            echo "<p class='total-price'><strong>Total del Carrito:</strong> $" . number_format($total, 2) . "</p>";
            ?>
            <!-- Mostrar el formulario solo si el carrito no está vacío -->
            <?php if (!empty($_SESSION['carrito'])) : ?>
                <form method="post" action="register.php">
                    <input type="submit" name="comprar" value="Registrate y Compra">
                </form>
            <?php endif; ?>


            <form method="post" action="">
                <input type="submit" name="comprar" value="Comprar como invitado">
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mi Tienda UOC</p>
    </footer>
</body>