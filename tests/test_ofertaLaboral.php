<?php
require_once __DIR__ . '/../models/Empresa.php';
require_once __DIR__ . '/../models/OfertaLaboral.php';

echo "=== Prueba de OfertaLaboral con Empresa ===\n";

// 1. Crear tablas
Empresa::createTable();
OfertaLaboral::createTable();
echo "🗃️ Tablas creadas\n";

// 2. Crear empresa de prueba
$empresaId = Empresa::create([
    'razon_social' => 'Tech Solutions C.A.',
    'sector' => 'Tecnología',
    'persona_contacto' => 'Laura Méndez',
    'RIF' => 'J-12345678-9'
]);

if (!$empresaId) {
    die("❌ Error al crear empresa\n");
}
echo "🏢 Empresa creada con ID: $empresaId\n";

// 3. Crear oferta laboral
$ofertaData = [
    'profesion' => 'Ingeniería de Software',
    'cargo' => 'Desarrollador Backend',
    'descripcion' => 'Responsable del desarrollo de APIs y lógica de negocio.',
    'salario' => 1200.00,
    'modalidad' => 'Remoto',
    'estado' => 'Bolívar',
    'ciudad' => 'Ciudad Guayana',
    'estatus' => 1,
    'empresa_id' => $empresaId
];

$ofertaId = OfertaLaboral::add($ofertaData);
if ($ofertaId) {
    echo "✅ Oferta creada con ID: $ofertaId\n";
} else {
    die("❌ Error al crear oferta\n");
}

// 4. Obtener por ID
$oferta = OfertaLaboral::getById($ofertaId);
echo "🔍 Oferta obtenida por ID:\n";
print_r($oferta);

// 5. Obtener todas las ofertas de la empresa
$ofertasEmpresa = OfertaLaboral::getAll(['empresa_id' => $empresaId]);
echo "🏢 Ofertas de la empresa:\n";
print_r($ofertasEmpresa);

// 6. Actualizar oferta
$actualizado = OfertaLaboral::update($ofertaId, ['cargo' => 'Desarrollador Full Stack', 'salario' => 1500.00]);
echo $actualizado ? "🔄 Oferta actualizada\n" : "❌ Error al actualizar oferta\n";

// 7. Obtener oferta actualizada
$ofertaActualizada = OfertaLaboral::getById($ofertaId);
echo "📋 Oferta actualizada:\n";
print_r($ofertaActualizada);

// 8. Eliminar oferta
$eliminada = OfertaLaboral::delete($ofertaId);
echo $eliminada ? "🗑 Oferta eliminada\n" : "❌ Error al eliminar oferta\n";

// 9. Eliminar empresa
$empresaEliminada = Empresa::delete($empresaId);
echo $empresaEliminada ? "✅ Empresa eliminada\n" : "❌ Error al eliminar empresa\n";

echo "=== Prueba completada ===\n";
?>