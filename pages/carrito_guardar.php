<?php
require_once '../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json');

if (empty($_SESSION['user_logged_in'])) {
    echo json_encode(['ok' => false, 'msg' => 'no_session']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$accion = $data['accion'] ?? '';

if ($accion === 'agregar') {
    $userId     = $_SESSION['user_id'];
    $productoId = (int)($data['producto_id'] ?? 0);
    $cantidad   = (int)($data['cantidad'] ?? 1);
    $precio     = (int)($data['precio'] ?? 0);

    $db = getDB();

    // Buscar pedido pendiente del usuario
    $stmt = $db->prepare("SELECT id FROM pedidos WHERE usuario_id = ? AND estado = 'pendiente' LIMIT 1");
    $stmt->execute([$userId]);
    $pedido = $stmt->fetch();

    if (!$pedido) {
        // Crear nuevo pedido
        $stmt = $db->prepare("INSERT INTO pedidos (usuario_id, total, estado) VALUES (?, 0, 'pendiente')");
        $stmt->execute([$userId]);
        $pedidoId = $db->lastInsertId();
    } else {
        $pedidoId = $pedido['id'];
    }

    // Verificar si el producto ya está en el pedido
    $stmt = $db->prepare("SELECT id, cantidad FROM pedido_items WHERE pedido_id = ? AND producto_id = ?");
    $stmt->execute([$pedidoId, $productoId]);
    $item = $stmt->fetch();

    if ($item) {
        $stmt = $db->prepare("UPDATE pedido_items SET cantidad = cantidad + ? WHERE id = ?");
        $stmt->execute([$cantidad, $item['id']]);
    } else {
        $stmt = $db->prepare("INSERT INTO pedido_items (pedido_id, producto_id, cantidad, precio_unit) VALUES (?, ?, ?, ?)");
        $stmt->execute([$pedidoId, $productoId, $cantidad, $precio]);
    }

    // Actualizar total
    $stmt = $db->prepare("UPDATE pedidos SET total = (SELECT SUM(cantidad * precio_unit) FROM pedido_items WHERE pedido_id = ?) WHERE id = ?");
    $stmt->execute([$pedidoId, $pedidoId]);

    echo json_encode(['ok' => true]);

} else {
    echo json_encode(['ok' => false, 'msg' => 'accion_invalida']);
}