<?php
// pages/contacto.php — Controlador de contacto
require_once '../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$pageTitle      = 'Contacto';
$mensajeEnviado = false;
$error          = '';
$nombre = $email = $asunto = $mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre  = trim(htmlspecialchars($_POST['nombre']  ?? ''));
    $email   = trim(htmlspecialchars($_POST['email']   ?? ''));
    $asunto  = trim(htmlspecialchars($_POST['asunto']  ?? ''));
    $mensaje = trim(htmlspecialchars($_POST['mensaje'] ?? ''));

    if (empty($nombre) || empty($email) || empty($mensaje)) {
        $error = 'Por favor, completa todos los campos obligatorios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico no es válido.';
    } else {
        // En producción: enviar email con mail() o PHPMailer
        $mensajeEnviado = true;
    }
}

require_once '../includes/header.php';
include '../views/contacto.phtml';
require_once '../includes/footer.php';
