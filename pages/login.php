<?php
// pages/login.php — Controlador de autenticación (con DB)
require_once '../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$pageTitle = 'Iniciar Sesión';

if (!empty($_SESSION['user_logged_in'])) {
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']    ?? '');
    $pass  =      $_POST['password'] ?? '';

    $user = getUserPorEmail($email);

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_id']        = $user['id'];
        $_SESSION['user_email']     = $user['email'];
        $_SESSION['user_name']      = $user['nombre'];
        $_SESSION['user_role']      = $user['rol'];
        header('Location: ' . BASE_URL . ($user['rol'] === 'admin' ? '/pages/admin.php' : '/index.php'));
        exit;
    }
    $error = 'Correo o contraseña incorrectos.';
}

require_once '../includes/header.php';
include '../views/login.phtml';
require_once '../includes/footer.php';
