<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit Fusion Wear - Menú Administradores</title>
    <link rel="stylesheet" href="css/verInventario.css">
</head>
<body>
    <header>
        <h1>Fit Fusion Wear</h1>
    </header>
    <?php require('menuAdmin.html'); ?>

    <!-- Sección Ver Stock -->
    <div id="ver-stock" class="seccion">
        <div class="form-table-style">
            <h2>Inventario</h2>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio Venta</th>
                        <th>Categoría</th>
                        <th>Color</th>
                        <th>Talla</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Conexión a la base de datos
                    $servername = "127.0.0.1";
                    $username = "root"; // Cambia según tu configuración
                    $password = ""; // Cambia según tu configuración
                    $dbname = "ropadeportiva";

                    // Crea la conexión
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Verifica la conexión
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    // Consulta para mostrar productos ordenados por categoría y código
                    $productos_query = "SELECT codigo, nombre, descripcion, precio, categoria, color, talla, stock
                                        FROM productos
                                        ORDER BY categoria ASC, codigo ASC";  // Ordena por categoría y luego por código
                    $result = $conn->query($productos_query);

                    // Verificar si hay resultados
                    if ($result->num_rows > 0) {
                        // Mostrar los productos en las filas de la tabla
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['codigo']}</td>
                                    <td>{$row['nombre']}</td>
                                    <td>{$row['descripcion']}</td>
                                    <td>{$row['precio']}</td>  <!-- Solo precio de venta -->
                                    <td>{$row['categoria']}</td>
                                    <td>{$row['color']}</td>
                                    <td>{$row['talla']}</td>
                                    <td>{$row['stock']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No hay productos registrados aún.</td></tr>";
                    }

                    // Cierra la conexión
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
