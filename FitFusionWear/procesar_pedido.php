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

$user_id = $_SESSION['user_id'];  // El ID del cliente desde la sesión

// Consulta para obtener los datos del cliente desde la base de datos
$sql_cliente = "SELECT nombre_completo, telefono, direccion FROM clientes WHERE id = ?";
$stmt_cliente = $conexion->prepare($sql_cliente);
$stmt_cliente->bind_param("i", $user_id);
$stmt_cliente->execute();
$result_cliente = $stmt_cliente->get_result();

// Verificamos que el cliente exista
if ($result_cliente->num_rows > 0) {
    $cliente = $result_cliente->fetch_assoc();
    $nombre_cliente = $cliente['nombre_completo'];
    $telefono_cliente = $cliente['telefono'];
    $direccion_cliente = $cliente['direccion'];
} else {
    // Si no se encuentra el cliente, redirigir al login
    header('Location: login.php');
    exit();
}

$entrega = $_POST['entrega'];
$pago = $_POST['pago'];
$fecha_entrega = $_POST['fecha'];

// Obtener los productos del carrito
$sql = "SELECT c.cantidad, p.codigo, p.nombre, p.precio 
        FROM carrito c 
        JOIN productos p ON c.producto_codigo = p.codigo 
        WHERE c.cliente_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Crear un array con los productos para almacenar en formato JSON
$productos_pedido = [];
$total = 0;

while ($producto = $result->fetch_assoc()) {
    $codigo = $producto['codigo'];
    $nombre = $producto['nombre'];
    $precio = $producto['precio'];
    $cantidad = $producto['cantidad'];
    $subtotal = $precio * $cantidad;
    $total += $subtotal;

    $productos_pedido[] = [
        'codigo' => $codigo,
        'nombre' => $nombre,
        'precio' => $precio,
        'cantidad' => $cantidad,
        'subtotal' => $subtotal
    ];
}

// Convertir el array a formato JSON
$lista_compras = json_encode($productos_pedido);

// Insertar el pedido en la base de datos
$sql_pedido = "INSERT INTO pedidos (cliente_id, nombre_cliente, telefono_cliente, direccion_cliente, lista_compras, total, forma_entrega, forma_pago, fecha_entrega) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_pedido = $conexion->prepare($sql_pedido);
$stmt_pedido->bind_param("issssssss", $user_id, $nombre_cliente, $telefono_cliente, $direccion_cliente, $lista_compras, $total, $entrega, $pago, $fecha_entrega);
$stmt_pedido->execute();

// Eliminar los productos del carrito después de realizar el pedido
$sql_delete_carrito = "DELETE FROM carrito WHERE cliente_id = ?";
$stmt_delete_carrito = $conexion->prepare($sql_delete_carrito);
$stmt_delete_carrito->bind_param("i", $user_id);
$stmt_delete_carrito->execute();

// Guardar un mensaje de confirmación en la sesión
$_SESSION['mensaje_confirmacion'] = "Tu pedido ha sido realizado con éxito. ¡Gracias por tu compra!";

// Redirigir a la página de confirmación (puedes cambiar a una página de gracias o carrito)
header('Location: carritoCompras.php');
exit();
?>