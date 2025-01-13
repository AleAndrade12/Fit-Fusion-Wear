<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit Fusion Wear - Menú Administradores</title>
    <link rel="stylesheet" href="css/verPedidos.css">
</head>
<body>
    <header>
        <h1>Fit Fusion Wear</h1>
    </header>
    <?php require('menuAdmin.html'); ?>

    <!-- Sección Ver Pedidos -->
    <div id="ver-pedidos" class="seccion">
        <div class="form-table-style">
            <h2>Pedidos</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Lista de Compras</th>
                        <th>Total</th>
                        <th>Entrega</th>
                        <th>Pago</th>
                        <th>Fecha Entrega</th>
                        <th>Acción</th> <!-- Nueva columna -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Conexión a la base de datos
                    $servername = "127.0.0.1";
                    $username = "root";
                    $password = "";
                    $dbname = "ropadeportiva";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    // Consulta para mostrar pedidos
                    $pedidos_query = "SELECT id, nombre_cliente, telefono_cliente, direccion_cliente, lista_compras, total, forma_entrega, forma_pago, fecha_entrega
                                      FROM pedidos
                                      ORDER BY fecha_entrega DESC";
                    $result = $conn->query($pedidos_query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['nombre_cliente']}</td>
                                    <td>{$row['telefono_cliente']}</td>
                                    <td>{$row['direccion_cliente']}</td>
                                    <td>{$row['lista_compras']}</td>
                                    <td>{$row['total']}</td>
                                    <td>{$row['forma_entrega']}</td>
                                    <td>{$row['forma_pago']}</td>
                                    <td>{$row['fecha_entrega']}</td>
                                    <td>
                                        <form method='POST' action='confirmarPedido.php'>
                                            <input type='hidden' name='pedido_id' value='{$row['id']}'>
                                            <button type='submit'>Confirmar</button>
                                        </form>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No hay pedidos registrados aún.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
