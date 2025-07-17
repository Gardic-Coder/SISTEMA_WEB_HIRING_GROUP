<?php
session_start();
require_once __DIR__ . '/../../utils/config.php';
require_once CORE_DIR . 'Auth.php';

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = null;

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Token CSRF inválido.";
    } else {
        $usuario = $_POST['nombre_usuario'] ?? '';
        $clave = $_POST['contraseña'] ?? '';

        if (Auth::login($usuario, $clave)) {
            // Redirigir según tipo de usuario
            $rol = Auth::getCurrentUserRole();
            switch ($rol) {
                case 'administrador':
                    header('Location: /admin/dashboard.php');
                    break;
                case 'empresa':
                    header('Location: /empresa/panel.php');
                    break;
                case 'postulante':
                    header('Location: /postulante/perfil.php');
                    break;
                case 'hiring_group':
                    header('Location: /hiring/dashboard.php');
                    break;
                default:
                    header('Location: /');
            }
            exit;
        } else {
            $error = "Credenciales incorrectas.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión</title>
</head>
<body>
    <h1>Login</h1>

    <?php if ($error): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="/views/login.php">
        <label>Usuario:</label><br>
        <input type="text" name="nombre_usuario" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="contraseña" required><br><br>

        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>