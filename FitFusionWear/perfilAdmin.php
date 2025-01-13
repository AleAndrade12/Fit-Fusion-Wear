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
$sql = "SELECT nombre_completo, correo, contrasena, usuario FROM $table WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nombre_completo, $correo, $contrasena, $usuario);
$stmt->fetch();
$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit Fusion Wear - Menú Administradores</title>
    <link rel="stylesheet" href="css/perfilAdmin.css">
</head>
<body>
    <header>
        <h1>Fit Fusion Wear</h1>
    </header>

    <!-- Incluir el menú del administrador -->
    <?php include('menuAdmin.html'); ?>

    <div id="perfil-admin" class="seccion">
        <div class="perfil-admin-form">
            <h2>Perfil del Administrador</h2>
            <label for="nombreAdmin">Nombre Completo:</label>
            <input type="text" id="nombreAdmin" value="<?php echo htmlspecialchars($nombre_completo); ?>" disabled>

            <label for="usuarioAdmin">Usuario:</label>
            <input type="text" id="usuarioAdmin" value="<?php echo htmlspecialchars($usuario); ?>" disabled>

            <label for="contrasenaAdmin">Contraseña:</label>
            <input type="password" id="contrasenaAdmin" value="<?php echo htmlspecialchars($contrasena); ?>" disabled>

            <label for="correoAdmin">Correo Electrónico:</label>
            <input type="email" id="correoAdmin" value="<?php echo htmlspecialchars($correo); ?>" disabled>
        </div>
    </div>
</body>
</html>