<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit Fusion Wear - Menú clientes</title>
    <link rel="stylesheet" href="css/inicioUsuario.css">
</head>
<body>
    <header>
        <h1>Fit Fusion Wear</h1>
    </header>

    <!-- Menú de usuario -->
    <?php include('menuUsuario.html'); ?>

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

    // Categorías de productos
    $categorias = ['shorts', 'tops', 'leggins', 'conjuntos', 'enterizos'];

    foreach ($categorias as $categoria) {
        // Consulta SQL para obtener los productos de cada categoría
        $sql = "SELECT * FROM productos WHERE categoria = '$categoria'";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            echo "<section class='product-category'>";

            echo "<div class='product-grid'>";

            // Contador de productos
            $counter = 0;

            while ($product = $result->fetch_assoc()) {
                // Obtener datos del producto
                $codigo = $product['codigo'];
                $nombre = $product['nombre'];
                $color = $product['color'];
                $descripcion = $product['descripcion'];
                $talla = $product['talla'];
                $precio = $product['precio'];
                $stock = $product['stock']; // Obtener el stock

                // Ruta de la imagen según la categoría
                $imagenPath = "img/" . $categoria . "/" . $codigo . ".jpeg";

                // Verificar si el stock es 0 para deshabilitar el botón
                $disabled = ($stock == 0) ? 'disabled' : '';

                // Generar el HTML del producto
                echo "<div class='product-item'>
                        <img src='$imagenPath' alt='Imagen de $nombre'>
                        <h3>$nombre</h3>
                        <p>
                            <b>Código: </b>$codigo<br>
                            <b>Colores: </b>$color<br>
                            <b>Descripción: </b>$descripcion<br>
                            <b>Talla: </b>$talla<br>
                            <b>Precio: </b>$$precio<br>
                            <b>Stock: </b>$stock<br>
                        </p>
                        <form action='agregarCarrito.php' method='POST'>
                            <input type='hidden' name='codigo' value='$codigo'>
                            <button type='submit' class='add-to-cart-btn' $disabled>Agregar al carrito</button>
                        </form>
                    </div>";

                // Incrementar el contador
                $counter++;

                // Crear una nueva sección después de cada 4 productos
                if ($counter % 4 === 0) {
                    echo "</div><div class='product-grid'>"; // Cerrar la sección actual y abrir una nueva
                }
            }

            echo "</div>"; // Cerrar la grid de productos
            echo "</section>"; // Cerrar la categoría
        } else {
            echo "<p>No hay productos disponibles en la categoría '$categoria'.</p>";
        }
    }

    // Cerrar la conexión
    $conexion->close();
    ?>
</body>
</html>
