<?php
session_start();

// Conexión a la base de datos
$server = "localhost";
$username = "root";
$password = "";
$dbname = "ropadeportiva";

$conn = new mysqli($server, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el código del producto está presente
if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Eliminar el producto
    $sql_delete = "DELETE FROM productos WHERE codigo = '$codigo'";

    if ($conn->query($sql_delete) === TRUE) {
        // Redirigir al inventario después de eliminar
        header("Location: verInventario.php");
        exit;
    } else {
        echo "Error al eliminar producto: " . $conn->error;
    }
} else {
    echo "No se ha proporcionado un código de producto.";
}

// Cerrar la conexión
$conn->close();
?>
