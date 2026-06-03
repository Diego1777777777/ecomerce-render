<?php
// pages/register.php — Controlador de registro (con DB)
require_once '../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$pageTitle = 'Registrarse';
$error     = '';
$success   = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim(htmlspecialchars($_POST['nombre']    ?? ''));
    $apellido  = trim(htmlspecialchars($_POST['apellido']  ?? ''));
    $email     = trim(htmlspecialchars($_POST['email']     ?? ''));
    $password  = $_POST['password']  ?? '';
    $confirmar = $_POST['confirmar'] ?? '';
    $terminos  = isset($_POST['terminos']);

    if (!$nombre || !$apellido || !$email || !$password) {
        $error = 'Por favor, completa todos los campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico no es válido.';
    } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password)
           || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $error = 'La contraseña debe tener mínimo 8 caracteres, una mayúscula, una minúscula y un número.';
    } elseif ($password !== $confirmar) {
        $error = 'Las contraseñas no coinciden.';
    } elseif (!$terminos) {
        $error = 'Debes aceptar los Términos y Condiciones.';
    } elseif (emailExiste($email)) {
        $error = 'Ya existe una cuenta con ese correo electrónico.';
    } else {
        if (crearUsuario($nombre, $apellido, $email, $password)) {
            $success = true;
        } else {
            $error = 'Error al crear la cuenta. Intenta de nuevo.';
        }
    }
}

require_once '../includes/header.php';
?>

<main class="min-h-screen flex items-center justify-center py-12 px-4 bg-gray-50">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-black mb-2">Crear Cuenta</h1>
                <p class="text-gray-600">Únete a la comunidad FutbolShop</p>
            </div>

            <?php if ($success): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-center">
                <p class="font-medium">¡Cuenta creada exitosamente!</p>
                <p class="text-sm mt-1">Redirigiendo al login... <a href="login.php" class="underline">Ir ahora</a></p>
            </div>
            <script>setTimeout(() => window.location.href = 'login.php', 2000);</script>
            <?php endif; ?>

            <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <p class="text-sm font-medium"><?= $error ?></p>
            </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">Nombre *</label>
                        <input type="text" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                               required placeholder="Juan"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-black transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">Apellido *</label>
                        <input type="text" name="apellido" value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>"
                               required placeholder="Pérez"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-black transition-colors">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Correo Electrónico *</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                           required placeholder="tu@email.com"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-black transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Contraseña *</label>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-black transition-colors">
                    <p class="mt-1 text-xs text-gray-500">Mínimo 8 caracteres, mayúscula, minúscula y número</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Confirmar Contraseña *</label>
                    <input type="password" name="confirmar" required placeholder="••••••••"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-black transition-colors">
                </div>
                <div class="flex items-start">
                    <input type="checkbox" id="terminos" name="terminos" class="w-4 h-4 mt-1 border-gray-300 rounded"
                           <?= isset($_POST['terminos']) ? 'checked' : '' ?>>
                    <label for="terminos" class="ml-2 text-sm text-gray-600">
                        Acepto los <a href="#" class="font-semibold text-black hover:text-red-600">Términos y Condiciones</a>
                    </label>
                </div>
                <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                    Crear Cuenta
                </button>
            </form>
            <div class="mt-6 text-center text-sm text-gray-600">
                ¿Ya tienes una cuenta?
                <a href="login.php" class="font-semibold text-black hover:text-red-600">Inicia sesión aquí</a>
            </div>
        </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
