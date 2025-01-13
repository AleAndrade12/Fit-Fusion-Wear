<?php
// Iniciar la sesión
session_start();

// Eliminar todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Eliminar la cookie de sesión si existe
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Establecer encabezados HTTP para prevenir la caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Redirigir al usuario a la página de inicio de sesión
header("Location: login.php"); // Puedes redirigir a cualquier página de tu elección
exit;
?>
