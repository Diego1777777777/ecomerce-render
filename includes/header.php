<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Subir al raíz si estamos en pages/
$configPath = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false)
    ? dirname(__DIR__) . '/config.php'
    : __DIR__ . '/../config.php';
require_once $configPath;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futbol Shop</title>
    <meta name="description" content="Futbol Shop - La mejor tienda de equipamiento deportivo. Botines, camisetas, balones y más.">
    <meta name="keywords" content="futbol, botines, camisetas, balones, tienda deportiva, equipamiento futbol">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://ecommerce-render.onrender.com">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>/favicon-16x16.png">
    <link rel="apple-touch-icon" href="<?= BASE_URL ?>/apple-touch-icon.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        const BASE_URL = "<?= BASE_URL ?>";
        const IMG_URL  = "<?= IMG_URL ?>";
    </script>
</head>
<body class="bg-white">

<header class="border-b border-gray-200 sticky top-0 bg-white z-50">
    <div class="container mx-auto px-4">
        <nav class="flex items-center justify-between py-4">

            <div class="flex items-center gap-3">
                <a href="<?= BASE_URL ?>/index.php" class="text-2xl font-bold text-black tracking-tight">
                    ⚽ FUTBOLSHOP
                </a>
            </div>

            <div class="hidden md:flex flex-1 max-w-xl mx-8">
                <div class="relative w-full">
                    <input type="text" id="searchInput"
                        placeholder="Buscar productos, marcas, categorías..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-black transition-colors">
                    <button class="absolute right-3 top-1/2 -translate-y-1/2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <?php if (!empty($_SESSION['user_logged_in'])): ?>
                    <span class="text-sm text-gray-600">Hola, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
                        <a href="<?= BASE_URL ?>/pages/admin.php" class="text-sm font-medium text-red-600 hover:text-red-800">Panel Admin</a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/pages/logout.php" class="text-sm font-medium text-black hover:text-red-600 transition-colors">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/pages/login.php"    class="text-sm font-medium text-black hover:text-red-600 transition-colors">Iniciar Sesión</a>
                    <a href="<?= BASE_URL ?>/pages/register.php" class="text-sm font-medium text-black hover:text-red-600 transition-colors">Registrarse</a>
                <?php endif; ?>

                <a href="<?= BASE_URL ?>/pages/carrito.php" class="relative">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span id="cartCount"
                          class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </a>
            </div>
        </nav>

        <div class="md:hidden pb-4">
            <input type="text" id="searchInputMobile" placeholder="Buscar productos..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-black">
        </div>
    </div>
</header>