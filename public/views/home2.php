<?php
// public/views/Home.php
require_once __DIR__ . '/../../utils/config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Empleo</title>
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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #fff;
        }
        
        .container {
            max-width: 1200px;
            width: 100%;
            text-align: center;
        }
        
        header {
            margin-bottom: 40px;
        }
        
        h1 {
            font-size: 3.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .subtitle {
            font-size: 1.5rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .features {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-bottom: 50px;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            width: 300px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .feature-card h3 {
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        
        .feature-card p {
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 15px 30px;
            font-size: 1.2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background-color: #ff6b6b;
            color: white;
        }
        
        .btn-secondary {
            background-color: transparent;
            border: 2px solid white;
            color: white;
        }
        
        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 50px;
            flex-wrap: wrap;
        }
        
        .stat-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            min-width: 200px;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        footer {
            margin-top: 50px;
            padding: 20px;
            text-align: center;
            opacity: 0.8;
        }
        
        @media (max-width: 768px) {
            .features, .cta-buttons, .stats {
                flex-direction: column;
                align-items: center;
            }
            
            h1 {
                font-size: 2.5rem;
            }
            
            .subtitle {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Conectando Talentos con Oportunidades</h1>
            <p class="subtitle">La plataforma líder para encontrar el trabajo perfecto o el candidato ideal</p>
        </header>
        
        <div class="features">
            <div class="feature-card">
                <h3>Para Postulantes</h3>
                <p>Encuentra trabajos que se ajusten a tus habilidades y aspiraciones profesionales. Crea un perfil atractivo y recibe ofertas personalizadas.</p>
            </div>
            
            <div class="feature-card">
                <h3>Para Empresas</h3>
                <p>Publica tus ofertas laborales y encuentra a los mejores candidatos. Herramientas avanzadas para gestionar todo el proceso de contratación.</p>
            </div>
            
            <div class="feature-card">
                <h3>Para Hiring Groups</h3>
                <p>Plataforma especializada para agencias de reclutamiento. Gestiona múltiples clientes y candidatos en un solo lugar.</p>
            </div>
        </div>
        
        <div class="cta-buttons">
            <a href="<?= APP_URL ?>/login" class="btn btn-primary">Iniciar Sesión</a>
            <a href="<?= APP_URL ?>/registro/postulante" class="btn btn-secondary">Registrarse</a>
        </div>
        
        <div class="stats">
            <div class="stat-item">
                <div class="stat-number">5,000+</div>
                <div>Empresas Registradas</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">120,000+</div>
                <div>Postulantes Activos</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">25,000+</div>
                <div>Ofertas Laborales</div>
            </div>
        </div>
        
        <footer>
            <p>&copy; <?= date('Y') ?> Sistema de Empleo. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>
</html>