<?php
// public/views/dashboard/postulante.php
require_once __DIR__ . '/../../../utils/config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Hiring Group</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-icons-1.13.1/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="stylesheet" href="../../assets/css/Styles-usercontratado.css">
    <link rel="icon" href="../../assets/images/Icono.png">
</head>
<body style="background-color: rgb(33, 37, 41)">
    <header style="position: fixed; width: 100%; z-index: 2; top: 0; left: 0;"><!--Barra de Navegacion-->
        <nav class="navbar navbar-expand-lg color_barra custom-border">
        <div class="container-fluid">
            <div class="px-5 py-1 animacionlogo">
                <a class="navbar-brand" href="#"><img src="../../assets/images/Icono.png" width="70" height="65"></a>
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
                        <i class="bi bi-search me-1"></i> Ver Ofertas
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active px-lg-3" aria-current="page" href="#">
                        <i class="bi bi-pencil-square me-1"></i> Postulaciones
                    </a>
                    </li>
                </ul>
            </div>

            <!--Boton solo visible en movil-->

             <div class="d-lg-none mt-3 mb-3 py-2 px-3  animacionlogo">
                    <a href="<?= APP_URL ?>/perfil/postulante/editar" class="btn btn-outline-sesion w-100 ">
                        <i class="bi bi-person-badge-fill me-1"></i><?= htmlspecialchars($usuario['nombre_usuario']) ?>
                    </a>
            </div>

            <!--Boton solo visible en Desktop-->

            <div class="d-none d-lg-flex ms-lg-3 py-2 px-3 animacionlogo">
                    <a href="<?= APP_URL ?>/perfil/postulante/editar" class="btn btn-outline-sesion w-100 ">
                        <i class="bi bi-person-badge-fill me-1"></i><?= htmlspecialchars($usuario['nombre_usuario']) ?>

                    </a>
            </div>

        </div>
        </nav>
    </header>

    <!--Parte principal del Perfil-->

    <main class="container-fluid mt-5 px-0" style="height: auto; padding-top: 90px;">
    <div class="row align-items-center" style="height: 100%; background-color: blueviolet;">
        <!-- Columna izquierda con nombre y foto -->
        <div class="col-12 text-center py-3 px-5 textocentral">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center">
                <!-- Foto de perfil -->
                <div class="me-md-4 mb-3 mb-md-0 position-relative">
                    <div class="rounded-circle border border-4  d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; overflow: hidden; background-color: rgb(95, 35, 192) !important; border-color: rgb(33, 37, 41) !important;">
                        <span class="fw-bold fs-4 text-dark">YOU</span>
                        <!-- La imagen real se cargaría aquí desde el backend -->
                        <img id="profile-image" src="" alt="Foto de perfil" 
                             class="w-100 h-100 d-none" style="object-fit: cover;">
                    </div>
                </div>
                
                <!-- Texto de bienvenida -->
                <div class=" text-center textocentral px-1">
                    <h1 class="text-center text-white fw-bold">Bienvenido, <?= htmlspecialchars($usuario['nombre_usuario']) ?></h1>
                    <p class="text-center text-white fw-semibold" style="font-size: large;">Username Job goes here Juan</p>
                </div>
            </div>
        </div>
    </div>
</main>

    <!--Informacion Personal-->
    <div class=" row mt-5 justify-content-center mx-5 gx-5">
        <div class="col-lg-5 col-md-6 mb-4">
            <div class="card h-100 custom-card ">
                <div class="card-body">
                    <h5> <i class="bi bi-geo-alt text-primary me-2"></i>Información de Contacto</h5>
                    <div class="row">
                        <div class="col-md">
                            <h6>Cedula de Identidad</h6><p id="userCI" class="mb-0 fw-bold"><?= htmlspecialchars($postulante['cedula']) ?></p>
                            <hr>
                            <h6>Fecha de Nacimiento</h6><p id="userBirth" class="mb-0 fw-bold"><?= htmlspecialchars($postulante['fecha_nacimiento']) ?></p>
                            <hr>
                            <h6>Genero</h6><p id="userGender" class="mb-0 fw-bold"><?= htmlspecialchars($postulante['genero']) ?></p> 
                            <hr>
                            <h6>Telefono</h6><p id="userPhone" class="mb-0 fw-bold"><?= htmlspecialchars($telefonos['telefono']) ?></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-md-6 mb-4">
            <div class="card h-100 custom-card " >
                <div class="card-body">
                    <h5 class="card-title"> <i class="bi bi-briefcase text-primary me-2"></i>Información Laboral</h5>
                    <div class="row">
                        <div class="col-md">
                            <h6>Correo Electrónico</h6><p id="userEmail" class="mb-0 fw-bold"><?= htmlspecialchars($usuario['correo']) ?></p>
                            <hr>
                            <h6>Estado de Residencia</h6><p id="userState" class="mb-0 fw-bold"><?= htmlspecialchars($postulante['estado_residencia']) ?></p>
                            <hr>
                            <h6>Ciudad de Residencia</h6><p id="userPlace" class="mb-0 fw-bold"><?= htmlspecialchars($postulante['ciudad_residencia']) ?></p> 
                            <hr>
                            <h6>Tipo de Sangre</h6><p id="userBlood" class="mb-0 fw-bold"><?= htmlspecialchars($postulante['tipo_sangre']) ?></p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>



   <!--Final de la pagina-->
<div style="margin-bottom: 63px;"></div>
    <footer style="background-color: rgb(29, 29, 29);">
        <div class="container py-4">
            <div class="text-center text-white mt-3" style="font-size: 0.9rem;">
                &copy; 2025 Hiring Group. All rights reserved to <strong>Alejandro González</strong>.
            </div>
        </div>
    </footer>

    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>