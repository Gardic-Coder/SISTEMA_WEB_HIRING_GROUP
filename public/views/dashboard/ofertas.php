<?php
// public/views/dashboard/ofertas.php
require_once __DIR__ . '/../../../utils/config.php';
require_once MODELS_DIR . 'Empresa.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas Laborales - Hiring Group</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-icons-1.13.1/bootstrap-icons.css">
    <link rel="icon" href="../../assets/images/Icono.png">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="stylesheet" href="../../assets/css/Styles-usercontratado.css">
    <link rel="stylesheet" href="../../assets/css/Tabla.css">

</head>
<body style="background-color: rgb(33, 37, 41)">
     <header style="position: fixed; width: 100%; z-index: 2; top: 0; left: 0;"><!--Barra de Navegacion-->
        <nav class="navbar navbar-expand-lg color_barra custom-border">
        <div class="container-fluid">
            <div class="px-5 py-1 animacionlogo">
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
                    <a class="nav-link active px-lg-3" aria-current="page" href="#">
                        <i class="bi bi-search me-1"></i> Ver Ofertas
                    </a>
                    </li>
                    <?php if($tipoUsuario == 'postulante'): ?>
                        <?php if ($postulante['contratado'] == 1): ?>
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
                        <?php else: ?>
                            <!-- Mostrar cuando NO está contratado -->
                            <li class="nav-item">
                            <a class="nav-link active px-lg-3" aria-current="page" href="<?= APP_URL ?>/postulaciones">
                                <i class="bi bi-pencil-square me-1"></i> Postulaciones
                            </a>
                            </li>
                        <?php endif; ?>
                    <?php elseif($tipoUsuario == 'hiring_group'): ?>
                        <li class="nav-item">
                        <a class="nav-link active px-lg-3" aria-current="page" href="#">
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
                    <?php endif; ?>
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
                </div>
            </div>
        </div>
    </div>
    </main>

    
    <div class="container px-5 Pago mt-5 mb-5"> 
        <div class="container px-5 w-100">
            <div class="row justify-content-center align-items-center mt-4">
                <div class="w-100">
                    <div class="text-center mb-3 p-3 rounded-bottom titulo">
                        <h1 class="mb-0" style="color: white; text-shadow: (5px 5px 5px black) ;">Ofertas Disponibles</h1> 
                    </div>
                    <?php if($tipoUsuario == 'postulante'): ?>
                        <div class="text-center mb-3 p-3">
                            <p class="fw-bold" style="color: rgb(33, 37, 41)">¡Asegurate que tu Perfil este actualizado antes de continuar!</p>
                            <a href="<?= APP_URL ?>/perfil/postulante/editar" class="btn btn-outline-blueviolet">Edita tu Perfil</a> 
                        </div>
                    <?php endif; ?>
                </div> 
            </div>
        </div>

        <hr>

        <!-- Filtros -->
        <div class="filter-section">
            <div class="row g-5 justify-content-center">
                <div class="col-md-3">
                    <label for="knowledge" class="form-label">Area de Conocimiento <i class="bi bi-patch-question me-3"></i></label>
                    <select id="knowledge" class="form-select">
                        <option value="">Todos</option>
                        <option value="weekly">Semanal</option>
                        <option value="biweekly">Quincenal</option>
                        <option value="monthly">Mensual</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="state" class="form-label">Ubicacion <i class="bi bi-geo-alt me-1"></i></label>
                    <select id="state" class="form-select">
                                <option value="" selected>Todos</option>
                                <option value="Amazonas">Amazonas</option>
                                <option value="Anzoategui">Anzoátegui</option>
                                <option value="Apure">Apure</option>
                                <option value="Aragua">Aragua</option>
                                <option value="Barinas">Barinas</option>
                                <option value="Bolívar">Bolívar</option>
                                <option value="Carabobo">Carabobo</option>
                                <option value="Cojedes">Cojedes</option>
                                <option value="Delta Amacuro">Delta Amacuro</option>
                                <option value="Falcón">Falcón</option>
                                <option value="Guarico">Guárico</option>
                                <option value="Lara">Lara</option>
                                <option value="Merida">Mérida</option>
                                <option value="Miranda">Miranda</option>
                                <option value="Monagas">Monagas</option>
                                <option value="Nueva Esparta">Nueva Esparta</option>
                                <option value="Portuguesa">Portuguesa</option>
                                <option value="Sucre">Sucre</option>
                                <option value="Tachira">Táchira</option>
                                <option value="Trujillo">Trujillo</option>
                                <option value="Yaracuy">Yaracuy</option>
                                <option value="Zulia">Zulia</option>
                            </select>
                </div>
                
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-outline-blueviolet w-100" onclick="filterOffers()">
                        <i class="bi bi-funnel-fill"></i> Filtrar
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Tabla de recibos -->
        <div class="table-responsive">
            <table class="table table-striped table-hover receipt-table">
                <thead>
                    <tr>
                        <th>ID Oferta</th>
                        <th>Profesíon</th>
                        <th>Cargo</th>
                        <th>Descripción</th>
                        <th>Salario</th>
                        <th>Modalidad</th>
                        <th>Estado</th>
                        <th>Ciudad</th>
                        <th>Estatus</th>
                        <th>Empresa</th>
                        <th>Fecha</th>
                        <?php if($tipoUsuario == 'postulante' && $postulante['contratado'] == 0): ?>
                            <th>Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="receiptsTableBody">
                    <!-- Datos cargados por JavaScript -->
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center" id="pagination">
                <!-- Generado por JavaScript -->
            </ul>
        </nav>

       <hr>
  
    </div>


    
    <script>
        //No se absultamente nada de JavaScript
        // Datos de ejemplo para ofertas de trabajo (ahora más completos)
