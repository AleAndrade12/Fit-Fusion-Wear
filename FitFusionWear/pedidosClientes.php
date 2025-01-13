<?php
session_start(); // Asegúrate de iniciar la sesión al principio del archivo
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit Fusion Wear - Mis Pedidos</title>
    <link rel="stylesheet" href="css/pedidosClientes.css">
</head>
<body>
    <header>
        <h1>Fit Fusion Wear</h1>
    </header>
    
    <?php require('menuUsuario.html'); ?>

    <!-- Sección Ver Pedidos -->
    <div id="ver-pedidos" class="seccion">
        <div class="form-table-style">
            <h2>Mis Pedidos</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Lista de Compras</th>
                        <th>Total</th>
                        <th>Entrega</th>
                        <th>Pago</th>
                        <th>Fecha Entrega</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Verificar si el usuario ha iniciado sesión
                    if (!isset($_SESSION['user_id'])) {
                        echo "<tr><td colspan='6'>No has iniciado sesión.</td></tr>";
                        exit;
                    }

                    // Conexión a la base de datos
                    $servername = "127.0.0.1";
                    $username = "root";
                    $password = "";
                    $dbname = "ropadeportiva";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    // Consulta para mostrar pedidos del cliente (filtrados por su ID)
                    $cliente_id = $_SESSION['user_id'];
                    $pedidos_query = "SELECT id, lista_compras, total, forma_entrega, forma_pago, fecha_entrega
                                      FROM pedidos
                                      WHERE cliente_id = '$cliente_id'
                                      ORDER BY fecha_entrega DESC";

                    $result = $conn->query($pedidos_query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['lista_compras']}</td>
                                    <td>{$row['total']}</td>
                                    <td>{$row['forma_entrega']}</td>
                                    <td>{$row['forma_pago']}</td>
                                    <td>{$row['fecha_entrega']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No tienes pedidos registrados aún.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
