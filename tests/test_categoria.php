<?php
require_once __DIR__ . '/../models/Empresa.php';
require_once __DIR__ . '/../models/OfertaLaboral.php';
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../models/CategoriaOfertaLaboral.php';

echo "=== Prueba de Categoría y OfertaLaboral ===\n";

// 1. Crear tablas
Empresa::createTable();
OfertaLaboral::createTable();
Categoria::createTable();
CategoriaOfertaLaboral::createTable();
echo "🗃️ Tablas creadas\n";

// 2. Crear empresa de prueba
$empresaId = Empresa::create([
    'razon_social' => 'Tech C.A.',
    'sector' => 'Tecnología',
    'persona_contacto' => 'María López',
    'RIF' => 'J-44556677-8'
]);
echo "🏢 Empresa creada con ID: $empresaId\n";

// 3. Crear oferta laboral
$ofertaId = OfertaLaboral::add([
    'profesion' => 'Desarrollo Web',
    'cargo' => 'Frontend Developer',
    'descripcion' => 'Desarrollo de interfaces modernas con React.',
    'salario' => 1500.00,
    'modalidad' => 'Remoto',
    'estado' => 'Bolívar',
    'ciudad' => 'Ciudad Guayana',
    'estatus' => 1,
    'empresa_id' => $empresaId
]);
echo "📄 Oferta creada con ID: $ofertaId\n";

// 4. Crear categorías
$categoriaIds = [];
foreach (['Tecnología', 'Desarrollo', 'Remoto'] as $nombre) {
    $id = Categoria::create($nombre);
    if ($id) {
        $categoriaIds[] = $id;
        echo "🏷️ Categoría '$nombre' creada con ID: $id\n";
    }
}

// 5. Relacionar oferta con categorías
foreach ($categoriaIds as $catId) {
    CategoriaOfertaLaboral::add($catId, $ofertaId);
}
echo "🔗 Categorías asociadas a la oferta\n";

// 6. Obtener categorías de la oferta
$categoriasDeOferta = CategoriaOfertaLaboral::getCategoriasByOferta($ofertaId);
echo "📋 Categorías de la oferta:\n";
print_r($categoriasDeOferta);

// 7. Obtener ofertas por categoría
foreach ($categoriaIds as $catId) {
    $ofertas = CategoriaOfertaLaboral::getOfertasByCategoria($catId);
    echo "🔍 Ofertas en la categoría ID $catId:\n";
    print_r($ofertas);
}

// 8. Eliminar relaciones
CategoriaOfertaLaboral::deleteByOferta($ofertaId);
echo "🧹 Relaciones eliminadas\n";

// 9. Eliminar oferta
OfertaLaboral::delete($ofertaId);
echo "🗑 Oferta eliminada\n";

// 10. Eliminar categorías
foreach ($categoriaIds as $catId) {
    Categoria::delete($catId);
    echo "🗑 Categoría ID $catId eliminada\n";
}

// 11. Eliminar empresa
Empresa::delete($empresaId);
echo "🗑 Empresa eliminada\n";

echo "=== Prueba completada ===\n";
?>