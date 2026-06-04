<?php
// index.php — Controlador de la página de inicio
require_once 'config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$pageTitle = 'Futbol Shop | Tienda de Ropa y Artículos Deportivos';
$productos  = getProductos();
$destacados = array_slice($productos, 0, 8);

require_once 'includes/header.php';
include 'views/home.phtml';
require_once 'includes/footer.php';
