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

$errors = [];

// Verificación de datos cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreCompleto = $_POST['fullName'];
    $telefono = $_POST['phone'];
    $correo = $_POST['correo'];
    $usuario = $_POST['username'];
    $contraseña = $_POST['password'];
    $confirmarContraseña = $_POST['confirm_password']; // Confirmar contraseña
    $direccion = $_POST['address'];

    // Guardar los datos del formulario en sesión para persistir los valores
    $_SESSION['form_data'] = $_POST;

    // Lista de dominios permitidos
    $allowedDomains = ['gmail.com', 'outlook.com', 'hotmail.com', 'yahoo.com', 'yahoo.com.mx', 'live.com', 'prodigy.net.mx', 'icloud.com', 'msn.com', 'aol.com'];

    // Validación del nombre completo
    if (empty($nombreCompleto) || strlen($nombreCompleto) > 50 || !preg_match("/^[a-zA-Z\s]+$/", $nombreCompleto)) {
        $errors['nombreCompleto'] = "El nombre completo debe contener solo letras y espacios, y no exceder los 50 caracteres.";
    }

    // Validación del teléfono
    if (empty($telefono) || strlen($telefono) != 10 || !preg_match("/^[0-9]+$/", $telefono)) {
        $errors['telefono'] = "El teléfono debe tener exactamente 10 dígitos y solo números.";
    }

    // Validación del correo
    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errors['correo'] = "El correo debe tener un formato válido.";
    } else {
        // Validar dominio del correo
        $domain = substr(strrchr($correo, "@"), 1); // Obtener dominio del correo
        if (!in_array($domain, $allowedDomains)) {
            $errors['correo'] = "El dominio del correo electrónico no es válido. Solo se permiten dominios como " . implode(', ', $allowedDomains) . ".";
        }
    }

    // Validación de la contraseña
    if (empty($contraseña) || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/", $contraseña)) {
        $errors['contraseña'] = "La contraseña debe tener al menos 8 caracteres, contener al menos una letra mayúscula, una minúscula y un carácter especial.";
    }

    // Validación de la confirmación de la contraseña
    if (empty($confirmarContraseña) || $confirmarContraseña !== $contraseña) {
        $errors['confirm_password'] = "Las contraseñas no coinciden.";
    }

    // Validación del usuario
    if (empty($usuario)) {
        $errors['usuario'] = "El nombre de usuario es requerido.";
    }

    // Validación de dirección
    if (empty($direccion)) {
        $errors['direccion'] = "La dirección es requerida.";
    }

    if (!empty($errors)) {
        // Guardar los errores en la sesión para mostrarlos en el formulario
        $_SESSION['errors'] = $errors;
        header("Location: registro.php"); // Redirigir al mismo formulario con los errores
        exit();
    }

    // Verificar si el nombre de usuario ya está registrado
    $sql_verificar_usuario = "SELECT * FROM clientes WHERE usuario = '$usuario'";
    $resultado_verificacion_usuario = $conexion->query($sql_verificar_usuario);

    if ($resultado_verificacion_usuario->num_rows > 0) {
        $_SESSION['errors']['usuario'] = "El nombre de usuario ya está registrado. Por favor, elige otro.";
        header("Location: registro.php");
        exit();
    }

    // Verificar si el correo ya está registrado
    $sql_verificar_correo = "SELECT * FROM clientes WHERE correo = '$correo'";
    $resultado_verificacion_correo = $conexion->query($sql_verificar_correo);

    if ($resultado_verificacion_correo->num_rows > 0) {
        $_SESSION['errors']['correo'] = "El correo ya está registrado. Por favor, utiliza otro correo.";
        header("Location: registro.php");
        exit();
    }

    // Si no hay errores, insertar el nuevo usuario
    $sql = "INSERT INTO clientes (nombre_completo, telefono, correo, usuario, contrasena, direccion)
            VALUES ('$nombreCompleto', '$telefono', '$correo', '$usuario', '$contraseña', '$direccion')";

    if ($conexion->query($sql) === TRUE) {
        // Si la inserción es exitosa, aseguramos que no haya salida antes de la redirección
        $_SESSION['mensaje'] = "Registro exitoso. Inicia sesión ahora.";
        header("Location: login.php");
        exit(); // Asegura que no se ejecute más código después de la redirección
    } else {
        $_SESSION['mensaje'] = "Error al registrar: " . $conexion->error;
        header("Location: registro.php");
        exit();
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit Fusion Wear - Registro</title>
    <link rel="stylesheet" href="CSS/registro.css">
</head>
<body>
    <div id="index" class="index">
        <?php include 'menuIndex.html'; ?> <!-- Incluir el menú principal -->
        
        <div class="header-content">
            <div class="logo-container">
                <img src="img/logo.jpeg" alt="Logo de Fit Fusion Wear">
            </div>
            <?php
                // Mostrar mensajes de error o éxito
                if (isset($_SESSION['mensaje'])) {
                    echo "<div class='mensaje'>" . $_SESSION['mensaje'] . "</div>";
                    unset($_SESSION['mensaje']);
                }
            ?>
            <form action="registro.php" method="POST" class="login-form">
            <h2>Registro</h2>
            <div class="login-container">
                <!-- Primera columna -->
                <div class="left-column">
                    <div class="form-group">
                        <label for="fullName">Nombre completo:</label>
                        <input type="text" id="fullName" name="fullName" value="<?php echo isset($_SESSION['form_data']['fullName']) ? $_SESSION['form_data']['fullName'] : ''; ?>" required>
                        <?php if(isset($_SESSION['errors']['nombreCompleto'])): ?>
                            <div class="error-message"><?= $_SESSION['errors']['nombreCompleto'] ?></div>
                            <?php unset($_SESSION['errors']['nombreCompleto']); ?>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono:</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo isset($_SESSION['form_data']['phone']) ? $_SESSION['form_data']['phone'] : ''; ?>" required>
                        <?php if(isset($_SESSION['errors']['telefono'])): ?>
                            <div class="error-message"><?= $_SESSION['errors']['telefono'] ?></div>
                            <?php unset($_SESSION['errors']['telefono']); ?>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="address">Dirección:</label>
                        <input type="text" id="address" name="address" value="<?php echo isset($_SESSION['form_data']['address']) ? $_SESSION['form_data']['address'] : ''; ?>" required>
                        <?php if(isset($_SESSION['errors']['direccion'])): ?>
                            <div class="error-message"><?= $_SESSION['errors']['direccion'] ?></div>
                            <?php unset($_SESSION['errors']['direccion']); ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Segunda columna -->
                <div class="right-column">
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="text" id="correo" name="correo" value="<?php echo isset($_SESSION['form_data']['correo']) ? $_SESSION['form_data']['correo'] : ''; ?>" required>
                        <?php if(isset($_SESSION['errors']['correo'])): ?>
                            <div class="error-message"><?= $_SESSION['errors']['correo'] ?></div>
                            <?php unset($_SESSION['errors']['correo']); ?>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="username">Usuario:</label>
                        <input type="text" id="username" name="username" value="<?php echo isset($_SESSION['form_data']['username']) ? $_SESSION['form_data']['username'] : ''; ?>" required>
                        <?php if(isset($_SESSION['errors']['usuario'])): ?>
                            <div class="error-message"><?= $_SESSION['errors']['usuario'] ?></div>
                            <?php unset($_SESSION['errors']['usuario']); ?>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" required>
                        <?php if(isset($_SESSION['errors']['contraseña'])): ?>
                            <div class="error-message"><?= $_SESSION['errors']['contraseña'] ?></div>
                            <?php unset($_SESSION['errors']['contraseña']); ?>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar contraseña:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                        <?php if(isset($_SESSION['errors']['confirm_password'])): ?>
                            <div class="error-message"><?= $_SESSION['errors']['confirm_password'] ?></div>
                            <?php unset($_SESSION['errors']['confirm_password']); ?>
                        <?php endif; ?>
                    </div>
                    <button type="submit">Registrar</button>
                    <p class="login-link">¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
                </div>
            </div>
        </form>
        </div>
    </div>
</body>
</html>
