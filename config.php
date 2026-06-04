<?php
// =====================================================
// config.php — Configuración central del proyecto
// =====================================================

// ── Credenciales de base de datos ──────────────────
define('DB_HOST', 'sql5.freesqldatabase.com');
define('DB_NAME', 'sql5829215');
define('DB_USER', 'sql5829215');
define('DB_PASS', '12ag8pylah');
define('DB_PORT', '3306');

// ── Conexión PDO (singleton) ────────────────────────
function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT
                 . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            die('<h2 style="font-family:sans-serif;color:red;padding:2rem">
                ❌ Error de conexión a la base de datos:<br>
                <small>' . htmlspecialchars($e->getMessage()) . '</small><br><br>
                Verifica que MySQL esté corriendo y que las credenciales en config.php sean correctas.
                </h2>');
        }
    }
    return $pdo;
}

// ── URL base (auto-detectada) ───────────────────────
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
            || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
            ? 'https' : 'http';
$host       = $_SERVER['HTTP_HOST'] ?? 'localhost';
$docRoot    = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/');
$projectDir = dirname(__FILE__);
$subPath    = str_replace($docRoot, '', $projectDir);
$subPath    = str_replace('\\', '/', $subPath);

define('BASE_URL',  $protocol . '://' . $host . $subPath);
define('BASE_PATH', $projectDir);
define('IMG_URL',   BASE_URL  . '/assets/img/productos');
define('IMG_PATH',  BASE_PATH . '/assets/img/productos');

// ── Productos desde la base de datos ───────────────
function getProductos(): array {
    $stmt = getDB()->query('SELECT * FROM productos ORDER BY id ASC');
    return $stmt->fetchAll();
}

function getProductoPorId(int $id): ?array {
    $stmt = getDB()->prepare('SELECT * FROM productos WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function getProductosPorCategoria(string $categoria): array {
    $stmt = getDB()->prepare('SELECT * FROM productos WHERE categoria = ? ORDER BY id ASC');
    $stmt->execute([$categoria]);
    return $stmt->fetchAll();
}

// ── Usuarios ────────────────────────────────────────
function getUserPorEmail(string $email): ?array {
    $stmt = getDB()->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function crearUsuario(string $nombre, string $apellido, string $email, string $password): bool {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = getDB()->prepare(
        'INSERT INTO usuarios (nombre, apellido, email, password, rol) VALUES (?, ?, ?, ?, "user")'
    );
    return $stmt->execute([$nombre, $apellido, $email, $hash]);
}

function emailExiste(string $email): bool {
    $stmt = getDB()->prepare('SELECT COUNT(*) FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    return (int) $stmt->fetchColumn() > 0;
}

// ── Helpers ─────────────────────────────────────────
function imgUrl(string $filename): string {
    return IMG_URL . '/' . $filename;
}

function formatCOP(int $price): string {
    return '$' . number_format($price, 0, ',', '.') . ' COP';
}
