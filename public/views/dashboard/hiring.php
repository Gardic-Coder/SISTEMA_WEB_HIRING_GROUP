<?php
// public/views/dashboard/hiring.php
require_once __DIR__ . '/../../../utils/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring Group User - Hiring Group</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-icons-1.13.1/bootstrap-icons.css">
    <link rel="icon" href="../../assets/images/Icono.png">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="stylesheet" href="../../assets/css/Styles-usercontratado.css">
    <link rel="stylesheet" href="../../assets/css/styles-home.css">
</head>
<body style="background-color: rgb(33, 37, 41)">
   <header style="position: fixed; width: 100%; z-index: 2; top: 0; left: 0;"><!--Barra de Navegacion-->
        <nav class="navbar navbar-expand-lg color_barra custom-border">
        <div class="container-fluid">
            <div class="px-4 py-1 animacionlogo">
                <a class="navbar-brand" href="<?= APP_URL ?>/dashboard"><img src="../../assets/images/Icono.png" width="70" height="65"></a>
            </div>
            <!--Boton para Tlf-->
            <!--navbarSupportedContet, opciones que se colapsaran llegado a cierta posicion dada por el expand-md-->
            <button class="navbar-toggler btn btn-outline-light border-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <!--Menu colapsable-->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!--Opciones del Menu de Navegacion-->
                <ul class="navbar-nav mx-auto flex-lg-row gap-lg menu">
                    <li class="nav-item">
                    <a class="nav-link active px-lg-3" aria-current="page" href="<?= APP_URL ?>/logout">
                         <i class="bi bi-house me-1"></i> Cerrar Sesión
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active px-lg-3" aria-current="page" href="<?= APP_URL ?>/dashboard/ofertas">
                        <i class="bi bi-search me-1"></i> Ofertas Publicadas
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active px-lg-3" aria-current="page" href="<?= APP_URL ?>/registro/empresa">
                        <i class="bi bi-clipboard-data me-1"></i> Registrar Clientes
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active px-lg-3" aria-current="page" href="#">
                        <i class="bi bi-person-badge me-1"></i> Postulantes
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active px-lg-3" aria-current="page" href="#">
                        <i class="bi bi-coin me-1"></i> Nómina Mensual
                    </a>
                    </li>
                </ul>
            </div>
        </div>
        </nav>
    </header>
    
    <!--Parte principal del Perfil-->
<main class="container-fluid mt-5 px-0" style="height: auto; padding-top: 90px;">
    <div class="row align-items-center" style="height: 100%; background-color: blueviolet;">
        <!-- Columna izquierda con nombre y foto -->
        <div class=" col-12 text-center py-3 px-5 textocentral">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center">
                
                <!-- Texto de bienvenida -->
                <div class=" text-center textocentral px-1">
                    <h1 class="text-center text-white fw-bold">Bienvenido, <?= htmlspecialchars($usuario['nombre_usuario']) ?></h1>
                    <p class="text-center text-white fw-semibold" style="font-size: large;">Contamos con usted nuevamente el dia de hoy.</p>
                </div>
            </div>
        </div>
    </div>
