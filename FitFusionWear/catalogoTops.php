<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit Fusion Wear - Menú clientes</title>
    <link rel="stylesheet" href="css/catalogo.css">
</head>
<body>
    <header>
        <h1>Fit Fusion Wear</h1>
    </header>

    <!-- Menú de usuario -->
    <?php include('menuUsuario.html'); ?>

    <!-- Sección de productos de la categoría "shorts" -->
    <div class="product-grid-container">
        <?php
        $server = "localhost";
        $user = "root";
        $pass = "";
        $db = "ropadeportiva";

        // Conexión a la base de datos
        $conexion = new mysqli($server, $user, $pass, $db);

        if ($conexion->connect_errno) {
            die("Conexión fallida: " . $conexion->connect_errno);
        }

        // Consulta SQL para obtener los productos de la categoría "shorts"
        $sql = "SELECT * FROM productos WHERE categoria = 'tops'";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            $counter = 0; // Contador de productos

            // Abrir la primera sección fuera del bucle
            echo "<section class='product-grid'>";

            while ($product = $result->fetch_assoc()) {
                // Obtener datos del producto
                $codigo = $product['codigo'];
                $nombre = $product['nombre'];
                $color = $product['color'];
                $descripcion = $product['descripcion'];
                $talla = $product['talla'];
                $precio = $product['precio'];
                $stock = $product['stock']; // Obtener el stock

                // Ruta de la imagen
                $imagenPath = "img/tops/" . $codigo . ".jpeg";

                // Verificar si el stock es 0 para deshabilitar el botón
                $disabled = ($stock == 0) ? 'disabled' : ''; // Si el stock es 0, deshabilitar el botón

                // Generar el HTML del producto
                echo "<div class='product-item'>
                        <img src='$imagenPath' alt='Imagen de $nombre'>
                        <h2>$nombre</h2>
                        <p>
                            <b>Codigo: </b>$codigo<br>
                            <b>Colores: </b>$color<br>
                            <b>Descripcion:</b> $descripcion<br>
                            <b>Talla:</b> $talla<br>
                            <b>Precio:</b> $$precio<br>
                            <b>Stock:</b> $stock<br> <!-- Mostrar el stock -->
                        </p>
                        <form action='agregarCarrito.php' method='POST'>
                            <input type='hidden' name='codigo' value='$codigo'>
                            <button type='submit' class='add-to-cart-btn' $disabled>Agregar al carrito</button>
                        </form>
                    </div>";

                // Incrementar el contador
                $counter++;

                // Abrir una nueva sección después de cada 4 productos
                if ($counter % 4 === 0) {
                    echo "</section>"; // Cerrar la sección anterior
                    echo "<section class='product-grid'>"; // Crear una nueva sección
                }
            }

            echo "</section>"; // Cerrar la última sección
        } else {
            echo "<p>No hay productos disponibles en la categoría 'tops'.</p>";
        }

        // Cerrar la conexión
        $conexion->close();
        ?>
    </div>
</body>
</html>