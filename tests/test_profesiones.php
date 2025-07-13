<?php
/**
 * testProfesionFormacionExperiencia.php - Pruebas para los modelos de profesión, formación y experiencia
 */

require_once __DIR__ . '/../models/ProfesionUsuario.php';
require_once __DIR__ . '/../models/FormacionAcademica.php';
require_once __DIR__ . '/../models/ExperienciaLaboral.php';
require_once __DIR__ . '/../models/Usuario.php';

echo "=== PRUEBAS PROFESIÓN, FORMACIÓN Y EXPERIENCIA ===\n";

// Crear tablas
ProfesionUsuario::createTable();
FormacionAcademica::createTable();
ExperienciaLaboral::createTable();
Usuario::createTable();

// Crear usuario de prueba
$usuarioId = Usuario::create([
    'nombre_usuario' => 'test_profesional',
    'contraseña' => password_hash('test123', PASSWORD_BCRYPT),
    'correo' => 'test_profesional@example.com',
    'tipo_usuario' => 'postulante'
]);

// Pruebas de Profesión
try {
    echo "\n--- Pruebas de Profesión ---\n";
    
    $profesionId1 = ProfesionUsuario::add($usuarioId, 'Ingeniero de Sistemas');
    $profesionId2 = ProfesionUsuario::add($usuarioId, 'Desarrollador Web');
    
    $profesiones = ProfesionUsuario::getByUsuario($usuarioId);
    echo "Profesiones del usuario: " . print_r($profesiones, true) . "\n";
    
    // Actualizar una profesión
    ProfesionUsuario::update($profesionId1, 'Ingeniero en Computación');
    
    // Eliminar una profesión
    ProfesionUsuario::delete($profesionId2);
    
    echo "Profesiones después de actualizar/eliminar: " . print_r(ProfesionUsuario::getByUsuario($usuarioId), true) . "\n";
} catch (Exception $e) {
    echo "Error en pruebas de Profesión: " . $e->getMessage() . "\n";
}

// Pruebas de Formación Académica
try {
    echo "\n--- Pruebas de Formación Académica ---\n";
    
    $formacionId1 = FormacionAcademica::add([
        'usuario_id' => $usuarioId,
        'institucion' => 'Universidad Central',
        'carrera' => 'Ingeniería de Computación',
        'nivel' => 'licenciatura',
        'fecha_egreso' => '2015-07-15'
    ]);
    
    $formacionId2 = FormacionAcademica::add([
        'usuario_id' => $usuarioId,
        'institucion' => 'Instituto Tecnológico',
        'carrera' => 'Desarrollo Web',
        'nivel' => 'tecnico',
        'fecha_egreso' => '2012-06-20'
    ]);
    
    $formaciones = FormacionAcademica::getByUsuario($usuarioId);
    echo "Formación académica del usuario: " . print_r($formaciones, true) . "\n";
    
    // Actualizar una formación
    FormacionAcademica::update($formacionId1, ['institucion' => 'Universidad Central de Venezuela']);
    
    // Eliminar una formación
    FormacionAcademica::delete($formacionId2);
    
    echo "Formación después de actualizar/eliminar: " . print_r(FormacionAcademica::getByUsuario($usuarioId), true) . "\n";
} catch (Exception $e) {
    echo "Error en pruebas de Formación Académica: " . $e->getMessage() . "\n";
}

// Pruebas de Experiencia Laboral
try {
    echo "\n--- Pruebas de Experiencia Laboral ---\n";
    
    $expId1 = ExperienciaLaboral::add([
        'usuario_id' => $usuarioId,
        'empresa' => 'Tech Solutions',
        'cargo' => 'Desarrollador Senior',
        'fecha_inicio' => '2018-03-01',
        'fecha_fin' => '2022-12-15',
        'descripcion' => 'Desarrollo de aplicaciones empresariales'
    ]);
    
    $expId2 = ExperienciaLaboral::add([
        'usuario_id' => $usuarioId,
        'empresa' => 'Web Innovators',
        'cargo' => 'Desarrollador Junior',
        'fecha_inicio' => '2015-08-10',
        'fecha_fin' => '2018-02-28',
        'descripcion' => 'Desarrollo de sitios web'
    ]);
    
    $experiencias = ExperienciaLaboral::getByUsuario($usuarioId);
    echo "Experiencia laboral del usuario: " . print_r($experiencias, true) . "\n";
    
    // Actualizar una experiencia
    ExperienciaLaboral::update($expId1, ['cargo' => 'Líder de Desarrollo']);
    
    // Eliminar una experiencia
    ExperienciaLaboral::delete($expId2);
    
    echo "Experiencia después de actualizar/eliminar: " . print_r(ExperienciaLaboral::getByUsuario($usuarioId), true) . "\n";
} catch (Exception $e) {
    echo "Error en pruebas de Experiencia Laboral: " . $e->getMessage() . "\n";
}

// Limpieza
Usuario::delete($usuarioId);

echo "\n=== PRUEBAS COMPLETADAS ===\n";
?>