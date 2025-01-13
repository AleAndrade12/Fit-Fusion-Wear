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

// Obtener el producto por su código
if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];
    $sql = "SELECT * FROM productos WHERE codigo = '$codigo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit;
    }
}

// Editar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_producto'])) {
    // Escapar los valores para prevenir inyecciones SQL
    $codigo = mysqli_real_escape_string($conn, $_POST['codigo']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $precio = mysqli_real_escape_string($conn, $_POST['precio_venta']);
    $categoria = mysqli_real_escape_string($conn, $_POST['categoria']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $talla = mysqli_real_escape_string($conn, $_POST['talla']);

    // Verificar si el formulario está enviando datos correctamente
    if (empty($codigo) || empty($nombre) || empty($precio) || empty($categoria) || empty($stock) || empty($descripcion) || empty($color) || empty($talla)) {
        echo "Error: Faltan datos en el formulario.";
        exit;
    }

    // Consulta SQL para actualizar el producto
    $sql_update = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', talla = '$talla', color = '$color', precio = '$precio', categoria = '$categoria', stock = '$stock' WHERE codigo = '$codigo'";

    // Actualizar el producto
    if ($conn->query($sql_update) === TRUE) {
        header("Location: verInventario.php");
        exit;
    } else {
        echo "Error al actualizar producto: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Fit Fusion Wear</title>
    <link rel="stylesheet" href="css/editarProducto.css">
    <script>
        function toggleEdit() {
            var inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(function(input) {
                input.disabled = !input.disabled;
            });
            document.getElementById('editar-btn').style.display = 'none';
            document.getElementById('guardar-btn').style.display = 'block';
        }
    </script>
</head>
<body>
    <header>
        <h1>Fit Fusion Wear</h1>
    </header>
    <?php require('menuAdmin.html'); ?>

    <div id="editar-productos" class="seccion">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-table-style">
                <h2>Editar Producto</h2>
                <div class="form-columna">
                    <label>Codigo:</label>
                    <input type="text" name="codigo" value="<?= isset($producto) ? $producto['codigo'] : '' ?>" placeholder="Código del producto" required disabled>

                    <label>Nombre:</label>
                    <input type="text" name="nombre" value="<?= isset($producto) ? $producto['nombre'] : '' ?>" placeholder="Nombre del producto" required disabled>

                    <label>Descripción:</label>
                    <textarea name="descripcion" placeholder="Descripción del producto" required disabled><?= isset($producto) ? $producto['descripcion'] : '' ?></textarea>

                    <label>Talla:</label>
                    <select name="talla" required disabled>
                        <option value="">Selecciona talla</option>
                        <option value="unitalla" <?= isset($producto) && $producto['talla'] == 'unitalla' ? 'selected' : '' ?>>Unitalla</option>
                        <option value="extra_chico" <?= isset($producto) && $producto['talla'] == 'extra_chico' ? 'selected' : '' ?>>Extra Chico</option>
                        <option value="chico" <?= isset($producto) && $producto['talla'] == 'chico' ? 'selected' : '' ?>>Chico</option>
                        <option value="mediano" <?= isset($producto) && $producto['talla'] == 'mediano' ? 'selected' : '' ?>>Mediano</option>
                        <option value="grande" <?= isset($producto) && $producto['talla'] == 'grande' ? 'selected' : '' ?>>Grande</option>
                        <option value="extra_grande" <?= isset($producto) && $producto['talla'] == 'extra_grande' ? 'selected' : '' ?>>Extra Grande</option>
                        <option value="xs-ch" <?= isset($producto) && $producto['talla'] == 'xs-ch' ? 'selected' : '' ?>>XS-CH</option>
                        <option value="ch-m" <?= isset($producto) && $producto['talla'] == 'ch-m' ? 'selected' : '' ?>>CH-M</option>
                        <option value="m-l" <?= isset($producto) && $producto['talla'] == 'm-l' ? 'selected' : '' ?>>M-L</option>
                        <option value="l-xl" <?= isset($producto) && $producto['talla'] == 'l-xl' ? 'selected' : '' ?>>L-XL</option>
                        <option value="xs-m" <?= isset($producto) && $producto['talla'] == 'xs-m' ? 'selected' : '' ?>>XS-M</option>
                    </select>

                    <label>Color:</label>
                    <input type="text" name="color" value="<?= isset($producto) ? $producto['color'] : '' ?>" placeholder="Escribe el color" required disabled>
                </div>

                <div class="form-columna">
                    <label>Precio de venta:</label>
                    <input type="number" name="precio_venta" value="<?= isset($producto) ? $producto['precio'] : '' ?>" placeholder="Precio de venta" required disabled>

                    <label>Categoría:</label>
                    <select name="categoria" required disabled>
                        <option value="">Selecciona categoría</option>
                        <option value="tops" <?= isset($producto) && $producto['categoria'] == 'tops' ? 'selected' : '' ?>>Tops</option>
                        <option value="shorts" <?= isset($producto) && $producto['categoria'] == 'shorts' ? 'selected' : '' ?>>Shorts</option>
                        <option value="leggins" <?= isset($producto) && $producto['categoria'] == 'leggins' ? 'selected' : '' ?>>Leggins</option>
                        <option value="conjuntos" <?= isset($producto) && $producto['categoria'] == 'conjuntos' ? 'selected' : '' ?>>Conjuntos</option>
                        <option value="enterizos" <?= isset($producto) && $producto['categoria'] == 'enterizos' ? 'selected' : '' ?>>Enterizos</option>
                    </select>

                    <label>Stock:</label>
                    <input type="number" name="stock" value="<?= isset($producto) ? $producto['stock'] : '' ?>" placeholder="Cantidad en stock" required disabled>

                    <!-- Botones -->
                    <button type="button" id="editar-btn" onclick="toggleEdit()">Editar Producto</button>
                    <button type="submit" name="guardar_producto" id="guardar-btn" style="display:none;">Guardar Producto</button>
                    <input type="hidden" name="codigo" value="<?= isset($producto) ? $producto['codigo'] : '' ?>">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