/*const sampleOffers = [
    { 
        id: 'OF-1001', 
        profesion: 'Ingeniero de Sistemas', 
        cargo: 'Desarrollador Frontend', 
        descripcion: 'Desarrollo de interfaces con React y Bootstrap', 
        salario: '$2,500 - $3,000', 
        modalidad: 'Remoto', 
        estado: 'Distrito Capital', 
        ciudad: 'Caracas',
        estatus: 'Activa', 
        empresa: 'Tech Solutions', 
        fecha: '2023-05-15' 
    },
    { 
        id: 'OF-1002', 
        profesion: 'Diseñador Gráfico', 
        cargo: 'Diseñador UX/UI', 
        descripcion: 'Diseño de interfaces y experiencia de usuario', 
        salario: '$2,000 - $2,500', 
        modalidad: 'Híbrido', 
        estado: 'Miranda', 
        ciudad: 'Los Teques',
        estatus: 'Activa', 
        empresa: 'Creative Agency', 
        fecha: '2023-05-18' 
    },
    { 
        id: 'OF-1003', 
        profesion: 'Contador Público', 
        cargo: 'Auditor Senior', 
        descripcion: 'Auditoría de estados financieros', 
        salario: '$2,800 - $3,200', 
        modalidad: 'Presencial', 
        estado: 'Carabobo', 
        ciudad: 'Valencia',
        estatus: 'Activa', 
        empresa: 'Finance Corp', 
        fecha: '2023-05-20' 
    }
];*/

    const tipoUsuario = <?= json_encode($tipoUsuario) ?>;
    const contratado = <?= json_encode($postulante['contratado'] ?? 0) ?>;

    const ofertas = <?= json_encode(array_map(function($oferta) {
        return [
            'id' => 'OF-' . str_pad($oferta['id'], 4, '0', STR_PAD_LEFT),
            'profesion' => $oferta['profesion'],
            'cargo' => $oferta['cargo'],
            'descripcion' => $oferta['descripcion'],
            'salario' => '$ ' . number_format($oferta['salario'], 2, ',', '.'),
            'modalidad' => $oferta['modalidad'],
            'estado' => $oferta['estado'],
            'ciudad' => $oferta['ciudad'],
            'estatus' => $oferta['estatus'] ? 'Activa' : 'Inactiva',
            'empresa' => Empresa::getById($oferta['empresa_id'])['nombre_empresa'] ?? 'Empresa desconocida',
            'fecha' => date('Y-m-d', strtotime($oferta['fecha_creacion']))
        ];
    }, $ofertas)) ?>;

    //loadOffers(ofertas);


let currentPage = 1;
const itemsPerPage = 10;

