<?php
// pages/productos.php — Controlador del catálogo de productos
require_once '../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$pageTitle = 'Catálogo de Productos';
$todos     = getProductos();
$catFiltro = isset($_GET['categoria']) ? htmlspecialchars($_GET['categoria']) : '';
$busqueda  = isset($_GET['buscar'])    ? strtolower(trim(htmlspecialchars($_GET['buscar']))) : '';

$filtrados = array_filter($todos, function($p) use ($catFiltro, $busqueda) {
    $okCat = (!$catFiltro || $p['categoria'] === $catFiltro);
    $okBus = (!$busqueda  || strpos(strtolower($p['nombre']), $busqueda) !== false
                          || strpos($p['categoria'], $busqueda) !== false);
    return $okCat && $okBus;
});

require_once '../includes/header.php';
include '../views/productos.phtml';
require_once '../includes/footer.php';