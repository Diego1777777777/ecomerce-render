<?php
// pages/producto.php — Detalle de un producto
require_once '../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$producto = getProductoPorId($id);

if (!$producto) {
    header('Location: productos.php');
    exit;
}

$pageTitle = htmlspecialchars($producto['nombre']);

require_once '../includes/header.php';
include '../views/producto.phtml';
require_once '../includes/footer.php';

