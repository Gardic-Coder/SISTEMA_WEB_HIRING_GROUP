<?php
require_once __DIR__ . '/../models/Empresa.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/UsuarioPostulante.php';
require_once __DIR__ . '/../models/OfertaLaboral.php';
require_once __DIR__ . '/../models/Postulacion.php';

echo "=== Prueba de Postulacion ===\n";

// 1. Crear tablas
Empresa::createTable();
Usuario::createTable();
UsuarioPostulante::createTable();
OfertaLaboral::createTable();
Postulacion::createTable();
echo "🗃️ Tablas creadas\n";

// 2. Crear empresa
$empresaId = Empresa::create([
    'razon_social' => 'Soluciones Digitales C.A.',
    'sector' => 'Tecnología',
    'persona_contacto' => 'Carlos Ruiz',
    'RIF' => 'J-98765432-1'
]);
echo "🏢 Empresa creada con ID: $empresaId\n";

// 3. Crear usuario y asociarlo a UsuarioPostulante
$usuarioId = Usuario::create([
    'nombre_usuario' => 'postulante_test',
    'contraseña' => 'clave123',
    'correo' => 'postulante@test.com',
    'tipo_usuario' => 'postulante'
]);
echo "👤 Usuario creado con ID: $usuarioId\n";

UsuarioPostulante::add([
    'usuario_id' => $usuarioId,
    'nombre' => 'Ana',
    'apellido' => 'Gómez',
    'cedula' => 'V12345678',
    'estado_residencia' => 'Bolívar',
    'ciudad_residencia' => 'Ciudad Guayana',
    'contratado' => 0,
    'tipo_sangre' => 'O+',
    'fecha_nacimiento' => '1995-06-15',
    'genero' => 'femenino'
]);
echo "🧾 UsuarioPostulante creado\n";

// 4. Crear oferta laboral
$ofertaId = OfertaLaboral::add([
    'profesion' => 'Diseño Gráfico',
    'cargo' => 'Diseñador UI/UX',
    'descripcion' => 'Diseño de interfaces para aplicaciones móviles.',
    'salario' => 1000.00,
    'modalidad' => 'Presencial',
    'estado' => 'Bolívar',
    'ciudad' => 'Ciudad Guayana',
    'estatus' => 1,
    'empresa_id' => $empresaId
]);
echo "📄 Oferta creada con ID: $ofertaId\n";

// 5. Crear postulación
$postulacionId = Postulacion::add([
    'usuario_id' => $usuarioId,
    'oferta_id' => $ofertaId
]);
echo "✅ Postulación creada con ID: $postulacionId\n";

// 6. Obtener postulaciones por usuario
$postulacionesUsuario = Postulacion::getByUsuario($usuarioId);
echo "🔍 Postulaciones del usuario:\n";
print_r($postulacionesUsuario);

// 7. Obtener postulaciones por oferta
$postulacionesOferta = Postulacion::getByOferta($ofertaId);
echo "📋 Postulaciones a la oferta:\n";
print_r($postulacionesOferta);

// 8. Verificar si ya se postuló
$yaPostulado = Postulacion::checkIfApplied($usuarioId, $ofertaId);
echo $yaPostulado ? "🔒 El usuario ya está postulado\n" : "❌ El usuario no está postulado\n";

// 9. Eliminar postulación
Postulacion::delete($postulacionId);
echo "🗑 Postulación eliminada\n";

// 10. Eliminar oferta
OfertaLaboral::delete($ofertaId);
echo "🗑 Oferta eliminada\n";

// 11. Eliminar usuario y UsuarioPostulante
UsuarioPostulante::delete($usuarioId);
Usuario::delete($usuarioId);
echo "🗑 Usuario y UsuarioPostulante eliminados\n";

// 12. Eliminar empresa
Empresa::delete($empresaId);
echo "🗑 Empresa eliminada\n";

echo "=== Prueba completada ===\n";
?>