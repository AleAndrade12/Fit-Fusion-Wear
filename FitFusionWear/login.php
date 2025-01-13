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

$max_intentos = 5;  // Máximo intentos fallidos permitidos
$tiempo_bloqueo = 10 * 60;  // Bloqueo por 30 minutos (en segundos)

// Dirección IP del cliente
$ip_address = $_SERVER['REMOTE_ADDR'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'login') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validación de campos vacíos
    if (empty($username) || empty($password)) {
        $_SESSION['mensaje'] = "Por favor, completa todos los campos.";
        $_SESSION['old_username'] = $username;
        header("Location: login.php");
        exit();
    }

    // Verificar intentos fallidos anteriores
    $query_intentos = "SELECT COUNT(*) AS fallidos, MAX(timestamp) AS ultimo_intento 
                       FROM intentos_fallidos 
                       WHERE ip_address = ? AND username = ? AND timestamp > NOW() - INTERVAL 30 MINUTE";
    $stmt_intentos = $conexion->prepare($query_intentos);
    $stmt_intentos->bind_param("ss", $ip_address, $username);
    $stmt_intentos->execute();
    $resultado_intentos = $stmt_intentos->get_result();
    $intentos = $resultado_intentos->fetch_assoc();

    if ($intentos['fallidos'] >= $max_intentos) {
        $ultimo_intento = new DateTime($intentos['ultimo_intento']);
        $hoy = new DateTime();
        $diferencia = $hoy->getTimestamp() - $ultimo_intento->getTimestamp();

        if ($diferencia < $tiempo_bloqueo) {
            $_SESSION['mensaje'] = "Demasiados intentos fallidos. Intenta de nuevo más tarde.";
            $_SESSION['old_username'] = $username;
            header("Location: login.php");
            exit();
        }
    }

    // Verificar si el usuario es cliente
    $query_cliente = "SELECT * FROM clientes WHERE correo = ? OR usuario = ?";
    $stmt_cliente = $conexion->prepare($query_cliente);
    $stmt_cliente->bind_param("ss", $username, $username);
    $stmt_cliente->execute();
    $resultado_cliente = $stmt_cliente->get_result();

    if ($resultado_cliente->num_rows > 0) {
        $cliente = $resultado_cliente->fetch_assoc();
        if ($cliente['contrasena'] === $password) {
            // Iniciar sesión correctamente
            $_SESSION['user_id'] = $cliente['id'];
            $_SESSION['user_type'] = 'cliente';
            header("Location: inicioUsuario.php");
            exit();
        } else {
            // Registro de intento fallido
            $query_registro_fallo = "INSERT INTO intentos_fallidos (ip_address, username) VALUES (?, ?)";
            $stmt_fallo = $conexion->prepare($query_registro_fallo);
            $stmt_fallo->bind_param("ss", $ip_address, $username);
            $stmt_fallo->execute();

            $_SESSION['mensaje'] = "Contraseña incorrecta para el usuario o correo ingresado.";
            $_SESSION['old_username'] = $username;
            header("Location: login.php");
            exit();
        }
    }

    // Verificar si el usuario es administrador
    $query_admin = "SELECT * FROM admins WHERE correo = ? OR usuario = ?";
    $stmt_admin = $conexion->prepare($query_admin);
    $stmt_admin->bind_param("ss", $username, $username);
    $stmt_admin->execute();
    $resultado_admin = $stmt_admin->get_result();

    if ($resultado_admin->num_rows > 0) {
        $admin = $resultado_admin->fetch_assoc();
        if ($admin['contrasena'] === $password) {
            // Iniciar sesión correctamente
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['user_type'] = 'admin';
            header("Location: inicioAdmin.php");
            exit();
        } else {
            // Registro de intento fallido
            $query_registro_fallo = "INSERT INTO intentos_fallidos (ip_address, username) VALUES (?, ?)";
            $stmt_fallo = $conexion->prepare($query_registro_fallo);
            $stmt_fallo->bind_param("ss", $ip_address, $username);
            $stmt_fallo->execute();

            $_SESSION['mensaje'] = "Contraseña incorrecta para el usuario o correo ingresado.";
            $_SESSION['old_username'] = $username;
            header("Location: login.php");
            exit();
        }
    }

    // Si no es cliente ni administrador, mostrar mensaje de error
    $_SESSION['mensaje'] = "Usuario o correo no registrado. Intenta de nuevo.";
    $_SESSION['old_username'] = $username;
    header("Location: login.php");
    exit();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit Fusion Wear - Iniciar Sesión</title>
    <link rel="stylesheet" href="css/logins.css">
</head>
<body>
    <div id="index" class="index">
        <?php include 'menuIndex.html'; ?> <!-- Incluir el menú principal -->
        
        <div class="header-content">
            <div class="logo-container">
                <img src="img/logo.jpeg" alt="Logo de Fit Fusion Wear">
            </div>
            <div class="login-container">
                <h2>Iniciar Sesión</h2>
                <form action="login.php" method="POST" class="login-form">
                    <input type="hidden" name="action" value="login">
                    <div class="form-group">
                        <label for="username">Usuario o Correo Electrónico:</label>
                        <input type="text" id="username" name="username" required>
                        <?php if (isset($_SESSION['mensaje'])): ?>
                            <div class="error-message"><?= $_SESSION['mensaje'] ?></div>
                            <?php unset($_SESSION['mensaje']); ?>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit">Iniciar Sesión</button>
                </form>

                <!-- Enlace de registro -->
                <div class="register-link">
                    <p>¿No cuentas con una cuenta? <a href="registro.php">Haz clic aquí para registrarte</a></p>
                </div>
            </div>
        </div>
    </div>  
</body>
</html>