// Función para cargar ofertas con botones de postulación
function loadOffers(offers = ofertas) {
    const tbody = document.getElementById('receiptsTableBody');
    tbody.innerHTML = '';
    
    const startIndex = (currentPage - 1) * itemsPerPage;
    const paginatedOffers = offers.slice(startIndex, startIndex + itemsPerPage);
    
    if (paginatedOffers.length === 0) {
        const row = document.createElement('tr');
        row.innerHTML = `<td colspan="12" class="text-center py-4 text-muted">No se encontraron ofertas</td>`;
        tbody.appendChild(row);
        return;
    }
    //Aqui muestro en pantalla cada uno de los Registros, eso incluye el boton Postularse
    paginatedOffers.forEach(offer => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${offer.id}</td>
            <td>${offer.profesion}</td>
            <td>${offer.cargo}</td>
            <td class="text-truncate" style="max-width: 200px;">${offer.descripcion}</td>
            <td>${offer.salario}</td>
            <td>${offer.modalidad}</td>
            <td>${offer.estado}</td>
            <td>${offer.ciudad}</td>
            <td><span class="badge ${offer.estatus === 'Activa' ? 'bg-success' : 'bg-secondary'}">${offer.estatus}</span></td>
            <td>${offer.empresa}</td>
            <td>${offer.fecha}</td>
            <td>
            <?php if($tipoUsuario == 'postulante' && $postulante['contratado'] == 0): ?>
                <button class="btn btn-sm btn-outline-blueviolet btn-postular" 
                    data-offer-id="${offer.id}">
                    <i class="bi bi-send-check"></i> Postularse
                </button>
            <?php endif; ?>
            </td>
        `;
        tbody.appendChild(row);
    });
    
    // Agregar event listeners a los nuevos botones
    document.querySelectorAll('.btn-postular').forEach(btn => {
        btn.addEventListener('click', handlePostulacion);
    });
    
    setupPagination(offers.length);
}

function handlePostulacion(event) {
    console.log("Botón clickeado");

    const button = event.currentTarget;
    const ofertaId = button.getAttribute('data-offer-id');

    // Animación: deshabilitar y mostrar spinner
    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...';

    // Crear formulario oculto dinámicamente
    const form = document.createElement('form');
    form.method = 'post';
    form.action = '<?= APP_URL ?>/postular';

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'oferta_id';
    input.value = ofertaId;
    form.appendChild(input);

    document.body.appendChild(form);

    // Opcional: mostrar toast antes de enviar
    showToast('Enviando postulación...');

    form.submit();
}

// Función para mostrar notificación toast
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 p-3';
    toast.innerHTML = `
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Hiring Group</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    document.body.appendChild(toast);
    
    // Eliminar el toast después de 5 segundos
    setTimeout(() => {
        toast.remove();
    }, 5000);
}

// Configurar paginación (mejorada con estilos)
function setupPagination(totalItems) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';
    
    const pageCount = Math.ceil(totalItems / itemsPerPage);
    
    // Botón Anterior
    const prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<a class="page-link" href="#" onclick="changePage(${currentPage - 1})">&laquo;</a>`;
    pagination.appendChild(prevLi);
    
    // Páginas
    const maxVisiblePages = 5; // Máximo de páginas visibles
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages/2));
    let endPage = Math.min(pageCount, startPage + maxVisiblePages - 1);
    
    // Ajustar si estamos cerca del final
    if(endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }
    
    // Primera página (si no está visible)
    if(startPage > 1) {
        const li = document.createElement('li');
        li.className = 'page-item';
        li.innerHTML = `<a class="page-link" href="#" onclick="changePage(1)">1</a>`;
        pagination.appendChild(li);
        if(startPage > 2) {
            const dots = document.createElement('li');
            dots.className = 'page-item disabled';
            dots.innerHTML = `<span class="page-link">...</span>`;
            pagination.appendChild(dots);
        }
    }
    
    // Páginas visibles
    for (let i = startPage; i <= endPage; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" style="background-color: blueviolet" href="#" onclick="changePage(${i})">${i}</a>`;
        pagination.appendChild(li);
    }
    
    // Última página (si no está visible)
    if(endPage < pageCount) {
        if(endPage < pageCount - 1) {
            const dots = document.createElement('li');
            dots.className = 'page-item disabled';
            dots.innerHTML = `<span class="page-link">...</span>`;
            pagination.appendChild(dots);
        }
        const li = document.createElement('li');
        li.className = 'page-item';
        li.innerHTML = `<a class="page-link" href="#" onclick="changePage(${pageCount})">${pageCount}</a>`;
        pagination.appendChild(li);
    }
    
    // Botón Siguiente
    const nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentPage === pageCount ? 'disabled' : ''}`;
    nextLi.innerHTML = `<a class="page-link" href="#" onclick="changePage(${currentPage + 1})">&raquo;</a>`;
    pagination.appendChild(nextLi);
}

// Cambiar página
function changePage(page) {
    currentPage = page;
    loadOffers();
    window.scrollTo(0, 0);
}


// Función para normalizar texto (quitar acentos y convertir a minúsculas)
function normalizeText(text) {
    return text.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
}

// Función principal para filtrar las ofertas
function filterOffers() {
    // 1. Obtener los valores seleccionados en los filtros
    const areaConocimiento = document.getElementById('knowledge').value;
    const ubicacion = document.getElementById('state').value;
    
    // 2. Filtrar las ofertas
    const filtered = ofertas.filter(offer => {
        // Filtro por área de conocimiento
        const matchesArea = !areaConocimiento || 
                          normalizeText(offer.profesion).includes(normalizeText(areaConocimiento)) || 
                          normalizeText(offer.cargo).includes(normalizeText(areaConocimiento)) ||
                          normalizeText(offer.descripcion).includes(normalizeText(areaConocimiento));
        
        // Filtro por ubicación (estado o ciudad)
        const matchesUbicacion = !ubicacion || 
                               normalizeText(offer.estado) === normalizeText(ubicacion) ||
                               normalizeText(offer.ciudad) === normalizeText(ubicacion);
        
        // La oferta debe cumplir ambos filtros
        return matchesArea && matchesUbicacion;
    });
    
    // 3. Recargar la tabla con los resultados filtrados
    currentPage = 1;
    loadOffers(filtered);
}

// Modificación necesaria en la inicialización
document.addEventListener('DOMContentLoaded', () => {
    loadOffers();
    
    // Asignar el evento de filtrado al botón correcto
    document.querySelector('.btn-outline-blueviolet').addEventListener('click', filterOffers);
});

// Inicializar
document.addEventListener('DOMContentLoaded', () => {
    loadOffers();
    
    // Asignar el evento de filtrado al botón
    document.querySelector('.btn-outline-blueviolet').addEventListener('click', filterOffers);
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


   



</body>
</html>