<?php
// public/views/auth/registroEmpresa.php
require_once __DIR__ . '/../../../utils/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empresa - Hiring Group</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-icons-1.13.1/bootstrap-icons.css">
    <link rel="icon" href="../../assets/images/Icono.png">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="stylesheet" href="../../assets/css/Styles-usercontratado.css">
    <link rel="stylesheet" href="../../assets/css/Styles-Configuracion-Perfil.css">
</head>




<!--Casi un copia y pega de Register-->
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

    <div class="container-fluid d-flex justify-content-center align-items-center mb-4" style=" min-height: 90vh; padding-top: 140px;" id="main-container">
            <div class="text-center formulariocontainer mb-3" style="background-color: #3a3f44 !important;">
                <h1 class="mt-5">Creación de una Empresa</h1>
                <hr>
                
                
                <form id="profile-form" class="row g-3 needs-validation" method="post" action="<?= APP_URL ?>/registro/empresa" novalidate>
                    <div class="col-md-6 mb-3">
                        <div class="mt-3">
                            <label for="razon-social" class="form-label"><h5>Nombre de la Empresa <i class="bi bi-building-gear me-1"></i></h5></label>
                            <input type="text" class="form-control w-75 mx-auto" id="razon-social" name="razon-social" placeholder="¿Como se Identifica?"  minlength="3" maxlength="30"  required>
                        </div>

                        <div class="mt-3">
                            <label for="sector" class="form-label"><h5>Sector Laboral <i class="bi bi-building-fill-exclamation me-1"></i></h5></label>
                            <input type="text"  class="form-control w-75 mx-auto" id="sector" name="sector" placeholder="Area Laboral Principal"  minlength="3" maxlength="30"  required>
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">
                        
                        <div class="mt-3">
                            <label for="phone" class="form-label"><h5>Teléfono de Contacto <i class="bi bi-telephone-fill me-1"></i></h5></label>
                            <input type="tel" class="form-control w-75 mx-auto" id="phone" name="phone" placeholder="Ej. +58 XXX-XXXXXXX" minlength="10" maxlength="15" pattern="\+58[\s-]\d{3}[\s-]\d{7}" required>
                        </div>
                        
                        <div class="mt-3">
                            <label for="rif" class="form-label"> <h5>RIF de la Empresa <i class="bi bi-building me-1"></i></h5></label>
                            <input type="text" class="form-control w-75 mx-auto" id="rif" name="rif" placeholder="Ej. J-12345678-9 o G-98765432-1" minlength="11"  maxlength="12"pattern="[JGVEPjvgep]-[0-9]{8}-[0-9]{1}" title="Formato: Letra (J, G, V, E, P) - 8 dígitos - 1 dígito. Ej: J-12345678-9"  required>
                        </div>
                    </div>


                    <hr>

                    <div class="col-12 mb-3">
                        <h1 class="text-center contrasena">Datos Principales del Perfil</h1>   
                        
                        <hr>
                        <div class="mt-3">
                            <label for="correo" class="form-label">
                            <h5>Correo Electrónico <i class="bi bi-envelope-at-fill me-1"></i></h5></label>
                            <input type="email" class="form-control w-75 mx-auto" id="correo" name="correo" placeholder="correo@ejemplo.com" minlength="5" maxlength="254" required>
                        </div>


                        <div class="mt-3">
                            <label for="user" class="form-label"><h5>Usuario <i class="bi bi-person-badge-fill me-1"></i></h5> </label>
                            <input type="text" class="form-control w-75 mx-auto" id="user" name="user" placeholder="Ingrese su Usuario" minlength="3" maxlength="30"  required>
                        </div>

                        <div class="mt-3">
                            <label for="new-password" class="form-label"><h5>Contraseña <i class="bi bi-card-checklist me-1"></i> </h5></label>
                            <input type="password" value="" class="form-control w-75 mx-auto" id="new-password" name="new-password" placeholder="Ingrese su Contraseña" minlength="8" maxlength="32" required>
                        </div>

                         <div class="mt-3">
                            <label for="Confirm-password" class="form-label"><h5>Confirmar Contraseña <i class="bi bi-card-heading me-1"></i> </h5></label>
                            <input type="password" value="" class="form-control w-75 mx-auto" id="confirm-password" placeholder="***************"  minlength="8" maxlength="32" required oninput="checkPasswordMatch()">
                        </div>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex justify-content-center">
                           <a href="#"><button type="button" class="btn btn-outline-blueviolet py-2 px-4"> <i class="bi bi-arrow-left"></i> Cancelar</button></a> 
                        </div>
                    </div>

                    <div class="col-md-6 justify-content-center">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-outline-blueviolet py-2 px-4">
                                <i class="bi bi-save"></i> Guardar
                            </button>
                        </div>
                    </div>

                    <hr class="my-4">

                    
                </form>
            </div>


        </div>

        <!--Funcion CheckPasswordMatch-->
    <script>
        function checkPasswordMatch() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("password2").value;
            if (password !== confirmPassword) {
                confirmPassword.setCustomValidity("Las contraseñas no coinciden");
                confirmPassword.classList.add('is-invalid');
            } else {
                confirmPassword.setCustomValidity("");
                confirmPassword.classList.remove('is-invalid');
            }
             confirmPassword.reportValidity();
        }

        // Validación al enviar 
        document.querySelector('form').addEventListener('submit', function(e) {
            if (document.getElementById("password").value !== 
                document.getElementById("password2").value) {
                e.preventDefault();
                document.getElementById("password2").focus();
            }
        });
    </script>
    








       <!--Final de la pagina-->
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