</main>

    <article>
            <div class="container-fluid px-0 mt-5" style=" min-height: 300px;">
                <div class="row justify-content-center align-items-center w-100 h-100">
                    
                    <div class=" col-md-4 justify-content-center align-items-center">
                            <div id="videoCarousel" class="carousel slide w-100 h-100" data-bs-ride="carousel"> <!--Container del Carrusel-->
                                <div class="carousel-inner w-100 h-100" style="border-radius: 20px; border: 4px solid rgb(80, 28, 162) !important;">
                                    <div class="carousel-item active w-100 h-100">
                                        <video autoplay loop muted src="../assets/video/HG1.mp4"
                                            class="d-block w-100 h-100 object-fit-cover"
                                            style="max-height: 100%;"
                                            type="video/mp4"></video>
                                    </div>
                                    <div class="carousel-item w-100 h-100">
                                        <video autoplay loop muted src="../../assets/video/HG2.mp4"
                                            class="d-block w-100 h-100 object-fit-cover"
                                            style="max-height: 100%;"
                                            type="video/mp4"></video>
                                    </div>
                                </div>
                            </div>   
                    </div>

                    <div class=" col-md-7 justify-content-center align-items-center nosotroscontainer">
                        <div class="d-flex flex-column justify-content-center align-items-center mt-3 nosotros text-center">
                            <h1 class="fw-bold mb-2">REGLAMENTO HIRING GROUP</h1>
                            <div class="separador" style="height: 3px; background: linear-gradient(to right, #503ca2, #8a63f6); width: 80px; margin: 0 auto;"></div>
                            <div class="d-flex align-items-center w-100">
                                <div class="text-center nosotros mt-2">
                                    <p class="fw-semibold">Conectar el talento profesional con oportunidades laborales de calidad, manteniendo los valores de transparencia, ética e innovación en cada proceso de selección.<br></p>
                                    <div class="text-center nosotros">
                                        <p class="fs-5 fw-semibold"><i class="bi bi-1-circle-fill me-1" style="color: #8a63f6 !important;"></i>Garantizar confidencialidad de datos personales</p>
                                        <p class="fs-5 fw-semibold"><i class="bi bi-2-circle-fill me-1" style="color: #8a63f6 !important;"></i>Procesos de selección libres de discriminación</p>
                                        <p class="fs-5 fw-semibold"><i class="bi bi-3-circle-fill me-1" style="color: #8a63f6 !important;"></i>Comunicación clara y oportuna</p>
                                        <p class="fs-5 fw-semibold"><i class="bi bi-4-circle-fill me-1" style="color: #8a63f6 !important;"></i>Actualización constante de la base de oportunidades</p>
                                    </div>
                                    
                                </div>
                                        
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </article>

    <article>
            <div class="container-fluid px-0 mt-5" style=" min-height: 300px;">
                <div class="row justify-content-center align-items-center w-100 h-100">
                    <div class=" col-md-7 justify-content-center align-items-center nosotroscontainer">
                        <div class="d-flex flex-column justify-content-center align-items-center mt-3 nosotros text-center">
                            <h1 class="fw-bold mb-2">Políticas de Uso</h1>
                            <p class="fw-semibold">Siempre pensando en nuestros clientes. Lo siguiente esta prohibido:</p>
                                <div class="text-center nosotros">
                                    <p class="fs-5 fw-semibold"><i class="bi bi-1-circle-fill me-1" style="color: #8a63f6 !important;"></i>Lenguaje ofensivo, discriminatorio o de odio</p>
                                    <p class="fs-5 fw-semibold"><i class="bi bi-2-circle-fill me-1" style="color: #8a63f6 !important;"></i>Discriminación por género, raza, religión u orientación sexual</p>
                                    <p class="fs-5 fw-semibold"><i class="bi bi-3-circle-fill me-1" style="color: #8a63f6 !important;"></i>Salarios por debajo del mínimo legal</p>
                                    <p class="fs-5 fw-semibold"><i class="bi bi-4-circle-fill me-1" style="color: #8a63f6 !important;"></i>Condiciones laborales peligrosas</p>
                                </div>
                        </div>
                    </div>

                    <div class=" col-md-4 justify-content-center align-items-center">
                            <div id="videoCarousel" class="carousel slide w-100 h-100" data-bs-ride="carousel"> <!--Container del Carrusel-->
                                <div class="carousel-inner w-100 h-100" style="border-radius: 20px; border: 4px solid rgb(80, 28, 162) !important;">
                                    <div class="carousel-item active w-100 h-100">
                                        <video autoplay loop muted src="../assets/video/HG3.mp4"
                                            class="d-block w-100 h-100 object-fit-cover"
                                            style="max-height: 100%;"
                                            type="video/mp4"></video>
                                    </div>
                                    <div class="carousel-item w-100 h-100">
                                        <video autoplay loop muted src="../assets/video/HG4.mp4"
                                            class="d-block w-100 h-100 object-fit-cover"
                                            style="max-height: 100%;"
                                            type="video/mp4"></video>
                                    </div>
                                </div>
                            </div>   
                    </div>
                </div>
            </div>
    </article>

    

   <!--Final de la pagina-->
<footer class="mt-5" style="background-color: rgb(29, 29, 29);">
    <div class="container py-4">
       
        <div class="text-center text-white mt-3" style="font-size: 0.9rem;">
            &copy; 2025 Hiring Group. All rights reserved to <strong>Alejandro González</strong>.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</body>
</html>