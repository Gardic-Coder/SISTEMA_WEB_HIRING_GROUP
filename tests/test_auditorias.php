<?php
// test_auditoria.php

require_once __DIR__ . '/../utils/config.php';
require_once MODELS_DIR . 'Usuario.php';
require_once MODELS_DIR . 'RegistroInicioSesion.php';
require_once MODELS_DIR . 'ReporteActividad.php';

echo "=== Pruebas de Auditoría (RegistroInicioSesion y ReporteActividad) ===\n";

// Crear tablas necesarias
try {
    Usuario::createTable();
    echo "Tabla Usuario creada.\n";
    
    RegistroInicioSesion::createTable();
    echo "Tabla RegistroInicioSesion creada.\n";
    
    ReporteActividad::createTable();
    echo "Tabla ReporteActividad creada.\n";
} catch (Exception $e) {
    die("Error creando tablas: " . $e->getMessage());
}

// Crear usuario de prueba para RegistroInicioSesion
$userIdLogin = null;
try {
    $userIdLogin = Usuario::create([
        'nombre_usuario' => 'test_login',
        'contraseña' => password_hash('password123', PASSWORD_BCRYPT),
        'correo' => 'test_login@example.com',
        'tipo_usuario' => 'administrador'
    ]);
    echo "Usuario de prueba (login) creado con ID: $userIdLogin\n";
} catch (Exception $e) {
    die("Error creando usuario para login: " . $e->getMessage());
}

// Prueba: Registrar inicios de sesión
try {
    // Registro exitoso
    $log1 = RegistroInicioSesion::add([
        'usuario_id' => $userIdLogin,
        'fecha_hora' => date('Y-m-d H:i:s', strtotime('-1 hour')),
        'ip_usuario' => '192.168.1.100',
        'exito' => true
    ]);
    echo "Registro de inicio exitoso #1 creado\n";
    
    // Registro fallido
    $log2 = RegistroInicioSesion::add([
        'usuario_id' => $userIdLogin,
        'fecha_hora' => date('Y-m-d H:i:s', strtotime('-30 minutes')),
        'ip_usuario' => '192.168.1.100',
        'exito' => false
    ]);
    echo "Registro de inicio fallido creado\n";
    
    // Otro registro exitoso
    $log3 = RegistroInicioSesion::add([
        'usuario_id' => $userIdLogin,
        'fecha_hora' => date('Y-m-d H:i:s'),
        'ip_usuario' => '192.168.1.101',
        'exito' => true
    ]);
    echo "Registro de inicio exitoso #2 creado\n";
    
} catch (Exception $e) {
    die("Error registrando inicios: " . $e->getMessage());
}

// Prueba: Obtener registros por usuario
try {
    $logs = RegistroInicioSesion::getByUsuario($userIdLogin);
    echo "\nRegistros de inicio para usuario $userIdLogin:\n";
    foreach ($logs as $log) {
        echo " - ID: {$log['id']}, Fecha: {$log['fecha_hora']}, IP: {$log['ip_usuario']}, Éxito: " 
             . ($log['exito'] ? 'Sí' : 'No') . "\n";
    }
} catch (Exception $e) {
    echo "Error obteniendo registros: " . $e->getMessage() . "\n";
}

// Prueba: Intentos fallidos recientes
try {
    $ip = '192.168.1.100';
    $attempts = RegistroInicioSesion::getFailedAttempts($ip, 60); // Últimos 60 minutos
    echo "\nIntentos fallidos para IP $ip en los últimos 60 minutos: $attempts\n";
} catch (Exception $e) {
    echo "Error obteniendo intentos fallidos: " . $e->getMessage() . "\n";
}

// Prueba: Último inicio exitoso
try {
    $lastSuccess = RegistroInicioSesion::getLastSuccess($userIdLogin);
    if ($lastSuccess) {
        echo "\nÚltimo inicio exitoso:\n";
        echo " - ID: {$lastSuccess['id']}, Fecha: {$lastSuccess['fecha_hora']}, IP: {$lastSuccess['ip_usuario']}\n";
    } else {
        echo "\nNo se encontraron inicios exitosos\n";
    }
} catch (Exception $e) {
    echo "Error obteniendo último éxito: " . $e->getMessage() . "\n";
}

// Ahora pruebas para ReporteActividad
echo "\n=== Iniciando pruebas para ReporteActividad ===\n";

