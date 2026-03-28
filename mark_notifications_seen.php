<?php
require_once __DIR__ . '/helpers.php';

header('Content-Type: application/json');

session_start();

// Check admin authentication
if (!isset($_SESSION['admin_authenticated']) || !$_SESSION['admin_authenticated']) {
    send_error('Not authenticated', 401);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_error('Only POST allowed', 405);
    exit;
}

$input = parse_input();
$notification_ids = $input['notification_ids'] ?? [];

if (empty($notification_ids)) {
    send_error('notification_ids required', 422);
    exit;
}

$conn = get_db();
$admin_id = $_SESSION['admin_id'] ?? 0;

// Mark notifications as seen
$sql = 'INSERT IGNORE INTO notification_seen (admin_id, notification_id) VALUES ';
$values = [];
$params = [];
$types = '';

foreach ($notification_ids as $id) {
    $values[] = '(?, ?)';
    $params[] = $admin_id;
    $params[] = intval($id);
    $types .= 'ii';
}

if (!empty($values)) {
    $sql .= implode(', ', $values);
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $stmt->close();
    }
}

send_json(['success' => true, 'message' => 'Notifications marked as seen']);
