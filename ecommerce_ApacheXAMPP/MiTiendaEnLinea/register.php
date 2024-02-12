<?php
/*
 * Autor: Napoleón Devesa Dalio
 * Asignatura: Comercio electrónico
 * Descripción: Registro
 */
?>

<?php
// Incluye el archivo de conexión a la base de datos
include "includes/database.php";

session_start();

// Verificar si se ha enviado el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['registro'])) {
        // Recoge los datos del formulario de registro
        $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($conexion, $_POST['nombre']) : '';
        $email = isset($_POST['email']) ? mysqli_real_escape_string($conexion, $_POST['email']) : '';
        $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
        $direccion = isset($_POST['direccion']) ? mysqli_real_escape_string($conexion, $_POST['direccion']) : '';

        // Crear una sentencia preparada
        $stmt = mysqli_prepare($conexion, "INSERT INTO usuarios (nombre, email, password, direccion) VALUES (?, ?, ?, ?)");

        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "ssss", $nombre, $email, $password, $direccion);

        // Ejecutar la sentencia
        mysqli_stmt_execute($stmt);

        // Cerrar la sentencia
        mysqli_stmt_close($stmt);

        // Después del registro, se redirige al usuario a la página de compra
        header("Location: cart.php");
        exit();
    } elseif (isset($_POST['continuar_como_invitado'])) {
        // Después de continuar como invitado, redirige al usuario a la página de compra
        header("Location: cart.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registro</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
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
        <section class="registration-form">
            <h2>Registro</h2>
            <form method="post" action="">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>

                <label for="email">Email:</label>
                <input type="email" name="email" required>

                <label for="password">Contraseña:</label>
                <input type="password" name="password" required>

                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" required>

                <input type="submit" name="registro" value="Registrarse">
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mi Tienda UOC</p>
    </footer>
</body>

</html>