// Crear usuario de prueba para ReporteActividad
$userIdActivity = null;
try {
    $userIdActivity = Usuario::create([
        'nombre_usuario' => 'test_activity',
        'contraseña' => password_hash('password123', PASSWORD_BCRYPT),
        'correo' => 'test_activity@example.com',
        'tipo_usuario' => 'empresa'
    ]);
    echo "Usuario de prueba (actividad) creado con ID: $userIdActivity\n";
} catch (Exception $e) {
    die("Error creando usuario para actividad: " . $e->getMessage());
}

// Prueba: Registrar actividades
try {
    // Crear oferta
    $report1 = ReporteActividad::add([
        'usuario_id' => $userIdActivity,
        'accion' => 'crear',
        'entidad_afectada' => 'oferta_laboral',
        'fecha_hora' => date('Y-m-d H:i:s', strtotime('-2 days'))
    ]);
    echo "Reporte #1 creado (crear oferta)\n";
    
    // Modificar oferta
    $report2 = ReporteActividad::add([
        'usuario_id' => $userIdActivity,
        'accion' => 'modificar',
        'entidad_afectada' => 'oferta_laboral',
        'fecha_hora' => date('Y-m-d H:i:s', strtotime('-1 day'))
    ]);
    echo "Reporte #2 creado (modificar oferta)\n";
    
    // Postular a oferta
    $report3 = ReporteActividad::add([
        'usuario_id' => $userIdActivity,
        'accion' => 'postular',
        'entidad_afectada' => 'postulacion_123',
        'fecha_hora' => date('Y-m-d H:i:s')
    ]);
    echo "Reporte #3 creado (postular a oferta)\n";
    
} catch (Exception $e) {
    die("Error registrando actividades: " . $e->getMessage());
}

// Prueba: Obtener reportes por usuario
try {
    $reports = ReporteActividad::getByUsuario($userIdActivity);
    echo "\nReportes de actividad para usuario $userIdActivity:\n";
    foreach ($reports as $report) {
        echo " - ID: {$report['id']}, Acción: {$report['accion']}, Entidad: {$report['entidad_afectada']}, Fecha: {$report['fecha_hora']}\n";
    }
} catch (Exception $e) {
    echo "Error obteniendo reportes: " . $e->getMessage() . "\n";
}

// Prueba: Obtener todos los reportes con filtros
try {
    $filters = [
        'accion' => 'crear',
        'fecha_desde' => date('Y-m-d 00:00:00', strtotime('-3 days')),
        'fecha_hasta' => date('Y-m-d 23:59:59', strtotime('-1 day'))
    ];
    
    $reports = ReporteActividad::getAll($filters);
    echo "\nReportes filtrados (acción 'crear' en los últimos 3 días):\n";
    foreach ($reports as $report) {
        echo " - ID: {$report['id']}, Usuario: {$report['nombre_usuario']}, Acción: {$report['accion']}, Fecha: {$report['fecha_hora']}\n";
    }
} catch (Exception $e) {
    echo "Error obteniendo reportes filtrados: " . $e->getMessage() . "\n";
}

// Prueba adicional: Actividad de auditoría cruzada
try {
    echo "\n=== Prueba adicional: Actividad cruzada ===\n";
    
    // Crear un evento de actividad para el usuario de login
    $crossReport = ReporteActividad::add([
        'usuario_id' => $userIdLogin,
        'accion' => 'consultar',
        'entidad_afectada' => 'registros_auditoria',
        'fecha_hora' => date('Y-m-d H:i:s')
    ]);
    echo "Reporte cruzado creado (usuario de login consulta auditoría)\n";
    
    // Obtener todos los reportes sin filtros
    $allReports = ReporteActividad::getAll();
    echo "Total de reportes de actividad: " . count($allReports) . "\n";
    
    // Verificar que el reporte cruzado existe
    $found = false;
    foreach ($allReports as $report) {
        if ($report['id'] == $crossReport) {
            $found = true;
            echo " - Reporte cruzado encontrado: Usuario {$report['nombre_usuario']} realizó acción {$report['accion']} sobre {$report['entidad_afectada']}\n";
        }
    }
    
    if (!$found) {
        echo "✗ Reporte cruzado no encontrado\n";
    }
} catch (Exception $e) {
    echo "Error en prueba cruzada: " . $e->getMessage() . "\n";
}

// Limpieza
try {
    Usuario::delete($userIdLogin);
    echo "\nUsuario de prueba (login) eliminado\n";
    
    Usuario::delete($userIdActivity);
    echo "Usuario de prueba (actividad) eliminado\n";
} catch (Exception $e) {
    echo "Error limpiando: " . $e->getMessage() . "\n";
}

echo "=== Pruebas de auditoría completadas ===\n";
?>