<?php
// public/views/home.php
require_once __DIR__ . '/../../utils/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Hiring Group</title>
    <link rel="stylesheet" href="../assets/css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-icons-1.13.1/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/styles-home.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="icon" href="../assets/images/Icono.png">
</head>
<body style="background-color: rgb(33, 37, 41)">
    <header style="position: fixed; width: 100%; z-index: 2; top: 0; left: 0;"><!--Barra de Navegacion-->
        <nav class="navbar navbar-expand-lg color_barra custom-border">
        <div class="container-fluid">
            <div class="px-2 py-1 animacionlogo">
                <a class="navbar-brand" href="<?= APP_URL ?>/"><img src="../assets/images/logo3.png" width="150" height="80"></a>
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
                    <a class="nav-link active px-lg-4" aria-current="page" href="#service">
                        <i class="bi bi-gear me-1"></i> Servicios
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active px-lg-4" aria-current="page" href="<?= APP_URL ?>/registro/postulante">
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

            <!--Boton solo visible en movil-->

             <div class="d-lg-none mt-3 mb-3 py-2 px-3 BotonSesion">
                    <a href="<?= APP_URL ?>/login" class="btn w-100 ">
                        <i class="bi bi-universal-access me-1"></i> Iniciar Sesión
                    </a>
            </div>

            <!--Boton solo visible en Desktop-->

            <div class="d-none d-lg-flex ms-lg-3 py-2 px-3 BotonSesion">
                    <a href="<?= APP_URL ?>/login" class="btn w-100 ">
                        <i class="bi bi-universal-access me-1"></i> Iniciar Sesión

                    </a>
            </div>

        </div>
        </nav>
    </header>

    <!--Carrusel de Videos y Texto Central-->

    <div class="container-fluid px-0 mb-5" style="height: 85vh; min-height: 300px; border: solid 5px rgb(80, 28, 162);">
        <div class="d-flex justify-content-center align-items-center w-100 h-100">
            <div id="videoCarousel" class="carousel slide w-100 h-100" data-bs-ride="carousel"> <!--Container del Carrusel-->
                <div class="carousel-inner w-100 h-100">
                    <div class="carousel-item active w-100 h-100">
                        <video autoplay loop muted src="../assets/video/home-1.mp4"
                            class="d-block w-100 h-100 object-fit-cover"
                            style="max-height: 100%; opacity: 0.6;"
                            type="video/mp4"></video>
                    </div>
                    <div class="carousel-item w-100 h-100">
                        <video autoplay loop muted src="../assets/video/home-2.mp4"
                            class="d-block w-100 h-100 object-fit-cover"
                            style="max-height: 100%; opacity: 0.6;"
                            type="video/mp4"></video>
                    </div>
                    <div class="carousel-item w-100 h-100">
                        <video autoplay loop muted src="../assets/video/home-3.mp4"
                            class="d-block w-100 h-100 object-fit-cover"
                            style="max-height: 100%; opacity: 0.6;"
                            type="video/mp4"></video>
                    </div>
                    <div class="carousel-item w-100 h-100">
                        <video autoplay loop muted src="../assets/video/home-4.mp4"
                            class="d-block w-100 h-100 object-fit-cover"
                            style="max-height: 100%; opacity: 0.6;"
                            type="video/mp4"></video>
                    </div>
                </div>
            </div>
        </div>

        <!--Texto Central-->

        <div class="position-absolute text-center w-75" style="top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <h1 class="display-4 fw-bold mb-3 textocentral">Bienvenido a Hiring Group</h1>
            <p class="lead mb-4 fw-bold parrafocentral"><b style="color: blueviolet !important;">Conectamos</b> talento con oportunidades. <b style="color: blueviolet !important;">Descubre</b> nuestros servicios. <b style="color: blueviolet !important;">Únete</b> a nuestra comunidad.</p>
            <a href="Register-Hiring Group.html" class="btn btn-outline-blueviolet btn-lg px-4 fw-bold">Registrarse</a>
        </div>
    </div>



    <main style="background-color: rgb(33, 37, 41)">
        <!--Sobre Nosotros-->
        <article>

            
            <div class="container-fluid px-0" style=" min-height: 300px;">
                <div class="row justify-content-center align-items-center w-100 h-100">
                    
                    <div class=" col-md-4 justify-content-center align-items-center">
                            <div id="videoCarousel" class="carousel slide w-100 h-100" data-bs-ride="carousel"> <!--Container del Carrusel-->
                                <div class="carousel-inner w-100 h-100" style="border-radius: 20px; border: 4px solid rgb(80, 28, 162) !important;">
                                    <div class="carousel-item active w-100 h-100">
                                        <video autoplay loop muted src="../assets/video/home-5.mp4"
                                            class="d-block w-100 h-100 object-fit-cover"
                                            style="max-height: 100%;"
                                            type="video/mp4"></video>
                                    </div>
                                    <div class="carousel-item w-100 h-100">
                                        <video autoplay loop muted src="../assets/video/home-6.mp4"
                                            class="d-block w-100 h-100 object-fit-cover"
                                            style="max-height: 100%;"
                                            type="video/mp4"></video>
                                    </div>
                                </div>
                            </div>   
                    </div>

                    <div class=" col-md-7 justify-content-center align-items-center nosotroscontainer">
                        <div class="d-flex flex-column justify-content-center align-items-center mt-3 nosotros text-center">
                            <h1 class="fw-bold mb-2">SOBRE NOSOTROS</h1>
                            <p class="fs-4 fw-semibold">Impulsando el talento, creando oportunidades.</p>
                            <div class="d-flex align-items-center w-100">
                                <div class="me-4">
                                    <img src="../assets/images/Icono.png" width="120" height="120" style="padding-bottom: 8px;">
                                </div>
                                <div class="text-start nosotros" style=" padding-bottom: 8px;">
                                    <p>En Hiring Group, te damos la bienvenida a un espacio donde el talento y las oportunidades se unen para impulsar tu crecimiento profesional y empresarial.</p>
                                    <p>Somos una empresa dedicada a conectar profesionales con empresas que buscan talento, ofreciendo soluciones innovadoras y personalizadas para cada necesidad.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



            </div>

        </article>

        <!--Servicios-->
        <article style="background-color: blueviolet;">
            <div class="container-fluid px-0" style="min-height: 320px;">
                <div class="row justify-content-center align-items-center w-100 h-100">
                    <div class="justify-content-center align-items-center">
                        <div class="d-flex flex-column justify-content-center align-items-center mt-3 servicios">
                            <h1 class="fw-bold mb-2">¿Cómo funciona?</h1>
                            <p class="fs-4 fw-semibold">Encuentra tu proximo empleo en 3 simples pasos</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Tarjeta 1 -->
                        <div class="col-md-4 mb-3" id="service">
                            <div class="card h-100 text-white border-0" style="background-color: rgb(80, 28, 162);">
                                <div class="card-body text-center d-flex flex-column align-items-center" style="color: white;">
                                    <i class="bi bi-1-circle fs-1 mb-3"></i>
                                    <h5 class="card-title"><strong>Crea tu perfil</strong> </h5>
                                    <p class="card-text fw-semibold">Registrate y completa tu perfil profesional<br> con tus habilidades, experiencias y preferencias laborales.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Tarjeta 2 -->
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 text-white border-0" style="background-color: rgb(80, 28, 162);">
                                <div class="card-body text-center d-flex flex-column align-items-center" style="color: white;">
                                    <i class="bi bi-2-circle fs-1 mb-3"></i>
                                    <h5 class="card-title"><strong>Explora Oportunidades</strong></h5>
                                    <p class="card-text fw-semibold">Busca entre miles de ofertas de empleo filtradas<br>según tus preferencias y cualificaciones</p>
                                </div>
                            </div>
                        </div>
                        <!-- Tarjeta 3 -->
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 text-white border-0" style="background-color: rgb(80, 28, 162);">
                               <div class="card-body text-center d-flex flex-column align-items-center" style="color: white;">
                                    <i class="bi bi-3-circle fs-1 mb-3"></i>
                                    <h5 class="card-title"><strong>Postúlate y conecta</strong></h5>
                                    <p class="card-text fw-semibold">Aplica a las ofertas que te interesen y conecta<br>directamente con los reclutadores de las empresas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>  
        
        <article>
            <div class="container-fluid px-0 mt-5" style="min-height: 320px; background-color:  rgb(80, 28, 162);">
                <div class="row justify-content-center align-items-center mx-auto" style="max-width: 1200px;"">
                    <div class="justify-content-center align-items-center mt-5 text-center">
                        <div class="d-flex flex-column justify-content-center align-items-center mt-3 registrarse">
                            <h1 class="fw-bold mb-2">¿Listo para dar el siguiente paso en tu carrera?</h1>
                            <p class="fs-4 fw-semibold" id="Registrarse">Unete a miles de profesionales que ya han encontrado su trabajo ideal con Hiring Group</p>
                        </div>

                        <div class="d-flex flex-column justify-content-center align-items-center mt-3">
                            <a href="<?= APP_URL ?>/login" class="btn btn-outline-light btn-lg px-4 fw-bold">Buscar Empleo</a>
                        </div>
                    </div>
            </div>
        </article>
    </main>
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