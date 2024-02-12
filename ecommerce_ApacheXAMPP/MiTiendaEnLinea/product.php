<?php
/*
 * Autor: Napoleón Devesa Dalio
 * Asignatura: Comercio electrónico
 * Descripción: Producto
 */
?>

<!DOCTYPE html>
<html>

<head>
    <title>Detalles del Producto</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style>
        body {
            background-color: #ffffff;
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <?php
    // Incluye el archivo de conexión a la base de datos
    include "includes/database.php";

    // Verifica si se ha proporcionado un ID de producto válido
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        // Consulta para obtener los detalles del producto
        $query = "SELECT * FROM productos WHERE id = $product_id";
        $result = mysqli_query($conexion, $query);

        // Comprueba si hay resultados
        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
            // Muestra los detalles del producto
            echo "<h1>" . $product['nombre'] . "</h1>";
            echo "<p>Precio: $" . number_format($product['precio'], 2) . "</p>";
            echo "<p>Descripción: " . $product['descripcion'] . "</p>";

            // Muestra la categoría
            $categoria = ($product['categoria_id'] == 1) ? "Frutos Secos" : "Frutas Congeladas";
            echo "<p>Categoría: " . $categoria . "</p>";

            // Muestra la imagen
            echo "<img src='" . $product['imagen'] . "' alt='" . $product['nombre'] . "' style='max-width: 300px;'>";

            // Agrega el botón Comprar Ahora
            $categoryNumber = ($product['categoria_id'] == 1) ? 1 : 2;
            echo "<form action='category.php' method='get'>";
            echo "<input type='hidden' name='category' value='$categoryNumber'>";
            echo "<input type='submit' value='Comprar Ahora'>";
            echo "</form>";
        } else {
            echo "<p>No se encontraron detalles del producto.</p>";
        }
    } else {
        echo "<p>ID de producto no proporcionado.</p>";
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conexion);
    ?>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mi Tienda UOC</p>
    </footer>
</body>

</html>