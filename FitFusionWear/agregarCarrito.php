<?php
session_start();

$server = "localhost";
$user = "root";
$pass = "";
$db = "ropadeportiva";

// Conexión a la base de datos
$conexion = new mysqli($server, $user, $pass, $db);

if ($conexion->connect_errno) {
    die("Conexión fallida: " . $conexion->connect_errno);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del producto
    $codigo = $_POST['codigo'];
    $cantidad = 1; // Cantidad por defecto es 1
    $cliente_id = $_SESSION['user_id']; // Supongamos que tienes la sesión del cliente

    // Consultar el stock disponible
    $stock_query = "SELECT stock FROM productos WHERE codigo = ?";
    $stmt_stock = $conexion->prepare($stock_query);
    $stmt_stock->bind_param("s", $codigo);
    $stmt_stock->execute();
    $result_stock = $stmt_stock->get_result();

    if ($result_stock->num_rows > 0) {
        $product = $result_stock->fetch_assoc();
        $stock = $product['stock'];

        if ($stock > 0) {
            // Verificar si el producto ya está en el carrito del cliente
            $check_query = "SELECT * FROM carrito WHERE cliente_id = ? AND producto_codigo = ?";
            $stmt = $conexion->prepare($check_query);
            $stmt->bind_param("is", $cliente_id, $codigo);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Si el producto ya está en el carrito, incrementa la cantidad en 1
                $update_query = "UPDATE carrito SET cantidad = cantidad + 1 WHERE cliente_id = ? AND producto_codigo = ?";
                $update_stmt = $conexion->prepare($update_query);
                $update_stmt->bind_param("is", $cliente_id, $codigo);
                $update_stmt->execute();
            } else {
                // Si no está en el carrito, insertar el producto con cantidad 1
                $insert_query = "INSERT INTO carrito (cliente_id, producto_codigo, cantidad) VALUES (?, ?, ?)";
                $insert_stmt = $conexion->prepare($insert_query);
                $insert_stmt->bind_param("isi", $cliente_id, $codigo, $cantidad);
                $insert_stmt->execute();
            }

            // Disminuir el stock del producto en la tabla productos
            $new_stock = $stock - 1;
            $update_stock_query = "UPDATE productos SET stock = ? WHERE codigo = ?";
            $update_stock_stmt = $conexion->prepare($update_stock_query);
            $update_stock_stmt->bind_param("is", $new_stock, $codigo);
            $update_stock_stmt->execute();

            // Redirigir de vuelta al carrito o al catálogo
            header("Location: carritoCompras.php");
        } else {
            // Si no hay stock disponible, redirigir con un mensaje
            echo "<p>Lo siento, no hay suficiente stock disponible.</p>";
        }
    } else {
        // Si no se encuentra el producto
        echo "<p>Producto no encontrado.</p>";
    }
}

$conexion->close();
?>
