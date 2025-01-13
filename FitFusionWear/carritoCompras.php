<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$server = "localhost";
$user = "root";
$pass = "";
$db = "ropadeportiva";

// Conectar a la base de datos
$conexion = new mysqli($server, $user, $pass, $db);
if ($conexion->connect_errno) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$user_id = $_SESSION['user_id'];

// Consulta para obtener los productos en el carrito
$sql = "SELECT c.cantidad, p.nombre, p.precio, p.codigo, p.categoria, p.stock 
        FROM carrito c 
        JOIN productos p ON c.producto_codigo = p.codigo 
        WHERE c.cliente_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="css/carritoCompras.css">
</head>
<body>
    <header>
        <h1>Fit Fusion Wear</h1>
    </header>

    <?php include('menuUsuario.html'); ?>

    <div class="carrito-container">
        <div class="productos">
            <h2>Carrito de Compras</h2>

            <?php if (isset($_SESSION['mensaje_confirmacion'])): ?>
                <div class="mensaje_confirmacion"><?= $_SESSION['mensaje_confirmacion'] ?></div>
                <?php unset($_SESSION['mensaje_confirmacion']); ?>
            <?php endif; ?>

            <?php
            $total = 0;
            while ($producto = $result->fetch_assoc()) {
                $codigo = $producto['codigo'];
                $nombre = $producto['nombre'];
                $precio = $producto['precio'];
                $cantidad = $producto['cantidad'];
                $categoria = $producto['categoria'];
                $stock = $producto['stock'];
                $subtotal = $precio * $cantidad;
                $total += $subtotal;

                // Ruta de la imagen
                $imagenPath = "img/$categoria/" . $codigo . ".jpeg";

                // Mostrar el producto con los botones de cantidad
                echo "<div class='producto'>
                        <img src='$imagenPath' alt='Imagen de $nombre'>
                        <div class='detalle'>
                            <p>$nombre</p>
                            <p>Código: #$codigo</p>
                            <p class='precio'>$$precio</p>
                        </div>
                        <div class='cantidad'>
                            <form action='actualizarCarrito.php' method='POST'>
                                <input type='hidden' name='codigo' value='$codigo'>
                                <input type='hidden' name='cantidad' value='$cantidad'>
                                <input type='hidden' name='precio' value='$precio'>
                                <input type='hidden' name='stock' value='$stock'>
                                
                                <!-- Botón Restar -->
                                <button type='submit' name='accion' value='restar'>-</button>
                                
                                <p>Cantidad: $cantidad</p>
                                
                                <!-- Botón Sumar -->
                                <button type='submit' name='accion' value='sumar'>+</button>
                            </form>
                        </div>
                    </div>";
            }
            ?>

        </div>

        <div class="detalles-pedido">
            <h2>Detalles del Pedido</h2>
            <p>Subtotal: $<?php echo number_format($total, 2); ?></p>
            
            <!-- Formulario para seleccionar la entrega y forma de pago -->
            <form action="procesar_pedido.php" method="POST">
                <label for="entrega">Forma de entrega:</label>
                <select id="entrega" name="entrega">
                    <option value="domicilio">Entrega a domicilio</option>
                    <option value="punto-entrega">Colonia la Roma</option>
                    <option value="punto-entrega">Colonia MIguel Hidalgo</option>
                    <option value="punto-entrega">Calle Paseo del Mar (San Patricio)</option>
                    <option value="punto-entrega">Tec Saltillo</option>
                </select>

                <label for="pago">Forma de pago:</label>
                <select id="pago" name="pago">
                    <option value="efectivo">Efectivo</option>
                    <option value="transferencia">Transferencia</option>
                </select>

                <label for="fecha">Fecha de entrega:</label>
                <input type="date" id="fecha" name="fecha">
                
                <div class="datos-transferencia">
                    <p>Datos para la transferencia:</p>
                    <p>Banco: BBVA</p>
                    <p>Cuenta: 4152 3143 6155 4234</p>
                    <p>Nombre: Alejandra Andrade</p>
                </div>
                
                <button type="submit" class="confirmar">Confirmar Pedido</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php $conexion->close(); ?>
