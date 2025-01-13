<?php
// Conexión a la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ropadeportiva";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si se recibió el ID del pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id'])) {
    $pedido_id = intval($_POST['pedido_id']);

    // Consulta para eliminar el pedido
    $delete_query = "DELETE FROM pedidos WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $pedido_id);

    // Ejecuta la consulta sin mostrar mensaje
    $stmt->execute();
    $stmt->close();
} else {
    // Si no se recibió un ID de pedido válido, no se muestra ningún mensaje
}

$conn->close();

// Redirige de vuelta a la página de pedidos después de unos segundos
header("Location: verPedidos.php");  // Cambiar a "Location: verPedidos.php"
exit();
?>

