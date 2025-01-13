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
$user_type = $_SESSION['user_type'];

// Seleccionar la tabla según el tipo de usuario
$table = $user_type === 'cliente' ? 'clientes' : 'admins';

// Consultar los datos del perfil
$sql = "SELECT nombre_completo, telefono, direccion, usuario, contrasena, correo FROM $table WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nombre_completo, $telefono, $direccion, $usuario, $contrasena, $correo);
$stmt->fetch();
$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit Fusion Wear - Perfil del Usuario</title>
    <link rel="stylesheet" href="css/perfilUsuario.css">
</head>
<body>
    <header>
        <h1>Fit Fusion Wear</h1>
    </header>
    
    <!-- Incluir el menú del usuario -->
    <?php include('menuUsuario.html'); ?>

    <div id="agregar-cliente" class="seccion">
        <div class="form-table-style">
            <h2>Perfil del Cliente</h2>
            <div class="form-columna">
                <label>Nombre Completo:</label>
                <input type="text" id="nombreCliente" value="<?php echo htmlspecialchars($nombre_completo); ?>" disabled>
                
                <label>Teléfono:</label>
                <input type="text" id="telefonoCliente" value="<?php echo htmlspecialchars($telefono); ?>" disabled>
                
                <label>Dirección:</label>
                <textarea id="direccionCliente" disabled><?php echo htmlspecialchars($direccion); ?></textarea>
            </div>

            <div class="form-columna">
                <label>Usuario:</label>
                <input type="text" id="usuarioCliente" value="<?php echo htmlspecialchars($usuario); ?>" disabled>

                <label>Contraseña:</label>
                <input type="password" id="contrasenaCliente" value="<?php echo htmlspecialchars($contrasena); ?>" disabled>

                <label>Correo Electrónico:</label>
                <input type="email" id="correoCliente" value="<?php echo htmlspecialchars($correo); ?>" disabled>
            </div>
        </div>
    </div>
</body>
</html>
