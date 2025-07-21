 <?php
// public/views/auth/postulante/edicion.php
require_once __DIR__ . '/../../../../utils/config.php';
 ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuracion - Hiring Group</title>
    <link rel="stylesheet" href="../../../assets/css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/bootstrap-icons-1.13.1/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../assets/css/navbar.css">
    <link rel="stylesheet" href="../../../assets/css/Styles-usercontratado.css">
    <link rel="icon" href="../../../assets/images/Icono.png">
    <link rel="stylesheet" href="../../../assets/css/Styles-Configuracion-Perfil.css">
</head>




<!--Casi un copia y pega de Register-->
<body style="background-color: rgb(33, 37, 41)">

    <header style="position: fixed; width: 100%; z-index: 2; top: 0; left: 0;"><!--Barra de Navegacion-->
        <nav class="navbar navbar-expand-lg color_barra custom-border">
        <div class="container-fluid">
            <div class="px-5 py-1 animacionlogo">
                <a class="navbar-brand" href="<?= APP_URL ?>/dashboard"><img src="../../../assets/images/Icono.png" width="70" height="65"></a>
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
                    <a class="nav-link active px-lg-3" aria-current="page" href="Ofertas Laborales - Hiring Group (Contratado).html">
                        <i class="bi bi-search me-1"></i> Ver Ofertas
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active px-lg-3" aria-current="page" href="Recibo de Pago - Hiring Group (Contratado).html">
                        <i class="bi bi-clipboard-data me-1"></i> Mis Recibos
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active px-lg-3" aria-current="page" href="#">
                        <i class="bi bi-building-gear me-1"></i> Constancia
                    </a>
                    </li>
                </ul>
            </div>

            <!--Boton solo visible en movil-->
            <!--Segun si es contratado o no, aqui deberia redirigir a una pagina u otra-->

             <div class="d-lg-none mt-3 mb-3 py-2 px-3  animacionlogo">
                    <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline-sesion w-100 ">
                        <i class="bi bi-person-badge-fill me-1"></i> <?= htmlspecialchars($usuario['nombre_usuario']) ?>
                    </a>
            </div>

            <!--Boton solo visible en Desktop-->

            <div class="d-none d-lg-flex ms-lg-3 py-2 px-3 animacionlogo">
                    <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline-sesion w-100 ">
                        <i class="bi bi-person-badge-fill me-1"></i> <?= htmlspecialchars($usuario['nombre_usuario']) ?>

                    </a>
            </div>

        </div>
        </nav>
    </header>

    <div class="container-fluid d-flex justify-content-center align-items-center mb-4" style=" min-height: 165vh; padding-top: 140px;" id="main-container">
            <div class="text-center formulariocontainer mb-3" style="background-color: #3a3f44 !important;">
                <div class="d-flex justify-content-center mt-3">
                    <div class="rounded-circle border border-4  d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; overflow: hidden; background-color: rgb(95, 35, 192) !important; border-color: rgb(33, 37, 41) !important;">
                        <span class="fw-bold fs-4 text-dark">YOU</span>
                        <!-- La imagen real se cargaría aquí desde el backend -->
                        <img id="profile-image" src="" alt="Foto de perfil" 
                             class="w-100 h-100 d-none" style="object-fit: cover;">
                    </div>
                </div>
                <h1>Configuración</h1>
                <hr>
                
                
                <form id="profile-form" method="post" action="<?= APP_URL ?>/perfil/actualizar" enctype="multipart/form-data"  class="row g-3 needs-validation" novalidate>
                    <div class="col-md-6 mb-3">
                        <div class="mt-3">
                            <label for="nombres" class="form-label"><h5>Nombre <i class="bi bi-person-fill me-1"></i></h5></label>
                            <input type="text" value=""  class="form-control w-75 mx-auto" id="nombres" name="nombres" placeholder="Ingrese su Nombre"  minlength="3" maxlength="30" pattern="[A-Za-zÁ-ú\s]+"  required>
                        </div>

                        <div class="mt-3">
                            <label for="apellidos" class="form-label"><h5>Apellido <i class="bi bi-person-fill-check me-1"></i></h5></label>
                            <input type="text" value="" class="form-control w-75 mx-auto" id="apellidos" name="apellidos" placeholder="Ingrese su Apellido" minlength="3" maxlength="30" pattern="[A-Za-zÁ-ú\s]+" required>
                        </div>

                        <div class="mt-3">
                            <label for="cedula" class="form-label"><h5>Cedula de Identidad <i class="bi bi-person-vcard me-1"></i></h5> </label>
                            <input type="text" value="" class="form-control w-75 mx-auto" id="cedula" name="cedula" placeholder="V\E-XX.XXX.XXX" maxlength="12" pattern="[VE]-\d{2}.\d{3}.\d{3}" required>
                        </div>

                        <div class="mt-3">
                            <label for="telefono" class="form-label"><h5>Teléfono <i class="bi bi-telephone-fill me-1"></i></h5></label>
                            <input type="tel" value="" class="form-control w-75 mx-auto" id="telefono" name="telefono" placeholder="Ej. +58 XXX-XXXXXXX" minlength="10" maxlength="15" pattern="\+58[\s-]\d{3}[\s-]\d{7}" required>
                        </div>


                        <div class="mt-3">
                            <label for="genero" class="form-label"><h5>Genero <i class="bi bi-person-arms-up me-1"></i></h5> </label>
                            <select class="form-select w-75 mx-auto" id="genero" name="genero" required>
                                <option value="" selected disabled>Seleccione su Genero</option>
                                <option value="masculino">Hombre</option>
                                <option value="femenino">Mujer</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        
                    </div>

                    <div class="col-md-6 mb-3">

                        <div class="mt-3">
                            <label for="email" value="" class="form-label"><h5>Correo Electrónico <i class="bi bi-envelope-at-fill me-1"></i></h5> </label>
                            <input type="email" class="form-control w-75 mx-auto" id="email" name="email" placeholder="Ingrese su Correo Electrónico" minlength="5" maxlength="254" required>
                        </div>

                        <div class="mt-3">
                            <label for="estado_residencia" class="form-label"><h5>Estado de Residencia <i class="bi bi-house-fill me-1"></i></h5> </label>
                            <select class="form-select w-75 mx-auto" id="estado_residencia" name="estado_residencia" required>
                                <option value="" selected disabled>Seleccione el Estado en el que reside</option>
                                <option value="Amazonas">Amazonas</option>
                                <option value="Anzoátegui">Anzoátegui</option>
                                <option value="Apure">Apure</option>
                                <option value="Aragua">Aragua</option>
                                <option value="Barinas">Barinas</option>
                                <option value="Bolívar">Bolívar</option>
                                <option value="Carabobo">Carabobo</option>
                                <option value="Cojedes">Cojedes</option>
                                <option value="Delta Amacuro">Delta Amacuro</option>
                                <option value="Falcón">Falcón</option>
                                <option value="Guárico">Guárico</option>
                                <option value="Lara">Lara</option>
                                <option value="Mérida">Mérida</option>
                                <option value="Miranda">Miranda</option>
                                <option value="Monagas">Monagas</option>
                                <option value="Nueva Esparta">Nueva Esparta</option>
                                <option value="Portuguesa">Portuguesa</option>
                                <option value="Sucre">Sucre</option>
                                <option value="Táchira">Táchira</option>
                                <option value="Trujillo">Trujillo</option>
                                <option value="Yaracuy">Yaracuy</option>
                                <option value="Zulia">Zulia</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <label for="ciudad_residencia" class="form-label"><h5>Ciudad de Residencia <i class="bi bi-house-gear-fill me-1"></i></h5> </label>
                            <input type="text" class="form-control w-75 mx-auto" id="ciudad_residencia" name="ciudad_residencia" placeholder="Ingrese la Ciudad en el que Reside" minlength="3" maxlength="50" required>
                        </div>

                        <div class="mt-3">
                            <label for="fecha_nacimiento" class="form-label"><h5>Fecha de Nacimiento <i class="bi bi-cake2-fill me-1"></i></h5> </label>
                            <input type="date" class="form-control w-75 mx-auto" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        </div>

                         <div class="mt-3">
                            <label for="tipo_sangre" class="form-label"><h5>Tipo de Sangre <i class="bi bi-droplet-fill me-1"></i></h5> </label>
                            <select class="form-select w-75 mx-auto" id="tipo_sangre" name="tipo_sangre" required>
                                <option value="" selected disabled>Seleccione su tipo de sangre</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-12 mb-3">
                        <hr>
                        <h1 class="text-center contrasena">Curriculum</h1>  
                        <hr>
                        
                        <!--Curriculum Actual-->
                        

                        <div class="mt-3">
                            <?php if (!empty($cvUrl)): ?>
                                <a href="<?= htmlspecialchars($cvUrl) ?>" target="_blank" class="btn btn-outline-blueviolet btn-sm">
                                    <i class="bi bi-download"></i> Descargar Curriculum actual
                                </a>
                            <?php else: ?>
                                <p class="text-muted">No se ha subido ningún currículum todavía.</p>
                            <?php endif; ?>
                            <!--<a href="#" id="current-cv-link" target="_blank" class="btn btn-outline-blueviolet btn-sm"><i class="bi bi-download"></i> Descargar Curriculum actual</a>-->
                        </div>

                        <div class="mt-3">
                            <label for="curriculum" class="btn btn-outline-blueviolet btn-sm w-100"> <i class="bi bi-upload"></i> Subir nuevo CV (PDF)</label>
                                <input type="file" id="curriculum" name="curriculum" accept=".pdf" class="d-none">
                        </div>
                    </div>


                    <div class="col-12 mb-3">

                        <hr>
                        <h1 class="text-center contrasena">Cambiar Contraseña</h1>   
                        
                        <hr>
                        <div class="mt-3">
                            <label for="actual_password" class="form-label"><h5>Contraseña Actual <i class="bi bi-file me-1"></i></h5> </label>
                            <input type="password" value="" class="form-control w-75 mx-auto" id="actual_password" name="actual_password" required>
                        </div>

                         <div class="mt-3">
                            <label for="new_password" class="form-label"><h5>Nueva Contraseña </h5></label>
                            <input type="password" value="" class="form-control w-75 mx-auto" id="new_password" name="new_password" minlength="8" maxlength="32" required>
                        </div>

                         <div class="mt-3">
                            <label for="Confirm_password" class="form-label"><h5>Confirmar Contraseña <i class="bi bi-file-plus me-1"></i></h5></label>
                            <input type="password" value="" class="form-control w-75 mx-auto" id="confirm_password" name="confirm_password" minlength="8" maxlength="32" required oninput="checkPasswordMatch()">
                        </div>
                        <hr>
                    </div>

                    <div class="col-md-6 justify-content-center">
                        <div class="d-flex justify-content-center">
                           <a href="<?= APP_URL ?>/dashboard"><button type="button" class="btn btn-outline-blueviolet py-2 px-4"> <i class="bi bi-arrow-left"></i> Cancelar</button></a> 
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
            const password = document.getElementById("new_password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
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
            if (document.getElementById("new_password").value !== 
                document.getElementById("password2").value) {
                e.preventDefault();
                document.getElementById("confirm_password").focus();
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