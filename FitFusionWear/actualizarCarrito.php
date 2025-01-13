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
$codigo = $_POST['codigo'];
$accion = $_POST['accion'];
$cantidad = $_POST['cantidad'];
$stock = $_POST['stock'];
$precio = $_POST['precio'];

// Determinar si se debe aumentar o disminuir la cantidad
if ($accion == 'sumar') {
    if ($stock > $cantidad) {
        // Actualizar la cantidad en el carrito
        $cantidad++;
        $update_query = "UPDATE carrito SET cantidad = ? WHERE cliente_id = ? AND producto_codigo = ?";
        $stmt = $conexion->prepare($update_query);
        $stmt->bind_param("iis", $cantidad, $user_id, $codigo);
        $stmt->execute();
        
        // Reducir el stock en productos
        $new_stock = $stock - 1;
        $update_stock_query = "UPDATE productos SET stock = ? WHERE codigo = ?";
        $update_stock_stmt = $conexion->prepare($update_stock_query);
        $update_stock_stmt->bind_param("is", $new_stock, $codigo);
        $update_stock_stmt->execute();
    } else {
        // No hay suficiente stock
        echo "No hay suficiente stock para aumentar la cantidad.";
    }
} elseif ($accion == 'restar' && $cantidad > 1) {
    // Si la cantidad es mayor a 1, restar la cantidad
    $cantidad--;
    $update_query = "UPDATE carrito SET cantidad = ? WHERE cliente_id = ? AND producto_codigo = ?";
    $stmt = $conexion->prepare($update_query);
    $stmt->bind_param("iis", $cantidad, $user_id, $codigo);
    $stmt->execute();
    
    // Aumentar el stock en productos
    $new_stock = $stock + 1;
    $update_stock_query = "UPDATE productos SET stock = ? WHERE codigo = ?";
    $update_stock_stmt = $conexion->prepare($update_stock_query);
    $update_stock_stmt->bind_param("is", $new_stock, $codigo);
    $update_stock_stmt->execute();
} elseif ($accion == 'restar' && $cantidad == 1) {
    // Si la cantidad llega a 0, eliminar el producto del carrito
    $delete_query = "DELETE FROM carrito WHERE cliente_id = ? AND producto_codigo = ?";
    $stmt = $conexion->prepare($delete_query);
    $stmt->bind_param("is", $user_id, $codigo);
    $stmt->execute();
    
    // Devolver el producto al stock
    $new_stock = $stock + 1;
    $update_stock_query = "UPDATE productos SET stock = ? WHERE codigo = ?";
    $update_stock_stmt = $conexion->prepare($update_stock_query);
    $update_stock_stmt->bind_param("is", $new_stock, $codigo);
    $update_stock_stmt->execute();
}

// Redirigir de nuevo al carrito de compras
header("Location: carritoCompras.php");
$conexion->close();
?>
