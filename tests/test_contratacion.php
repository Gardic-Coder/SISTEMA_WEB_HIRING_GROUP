<?php
require_once __DIR__ . '/../models/Empresa.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/UsuarioPostulante.php';
require_once __DIR__ . '/../models/OfertaLaboral.php';
require_once __DIR__ . '/../models/Postulacion.php';
require_once __DIR__ . '/../models/CuentaBancaria.php';
require_once __DIR__ . '/../models/Contratacion.php';
require_once __DIR__ . '/../models/Banco.php';

echo "=== Prueba de Contratacion ===\n";

// 1. Crear tablas
Banco::createTable();
Empresa::createTable();
Usuario::createTable();
UsuarioPostulante::createTable();
OfertaLaboral::createTable();
Postulacion::createTable();
CuentaBancaria::createTable();
Contratacion::createTable();
echo "🗃️ Tablas creadas\n";

// 2. Crear banco
$bancoId = Banco::create('Banco Central de Venezuela');
echo "🏦 Banco creado con ID: $bancoId\n";

// 3. Crear empresa
$empresaId = Empresa::create([
    'razon_social' => 'Innovación C.A.',
    'sector' => 'Tecnología',
    'persona_contacto' => 'Luis Pérez',
    'RIF' => 'J-11223344-5'
]);
echo "🏢 Empresa creada con ID: $empresaId\n";

// 4. Crear usuario y asociarlo como postulante
$usuarioId = Usuario::create([
    'nombre_usuario' => 'contratado_test',
    'contraseña' => 'clave123',
    'correo' => 'contratado@test.com',
    'tipo_usuario' => 'postulante'
]);
echo "👤 Usuario creado con ID: $usuarioId\n";

UsuarioPostulante::add([
    'usuario_id' => $usuarioId,
    'nombre' => 'Luis',
    'apellido' => 'Martínez',
    'cedula' => 'V-87.654.321',
    'estado_residencia' => 'Bolívar',
    'ciudad_residencia' => 'Ciudad Guayana',
    'contratado' => 0,
    'tipo_sangre' => 'A+',
    'fecha_nacimiento' => '1990-03-22',
    'genero' => 'masculino'
]);
echo "🧾 UsuarioPostulante creado\n";

// 5. Crear oferta laboral
$ofertaId = OfertaLaboral::add([
    'profesion' => 'Ingeniería de Sistemas',
    'cargo' => 'Analista de Datos',
    'descripcion' => 'Análisis y visualización de datos empresariales.',
    'salario' => 1800.00,
    'modalidad' => 'Híbrido',
    'estado' => 'Bolívar',
    'ciudad' => 'Ciudad Guayana',
    'estatus' => 1,
    'empresa_id' => $empresaId
]);
echo "📄 Oferta creada con ID: $ofertaId\n";

// 6. Crear postulación
$postulacionId = Postulacion::add([
    'usuario_id' => $usuarioId,
    'oferta_id' => $ofertaId
]);
echo "✅ Postulación creada con ID: $postulacionId\n";

// 7. Crear cuenta bancaria
$cuentaId = CuentaBancaria::create([
    'usuario_id' => $usuarioId,
    'banco_id' => $bancoId,
    'nro_cuenta' => '01234567890123456789',
    'tipo_cuenta' => 'ahorro'
]);
echo "🏦 Cuenta bancaria creada con ID: $cuentaId\n";

// 8. Crear contratación
$contratacionId = Contratacion::add([
    'usuario_id' => $usuarioId,
    'oferta_id' => $ofertaId,
    'cuenta_bancaria_id' => $cuentaId,
    'fecha_inicio' => date('Y-m-d'),
    'duracion' => '6 meses',
    'salario' => 1800.00
]);
echo "📑 Contratación creada con ID: $contratacionId\n";

// 9. Consultar por usuario
$contratacionesUsuario = Contratacion::getByUsuario($usuarioId);
echo "🔍 Contrataciones del usuario:\n";
print_r($contratacionesUsuario);

// 10. Consultar por empresa
$contratacionesEmpresa = Contratacion::getByEmpresa($empresaId);
echo "🏢 Contrataciones de la empresa:\n";
print_r($contratacionesEmpresa);

// 11. Actualizar contratación
/*$actualizado = Contratacion::update($contratacionId, ['duracion' => '12 meses', 'salario' => 2000.00]);
echo $actualizado ? "🔄 Contratación actualizada\n" : "❌ Error al actualizar contratación\n";

// 12. Obtener contratación actualizada
$contratacionActualizada = Contratacion::getById($contratacionId);
echo "📋 Contratación actualizada:\n";
print_r($contratacionActualizada);*/

//$contratacionId = 1; // Asumiendo que la contratación tiene ID 1
// 13. Eliminar contratación
//Contratacion::delete($contratacionId);
//echo "🗑 Contratación eliminada\n";

// 14. Eliminar cuenta bancaria
/*CuentaBancaria::delete($cuentaId);
echo "🗑 Cuenta bancaria eliminada\n";*/

//$postulacionId = 1; // Asumiendo que la postulación tiene ID 1
// 15. Eliminar postulación
//Postulacion::delete($postulacionId);
//echo "🗑 Postulación eliminada\n";

//$ofertaId = 1; // Asumiendo que la oferta tiene ID 1
// 16. Eliminar oferta
//OfertaLaboral::delete($ofertaId);
//echo "🗑 Oferta eliminada\n";

// 17. Eliminar usuario y UsuarioPostulante
/*UsuarioPostulante::delete($usuarioId);
Usuario::delete($usuarioId);
echo "🗑 Usuario y UsuarioPostulante eliminados\n";

// 18. Eliminar empresa
Empresa::delete($empresaId);
echo "🗑 Empresa eliminada\n";

// 19. Eliminar banco
Banco::delete($bancoId);
echo "🗑 Banco eliminado\n";*/

echo "=== Prueba completada ===\n";
?>