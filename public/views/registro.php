<?php
session_start();
require_once __DIR__ . '/../../utils/config.php';
require_once CORE_DIR . 'Auth.php';
require_once CONTROLLERS_DIR . 'UsuarioController.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$mensaje = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Token CSRF inválido.";
    } else {
        try {
            UsuarioController::registrarPostulante($_POST);
            $mensaje = "Registro exitoso. Ya puedes iniciar sesión.";
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Postulante</title>
</head>
<body>
    <h1>Registro</h1>

    <?php if ($mensaje): ?>
        <p style="color:green"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="/views/registro.php">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <label>Nombre de usuario:</label><br>
        <input type="text" name="nombre_usuario" required><br>

        <label>Contraseña:</label><br>
        <input type="password" name="contraseña" required><br>

        <label>Correo:</label><br>
        <input type="email" name="correo" required><br>

        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br>

        <label>Apellido:</label><br>
        <input type="text" name="apellido" required><br>

        <label>Cédula:</label><br>
        <input type="text" name="cedula" required><br>

        <label>Estado de residencia:</label><br>
        <input type="text" name="estado_residencia" required><br>

        <label>Ciudad de residencia:</label><br>
        <input type="text" name="ciudad_residencia" required><br>

        <label>Tipo de sangre:</label><br>
        <select name="tipo_sangre" required>
            <option value="A_pos">A+</option>
            <option value="A_neg">A−</option>
            <option value="B_pos">B+</option>
            <option value="B_neg">B−</option>
            <option value="AB_pos">AB+</option>
            <option value="AB_neg">AB−</option>
            <option value="O_pos">O+</option>
            <option value="O_neg">O−</option>
        </select><br>

        <label>Fecha de nacimiento:</label><br>
        <input type="date" name="fecha_nacimiento" required><br>

        <label>Género:</label><br>
        <input type="text" name="genero" required><br><br>

        <button type="submit">Registrarse</button>
    </form>
</body>
</html>