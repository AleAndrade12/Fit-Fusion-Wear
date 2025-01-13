<?php 
// Variables para producto si se encuentra
$producto = null;

// Buscar producto cuando se realiza la consulta
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $query = $_GET['query'];
    
    // Buscar producto por código, nombre o descripción
    $sql = "SELECT * FROM productos WHERE codigo LIKE '%$query%' OR nombre LIKE '%$query%' OR descripcion LIKE '%$query%'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Si se encuentra el producto, almacenamos los datos
        $producto = $result->fetch_assoc();
    } else {
        $_SESSION['mensaje'] = "No se encontraron productos.";
    }
}
?>

<div class="search-bar">
    <form method="GET" action="editarProducto.php">
        <input type="text" name="query" placeholder="Buscar productos..." value="<?= isset($_GET['query']) ? $_GET['query'] : '' ?>" required>
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="error-message"><?php echo $_SESSION['mensaje']; ?></div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>
        <button type="submit">Buscar</button>
    </form>
</div>