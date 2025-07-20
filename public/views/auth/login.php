<?php
require_once __DIR__ . '/../../../utils/config.php';
require_once CORE_DIR . 'Auth.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Empleo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1e5799, #207cca);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo h1 {
            color: white;
            font-size: 2.5rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }
        
        .login-form .form-group {
            margin-bottom: 25px;
        }
        
        .login-form label {
            display: block;
            margin-bottom: 8px;
            color: white;
            font-weight: 500;
            font-size: 1.1rem;
        }
        
        .login-form input {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .login-form input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.2);
        }
        
        .login-form input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .btn-login {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            background: #ff6b6b;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            background: #ff5252;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }
        
        .forgot-password a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s ease;
        }
        
        .forgot-password a:hover {
            color: white;
            text-decoration: underline;
        }
        
        .register-link {
            text-align: center;
            margin-top: 30px;
            color: white;
            font-size: 1.1rem;
        }
        
        .register-link a {
            color: #ffdd59;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        
        .register-link a:hover {
            color: #ffcc00;
            text-decoration: underline;
        }
        
        .error-message {
            background: rgba(231, 76, 60, 0.3);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid rgba(231, 76, 60, 0.5);
        }
        
        .user-type-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }
        
        .user-type-btn {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid transparent;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .user-type-btn.active {
            background: rgba(255, 107, 107, 0.3);
            border-color: rgba(255, 255, 255, 0.4);
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            
            .logo h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>Sistema de Empleo</h1>
        </div>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <form action="<?= APP_URL ?>/auth" method="post" class="login-form">
            <div class="form-group">
                <label for="identifier">Usuario o Correo Electrónico</label>
                <input type="text" id="identifier" name="identifier" required placeholder="Ingresa tu usuario o correo">
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="Ingresa tu contraseña">
            </div>
            
            <button type="submit" class="btn-login">Iniciar Sesión</button>
            
            <div class="forgot-password">
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>
        </form>
        
        <div class="register-link">
            <p>¿No tienes una cuenta? <a href="<?= APP_URL ?>/registro/postulante">Regístrate ahora</a></p>
        </div>
    </div>
</body>
</html>