<?php
// public/views/auth/login.php
require_once __DIR__ . '/../../../utils/config.php';
?>

<!DOCTYPE html>
<html lang="en"><!--Metadatos-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hiring Group</title>
    <link rel="stylesheet" href="../../assets/css/styles-login.css">
    <link rel="icon" href="../../assets/images/Icono.png">
    <link rel="stylesheet" href="../../assets/css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-icons-1.13.1/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
</head>
<body><!--Cuerpo de la Pagina-->
    <header style="position: fixed; width: 100%; z-index: 2; top: 0; left: 0;"><!--Barra de Navegacion-->
        <nav class="navbar navbar-expand-lg color_barra custom-border">
        <div class="container-fluid">
            <div class="px-2 py-1 animacionlogo">
                <a class="navbar-brand" href="<?= APP_URL ?>/"><img src="../../assets/images/logo3.png" width="150" height="80"></a>
            </div>
            <!--Boton para Tlf-->
            <!--navbarSupportedContet, opciones que se colapsaran llegado a cierta posicion dada por el expand-md-->
            <button class="navbar-toggler btn btn-outline-light border-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <!--Menu colapsable-->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!--Opciones del Menu de Navegacion-->
                <ul class="navbar-nav mx-auto flex-lg-row gap-lg-5 menu">
                    <li class="nav-item">
                    <a class="nav-link active px-lg-4" aria-current="page" href="<?= APP_URL ?>/">
                         <i class="bi bi-house-door me-1"></i> Inicio
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active px-lg-4" aria-current="page" href="<?= APP_URL ?>/#service">
                        <i class="bi bi-gear me-1"></i> Servicios
                    </a>
                    </li>
                    <li class="nav-item">
<<<<<<<< HEAD:public/views/Login - Hiring Group.html
                    <a class="nav-link active px-lg-4" aria-current="page" href="UserContratado - Hiring Group.html"> <!--Enlace a la pagina de Uusario de prueba-->
========
                    <a class="nav-link active px-lg-4" aria-current="page" href="<?= APP_URL ?>/registro/postulante"> <!--Enlace a la pagina de Uusario de prueba-->
>>>>>>>> feature-controllers:public/views/auth/login.php
                        <i class="bi bi-globe me-1"></i> Registrarse
                    </a>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-lg-4" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Menu
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#">
                                Nintendo Switch <i class="bi bi-nintendo-switch me-1"></i>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                Twitter <i class="bi bi-twitter me-1"></i>
                            </a>
                        </li>
                    </ul>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active px-lg-4" aria-current="page" href="#">
                        <i class="bi bi-paypal me-1"></i> Rutinas
                    </a>
                    </li>
                </ul>
            </div>

        
        </div>
        </nav>
    </header>

    <!--Inicio Sesion-->
    <div class="container-fluid g-0" style="padding-top: 87px;"> <!--Contenedor Principal-->
        <div class="row g-0"> <!--Fila Principal-->
            <!-- Sección Negro (50%) -->
            <div class="col-md-6 d-flex align-items-center justify-content-center" style="background-color: rgb(33, 37, 41)">
                <div class="text-white p-4 text-start">
                    <h1><strong>Inicio de Sesion</strong></h1>
                    <form class="mt-5" method="post" action="<?= APP_URL ?>/auth">
                        <div class="mb-3">
                            <label for="identifier" class="form-label"><h5>Usuario <i class="bi bi-person-fill me-3"></i></h5></i></label>
                            <input type="text" class="form-control barrasesion" id="identifier" name="identifier" placeholder="Ingrese su Usuario o Correo" required>
                        </div>
                        <div class="mb-3">
                             <label for="password" class="form-label"><h5>Contraseña <i class="bi bi-lock-fill me-3"></i></h5></i></label>
                            <input type="password" class="form-control barrasesion" id="password" name="password" placeholder="Ingrese su Contraseña" style="color: white !important;" required>
                        </div>
                        <div class="text-center">
                           <button type="submit" class="btn btn-outline-blueviolet px-5 mt-3"><strong>Login</strong></button> 
                        </div>
                        
                    </form>
                    <p class="mt-3 text-center" >¿No tienes una Cuenta? <a href="<?= APP_URL ?>/registro/postulante" style="color: blueviolet !important; text-decoration: none;"><strong>¡Registrate!</strong></a></p>
                </div>
                
            </div>
            
            <!-- Sección Morada (50%) -->
            <div class="col-md-6 d-flex align-items-center justify-content-center" style="background-color: #6c2eb7 !important;">
                <div class="d-flex flex-column align-items-center justify-content-center" style="width: 100%; height: 100%; position: relative;">
                    <!--Video Placeholder-->
                    <div class="mb-2 mt-4 justify-content-center" style="border-radius: 10px; overflow: hidden; z-index: 0;">
                        <video autoplay muted loop style="width: 95%; height: auto; max-height: 300px; object-fit: cover; border-radius: 20px;">
                            <source src="../../assets/video/placeholder.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div> 
                    <!--Texto de Bienvenida-->
                    <div class="text-white px-4 text-end" style="margin-top: 10px;">
                        <h1><strong>WELCOME</strong></h1>
                        <h1><strong>BACK!</strong></h1>
                        <p class="mt-3" style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit<br>, sed do eiusmod tempor<br>
                            incididunt ut labore et dolore magna aliqua. Ut<br>
                            ullamco laboris nisi ut aliquip ex ea
                        </p>
                    </div>
                </div>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<!--Final de la pagina-->
<footer style="background-color: rgb(29, 29, 29);">
    <div class="container py-4">
        <div class="row">
            <!-- Tarjeta 1 -->
            <div class="col-md-4 mb-3">
                <div class="card h-100 bg-dark text-white border-0">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Nosotros</strong> </h5>
                        <p class="card-text">Somos Hiring Group, conectando talento con oportunidades laborales. Nuestro objetivo es facilitar el proceso de contratación.</p>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 2 -->
            <div class="col-md-4 mb-3">
                <div class="card h-100 bg-dark text-white border-0">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Contacto</strong></h5>
                        <p class="card-text">
                            <i class="bi bi-envelope me-2"></i> contacto@hiringgroup.com<br>
                            <i class="bi bi-telephone me-2"></i> +1 234 567 890<br>
                            <i class="bi bi-geo-alt me-2"></i> Av. Principal 123, Ciudad XXXX, País YYYY
                        </p>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 3 -->
            <div class="col-md-4 mb-3">
                <div class="card h-100 bg-dark text-white border-0">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Síguenos</strong></h5>
                        <p class="card-text">
                            <a href="#" class="text-white me-2" style="text-decoration: none !important;"><i class="bi bi-twitter"></i> <strong>Twitter</strong></a><br>
                            <a href="#" class="text-white me-2" style="text-decoration: none !important;"><i class="bi bi-facebook"></i> <strong>Facebook</strong></a><br>
                            <a href="#" class="text-white me-2" style="text-decoration: none !important;"><i class="bi bi-instagram"></i> <strong>Instagram</strong> </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center text-white mt-3" style="font-size: 0.9rem;">
            &copy; 2025 Hiring Group. All rights reserved to <strong>Alejandro González</strong>.
        </div>
    </div>
</footer>
</html>